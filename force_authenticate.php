<?php

require_once "authenticate.php";

if (!$login) {
    header("Location: login.php");
    exit;
}
