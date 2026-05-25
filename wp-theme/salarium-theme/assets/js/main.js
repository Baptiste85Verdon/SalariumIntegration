// JS pour le menu burger en vue mobile

// On récupère les éléments du DOM
const burger = document.getElementById('navbar_burger');
const menu = document.getElementById('navbar_menu');

// On ajoute un événement au clic sur le bouton burger
burger.addEventListener('click', () => {
    // On bascule la classe 'is_open' sur le menu
    menu.classList.toggle('is_open');
    // On bascule la classe 'is_active' sur le burger pour l'animation
    burger.classList.toggle('is_active');
});
