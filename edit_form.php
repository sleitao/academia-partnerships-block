<?php

class block_partnerships_edit_form extends block_edit_form {

    protected function specific_definition($mform) {

        // Section header title according to language file.
        $mform->addElement('header', 'configheader', get_string('blocksettings', 'block'));

        // A sample string variable with a default value.
        $options = array('subdirs' => 0, 'maxbytes' => 1024, 'areamaxbytes' => 10485760, 'maxfiles' => 50,
                      'accepted_types' => array('image'), 'return_types'=> 1 | 2);

        $mform->addElement('filemanager', 'config_attachments', 'File Manager label', null,
                array('subdirs' => 0, 'maxbytes' => 5000000, 'maxfiles' => 10,
                      'accepted_types' => array('.png', '.jpg', '.gif') ));

        /*if (isset($this->block->config->attachments)) {
            echo "this->block->config->attachments:".$this->block->config->attachments;
            $mform->setDefault('config_attachments',$this->block->config->attachments);
        }*/
        
        /*$mform->addElement('text', 'config_text', 'Text');
        if (isset($this->block->config->text)) {
            $mform->setDefault('config_text',$this->block->config->text);
        }*/
 
    }

    function set_data($defaults) {
        //echo"-- Defaults: ";print_r($defaults);
        $context = $this->block->context;
        //error_log("set_dataCONTEXT ID:".$this->block->context->id);
        $filemanageropts = array('subdirs' => 0, 'maxbytes' => '0', 'maxfiles' => 50, 'context' => $context);
        $itemid = 0;
        //if (!empty($this->block->config) && is_object($this->block->config)) {
            $draftitemid = file_get_submitted_draft_itemid('config_attachments');
            //$draftitemid = 852279395;
        //}
        //echo("set_data draftitemid: ".$draftitemid);
        file_prepare_draft_area($draftitemid, $context->id, 'block_partnerships', 'content', $itemid, $filemanageropts);
        $defaults->config_attachments = $draftitemid;
        //echo("set_data draftitemid 2: ".$draftitemid);

/*
        $fs = get_file_storage();
        $files = $fs->get_area_files($this->block->context->id, 'block_partnerships', 'content', $itemid);
        foreach ($files as $file) {
            error_log("set_data filename: ".$file->get_filename());
        }
*/
        //echo "--- Defaults antes de set_data: ";print_r($defaults);

        parent::set_data($defaults);



        /*if ($data = parent::get_data()) {
            echo ("AAAA: ".$data->config_attachments);
            file_save_draft_area_files($data->config_attachments, $this->block->context->id, 'block_partnerships', 'content', 0, array('subdirs' => true));
        }*/
    }

}
