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

    if (document.getElementById('novo-produto-fornecedor')) {
        carregarFornecedoresSelectAjax();
    }
});

/* =========================
   FUNÇÕES AUXILIARES
========================= */

function escaparHtml(valor) {
    if (valor === null || valor === undefined) {
        return '';
    }

    return String(valor)
        .replaceAll('&', '&amp;')
        .replaceAll('<', '&lt;')
        .replaceAll('>', '&gt;')
        .replaceAll('"', '&quot;')
        .replaceAll("'", '&#039;');
}

function mostrarMensagemAjax(tipo, mensagem) {
    const divMensagem = document.getElementById('mensagemAjax');

    if (!divMensagem) {
        return;
    }

    divMensagem.innerHTML = `
        <div class="alert alert-${tipo}">
            ${escaparHtml(mensagem)}
        </div>
    `;

    setTimeout(function () {
        divMensagem.innerHTML = '';
    }, 4000);
}

async function buscarJson(url, opcoes = {}) {
    const resposta = await fetch(url, opcoes);
    const texto = await resposta.text();

    try {
        return JSON.parse(texto);
    } catch (erro) {
        console.error('Resposta não é JSON:', texto);
        throw new Error('Resposta inválida do servidor.');
    }
}

/* =========================
   MÁSCARAS
========================= */

function aplicarMascaras() {
    const camposCnpj = document.querySelectorAll('.mascara-cnpj');
    const camposTelefone = document.querySelectorAll('.mascara-telefone');

    camposCnpj.forEach(function (campo) {
        if (campo.dataset.mascaraAplicada === 'true') {
            return;
        }

        campo.dataset.mascaraAplicada = 'true';

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
        if (campo.dataset.mascaraAplicada === 'true') {
            return;
        }

        campo.dataset.mascaraAplicada = 'true';

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

/* =========================
   CRIAR FORNECEDOR VIA AJAX
========================= */

function criarFornecedorAjax() {
    const formData = new FormData();

    formData.append('nome', document.getElementById('novo-fornecedor-nome').value);
    formData.append('cnpj', document.getElementById('novo-fornecedor-cnpj').value);
    formData.append('telefone', document.getElementById('novo-fornecedor-telefone').value);
    formData.append('email', document.getElementById('novo-fornecedor-email').value);
    formData.append('endereco', document.getElementById('novo-fornecedor-endereco').value);

    buscarJson('ajax/criar_fornecedor.php', {
        method: 'POST',
        body: formData
    })
        .then(data => {
            if (data.status === 'sucesso') {
                mostrarMensagemAjax('success', data.mensagem);

                document.getElementById('novo-fornecedor-nome').value = '';
                document.getElementById('novo-fornecedor-cnpj').value = '';
                document.getElementById('novo-fornecedor-telefone').value = '';
                document.getElementById('novo-fornecedor-email').value = '';
                document.getElementById('novo-fornecedor-endereco').value = '';

                carregarFornecedores();
                carregarFornecedoresSelectAjax();
            } else {
                mostrarMensagemAjax('danger', data.mensagem);
            }
        })
        .catch(error => {
            console.error('Erro completo ao cadastrar fornecedor:', error);
            mostrarMensagemAjax('danger', 'Erro ao cadastrar fornecedor via AJAX.');
        });
}

/* =========================
   LISTAR FORNECEDORES VIA AJAX
========================= */

function carregarFornecedores() {
    const area = document.getElementById('listaFornecedores');

    if (!area) {
        return;
    }

    area.innerHTML = '<p class="text-muted">Carregando fornecedores...</p>';

    buscarJson('ajax/listar_fornecedores.php')
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
                            <input 
                                type="text" 
                                class="form-control" 
                                id="fornecedor-nome-${fornecedor.id}" 
                                value="${escaparHtml(fornecedor.nome)}"
                            >
                        </div>

                        <div class="mb-2">
                            <label class="form-label">CNPJ</label>
                            <input 
                                type="text" 
                                class="form-control mascara-cnpj" 
                                maxlength="18"
                                id="fornecedor-cnpj-${fornecedor.id}" 
                                value="${escaparHtml(fornecedor.cnpj)}"
                            >
                        </div>

                        <div class="mb-2">
                            <label class="form-label">Telefone</label>
                            <input 
                                type="text" 
                                class="form-control mascara-telefone" 
                                maxlength="15"
                                id="fornecedor-telefone-${fornecedor.id}" 
                                value="${escaparHtml(fornecedor.telefone)}"
                            >
                        </div>

                        <div class="mb-2">
                            <label class="form-label">E-mail</label>
                            <input 
                                type="email" 
                                class="form-control" 
                                id="fornecedor-email-${fornecedor.id}" 
                                value="${escaparHtml(fornecedor.email)}"
                            >
                        </div>

                        <div class="mb-2">
                            <label class="form-label">Endereço</label>
                            <input 
                                type="text" 
                                class="form-control" 
                                id="fornecedor-endereco-${fornecedor.id}" 
                                value="${escaparHtml(fornecedor.endereco)}"
                            >
                        </div>

                        <div class="d-flex gap-2">
                            <button type="button" class="btn btn-primary btn-sm" onclick="atualizarFornecedor(${fornecedor.id})">
                                <i class="bi bi-save"></i>
                                Salvar via AJAX
                            </button>

                            <button type="button" class="btn btn-danger btn-sm" onclick="excluirFornecedorAjax(${fornecedor.id})">
                                <i class="bi bi-trash"></i>
                                Excluir via AJAX
                            </button>
                        </div>
                    </div>
                `;
            });

            area.innerHTML = html;
            aplicarMascaras();
        })
        .catch(error => {
            console.error(error);
            area.innerHTML = '<div class="alert alert-danger">Erro na requisição AJAX de fornecedores.</div>';
        });
}

/* =========================
   ATUALIZAR FORNECEDOR VIA AJAX
========================= */

function atualizarFornecedor(id) {
    const formData = new FormData();

    formData.append('id', id);
    formData.append('nome', document.getElementById(`fornecedor-nome-${id}`).value);
    formData.append('cnpj', document.getElementById(`fornecedor-cnpj-${id}`).value);
    formData.append('telefone', document.getElementById(`fornecedor-telefone-${id}`).value);
    formData.append('email', document.getElementById(`fornecedor-email-${id}`).value);
    formData.append('endereco', document.getElementById(`fornecedor-endereco-${id}`).value);

    buscarJson('ajax/atualizar_fornecedor.php', {
        method: 'POST',
        body: formData
    })
        .then(data => {
            if (data.status === 'sucesso') {
                mostrarMensagemAjax('success', data.mensagem);

                carregarFornecedores();
                carregarFornecedoresSelectAjax();
                carregarProdutos();
            } else {
                mostrarMensagemAjax('danger', data.mensagem);
            }
        })
        .catch(error => {
            console.error(error);
            mostrarMensagemAjax('danger', 'Erro ao atualizar fornecedor.');
        });
}

/* =========================
   EXCLUIR FORNECEDOR VIA AJAX
========================= */

function excluirFornecedorAjax(id) {
    const confirmar = confirm('Tem certeza que deseja excluir este fornecedor via AJAX?');

    if (!confirmar) {
        return;
    }

    const formData = new FormData();
    formData.append('id', id);

    buscarJson('ajax/excluir_fornecedor.php', {
        method: 'POST',
        body: formData
    })
        .then(data => {
            if (data.status === 'sucesso') {
                mostrarMensagemAjax('success', data.mensagem);

                carregarFornecedores();
                carregarFornecedoresSelectAjax();
                carregarProdutos();
            } else {
                mostrarMensagemAjax('danger', data.mensagem);
            }
        })
        .catch(error => {
            console.error(error);
            mostrarMensagemAjax('danger', 'Erro ao excluir fornecedor via AJAX.');
        });
}

/* =========================
   CARREGAR SELECT DE FORNECEDORES
========================= */

function carregarFornecedoresSelectAjax() {
    const select = document.getElementById('novo-produto-fornecedor');

    if (!select) {
        return;
    }

    buscarJson('ajax/listar_fornecedores.php')
        .then(data => {
            if (data.status !== 'sucesso') {
                select.innerHTML = '<option value="">Erro ao carregar fornecedores</option>';
                return;
            }

            let options = '<option value="">Selecione um fornecedor</option>';

            data.dados.forEach(fornecedor => {
                options += `
                    <option value="${fornecedor.id}">
                        ${escaparHtml(fornecedor.nome)}
                    </option>
                `;
            });

            select.innerHTML = options;
        })
        .catch(error => {
            console.error(error);
            select.innerHTML = '<option value="">Erro ao carregar fornecedores</option>';
        });
}

/* =========================
   CRIAR PRODUTO VIA AJAX
========================= */

function criarProdutoAjax() {
    const formData = new FormData();

    formData.append('nome', document.getElementById('novo-produto-nome').value);
    formData.append('descricao', document.getElementById('novo-produto-descricao').value);
    formData.append('preco', document.getElementById('novo-produto-preco').value);
    formData.append('fornecedor_id', document.getElementById('novo-produto-fornecedor').value);

    buscarJson('ajax/criar_produto.php', {
        method: 'POST',
        body: formData
    })
        .then(data => {
            if (data.status === 'sucesso') {
                mostrarMensagemAjax('success', data.mensagem);

                document.getElementById('novo-produto-nome').value = '';
                document.getElementById('novo-produto-descricao').value = '';
                document.getElementById('novo-produto-preco').value = '';
                document.getElementById('novo-produto-fornecedor').value = '';

                carregarProdutos();
                carregarResumoCesta();
            } else {
                mostrarMensagemAjax('danger', data.mensagem);
            }
        })
        .catch(error => {
            console.error(error);
            mostrarMensagemAjax('danger', 'Erro ao cadastrar produto via AJAX.');
        });
}

/* =========================
   LISTAR PRODUTOS VIA AJAX
========================= */

function carregarProdutos() {
    const area = document.getElementById('listaProdutos');

    if (!area) {
        return;
    }

    area.innerHTML = '<p class="text-muted">Carregando produtos...</p>';

    buscarJson('ajax/listar_produtos.php')
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
                            <input 
                                type="text" 
                                class="form-control" 
                                id="produto-nome-${produto.id}" 
                                value="${escaparHtml(produto.nome)}"
                            >
                        </div>

                        <div class="mb-2">
                            <label class="form-label">Descrição</label>
                            <textarea 
                                class="form-control" 
                                id="produto-descricao-${produto.id}"
                            >${escaparHtml(produto.descricao)}</textarea>
                        </div>

                        <div class="mb-2">
                            <label class="form-label">Preço</label>
                            <input 
                                type="text" 
                                class="form-control" 
                                id="produto-preco-${produto.id}" 
                                value="${escaparHtml(produto.preco)}"
                            >
                        </div>

                        <p class="text-muted small mb-2">
                            Fornecedor atual: ${escaparHtml(produto.fornecedor_nome)}
                        </p>

                        <div class="d-flex gap-2">
                            <button type="button" class="btn btn-success btn-sm" onclick="atualizarProduto(${produto.id})">
                                <i class="bi bi-save"></i>
                                Salvar via AJAX
                            </button>

                            <button type="button" class="btn btn-danger btn-sm" onclick="excluirProdutoAjax(${produto.id})">
                                <i class="bi bi-trash"></i>
                                Excluir via AJAX
                            </button>
                        </div>
                    </div>
                `;
            });

            area.innerHTML = html;
        })
        .catch(error => {
            console.error(error);
            area.innerHTML = '<div class="alert alert-danger">Erro na requisição AJAX de produtos.</div>';
        });
}

/* =========================
   ATUALIZAR PRODUTO VIA AJAX
========================= */

function atualizarProduto(id) {
    const formData = new FormData();

    formData.append('id', id);
    formData.append('nome', document.getElementById(`produto-nome-${id}`).value);
    formData.append('descricao', document.getElementById(`produto-descricao-${id}`).value);
    formData.append('preco', document.getElementById(`produto-preco-${id}`).value);
    formData.append('fornecedor_id', document.getElementById(`produto-fornecedor-${id}`).value);

    buscarJson('ajax/atualizar_produto.php', {
        method: 'POST',
        body: formData
    })
        .then(data => {
            if (data.status === 'sucesso') {
                mostrarMensagemAjax('success', data.mensagem);

                carregarProdutos();
                carregarResumoCesta();
            } else {
                mostrarMensagemAjax('danger', data.mensagem);
            }
        })
        .catch(error => {
            console.error(error);
            mostrarMensagemAjax('danger', 'Erro ao atualizar produto.');
        });
}

/* =========================
   EXCLUIR PRODUTO VIA AJAX
========================= */

function excluirProdutoAjax(id) {
    const confirmar = confirm('Tem certeza que deseja excluir este produto via AJAX?');

    if (!confirmar) {
        return;
    }

    const formData = new FormData();
    formData.append('id', id);

    buscarJson('ajax/excluir_produto.php', {
        method: 'POST',
        body: formData
    })
        .then(data => {
            if (data.status === 'sucesso') {
                mostrarMensagemAjax('success', data.mensagem);

                carregarProdutos();
                carregarResumoCesta();
            } else {
                mostrarMensagemAjax('danger', data.mensagem);
            }
        })
        .catch(error => {
            console.error(error);
            mostrarMensagemAjax('danger', 'Erro ao excluir produto via AJAX.');
        });
}

/* =========================
   RESUMO DA CESTA VIA AJAX
========================= */

function carregarResumoCesta() {
    const area = document.getElementById('resumoCestaAjax');

    if (!area) {
        return;
    }

    area.innerHTML = '<p class="text-muted">Carregando resumo da cesta...</p>';

    buscarJson('ajax/listar_resumo_cesta.php')
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
        .catch(error => {
            console.error(error);
            area.innerHTML = '<div class="alert alert-danger">Erro na requisição AJAX do resumo da cesta.</div>';
        });
}