<?php
include(__DIR__ . "/../engine/core.include.php");
require_token();

$api = new MajestiCloudAPI($_SESSION["token"]);

if(!empty($_GET["action"])) {
    switch($_GET["action"]) {
        case "request":
            $response = $api->user_delete(false);
            break;
        case "cancel":
            $response = $api->user_delete(true);
            break;
    }

    set_alert($response["message"], $response["status"] ? "success" : "warning");
}

$user = $api->user_get();
?>
<!DOCTYPE html>
<html lang="fr">
<?= WebViewEngine::head("Suppression du compte") ?>

<body>
    <?= WebViewEngine::header("Suppression du compte", "/dashboard/index.php", "bi-arrow-left", "Retour") ?>
    <?= display_alert() ?>
    <section class="container">
        <div>
            <h2><i class="bi bi-person-circle"></i> État du compte</h2>
            <?php if (!empty($user["to_be_deleted_after"])) : ?>
                <p class="mt-0">Le compte est marqué comme À SUPPRIMER le <?= date_create_from_format("Y-m-d H:i:s", $user["to_be_deleted_after"])->format("d/m/Y") ?>.</p>
                <p>Jusqu'à cette date, vous pouvez vous rétracter. Votre compte ne sera plus considéré comme à supprimer.</p>
                <a href="accountdelete.php?action=cancel" class="btn btn-danger shadow-sm"><i class="bi bi-gear-wide-connected"></i> Annuler la suppression du compte</a>
            <?php else : ?>
                <p class="mt-0">Votre compte est actuellement actif.</p>
                <p>La suppression du compte entraînera la suppression de toutes ses données de notre serveur : profil, photo de profil, données de synchronisation.</p>
                <p>Vous disposerez d'une période de rétractation de 30 jours à compter de votre demande de suppression, pendant laquelle votre compte continuera de fonctionner comme d'habitude, et pendant laquelle vous pourrez annuler votre demande.</p>
                <a href="accountdelete.php?action=request" class="btn btn-danger shadow-sm"><i class="bi bi-gear-wide-connected"></i> Demander la suppression du compte</a>
            <?php endif; ?>
        </div>
    </section>
    <?= WebViewEngine::footer() ?>
</body>

</html>