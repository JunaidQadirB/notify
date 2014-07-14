<?php namespace JeyKeu\Notify\View;

interface ViewInterface
{

    /**
     *
     * @param string $view
     * @param array  $vars
     * @param bool   $return
     */
    public function load($view, $vars = array(), $return = false);
}
