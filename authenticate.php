<?php

session_start();

$login = false;

if (isset($_SESSION["user_id"]) && isset($_SESSION["user_name"]) && isset($_SESSION["user_email"])) {
    $login = true;
}
