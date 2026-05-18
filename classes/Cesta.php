<?php

require_once __DIR__ . '/Database.php';

class Cesta
{
   private $conn;

   public function __construct()
   {
       $this->conn = Database::conectar();
   }

   public function buscarCestaAberta($usuarioId)
   {
       $sql = "
           SELECT *
           FROM cestas
           WHERE usuario_id = ?
           AND status = 'aberta'
           ORDER BY id DESC
           LIMIT 1
       ";

       $stmt = $this->conn->prepare($sql);
       $stmt->execute([$usuarioId]);

       return $stmt->fetch();
   }

   public function criarCesta($usuarioId)
   {
       $sql = "
           INSERT INTO cestas (usuario_id, status)
           VALUES (?, 'aberta')
       ";

       $stmt = $this->conn->prepare($sql);
       $stmt->execute([$usuarioId]);

       return $this->conn->lastInsertId();
   }

   public function obterOuCriarCestaAberta($usuarioId)
   {
       $cesta = $this->buscarCestaAberta($usuarioId);

       if ($cesta) {
           return $cesta['id'];
       }

       return $this->criarCesta($usuarioId);
   }

   public function buscarProduto($produtoId)
   {
       $sql = "
           SELECT id, nome, preco
           FROM produtos
           WHERE id = ?
       ";

       $stmt = $this->conn->prepare($sql);
       $stmt->execute([$produtoId]);

       return $stmt->fetch();
   }

   public function produtoJaNaCesta($cestaId, $produtoId)
   {
       $sql = "
           SELECT id
           FROM cesta_itens
           WHERE cesta_id = ?
           AND produto_id = ?
       ";

       $stmt = $this->conn->prepare($sql);
       $stmt->execute([$cestaId, $produtoId]);

       return $stmt->fetch() ? true : false;
   }

   public function adicionarProduto($usuarioId, $produtoId)
   {
       $cestaId = $this->obterOuCriarCestaAberta($usuarioId);

       $produto = $this->buscarProduto($produtoId);

       if (!$produto) {
           return 'produto_invalido';
       }

       if ($this->produtoJaNaCesta($cestaId, $produtoId)) {
           return 'duplicado';
       }

       $sql = "
           INSERT INTO cesta_itens (cesta_id, produto_id, preco_unitario)
           VALUES (?, ?, ?)
       ";

       $stmt = $this->conn->prepare($sql);

       $stmt->execute([
           $cestaId,
           $produto['id'],
           $produto['preco']
       ]);

       return 'adicionado';
   }

   public function adicionarProdutos($usuarioId, $produtosIds)
   {
       $resultado = [
           'adicionados' => 0,
           'duplicados' => 0,
           'invalidos' => 0
       ];

       foreach ($produtosIds as $produtoId) {
           $status = $this->adicionarProduto($usuarioId, $produtoId);

           if ($status === 'adicionado') {
               $resultado['adicionados']++;
           }

           if ($status === 'duplicado') {
               $resultado['duplicados']++;
           }

           if ($status === 'produto_invalido') {
               $resultado['invalidos']++;
           }
       }

       return $resultado;
   }

   public function produtoEstaNaCestaAberta($usuarioId, $produtoId)
   {
       $cesta = $this->buscarCestaAberta($usuarioId);

       if (!$cesta) {
           return false;
       }

       return $this->produtoJaNaCesta($cesta['id'], $produtoId);
   }

   public function obterResumo($usuarioId)
   {
       $sql = "
           SELECT
               COUNT(ci.id) AS total_itens,
               COALESCE(SUM(ci.preco_unitario), 0) AS valor_total
           FROM cestas c
           LEFT JOIN cesta_itens ci ON ci.cesta_id = c.id
           WHERE c.usuario_id = ?
           AND c.status = 'aberta'
       ";

       $stmt = $this->conn->prepare($sql);
       $stmt->execute([$usuarioId]);

       return $stmt->fetch();
   }
}
