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
 * Plugin strings are defined here.
 *
 * @package     local_aiid
 * @category    string
 * @copyright   Copyright 2015-2023 TNG Consulting Inc. <www.tngconsulting.ca>
 * @license     https://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

defined('MOODLE_INTERNAL') || die();

$string['pluginname'] = 'AI Instructional Designer';
$string['pluginname_desc'] = 'Enter information below and then click Generate to create a new course using AI provided information.</p>';

// Settings

$string['openaiapikey'] = 'OpenAI API Key';
$string['openaiapikey_desc'] = 'Enter your OpenAI API key (51 characters).';
$string['ainame'] = 'Name of the AI';
$string['ainame_desc'] = 'Enter the name of the AI (maximum 30 characters).';
$string['model'] = 'Model';
$string['model_desc'] = 'Select the AI model to use.';
$string['temperature'] = 'Temperature';
$string['temperature_desc'] = 'Select the temperature value (0.0 - 1.0).';

// Main form.

$string['heading'] = 'Settings to generate a new course';
$string['target_audience'] = 'Level of Target Audience';
$string['course_description'] = 'Course Description';
$string['course_objective'] = 'Course Objective';
$string['num_topics_weeks'] = 'Number of Topics or Weeks';
$string['include_quiz'] = 'Include a quiz';
$string['include_assignment'] = 'Include an assignment';
$string['include_forum'] = 'Include a discussion forum';
$string['college'] = 'College';
$string['university'] = 'University';
$string['professional'] = 'Professional development';
$string['women'] = 'Women only';
$string['men'] = 'Men only';
$string['no'] = 'No';
$string['after_section'] = 'After each section';
$string['after_course'] = 'After whole course';
$string['after_section_and_course'] = 'After each section and whole course';
$string['grade'] = 'Grade {$a}';
