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
 * Add AI Instructional Designer to Site Administration > Courses > Courses.
 *
 * @package     local_aiid
 * @category    admin
 * @copyright   Copyright 2015-2023 TNG Consulting Inc. <www.tngconsulting.ca>
 * @license     https://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

defined('MOODLE_INTERNAL') || die();

function local_aiid_extend_settings_navigation($navigation, $context) {
    if (is_siteadmin()) {
        $navigation->add(get_string('pluginname', 'local_aiid'), new moodle_url('/local/aiid/'));
    }
}
