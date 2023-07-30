<?php
include(__DIR__ . "/../engine/core.include.php");
require_token();

$api = new MajestiCloudAPI($_SESSION["token"]);

if (!empty($_GET['email']) && !empty($_GET['key'])) {
    $api_response = $api->user_verify_email($_GET['email'], $_GET['key']);
    if($api_response['status'] == true) set_alert("Adresse validée.", "success");
    else set_alert($api_response['message'], "success");
} else {
    set_alert("Le lien est invalide.", "info");
}

header("Location: /dashboard/index.php");
