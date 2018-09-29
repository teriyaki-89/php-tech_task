<?php
defined('Site_Name') or exit( 'access denied');
use \System\DB as DB;

Class Users extends \System\Controller
{
    public function __construct() {
        session_start();
    }
    public function index() {
        $view = new \System\View();
        if ( !isset($_SESSION['login'])) {
            $view->render('loginView');

        } else {
            $view->render('noView');
        }
        session_write_close();
    }
    public function login () {
        session_start();
        if  (isset($_SESSION['login'])) {
            header ('Location:/users/cabinet');
        } else {
            if (isset($_POST['login'])) { $login = $this->sanitize($_POST['login']);}
            if (isset($_POST['password'])) { $password = $this->sanitize($_POST['password']);}
            $db = DB::getInstance();
            $sql = 'select * from users where name = "' .$login.' " and password = sha1(sha1("'. $password .'")) limit 1 ';
            $req = $db->query($sql);
            $post = $req->fetch();
            $user_id = $post['id'];
            if (empty($post)) {
                echo 'no match </br>';
                echo '<a href="/">Login again</a>';
            } else {
                session_unset();
                session_destroy();
                //session_name('TestMVC user session');
                session_start( [ 'cookie_lifetime' => 86400]);
                $_SESSION['login'] = $login;
                $_SESSION['u_id'] = $user_id;
                $sql2 = 'select * from balance where user_id ='.$user_id.' limit 1';
                $req2 = $db->query($sql2);
                $bal_arr = $req2->fetch();
                $_SESSION['balance']= $bal_arr['balance'] ?: 'not available';
                header("Location: /users/cabinet");
            }
        }
        session_write_close();
    }
    public function logout () {
        session_unset();
        session_destroy();
        session_write_close();
        header("Location: /users/index");
    }
    public function cabinet () {
        //session_start();
        $view = new \System\View();
        $view->render('noView');
        session_write_close();
    }
    public function withdraw () {
        if (isset($_SESSION['login'])) {
            if (isset ( $_POST['amount']) ) {
                $amount = $this->sanitize($_POST['amount']);
                if (filter_var($amount,FILTER_VALIDATE_FLOAT)) {
                    $sql = 'select balance from balance where user_id = ?';
                    $db = DB::getInstance();
                    $stmt = $db->prepare($sql);
                    $stmt->execute( [$_SESSION['u_id'] ]);
                    $res = $stmt->fetch();
                    if ($amount > $res['balance']) {
                        echo 'the amount is more than on your card';
                    } else {
                        $db->beginTransaction();
                        try {
                            $new_balance = $res['balance'] - $amount;
                            $sql=' Update balance set balance = ? where  user_id = ? ;';
                            $stmt2 = $db->prepare($sql);
                            $stmt2->execute (array($new_balance, $_SESSION['u_id'] ));
                            $sql ='insert into transactions (user_id, date, amount, new_balance)   values (?,?,?,?); ';
                            $stmt3 = $db->prepare($sql);
                            $stmt3->execute(array($_SESSION['u_id'],date('Y-m-d H:i:s'), -$amount, $new_balance));
                            $db->commit();
                            $_SESSION['balance'] = $new_balance;
                            header ('Location:/users/cabinet');
                        } catch (Exception $e)  {
                            echo 'error while drawing money ' ;
                            $db->rollback();
                        }
                    }
                } else {
                    echo 'value is not numerical';
                }
            } else {
                echo 'amount is invalid<br>';
            }
        } else {
            header('Location:/users/login');
        }
        session_write_close();
    }
}

