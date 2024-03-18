<?php
include(__DIR__ . "/engine/core.include.php");
?>
<!DOCTYPE html>
<html lang="fr">
<?= WebViewEngine::head("Politique de confidentialité") ?>

<body>
    <?= WebViewEngine::header("Politique de confidentialité", "index.php", "bi-arrow-left", "Retour") ?>

    <section class="container">
        <h4>Préambule</h4>
        <p>La protection de vos données personnelles est une de nos priorités, de même que la qualité des services que nous vous proposons.</p>
        <p>À ce titre, et bien que le risque zéro n'existe pas, nous mettons tous les moyens qui sont à notre disposition afin de vous fournir un service le plus sûr possible.</p>

        <h4>Qui ?</h4>
        <p>
            Ce service vous est proposé par :<br>
            Quentin Pugeat<br>
            25000 Besançon<br>
            France<br>
            contact@quentinpugeat.fr
        </p>
        <p>
            Les données sont collectées et stockées dans une base de données grâce au service fourni par notre sous-traitant, OVH SAS.
        </p>
        <p>
            Les données ne seront accessibles qu'aux personnes qui en ont besoin : l'utilisateur du compte, l'administrateur de la base de données, l'équipe de support client.
        </p>

        <h4>Pourquoi ?</h4>
        <p>
            Les données qui sont collectées pour le fonctionnement de MajestiCloud auront les finalités suivantes :<br>
        <ul>
            <li>Définir l'identité du détenteur d'un compte. (Son nom, son prénom et/ou son pseudonyme)</li>
            <li>Lui permettre de se connecter et de récupérer son compte s'il perd son mot de passe (adresse e-mail)</li>
            <li>Vérifier son identité en cas de soupçon de piratage (adresse e-mail secondaire)</li>
            <li>Permettre la personnalisation du compte (image de profil)</li>
        </ul>
        </p>
        <p>
            Toutes les données demandées ne sont pas obligatoires pour la création et l'usage d'un compte. Seules l'adresse e-mail, et le nom d'affichage (véritable nom ou pseudonyme) sont obligatoires. L'adresse e-mail secondaire et l'image de profil sont des données facultatives et peuvent à tout moment être retirées.
        </p>

        <h4>Quand et pour quelle durée ?</h4>
        <p>
            Les données seront stockées sur notre base de données dès l'instant où le compte est crée, et jusqu'à sa fermeture.<br>
            Pour fermer votre compte, connectez-vous puis cliquez sur "Fermer le compte..." en bas du menu. Confirmez l'action sur la fenêtre suivante.<br>
            La fermeture d'un compte entraîne la suppression irréversible des données associées de notre base de données.
        </p>

        <h4>Demandes spécifiques et recours</h4>
        <p>
            Conformément à la loi Informatique et Libertés du 6 janvier 1978 modifiée en 2004, vous bénéficiez d’un droit d’accès et de rectification aux informations qui vous concernent. Vous pouvez l'exercer en adressant une demande à contact@quentinpugeat.fr.
        </p>
        <p>
            Si vous constatez une violation de vos droits concernant vos données à caractère personnel, vous pouvez introduire une réclamation auprès de la Commission Nationale de l'Informatique et des Libertés.
        </p>
    </section>

    <?= WebViewEngine::footer() ?>
</body>

</html>