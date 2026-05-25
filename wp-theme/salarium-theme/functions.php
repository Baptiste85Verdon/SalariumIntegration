<?php
// Fonctions pour le thème custom de Salarium.


// Chargement des assets du thème
function salarium_enqueue_assets() {
    // CSS
    wp_enqueue_style('salarium-style',      // Identifiant du style
    get_template_directory_uri() . '/assets/css/style.css',         // Chemin du CSS
    array(),        // Dépendances (aucune)
    '1.0.0'         // Version
    );

    // Google Fonts
    wp_enqueue_style('salarium-google-fonts', 
    'https://fonts.googleapis.com/css2?family=Instrument+Serif:ital@0;1&family=Geist:wght@400;500;600&display=swap', 
    array(), 
    null);

    // JS
    wp_enqueue_script('salarium-script',     // Identifiant du script
    get_template_directory_uri() . '/assets/js/main.js',          // Chemin du JS
    array(),        // Dépendances (aucune)
    '1.0.0',        // Version
    true              // Charger dans le footer
    );
}
// Hook pour charger les assets
add_action('wp_enqueue_scripts', 'salarium_enqueue_assets');

// Configuration du thème
function salarium_theme_setup() {
    add_theme_support('title-tag'); // Support pour les titres dynamiques
    add_theme_support('post-thumbnails'); // Support pour les images à la une
}
// Hook pour configurer le thème
add_action('after_setup_theme', 'salarium_theme_setup');
