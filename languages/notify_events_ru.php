<?php

/**
 * Russian language for Notify.Events module
 */

$help = <<<HELP
<h3>Перед началом работы, вам необходимо:</h3>
<ul>
    <li>Зарегистрироваться в сервисе <a href="https://notify.events" target="_blank">Notify.Events</a>.</li>
    <li>Создать канал и добавить на него <a href="https://notify.events/source/68" target="_blank">источник MajorDoMo</a>.</li> 
    <li>На экране добавления источника на канал скопируйте ваш "токен".</li>
    <li>Указажите полученный токен в разделе "<a href="?mode_view=">Настройки</a>" данного модуля.</li> 
</ul>

<h3>Принцип работы</h3>
<p>
    Модуль Notify.Events обрабатывает сообщения, посылаемые через внутреннюю систему сообщений MajorDoMo.<br>
    В рамках обработки этих сообщений, доступна механика определения приоритета исходя из уровня сообщения (подробнее на вкладке "<a href="?mode_view=">Настройки</a>", "Поддержка приоритета сообщений"). 
</p>

<h3>Расширенный сценарий использования</h3>
<p>
    Так же вы можете отправлять сообщения в Notify.Events непосредственно из скриптов.<br>В таком сценарии использования, вам становятся
    доступны: поддержка базового форматирования текста, приоритеты и уровни сообщения, а так же возможность отправки файлов и изображений.
</p>
<pre>
ne_send(\$content, \$title = '', \$priority = 'normal', \$level = 'info', \$files = [], \$images = []);
</pre>
<table class="table table-bordered">
    <thead>
        <tr>
            <th>Параметр</th>
            <th>Обязательный</th>
            <th>Описание</th>
        </tr>
    </thead>
    <tbody>
        <tr>
            <td>content</td>
            <td>Да</td>
            <td>Текст сообщения (поддерживается базовое форматирование при помощи html-тегов: &lt;b&gt;, &lt;i&gt;, &lt;a&gt;, &lt;br&gt;)</td>
        </tr>
        <tr>
            <td>title</td>
            <td>Нет</td>
            <td>Заголовок сообщения (используется для получателей, поддерживающих заголовок, например: E-Mail)</td>
        </tr>
        <tr>
            <td>priority</td>
            <td>Нет</td>
            <td>Приоритет сообщения (допустимые значения: highest, high, normal, low, lowest)</td>
        </tr>
        <tr>
            <td>level</td>
            <td>Нет</td>
            <td>Уровень сообщения (допустимые значения: verbose, info, notice, warning, error, success)</td>
        </tr>
        <tr>
            <td>files</td>
            <td>Нет</td>
            <td>Файлы</td>
        </tr>
        <tr>
            <td>images</td>
            <td>Нет</td>
            <td>Изображения</td>
        </tr>
    </tbody>
</table>
<p>
    Для отправки файлов и изображений допустимы следующие варианты значений:
</p>
<ul>
    <li>URL файла/изображения (обязательно с указанием протокола http/https)</li>
    <li>Локальное имя файла</li>
    <li>Контент файла/изображения</li>
</ul>
<p>
    Пример:
</p>
<pre>
ne_send('Это &lt;b&gt;тестовое&lt;/b&gt; сообщение', 'Тест', 'lowest', 'info', [], ['https://example.com/image.png', '/opt/image.jpg']);
</pre>
HELP;

$dictionary = [
    // Tabs
    'NE_TAB_SETTINGS' => 'Настройки',
    'NE_TAB_TEST'     => 'Тестирование',
    'NE_TAB_HELP'     => 'Помощь',

    // Settings
    'NE_TOKEN'              => 'Токен',
    'NE_EVENT_SAY_ENABLED'  => 'Подписка на событие SAY',
    'NE_LEVEL_ENABLED'      => 'Поддержка приоритета сообщений',
    'NE_LEVEL_ENABLED_HELP' => '<p style="margin-bottom: 5px">Notify.Events позволяет вам использовать <b>приоритет</b> сообщения, в качестве фильтра для определения получателей этого сообщения.</p>'
        . '<p>Для того, чтобы воспользоваться этим функционалом, вам необходимо сначала установить соответствие <b>уровня</b> сообщения в MajorDoMo его <b>приоритету</b> в Notify.Events, воспользовавшись формой ниже.'
        . '<br>Например: "Незначительный" приоритет будет от 0 до 2 (0 &leq; N &lt; 2), "Низкий" - от 2 до 4 (2 &leq; N &lt; 4) и т.д.</p>'
        . '<p>Если "Уровень От" будет равен значению в поле "Уровень До", то указанный приоритет не будет использоваться.</p>',
    'NE_LEVEL_FROM'         => 'Уровень От',
    'NE_LEVEL_TO'           => 'Уровень До',
    'NE_PRIORITY'           => 'Приоритет',
    'NE_PRIORITY_LOWEST'    => 'Незначительный',
    'NE_PRIORITY_LOW'       => 'Низкий',
    'NE_PRIORITY_NORMAL'    => 'Средний',
    'NE_PRIORITY_HIGH'      => 'Высокий',
    'NE_PRIORITY_HIGHEST'   => 'Критичный',

    'NE_ACTION_SAVE' => 'Сохранить',

    'NE_ALERT_SAVE_SUCCESSFULLY' => 'Настройки успешно сохранены!',

    // Test
    'NE_MESSAGE' => 'Сообщение',

    'NE_ALERT_SEND_SUCCESSFULLY' => 'Тестовое сообщение успешно отправлено!',

    'NE_ACTION_SEND' => 'Отправить',

    // Help
    'NE_HELP' => $help,
];

foreach ($dictionary as $key => $value) {
    if (!defined('LANG_' . $key)) {
        @define('LANG_' . $key, $value);
    }
}
