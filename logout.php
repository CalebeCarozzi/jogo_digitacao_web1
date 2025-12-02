<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

session_unset();

session_destroy();

if (ini_get("session.use_cookies")) {
    $params = session_get_cookie_params();
    setcookie(
        session_name(),
        '', //valor do coockie
        time() - 42000,
        $params["path"],
        $params["domain"],
        $params["secure"],
        $params["httponly"]
    );
}

// [
//   "lifetime" => 0,
//   "path" => "/",
//   "domain" => "",
//   "secure" => false,
//   "httponly" => true
// ]
//nome seria -> PHPSESSID

header("Location: login.php");
exit;
