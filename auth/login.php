<?php
include(__DIR__ . "/../engine/core.include.php");

http_response_code(307);
if(isset($_SESSION["token"])) {
    header("Location: /dashboard/index.php");
} else {
    header("Location: ".API_ROOT."oauth/authorize.php?client_uuid=".urlencode(CLIENT_ID)."&redirect_uri=".urlencode(CLIENT_REDIRECT_URI));
}