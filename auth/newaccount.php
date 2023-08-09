<?php
include(__DIR__ . "/../engine/core.include.php");

try {
    $api = new MajestiCloudAPI();

    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        $display_name = $_POST["display_name"];
        $email = $_POST["email"];
        $pwd = $_POST["pwd"];

        // Create the account
        $response = $api->user_post(
            $email,
            $pwd,
            $display_name
        );

        if($response["status"] == true) {
            $response["message"] .= ' Vous pouvez dès maintenant <a href="/auth/login.php">vous authentifier sur le portail.</a>';
        }
    }
} catch (Exception $ex) {
    header("Location: /error.php?error=" . str_replace("\n", "", $ex->getMessage()));
}

?>
<!DOCTYPE html>
<html lang="fr">
<?= WebViewEngine::head("Créer un compte") ?>

<style>
    h2 {
        text-align: center;
        margin-bottom: 1.5rem;
    }

    body {
        background-image: linear-gradient(to top right, #f5fcff, #fff);
    }

    @media (prefers-color-scheme: dark) {
        body {
            background-image: linear-gradient(to top right, #020202, #000);
        }
    }
</style>

<body style="min-height: 100vh;" class="p-3 d-flex flex-column justify-content-center align-items-center">
    <div class="mb-3">
        <img src="/assets/images/logos/legacy_icon_x128.png" alt="MajestiCloud logo" height="96">
    </div>
    <div class="border rounded-3 shadow p-4 bg-body-tertiary" style="width:100%; max-width: 700px;">
        <h2>Créer un compte sur MajestiCloud</h2>
        <?php if (!empty($response)) : ?>
            <div class="alert <?=$response["status"] ? 'alert-success' : 'alert-warning' ?> mb-3 shadow-sm">
                <?= $response["message"]; ?>
            </div>
        <?php endif; ?>
        <form action="newaccount.php" method="POST">
        <div class="mb-3">
                <label for="nameInput" class="form-label">Nom</label>
                <input type="text" class="form-control" id="nameInput" name="display_name" value="<?php if (isset($display_name)) echo $display_name; ?>" autocomplete="name" required>
                <div class="invalid-feedback">Vous pouvez utiliser votre vrai nom ou un pseudonyme.</div>
            </div>
            <div class="mb-3">
                <label for="emailInput" class="form-label">Adresse de courriel</label>
                <input type="email" class="form-control" id="emailInput" placeholder="name@example.com" name="email" value="<?php if (isset($email)) echo $email; ?>" autocomplete="email" required>
                <div class="invalid-feedback">Saisissez une adresse sur laquelle vous pouvez recevoir des courriels et à laquelle personne d'autre que vous n'a accès.</div>
            </div>
            <div class="mb-3">
                <label for="pwdInput" class="form-label">Mot de passe</label>
                <input type="password" class="form-control" id="pwdInput" placeholder="Votre mot de passe" name="pwd" autocomplete="new-password" required>
                <div class="invalid-feedback">Il s'agira du mot de passe de votre compte.</div>
            </div>
            <div>
                <a class="btn btn-secondary shadow-sm" href="login.php"><i class="bi bi-chevron-left"></i> Annuler</a>
                <button type="submit" id="submitBtn" class="btn btn-primary shadow-sm">Continuer <i class="bi bi-chevron-right"></i></button>
            </div>
        </form>
    </div>
    <footer class="m-5">
        &copy; 2014-<?= date("Y") ?> Quentin Pugeat
    </footer>
</body>
<script src="https://assets.lesmajesticiels.org/libraries/bootstrap/bootstrap-5.3.1-dist/js/bootstrap.bundle.min.js"></script>
<script src="https://assets.lesmajesticiels.org/libraries/bootstrap/bootstrap-5.x-custom/color-modes-toggler.js"></script>
<script>
    document.getElementById("submitBtn").addEventListener("click", (ev) => {
        document.getElementsByTagName("form").item(0).classList.add("was-validated")
    });
</script>

</html>