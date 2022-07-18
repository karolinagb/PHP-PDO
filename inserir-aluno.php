<?php

use Alura\Pdo\Domain\Model\Student;

require_once 'vendor/autoload.php';

$databasePath = __DIR__ . '/banco.sqlite';
$pdo = new PDO('sqlite:' . $databasePath);

$student = new Student(null, 'Karolina Bento', new DateTimeImmutable('1999-10-15'));

$sqlInsert = "INSERT INTO students (name, birth_date) VALUES (?, ?);";
$statement = $pdo->prepare($sqlInsert); //prepara o banco
$statement->bindValue(1, $student->name());
$statement->bindValue(1, $student->birthDate()->format('Y-m-d'));

if($statement->execute())
{
    echo "Aluno incluído";
}

//A instrução prepara faz com que o nome seja inserido como string e não tente executar uma consulta