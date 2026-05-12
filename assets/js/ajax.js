console.log('Arquivo ajax.js carregado com sucesso.');

document.addEventListener('DOMContentLoaded', function () {
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
});