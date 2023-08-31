<?php
// This file is part of AI Instructional Designer for Moodle - http://moodle.org/
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
// along with AI Instructional Designer.  If not, see <http://www.gnu.org/licenses/>.

/**
 * Main form for eaiid.
 *
 * @package    local_aiid
 * @copyright  2015-2023 TNG Consulting Inc. - www.tngcosulting.ca
 * @author     Michael Milette
 * @license    https://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

defined('MOODLE_INTERNAL') || die;

require_once($CFG->libdir . '/formslib.php');

/**
 * Form to prompt administrator course information.
 * @copyright  2015-2023 TNG Consulting Inc. - www.tngcosulting.ca
 * @license    https://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */
class aiid_form extends moodleform {
    protected function definition() {
        $mform = $this->_form;

        // Header.

        $mform->addElement('html', '<p>' . get_string('pluginname_desc', 'local_aiid') . '</p>');

        $options = array();
        for ($i = 1; $i <= 13; $i++) {
            $grade = get_string('grade', 'local_aiid', $i);
            $options[$grade] = $grade;
        }
        $options['college'] = get_string('college', 'local_aiid');
        $options['university'] = get_string('university', 'local_aiid');
        $options['professional'] = get_string('professional', 'local_aiid');
        $options['women'] = get_string('women', 'local_aiid');
        $options['men'] = get_string('men', 'local_aiid');
        $mform->addElement('select', 'target_audience', get_string('target_audience', 'local_aiid'), $options);
        $mform->addRule('target_audience', get_string('required'), 'required', null, 'server');
        $mform->setDefault('target_audience', 'professional');

        $mform->addElement('textarea', 'course_description', get_string('course_description', 'local_aiid'));
        $mform->addRule('course_description', get_string('required'), 'required', null, 'server');
        $mform->setType('course_description', PARAM_TEXT);

        $mform->addElement('textarea', 'course_description', get_string('course_description', 'local_aiid'));
        $mform->addRule('course_description', get_string('required'), 'required', null, 'server');
        $mform->setType('course_objective', PARAM_TEXT);

        $options = array();
        for ($i = 1; $i <= 15; $i++) {
            $options[$i] = $i;
        }
        $mform->addElement('select', 'num_topics_weeks', get_string('num_topics_weeks', 'local_aiid'), $options);

        $radiooptions = array(
            0 => get_string('no', 'local_aiid'),
            1 => get_string('after_section', 'local_aiid'),
            2 => get_string('after_course', 'local_aiid'),
            3 => get_string('after_section_and_course', 'local_aiid')
        );
        $attributes = '';

        // Include discussion forum.
        $radioarray = [];
        foreach($radiooptions as $value => $label) {
            $radioarray[] = $mform->createElement('radio', 'include_forum', '', $label, $value, $attributes);
        }
        $mform->addGroup($radioarray, 'radioar', get_string('include_forum', 'local_aiid'), array(' '), false);
        $mform->setDefault('include_forum', 0);

        // Include assignment.
        $radioarray = [];
        foreach($radiooptions as $value => $label) {
            $radioarray[] = $mform->createElement('radio', 'include_assignment', '', $label, $value, $attributes);
        }
        $mform->addGroup($radioarray, 'radioar', get_string('include_assignment', 'local_aiid'), array(' '), false);
        $mform->setDefault('include_assignment', 0);

        // Include quiz.
        $radioarray = [];
        foreach($radiooptions as $value => $label) {
            $radioarray[] = $mform->createElement('radio', 'include_quiz', '', $label, $value, $attributes);
        }
        $mform->addGroup($radioarray, 'radioar', get_string('include_quiz', 'local_aiid'), array(' '), false);
        $mform->setDefault('include_quiz', 0);


        // Save / Cancel buttons.
        $this->add_action_buttons();
    }
}
