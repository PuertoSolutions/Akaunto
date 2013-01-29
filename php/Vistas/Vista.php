<?php
require 'lib/Slim/View.php';

class Vista extends \Slim\View
{
    static protected $_layout = NULL;
    public static function set_layout($layout=NULL)
    {
        self::$_layout = $layout;
    }
    public function render( $template ) {
        extract($this->data);
        $templatePath = "./vistas" . '/' . ltrim($template, '/');
        if ( !file_exists($templatePath) ) {
            throw new RuntimeException('View cannot render template `' . $templatePath . '`. Template does not exist !.');
        }
        ob_start();
        require $templatePath;
        $html = ob_get_clean();
        return $this->_render_layout($html);
    }
    public function _render_layout($_html)
    {
        if(self::$_layout !== NULL)
        {
            $layout_path = "./vistas" . '/' . ltrim(self::$_layout, '/');
            if ( !file_exists($layout_path) ) {
                throw new RuntimeException('View cannot render layout `' . $layout_path . '`. Layout does not exist.');
            }
            ob_start();
            require $layout_path;
            $_html = ob_get_clean();
        }
        return $_html;
    }

}
?>