<?php namespace JeyKeu\Notify;

/**
 * Notification - its a container for a singlen Notify notification
 *
 * @package Notify
 * @author Junaid Qadir Baloch <shekhanzai.baloch@gmail.com>
 */
class Notification
{

    /**
     *
     * @var string 
     */
    private $handle;

    /**
     *
     * @var string 
     */
    private $view;

    /**
     *
     * @var string 
     */
    private $viewData = '';

    /**
     *
     * @var string 
     */
    private $type = 'alert';

    /**
     *
     * @var bool 
     */
    private $isPersisted = true;

    /**
     *
     * @var bool 
     */
    private $isDissmissable = true;

    /**
     *
     * @var array 
     */
    private $exclude;

    public function __construct()
    {
        $this->exclude        = array();
        $this->handle         = "";
        $this->isDissmissable = true;
        $this->isPersisted    = true;
        $this->type           = 'alert';
        $this->view           = '';
        $this->viewData       = '';
    }

    public function getHandle()
    {
        return $this->handle;
    }

    public function setHandle($value)
    {
        $this->handle = $value;
        return $this;
    }

    public function getView()
    {
        return $this->view;
    }

    public function setView($value)
    {
        $this->view = $value;
        return $this;
    }

    public function getViewData()
    {
        return $this->viewData;
    }

    public function setViewData($value)
    {
        $this->viewData = $value;
        return $this;
    }

    public function getType()
    {
        return $this->type;
    }

    public function setType($value)
    {
        $this->type = $value;
        return $this;
    }

    public function getIsPersisted()
    {
        return $this->isPersisted;
    }

    public function setIsPersisted($value)
    {
        $this->isPersisted = $value;
        return $this;
    }

    function getIsDissmissable()
    {
        return $this->isDissmissable;
    }

    function setIsDissmissable($value)
    {
        $this->isDissmissable = $value;
        return $this;
    }

    function getExcludedPages()
    {
        return $this->exclude;
    }

    function setExcludedPages($value)
    {
        $this->exclude = $value;
        return $this;
    }
}
