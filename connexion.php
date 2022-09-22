<?php
try {
    $base = new PDO('mysql:host=localhost; dbname=bot_db', 'root', '');
} catch (exception $e) {
    die('Erreur' . $e->getMessage());
}

?>