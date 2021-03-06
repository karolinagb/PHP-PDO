<?php

namespace Alura\Pdo\Infrastructure\Persistence;

use PDO;

class ConnectionCreator{

    //Posso definir esse método como static para nao ter que fazer uma instancia da classe ja q ela so tem esse metodo
    //Padrao de metodo de criacao estatico = criando um metodo estatico que so devolve um objeto criado
    public static function createConnection(): PDO
    {
        
        $connection = new PDO('mysql:host=localhost;dbname=banco_alura', 'root', 'root');

        //Define como vão ser reportados os erros na classe de conexão
            //No nosso caso estamos reportando eles como exceções
        $connection->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        //Defini que o fetchAll por exemplo vai retornar sempre umm array associativo
        $connection->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);

        return $connection;
    }
}