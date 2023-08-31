<?php
// Include required library
require_once($CFG->dirroot.'/course/modlib.php');

// Read the JSON input
$json = file_get_contents($CFG->dirroot . '/local/aiid/course.json');
$data = json_decode($json, true);

// Connect to the Moodle using moodle API

$sectionnum = 0;

// Create the course.
$course = createCourse($data['courseName'], $data['shortCourseName'], $data['courseDescription']);

// Create the introduction label.
createLabelActivity($course, $sectionnum, $data['courseIntroduction']);

// Create the glossary
createGlossary($course, $sectionnum, 'Glossary of terms', '<p>This glossary contains the terms associated with this course. Make sure you are familiar these and their meanings before taking the quiz.</p>', $data['courseGlossary']);

// Create a new section for the course content.
//$sectionnum = createCourseSection($course, 'Course content', '');

// Create the course content as a Book. If there is only one page, use a Page instead.
if (count($data['topicContent'])) {
    // Create a Book. For each chapter, populate the content.
    createBookActivity($course, $sectionnum, 'HOW TO: ' . $data['courseName'], 'Open your mind to new ideas.', $data['topicContent']);
} else {
    // Create a Page.
    foreach ($data['topicContent'] as $topic) {
        createPageActivity($course, $sectionnum, $topic['topic'], $topic['description'], $topic['content']);
    }
}

// Add quiz questions (if any)
if (!empty($data['quizQuestions'])) {
    createQuizActivity($course, $sectionnum, 'Quiz', 'Test your knowledge.', $data['quizQuestions']);
}

// Create a new section for the course Completion.
// $sectionnum = createCourseSection($course, 'Completion', $summary = '');
// }


// Add feedback questions (if any)
if (!empty($data['feedbackQuestions'])) {
    createFeedbackActivity($course, $sectionnum, 'Feedback', 'We are always trying to make improvements. Please share your thoughts on this course.', $data['feedbackQuestions']);
}

// Create the conclusion page.
//$conclusionPage = createPageActivity($course, $sectionnum, 'Conclusion', 'You have reached the end of the course.', $data['conclusionPage']);

// Done!
echo '<p>Your course was generated successfully.</p>' . PHP_EOL;
echo '<H3><strong>Important</strong></H3>';
echo '<p>AI-generated information can contain errors. It is therefore highly recommended that the following tests are completed by the following people:</p>';
echo '<ol>';
echo '<li><strong>Course creator</strong> (that\'s you!): Check the complete course yourself in order to ensure that it is 100% functional and is not missing any information, graphics or other media.</li>';
echo '<li><strong>Subject matter expert</strong>: Makes sure everything is accurate and makes sense.</li>';
echo '<li><strong>Learner</strong>: This is one to 10 people who know nothing about the subject but represent your target audience. Have them complete the course to make sure that they understand everything and that they have acquired new knowledge as described in the objectives.</li>';
echo '</ol>';
echo '<p>Fix any issues, errors, inaccuracies, or things that leave test learners confused instead of enlightened.</p>';
echo '<p><a href="/moodle401/course/view.php?id=' . $course->id . '" target="_blank" class="btn btn-primary">Take me to my new course</a></p>' . PHP_EOL;

// Output the page footer.
echo $OUTPUT->footer();

function newmodule($modulename, $courseid, $sectionnum, $title, $description = '', $visibility = 1) {
    global $DB;
    $moduleinfo = new \stdClass();
    $moduleinfo->modulename = $modulename;
    $moduleinfo->module = $DB->get_field('modules', 'id', ['name' => $moduleinfo->modulename]);
    $moduleinfo->course = $courseid;
    $moduleinfo->section = $sectionnum;
    $moduleinfo->name = $title;
    $moduleinfo->introeditor = array('text' => $description, 'format' => FORMAT_HTML, 'itemid' => NULL);
    $moduleinfo->showdescription = 0;
    $moduleinfo->visible = $visibility;
    $moduleinfo->visibleoncoursepage = 1;
    $moduleinfo->downloadcontent = 0;
    $moduleinfo->instance = 0;
    $moduleinfo->timecreated = time();
    $moduleinfo->timemodified = $moduleinfo->timecreated;

    return $moduleinfo;
}

// Function to check if a course with the given shortname already exists.
function courseExists($shortname) {
    global $DB;
    return $DB->record_exists('course', array('shortname' => $shortname));
}

// Function to create a new course in Moodle.
function createCourse($fullname, $shortname, $summary) {
    echo '<p>Creating the course...</p>' . PHP_EOL;

    $newCourse = new stdClass();
    $newCourse->fullname = $fullname;
    while (courseExists($shortname)) {
        $shortname = $shortname . ' ' . time();
    }
    $newCourse->shortname = $shortname;
    $newCourse->format = 'topics'; // Set the course format to Topics format.
    $newCourse->summary = $summary;
    $newCourse->startdate = time() + 86400; // Set the course start date to tomorrow.
    $newCourse->category = 1; // Set the course category ID here.
    $newCourse->visible = get_config('moodle', 'course:visibility'); // Set the course visibility to site default.
    $course = create_course($newCourse);
    return $course;
}

// Function to create a new course section in a course.
function createCourseSection($course, $title = '', $summary = '') {
    global $DB;

    echo '<p>Adding a new course section...</p>' . PHP_EOL;

    // Create the new section
    $section = course_create_section($course->id, 0);
    $section->name = $title;
    $section->summary = $summary;
    $section->summaryformat = FORMAT_HTML;
    $section->timemodified = time();
    $DB->update_record('course_sections', $section);

    return $section->section; // New section number.
}

// Function to create a new label in a Moodle course.
function createLabelActivity($course, $sectionnum, $content) {
    global $DB;

    echo '<p>Adding a label resource...</p>' . PHP_EOL;

    // Create a new label object.
    $moduleinfo = newmodule('label', $course->id, $sectionnum, '', $content);
    $moduleinfo->coursemodule = $moduleinfo->module;

    // Add the label to the course's General section using Moodle API.
    add_moduleinfo($moduleinfo, $course);
    return $moduleinfo->module; // Return the label ID.
}

// Function to create a new page in a Moodle course.
function createPageActivity($course, $sectionnum, $title, $description, $content) {
    global $DB;

    echo '<p>Adding a page resource: ' . $title . '...</p>' . PHP_EOL;

    $moduleinfo = newmodule('page', $course->id, $sectionnum, $title, $description);
    $moduleinfo->content = $content;
    $moduleinfo->contentformat = FORMAT_HTML;
    $moduleinfo->display = 5;
    $moduleinfo->printintro = 1;
    $moduleinfo->printlastmodified = 1;

    // Add the page module to the course.
    $moduleinfo = add_moduleinfo($moduleinfo, $course);
    return $moduleinfo->id; // Return the page ID.
}

// Function to create a glossary in Moodle
function createGlossary($course, $sectionnum, $title, $description, $glossaryData) {
    global $DB, $CFG;
    require_once($CFG->dirroot . '/mod/glossary/lib.php');

    echo '<p>Adding a glossary: ' . $title . '...</p>' . PHP_EOL;

    $moduleinfo = newmodule('glossary', $course->id, $sectionnum, $title, $description);
    $moduleinfo->displayformat = 'dictionary';
    $moduleinfo->cmidnumber = '';
    $moduleinfo->assessed = 0;

    // Add the glossary module to the course.
    $moduleinfo = add_moduleinfo($moduleinfo, $course);
    $glossaryID = $moduleinfo->id;

    // Add the glossary to the course section
    foreach ($glossaryData as $term) {
        $entry = new stdClass();
        $entry->glossaryid = $glossaryID;
        $entry->timecreated = time();
        $entry->userid = 0;
        $entry->sourceglossaryid = 0;
        $entry->concept = $term['term'];
        $entry->definition = $term['definition'];
        $entry->definitionformat = FORMAT_HTML;
        $entry->definitiontrust = 0;
        $entry->timemodified = time();
        $entry->approved = 1;
        $entry->usedynamiclink = 1;
        $entry->casesensitive = 0;
        $entry->fullmatch = 0;
        $DB->insert_record('glossary_entries', $entry);
    }
    return $glossaryID;
}

// Function to create a quiz in Moodle.
// TODO: multichoice works but displays errors when viewed.
function createQuizActivity($course, $sectionnum, $title, $description, $questions) {
    global $DB, $USER;

    echo '<p>Adding a quiz activity: ' . $title . '...</p>' . PHP_EOL;

    // Create a new quiz activity.
    $moduleinfo = newmodule('quiz', $course->id, $sectionnum, $title, $description);
    $moduleinfo->quizpassword = '';
    $moduleinfo->timeopen = time();
    $moduleinfo->timeclose = time() + 86400;
    $moduleinfo->timelimit = 0;
    $moduleinfo->attempts = 1;
    $moduleinfo->grademethod = 1;
    $moduleinfo->questionsperpage = 0;
    $moduleinfo->sumgrades = 0;
    $moduleinfo->grade = 0;
    $moduleinfo->questiondecimalpoints = 0;
    $moduleinfo->shuffleanswers = 1;
    $moduleinfo->preferredbehaviour = 'deferredfeedback';
    $moduleinfo->correctnessimmediately = 1;

    // Create the quiz activity module.
    $moduleinfo = add_moduleinfo($moduleinfo, $course);
    $moduleinfo->cmid = get_coursemodule_from_instance('quiz', $moduleinfo->instance, $course->id)->id;
    $quizID = $moduleinfo->id;

    // Set the question category
    // $categoryid = 0; // The ID of the question category
    // $categorycontextid = $DB->get_field('context', 'id', array('contextlevel' => CONTEXT_COURSE, 'instanceid' => $course->id));
    // $categoryrowid = $DB->get_field('question_categories', 'id', array('contextid' => $categorycontextid, 'id' => $categoryid));
    // if (!$categoryrowid) {
    //     throw new moodle_exception('error', '', '', null, "Invalid category ID: {$categoryid}");
    // }
    // Get the course context
    $context = context_course::instance($course->id);
    // Create a new question category
    $category = question_make_default_categories(array($context));
    // Get the ID of the new category
    $categoryid = $category->id;

    // Add the questions to the quiz
    $qnum = 1;
    foreach ($questions as $questiondata) {
        // Create a new question
        $question = new stdClass();
        $question->qtype = $questiondata['type'];
        $question->name = "Q$$qnum";
        $question->questiontext = $questiondata['question'];
        $question->questiontextformat = FORMAT_HTML;
        $question->generalfeedback = '';
        $question->generalfeedbackformat = FORMAT_HTML;
        $question->defaultmark = 1;
        $question->length = 1;
        $question->penalty = 0.3333333;
        $question->hidden = 0;
        $question->timecreated = time();
        $question->timemodified = time();
        $question->createdby = $USER->id;
        $question->modifiedby = $USER->id;
        $question->category = $categoryid;

        // Create the question options and answers
        switch ($questiondata['type']) {
            case 'multichoice':
                // Create the question options
                $options = new stdClass();
                $options->single = 1; // Only one answer allowed (set to 0 for multiple answers)
                $options->shuffleanswers = 1;
                $options->answernumbering = 'abc';
                $options->showstandardinstruction = 1;
                $options->correctfeedback = 'Your answer is correct.';
                $options->correctfeedbackformat = FORMAT_HTML;
                $options->partiallycorrectfeedback = 'Your answer is partially correct.';
                $options->partiallycorrectfeedbackformat = FORMAT_HTML;
                $options->incorrectfeedback = 'Your answer is incorrect.';
                $options->incorrectfeedbackformat = FORMAT_HTML;
                $options->shownumcorrect = 0;

                // Set the question answers
                $answers = array();
                foreach ($questiondata['options'] as $key => $answerdata) {
                    $answers[] = ['text' => $answerdata, 'format' => FORMAT_HTML];
                    $fractions[] = ($key == ($questiondata['correctAnswer'] - 1) ? '1.0' : '0.0');
                    $feedbacks[] = ['text' => '', 'format' => FORMAT_HTML];
                }
                // Save the multichoice question
                $question = question_bank::get_qtype($question->qtype)->save_question($question, (object) array(
                    'name' => '',
                    'category' => $categoryid,
                    'questiontext' => array(
                        'text' => $questiondata['question'],
                        'format' => FORMAT_HTML
                    ),
                    'answer' => $answers,
                    'single' => $options->single,
                    'shuffleanswers' => $options->shuffleanswers,
                    'answernumbering' => $options->answernumbering,
                    'noanswers' => count($answers),
                    'correctfeedback' => array(
                        'text' => $options->correctfeedback,
                        'format' => $options->correctfeedbackformat,
                        'itemid' => 0
                    ),
                    'partiallycorrectfeedback' => array(
                        'text' => $options->partiallycorrectfeedback,
                        'format' => $options->partiallycorrectfeedbackformat,
                        'itemid' => 0
                    ),
                    'incorrectfeedback' => array(
                        'text' => $options->incorrectfeedback,
                        'format' => $options->incorrectfeedbackformat,
                        'itemid' => 0
                    ),
                    'shownumcorrect' => $options->shownumcorrect,
                    'defaultmark' => 1,
                    'penalty' => 0.3333333,
                    'length' => 1,
                    'hidden' => 0,
                    'fraction' => $fractions,
                    'feedback' => $feedbacks,
                    'timecreated' => time(),
                    'timemodified' => time(),
                    'createdby' => $USER->id,
                    'modifiedby' =>$USER->id
                ));
                break;

            // case 'truefalse':
            //     // Create the question options
            //     $options = new stdClass();
            //     foreach ($questiondata['answers'] as $index => $answerdata) {
            //         if ($answerdata['answer']) {
            //             $options->trueanswer = $index + 1;
            //         } else {
            //             $options->falseanswer = $index + 1;
            //         }
            //     }

            //     // Set the question answers
            //     $answers = array();
            //     foreach ($questiondata['answers'] as $index => $answerdata) {
            //         $answer = new stdClass();
            //         if ($index + 1 == $options->trueanswer) {
            //             $answer->answer = 'True';
            //         } else {
            //             $answer->answer = 'False';
            //         }
            //         $answer->answerformat = FORMAT_HTML;
            //         $answer->fraction = 0;
            //         $answer->feedback = '';
            //         $answer->feedbackformat = FORMAT_HTML;
            //         $answers[] = $answer;
            //     }
            //     // Save the true/false question
            //     question_bank::get_qtype($question->qtype)->save_question($question, (object) array(
            //         'name' => '',
            //         'category' => "{$categoryrowid},{$categorycontextid}",
            //         'answer' => $options->trueanswer,
            //         'correctanswer' => $options->trueanswer,
            //         'feedbacktrue' => array(
            //             'text' => reset($answers)->feedback,
            //             'format' => FORMAT_HTML,
            //             'itemid' => 0
            //         ),
            //         'feedbackfalse' => array(
            //             'text' => next($answers)->feedback,
            //             'format' => FORMAT_HTML,
            //             'itemid' => 0
            //         ),
            //         'defaultmark' => 1,
            //         'penalty' => 0.3333333,
            //         'length' => 1,
            //         'hidden' => 0,
            //         'timecreated' => time(),
            //         'timemodified' => time(),
            //         'createdby' => $USER->id,
            //         'modifiedby' =>$USER->id
            //     ));
            //     break;

            default:
                throw new moodle_exception('error', '', '', null, "Invalid question type: {$questiondata['type']}");
        }

        // Add the question to the quiz
        quiz_add_quiz_question($question->id, $moduleinfo);
    }
    return $quizID;
}

// Function to create a book in Moodle.
function createBookActivity($course, $sectionnum, $title, $description, $chapters) {
    global $DB, $CFG;

    require_once($CFG->dirroot . '/mod/book/lib.php');

    echo '<p>Adding a book resource: ' . $title . '...</p>' . PHP_EOL;

    // Create a new book activity
    $moduleinfo = newmodule('book', $course->id, $sectionnum, $title, $description);

    $moduleinfo->numbering = 0; // NONE: 0, NUMBERS: 1, BULLETS: 2, INDENTED: 3.
    $moduleinfo->navstyle = 2;  // BOOK_LINK - TOCONLY: 0, IMAGE: 1, TEXT: 2.
    $moduleinfo->customtitles = 0;

    // Create the book activity
    $cm = add_moduleinfo($moduleinfo, $course);
    $bookID = $DB->get_record('book', ['id' => $cm->instance], '*', MUST_EXIST)->id;

    // Add chapters to the book.
    foreach($chapters as $chapter) {
        $newchapter = new stdClass();
        $newchapter->bookid = $bookID;
        $newchapter->pagenum = 1;
        $newchapter->subchapter = 0;
        $newchapter->title = $chapter['topic'];
        $newchapter->content = $chapter['content'];
        $newchapter->contentformat = FORMAT_HTML;
        $newchapter->summary = $description;
        $newchapter->summaryformat = FORMAT_HTML;
        $newchapter->hidden = false;
        $newchapter->timecreated = time();
        $newchapter->timemodified = time();
        $newchapter->importsrc = '';

        // Save the chapter of the book to the database.
        $DB->insert_record("book_chapters", $newchapter);
    }
    return $bookID;
}

// Function to create a feedback form in the course.
function createFeedbackActivity($course, $sectionnum, $title, $description, $questions) {
    global $DB, $CFG;

    require_once($CFG->dirroot . '/mod/feedback/lib.php');

    echo '<p>Adding a feedback activity: ' . $title . '...</p>' . PHP_EOL;

    // Create the feedback activity
    $moduleinfo = newmodule('feedback', $course->id, $sectionnum, $title, $description);

    $moduleinfo->page_after_submit = '';
    $moduleinfo->page_after_submit_editor = array('text' => '', 'format' => FORMAT_HTML, 'itemid' => NULL);
    $moduleinfo->site_after_submit = '';
    $moduleinfo->timeopen = 0;
    $moduleinfo->timeclose = 0;
    $moduleinfo->completionsubmit = 0;
    $moduleinfo->anonymous = 1;
    $moduleinfo->email_notification = 0;
    $moduleinfo->multiple_submit = 0;
    $moduleinfo->autonumbering = 0;
    $moduleinfo->publish_stats = 0;

    // Create the feedback activity.
    $feedbackID = add_moduleinfo($moduleinfo, $course)->instance;


    // Add the questions to the feedback activity
    $qnum = 1;
    foreach ($questions as $question) {
        $item = new stdClass();
        $item->name = $question['question'];
        $item->label = 'Question ' . $qnum++;
        $item->hasvalue = 1;
        $item->position = $qnum;
        $item->dependitem = 0;
        $item->dependvalue = '';
        $item->required = 1;
        $item->feedback = $feedbackID;
        $item->template = 0;
        $item->options = '';
        $item->typ = $question['type'];
        switch ($question['type']) {
            case "multichoice":
                // Create a multichoice question
                $item->horizontal = 1;
                $item->hidenoselect = 0;
                $item->presentation = 'r>>>>>0 (disagree)|1|2|3|4|5 (agree)<<<<<1';
                break;
            case 'textfield':
                // Create a textfield question
                $item->presentation = '40|255'; // Width|Max length.
                break;
            default:
                die('Invalid or missing question type.' . $question['type']);
        }
        // Add the question to the feedback activity
        $DB->insert_record('feedback_item', $item);
    }

    return $feedbackID;
}
