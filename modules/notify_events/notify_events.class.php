<?php

require_once(__DIR__ . '/lib/Message.php');

use notify_events\Message;

/**
 * Notify.Events
 * @package project
 * @author Notify.Events
 * @copyright https://notify.events
 * @version 0.1
 *
 * Class notify_events
 */
class notify_events extends module
{
    /**
     * notify_events
     *
     * Module class constructor
     *
     * @access private
     */
    function __construct()
    {
        $this->name            = 'notify_events';
        $this->title           = 'Notify.Events';
        $this->module_category = '<#LANG_SECTION_APPLICATIONS#>';

        $this->checkInstalled();
    }

    /**
     * saveParams
     *
     * Saving module parameters
     *
     * @access public
     */
    function saveParams($data = 1)
    {
        $p = array();

        if (isset($this->id)) {
            $p['id'] = $this->id;
        }

        if (isset($this->view_mode)) {
            $p['view_mode'] = $this->view_mode;
        }

        if (isset($this->edit_mode)) {
            $p['edit_mode'] = $this->edit_mode;
        }

        return parent::saveParams($p);
    }

    /**
     * getParams
     *
     * Getting module parameters from query string
     *
     * @access public
     */
    function getParams()
    {
        global $id;
        global $mode;
        global $view_mode;
        global $edit_mode;

        if (isset($id)) {
            $this->id = $id;
        }

        if (isset($mode)) {
            $this->mode = $mode;
        }

        if (isset($view_mode)) {
            $this->view_mode = $view_mode;
        }

        if (isset($edit_mode)) {
            $this->edit_mode = $edit_mode;
        }
    }

    /**
     * Run
     *
     * Description
     *
     * @access public
     */
    function run()
    {
        global $session;

        $out = array();

        if ($this->action == 'admin') {
            $this->admin($out);
        } else {
            $this->usual($out);
        }

        if (isset($this->owner->action)) {
            $out['PARENT_ACTION'] = $this->owner->action;
        }

        if (isset($this->owner->name)) {
            $out['PARENT_NAME'] = $this->owner->name;
        }

        $out['VIEW_MODE'] = $this->view_mode;
        $out['EDIT_MODE'] = $this->edit_mode;
        $out['MODE']      = $this->mode;
        $out['ACTION']    = $this->action;

        $this->data = $out;

        $parser = new parser(DIR_TEMPLATES . $this->name . '/' . $this->name . '.html', $this->data, $this);

        $this->result = $parser->result;
    }

    function alert($type, $message)
    {
        $_SESSION['NE_ALERT'] = [
            'type'    => $type,
            'message' => $message,
        ];
    }

    function renderAlert(&$out)
    {
        if (!array_key_exists('NE_ALERT', $_SESSION)) {
            return;
        }

        $out['ALERT']      = $_SESSION['NE_ALERT']['message'];
        $out['ALERT_TYPE'] = $_SESSION['NE_ALERT']['type'];

        unset($_SESSION['NE_ALERT']);
    }

    /**
     * BackEnd
     *
     * Module backend
     *
     * @access public
     */
    function admin(&$out)
    {
        global $ne_action;

        $this->getConfig();

        if ($ne_action == 'settings') {
            global $token, $level_enabled, $level_high, $level_normal, $level_low, $level_lowest;

            $this->config['TOKEN']         = $token;

            $this->config['LEVEL_ENABLED'] = (int)($level_enabled == 'on');

            $this->config['LEVEL_HIGH']   = (int)$level_high;
            $this->config['LEVEL_NORMAL'] = (int)$level_normal;
            $this->config['LEVEL_LOW']    = (int)$level_low;
            $this->config['LEVEL_LOWEST'] = (int)$level_lowest;

            $this->saveConfig();
            $this->alert('success', LANG_NE_ALERT_SAVE_SUCCESSFULLY);
            $this->redirect('?');
            return;
        }

        if ($ne_action == 'test') {
            global $message;

            $message = strip_tags($message);

            $this->sendMessage($message);

            $this->alert('success', LANG_NE_ALERT_SEND_SUCCESSFULLY);
            $this->redirect('?view_mode=test');
            return;
        }

        $out['TOKEN']         = $this->config['TOKEN'];

        $out['LEVEL_ENABLED'] = $this->config['LEVEL_ENABLED'] ?: 0;

        $out['LEVEL_HIGH']   = $this->config['LEVEL_HIGH']   ?: 0;
        $out['LEVEL_NORMAL'] = $this->config['LEVEL_NORMAL'] ?: 0;
        $out['LEVEL_LOW']    = $this->config['LEVEL_LOW']    ?: 0;
        $out['LEVEL_LOWEST'] = $this->config['LEVEL_LOWEST'] ?: 0;
        $out['LEVEL_MAX']    = getGlobal('minMsgLevel');

        $out['LEVEL_MAX_VALUE'] = getGlobal('minMsgLevel') - 1;

        $this->renderAlert($out);
    }

    /**
     * FrontEnd
     *
     * Module frontend
     *
     * @access public
     */
    function usual(&$out)
    {
        $this->admin($out);
    }

    /**
     * @throws ErrorException
     */
    function processSubscription($event, $details = '')
    {
        $this->getConfig();

        if (($event != 'SAY') || $this->config['DISABLED']) {
            return;
        }

        if ($this->config['LEVEL_ENABLED']) {
            $level = $details['level'];

            if ($level < $this->config['LEVEL_HIGH']) {
                $priority = Message::PRIORITY_HIGHEST;
            } elseif ($level < $this->config['LEVEL_NORMAL']) {
                $priority = Message::PRIORITY_HIGH;
            } elseif ($level < $this->config['LEVEL_LOW']) {
                $priority = Message::PRIORITY_NORMAL;
            } elseif ($level < $this->config['LEVEL_LOWEST']) {
                $priority = Message::PRIORITY_LOW;
            } else {
                $priority = Message::PRIORITY_LOWEST;
            }
        } else {
            $priority = Message::PRIORITY_NORMAL;
        }

        $message = strip_tags($details['message']);

        $this->sendMessage($message, '', $priority);
    }

    /**
     * Install
     *
     * Module installation routine
     *
     * @access private
     */
    function install($parent_name = "")
    {
        subscribeToEvent($this->name, 'SAY');

        parent::install($parent_name);
    }

    function uninstall()
    {
        unsubscribeFromEvent($this->name, 'SAY');

        parent::uninstall();
    }

    /**
     * @param string $content  - Message text (allow simple html-tags: <b>, <i>, <a>, <br>)
     * @param string $title    - Message title (for title support recipient)
     * @param string $priority - Message priority (lowest, low, normal, high, highest)
     * @param string $level    - Message level (verbose, info, notice, warning, error, success)
     * @param string[] $files  - File array (allow url, local file path or file content)
     * @param string[] $images - Image array (allow url, local file path or image content)
     * @throws ErrorException
     */
    function sendMessage($content, $title = '', $priority = Message::PRIORITY_NORMAL, $level = Message::LEVEL_INFO, $files = [], $images = [])
    {
        $this->getConfig();

        $message = new Message($content, $title, $priority, $level);

        foreach ($files as $file) {
            if (filter_var($file, FILTER_VALIDATE_URL)) {
                $message->addFileFromUrl($file);
            } elseif (file_exists($file)) {
                $message->addFile($file);
            } else {
                $message->addFileFromContent($file);
            }
        }

        foreach ($images as $image) {
            if (filter_var($image, FILTER_VALIDATE_URL)) {
                $message->addImageFromUrl($image);
            } elseif (file_exists($image)) {
                $message->addImage($image);
            } else {
                $message->addImageFromContent($image);
            }
        }

        $message->send($this->config['TOKEN']);
    }
}
