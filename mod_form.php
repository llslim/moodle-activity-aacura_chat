<?php
// This file is part of Moodle - http://moodle.org/
//
// Moodle is free software: you can redistribute it and/or modify
// it under the terms of the GNU General Public License as published by
// the Free Software Foundation, either version 3 of the License, or
// (at your option) any later version.
//
// Moodle is distributed in the hope that it will be useful,
// but WITHOUT ANY WARRANTY; without even the implied warranty of
// MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
// GNU General Public License for more details.
//
// You should have received a copy of the GNU General Public License
// along with Moodle.  If not, see <http://www.gnu.org/licenses/>.

/**
 * mod_form file
 *
 * @package   mod_aacura_chat
 * @copyright 2025 Eduardo Kraus https://eduardokraus.com/
 * @license   http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

defined('MOODLE_INTERNAL') || die;

require_once("{$CFG->dirroot}/course/moodleform_mod.php");

/**
 * Class mod_aacura_chat_mod_form
 */
class mod_aacura_chat_mod_form extends moodleform_mod {
    /**
     * Defines forms elements
     * @throws coding_exception
     * @throws moodle_exception
     */
    public function definition(): void {
        global $CFG, $DB;

        $mform = $this->_form;
        $mform->addElement("header", "general", get_string("general", "form"));

        $mform->addElement("text", "name", get_string("name"), ["size" => "64"]);
        $mform->addRule("name", null, "required", null, "client");
        $mform->addRule("name", get_string("maximumchars", "", 255), "maxlength", 255, "client");
        if (!empty($CFG->formatstringstriptags)) {
            $mform->setType("name", PARAM_TEXT);
        } else {
            $mform->setType("name", PARAM_CLEANHTML);
        }

        $this->standard_intro_elements();

        $scenarios = [
            'anna' => 'Anna Charles (Autism pre-K concern)',
            'brianna' => 'Brianna Mitchell (Apraxia / social isolation)',
            'cathy' => 'Cathy Fratner (Down Syndrome / app concern)',
            'mary' => 'Mary (Mother of Non-Verbal 6-Year-Old)',
        ];

        // Fetch custom registered personas from local_aacura_core_custom_scenarios DB table
        $customrecords = $DB->get_records('local_aacura_core_custom_scenarios', null, 'name ASC');
        foreach ($customrecords as $cr) {
            $scenarios[$cr->scenariocode] = $cr->name . ' (Custom Persona)';
        }

        $scenarios['custom'] = 'Activity File Upload (Upload single scenario .json below)';

        $mform->addElement('select', 'scenariocode', get_string('scenariocode', 'mod_aacura_chat'), $scenarios);
        $mform->setDefault('scenariocode', 'anna');
        $mform->setType('scenariocode', PARAM_ALPHANUMEXT);

        // Add direct Scenario Builder link button in settings
        $builderurl = new moodle_url('/local/aacura_core/scenario_builder.php');
        $buttonhtml = '<div class="form-group row fitem">' .
            '<div class="col-md-3 text-sm-right"><label class="col-form-label"></label></div>' .
            '<div class="col-md-9 form-inline felement">' .
            '<a href="' . $builderurl->out() . '" target="_blank" class="btn btn-primary" style="background-color: #4F46E5; border-color: #4F46E5; color: white;">' .
            '🛠️ Open Custom Scenario Builder Tool' .
            '</a>' .
            '<span class="form-text text-muted ml-2">Build a custom scenario JSON file to upload below.</span>' .
            '</div></div>';
        $mform->addElement('html', $buttonhtml);

        $mform->addElement(
            'filepicker',
            'scenariofile',
            get_string('scenariofile', 'mod_aacura_chat'),
            null,
            ['maxbytes' => 1024 * 1024, 'accepted_types' => ['.json']]
        );

        // Add standard elements.
        $this->standard_coursemodule_elements();

        // Add standard buttons.
        $this->add_action_buttons();
    }

    /**
     * Enforce validation rules here
     *
     * @param array $data array of ("fieldname"=>value) of submitted data
     * @param array $files array of uploaded files "element_name"=>tmp_file_path
     * @return array
     **/
    public function validation($data, $files) {
        $errors = parent::validation($data, $files);

        return $errors;
    }
}
