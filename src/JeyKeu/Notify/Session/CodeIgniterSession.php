<?php

namespace JeyKeu\Notify\Session;

use JeyKeu\Notify\Session\SessionInterface;
use CI_Session;

class CodeIgniterSession implements SessionInterface
{

    /**
     * The CodeIgniter session driver.
     *
     * @param  CI_Session
     */
    protected $store;

    /**
     * The key used in the Session.
     *
     * @var string
     */
    protected $key = 'jeykeu_notify';

    /**
     * Creates a new CodeIgniter Session driver for Notify.
     *
     * @param  \CI_Session  $store
     * @param  string  $key
     * @return void
     */
    public function __construct(CI_Session $store, $key = null) {
//        die("fsdsdfd");
        $this->store = $store;
        if (isset($key)) {
            $this->key = $key;
        }
    }

    /**
     * Returns the session key.
     *
     * @return string
     */
    public function getKey() {
        return $this->key;
    }

    /**
     * Put a value in the Notify session.
     *
     * @param  mixed  $value
     * @return void
     */
    public function put($key, $value) {
        $this->store->set_userdata($this->getkey(), serialize($value));
    }

    /**
     * Get the Notify session value.
     *
     * @return mixed
     */
    public function get($key) {
        return unserialize($this->store->userdata($this->getKey()));
    }

    /**
     * Remove the Notify session.
     *
     * @return void
     */
    public function forget($key = null) {
        $this->store->unset_userdata($this->getKey());
    }

}
