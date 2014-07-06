<?php

namespace JeyKeu\Notify\Session;

/**
 * SessionInterface
 */
interface SessionInterface
{

    /**
     * Returns the session key.
     *
     * @return string
     */
    public function getKey();

    /**
     * Put a value in the Notify session.
     *
     * @param  mixed   $value
     * @return void
     */
    public function put($key, $value);

    /**
     * Get the Notify session value.
     *
     * @return mixed
     */
    public function get($key);

    /**
     * Remove the Notify session.
     *
     * @return void
     */
    public function forget($key);
}
