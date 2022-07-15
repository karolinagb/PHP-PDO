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

//EXECUTAR código sql
$pdo->exec('CREATE TABLE students (id INTEGER PRIMARY KEY, name TEXT, birth_date TEXT);');