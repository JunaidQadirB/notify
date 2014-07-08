<?php namespace JeyKeu\Notify\Facades\CodeIgniter;

use JeyKeu\Notify\Notify as BaseNotify;
use JeyKeu\Notify\Session\CodeIgniterSession;
use JeyKeu\Notify\URI\CodeIgniterURI;

/**
 * Description of Notify
 *
 * @author Junaid Qadir Baloch <shekhanzai.baloch@gmail.com>
 */
class Notify
{

    public function createNotify()
    {
        $ci   = &get_instance();
        $ci->load->library('session');
        $sess = new CodeIgniterSession($ci->session);

        return new BaseNotify(
                $sess, new CodeIgniterURI($ci->uri)
        );
    }
}
