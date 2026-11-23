document.addEventListener("DOMContentLoaded", () => {
    lucide.createIcons();
});

const botaoMenu = document.querySelector(".menu-botao");
const menu = document.getElementById("menu");

function alternarMenu() {
    const aberto = menu.classList.toggle("aberto");
    botaoMenu.setAttribute("aria-expanded", aberto);
    botaoMenu.setAttribute("aria-label", aberto ? "Fechar menu" : "Abrir menu");
}

botaoMenu.addEventListener("click", alternarMenu);

document.addEventListener("keydown", function (evento) {
    if (evento.key === "Escape" && menu.classList.contains("aberto")) {
        alternarMenu();
        botaoMenu.focus();
    }
});
