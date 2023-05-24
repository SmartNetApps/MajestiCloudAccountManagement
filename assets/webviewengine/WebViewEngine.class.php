<?php
class WebViewEngine
{
    public const TEMPLATES_DIR = __DIR__ . "/templates";

    public static function head($page_title = "", $redirect_to = null)
    {
        $html = file_get_contents(self::TEMPLATES_DIR . "/head.html");
        $html = str_replace("{{page_title}}", $page_title, $html);
        if (!empty($redirect_to)) {
            $html = str_replace("{{redirect_tag}}", '<meta http-equiv="refresh" content="0; URL='.$redirect_to.'" />', $html);
        } else {
            $html = str_replace("{{redirect_tag}}", "", $html);
        }
        return $html;
    }

    public static function header($page_h1 = "MajestiCloud", $back_btn_link = null, $back_btn_icon = "bi-arrow-left-circle", $back_btn_title="Retour")
    {
        $html = file_get_contents(self::TEMPLATES_DIR . "/header.html");
        $html = str_replace("{{page_h1}}", $page_h1, $html);
        if(!empty($back_btn_link)) 
            $html = str_replace("{{back_btn}}", '<a class="btn btn-lg btn-link py-0 ps-0" style="font-size: 2rem;" href="'.$back_btn_link.'" title="'.$back_btn_title.'"><i class="bi '.$back_btn_icon.'"></i></a>', $html);
        else
            $html = str_replace("{{back_btn}}", "", $html);
        return $html;
    }

    public static function footer()
    {
        $html = file_get_contents(self::TEMPLATES_DIR . "/footer.html");
        $html = str_replace("{{current_year}}", date("Y"), $html);

        return $html;
    }
}
