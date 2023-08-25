<?php  
// session start 
    session_start();

    // destroy session
        session_destroy();
        $_SESSION=[];
        session_unset();


    // destroy cookie
        setcookie('name', '', time()-2);
        setcookie('us_di', '', time()-2);
        setcookie('su_n', '' , time()-2);

    // pindahkan user ke page login
        header('location:login.php');

?>