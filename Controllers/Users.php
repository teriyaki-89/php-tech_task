<?php

defined('Site_Name') or exit( 'access denied');
use \System\View;
use \System\DB;
use \System\Controller;

Class Users extends Controller
{

    public function index() {
        parent::check_session();
        parent::check_auth(__FUNCTION__);
        $view = new View();
        $view->render('cabinetView');
    }

    public function auth() {
        parent::check_session();
        parent::check_auth(__FUNCTION__);
        $view = new View();
        $view->render('loginView');
    }

    public function logout() {
        if (isset($_SESSION)) {
            session_start();
            // Session ID must be regenerated when //  - User logged out
            session_regenerate_id();
            session_unset();
            session_destroy();
        }
        parent::check_auth(__FUNCTION__);
    }

    public function login() {
        parent::check_session();
        parent::check_auth(__FUNCTION__);
        $login = $this->sanitize($_POST['login']) ?: ' ' ;
        $password = $this->sanitize($_POST['password']) ?: ' ';
        $db = DB::getInstance();
        $sql = 'select * from users where name = "' .$login.' " and password = sha1(sha1("'. $password .'")) limit 1 ';
        $req = $db->query($sql);
        $post = $req->fetch();
        $user_id = $post['id'];
        if (empty($post)) {
            echo 'no match </br>';
            echo '<a href="/">Login again</a>';
        } else {
            session_start();
            // Session ID must be regenerated when //  - User logged in
            session_regenerate_id();
            $_SESSION['deleted_time'] = time();
            $_SESSION['login'] = $login;
            $_SESSION['u_id'] = $user_id;
            $sql2 = 'select * from balance where user_id ='.$user_id.' limit 1';
            $req2 = $db->query($sql2);
            $bal_arr = $req2->fetch();
            $_SESSION['balance']= $bal_arr['balance'] ?: 'not available';
            session_write_close();
            exit(header("Location: /users/cabinet"));
        }
    }

    public function cabinet() {
        parent::check_session();
        parent::check_auth(__FUNCTION__);
        $view = new View();
        $view->render('cabinetView');

    }

    public function withdraw() {
        parent::check_session();
        parent::check_auth(__FUNCTION__);
        if (isset ( $_POST['amount']) ) {
            $amount = $this->sanitize($_POST['amount']);
            if (filter_var($amount,FILTER_VALIDATE_FLOAT)) {
                $sql = 'select balance from balance where user_id = ?';
                $db = DB::getInstance();
                $stmt = $db->prepare($sql);
                $stmt->execute( [ $this->user['u_id'] ]);
                $res = $stmt->fetch();
                if ($amount > $res['balance']) {
                    echo 'the amount is more than on your card';
                } else {
                    $db->beginTransaction();
                    try {
                        $new_balance = $res['balance'] - $amount;
                        $sql=' Update balance set balance = ? where  user_id = ? ;';
                        $stmt2 = $db->prepare($sql);
                        $stmt2->execute ([$new_balance, $_SESSION['u_id']]);
                        $sql ='insert into transactions (user_id, date, amount, new_balance)   values (?,?,?,?); ';
                        $stmt3 = $db->prepare($sql);
                        $stmt3->execute([$_SESSION['u_id'],date('Y-m-d H:i:s'), -$amount, $new_balance]);
                        $db->commit();
                        session_start();
                        $_SESSION['balance'] = $new_balance;
                        session_write_close();
                        exit(header ('Location:/users/cabinet'));
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

    }
}