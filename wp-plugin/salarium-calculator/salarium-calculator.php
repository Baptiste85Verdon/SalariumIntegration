<?php
/**
 * Plugin Name: Salarium Calculator
 * Plugin URI: https://github.com/Baptiste85Verdon/SalariumIntegration/
 * Description: Calculateur de salaire brut / net pour l'intégration de la maquette Salarium
 * Version: 1.0.0
 * Author: Baptiste Verdon
 */

// Empêche l'accès direct au fichier
if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

// Chargement des scripts et styles
function salarium_calculator_enqueue_assets() {

    // Font Awesome
    wp_enqueue_style(
        'font-awesome',
        'https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css',
        array(),
        '6.5.0'
    );

    // CSS
    wp_enqueue_style(
        'salarium-calculator-style',
        plugin_dir_url( __FILE__ ) . 'assets/css/calculator.css',
        array(),
        '1.0.0'
    );

    // JS
    wp_enqueue_script(
        'salarium-calculator-script',
        plugin_dir_url( __FILE__ ) . 'assets/js/calculator.js',
        array(),
        '1.0.0',
        true
    );
}
add_action( 'wp_enqueue_scripts', 'salarium_calculator_enqueue_assets' );

// Shortcode pour afficher le calculateur
function salarium_calculator_shortcode() {
    ob_start();
    ?>
    
    <div class="calculator">
        <div class="calc_card">

            <!-- Colonne gauche formulaire -->
             <div class="calc_form">
                <!-- Toggles pour le statut et la période -->
                <div class="calc_controls">
                    <div class="calc_toggle_group" id="toggle_statut">
                        <button class="calc_toggle_btn calc_toggle_btn--active" data-value="non-cadre">Non-cadre</button>
                        <button class="calc_toggle_btn" data-value="cadre">Cadre</button>
                    </div>
                    <div class="calc_toggle_group" id="toggle_periode">
                        <button class="calc_toggle_btn calc_toggle_btn--active" data-value="mensuel">Mensuel</button>
                        <button class="calc_toggle_btn" data-value="annuel">Annuel</button>
                    </div>
                </div>

                <!-- Champ de saisie pour le salaire -->
                <div class="calc_field">
                    <div class="calc_field_header">
                        <label for="calc_brut" class="calc_label">Salaire brut</label>
                        <span class="calc_hint">avant cotisations salariales</span>
                    </div>
                    <div class="calc_input_wrapper">
                        <input 
                            type="number" 
                            id="calc_brut" 
                            class="calc_input" 
                            placeholder="0" 
                            min="0"
                            step="1"
                        />
                        <span class="calc_currency">€</span>
                    </div>
                    <p class="calc_error" id="error_brut"></p>
                </div>

                <!-- Séparateur -->
                <div class="calc_separator">
                    <div class="calc_separator_line"></div>
                    <span class="calc_separator_icon">
                        <i class="fa-solid fa-arrow-right-arrow-left"></i>
                    </span>
                    <div class="calc_separator_line"></div>
                </div>

                <!-- Champ de saisie pour le salaire net -->
                <div class="calc_field">
                    <div class="calc_field_header">
                        <label for="calc_net" class="calc_label">Salaire net</label>
                        <span class="calc_hint">avant impôt sur le revenu</span>
                    </div>
                    <div class="calc_input_wrapper">
                        <input 
                            type="number" 
                            id="calc_net" 
                            class="calc_input" 
                            placeholder="0" 
                            min="0"
                            step="1"
                        />
                        <span class="calc_currency">€</span>
                    </div>
                    <p class="calc_error" id="error_net"></p>
                </div>
            </div>

            <!-- Panneau d'affichage du résultat -->
            <div class="calc_results">
                <p class="calc_results_label">TAUX APPLIQUÉ</p>
                <p class="calc_results_rate">
                    <span class="calc_results_rate_number" id="calc_rate">22</span>
                    <span class="calc_results_percent">%</span>
                </p>
                <p class="calc_results_description" id="calc_description">
                    Statut non-cadre — environ 22 % de cotisations salariales déduites du brut.
                </p>
                <div class="calc_results_stats">
                    <div class="calc_results_stat">
                        <p class="calc_results_stat_label">Cotisations</p>
                        <p class="calc_results_stat_value" id="calc_cotisations">— <span class="calc_results_stat_currency">€</span></p>
                    </div>

                    <div class="calc_results_stat">
                        <p class="calc_results_stat_label">Sur 12 mois (net)</p>
                        <p class="calc_results_stat_value" id="calc_annuel">— <span class="calc_results_stat_currency">€</span></p>
                    </div>
                </div>
            </div>

        </div>

        <!-- Note information -->
        <p class="calc_note">
            <i class="fa-solid fa-circle-info calc_note_icon"></i>
            Estimation à titre indicatif, basée sur un taux moyen de cotisations salariales 
            (22 % non-cadre, 25 % cadre). Le montant réel dépend de votre convention 
            collective, primes, mutuelle et avantages.
        </p>

    </div>

    <?php
    return ob_get_clean();
}
add_shortcode('salary_calculator', 'salarium_calculator_shortcode');
