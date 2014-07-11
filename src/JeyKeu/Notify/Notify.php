<?php namespace JeyKeu\Notify;

/**
 * Bootstrap3 Notification system for CodeIgniter
 *
 * @package Notify
 * @author Junaid Qadir Baloch <shekhanzai.baloch@gmail.com>
 */
use JeyKeu\Notify\Session\SessionInterface;
use JeyKeu\Notify\URI\URIInterface;
use JeyKeu\Notify\View\ViewInterface;
use JeyKeu\Notify\Session\NativeSession;
use JeyKeu\Notify\URI\NativeURI;
use JeyKeu\Notify\View\NativeView;

class Notify
{

    /**
     * The session driver used by Notify.
     *
     * @var SessionInterface
     */
    protected $session;

    /**
     * The uri driver used by Notify.
     *
     * @var URIInterface
     */
    protected $uri;

    /**
     * The view driver used by Notify.
     *
     * @var ViewInterface
     */
    protected $view;
    private $notifications = array();
    private $viewBase;

    public function __construct(SessionInterface $session = null, URIInterface $uri = null, View\ViewInterface $view = null)
    {
        $this->session       = $session ? : new NativeSession;
        $this->uri           = $uri? : new NativeURI;
        $this->view          = $view? : new NativeView();
//        $this->CI            = & get_instance();
//        $this->CI->config->load('notification', false, true);
        $this->viewBase      = "views/notify_views/";
//        $this->CI->load->library('session');
//        $this->CI->load->library('uri');
//        print_r($this->session);
        $this->notifications = $this->session->get('notifications');
//        die("dd");
    }

    private function handleExists($handle)
    {
        if (!is_array($this->notifications)) {
            return false;
        }
        foreach ($this->notifications as $key => $value) {
            if ($value->handle == $handle) {
                return true;
            }
        }

        return false;
    }

    private function isExcluded($notification, $currentUrl)
    {
        foreach ($notification->excludePages as $page) {
            if (in_array($page, $currentUrl)) {
                return true;
            }
        }

        return false;
    }

    /**
     *
     * @param string $message
     * @param string $type       message | alert |
     * @param bool   $canDismiss true
     */
    private function show($message, $type = 'message', $canDismiss = true)
    {
        $message      = html_entity_decode($message);
        $buttonDiv    = '';
        $dismissClass = '';
        if ($canDismiss) {
            $buttonDiv    = '<button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>';
            $dismissClass = 'alert-dismissable';
        }

        switch ($type) {
            case 'message':
            case 'success':
                $typeClass = 'alert-success';
                break;
            case 'info':
                $typeClass = 'alert-info';
                break;
            case 'warning':
                $typeClass = 'alert-warning';
                break;
            case 'alert':
            case 'danger':
                $typeClass = 'alert-danger';
                break;
            default:
                $typeClass = 'alert-success';
                break;
        }

        $message = <<<MSG
            <div class="alert {$typeClass} {$dismissClass}">
                {$buttonDiv}
                {$message}
            </div>

MSG;

        return $message;
    }

    /**
     * Queues notifications in the Notify's Notification system
     * @param string $handle         An easy-to-remember name for the notification.
     *                               Something like a slug in wordpress
     * @param string $viewData       Description
     * @param string $type           alert|message
     * @param bool   $isVolatile     if true, the notification will not appear if
     * @param bool   $isDissmissable If true, use can close the notification
     *                               the user navigates away or reloads the page.
     */
    public function add($handle, $viewData = null, $type = 'alert', $isVolatile = false, $isDissmissable = true, $excludePages = array())
    {
        if (empty($handle) || $this->handleExists($handle)) {
            return false;
        }

        if (is_array($this->notifications) && in_array($handle, $this->notifications)) {
            unset($this->notifications[$handle]);
        }
        $notificationView = (file_exists($this->viewBase . $handle . EXT)) ? $this->viewBase . $handle : $this->viewBase . 'notify_default_view';

        $notification          = (object) array(
                    'handle'         => $handle,
                    'view'           => $notificationView,
                    'viewData'       => $viewData,
                    'type'           => $type,
                    'isDissmissable' => $isDissmissable,
                    'isVolatile'     => $isVolatile,
                    'excludePages'   => $excludePages
        );
        $this->notifications[] = $notification;
        $this->session->put('notifications', $this->notifications);
    }

    public function remove($handle)
    {
        foreach ($this->notifications as $key => $notification) {
            if ($notification->handle == $handle) {
                unset($this->notifications[$key]);
            }
        }

        $this->session->put('notifications', $this->notifications);
    }

    public function removeAll()
    {
        foreach ($this->notifications as $key => $notification) {
            unset($this->notifications[$key]);
        }
        $this->session->put('notifications', $this->notifications);
    }

    /**
     *
     * @return mixed
     */
    public function processQueue()
    {
        $messages = '<div class="notification-wrapper col col-lg-4 col-lg-offset-2 stickyTop">';
        if (!is_array($this->notifications) || (is_array($this->notifications) && sizeof($this->notifications) < 1)) {
            return false;
        }

        foreach ($this->notifications as $key => $notification) {
            if (is_array($notification->excludePages) && sizeof($notification->excludePages > 0)) {
                $currentUrl = $this->uri->getLastSegment();
                print_r($currentUrl);
                $exclude    = $this->isExcluded($notification, $currentUrl);
            }
            if ($exclude) {
                $exclude = false;
                break;
            }
            $message = $this->view->load($notification->view, array('notificationContent' => $notification->viewData), true);
            $messages .= $this->show($message, $notification->type, $notification->isDissmissable);
            if ($notification->isVolatile) {
                unset($this->notifications[$key]);
                $this->session->put('notifications', $this->notifications);
            }
        }
        $messages .= "</div>";

        return $messages;
    }
}
