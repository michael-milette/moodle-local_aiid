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
 * @copyright  2015-2023 TNG Consulting Inc. - www.tngconsulting.ca
 * @author     Michael Milette
 * @license    https://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

// Include config.php.
require_once(__DIR__ . '/../../config.php');
require_once($CFG->libdir . '/adminlib.php');

$pluginname = 'aiid';

// =============================
// Only administrators access.
// =============================

$homeurl = new moodle_url('/');
require_login();
if (!is_siteadmin()) {
    redirect($homeurl, "This feature is only available for site administrators.", 5);
}

// =============================
// Set up the page.
// =============================

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
$PAGE->set_heading($title);

// =============================
// Display the page
// =============================

// Include our function library.
require_once($CFG->dirroot.'/local/' . $pluginname . '/locallib.php');
// Include the form.
require_once($CFG->dirroot.'/local/' . $pluginname . '/classes/aiid_form.php');

$form = new aiid_form(new moodle_url('/local/aiid/'));

// If clicked cancel button.
if ($form->is_cancelled()) {
    // Redirect to home page.
    redirect($homeurl);
}

// Page header.
echo $OUTPUT->header();

if ($data = $form->get_data()) {
    // Form was submitted. Generate the course.
    // Include required library.
    require_once($CFG->dirroot.'/course/modlib.php');
    require($CFG->dirroot . '/local/aiid/create-course.php');
} else {
    // Display the form.
    echo $OUTPUT->heading($heading);
    $form->display();
}

// Page footer.
echo $OUTPUT->footer();
