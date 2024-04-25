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
 * Displays the form and processes the form submission.
 *
 * @package    local_aiid
 * @copyright  2015-2024 TNG Consulting Inc. - www.tngconsulting.ca
 * @author     Michael Milette
 * @license    https://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

// Include config.php.
require_once(__DIR__ . '/../../config.php');

// Include our function library.
$pluginname = 'aiid';
require_once($CFG->dirroot.'/local/' . $pluginname . '/locallib.php');

// Ensure only administrators have access.
$homeurl = new moodle_url('/');
require_login();
if (!is_siteadmin()) {
    redirect($homeurl, "This feature is only available for site administrators.", 5);
}

$title = get_string('pluginname', 'local_' . $pluginname);
$heading = get_string('heading', 'local_' . $pluginname);
$url = new moodle_url('/local/' . $pluginname . '/');
if ($CFG->branch >= 25) { // Moodle 2.5+.
    $context = context_system::instance();
} else {
    $context = get_system_context();
}

$PAGE->set_pagelayout('admin');
$PAGE->set_url($url);
$PAGE->set_context($context);
$PAGE->set_title($title);
$PAGE->set_heading($heading);
admin_externalpage_setup('local_' . $pluginname); // Sets the navbar & expands navmenu.

$form = new aiid_form(null, array('fromdefault' => $fromdefault));
if ($form->is_cancelled()) {
    redirect($homeurl);
}

echo $OUTPUT->header();

$data = $form->get_data();
if (!$data) { // Display the form.

    echo $OUTPUT->heading($heading);

    echo "Form goes here.";

    // example: $data->sender

    // Display the form. ============================================.
    $form->display();

} else {      // Generate course.

    echo "Generating the course...the code goes here";

}

// Footing  =========================================================.

echo $OUTPUT->footer();
