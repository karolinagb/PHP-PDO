<?php

use Alura\Pdo\Domain\Model\Student;

require_once 'vendor/autoload.php';

$databasePath = __DIR__ . '/banco.sqlite';
$pdo = new PDO('sqlite:' . $databasePath);

$sqlDelete = "DELETE FROM students WHERE id = ?;";
$prepareStatment = $pdo->prepare($sqlDelete);
$prepareStatment->bindValue(1, 1, PDO::PARAM_INT);

var_dump($prepareStatment->execute());

//É importante informar os tipos que vamos passar para o bindValue pois alguns bancos podem entender como string