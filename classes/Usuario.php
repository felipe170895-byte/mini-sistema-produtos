<?php

require_once __DIR__ . '/Database.php';

class Usuario
{
    private $conn;

    public function __construct()
    {
        $this->conn = Database::conectar();
    }

    public function emailExiste($email)
    {
        $sql = "SELECT id FROM usuarios WHERE email = ?";
        $stmt = $this->conn->prepare($sql);
        $stmt->execute([$email]);

        return $stmt->fetch() ? true : false;
    }

    public function cadastrar($nome, $email, $senha)
    {
        if ($this->emailExiste($email)) {
            return false;
        }

        $senhaHash = hash('sha256', $senha);

        $sql = "INSERT INTO usuarios (nome, email, senha_hash) VALUES (?, ?, ?)";
        $stmt = $this->conn->prepare($sql);

        return $stmt->execute([$nome, $email, $senhaHash]);
    }

    public function autenticar($email, $senha)
    {
        $senhaHash = hash('sha256', $senha);

        $sql = "SELECT * FROM usuarios WHERE email = ? AND senha_hash = ?";
        $stmt = $this->conn->prepare($sql);
        $stmt->execute([$email, $senhaHash]);

        return $stmt->fetch();
    }
}