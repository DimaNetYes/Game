<?php
$dbh = new \PDO(
    'mysql:host=localhost;dbname=biba_game;',
    'biba_game',
    '1234'
);

$dbh->exec('SET NAMES UTF8');
