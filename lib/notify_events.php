<?php 

require_once(DIR_MODULES . '/notify_events/notify_events.class.php');
require_once(DIR_MODULES . '/notify_events/lib/Message.php');

use notify_events\Message;

/**
 * Send Notify.Events message
 *
 * @param string   $content
 * @param string   $title
 * @param string   $priority
 * @param string   $level
 * @param string[] $files
 * @param string[] $images
 * @throws ErrorException
 */
function ne_send($content, $title = '', $priority = Message::PRIORITY_NORMAL, $level = Message::LEVEL_INFO, $files = [], $images = []) {
    (new notify_events())->sendMessage($content, $title, $priority, $level, $files, $images);
}
