# Notify.Events for MajorDoMo

Plugin for integrating your MajorDoMo with Notify.Events service for receiving notifications of various events.

#### Instruction on another languages

- [Русский](/README_RU.md)

# Usage instructions

To forward notifications from MajorDoMo to Notify.Events you need to:

- Add [MajorDoMo](https://notify.events/source/68) source to your Notify.Events channel and get your integration `token`.
- Install Notify.Events plugin to MajorDoMo:
  - Open MajorDoMo control panel.
  - Go to System -> Plugins market section.
  - Find Notify.Events plugin using search.
  - Click "Add".
- Open your Notify.Events module settings and put your `token` into the corresponding field.
- If necessary, enable the "Message priority support" option and configure the matching of message levels and priorities.

# How it works

The Notify.Events module processes messages sent through MajorDoMo internal messaging system.

As part of message processing, module determining the priority of message based on the MajorDoMo message level (more details on the module "Settings" tab, "Message priority support").

# Extended use case

You can also send messages to Notify.Events directly from scripts.

In this use case you would be able to: use basic html tags for text formatting, message's priority and level and also to send files and images.

For example:

```
ne_send($content, $title = '', $priority = 'normal', $level = 'info', $files = [], $images = []);
```

| Parameter | Required | Description |
|-----------|----------|-------------|
| content   | yes      | Message text (basic html formatting is allowed by using: `<b>`, `<i>`, `<a>`, `<br>` tags) |
| title     | no       | Message title (using for recipients that support titles, for example: E-Mail) |
| priority  | no       | Message priority (available values: `highest`, `high`, `normal`, `low`, `lowest`) |
| level     | no       | Message level (available values: `verbose`, `info`, `notice`, `warning`, `error`, `success`) |
| files     | no       | File attachments |
| images    | no       | Image attachments |

The following options are acceptable for sending files and images:
- File/Image URL (requires to define protocol http/https)
- Local file name
- File/Image content

For example:

```
ne_send('This is <b>test</b> message', 'Test', 'lowest', 'info', [], ['https://example.com/image.png', '/opt/image.jpg']);
```