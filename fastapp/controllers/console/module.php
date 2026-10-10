<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed dc ');

class Module extends MY_Controller {

    public function __construct() {
        parent::__construct();
        $this->targetModel = 'modules_model';
      
        $this->page_config['tablePrimaryKey'] = $this->modules_model->get_primary_key(); //pk
        /** page_config* */
        $this->page_config['title'] = 'Module'; //search title bar
        $this->page_config['searchFields'] = 'module_status'; //search box,
        $this->page_config['list_columns'] = 'module_name,module_status'; //search box,
        $this->page_config['use_dropdown_columns'] = 'module_name';
        $this->page_config['use_dropdown_columns_options']['module_name'] = $this->get_modules('all');
     
    }

    private function get_modules($show = 'all') {


        $dataModule = array();


        switch ($show) {
            case 'active':
                $activeModules = $this->{$this->targetModel}->get_list();
                foreach ($activeModules as $mvalue) {
                    $dataModule[$mvalue['module_name']] = ucwords(str_replace('_', ' ', $mvalue['module_name']));
                }
                break;
            case 'inactive':
                $activeModules = $this->{$this->targetModel}->get_list();
                $activedataModule = array();
                foreach ($activeModules as $mvalue) {
                    $activedataModule[$mvalue['module_name']] = ucwords(str_replace('_', ' ', $mvalue['module_name']));
                }
                $modules = get_dir_file_info(ROOTPATH . "modules/");

                foreach ($modules as $key => $value) {
                    $dataModule[$key] = ucwords(str_replace('_', ' ', $value['name']));
                }
                $dataModule = array_diff($dataModule, $activedataModule);
                break;

            case 'all':
            default:
                $modules = get_dir_file_info(ROOTPATH . "modules/");
                
                foreach ($modules as $key => $value) {
                    $dataModule[$key] = ucwords(str_replace('_', ' ', $value['name']));
                }
                break;
        }
        return $dataModule;
    }

    /**
     * add detail
     */
    public function add_detail() {
        $this->page_config['use_dropdown_columns_options']['module_name'] = $this->get_modules('inactive');

        $postedData = $this->input->post();
        if (isset($postedData['load_add_entry'])) {
            $entryData = $this->{$this->targetModel}->get_field_list();
            echo $this->generate_form_view($entryData[0], $this->page_config);
        } else {
            if ($postedData) {
                $lastInsertedID = $this->{$this->targetModel}->insert_data($postedData);

                echo json_encode(array('status' => 'success', 'message' => 'your data is added!!!'));
            }
        }
    }

    /**
     * edit detail
     */
    public function edit_detail() {
        $this->page_config['readonly_columns']= 'module_name';
        $postedData = $this->input->post();
        if (isset($postedData['load_edit_entry'])) {
            $entryData2 = $this->{$this->targetModel}->get_list(array($this->{$this->targetModel}->get_primary_key() => trim($postedData['load_edit_entry'])));
            $entryData1 = $this->{$this->targetModel}->get_field_list();
            $entryData = array_intersect_key($entryData2[0], $entryData1[0]);
            echo $this->generate_form_view($entryData, $this->page_config);
        } else {
            if ($postedData) {
                $config = $this->auto_fieldtype_detect(NULL);
                if (isset($config['use_status_columns'])) {
                    foreach ($config['use_status_columns'] as $statusColumn) {
                        $postedData[$statusColumn] = isset($postedData[$statusColumn]) ? 1 : 0;
                    }
                }
                $this->{$this->targetModel}->update_data($postedData, array($this->page_config['tablePrimaryKey'] => $postedData[$this->page_config['tablePrimaryKey']]));
                echo json_encode(array('status' => 'success', 'message' => 'your data is updated!!!'));
            }
        }
    }

    /**
     * view detail
     */
}
