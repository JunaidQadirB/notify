<?php

namespace JeyKeu\Notify\Facades\CodeIgniter;

use JeyKeu\Notify\Facades\Facade;
use JeyKeu\Notify\Notify as BaseNotify;
use JeyKeu\Notify\Session\CodeIgniterSession;
use JeyKeu\Notify\URI\CodeIgniterURI;
use JeyKeu\Notify\View\CodeIgniterView;

/**
 * Description of Notify
 *
 * @author jeykeu
 */
class Notify
{

    public function createNotify() {
        $ci = &get_instance();
        return new BaseNotify(
                new CodeIgniterSession($ci->session), new CodeIgniterURI($ci->uri)
        );
    }

}
