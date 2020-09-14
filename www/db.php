<?php
$dbh = new \PDO(
    'mysql:host=localhost;dbname=game;',
    'root',
    ''
);

$dbh->exec('SET NAMES UTF8');
