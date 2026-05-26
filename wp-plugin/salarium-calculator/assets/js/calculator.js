// JS pour le calculateur de salaire

// Taux de cotisation selon le statut
const TAUX = {
    'non-cadre': 0.22,
    'cadre': 0.25
};

// États par défaut pour le calcul
let statut = 'non-cadre';
let periode = 'mensuel';

// On récupère les éléments du DOM
const inputBrut = document.getElementById('calc_brut');
const inputNet = document.getElementById('calc_net');
const errorBrut = document.getElementById('error_brut');
const errorNet = document.getElementById('error_net');
const tauxDisplay = document.getElementById('calc_rate');
const descDisplay = document.getElementById('calc_description');
const cotisationsDisplay = document.getElementById('calc_cotisations');
const annuelDisplay = document.getElementById('calc_annuel');

// Validation des entrées
function validerChamp(valeur, errorElement) {
    if (valeur === '') {
        errorElement.textContent = '';
        return false;
    }
    if (isNaN(valeur) || parseFloat(valeur) < 0) {
        errorElement.textContent = 'Veuillez entrer un nombre positif.';
        return false;
    }
    if (valeur > 1000000) {
        errorElement.textContent = 'Le montant est trop élevé.';
        return false;
    }
    errorElement.textContent = '';
    return true;
}

// Calculs
function calculerDepuisBrut(brut) {
    const taux = TAUX[statut];
    const net = brut * (1 - taux);
    const cotisations = brut - net;
    // Si la période est annuelle on retroune le net tel quel
    // Sinon, on le multiplie par 12 pour le mensuel
    const annuel = periode === 'annuel' ? net : net * 12;
    return {  net, cotisations, annuel };
}

function calculerDepuisNet(net) {
    const taux = TAUX[statut];
    const brut = net / (1 - taux);
    const cotisations = brut - net;
    // Si la période est annuelle on retroune le net tel quel
    // Sinon, on le multiplie par 12 pour le mensuel
    const annuel = periode === 'annuel' ? net : net * 12;
    return { brut, cotisations, annuel };
}

// Mise à jour de l'affichage
function formaterNombre(nombre) {
    return new Intl.NumberFormat('fr-FR').format(Math.round(nombre));
}

function mettreAJourResultats(cotisations, annuel) {
    const taux = TAUX[statut];
    const tauxPourcentage = Math.round(taux * 100);

    tauxDisplay.textContent = tauxPourcentage;
    cotisationsDisplay.firstChild.textContent = formaterNombre(cotisations) + ' ';
    annuelDisplay.firstChild.textContent = formaterNombre(annuel) + ' ';
    descDisplay.textContent = `Statut ${statut} — environ ${tauxPourcentage} % de cotisations salariales déduites du brut.`;
}

// Gestion des événements sur les champs de saisie

// Calcul depuis le champ brut
inputBrut.addEventListener('input', () => {
    const valeur = parseFloat(inputBrut.value);
    if (!validerChamp(inputBrut.value, errorBrut)) return;

    const { net, cotisations, annuel } = calculerDepuisBrut(valeur);

    // Mise à jour des champs net sans déclencher son événement lié
    inputNet.value = Math.round(net);
    errorNet.textContent = '';

    mettreAJourResultats(cotisations, annuel);
});

// Calcul depuis le champ net
inputNet.addEventListener('input', () => {
    const valeur = parseFloat(inputNet.value);
    if (!validerChamp(inputNet.value, errorNet)) return;

    const { brut, cotisations, annuel } = calculerDepuisNet(valeur);

    // Mise à jour des champs brut sans déclencher son événement lié
    inputBrut.value = Math.round(brut);
    errorBrut.textContent = '';

    mettreAJourResultats(cotisations, annuel);
});

// Événements sur les toggles de statut et de période
function gererToggle(groupId, callback) {
    const groupe = document.getElementById(groupId);
    if (!groupe) return;

    groupe.querySelectorAll('.calc_toggle_btn').forEach(btn => {
        btn.addEventListener('click', () => {
            // Désactiver tous les boutons du groupe
            groupe.querySelectorAll('.calc_toggle_btn').forEach(b => {
                b.classList.remove('calc_toggle_btn--active');
            });
            // Activer le bouton cliqué
            btn.classList.add('calc_toggle_btn--active');
            // Appeler le callback avec la valeur du bouton
            callback(btn.dataset.value);
        });
    });
}

// Toggle statut cadre/non-cadre
gererToggle('toggle_statut', (value) => {
    statut = value;
    // Recalculer les résultats avec le nouveau statut
    if (inputBrut.value) {
        inputBrut.dispatchEvent(new Event('input'));
    } else {
        // Si aucun brut n'est saisi, on met à jour les descriptions et les taux
        const taux = TAUX[statut];
        const tauxPourcentage = Math.round(taux * 100);
        tauxDisplay.textContent = tauxPourcentage;
        descDisplay.textContent = `Statut ${statut} — environ ${tauxPourcentage} % de cotisations salariales déduites du brut.`;
    }
});

// Toggle période mensuel/annuel
gererToggle('toggle_periode', (value) => {
    periode = value;
    // On vide les inputs
    inputBrut.value = '';
    inputNet.value = '';
    errorBrut.textContent = '';
    errorNet.textContent = '';
    // On met à jour les descriptions
    cotisationsDisplay.firstChild.textContent = '— ';
    annuelDisplay.firstChild.textContent = '— ';
    descDisplay.textContent = `Statut ${statut} — environ ${tauxPourcentage} % de cotisations salariales déduites du brut.`;
});