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
    protected $key = 'jeykeu_notify';

    public function forget($key = null)
    {
        if (empty($key)) {
            unset($_SESSION[$this->key]);
        } else {
            $data                 = unserialize($_SESSION($this->key));
            unset($data->$key);
            $_SESSION[$this->key] = serialize($data);
        }
    }

    public function get($key)
    {
        $store = unserialize($_SESSION[$this->key]);

        return $store->$key;
    }

    public function getKey()
    {
        return $this->key;
    }

    public function put($key, $value)
    {
        $data                 = (object) array($key => $value);
        $_SESSION[$this->key] = serialize($data);
    }
}
