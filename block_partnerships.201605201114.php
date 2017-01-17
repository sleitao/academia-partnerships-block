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

        /*if (empty($this->instance)) {
            $this->content = '';
            return $this->content;
        }*/

        $this->content = new stdClass();
        $this->content->text   = '';
        $this->content->footer = '';
        //$this->content->items = array();
        //$this->content->icons = array()

        // user/index.php expect course context, so get one if page has module context.
        //$currentcontext = $this->page->context->get_course_context(false);

        if (! empty($this->config->text)) {
            //$this->content->text = $this->config->text;
            $this->config->text = "";
            $img_itemid = $this->config->attachments;
            //$draftitemid = file_get_submitted_draft_itemid('attachments');
            $itemid = 0;
            $fs = get_file_storage();
            $files = $fs->get_area_files($this->context->id, 'block_partnerships', 'content', $itemid, "itemid, filepath, filename", false);
            foreach ($files as $file) {
                $fileurl = moodle_url::make_pluginfile_url($file->get_contextid(), $file->get_component(), $file->get_filearea(),
                                                           null, $file->get_filepath(), $file->get_filename());
                $this->content->text .= html_writer::empty_tag('img', array('src' => $fileurl));
            }
        }

        /*$this->content = '';
        if (empty($currentcontext)) {
            return $this->content;
        }
        if ($this->page->course->id == SITEID) {
            $this->content->text .= "site context";
        }

        if (! empty($this->config->text)) {
            $this->content->text .= $this->config->text;
        }*/

        return $this->content;
    }

    // my moodle can only have SITEID and it's redundant here, so take it away
    public function applicable_formats() {
        return array('all' => false,
                     'site' => true,
                     'site-index' => true,
                     'course-view' => true, 
                     'course-view-social' => false,
                     'mod' => true, 
                     'mod-quiz' => false);
    }

    public function instance_allow_multiple() {
          return false;
    }

    function has_config() {return true;}

    public function cron() {
            mtrace( "Hey, my cron script is running" );
             
                 // do something
                  
                      return true;
    }

    /**
     * Serialize and store config data
     */
/*    function instance_config_save($data, $nolongerused = false) {
        global $DB;
        $config = clone($data);
        error_log ("data->attachments: ".$data->attachments); 
        $draftitemid = file_get_submitted_draft_itemid('config_attachments');
        error_log ("draftitemid: ".$draftitemid);
        // Move embedded files into a proper filearea and adjust HTML links to match
        file_save_draft_area_files($draftitemid, $this->context->id, 'block_partnerships', 'content', 0, array('subdirs'=>false), $draftitemid);
        
        //$config->format = $data->attachments['format'];

        parent::instance_config_save($config, $nolongerused);
    }*/
}
