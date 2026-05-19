console.log('Arquivo ajax.js carregado com sucesso.');

document.addEventListener('DOMContentLoaded', function () {
   aplicarMascaras();

   if (document.getElementById('listaFornecedores')) {
       carregarFornecedores();
   }

   if (document.getElementById('listaProdutos')) {
       carregarProdutos();
   }

   if (document.getElementById('resumoCestaAjax')) {
       carregarResumoCesta();
   }
});

function aplicarMascaras() {
   const camposCnpj = document.querySelectorAll('.mascara-cnpj');
   const camposTelefone = document.querySelectorAll('.mascara-telefone');

   camposCnpj.forEach(function (campo) {
       campo.addEventListener('input', function () {
           let valor = campo.value.replace(/\D/g, '');

           valor = valor.substring(0, 14);

           valor = valor.replace(/^(\d{2})(\d)/, '$1.$2');
           valor = valor.replace(/^(\d{2})\.(\d{3})(\d)/, '$1.$2.$3');
           valor = valor.replace(/\.(\d{3})(\d)/, '.$1/$2');
           valor = valor.replace(/(\d{4})(\d)/, '$1-$2');

           campo.value = valor;
       });
   });

   camposTelefone.forEach(function (campo) {
       campo.addEventListener('input', function () {
           let valor = campo.value.replace(/\D/g, '');

           valor = valor.substring(0, 11);

           if (valor.length <= 10) {
               valor = valor.replace(/^(\d{2})(\d)/, '($1) $2');
               valor = valor.replace(/(\d{4})(\d)/, '$1-$2');
           } else {
               valor = valor.replace(/^(\d{2})(\d)/, '($1) $2');
               valor = valor.replace(/(\d{5})(\d)/, '$1-$2');
           }

           campo.value = valor;
       });
   });
}

function mostrarMensagemAjax(tipo, mensagem) {
   const divMensagem = document.getElementById('mensagemAjax');

   if (!divMensagem) {
       return;
   }

   divMensagem.innerHTML = `
       <div class="alert alert-${tipo}">
           ${mensagem}
       </div>
   `;

   setTimeout(function () {
       divMensagem.innerHTML = '';
   }, 4000);
}

function carregarFornecedores() {
   const area = document.getElementById('listaFornecedores');

   if (!area) {
       return;
   }

   area.innerHTML = '<p class="text-muted">Carregando fornecedores...</p>';

   fetch('ajax/listar_fornecedores.php')
       .then(response => response.json())
       .then(data => {
           if (data.status !== 'sucesso') {
               area.innerHTML = '<div class="alert alert-danger">Erro ao carregar fornecedores.</div>';
               return;
           }

           if (data.dados.length === 0) {
               area.innerHTML = '<div class="alert alert-info">Nenhum fornecedor cadastrado.</div>';
               return;
           }

           let html = '';

           data.dados.forEach(fornecedor => {
               html += `
                   <div class="border rounded p-3 mb-3">
                       <input type="hidden" id="fornecedor-id-${fornecedor.id}" value="${fornecedor.id}">

                       <div class="mb-2">
                           <label class="form-label">Nome</label>
                           <input type="text" class="form-control" id="fornecedor-nome-${fornecedor.id}" value="${fornecedor.nome ?? ''}">
                       </div>

                       <div class="mb-2">
                           <label class="form-label">CNPJ</label>
                           <input type="text" class="form-control" id="fornecedor-cnpj-${fornecedor.id}" value="${fornecedor.cnpj ?? ''}">
                       </div>

                       <div class="mb-2">
                           <label class="form-label">Telefone</label>
                           <input type="text" class="form-control" id="fornecedor-telefone-${fornecedor.id}" value="${fornecedor.telefone ?? ''}">
                       </div>

                       <div class="mb-2">
                           <label class="form-label">E-mail</label>
                           <input type="email" class="form-control" id="fornecedor-email-${fornecedor.id}" value="${fornecedor.email ?? ''}">
                       </div>

                       <div class="mb-2">
                           <label class="form-label">Endereço</label>
                           <input type="text" class="form-control" id="fornecedor-endereco-${fornecedor.id}" value="${fornecedor.endereco ?? ''}">
                       </div>

                       <button class="btn btn-primary btn-sm" onclick="atualizarFornecedor(${fornecedor.id})">
                           Salvar via AJAX
                       </button>
                   </div>
               `;
           });

           area.innerHTML = html;
       })
       .catch(() => {
           area.innerHTML = '<div class="alert alert-danger">Erro na requisição AJAX.</div>';
       });
}

function atualizarFornecedor(id) {
   const formData = new FormData();

   formData.append('id', id);
   formData.append('nome', document.getElementById(`fornecedor-nome-${id}`).value);
   formData.append('cnpj', document.getElementById(`fornecedor-cnpj-${id}`).value);
   formData.append('telefone', document.getElementById(`fornecedor-telefone-${id}`).value);
   formData.append('email', document.getElementById(`fornecedor-email-${id}`).value);
   formData.append('endereco', document.getElementById(`fornecedor-endereco-${id}`).value);

   fetch('ajax/atualizar_fornecedor.php', {
       method: 'POST',
       body: formData
   })
       .then(response => response.json())
       .then(data => {
           if (data.status === 'sucesso') {
               mostrarMensagemAjax('success', data.mensagem);
               carregarFornecedores();
           } else {
               mostrarMensagemAjax('danger', data.mensagem);
           }
       })
       .catch(() => {
           mostrarMensagemAjax('danger', 'Erro ao atualizar fornecedor.');
       });
}

function carregarProdutos() {
   const area = document.getElementById('listaProdutos');

   if (!area) {
       return;
   }

   area.innerHTML = '<p class="text-muted">Carregando produtos...</p>';

   fetch('ajax/listar_produtos.php')
       .then(response => response.json())
       .then(data => {
           if (data.status !== 'sucesso') {
               area.innerHTML = '<div class="alert alert-danger">Erro ao carregar produtos.</div>';
               return;
           }

           if (data.dados.length === 0) {
               area.innerHTML = '<div class="alert alert-info">Nenhum produto cadastrado.</div>';
               return;
           }

           let html = '';

           data.dados.forEach(produto => {
               html += `
                   <div class="border rounded p-3 mb-3">
                       <input type="hidden" id="produto-id-${produto.id}" value="${produto.id}">
                       <input type="hidden" id="produto-fornecedor-${produto.id}" value="${produto.fornecedor_id}">

                       <div class="mb-2">
                           <label class="form-label">Nome</label>
                           <input type="text" class="form-control" id="produto-nome-${produto.id}" value="${produto.nome ?? ''}">
                       </div>

                       <div class="mb-2">
                           <label class="form-label">Descrição</label>
                           <textarea class="form-control" id="produto-descricao-${produto.id}">${produto.descricao ?? ''}</textarea>
                       </div>

                       <div class="mb-2">
                           <label class="form-label">Preço</label>
                           <input type="text" class="form-control" id="produto-preco-${produto.id}" value="${produto.preco ?? ''}">
                       </div>

                       <p class="text-muted small mb-2">
                           Fornecedor atual: ${produto.fornecedor_nome}
                       </p>

                       <button class="btn btn-success btn-sm" onclick="atualizarProduto(${produto.id})">
                           Salvar via AJAX
                       </button>
                   </div>
               `;
           });

           area.innerHTML = html;
       })
       .catch(() => {
           area.innerHTML = '<div class="alert alert-danger">Erro na requisição AJAX.</div>';
       });
}

function atualizarProduto(id) {
   const formData = new FormData();

   formData.append('id', id);
   formData.append('nome', document.getElementById(`produto-nome-${id}`).value);
   formData.append('descricao', document.getElementById(`produto-descricao-${id}`).value);
   formData.append('preco', document.getElementById(`produto-preco-${id}`).value);
   formData.append('fornecedor_id', document.getElementById(`produto-fornecedor-${id}`).value);

   fetch('ajax/atualizar_produto.php', {
       method: 'POST',
       body: formData
   })
       .then(response => response.json())
       .then(data => {
           if (data.status === 'sucesso') {
               mostrarMensagemAjax('success', data.mensagem);
               carregarProdutos();
               carregarResumoCesta();
           } else {
               mostrarMensagemAjax('danger', data.mensagem);
           }
       })
       .catch(() => {
           mostrarMensagemAjax('danger', 'Erro ao atualizar produto.');
       });
}

function carregarResumoCesta() {
   const area = document.getElementById('resumoCestaAjax');

   if (!area) {
       return;
   }

   area.innerHTML = '<p class="text-muted">Carregando resumo da cesta...</p>';

   fetch('ajax/listar_resumo_cesta.php')
       .then(response => response.json())
       .then(data => {
           if (data.status !== 'sucesso') {
               area.innerHTML = '<div class="alert alert-danger">Erro ao carregar resumo.</div>';
               return;
           }

           const totalItens = data.dados.total_itens;
           const valorTotal = Number(data.dados.valor_total).toLocaleString('pt-BR', {
               style: 'currency',
               currency: 'BRL'
           });

           area.innerHTML = `
               <div class="row g-3">
                   <div class="col-md-6">
                       <div class="card bg-light">
                           <div class="card-body">
                               <p class="text-muted mb-0">Produtos na cesta</p>
                               <h3>${totalItens}</h3>
                           </div>
                       </div>
                   </div>

                   <div class="col-md-6">
                       <div class="card bg-light">
                           <div class="card-body">
                               <p class="text-muted mb-0">Valor total</p>
                               <h3>${valorTotal}</h3>
                           </div>
                       </div>
                   </div>
               </div>
           `;
       })
       .catch(() => {
           area.innerHTML = '<div class="alert alert-danger">Erro na requisição AJAX.</div>';
       });
}
