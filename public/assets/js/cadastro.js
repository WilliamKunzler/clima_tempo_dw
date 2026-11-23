const formulario = document.getElementById("cadastro-form");
const resumo = document.getElementById("cadastro-resumo");

const campos = {
    nome: document.getElementById("nome"),
    email: document.getElementById("email"),
    senha: document.getElementById("senha"),
    confirmarSenha: document.getElementById("confirmar-senha")
};

const mensagens = {
    nome: document.getElementById("erro-nome"),
    email: document.getElementById("erro-email"),
    senha: document.getElementById("erro-senha"),
    confirmarSenha: document.getElementById("erro-confirmar-senha")
};

const formatoEmail = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;

function validar() {
    const nome = campos.nome.value.trim();
    const email = campos.email.value.trim();
    const senha = campos.senha.value;
    const confirmarSenha = campos.confirmarSenha.value;
    const erros = {};

    if (nome === "") {
        erros.nome = "Erro: Informe seu nome completo.";
    }

    if (email === "") {
        erros.email = "Erro: Informe seu e-mail.";
    } else if (!formatoEmail.test(email)) {
        erros.email = "Erro: Informe um e-mail válido.";
    }

    if (senha === "") {
        erros.senha = "Erro: Informe uma senha.";
    } else if (senha.length < 8) {
        erros.senha = "Erro: A senha precisa ter 8 caracteres ou mais.";
    }

    if (confirmarSenha === "") {
        erros.confirmarSenha = "Erro: Confirme sua senha.";
    } else if (confirmarSenha !== senha) {
        erros.confirmarSenha = "Erro: As senhas não coincidem.";
    }

    return erros;
}

function mostrarErro(nomeCampo, texto) {
    const campo = campos[nomeCampo];
    const mensagem = mensagens[nomeCampo];
    const temErro = Boolean(texto);

    campo.classList.toggle("campo-erro", temErro);
    campo.setAttribute("aria-invalid", temErro);
    mensagem.textContent = texto || "";
    mensagem.hidden = !temErro;
}

formulario.addEventListener("submit", function (evento) {
    const erros = validar();
    const camposComErro = Object.keys(campos).filter(function (nomeCampo) {
        return erros[nomeCampo];
    });

    Object.keys(campos).forEach(function (nomeCampo) {
        mostrarErro(nomeCampo, erros[nomeCampo]);
    });

    if (camposComErro.length > 0) {
        evento.preventDefault();
        resumo.hidden = false;
        campos[camposComErro[0]].focus();
        return;
    }

    resumo.hidden = true;
});

Object.keys(campos).forEach(function (nomeCampo) {
    campos[nomeCampo].addEventListener("input", function () {
        mostrarErro(nomeCampo, "");
    });
});