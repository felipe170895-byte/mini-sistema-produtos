<?php

require_once __DIR__ . '/Database.php';

class Produto
{
    private $conn;

    public function __construct()
    {
        $this->conn = Database::conectar();
    }

    public function listarTodos()
    {
        $sql = "
            SELECT 
                p.*,
                f.nome AS fornecedor_nome
            FROM produtos p
            INNER JOIN fornecedores f ON f.id = p.fornecedor_id
            ORDER BY p.nome ASC
        ";

        $stmt = $this->conn->query($sql);

        return $stmt->fetchAll();
    }

    public function buscarPorId($id)
    {
        $sql = "
            SELECT 
                p.*,
                f.nome AS fornecedor_nome
            FROM produtos p
            INNER JOIN fornecedores f ON f.id = p.fornecedor_id
            WHERE p.id = ?
        ";

        $stmt = $this->conn->prepare($sql);
        $stmt->execute([$id]);

        return $stmt->fetch();
    }

    public function cadastrar($fornecedorId, $nome, $descricao, $preco)
    {
        $sql = "
            INSERT INTO produtos (fornecedor_id, nome, descricao, preco)
            VALUES (?, ?, ?, ?)
        ";

        $stmt = $this->conn->prepare($sql);

        return $stmt->execute([
            $fornecedorId,
            $nome,
            $descricao,
            $preco
        ]);
    }

    public function atualizar($id, $fornecedorId, $nome, $descricao, $preco)
    {
        $sql = "
            UPDATE produtos
            SET fornecedor_id = ?, nome = ?, descricao = ?, preco = ?
            WHERE id = ?
        ";

        $stmt = $this->conn->prepare($sql);

        return $stmt->execute([
            $fornecedorId,
            $nome,
            $descricao,
            $preco,
            $id
        ]);
    }

    public function excluir($id)
    {
        $sql = "DELETE FROM produtos WHERE id = ?";
        $stmt = $this->conn->prepare($sql);

        return $stmt->execute([$id]);
    }

    public function contarItensCesta($id)
    {
        $sql = "SELECT COUNT(*) AS total FROM cesta_itens WHERE produto_id = ?";
        $stmt = $this->conn->prepare($sql);
        $stmt->execute([$id]);

        $resultado = $stmt->fetch();

        return $resultado['total'] ?? 0;
    }

    public function fornecedorExiste($fornecedorId)
    {
        $sql = "SELECT id FROM fornecedores WHERE id = ?";
        $stmt = $this->conn->prepare($sql);
        $stmt->execute([$fornecedorId]);

        return $stmt->fetch() ? true : false;
    }

    public function contarTotal()
    {
        $sql = "SELECT COUNT(*) AS total FROM produtos";
        $stmt = $this->conn->query($sql);
        $resultado = $stmt->fetch();

        return $resultado['total'] ?? 0;
    }
}