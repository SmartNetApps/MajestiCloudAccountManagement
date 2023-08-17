<?php
include(__DIR__ . "/../engine/core.include.php");
require_token();

$api = new MajestiCloudAPI($_SESSION["token"]);

if (empty($_GET['for'])) header("Location: /dashboard/index.php");

switch (strtolower($_GET['for'])) {
    case "primary_email_validation":
        $api->send_validation_email("primary");
        break;
    case "recovery_email_validation":
        $api->send_validation_email("recovery");
        break;
}

header("Location: /dashboard/index.php");
