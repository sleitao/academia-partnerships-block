<?php

class block_partnerships_edit_form extends block_edit_form {

    protected function specific_definition($mform) {

        // Section header title according to language file.
        $mform->addElement('header', 'configheader', get_string('blocksettings', 'block'));

        // A sample string variable with a default value.
        $mform->addElement('text', 'config_text', get_string('blockstring', 'block_partnerships'));
        $mform->setDefault('config_text', 'default value');
        $mform->setType('config_text', PARAM_MULTILANG);        

        $mform->addElement('filemanager', 'config_attachments', 'File Manager label', null,
                array('subdirs' => 0, 'maxbytes' => 1024, 'areamaxbytes' => 10485760, 'maxfiles' => 50,
                      'accepted_types' => array('image'), 'return_types'=> 1 | 2));
    }

    function set_data($defaults) {
        print_r($defaults);

        $filemanageropts = array('subdirs' => 0, 'maxbytes' => 1024, 'areamaxbytes' => 10485760, 'maxfiles' => 50,
                      'accepted_types' => array('image'), 'return_types'=> 1 | 2);

        if (!empty($this->block->config) && is_object($this->block->config)) {
            $draftid_attachments = file_get_submitted_draft_itemid('config_attachments');
            echo "DRAFTID1: ".$draftid_attachments;
            echo "DRAFTID2: ".$this->block->config->attachments;
            $draftid_attachments = $this->block->config->attachments;
            //$defaults->attachments = $draftid_attachments;

            $defaults->config_attachments = file_prepare_draft_area($draftid_attachments, $this->block->context->id, 'block_participants', 'content', 0, $filemanageropts,$draftid_attachments);
            
            
            //echo $defaults->config_attachments;
            //$defaults->config_attachments['itemid'] = $draftid_attachments;
            //$defaults->config_attachments['format'] = $this->block->config->format;
        }

        unset($this->block->config->attachments);
        parent::set_data($defaults);
        // restore $text
        if (!isset($this->block->config)) {
            $this->block->config = new stdClass();
        }

    }

}
