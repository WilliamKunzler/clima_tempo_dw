const campoBusca = document.querySelector(".busca-grande input");
const cards = document.querySelectorAll(".feed-grade .card");
const avisoVazio = document.getElementById("filtro-vazio");

// Filtra os cards do feed enquanto o usuário digita
function filtrarFeed() {
    const texto = campoBusca.value.trim().toLowerCase();
    let encontrados = 0;

    cards.forEach(function (card) {
        const cidade = card.querySelector(".card-clima-cidade");
        let mostrar = texto === "";

        if (cidade && cidade.textContent.toLowerCase().includes(texto)) {
            mostrar = true;
        }

        card.style.display = mostrar ? "" : "none";

        if (mostrar) {
            encontrados++;
        }
    });

    avisoVazio.hidden = encontrados > 0;
}

campoBusca.addEventListener("input", filtrarFeed);
