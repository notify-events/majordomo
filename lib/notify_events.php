<?php 

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
function ne_send($content, $title = '', $priority = 'normal', $level = 'info', $files = [], $images = []) {
    require_once(DIR_MODULES . '/notify_events/notify_events.class.php');

    (new notify_events())->sendMessage($content, $title, $priority, $level, $files, $images);
}
