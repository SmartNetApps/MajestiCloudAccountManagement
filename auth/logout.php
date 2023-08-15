<?php
include(__DIR__ . "/../engine/core.include.php");

try {
    if (!empty($_SESSION["token"])) {
        $api = new MajestiCloudAPI($_SESSION["token"]);
        $api->session_current_delete();
    }
} catch (Exception $ex) {
}

session_unset();
session_destroy();

header("Location: /auth/login.php");
