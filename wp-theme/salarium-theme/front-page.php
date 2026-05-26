<?php
// Template de la page d'accueil de Salarium. 
get_header();
?>

<main class="main">

    <section class="hero">
        <div class="hero_container">
            
            <p class="hero_badge">
                <span class="hero_badge_dot">●</span>
                OUTIL · CALCULATEUR
            </p>

            <h1 class="hero_title">
                Convertissez votre
                <em class="hero_title_italic">salaire brut en net</em>, en un coup d'œil.
            </h1>

            <p class="hero_subtitle">
                Saisissez un montant dans l'un ou l'autre champ — la conversion se fait automatiquement, selon votre statut et la période choisie.
            </p>

        </div>
    </section>

    <section class="calculator">
        <div class="calculator_container">
            <?php echo do_shortcode('[salary_calculator]'); ?>
        </div>
    </section>

</main>

<?php
get_footer();
?>