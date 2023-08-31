<?php
// This file is part of AI Instructional Designer for Moodle - https://moodle.org/
//
// AI Instructional Designer is free software: you can redistribute it and/or modify
// it under the terms of the GNU General Public License as published by
// the Free Software Foundation, either version 3 of the License, or
// (at your option) any later version.
//
// AI Instructional Designer is distributed in the hope that it will be useful,
// but WITHOUT ANY WARRANTY; without even the implied warranty of
// MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
// GNU General Public License for more details.
//
// You should have received a copy of the GNU General Public License
// along with AI Instructional Designer.  If not, see <https://www.gnu.org/licenses/>.

/**
 * Plugin administration pages are defined here.
 *
 * @package     local_aiid
 * @category    admin
 * @copyright   Copyright 2015-2023 TNG Consulting Inc. <www.tngconsulting.ca>
 * @license     https://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

defined('MOODLE_INTERNAL') || die();

if ($hassiteconfig) {
    // phpcs:ignore Generic.CodeAnalysis.EmptyStatement.DetectedIf
    $pluginname = get_string('pluginname', 'local_aiid');
    $ADMIN->add('courses', new admin_externalpage('local_aiid_generator',
            $pluginname,
            new moodle_url('/local/aiid/index.php')));

    $settings = new admin_settingpage('local_aiid', get_string('pluginname', 'local_aiid'));
    $ADMIN->add('localplugins', $settings);

    // OpenAI API key.
    $default = '';
    $name = 'local_aiid/openaiapikey';
    $title = get_string('openaiapikey', 'local_aiid');
    $description = get_string('openaiapikey_desc', 'local_aiid');
    $setting = new admin_setting_configtext($name, $title, $description, $default, PARAM_ALPHANUMEXT, 51);
    $setting->set_updatedcallback('theme_reset_all_caches');
    $settings->add($setting);

    // Name of AI.
    $default = 'AIID';
    $name = 'local_aiid/ainame';
    $title = get_string('ainame', 'local_aiid');
    $description = get_string('ainame_desc', 'local_aiid');
    $setting = new admin_setting_configtext($name, $title, $description, $default, PARAM_TEXT, 30);
    $setting->set_updatedcallback('theme_reset_all_caches');
    $settings->add($setting);

    // Large Language Model.
    $model_options = [
        'gpt-3.5-turbo-16k' => 'GPT-3.5 Turbo 16K',
        'gpt_4-16k' => 'GPT-4 16K'
    ];

    $default = 'gpt-4-16k';
    $name = 'local_aiid/model';
    $title = get_string('model', 'local_aiid');
    $description = get_string('model_desc', 'local_aiid');
    $setting = new admin_setting_configselect($name, $title, $description, $default, $model_options);
    $setting->set_updatedcallback('theme_reset_all_caches');
    $settings->add($setting);

    // Temperature.
    $temperature_options = [];
    for ($i = 0; $i <= 10; $i++) {
        $temperature = $i / 10;
        $temperature_options[(string)$temperature] = (string)number_format($temperature, 1);
    }
    $default = '0.5';
    $name = 'local_aiid/temperature';
    $title = get_string('temperature', 'local_aiid');
    $description = get_string('temperature_desc', 'local_aiid');
    $setting = new admin_setting_configselect($name, $title, $description, $default, $temperature_options);
    $setting->set_updatedcallback('theme_reset_all_caches');
    $settings->add($setting);

}
