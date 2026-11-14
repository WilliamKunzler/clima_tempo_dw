const modal = document.getElementById("modal-assinatura");
const botaoAbrir = document.getElementById("abrir-modal");
const botoesFechar = document.querySelectorAll("[data-fechar-modal]");

function abrirModal() {
    modal.classList.add("aberto");
    document.documentElement.classList.add("sem-scroll");
}

function fecharModal() {
    modal.classList.remove("aberto");
    document.documentElement.classList.remove("sem-scroll");
}

botaoAbrir.addEventListener("click", abrirModal);

botoesFechar.forEach(function (botao) {
    botao.addEventListener("click", fecharModal);
});

document.addEventListener("keydown", function (evento) {
    if (evento.key === "Escape" && modal.classList.contains("aberto")) {
        fecharModal();
    }
});
