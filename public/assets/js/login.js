const formulario = document.getElementById("login-form");
const campoEmail = document.getElementById("email");
const campoSenha = document.getElementById("senha");
const caixaErro = document.getElementById("login-erro");
const tituloErro = document.getElementById("login-erro-titulo");
const textoErro = document.getElementById("login-erro-texto");

function mostrarErro(titulo, texto) {
    tituloErro.textContent = titulo;
    textoErro.textContent = texto;
    caixaErro.hidden = false;
}

function marcarCampo(campo, vazio) {
    campo.classList.toggle("campo-erro", vazio);
    campo.setAttribute("aria-invalid", vazio);
}

formulario.addEventListener("submit", function (evento) {
    const emailVazio = campoEmail.value.trim() === "";
    const senhaVazia = campoSenha.value === "";

    marcarCampo(campoEmail, emailVazio);
    marcarCampo(campoSenha, senhaVazia);

    if (emailVazio || senhaVazia) {
        evento.preventDefault();
        mostrarErro("Preencha todos os campos", "Informe seu e-mail e sua senha para entrar.");

        if (emailVazio) {
            campoEmail.focus();
        } else {
            campoSenha.focus();
        }
        return;
    }

    caixaErro.hidden = true;
});

[campoEmail, campoSenha].forEach(function (campo) {
    campo.addEventListener("input", function () {
        marcarCampo(campo, false);
    });
});