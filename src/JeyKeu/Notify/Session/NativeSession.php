<?php namespace JeyKeu\Notify\Session;

/**
 * Description of NativeSession
 *
 * @author Junaid Qadir Baloch <shekhanzai.baloch@gmail.com>
 */
class NativeSession implements \JeyKeu\Notify\Session\SessionInterface
{

    /**
     * The Native PHP session driver.
     *
     */
    protected $store;

    /**
     * The key used in the Session.
     *
     * @var string
     */
    protected $appSessionKey = 'jeykeu_notify';

    public function getKey()
    {
        return $this->appSessionKey;
    }


    public function get($key)
    {
        if (!isset($_SESSION[$this->appSessionKey])) {
            return false;
        }
        $data = unserialize($_SESSION[$this->appSessionKey]);

        return $data->$key;
    }

    public function set($key, $value)
    {
        $data                 = (object) array($key => $value);
        $_SESSION[$this->appSessionKey] = serialize($data);
    }
    
    public function remove($key = null)
    {
        if (empty($key)) {
            unset($_SESSION[$this->appSessionKey]);
        } else {
            $data                           = unserialize($_SESSION[$this->appSessionKey]);
            unset($data->$key);
            $_SESSION[$this->appSessionKey] = serialize($data);
        }
    }
}
