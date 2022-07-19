<?php

namespace Alura\Pdo\Infrastructure\Persistence;

use PDO;

class ConnectionCreator{

    //Posso definir esse método como static para nao ter que fazer uma instancia da classe ja q ela so tem esse metodo
    //Padrao de metodo de criacao estatico = criando um metodo estatico que so devolve um objeto criado
    public static function createConnection(): PDO
    {
        $databasePath = __DIR__ . '/../../../banco.sqlite';
        return new PDO('sqlite:' . $databasePath);
    }
}