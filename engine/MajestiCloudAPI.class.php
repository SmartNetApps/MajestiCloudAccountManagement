<?php

include(__DIR__."/Environment.config.php");

/**
 * PHP interface for MajestiCloud API
 * @author Quentin Pugeat <contact@quentinpugeat.fr>
 * @version 3
 */
class MajestiCloudAPI
{
    const API_ROOT = API_ROOT;
    const API_KEY = API_KEY;

    const CLIENT_ID = CLIENT_ID;
    const CLIENT_REDIRECT_URI = CLIENT_REDIRECT_URI;
    private const CLIENT_SECRET = CLIENT_SECRET;

    private $ch;

    function __construct($access_token = null)
    {
        $this->ch = curl_init();
        curl_setopt($this->ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($this->ch, CURLOPT_USERAGENT, $_SERVER["HTTP_USER_AGENT"]);

        if (!empty($access_token)) {
            curl_setopt($this->ch, CURLOPT_HTTPHEADER, [
                "Authorization: Bearer ".$access_token
            ]);
        }
    }

    function __destruct()
    {
        curl_close($this->ch);
    }

    private function parse_response($response, $throw_401s = true)
    {
        if (curl_errno($this->ch) != 0) {
            throw new MajestiCloudAPIException(curl_error($this->ch));
        } elseif ($throw_401s && curl_getinfo($this->ch, CURLINFO_HTTP_CODE) == 401) {
            throw new MajestiCloudAPIException(curl_getinfo($this->ch, CURLINFO_HTTP_CODE) . " : " . json_decode($response, true)["message"]);
        } elseif (curl_getinfo($this->ch, CURLINFO_HTTP_CODE) > 299 && curl_getinfo($this->ch, CURLINFO_HTTP_CODE) != 401) {
            throw new MajestiCloudAPIException(curl_getinfo($this->ch, CURLINFO_HTTP_CODE) . " : " . json_decode($response, true)["message"]);
        } else {
            return json_decode($response, true);
        }
    }

    public function oauth_authorize($email, $pwd, $client_uuid, $redirect_uri, $code_challenge = null, $code_challenge_method = null)
    {
        $fields = [
            "username" => trim($email),
            "password" => $pwd,
            "client_uuid" => $client_uuid,
            "redirect_uri" => $redirect_uri,
            "api_key" => self::API_KEY
        ];

        if (!empty($code_challenge) && !empty($code_challenge_method)) {
            $fields["code_challenge"] = $code_challenge;
            $fields["code_challenge_method"] = $code_challenge_method;
        }

        curl_setopt_array($this->ch, [
            CURLOPT_URL => self::API_ROOT . "/oauth/authorize",
            CURLOPT_POST => true,
            CURLOPT_POSTFIELDS => http_build_query($fields)
        ]);

        return $this->parse_response(curl_exec($this->ch), false);
    }

    public function oauth_token($authorization_code, $code_verifier = null)
    {
        $fields = [
            "authorization_code" => trim($authorization_code),
            "client_uuid" => self::CLIENT_ID,
            "client_secret" => self::CLIENT_SECRET
        ];

        if (!empty($code_verifier)) {
            $fields["code_verifier"] = $code_verifier;
        }

        curl_setopt_array($this->ch, [
            CURLOPT_URL => self::API_ROOT . "/oauth/token",
            CURLOPT_POST => true,
            CURLOPT_POSTFIELDS => http_build_query($fields)
        ]);

        return $this->parse_response(curl_exec($this->ch));
    }

    public function client_get($uuid)
    {
        curl_setopt_array($this->ch, [
            CURLOPT_URL => self::API_ROOT . "/client?uuid=" . $uuid,
            CURLOPT_HTTPGET => true
        ]);

        return $this->parse_response(curl_exec($this->ch))["data"];
    }

    public function user_get()
    {
        curl_setopt_array($this->ch, [
            CURLOPT_URL => self::API_ROOT . "/user/",
            CURLOPT_HTTPGET => true
        ]);

        return $this->parse_response(curl_exec($this->ch))["data"];
    }

    public function user_profile_picture_get() {
        curl_setopt_array($this->ch, [
            CURLOPT_URL => self::API_ROOT . "/user/profile_picture",
            CURLOPT_HTTPGET => true
        ]);

        $image = curl_exec($this->ch);
        $base64 = base64_encode($image);
        $mime = curl_getinfo($this->ch, CURLINFO_CONTENT_TYPE);

        return "data:$mime;base64,$base64";
    }

    public function session_get() {
        curl_setopt_array($this->ch, [
            CURLOPT_URL => self::API_ROOT . "/session/",
            CURLOPT_HTTPGET => true
        ]);

        return $this->parse_response(curl_exec($this->ch))["data"];
    }
}

/**
 * MajestiCloud API Exceptions
 */
class MajestiCloudAPIException extends Exception
{
}
