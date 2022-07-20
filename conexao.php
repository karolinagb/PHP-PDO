<?php



//conexao com banco sqlite
// parametro 1 = string de conexao com driver do sqlite
//obs: a recomendacao seja do caminho absoluto
$caminhoBanco = __DIR__ . '/banco.sqlite';
$pdo = new PDO('sqlite:banco.sqlite');
//PDO = PHP Data Objects - objetos de dados em php
//interface leve e consistente para acessar um banco de  dados
//utiliza drivers específicos para cada bd
// se o banco sqlite nao existir, ele cria, se for um mysql, por exemplo, ele joga um erro na tela 

echo 'Conectei';

$pdo->exec("INSERT INTO phones (area_code, number, student_id) VALUES ('11', '123456789', 25), ('21', '456518799', 25);");
exit();

$createTableSql ='
    CREATE TABLE IF NOT EXISTS students (
        id INTERGER PRIMARY KEY,
        name TEXT,
        birth_date TEXT
    );

    CREATE TABLE IF NOT EXISTS phones (
        id INTERGER PRIMARY KEY,
        area_code TEXT,
        number TEXT,
        student_id INTERGER,
        FOREIGN KEY(student_id) REFERENCES students(id)
    );
';

//EXECUTAR código sql
$pdo->exec($createTableSql);