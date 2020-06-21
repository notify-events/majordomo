<?php

/**
 * English language for Notify.Events module
 */

$help = <<<HELP
<h3>Before start you need to:</h3>
<ul>
    <li>Sign-up to <a href="https://notify.events" target="_blank">Notify.Events</a> service.</li>
    <li>Create a channel and add the <a href="https://notify.events/source/68" target="_blank">MajorDoMo source</a>.</li> 
    <li>On the adding source screen, copy your "token".</li>
    <li>Put this token into the "<a href="?mode_view=">module settings</a>".</li> 
</ul>

<h3>How it works</h3>
<p>
    The Notify.Events module processes messages sent through MajorDoMo internal messaging system.<br>
    As part of message processing, module determining the priority of message based on the MajorDoMo message level (more details on the "<a href="?mode_view=">Settings</a>" tab, "Message priority support").
</p>

<h3>Extended use case</h3>
<p>
    You can also send messages to Notify.Events directly from scripts.<br>In this use case you would be able to: 
    use basic html tags for text formatting, message's priority and level and also to send files and images.
</p>
<pre>
ne_send(\$content, \$title = '', \$priority = 'normal', \$level = 'info', \$files = [], \$images = []);
</pre>
<table class="table table-bordered">
    <thead>
        <tr>
            <th>Parameter</th>
            <th>Required</th>
            <th>Description</th>
        </tr>
    </thead>
    <tbody>
        <tr>
            <td>content</td>
            <td>Yes</td>
            <td>Message text (basic html formatting is allowed by using &lt;b&gt;, &lt;i&gt;, &lt;a&gt; and &lt;br&gt; tags)</td>
        </tr>
        <tr>
            <td>title</td>
            <td>No</td>
            <td>Message title (using for recipients that support titles, for example: E-Mail)</td>
        </tr>
        <tr>
            <td>priority</td>
            <td>No</td>
            <td>Message priority (available values: highest, high, normal, low, lowest)</td>
        </tr>
        <tr>
            <td>level</td>
            <td>No</td>
            <td>Message level (available values: verbose, info, notice, warning, error, success)</td>
        </tr>
        <tr>
            <td>files</td>
            <td>No</td>
            <td>File attachments</td>
        </tr>
        <tr>
            <td>images</td>
            <td>No</td>
            <td>Image attachments</td>
        </tr>
    </tbody>
</table>
<p>
    The following options are acceptable for sending files and images:
</p>
<ul>
    <li>File/Image URL (requires to define protocol http/https)</li>
    <li>Local file name</li>
    <li>File/Image content</li>
</ul>
<p>
    For example:
</p>
<pre>
ne_send('This is <b>test</b> message', 'Test', 'lowest', 'info', [], ['https://example.com/image.png', '/opt/image.jpg']);
</pre>
HELP;

$dictionary = [
    // Tabs
    'NE_TAB_SETTINGS' => 'Settings',
    'NE_TAB_TEST'     => 'Testing',
    'NE_TAB_HELP'     => 'Help',

    // Settings
    'NE_TOKEN'              => 'Token',
    'NE_LEVEL_ENABLED'      => 'Message priority support',
    'NE_LEVEL_ENABLED_HELP' => '<p style="margin-bottom: 5px">Notify.Events allows you to use the message <b>priority</b> as a filter to determine the recipients of this message on it\'s side.'
        . '<br>To use this functionality, at first you need to define dependency of MajorDoMo message <b>level</b> to Notify.Events message <b>priority</b>, using the form below.</p>'
        . '<ul style="margin-bottom: 5px; padding-left: 25px;">'
        . '<li>The leftmost <b>level</b> value (0) - the highest <b>priority</b>.</li>'
        . '<li>The rightmost <b>level</b> value (equivalent to the value of the minMsgLevel variable) - the lowest <b>priority</b>.</li>'
        . '</ul>'
        . '<p>Set the level ranges according to your vision so that they correspond to the priorities you need.'
        . '<br>For example: Critical priority might be from 0 to 2 (0 <= N < 2), high priority - from 2 to 4 (2 <= N < 4) etc.</p>',
    'NE_LEVEL'              => 'Level',
    'NE_PRIORITY'           => 'Priority',
    'NE_PRIORITY_LOWEST'    => 'Lowest',
    'NE_PRIORITY_LOW'       => 'Low',
    'NE_PRIORITY_NORMAL'    => 'Normal',
    'NE_PRIORITY_HIGH'      => 'High',
    'NE_PRIORITY_HIGHEST'   => 'Highest',

    'NE_ACTION_SAVE' => 'Save',

    'NE_ALERT_SAVE_SUCCESSFULLY' => 'Settings saved successfully!',

    // Test
    'NE_MESSAGE' => 'Message',

    'NE_ALERT_SEND_SUCCESSFULLY' => 'Test message sent successfully!',

    'NE_ACTION_SEND' => 'Send',

    // Help
    'NE_HELP' => $help,
];

foreach ($dictionary as $key => $value) {
    if (!defined('LANG_' . $key)) {
        @define('LANG_' . $key, $value);
    }
}
