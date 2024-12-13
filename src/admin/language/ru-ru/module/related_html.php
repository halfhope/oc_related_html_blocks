<?php
/**
 * @author Shashakhmetov Talgat <talgatks@gmail.com>
 */

// Heading
$_['heading_title']             = 'Связанные HTML блоки';

$_['text_extension']            = 'Расширения';
$_['text_success']              = 'Настройки связанных HTML блоков успешно изменены!';
$_['text_add']                  = 'Добавление блока';
$_['text_edit']                 = 'Редактирование блока';
$_['text_add_module']           = 'Добавление модуля';
$_['text_edit_module']          = 'Редактирование модуля';
$_['text_list']                 = 'Блоки';
$_['text_modules']              = 'Модули';
$_['text_invert_selection']     = 'Инвертировать выделение';
$_['text_multiple']             = 'Групповое редактирование';

// Buttons
$_['button_modules']            = 'Модули';
$_['button_layouts']            = 'Макеты';
$_['button_clone']              = 'Клонировать';

// Entry
$_['entry_name']                = 'Название';
$_['entry_code_block']          = 'Код блока';
$_['entry_code_module']         = 'Код-обертка для блоков';
$_['entry_code_module_desc']    = 'Здесь вы можете обернуть выводимые блоки в другой код. Для вставки содержимого блоков используйте {{ content }}.';
$_['entry_file_name']           = 'Файл шаблона';
$_['entry_file_name_help']      = 'Если оставить пустым, не будет учтено';
$_['entry_file_name_desc']      = 'Файл шаблона это тоже код-обертка. Указывайте в путь к файлу в виде роута. Например, extension/module/related_html. В файле шаблона можно использовать TWIG переменные: <br>{{content}} - строка с объединенным кодом выводимых блоков, <br>{{ htmls }} - массив с блоками [html_id, code, sort_order].';
$_['entry_sort_order']          = 'Порядок сортировки';
$_['entry_status']              = 'Статус';

// Widget
$_['entry_related_html']       = 'Связанные HTML';
$_['entry_related_html_help']  = 'Выбранные HTML блоки можно будет вывести с помощью модуля';

$_['column_name']               = 'Название';
$_['column_sort_order']         = 'Порядок сортировки';
$_['column_date_added']         = 'Дата добавления';
$_['column_date_edited']        = 'Дата редактирования';
$_['column_status']             = 'Статус';
$_['column_action']             = 'Действия';

// Interval datetime functions
$_['text_interval_days']                   = 'дни';
$_['text_interval_hours']                  = 'часы';
$_['text_interval_minutes']                = 'минуты';
$_['text_interval_less_than_a_minute']     = 'менее минуты';
$_['text_interval_less_than_a_minute_ago'] = 'менее минуты назад';
$_['text_interval_2_minutes_ago']          = '2 минуты назад';
$_['text_interval_3_minutes_ago']          = '3 минуты назад';
$_['text_interval_4_minutes_ago']          = '4 минуты назад';
$_['text_interval_5_minutes_ago']          = '5 минут назад';
$_['text_interval_minutes_ago']            = 'минут назад';
$_['text_interval_1_hour_ago']             = '1 час назад';
$_['text_interval_2_hour_ago']             = '2 часа назад';
$_['text_interval_3_hour_ago']             = '3 часа назад';
$_['text_interval_4_hour_ago']             = '4 часа назад';
$_['text_interval_today_in']               = 'сегодня в';
$_['text_interval_yesterday_in']           = 'вчера в';
$_['text_interval_right_now']              = 'только что';
$_['text_interval_in_2_minutes']           = 'в течении 2-х минут';
$_['text_interval_in_3_minutes']           = 'в течении 3-х минут';
$_['text_interval_in_4_minutes']           = 'в течении 4-х минут';
$_['text_interval_in_5_minutes']           = 'в течении 5-и минут';
$_['text_interval_in_minutes']             = 'в течении %d минут';
$_['text_interval_in_an_hour']             = 'в течении часа';
$_['text_interval_in_2_hours']             = 'в течении 2-х часов';
$_['text_interval_in_3_hours']             = 'в течении 3-х часов';
$_['text_interval_in_4_hours']             = 'в течении 4-х часов';
$_['text_interval_today_at']               = 'сегодня в';
$_['text_interval_tomorrow_at']            = 'завтра в';

// Error
$_['error_permission']          = 'У вас недостаточно прав для внесения изменений!';
$_['error_check_form']          = 'Пожалуйста, проверьте форму на ошибки!';
$_['error_name']                = 'Название блока не может быть пустым!';