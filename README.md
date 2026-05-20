# Mini Sistema de Gestão de Produtos

## Descrição do Projeto

O **Mini Sistema de Gestão de Produtos** é um projeto acadêmico desenvolvido com o objetivo de aplicar conceitos de **Programação Orientada a Objetos**, **relacionamento entre objetos**, **armazenamento em banco de dados**, **autenticação de usuários** e **requisições AJAX**.

O sistema permite que usuários autenticados cadastrem fornecedores, produtos e montem uma cesta de produtos. Além disso, possui uma área específica com AJAX, onde é possível cadastrar, listar, editar e excluir fornecedores e produtos sem recarregar a página.

O projeto foi desenvolvido utilizando **PHP puro**, **MySQL**, **PDO**, **HTML**, **CSS**, **Bootstrap**, **JavaScript** e **AJAX**, conforme solicitado no enunciado do trabalho.

---

## Integrantes

- Felipe Motta - RA: 60003354
- Francisco de Assis Branco Filho - RA: 60003949
- Gabriel Denke Machado - RA: 60003691
- Pedro Henrique dos Santos Souza - RA: 60300230

---

## Tecnologias Utilizadas

- PHP
- MySQL
- PDO
- HTML5
- CSS3
- Bootstrap 5
- JavaScript
- AJAX com Fetch API
- Git
- GitHub
- XAMPP
- Figma
- MySQL Workbench / Draw.io / ferramenta similar para DER

---

## Funcionalidades do Sistema

### Autenticação

- Cadastro de usuários.
- Login de usuários.
- Logout.
- Proteção de páginas internas.
- Senha armazenada com hash SHA-256.

### Fornecedores

- Cadastro de fornecedores.
- Listagem de fornecedores.
- Edição de fornecedores.
- Exclusão de fornecedores.
- Validação de campos.
- Máscara para CNPJ e telefone.
- Bloqueio de exclusão de fornecedores que possuem produtos vinculados.

### Produtos

- Cadastro de produtos.
- Listagem de produtos.
- Edição de produtos.
- Exclusão de produtos.
- Relacionamento entre produto e fornecedor.
- Validação de preço.
- Validação de fornecedor obrigatório.

### Cesta

- Listagem de produtos com checkbox.
- Seleção de produtos para adicionar à cesta.
- Criação automática da cesta do usuário.
- Bloqueio de produtos duplicados na mesma cesta.
- Visualização da cesta.
- Remoção de produto da cesta.
- Limpeza completa da cesta.
- Cálculo da quantidade total de produtos.
- Cálculo do valor total da cesta.

### Painel AJAX

- Cadastro de fornecedores via AJAX.
- Listagem de fornecedores via AJAX.
- Edição de fornecedores via AJAX.
- Exclusão de fornecedores via AJAX.
- Cadastro de produtos via AJAX.
- Listagem de produtos via AJAX.
- Edição de produtos via AJAX.
- Exclusão de produtos via AJAX.
- Visualização do resumo da cesta via AJAX.
- Atualização dos dados sem recarregar a página.

---

## Estrutura de Pastas

```text
mini-sistema-produtos/
│
├── ajax/
│   ├── listar_fornecedores.php
│   ├── listar_produtos.php
│   ├── listar_resumo_cesta.php
│   ├── criar_fornecedor.php
│   ├── criar_produto.php
│   ├── atualizar_fornecedor.php
│   ├── atualizar_produto.php
│   ├── excluir_fornecedor.php
│   └── excluir_produto.php
│
├── assets/
│   ├── css/
│   │   └── style.css
│   └── js/
│       └── ajax.js
│
├── classes/
│   ├── Database.php
│   ├── Usuario.php
│   ├── Fornecedor.php
│   ├── Produto.php
│   └── Cesta.php
│
├── config/
│   └── config.php
│
├── database/
│   └── install.php
│
├── docs/
│   ├── der/
│   │   └── der-sistema.png
│   └── figma/
│       ├── login.png
│       ├── dashboard.png
│       ├── fornecedores.png
│       ├── produtos.png
│       ├── selecionar-produtos.png
│       ├── cesta.png
│       └── ajax.png
│
├── includes/
│   ├── auth.php
│   ├── header.php
│   ├── navbar.php
│   └── footer.php
│
├── login.php
├── cadastro_usuario.php
├── login_processa.php
├── logout.php
├── dashboard.php
│
├── fornecedores_listar.php
├── fornecedores_novo.php
├── fornecedores_salvar.php
├── fornecedores_editar.php
├── fornecedores_atualizar.php
├── fornecedores_excluir.php
│
├── produtos_listar.php
├── produtos_novo.php
├── produtos_salvar.php
├── produtos_editar.php
├── produtos_atualizar.php
├── produtos_excluir.php
│
├── cesta_produtos.php
├── cesta_adicionar.php
├── cesta_visualizar.php
├── cesta_remover.php
├── cesta_limpar.php
│
├── painel_ajax.php
├── README.md
└── .gitignore
```

---

## Banco de Dados

O sistema utiliza banco de dados **MySQL** com conexão via **PDO**.

O banco é criado automaticamente através do arquivo:

```text
database/install.php
```

Nome do banco:

```text
mini_sistema_produtos
```

---

## Tabelas do Banco

### Tabela `usuarios`

Responsável por armazenar os usuários do sistema.

Campos:

- `id`
- `nome`
- `email`
- `senha_hash`
- `created_at`

---

### Tabela `fornecedores`

Responsável por armazenar os fornecedores cadastrados.

Campos:

- `id`
- `nome`
- `cnpj`
- `telefone`
- `email`
- `endereco`
- `created_at`

---

### Tabela `produtos`

Responsável por armazenar os produtos cadastrados.

Campos:

- `id`
- `fornecedor_id`
- `nome`
- `descricao`
- `preco`
- `created_at`

---

### Tabela `cestas`

Responsável por armazenar as cestas dos usuários.

Campos:

- `id`
- `usuario_id`
- `status`
- `created_at`

---

### Tabela `cesta_itens`

Responsável por armazenar os produtos adicionados em uma cesta.

Campos:

- `id`
- `cesta_id`
- `produto_id`
- `preco_unitario`
- `created_at`

---

## Relacionamentos

O sistema possui os seguintes relacionamentos:

- Um usuário pode possuir várias cestas.
- Uma cesta pertence a um usuário.
- Um fornecedor pode possuir vários produtos.
- Um produto pertence a um fornecedor.
- Uma cesta pode possuir vários itens.
- Um item da cesta pertence a um produto.
- Um produto pode aparecer em vários itens de cesta.

---

## Como Executar o Projeto

### 1. Clonar o repositório

Clone o projeto dentro da pasta `htdocs` do XAMPP:

```bash
cd C:\xampp\htdocs
git clone URL-DO-REPOSITORIO
```

Depois acesse a pasta do projeto:

```bash
cd mini-sistema-produtos
```

---

### 2. Iniciar o XAMPP

Abra o **XAMPP Control Panel** e inicie:

```text
Apache
MySQL
```

Os dois serviços precisam ficar ativos.

---

### 3. Criar o banco de dados

Acesse no navegador:

```text
http://localhost/mini-sistema-produtos/database/install.php
```

Esse arquivo cria automaticamente:

- Banco de dados.
- Tabelas.
- Usuário administrador.
- Fornecedores de exemplo.
- Produtos de exemplo.

---

### 4. Acessar o sistema

Depois de executar o instalador, acesse:

```text
http://localhost/mini-sistema-produtos/login.php
```

---

## Usuário de Teste

```text
E-mail: admin@email.com
Senha: 123456
```

---

## Configuração do Banco

As configurações do banco estão no arquivo:

```text
config/config.php
```

Configuração padrão para XAMPP:

```php
define('DB_HOST', 'localhost');
define('DB_NAME', 'mini_sistema_produtos');
define('DB_USER', 'root');
define('DB_PASS', '');

define('BASE_URL', 'http://localhost/mini-sistema-produtos/');
```

Caso o MySQL utilize outra porta, como `3307`, alterar o `DB_HOST` para:

```php
define('DB_HOST', 'localhost:3307');
```

---

## Segurança

As senhas dos usuários são armazenadas com hash SHA-256.

Exemplo utilizado no PHP:

```php
hash('sha256', $senha);
```

Esse método foi utilizado para atender ao requisito acadêmico do trabalho.

---

## Orientação a Objetos

O projeto utiliza classes PHP para organizar as responsabilidades do sistema.

### Classe `Database`

Responsável pela conexão com o banco de dados utilizando PDO.

### Classe `Usuario`

Responsável por:

- Cadastrar usuário.
- Verificar se o e-mail já existe.
- Autenticar login.

### Classe `Fornecedor`

Responsável por:

- Listar fornecedores.
- Buscar fornecedor por ID.
- Cadastrar fornecedor.
- Atualizar fornecedor.
- Excluir fornecedor.
- Verificar se o fornecedor possui produtos vinculados.

### Classe `Produto`

Responsável por:

- Listar produtos.
- Buscar produto por ID.
- Cadastrar produto.
- Atualizar produto.
- Excluir produto.
- Verificar relacionamento com fornecedor.
- Verificar se o produto está vinculado à cesta.

### Classe `Cesta`

Responsável por:

- Buscar cesta aberta.
- Criar cesta.
- Adicionar produtos à cesta.
- Verificar produtos duplicados.
- Listar itens da cesta.
- Remover item da cesta.
- Limpar cesta.
- Calcular resumo da cesta.

---

## Explicação do AJAX

O sistema possui uma tela chamada **Painel AJAX**, localizada em:

```text
painel_ajax.php
```

Essa tela utiliza JavaScript com **Fetch API** para se comunicar com arquivos PHP na pasta `ajax`.

Os arquivos PHP retornam dados em formato JSON, permitindo que a tela seja atualizada sem recarregar a página inteira.

Arquivos utilizados pelo AJAX:

```text
ajax/listar_fornecedores.php
ajax/listar_produtos.php
ajax/listar_resumo_cesta.php
ajax/criar_fornecedor.php
ajax/criar_produto.php
ajax/atualizar_fornecedor.php
ajax/atualizar_produto.php
ajax/excluir_fornecedor.php
ajax/excluir_produto.php
```

Funcionalidades disponíveis no Painel AJAX:

- Cadastrar fornecedor.
- Listar fornecedores.
- Editar fornecedor.
- Excluir fornecedor.
- Cadastrar produto.
- Listar produtos.
- Editar produto.
- Excluir produto.
- Visualizar resumo da cesta.

---

## Validações Implementadas

O sistema possui validações como:

- Campos obrigatórios.
- E-mail válido.
- Senhas iguais no cadastro.
- CNPJ com 14 números.
- Telefone com 10 ou 11 números.
- Preço maior que zero.
- Fornecedor obrigatório ao cadastrar produto.
- Bloqueio de fornecedor com produtos vinculados.
- Bloqueio de produto vinculado à cesta.
- Validação para impedir cesta vazia.
- Bloqueio de produto duplicado na cesta.

---

## Fluxo Básico do Sistema

1. O usuário acessa a tela de login.
2. Caso ainda não tenha conta, realiza cadastro.
3. Após o login, acessa o dashboard.
4. Cadastra fornecedores.
5. Cadastra produtos vinculados a fornecedores.
6. Seleciona produtos através de checkbox.
7. Adiciona produtos à cesta.
8. Visualiza a cesta com quantidade e valor total.
9. Utiliza o Painel AJAX para manipular dados sem recarregar a página.

---

## Commits Realizados

Exemplos de commits utilizados no desenvolvimento:

```bash
git commit -m "chore: inicia estrutura do projeto"
git commit -m "feat: adiciona instalador do banco de dados"
git commit -m "feat: cria layout base com bootstrap"
git commit -m "feat: implementa cadastro e login de usuarios"
git commit -m "feat: melhora dashboard com resumo do sistema"
git commit -m "feat: implementa crud de fornecedores"
git commit -m "fix: adiciona validacao e mascara para cnpj e telefone"
git commit -m "feat: implementa crud de produtos"
git commit -m "feat: adiciona selecao de produtos para cesta"
git commit -m "feat: cria visualizacao e resumo da cesta"
git commit -m "feat: implementa painel ajax"
git commit -m "feat: adiciona cadastro via ajax no painel"
git commit -m "feat: adiciona exclusao via ajax"
git commit -m "docs: finaliza documentacao e entrega do projeto"
```

---

## Como Fazer Commits

Antes de começar a alterar o projeto:

```bash
git pull
```

Depois de alterar:

```bash
git status
git add .
git commit -m "mensagem do commit"
git push
```

---

## Observações Importantes

- O projeto deve ser executado com XAMPP.
- O banco de dados deve ser criado pelo arquivo `database/install.php`.
- As páginas do sistema ficam na raiz do projeto.
- A pasta `classes` deve conter apenas classes PHP.
- A pasta `ajax` deve conter apenas arquivos usados pelas requisições AJAX.
- O projeto não utiliza Laravel, React, Vue ou outros frameworks não permitidos no enunciado.
- O Bootstrap foi utilizado apenas para melhorar a interface visual.

---

## Status do Projeto

Projeto finalizado para entrega acadêmica.
