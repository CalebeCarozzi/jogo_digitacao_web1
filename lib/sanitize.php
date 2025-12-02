<?php

function sanitize(string $texto): string {
    $texto = trim($texto);
    $texto = stripslashes($texto); 
    $texto = htmlspecialchars($texto);
    return $texto;
}

?>
