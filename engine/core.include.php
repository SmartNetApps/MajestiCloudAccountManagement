<?php

session_start();

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

function clear_alert() {
    unset($_SESSION["alert"]);
}
