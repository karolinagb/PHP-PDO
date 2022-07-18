<?php

use Alura\Pdo\Domain\Model\Student;

require_once 'vendor/autoload.php';

$databasePath = __DIR__ . '/banco.sqlite';
$pdo = new PDO('sqlite:' . $databasePath);

$statement = $pdo->query('SELECT * FROM students;');

//FETCH_ASSOC = TRAZ o indice do array com o nome da coluna
//PDO::FETCH_CLASS, Student::class vai instanciar a classe student e preencher suas propriedades baseado no nome das colunas do bd
    //O indicado é buscar como array associativo para não ter problema de divergência de nome de coluna com nome de propriedade
$studentDataList = $statement->fetchAll(PDO::FETCH_ASSOC);
$studentList = [];


foreach($studentDataList as $studentData){
    $studentList[] = new Student($studentData['id'], $studentData['name'], new DateTimeImmutable($studentData['birth_date']));
}

var_dump($studentList);

//Pegando o primeiro aluno e exibindo o id
// echo $studentList[0]['id'] . PHP_EOL;

//ou do primeiro aluno posso exibir a primeira coluna que é o id
// echo $studentList[0][0];

//O padrão do fetchAll é trazer os dados representados dessas 2 formas
//Só que podemos informar como ele deve trazer essa informação