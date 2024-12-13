<?php
/**
 * @author Shashakhmetov Talgat <talgatks@gmail.com>
 */

// Heading
$_['heading_title']             = 'Related HTML blocks';

$_['text_extension']            = 'Extensions';
$_['text_success']              = 'Related HTML blocks successfully changed!';
$_['text_add']                  = 'Add block';
$_['text_edit']                 = 'Edit block';
$_['text_add_module']           = 'Add module';
$_['text_edit_module']          = 'Edit module';
$_['text_list']                 = 'Blocks';
$_['text_modules']              = 'Modules';
$_['text_invert_selection']     = 'Invert selection';
$_['text_multiple']             = 'Group edit';

// Buttons
$_['button_modules']            = 'Modules';
$_['button_clone']              = 'Clone';

// Entry
$_['entry_name']                = 'Name';
$_['entry_code_block']          = 'Code of block';
$_['entry_code_module']         = 'Code of module';
$_['entry_code_module_desc']    = 'Here you can wrap output blocks in other code. To insert block content, use {{ content }}.';
$_['entry_file_name']           = 'Template file';
$_['entry_file_name_help']      = 'If left blank, it will not be used';
$_['entry_file_name_desc']      = 'The template file is also wrapper code. Specify the path to the file as a route. For example, extension/module/related_html. In the template file, you can use TWIG variables: <br>{{content}} - a string with the combined code of output blocks, <br>{{ htmls }} - an array with [html_id, code, sort_order] blocks.';
$_['entry_sort_order']          = 'Sort order';
$_['entry_status']              = 'Status';

// Widget
$_['entry_related_html']        = 'Related HTMLs';
$_['entry_related_html_help']   = 'You can show selected HTML blocks using module';

$_['column_name']               = 'Name';
$_['column_sort_order']         = 'Sort order';
$_['column_date_added']         = 'Date added';
$_['column_date_edited']        = 'Date modified';
$_['column_status']             = 'Status';
$_['column_action']             = 'Action';

// Interval datetime functions
$_['text_interval_days']                   = 'days';
$_['text_interval_hours']                  = 'hours';
$_['text_interval_minutes']                = 'minutes';
$_['text_interval_less_than_a_minute']     = 'less than a minute';
$_['text_interval_less_than_a_minute_ago'] = 'less than a minute ago';
$_['text_interval_2_minutes_ago']          = '2 minutes ago';
$_['text_interval_3_minutes_ago']          = '3 minutes ago';
$_['text_interval_4_minutes_ago']          = '4 minutes ago';
$_['text_interval_5_minutes_ago']          = '5 minutes ago';
$_['text_interval_minutes_ago']            = 'minutes ago';
$_['text_interval_1_hour_ago']             = '1 hour ago';
$_['text_interval_2_hour_ago']             = '2 hour ago';
$_['text_interval_3_hour_ago']             = '3 hour ago';
$_['text_interval_4_hour_ago']             = '4 hour ago';
$_['text_interval_today_in']               = 'today in';
$_['text_interval_yesterday_in']           = 'yesterday in';
$_['text_interval_right_now']              = 'right now';
$_['text_interval_in_2_minutes']           = 'in 2 minutes';
$_['text_interval_in_3_minutes']           = 'in 3 minutes';
$_['text_interval_in_4_minutes']           = 'in 4 minutes';
$_['text_interval_in_5_minutes']           = 'in 5 minutes';
$_['text_interval_in_minutes']             = 'in %d minutes';
$_['text_interval_in_an_hour']             = 'in an hour';
$_['text_interval_in_2_hours']             = 'in 2 hours';
$_['text_interval_in_3_hours']             = 'in 3 hours';
$_['text_interval_in_4_hours']             = 'in 4 hours';
$_['text_interval_today_at']               = 'today at';
$_['text_interval_tomorrow_at']            = 'tomorrow at';

// Error
$_['error_permission']          = 'Warning: You do not have permission to modify Related HTML blocks module!';
$_['error_check_form']          = 'Please check form for errors!';
$_['error_name']                = 'Name cannot be empty!';