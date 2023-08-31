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
 * Library of functions for AI Instructional Designer.
 *
 * @package    local_aiid
 * @copyright  2015-2023 TNG Consulting Inc. - www.tngconsulting.ca
 * @author     Michael Milette
 * @license    https://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

/**
 * Outputs a message box.
 *
 * @param      string  $text     The text of the message.
 * @param      string  $heading  (optional) The text of the heading.
 * @param      int     $level    (optional) The level of importance of the
 *                               heading. Default: 2.
 * @param      string  $classes  (optional) A space-separated list of CSS
 *                               classes.
 * @param      string  $link     (optional) The link where you want the Continue
 *                               button to take the user. Only displays the
 *                               continue button if the link URL was specified.
 * @param      string  $id       (optional) An optional ID. Is applied to body
 *                               instead of heading if no heading.
 * @return     string  the HTML to output.
 */
function local_aiid_msgbox($text, $heading = null, $level = 2, $classes = null, $link = null, $id = null) {
    global $OUTPUT;
    echo $OUTPUT->box_start(trim('box ' . $classes));
    if (!is_null($heading)) {
        echo $OUTPUT->heading($heading, $level, $id);
        echo "<p>$text</p>" . PHP_EOL;
    } else {
        echo "<p id=\"$id\">$text</p>" . PHP_EOL;
    }
    if (!is_null($link)) {
        echo $OUTPUT->continue_button($link);
    }
    echo $OUTPUT->box_end();
}
