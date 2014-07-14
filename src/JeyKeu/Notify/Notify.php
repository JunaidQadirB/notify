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
        $this->viewBase      = "views/notify_views/";
        $this->notifications = $this->session->get('notifications');
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

    private function isExcluded($notification, $page)
    {
        if (in_array($page, $notification->excludePages)) {
            return true;
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
     * @param string $handle         An easy-to-remember name for 
     *                               the notification.
     *                               Something like a slug in wordpress
     * @param string $viewData       view or text to be displayedon the 
     *                               notification
     * @param string $type           alert|message
     * @param bool   $isVolatile     if true, the notification will not appear
     *                               if the user navigates away or reloads the page.
     * @param bool   $isDissmissable If true, user can close the notification
     *                                  
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
        $this->session->set('notifications', $this->notifications);
    }

    /**
     * Reomve a single notification as specied by the $handle param.
     * @param string $handle
     */
    public function remove($handle)
    {
        foreach ($this->notifications as $key => $notification) {
            if ($notification->handle == $handle) {
                unset($this->notifications[$key]);
            }
        }

        $this->session->set('notifications', $this->notifications);
    }

    /**
     * Remove all the notifications
     */
    public function removeAll()
    {
        foreach ($this->notifications as $key => $notification) {
            unset($this->notifications[$key]);
        }
        $this->session->set('notifications', $this->notifications);
    }

    /**
     * Generates HTML and displays the notification(s).
     * @return mixed
     */
    public function render()
    {
        $messages = '<div class="notification-wrapper col col-lg-4 col-lg-offset-2 stickyTop">';
        if (!is_array($this->notifications) || (is_array($this->notifications) && sizeof($this->notifications) < 1)) {
            return false;
        }

        foreach ($this->notifications as $key => $notification) {
            if (is_array($notification->excludePages) && sizeof($notification->excludePages > 0)) {
                $currentPage = $this->uri->getLastSegment();
                $exclude     = $this->isExcluded($notification, $currentPage);
            }
            if ($exclude) {
                $exclude = false;
                break;
            }
            $message = $this->view->load($notification->view, array('notificationContent' => $notification->viewData), true);
            $messages .= $this->show($message, $notification->type, $notification->isDissmissable);
            if ($notification->isVolatile) {
                unset($this->notifications[$key]);
                $this->session->set('notifications', $this->notifications);
            }
        }
        $messages .= "</div>";

        return $messages;
    }
}
