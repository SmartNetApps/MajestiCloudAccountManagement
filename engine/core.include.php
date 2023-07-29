<?php
session_start();

include(__DIR__."/Environment.config.php");
include(__DIR__."/MajestiCloudAPI.class.php");
include(__DIR__."/webviewengine/WebViewEngine.class.php");

function require_token() {
    if (empty($_SESSION["token"])) {
        header("Location: /");
        exit;
    }
}

function set_alert($message, $level = "info")
{
    $_SESSION["alert"] = [
        "message" => trim($message),
        "level" => $level
    ];
}

function display_alert() {
    if(!empty($_SESSION["alert"])) {
        return '<div class="mb-3 container alert alert-'.$_SESSION["alert"]["level"].'">'.htmlentities($_SESSION["alert"]["message"]).'</div>';
        clear_alert();
    }
}

function clear_alert() {
    unset($_SESSION["alert"]);
}
