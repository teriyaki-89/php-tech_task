<?php

defined('Site_Name') or exit( 'access denied');

Class Users extends Controller {

    public function index() {
        session_start();
        //echo "users->index";
        if ( !isset($_SESSION['login'])) {
            $this->view->render('loginView');

        } else {
            $this->view->render('noView');
        }

    }


    public function login () {

        if (isset($_POST['login'])) { $login = $this->sanitize($_POST['login']);}
        if (isset($_POST['password'])) { $password = $this->sanitize($_POST['password']);}


        $db = DB::getInstance();
        $sql = 'select * from users where name = "' .$login.' " and password = sha1(sha1("'. $password .'")) limit 1 ';

        $req = $db->query($sql);
        //print_r($sql);
        $post = $req->fetch();
        $user_id = $post['id'];
        //print_r( $user_id );

        if (empty($post)) {
            echo 'no match </br>';
            echo '<a href="/">Login again</a>';
        } else {

            session_start( [ 'cookie_lifetime' => 86400]);
            $_SESSION['login'] = $login;
            $_SESSION['id'] = $user_id;

            $sql2 = 'select * from balance where user_id ='.$user_id.' limit 1';
            $req2 = $db->query($sql2);
            $bal_arr = $req2->fetch();
            $_SESSION['balance']= $bal_arr['balance'] ?: 'not available';
            header("Location: /users/cabinet");
        }

    }

    public function logout () {
        session_start();
        //session_write_close();
        session_unset();
        session_destroy();


        header("Location: /users/index");

    }

    public function cabinet () {
        session_start();

        $this->view->render('noView');
    }

    public function withdraw () {
        session_start();



        if (isset ( $_POST['amount']) ) {
            $amount = $this->sanitize($_POST['amount']);
             if (filter_var($amount,FILTER_VALIDATE_INT)) {
                 if ($amount > $_SESSION['balance']) {
                     echo 'the amount is more than on your card';
                 } else {
                     $db = DB::getInstance();
                     $db->beginTransaction();
                     try {
                         $sql=' Update balance set balance = (balance - ?) where  user_id = ? ;';
                         $stmt = $db->prepare($sql);
                         $stmt->execute (array($amount, $_SESSION['id'] ));

                         $sql2 ='insert into transactions (user_id, date, amount, new_balance)   values (?,?,?,?); ';
                         $stmt = $db->prepare($sql2);
                         $new_balance =  $_SESSION['balance']- $amount;
                         $stmt->execute(array($_SESSION['id'],date('Y-m-d H:i:s'), -$amount, $new_balance));

                         $db->commit();
                         //echo 'success';
                         $_SESSION['balance'] = $new_balance;
                         session_write_close();
                         header ('Location:/users/cabinet');
                         //echo $_SESSION['balance'];
                     }

                     catch (Exception $e)  {
                         echo $e->getMessage();
                         $db->rollback();
                     }




                 }

             } else {
                 echo 'value is not integer';
             }
        }



    }


}

?>
