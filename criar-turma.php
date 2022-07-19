<?php

use Alura\Pdo\Domain\Model\Student;
use Alura\Pdo\Infrastructure\Persistence\ConnectionCreator;
use Alura\Pdo\Infrastructure\Repository\PdoStudentRepository;

require_once 'vendor/autoload.php';

$connection = ConnectionCreator::createConnection();
$studentRepository = new PdoStudentRepository($connection);

//Queremos inserir vários alunos ao mesmo tempo, mas se um não for inserido, então nenhum outro pode ser, pra isso podemos usar transações
//beginTransaction() - inicia uma transação no bd
    //Quando eu executar uma query ele nao vai fazer isso efetivo no banco, vai aguardar até que eu acabe essa transação
$connection->beginTransaction();

$aStudent = new Student(
    null,
    "Teste1",
    new DateTimeImmutable("1985-10-12")
);

$studentRepository->save($aStudent);

$anotherStudent = new Student(
    null,
    "Teste2",
    new DateTimeImmutable("1985-10-12")
);

$studentRepository->save($anotherStudent);

//Comita as alterações para efetivar no banco
// $connection->commit();
$connection->rollBack(); //cancela uma transação

foreach ($studentRepository->allStudents() as $student) {
    var_dump($student);
}
