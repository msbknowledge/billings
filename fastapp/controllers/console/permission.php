<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of Permission
 *
 * @author Kallol
 */
class Permission extends MY_Controller {

    //put your code here

    public function __construct() {
        parent::__construct();

        $this->targetModel = 'permissions_model';

        $this->page_config['tablePrimaryKey'] = $this->permissions_model->get_primary_key(); //pk
        /** page_config* */
        $this->page_config['title'] = 'Permission'; //search title bar
        $this->page_config['searchFields'] = 'permission_controller,permission_type'; //search box,
        $this->page_config['use_dropdown_columns'] = 'permission_type,permission_controller,permission_user_type_id';
        $this->page_config['use_dropdown_columns_options']['permission_type'] = array(
            'default' => 'default',
            'add_detail' => 'add',
            'edit_detail' => 'edit',
            'delete' => 'delete',
            'view_detail' => 'view',
            'index' => 'show list',
            'quick_edit' => 'Quick Edit'
        );
        $this->page_config['use_dropdown_columns_options']['permission_user_type_id'] = $this->user_types_model->get_list_for_dropdown('user_type_name');

        $controllers = $this->get_controllers();

        $this->page_config['use_dropdown_columns_options']['permission_controller'] = $controllers;




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
