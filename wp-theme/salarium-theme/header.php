<!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>
    <meta charset="<?php bloginfo('charset'); ?>" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <?php wp_head(); ?>
</head>
<body <?php body_class(); ?>>

	<header class="navbar">
		<div class="navbar_container">

			<a href="#" class="navbar_logo">
				<span class="navbar_logo_icon"><i class="fa-solid fa-comment-dollar navbar_logo_icon"></i></span>
				<span class="navbar_logo_text">Salarium
                    <span class="navbar_logo_tld">.fr</span>
                </span>
			</a>

			<nav class="navbar_menu" id="navbar_menu">
				<a href="#" class="navbar_menu_item">Outils</a>
				<a href="#" class="navbar_menu_item">Guides</a>
				<a href="#" class="navbar_menu_item">Tarifs</a>
				<a href="#" class="navbar_menu_item">À propos</a>
				<a href="#" class="navbar_menu_item navbar_contact">Contact</a>
			</nav>

			<button class="navbar_burger" id="navbar_burger" aria-label="Menu">
				<span></span>
				<span></span>
				<span></span>
			</button>
			
		</div>
	</header>