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
        $this->page_config['use_dropdown_columns_options']['multi']['module_name'] = true;
    }

    private function get_modules($show = 'all') {
        $dataModule = array();

        // 1. All directories under modules/
        $modules = get_dir_file_info(ROOTPATH . "modules/");
        if (!empty($modules)) {
            foreach ($modules as $key => $value) {
                $dataModule[$key] = ucwords(str_replace('_', ' ', $value['name']));
            }
        }

        // 2. All modules currently in DB
        $dbModules = $this->{$this->targetModel}->get_list();
        $activedataModule = array();
        if (!empty($dbModules)) {
            foreach ($dbModules as $mvalue) {
                $mName = trim($mvalue['module_name']);
                if (!empty($mName)) {
                    $activedataModule[$mName] = ucwords(str_replace('_', ' ', $mName));
                    $dataModule[$mName] = ucwords(str_replace('_', ' ', $mName));
                }
            }
        }

        // 3. All modules defined in PLAN_PACKAGES
        if (defined('PLAN_PACKAGES') && !empty(PLAN_PACKAGES)) {
            $planModules = json_decode(PLAN_PACKAGES, true);
            if (!is_array($planModules)) {
                $planModules = explode(',', PLAN_PACKAGES);
            }
            if (is_array($planModules)) {
                foreach ($planModules as $pm) {
                    $pm = trim($pm);
                    if (!empty($pm)) {
                        $dataModule[$pm] = ucwords(str_replace('_', ' ', $pm));
                    }
                }
            }
        }

        // 4. Known standard system modules
        $standardModules = array('billing', 'stock', 'sales', 'purchase', 'customer', 'supplier', 'reports', 'payments', 'email', 'sms', 'node', 'expence_manager', 'medical');
        foreach ($standardModules as $sm) {
            if (!isset($dataModule[$sm])) {
                $dataModule[$sm] = ucwords(str_replace('_', ' ', $sm));
            }
        }

        if ($show === 'inactive') {
            $dataModule = array_diff_key($dataModule, $activedataModule);
        }

        return $dataModule;
    }

    /**
     * add detail
     */
    public function add_detail() {
        $this->page_config['use_dropdown_columns_options']['module_name'] = $this->get_modules('all');
        $this->page_config['use_dropdown_columns_options']['multi']['module_name'] = true;

        $postedData = $this->input->post();
        if (isset($postedData['load_add_entry'])) {
            $entryData = $this->{$this->targetModel}->get_field_list();
            echo $this->generate_form_view($entryData[0], $this->page_config);
        } else {
            if ($postedData) {
                $status = isset($postedData['module_status']) ? 1 : 0;
                $moduleNames = array();
                if (isset($postedData['module_name'])) {
                    $moduleNames = is_array($postedData['module_name']) ? $postedData['module_name'] : array($postedData['module_name']);
                }

                if (!empty($moduleNames)) {
                    foreach ($moduleNames as $mName) {
                        $mName = trim($mName);
                        if (empty($mName)) continue;
                        $existing = $this->{$this->targetModel}->get_list(array('module_name' => $mName));
                        if (!empty($existing)) {
                            $this->{$this->targetModel}->update_data(
                                array('module_status' => $status),
                                array('module_name' => $mName)
                            );
                        } else {
                            $this->{$this->targetModel}->insert_data(array(
                                'module_name' => $mName,
                                'module_status' => $status
                            ));
                        }
                    }
                }

                // Clear module and menu caches so changes take effect immediately
                @unlink(ROOTPATH . 'fastapp/cachefiles/' . NODE . '/module.txt');
                @array_map('unlink', glob(ROOTPATH . 'fastapp/cachefiles/' . NODE . '/menu_cache_*.txt'));

                echo json_encode(array('status' => 'success', 'message' => 'Module(s) added successfully!'));
            }
        }
    }

    /**
     * edit detail
     */
    public function edit_detail() {
        $this->page_config['use_dropdown_columns_options']['module_name'] = $this->get_modules('all');
        $this->page_config['use_dropdown_columns_options']['multi']['module_name'] = true;

        $postedData = $this->input->post();
        if (isset($postedData['load_edit_entry'])) {
            $pkVal = trim($postedData['load_edit_entry']);
            $entryData2 = $this->{$this->targetModel}->get_list(array($this->page_config['tablePrimaryKey'] => $pkVal));
            $entryData1 = $this->{$this->targetModel}->get_field_list();
            $entryData = array_intersect_key($entryData2[0], $entryData1[0]);
            echo $this->generate_form_view($entryData, $this->page_config);
        } else {
            if ($postedData) {
                $pkVal = isset($postedData[$this->page_config['tablePrimaryKey']]) ? $postedData[$this->page_config['tablePrimaryKey']] : 0;
                $status = isset($postedData['module_status']) ? 1 : 0;

                $moduleNames = array();
                if (isset($postedData['module_name'])) {
                    $moduleNames = is_array($postedData['module_name']) ? $postedData['module_name'] : array($postedData['module_name']);
                }

                if (!empty($moduleNames)) {
                    // Update current record with first selected module
                    $primaryMod = trim(array_shift($moduleNames));
                    $this->{$this->targetModel}->update_data(
                        array('module_name' => $primaryMod, 'module_status' => $status),
                        array($this->page_config['tablePrimaryKey'] => $pkVal)
                    );

                    // Insert or update any extra selected modules
                    foreach ($moduleNames as $extraMod) {
                        $extraMod = trim($extraMod);
                        if (empty($extraMod)) continue;
                        $existing = $this->{$this->targetModel}->get_list(array('module_name' => $extraMod));
                        if (!empty($existing)) {
                            $this->{$this->targetModel}->update_data(
                                array('module_status' => $status),
                                array('module_name' => $extraMod)
                            );
                        } else {
                            $this->{$this->targetModel}->insert_data(array(
                                'module_name' => $extraMod,
                                'module_status' => $status
                            ));
                        }
                    }
                } else {
                    $this->{$this->targetModel}->update_data(
                        array('module_status' => $status),
                        array($this->page_config['tablePrimaryKey'] => $pkVal)
                    );
                }

                // Clear module and menu caches so updated module status is active immediately
                @unlink(ROOTPATH . 'fastapp/cachefiles/' . NODE . '/module.txt');
                @array_map('unlink', glob(ROOTPATH . 'fastapp/cachefiles/' . NODE . '/menu_cache_*.txt'));

                echo json_encode(array('status' => 'success', 'message' => 'Module(s) updated successfully!'));
            }
        }
    }

    /**
     * delete module
     */
    public function delete() {
        $postedData = $this->input->post();
        if ($postedData && isset($postedData['targetValue'])) {
            $this->{$this->targetModel}->delete_data(array($this->page_config['tablePrimaryKey'] => intval($postedData['targetValue'])));

            // Clear module and menu caches
            @unlink(ROOTPATH . 'fastapp/cachefiles/' . NODE . '/module.txt');
            @array_map('unlink', glob(ROOTPATH . 'fastapp/cachefiles/' . NODE . '/menu_cache_*.txt'));

            echo json_encode(array('status' => 'success', 'message' => 'Module removed successfully'));
        }
    }

    /**
     * view detail
     */
}
