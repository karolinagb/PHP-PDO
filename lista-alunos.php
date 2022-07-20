<?php

use Alura\Pdo\Domain\Model\Student;
use Alura\Pdo\Infrastructure\Persistence\ConnectionCreator;
use Alura\Pdo\Infrastructure\Repository\PdoStudentRepository;

require_once 'vendor/autoload.php';

$pdo = ConnectionCreator::createConnection();

$repository = new PdoStudentRepository($pdo);

$studenteList = $repository->allStudents();

var_dump($studenteList);

// $databasePath = __DIR__ . '/banco.sqlite';
// $pdo = new PDO('sqlite:' . $databasePath);

// $statement = $pdo->query('SELECT * FROM students;');

// //fetchColumn = retorna 1 linha com os dados de 1 única coluna
// var_dump($statement->fetchColumn(1)); exit(); //percorre uma linha de cada vez

// //FETCH_ASSOC = TRAZ o indice do array com o nome da coluna
// //PDO::FETCH_CLASS, Student::class vai instanciar a classe student e preencher suas propriedades baseado no nome das colunas do bd
//     //O indicado é buscar como array associativo para não ter problema de divergência de nome de coluna com nome de propriedade
// $studentDataList = $statement->fetchAll(PDO::FETCH_ASSOC);
// $studentList = [];

// var_dump($studentList);

// foreach($studentDataList as $studentData){
//     $studentList[] = new Student($studentData['id'], $studentData['name'], new DateTimeImmutable($studentData['birthDate']));
// }

// //Pegando o primeiro aluno e exibindo o id
// echo $studentList[0]['id'] . PHP_EOL;

// //ou do primeiro aluno posso exibir a primeira coluna que é o id
// echo $studentList[0][0];

//O padrão do fetchAll é trazer os dados representados dessas 2 formas
//Só que podemos informar como ele deve trazer essa informação

// O método fetch retorna uma única linha, diferentemente do método fetchAll, que retorna todas as linhas do SELECT. Vimos no último vídeo um outro cenário, onde utilizar fetch, ao invés de utilizar o fetchAll, pode ser vantajoso.

// Em que caso pode ser interessante utilizar fetch ao invés do fetchAll?

// Alternativa correta! Se tivermos muitas linhas sendo trazidas e tentarmos executar o fetchAll, iremos colocar todas as linhas em memória de uma vez só. Isso pode trazer problemas. Utilizando o fetch dentro de um while, pode nos permitir buscar todos os resultados, mas colocando um de cada vez na memória.