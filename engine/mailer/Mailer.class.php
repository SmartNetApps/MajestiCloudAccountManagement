<?php

/**
 * This class enables email sending for the website.
 * This is used to send security notifications.
 */
class Mailer
{
    private string $from = "webmaster@localhost";
    private string $root_url = "http://localhost";

    function __construct()
    {
        $this->from = "mailer@".$_SERVER['HTTP_HOST'];
        $this->root_url = ($_SERVER['SERVER_PORT'] == 443 ? 'https://' : 'http://').$_SERVER['HTTP_HOST'];
    }

    public function send_mail($to, $subject, $title, $html_body, $template = "global")
    {
        $mail_body = file_get_contents(__DIR__."/templates/$template.template.html");
        $mail_body = str_replace('{{subject}}', htmlentities($subject), $mail_body);
        $mail_body = str_replace('{{title}}', htmlentities($title), $mail_body);
        $mail_body = str_replace('{{html_body}}', $html_body, $mail_body);

        return mail(
            $to,
            $subject,
            $mail_body,
            implode("\r\n", [
                "Content-Type: text/html; charset=utf-8",
                "From: MajestiCloud <".$this->from.">",
                'X-Mailer: PHP/' . phpversion()
            ])
        );
    }

    public function validation_email($to, $validation_key) {
        $url = $this->root_url."/mailclick/verify_email.php?email=".urlencode($to)."&key=".urlencode($validation_key);
        $this->send_mail(
            $to, 
            "Veuillez valider votre adresse e-mail",
            "Validation requise",
            '<p>Veuillez valider votre adresse e-mail en cliquant sur ce lien ou en le copiant dans une fenêtre de navigateur.</p>
            <a href="'.$url.'">'.$url.'</a>'
        );
    }
}
