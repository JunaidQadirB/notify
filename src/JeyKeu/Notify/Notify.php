<?php

namespace JeyKeu\Notify;

if (!defined('BASEPATH')) {
    exit('No direct script access allowed');
}

/**
 * Bootstrap3 Notification system for CodeIgniter
 *
 * @subpackage Libraries
 * @author Junaid Qadir Baloch <shekhanzai.baloch@gmail.com>
 */
class Notify
{

    private $CI;
    private $notifications;
    private $viewBase;

    public function __construct()
    {
        $this->CI = & get_instance();

        $this->CI->config->load('notification', FALSE, TRUE);
        $this->viewBase      = $this->CI->config->item('view_base');
        $this->CI->load->library('session');
        $this->CI->load->library('uri');
        $this->notifications = $this->CI->session->userdata('notifications');
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
    public function add($handle, $viewData = null, $type = 'alert', $isVolatile = false, $isDissmissable = TRUE, $excludePages = array())
    {
        if (empty($handle) || $this->handleExists($handle)) {
            return false;
        }

        if (is_array($this->notifications) && in_array($handle, $this->notifications)) {
            unset($this->notifications[$handle]);
        }

        $notificationView = (file_exists(APPPATH . "views/" . $this->viewBase . $handle . EXT)) ? $this->viewBase . $handle : $this->viewBase . 'notification_default_view';

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
        $this->CI->session->set_userdata('notifications', $this->notifications);
    }

    private function handleExists($handle)
    {
        if (!is_array($this->notifications)) {
            return false;
        }
        foreach ($this->notifications as $key => $value) {
            if ($value->handle == $handle) {
                return TRUE;
            }
        }

        return FALSE;
    }

    public function remove($handle)
    {
        foreach ($this->notifications as $key => $notification) {
            if ($notification->handle == $handle) {
                unset($this->notifications[$key]);
            }
        }

        $this->CI->session->set_userdata('notifications', $this->notifications);
    }

    /**
     *
     * @param string $message
     * @param string $type       message | alert |
     * @param bool   $canDismiss TRUE
     */
    private function show($message, $type = 'message', $canDismiss = TRUE)
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
                $typeClass = 'alert-success';
                break;
            case 'alert':
                $typeClass = 'alert-danger';
                break;
            default :
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
            if (is_array($notification->excludePages)) {
                $currentUrl = $this->CI->uri->rsegment_array(current_url());
                $exclude    = $this->isExcluded($notification, $currentUrl);
            }
            if ($exclude) {
                $exclude = false;
                break;
            }
            $message = $this->CI->load->view($notification->view, array('notificationContent' => $notification->viewData), TRUE);
            $messages .= $this->show($message, $notification->type, $notification->isDissmissable);
            if ($notification->isVolatile) {
                unset($this->notifications[$key]);
                $this->CI->session->set_userdata('notifications', $this->notifications);
            }
        }
        $messages .= "</div>";

        return $messages;
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

}
