<?php

require_once __DIR__ . '/../config/config.php';

class Database
{
    private static $conexao = null;

    public static function conectar()
    {
        if (self::$conexao === null) {
            try {
                $dsn = 'mysql:host=' . DB_HOST . ';dbname=' . DB_NAME . ';charset=utf8mb4';

                self::$conexao = new PDO($dsn, DB_USER, DB_PASS);

                self::$conexao->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
                self::$conexao->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);

            } catch (PDOException $e) {
                die('Erro ao conectar com o banco de dados: ' . $e->getMessage());
            }
        }

        return self::$conexao;
    }
}