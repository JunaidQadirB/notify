<?php

namespace JeyKeu\Notify\View;

/**
 * Description of CodeIgniterView
 *
 * @author jeykeu
 */
class CodeIgniterView implements ViewInterface
{

    public function load($view, $vars = array(), $return = false) {
        return $this->CI->load->view($view, $vars, $return);
    }

//put your code here
}
