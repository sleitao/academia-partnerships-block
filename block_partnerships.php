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
 * Newblock block caps.
 *
 * @package    block_partnerships
 * @copyright  Daniel Neis <danielneis@gmail.com>
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

defined('MOODLE_INTERNAL') || die();

class block_partnerships extends block_base {

    function init() {
        $this->title = get_string('pluginname', 'block_partnerships');
    }

    function get_content() {
        global $CFG, $DB, $OUTPUT;

        if ($this->content !== null) {
            return $this->content;
        }

        $this->content = new stdClass();
        $this->content->text   = '';
        $this->content->footer = '';

        // user/index.php expect course context, so get one if page has module context.

            
        //get and display images
        $fs = get_file_storage();
        $files = $fs->get_area_files($this->context->id, 'block_partnerships', 'content',0,"itemid, filepath, filename", false);
        foreach ($files as $file) {
            error_log("get_content: ------------------------------------");
            $fileurl = moodle_url::make_pluginfile_url($file->get_contextid(), $file->get_component(), $file->get_filearea(),
                                                       null, $file->get_filepath(), $file->get_filename());
            $this->content->text .= html_writer::empty_tag('img', array('src' => $fileurl));
        }
        return $this->content;
    }

    /**
     * Serialize and store config data
     */
    function instance_config_save($data, $nolongerused = false) {
        global $DB;

        //error_log("instance_config_save CONTEXT ID:".$this->context->id);

        $context = $this->context;
        $filemanageropts = array('subdirs' => 0, 'maxbytes' => '0', 'maxfiles' => 50, 'context' => $context);
        $config = clone($data);
        // Move embedded files into a proper filearea and adjust HTML links to match
        //echo ("config_save data->attachments: $data->attachments");
        file_save_draft_area_files($data->attachments, $context->id, 'block_partnerships', 'content', 0, $filemanageropts);
        parent::instance_config_save($config, $nolongerused);
    }

    public function instance_allow_multiple() {
          return false;
    }
    function has_config() {
          return true;
    }
    public function applicable_formats() {
        return array(
          'site' => true,
          'course-view' => true
        );
    }

    public function cron() {
        mtrace( "Hey, my cron script is running" );
        // do something
        return true;
    }

}
