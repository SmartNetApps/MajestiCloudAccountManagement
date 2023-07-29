<?php
include(__DIR__."/../engine/core.include.php");

try {
    $api = new MajestiCloudAPI(isset($_SESSION["token"]) ? $_SESSION["token"] : null);

    $client_uuid = MajestiCloudAPI::CLIENT_ID;
    $redirect_uri = MajestiCloudAPI::CLIENT_REDIRECT_URI;
    $client = $api->client_get($client_uuid);

    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        $email = $_POST["email"];
        $pwd = $_POST["pwd"];
        if (empty($_POST["client_uuid"]) || empty($_POST["redirect_uri"])) {
            throw new Exception("Mauvaise configuration du tunnel d'authentification.");
        }

        $client_uuid = trim($_POST["client_uuid"]);
        $redirect_uri = trim($_POST["redirect_uri"]);
        $client = $api->client_get($client_uuid);

        // Get an authorization code
        $response = $api->oauth_authorize(
            $email,
            $pwd,
            $client_uuid,
            $redirect_uri,
            !empty($_POST["code_challenge"]) ? $_POST["code_challenge"] : null,
            !empty($_POST["code_challenge_method"]) ? $_POST["code_challenge_method"] : null
        );

        // Redirect to the client's callback page
        if ($response["status"] == true) {
            // http_response_code(307);
            // header("Location: ".$response["redirect_to"]);
            $redirect_to = $response["redirect_to"];
        }
    } else {
        if (!empty($_GET["client_uuid"]) && !empty($_GET["redirect_uri"])) {
            $client_uuid = trim($_GET["client_uuid"]);
            $redirect_uri = trim($_GET["redirect_uri"]);
            $client = $api->client_get($client_uuid);

            if ($client["redirect_uri"] != $redirect_uri) {
                throw new Exception("Mauvaise configuration du tunnel d'authentification.");
            }
        }
    }
} catch (Exception $ex) {
    header("Location: /error.php?error=" . $ex->getMessage());
}

?>
<!DOCTYPE html>
<html lang="fr">
<?= WebViewEngine::head("Se connecter", isset($redirect_to) ? $redirect_to : null) ?>

<style>
    h2 {
        text-align: center;
        margin-bottom: 1.5rem;
    }

    body {
        background-image: linear-gradient(to top right, #f5fcff, #fff);
    }
</style>

<script>
    function showform() {
        document.getElementsByTagName("form").item(0).style.display = "block";
        document.getElementById("session-disclaimer").classList.remove("d-flex");
        document.getElementById("session-disclaimer").style.display = "none";
    }
</script>

<body style="min-height: 100vh;" class="p-3 d-flex flex-column justify-content-center align-items-center">
    <div class="mb-3">
        <img src="/assets/images/logos/legacy_icon_x128.png" alt="MajestiCloud logo" height="96">
    </div>
    <div class="border rounded-3 shadow p-4 bg-white" style="width:100%; max-width: 700px;">
        <?php if (isset($redirect_to)) : ?>
            <div class="text-center">
                <div class="spinner-border text-primary" role="status">
                    <span class="visually-hidden">Veuillez patienter...</span>
                </div>
            </div>
        <?php else : ?>
            <?php if (!empty($client) && $client["uuid"] != MajestiCloudAPI::CLIENT_ID) : ?>
                <h2>Se connecter à l'application</h2>
                <div class="pb-3 mb-3 border-bottom d-flex flex-row gap-4">
                    <div>
                        <img width="50" src="<?= $client["logo_url"] ?>" alt="Logo de l'application">
                    </div>
                    <div>
                        <p class="m-0 h4"><?= $client["name"] ?></p>
                        <p class="m-0"><?= $client["author_name"] ?></p>
                        <p class="m-0"><?= $client["description"] ?></p>
                        <p class="m-0"><a href="<?= $client["webpage"] ?>"><?= $client["webpage"] ?></a></p>
                    </div>
                </div>
            <?php else : ?>
                <h2>Se connecter</h2>
            <?php endif; ?>

            <?php if (!empty($response) && !$response["status"]) : ?>
                <div class="alert alert-warning mb-3 shadow-sm">
                    <?= $response["message"]; ?>
                </div>
            <?php endif; ?>

            <?php if (isset($_SESSION["user"])) : ?>
                <div id="session-disclaimer">
                    <div class="d-flex flex-row gap-3 align-items-center">
                        <div>
                            <img class="rounded-circle" width="100" height="100" src="<?= $api->user_profile_picture_get() ?>" alt="Photo de profil">
                        </div>
                        <div>
                            <p class="mb-1 mt-0">Déjà connecté-e en tant que</p>
                            <p class="m-0 h4"><?= $_SESSION["user"]["name"] ?></p>
                            <p class="m-0"><?= $_SESSION["user"]["primary_email"] ?></p>
                        </div>
                    </div>
                    <div class="mt-3">
                        <a class="btn btn-sm btn-primary shadow-sm" href="/dashboard/">Continuer en tant que <?= $_SESSION["user"]["name"] ?> <i class="bi bi-chevron-right"></i></a>
                        <button class="btn btn-sm btn-secondary shadow-sm" onclick="showform()">Utiliser un autre compte</button>
                    </div>
                </div>
            <?php endif; ?>
            <form action="login.php" method="POST" <?php if (isset($_SESSION["user"])) echo 'style="display: none;"'; ?>>
                <input type="hidden" name="client_uuid" value="<?= $client_uuid ?>">
                <input type="hidden" name="redirect_uri" value="<?= $redirect_uri ?>">
                <div class="mb-3">
                    <label for="emailInput" class="form-label">Adresse de courriel</label>
                    <input type="email" class="form-control" id="emailInput" placeholder="name@example.com" name="email" value="<?php if (isset($email)) echo $email; ?>" required>
                    <div class="invalid-feedback">Veuillez saisir l'adresse de courriel principale de votre compte.</div>
                </div>
                <div class="mb-3">
                    <label for="pwdInput" class="form-label">Mot de passe</label>
                    <input type="password" class="form-control" id="pwdInput" placeholder="Votre mot de passe" name="pwd" required>
                    <div class="invalid-feedback">Veuillez saisir le mot de passe de votre compte.</div>
                </div>
                <div>
                    <button type="submit" id="submitBtn" class="btn btn-primary shadow-sm">Continuer <i class="bi bi-chevron-right"></i></button>
                </div>
            </form>
        <?php endif; ?>
    </div>
    <footer class="m-5">
        &copy; 2014-<?=date("Y")?> Quentin Pugeat
    </footer>
</body>
<script>
    document.getElementById("submitBtn").addEventListener("click", (ev) => {
        document.getElementsByTagName("form").item(0).classList.add("was-validated")
    });
</script>

</html>