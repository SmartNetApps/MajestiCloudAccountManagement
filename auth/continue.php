<?php
session_start();
require_once(__DIR__ . "/../assets/webviewengine/WebViewEngine.class.php");
require_once(__DIR__ . "/../engine/MajestiCloudAPI.class.php");

try {
    $api = new MajestiCloudAPI();

    if (!isset($_GET["code"])) {
        throw new Exception("Mauvaise configuration du tunnel d'authentification.");
    }

    $response = $api->oauth_token($_GET["code"]);

    if ($response["status"] == true) {
        $_SESSION["token"] = $response["access_token"];
        $api = new MajestiCloudAPI($response["access_token"]);
        $_SESSION["user"] = $api->user_get();
        header("Location: /dashboard/index.php");
    }
} catch (Exception $ex) {
    header("Location: /error.php?error=" . urlencode($ex->getMessage()));
}
