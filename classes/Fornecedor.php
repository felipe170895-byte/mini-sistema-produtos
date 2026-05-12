<?php

require_once __DIR__ . '/Database.php';

class Fornecedor
{
    private $conn;

    public function __construct()
    {
        $this->conn = Database::conectar();
    }

    public function listarTodos()
    {
        $sql = "SELECT * FROM fornecedores ORDER BY nome ASC";
        $stmt = $this->conn->query($sql);

        return $stmt->fetchAll();
    }

    public function buscarPorId($id)
    {
        $sql = "SELECT * FROM fornecedores WHERE id = ?";
        $stmt = $this->conn->prepare($sql);
        $stmt->execute([$id]);

        return $stmt->fetch();
    }

    public function cadastrar($nome, $cnpj, $telefone, $email, $endereco)
    {
        $sql = "
            INSERT INTO fornecedores (nome, cnpj, telefone, email, endereco)
            VALUES (?, ?, ?, ?, ?)
        ";

        $stmt = $this->conn->prepare($sql);

        return $stmt->execute([
            $nome,
            $cnpj,
            $telefone,
            $email,
            $endereco
        ]);
    }

    public function atualizar($id, $nome, $cnpj, $telefone, $email, $endereco)
    {
        $sql = "
            UPDATE fornecedores
            SET nome = ?, cnpj = ?, telefone = ?, email = ?, endereco = ?
            WHERE id = ?
        ";

        $stmt = $this->conn->prepare($sql);

        return $stmt->execute([
            $nome,
            $cnpj,
            $telefone,
            $email,
            $endereco,
            $id
        ]);
    }

    public function contarProdutos($id)
    {
        $sql = "SELECT COUNT(*) AS total FROM produtos WHERE fornecedor_id = ?";
        $stmt = $this->conn->prepare($sql);
        $stmt->execute([$id]);

        $resultado = $stmt->fetch();

        return $resultado['total'] ?? 0;
    }

    public function excluir($id)
    {
        if ($this->contarProdutos($id) > 0) {
            return false;
        }

        $sql = "DELETE FROM fornecedores WHERE id = ?";
        $stmt = $this->conn->prepare($sql);

        return $stmt->execute([$id]);
    }

    public function contarTotal()
    {
        $sql = "SELECT COUNT(*) AS total FROM fornecedores";
        $stmt = $this->conn->query($sql);
        $resultado = $stmt->fetch();

        return $resultado['total'] ?? 0;
    }
}