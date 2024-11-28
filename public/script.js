document.addEventListener("DOMContentLoaded", function () {
    window.scrollTo(0, 0); // Scroll vers le haut
});

document.addEventListener("DOMContentLoaded", function () {
    // Récupère le flash message via Symfony

    // const flashMessage = "{{ app.flashes('error')|join('<br>')|escape('js') }}";
    // Vérifie si un message d'erreur spécifique est présent
    if (flashMessage ) {
        const alert = document.getElementById("alert");
        const alertMessage = document.getElementById("alert-message");
        const alertClose = document.getElementById("alert-close");

        // Configure le message
        alertMessage.innerHTML = flashMessage;

        // Affiche l'alerte
        alert.classList.remove("hidden");

        // Fermer l'alerte lorsque l'utilisateur clique sur OK
        alertClose.addEventListener("click", function () {
            alert.classList.add("hidden");
        });
    }
    console.log("Flash Message:", flashMessage);

});
