<?php
include(__DIR__ . "/engine/core.include.php");
?>
<!DOCTYPE html>
<html lang="fr">
<?= WebViewEngine::head("Termes et conditions de MajestiCloud") ?>

<body>
    <?= WebViewEngine::header("Termes et conditions de MajestiCloud", "index.php", "bi-arrow-left", "Retour") ?>

    <section class="container">
        <h4>Service</h4>
        <p>
            Le "Service" est MajestiCloud, cette présente plateforme, dont la raison d'être est de permettre aux usagers des logiciels et des services en ligne des Majesticiels
            de synchroniser leurs données entre plusieurs appareils.
        </p>

        <h4>Fournisseur du service</h4>
        <p>Le fournisseur du service est <b>Quentin Pugeat</b>.</p>
        <p>Il s'agit d'un particulier domicilé à Besançon.</p>

        <h4>Garanties</h4>
        <p>Ce Service, maintenu par un volontaire, est fourni à titre gracieux et sans aucune garantie que ce soit.</p>
        <p>Le Service peut à tout moment être modifié ou interrompu sans préavis.</p>
        <p>Le Service peut dysfonctionner, indépendamment de la volonté de son Fournisseur, et par conséquent devenir inaccessible inopinément, pendant des durées indéterminées.</p>

        <h4>Limites légales</h4>
        <p>
            Il est requis d'utiliser ce Service dans le cadre prévu par les lois françaises et Européennes.<br>
            Tout contenu stocké sur le Service ou transféré via le Service est susceptible d'être effacé sans préavis si il est illégal.
        </p>

        <h4>Propriété</h4>
        <p>
            En envoyant du contenu sur le Service, les usagers accordent un droit d'accès, de modification et d'adaptation dudit contenu, jusqu'à ce qu'il soit retiré.
        </p>

        <h4>Politique de confidentialité</h4>
        <p>
            La <a href="/privacy.php">Politique de protection des données à caractères personnel</a> décrit en détail ce que le Fournisseur reçoit de votre utilisation du Service et quel usage il est fait de ces informations.
        </p>

        <h4>Nous contacter</h4>
        <p>
            Vous pouvez contacter le Fournisseur du Service via ces canaux.
        </p>
        <ul>
            <li>Courriel : <a href="mailto:hello@lesmajesticiels.org">hello@lesmajesticiels.org</a></li>
            <li>Sur les réseaux sociaux où il est présent : <a href="https://www.facebook.com/LesMajesticiels">Facebook</a>, <a href="https://www.threads.net/lesmajesticiels">Threads</a>, <a href="https://www.instagram.com/lesmajesticiels">Instagram</a>.</li>
        </ul>
    </section>

    <?= WebViewEngine::footer() ?>
</body>

</html>