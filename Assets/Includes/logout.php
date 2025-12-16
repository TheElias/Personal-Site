<?php

use Site\User;

echo var_dump(array_diff(scandir("./Classes"), array('.', '..')));
echo "<br /> " . realpath($_SERVER["DOCUMENT_ROOT"]);
require_once './Classes/User.php';

    session_start();
    echo 'http://' . $_SERVER['HTTP_HOST'] . "/manager";
    User::clearUserCookies();
    session_destroy();
    header('Location: http://eliasbroniecki.com/manager');
    exit;
?>