# Salarium — Calculateur brut / net

Intégration d'une landing page avec calculateur de salaire brut / net, développée en HTML/CSS/JS puis intégrée dans WordPress via un thème custom et un plugin.

---

## Prérequis

- PHP 8.x
- WordPress 7.0+
- [LocalWP](https://localwp.com) (ou tout autre environnement local : WAMP, XAMPP, MAMP pour la partie 1)
- Un navigateur moderne (Chrome, Firefox, Safari, Edge)

---

## Stack technique

| Technologie | Usage |
|---|---|
| HTML5 / CSS3 / JS ES6+ | Intégration standalone |
| PHP 8.x | Thème et plugin WordPress |
| WordPress 7.0 | CMS |
| Google Fonts | Typographies (Instrument Serif, Geist conformément à la maquette) |
| Font Awesome 6.5 | Icônes |

---

## Structure du projet
```
salariumIntegration/
├── index.html              # Page HTML standalone (Partie 1)
├── css/
│   └── style.css           # CSS de la partie 1
├── js/
│   └── main.js             # JS de la partie 1
├── wp-theme/
│   └── salarium-theme/     # Thème WordPress custom (Partie 2)
│       ├── style.css
│       ├── functions.php
│       ├── header.php
│       ├── footer.php
│       ├── front-page.php
│       ├── index.php
│       └── assets/
│           ├── css/
│           └── js/
└── wp-plugin/
    └── salarium-calculator/ # Plugin calculateur (Partie 3)
        ├── salarium-calculator.php
        └── assets/
            ├── css/
            └── js/
```

---

## Partie 1 — HTML/CSS/JS standalone

### Installation

1. Clonez le dépôt :
```bash
git clone https://github.com/Baptiste85Verdon/SalariumIntegration/
```
2. Ouvrez `index.html` via un serveur local (Live Server, WAMP, XAMPP, MAMP, etc.)

### Accès

- Page : `http://localhost/index.html` (selon votre outil)

### Ce qu'on y trouve

- `index.html` — structure sémantique complète de la page :
  - Navbar avec logo, liens de navigation et bouton Contact
  - Section Hero avec badge, titre mixte serif/italic et sous-titre
  - Section calculateur (placeholder en attente de la partie 3)

- `css/style.css` — feuille de styles complète :
  - Variables CSS globales (couleurs, typographies, espacements)
  - Reset CSS
  - Styles de chaque section
  - Responsive mobile via un breakpoint
  - Menu burger (affiché uniquement sur mobile)

- `js/main.js` — interactions JavaScript :
  - Ouverture/fermeture du menu burger sur mobile

---

## Partie 2 — Thème WordPress custom

### Installation
1. Copiez le thème dans votre installation LocalWP :
   - Depuis le dépôt : `wp-theme/salarium-theme/`
   - Vers : `[votre-site-local]/app/public/wp-content/themes/`

2. Activez le thème depuis le dashboard administrateur de WordPress :
    - Accédez au tableau de bord via :
      `http://[nom-de-votre-site].local/wp-admin`
    - WP Admin → Apparence → Thèmes → Activer **Salarium**

### Ce qu'on y trouve

- `style.css` — carte d'identité du thème (nom, version, auteur)
- `functions.php` — cerveau du thème :
  - Chargement des assets via `wp_enqueue_style` / `wp_enqueue_script`
  - Chargement de Google Fonts et Font Awesome
  - Configuration de base WordPress
- `header.php` — template de la navbar :
  - Logo avec icône Font Awesome
  - Navigation principale avec boutons
- `footer.php` — template du footer :
  - Copyright avec séparateur
  - Navigation légale (Mentions légales, CGU, Politique de confidentialité, Cookies)
  - Appel `wp_footer()` pour l'injection des scripts WordPress
- `front-page.php` — template de la page d'accueil :
  - Appel `get_header()` et `get_footer()`
  - Section Hero (badge, titre, sous-titre)
  - Section calculateur avec appel du shortcode `[salary_calculator]`
- `index.php` — template de fallback obligatoire WordPress
- `assets/css/style.css` — CSS identique à la Partie 1
- `assets/js/main.js` — JS identique à la Partie 1

---

## Partie 3 — Plugin calculateur

### Installation

1. Copiez le plugin dans votre installation LocalWP :
   - Depuis le dépôt : `wp-plugin/salarium-calculator/`
   - Vers : `[votre-site-local]/app/public/wp-content/plugins/`

2. Activez le plugin depuis le dashboard administrateur de WordPress :
   - WP Admin → Extensions → Activer **Salarium Calculator**

### Utilisation du shortcode

Le calculateur s'affiche automatiquement sur la page d'accueil. Pour l'utiliser sur une autre page :
[salary_calculator]

### Ce qu'on y trouve

- `salarium-calculator.php` — fichier principal du plugin :
  - En-tête WordPress
  - Chargement des assets CSS/JS et Font Awesome via `wp_enqueue`
  - Shortcode `[salary_calculator]` générant le HTML du calculateur via `ob_start()`
  - Structure HTML : carte en deux colonnes (formulaire + panneau résultats)

- `assets/css/calculator.css` — styles du calculateur :
  - Variables CSS
  - Layout en grille 2 colonnes (formulaire à gauche, résultats à droite)
  - Toggles Non-cadre/Cadre et Mensuel/Annuel
  - Champs de saisie stylisés (brut et net)
  - Panneau résultats avec affichage du taux, cotisations et salaire annuelle
  - Note informative
  - Responsive mobile

- `assets/js/calculator.js` — logique du calculateur :
  - Calcul bidirectionnel brut → net et net → brut
  - Taux de cotisations : Non-cadre 22%, Cadre 25%
  - Toggle Mensuel/Annuel avec vidage des champs et recalcul
  - Toggle Statut avec mise à jour instantanée du taux affiché
  - Validation des entrées (nombres positifs, maximum 1 000 000 €)
    - Formatage des nombres en français (`Intl.NumberFormat`)
  - Mise à jour dynamique du panneau résultats (taux, cotisations, annuel, description)

### Pourquoi une logique côté client ?

Le calcul du salaire net suit une formule simple :
`Net = Brut × (1 - taux)`

Trois raisons justifient le choix JavaScript côté client :

1. **Instantanéité** — le résultat s'affiche à chaque frappe, sans délai réseau.
   Une requête serveur (AJAX/REST) ajouterait une latence pour un calcul aussi simple.

2. **Pas de données sensibles** — aucune donnée n'est envoyée au serveur donc pas besoin d'aller se connecter et requêter un serveur

3. **Simplicité** — la formule ne nécessite pas de ressources serveur
   (base de données, API externe, règles métier complexes).

Un endpoint AJAX ou REST serait justifié et utile si les taux variaient selon
une base de données.

