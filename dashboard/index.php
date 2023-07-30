<?php
include(__DIR__ . "/../engine/core.include.php");
require_token();

$api = new MajestiCloudAPI($_SESSION["token"]);
$sessions = $api->session_get();
usort($sessions, function ($a, $b) {
    return date_create_from_format("Y-m-d H:i:s", $b["last_activity_on"], timezone_open("UTC")) <=> date_create_from_format("Y-m-d H:i:s", $a["last_activity_on"], timezone_open("UTC"));
});

$client = $api->client_get($sessions[0]["client_uuid"]);

$user = $api->user_get();
if ($user["primary_email_is_validated"] == false) {
    set_alert("Veuillez valider votre adresse e-mail principale.", "warning");
} elseif (!empty($user["recovery_email"]) && $user["recovery_email_is_validated"] == false) {
    set_alert("Veuillez valider votre adresse e-mail secondaire.", "warning");
}
?>
<!DOCTYPE html>
<html lang="fr">
<?= WebViewEngine::head("Gestion du compte MajestiCloud") ?>

<body>
    <?= WebViewEngine::header("Gestion du compte MajestiCloud", "/auth/logout.php", "bi-box-arrow-left", "Déconnexion") ?>
    <?= display_alert() ?>
    <section class="container">
        <div>
            <h2><i class="bi bi-person-circle"></i> Profil</h2>
            <div class="d-flex align-items-center gap-3 mb-2">
                <div><img src="<?= $api->user_profile_picture_get() ?>" class="rounded-circle" alt="Photo de profil" height="80" width="80"></div>
                <div>
                    <p class="h3 mb-1"><?= $_SESSION["user"]["name"] ?></p>
                    <p class="mb-0"><?= $_SESSION["user"]["primary_email"] ?></p>
                </div>
            </div>
            <a href="profile.php" class="btn btn-primary shadow-sm"><i class="bi bi-pencil"></i> Modifier le profil</a>
            <?php if (!$user["primary_email_is_validated"]) : ?>
                <a href="triggeremail.php?for=primary_email_validation" class="btn btn-warning shadow-sm">Renvoyer l'e-mail de validation</a>
            <?php endif; ?>
        </div>
        <div class="separator"></div>
        <div>
            <h2><i class="bi bi-shield-lock"></i> Sécurité</h2>
            <div>
                <p>Adresse de courriel de secours : <?= $_SESSION["user"]["recovery_email"] ?></p>
            </div>
            <a href="security.php" class="btn btn-primary shadow-sm"><i class="bi bi-pencil"></i> Changer les paramètres de sécurité</a>
            <?php if (!empty($user["recovery_email"]) && !$user["recovery_email_is_validated"]) : ?>
                <a href="triggeremail.php?for=recovery_email_validation" class="btn btn-warning shadow-sm">Renvoyer l'e-mail de validation</a>
            <?php endif; ?>
        </div>
        <div class="separator"></div>
        <div>
            <h2><i class="bi bi-pc-display"></i> Sessions</h2>
            <p class="h4 mt-0">Dernière activité</p>
            <div class="d-flex align-items-center gap-3 mb-2">
                <div>
                    <img src="<?= $client["logo_url"] ?>" title="Logo de l'application" height="55" width="55">
                </div>
                <div>
                    <p class="m-0"><?= $sessions[0]["client_name"] ?> sur <?= $sessions[0]["device_name"] ?></p>
                    <p class="m-0"><?= $sessions[0]["last_activity_on"] ?> - <?= $sessions[0]["last_activity_ip"] ?></p>
                </div>
            </div>
            <a href="sessions.php" class="btn btn-primary shadow-sm"><i class="bi bi-gear-wide-connected"></i> Gérer les sessions</a>
        </div>
        <div class="separator"></div>
        <div>
            <h2><i class="bi bi-braces"></i> API</h2>
            <p class="h4 mt-0">Prochainement disponible</p>
        </div>
    </section>
    <?= WebViewEngine::footer() ?>
</body>

</html>