<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of Capability
 *
 * @author Kallol
 */
class Capability extends MY_Controller {

    //put your code here

    public function __construct() {
        parent::__construct();

        $this->targetModel = 'capabilities_model';

        $this->page_config['tablePrimaryKey'] = $this->capabilities_model->get_primary_key(); //pk
        /** page_config* */
        $this->page_config['title'] = 'Capability'; //search title bar
        $this->page_config['searchFields'] = 'capability_user_type,capability_controller'; //search box,
        $this->page_config['use_dropdown_columns'] = 'capability_controller,capability_user_type';


        $this->page_config['use_dropdown_columns_options']['capability_user_type'] = $this->user_types_model->get_list_for_dropdown('user_type_name');
        $this->page_config['use_dropdown_columns_options']['capability_controller'] = $this->get_controllers();

        /** end page_config* */
    }

    public function get_controllers() {
        /*         * default controllers* */
        $files = get_dir_file_info(APPPATH . 'controllers', FALSE);
        $modules = $this->get_modules();

        foreach ($modules as $module) {
            if ($module != 'Default')
                $files = array_merge($files, get_dir_file_info(ROOTPATH . 'modules/' . $module . '/controllers', FALSE));
        }
        $controllers = NULL;
        // Loop through file names removing .php extension
        foreach (array_keys($files) as $file) {
            if ($file != 'index.html') {
                $controller = str_replace(EXT, '', $file);
                $controllers[$controller] = $controller;
            }
        }

        return $controllers;
    }

    public function get_modules() {
        $moduleMeta = $this->modules_model->get_list_for_dropdown('module_name', array('module_status' => 1));
        return $moduleMeta;
    }

    //---------------------------------------------------------------
    /**
     * non generic functions
     * * */
}

?>
