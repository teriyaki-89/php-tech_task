<?php
session_start();
$login = $_SESSION['login'];

?>
<html>
<head>


    <style>
        ul li {display: inline-block;}
    </style>


</head>
<body style="width:600px; margin:0 auto; ">
<?php
    if (isset($login)) {


?>
<div style="float:right;">
    <ul>
        <li>Hi, <?php echo ($_SESSION['login']); ?> </li>
        <li><a href="/users/logout">Logout</a></li>
        <li></li>
    </ul>
</div>
<div style="float:right; padding:30px;">
    <ul>
        <li><h2>Your Balance</h2></li>
        <li><h2><?php echo $_SESSION['balance']; ?></h2></li>
    </ul>
    <form action="/users/withdraw" method="post">
        <ul>
            <li><input type="text" name="amount" id ="amount" onkeyup="validate(this)" /> </li>
             <li><div id="check" style=" margin:5px 0; visibility:hidden;">should be positive numbers</div></li>
            <li><input type="submit" value="draw money"  id="submit" disabled="true"/></li>
        </ul>
    </form>

</div>



<?php
}

?>


<script type="text/javascript">
     function validate(e) {
        balance = <?php echo $_SESSION['balance'] ?>;

        if ( (isNaN(e.value)) || (e.value<0) ) {
            document.getElementById('check').setAttribute('style','display:initial; background: mediumpurple;');
            document.getElementById('submit').disabled= true;
        } else if ( e.value > balance )  {
            document.getElementById('check').setAttribute('style','display:initial; background: mediumpurple;');
            document.getElementById('check').innerHTML='Amount is bigger than balance';
            document.getElementById('submit').disabled= true;

        }  else {
            document.getElementById('check').setAttribute('style','visibility:hidden');
            document.getElementById('submit').disabled= false;
        }


     }
 </script>