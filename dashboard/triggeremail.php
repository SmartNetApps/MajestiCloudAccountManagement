<?php
include(__DIR__ . "/../engine/core.include.php");
require_token();

$api = new MajestiCloudAPI($_SESSION["token"]);
$mailer = new Mailer();

if (empty($_GET['for'])) header("Location: /dashboard/index.php");

switch (strtolower($_GET['for'])) {
    case "primary_email_validation":
        $validation_keys = $api->user_email_validation_keys();
        if ($validation_keys['status'] == true) $mailer->validation_email($_SESSION['user']['primary_email'], $validation_keys['data']['primary_email_validation_key']);
        break;
    case "recovery_email_validation":
        $validation_keys = $api->user_email_validation_keys();
        if ($validation_keys['status'] == true) $mailer->validation_email($_SESSION['user']['recovery_email'], $validation_keys['data']['recovery_email_validation_key']);
        break;
}

header("Location: /dashboard/index.php");
