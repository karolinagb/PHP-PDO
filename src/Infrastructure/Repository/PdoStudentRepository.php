<?php

namespace Alura\Pdo\Infrastructure\Repository;

use PDO;
use PDOStatement;
use DateTimeImmutable;
use DateTimeInterface;
use Alura\Pdo\Domain\Model\Phone;
use Alura\Pdo\Domain\Model\Student;
use Alura\Pdo\Domain\Repository\StudentRepository;


//Enquanto DAOs vão ter métodos como get, create, update e delete, lembrando ações que realizamos em tabelas de um banco de dados, Repositories vão possuir métodos como all, findById, add, remove, tratando os dados como uma coleção.

//Eu opto sempre por utilizar Repositories para que eles continuem fazendo sentido caso eu esteja persistindo dados em algum lugar que não seja um banco de dados (API, arquivo, sistema externo, etc)

class PdoStudentRepository implements StudentRepository
{
    private PDO $connection;

    public function __construct(PDO $connection)
    {
        $this->connection = $connection;
    }

    public function allStudents(): array
    {
        $sqlQuery = 'SELECT * FROM students;';
        $statment = $this->connection->query($sqlQuery); //query já devolve um statment executado

        return $this->hydrateStudentList($statment);
    }

    public function studentWithPhones(): array
    {
        $sqlQuery = "SELECT students.id, 
                            students.name, 
                            students.birth_date,
                            phones.id AS phone_id,
                            phones.area_code,
                            phones.number
                    FROM students
                    JOIN phones ON students.id = phones.student_id";
        
        $statment = $this->connection->query($sqlQuery);
        $result = $statment->fetchAll();

        $studentList = [];

        foreach ($result as $row) {
            if(!array_key_exists($row['id'], $studentList))
            {
                $studentList[$row['id']] = new Student($row['id'], $row['name'], new DateTimeImmutable($row['birth_date']));
            }
            $phone = new Phone($row['phone_id'], $row['area_code'], $row['number']);
            $studentList[$row['id']]->addPhone($phone);
        }

        return $studentList;
    }

    public function studentsBirthAt(DateTimeInterface $birthDate): array
    {
        $sqlQuery = 'SELECT * FROM students WHERE birth_date = ?;';
        $statment = $this->connection->prepare($sqlQuery);
        $statment->bindValue(1, $birthDate->format('Y-m-d'));
        $statment->execute();

        return $this->hydrateStudentList($statment);
    }

    private function hydrateStudentList(PDOStatement $stament): array
    {
        $studentDataList = $stament->fetchAll(); //preciso executar o prepare statment antes de chamar o fetchAll()
        $studentList = [];

        //Trazendo dados do banco de dados para a camada do nosso negocio
        //Esse é o conceito do hydrate/Hidratar
        foreach ($studentDataList as $studentData) {
            $studentList[] = new Student($studentData['id'], $studentData['name'], new DateTimeImmutable($studentData['birth_date']));
        }

        // //Preenchendo os telefones do aluno
        // $this->fillPhonesOf($student);

        // //Adicionando estudante na lista
        // $studentList[] = $student;

        return $studentList;
    }

    // private function fillPhonesOf(Student $student): void
    // {
    //     $sqlQuery = 'SELECT id, area_code, number FROM phones WHERE student_id = ?';
    //     $statment = $this->connection->prepare($sqlQuery);
    //     $statment->bindValue(1, $student->id(), PDO::PARAM_INT);
    //     $statment->execute();

    //     $phoneDataList = $statment->fetchAll();
    //     var_dump($phoneDataList);
    //     foreach ($phoneDataList as $phoneData) {
    //         $phone = new Phone($phoneData['id'], $phoneData['area_code'], $phoneData['number']);
    //     }
    //     $student->addPhone($phone);
    // }

    private function insert(Student $student): bool
    {
        $insetQuery = 'INSERT INTO students (name, birth_date) VALUES (:name, :birth_date);';
        $statment = $this->connection->prepare($insetQuery);

        //Passando parâmetros sem usar o bindValue
        $success = $statment->execute([
            ':name' => $student->name(),
            ':birth_date' => $student->birthDate()->format('Y-m-d')
        ]);

        if($success){
            //lastInsertId = fornece o ultimo id que foi inserido no banco
            $student->defineId($this->connection->lastInsertId());
        }

        return $success;
    }

    private function update(Student $student): bool
    {
        $updateQuery = 'UPDATE students SET name = :name, birth_date = :birth_date WHERE id = :id;';
        $statment = $this->connection->prepare($updateQuery);
        return $statment->execute([
            ':name' => $student->name(),
            ':birth_date' => $student->birthDate(),
            ':id' => $student->id()
        ]);
    }

    public function save(Student $student): bool
    {
        if($student->id() === null){
            return $this->insert($student);
        }

        return $this->update($student);
    }

    public function remove(Student $student): bool
    {
        $stament = $this->connection->prepare('DELETE FROM students WHERE id = ?');
        $stament->bindValue(1, $student->id(), PDO::PARAM_INT);

        return $stament->execute();
    }
}
