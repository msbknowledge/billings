<?php

/**
 * Description of My_Controler
 * @package core
 * @author Kallol
 * @version 2.0
 * @dependent Model permission_model,site_settings_model,menus_model
 * @deprecated since version 1.0.2 dependent  Model 
 */
class MY_Controller extends CI_Controller {

    protected $publicAccess, $validationRules, $moduleControllers,
            $allowed_action, $translator, $record_per_page = 15,
            $default_uri_segment = 4;
    public $moduleMenu,$targetModel, $current_user_session,
            $current_site_settings, $routedirectory, $moduleMeta, $function_hook;
    
    public function __construct() {
        parent::__construct();
        //$this->output->enable_profiler(TRUE);
        if ($this->input->get()) {
            $this->output->cache(60);
        }
        /***/
        $this->initilise();
        $this->access_control();
        $this->load_module_packages();
        $this->is_site_down();
        
    }

   /**
     * initialisation of varriables 
     * @ticket:  $this->routedirectory must be changed
     * * */
    public function initilise() {
        /** populate basic site settings ans user data to application wise */
        $this->current_user_session = $this->session->userdata('current_user_session');
        $this->allowed_action = array('add_detail', 'edit_detail', 'delete', 'view_detail', 'quick_edit');
        $this->current_site_settings = $this->get_site_setting();
        $this->targetModel = $this->uri->segment(2) . 's_model';
        /** populate site settings ans user data to application wise */
        /*         * initialize the routing directory[think useless now]* */
        if ($this->router->directory != '/') {
            $this->routedirectory = $this->router->directory;
        } else {
            $this->routedirectory = 'console/';
        }
    }
    /**
     * autoload module active module packages
     * with all models and helpers
     * *** */
    private function load_module_packages() {
        /** get the active modules */
        if (file_exists(ROOTPATH . 'fastapp/cachefiles/' . NODE . '/module.txt')) {
            $modules = $this->get_modules();
        } else {
            $modules = $this->get_modules();

            file_put_contents(ROOTPATH . 'fastapp/cachefiles/' . NODE . '/module.txt', json_encode($modules));
        }
        
        //pr($modules);
        foreach ($modules as $moduleMeta) {
            if (!is_dir(ROOTPATH . "modules/" . $moduleMeta)) continue;
            /*             * load the package */
            $this->load->add_package_path(ROOTPATH . "modules/" . $moduleMeta . '/');

            /** load frontend controller list only */
            if (get_dir_file_info(ROOTPATH . 'modules/' . $moduleMeta . '/controllers', TRUE))
                foreach (get_dir_file_info(ROOTPATH . 'modules/' . $moduleMeta . '/controllers', TRUE) as $value) {
                    if (substr($value['name'], -4) === '.php')
                        $this->moduleControllers['frontend'][substr($value['name'], 0, -4)] = array(
                            'module' => $moduleMeta,
                            'path' => $value['server_path']
                        );
                }

            /*             * load console controller list only */
            if (get_dir_file_info(ROOTPATH . 'modules/' . $moduleMeta . '/controllers/console', TRUE))
                foreach (get_dir_file_info(ROOTPATH . 'modules/' . $moduleMeta . '/controllers/console', TRUE) as $value) {
                    if (substr($value['name'], -4) === '.php') {
                        $ctrl_name = substr($value['name'], 0, -4);
                        $this->moduleControllers['console'][$ctrl_name] = array(
                            'module' => $moduleMeta,
                            'path' => $value['server_path']
                        );
                        if (substr($ctrl_name, -1) === 's') {
                            $singular = substr($ctrl_name, 0, -1);
                            if (!isset($this->moduleControllers['console'][$singular])) {
                                $this->moduleControllers['console'][$singular] = array(
                                    'module' => $moduleMeta,
                                    'path' => $value['server_path']
                                );
                            }
                        } else {
                            $plural = $ctrl_name . 's';
                            if (!isset($this->moduleControllers['console'][$plural])) {
                                $this->moduleControllers['console'][$plural] = array(
                                    'module' => $moduleMeta,
                                    'path' => $value['server_path']
                                );
                            }
                        }
                    }
                }

            /*             * load models */
            if (get_dir_file_info(ROOTPATH . 'modules/' . $moduleMeta . '/models'))
                foreach (get_dir_file_info(ROOTPATH . 'modules/' . $moduleMeta . '/models') as $value) {
                    if (substr($value['name'], -4) === '.php')
                        $this->load->model(substr($value['name'], 0, -4));
                }
            /*             * load helpers */
            if (get_dir_file_info(ROOTPATH . 'modules/' . $moduleMeta . '/helpers'))
                foreach (get_dir_file_info(ROOTPATH . 'modules/' . $moduleMeta . '/helpers') as $value) {
                    if (substr($value['name'], -4) === '.php')
                        $this->load->helper(substr($value['name'], 0, -4));
                }
            /*             * remove packages for safe execution* */
            //$this->load->remove_package_path(ROOTPATH . "modules/" . $moduleMeta . '/');
        }
    }

    /**
     * prepare user capability permission and access controle
     *      * @ticket:  $this->is_authorised malfunctionaing
     * * */
    private function access_control() {

        if (!$this->is_capabale()) {
            $this->show_error_page(403, 'Permission Denied: You do not have permission / capability to access this section.');
            exit();
        }
        // pr($this->router->class);
        /*         * prepare access controle links* */
        $permission_list = $this->permissions_model->get_list(array(
            'permission_user_type_id' => isset($this->current_user_session['user_type_id']) ? $this->current_user_session['user_type_id'] : 0,
            'permission_controller' => isset($this->uri->segments[2]) ? $this->uri->segments[2] : $this->uri->rsegments[1]
        ));
        //$permission_list = NULL;
        $permission_type_array = NULL;

        if ($permission_list) {
            foreach ($permission_list as $value) {
                $permission_type_array[] = $value['permission_type'];
            }
            $this->page_config['allowed_action'] = implode(',', $permission_type_array);
        }
        unset($permission_list);
        /*         * prepare capability permissio* */
        $this->is_authorised($permission_type_array);
        unset($permission_type_array);
    }

    private function get_capabilities() {
        $searchCapability['capability_user_type'] = isset($this->current_user_session['user_type_id']) ? intval($this->current_user_session['user_type_id']) : 0;
        $searchCapability['capability_controller'] = isset($this->uri->segments[2]) ? $this->uri->segments[2] : $this->uri->rsegments[1];
        $capabilities = $this->capabilities_model->get_list($searchCapability);
        return isset($capabilities[0]) ? $capabilities[0] : NULL;
    }

    /**
     * only for console capability check    
     *  */
    private function is_capabale() {
        if (isset($this->uri->segments[1]) && $this->uri->segments[1] == 'console') {
            $capabilities = $this->get_capabilities();
            $verify_capable_action = isset($this->uri->segments[3]) ? $this->uri->segments[3] : $this->uri->rsegments[2];
            if ($capabilities) {
                if (!is_array($capabilities['capability_actions']) && ($capabilities['capability_actions'] == '*')) {
                    return TRUE;
                } else {
                    $capabilities = explode(',', $capabilities['capability_actions']);
                    if (in_array($verify_capable_action, $capabilities)) {
                        return TRUE;
                    }
                }
            }
            return FALSE;
        } else {
            return TRUE;
        }
    }


    /**
     * 
     * check if site down for maintain 
     * in admin check the site_setting_status is 0 or 1
     *  */
    private function is_site_down($forceDown = false) {
        if ($forceDown || ($this->current_site_settings['site_setting_status'] == 0 && $this->routedirectory == 'frontend/')) {
            $this->show_error_page(204);
        }
        return TRUE;
    }


    public function capability_list() {
        $this->page_config['use_dropdown_columns_options']['capability_user_type'] = $this->user_types_model->get_list_for_dropdown('user_type_name');
        $this->page_config['use_dropdown_columns_options']['capability_controller'] = $this->get_controllers();
        if (!$this->current_user_session['user_type_super']) {
            $message = '<script>window.location="' . console_url() . 'user/login"</script>Please Wait...';
            show_error($message, '403', 'Not Authorised!! Please wait...');
        }
        if ($this->input->post()) {
            $postedData = $this->input->post();
            set_option('capability_' . key($postedData['capability']), json_encode($postedData));
        }
        $choosenData = json_decode(get_option('capability_' . $this->uri->segment(2)), true);
        $this->render(array('choosenData' => $choosenData), 'capability_list_tpl');
        //pr($viewData);
       // $this->render(array('viewData' => $viewData));
    }

    private function get_controllers() {
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

    private function get_modules() {
        $activeModules = array();

        // 1. Fetch active modules from database `modules` table where module_status = 1
        if (isset($this->db)) {
            $query = $this->db->select('module_name')->where('module_status', 1)->get('modules');
            if ($query && $query->num_rows() > 0) {
                foreach ($query->result_array() as $m) {
                    if (!empty($m['module_name'])) {
                        $raw = trim($m['module_name']);
                        $dec = json_decode($raw, true);
                        if (is_array($dec)) {
                            foreach ($dec as $item) {
                                $item = trim($item);
                                if (!empty($item)) $activeModules[] = $item;
                            }
                        } else {
                            $activeModules[] = $raw;
                        }
                    }
                }
            }
        }

        // 2. Also merge any modules defined in PLAN_PACKAGES if set
        if (defined('PLAN_PACKAGES') && !empty(PLAN_PACKAGES)) {
            $planModules = json_decode(PLAN_PACKAGES, true);
            if (!is_array($planModules)) {
                $planModules = explode(',', PLAN_PACKAGES);
            }
            if (is_array($planModules)) {
                foreach ($planModules as $pm) {
                    $pm = trim($pm);
                    if (!empty($pm) && !in_array($pm, $activeModules)) {
                        $activeModules[] = $pm;
                    }
                }
            }
        }

        return array_values(array_unique($activeModules));
    }

    public function excel_convert() {

        $all_data = $this->{$this->targetModel}->get_list();

        foreach ($all_data as $key => $value) {
            $title_data[] = (array_keys($value));
            //array_push($all_data, $title_data);
            $reformatted_all_data = (array_merge($title_data, $all_data));

            //pr($reformatted_all_data,1);
            //load our new PHPExcel library
            $this->load->library('excel');
            //activate worksheet number 1
            $this->excel->setActiveSheetIndex(0);
            //name the worksheet
            $this->excel->getActiveSheet()->setTitle($this->page_config['title']);
            $this->excel->getActiveSheet()->fromArray($reformatted_all_data);

            $filename = $this->page_config['title'] . date("Y-m-d H:m:s") . 'sheet.xls'; //save our workbook as this file name
            ob_end_clean();
            header('Content-Type: application/vnd.ms-excel'); //mime type
            header('Content-Disposition: attachment;filename="' . $filename . '"'); //tell browser what's the file name
            header('Cache-Control: max-age=0'); //no cache
            //save it to Excel5 format (excel 2003 .XLS file), change this to 'Excel2007' (and adjust the filename extension, also the header mime type)
            //if you want to save it as .XLSX Excel 2007 format

            $objWriter = PHPExcel_IOFactory::createWriter($this->excel, 'Excel5');
            //force user to download the Excel file without writing it to server's HD
            $objWriter->save('php://output');
            exit;
        }
    }

    protected function breadcrumb_generator($segments) {
        $breadcrumb[ucwords(str_replace('_', ' ', $segments[1]))] = '/' . $segments[1];
        if ($segments[2] != 'index' && !empty($segments[2]))
            $breadcrumb[ucwords(str_replace('_', ' ', $segments[2]))] = '/' . $segments[1] . '/' . $segments[2];
        if ($segments[3] != 'index' && !empty($segments[3]))
            $breadcrumb[ucwords(str_replace('_', ' ', $segments[3]))] = '/' . $segments[1] . '/' . $segments[2] . '/' . $segments[3];
        return $breadcrumb;
    }

    /*     * *
     * Rendering default template and others.
     * Default : application/views/console/controller_name/method_name.tpl.php
     * For Popup window needs to include the main css and jquery exclusively.
     * 
     * @param string $view_file, ex- dashboard/report then looks like application/views/console/.$view_file.tpl.php
     * @param array $passedData, pass the data to view
     * @param boolean $returnData, ex- true if return the data as variable string , false to render general
     * @param string header view name  $header_tpl, ex- default is 'header.tpl'
     * @param string footer view name  $footer_tpl, ex- default is 'footer.tpl'
     */

    /*     * *
     * Rendering default template and others.
     * Default : application/views/console/controller_name/method_name.tpl.php
     * For Popup window needs to include the main css and jquery exclusively.
     * 
     * @param string $view_file, ex- dashboard/report then looks like application/views/console/.$view_file.tpl.php
     * @param array $passedData, pass the data to view
     * @param boolean $returnData, ex- true if return the data as variable string , false to render general
     * @param string header view name  $header_tpl, ex- default is 'header.tpl'
     * @param string footer view name  $footer_tpl, ex- default is 'footer.tpl'
     */

    protected function render($passedData = array(), $view_file = null, $returnData = FALSE, $header_tpl = 'common/header_tpl', $footer_tpl = 'common/footer_tpl') {
        try {
            $segments = $this->router->uri->segments;
            if ($segments[1] == 'console') {
                if (empty($segments[3])) {
                    $segments[3] = 'index';
                }
                if (empty($segments[2])) {
                    $segments[2] = 'dashboard';
                }
                $this->routedirectory = 'console/';
                if ($view_file == null)
                    $view_file_path = $segments[1] . '/' . $segments[2] . '/' . $segments[3] . '_tpl';
                else
                    $view_file_path = $segments[1] . '/' . $segments[2] . '/' . $view_file;
            } else {
                $this->routedirectory = '';
                $view_file_path = $segments[1] . '/' . $segments[2] . '_tpl';
            }

            $returnViewData = '';
            $passedData['current_user_session'] = $this->current_user_session;
            $passedData['site_settings'] = $this->current_site_settings;
            $passedData['site_menu'] = $this->menu_generater();
            $passedData['site_breadcrumb'] = $this->breadcrumb_generator($segments);
            /*             * **********
              header
             *              * ************ */
            if (!($header_tpl === FALSE))
                $returnViewData .= $this->load->view($this->routedirectory . $header_tpl, $passedData, $returnData);

            /*             * **********
              view file detection and load
             * ************ */
            if (isset($this->moduleControllers['console'][$this->uri->segment(2)]['module'])) {
                $module_name = $this->moduleControllers['console'][$this->uri->segment(2)]['module'];
                if (!get_file_info(ROOTPATH . 'modules/' . $module_name . '/views/' . $view_file_path . '.php')) {
                    $alt_view_path = null;
                    $seg2 = $this->uri->segment(2);
                    if (substr($seg2, -1) === 's') {
                        $alt_view_path = str_ireplace($seg2 . '/', substr($seg2, 0, -1) . '/', $view_file_path);
                    } else {
                        $alt_view_path = str_ireplace($seg2 . '/', $seg2 . 's/', $view_file_path);
                    }
                    if ($alt_view_path && get_file_info(ROOTPATH . 'modules/' . $module_name . '/views/' . $alt_view_path . '.php')) {
                        $view_file_path = $alt_view_path;
                    } else if (get_file_info(APPPATH . 'views/' . $this->routedirectory . 'elements/' . $view_file . '.php')) {
                        $view_file_path = $this->routedirectory . 'elements/' . $view_file;
                    } else {
                        $view_file_path = str_ireplace($this->uri->segment(2) . '/', '', $view_file_path);
                    }
                }
            } else {
                if (!get_file_info(APPPATH . 'views/' . $view_file_path . '.php')) {
                    $view_file_path = str_ireplace($this->uri->segment(2) . '/', '', $view_file_path);
                    if (!get_file_info(APPPATH . 'views/' . $view_file_path . '.php')) {
                        $view_file_path = str_ireplace('elements' . '/', '', $view_file_path);
                    }
                }
            }
            $returnViewData .= $this->load->view($view_file_path, $passedData, $returnData);
            /*             * **********
              footer
             *              * ************ */
            if (!($footer_tpl === FALSE)) {
                $returnViewData .= $this->load->view($this->routedirectory . $footer_tpl, $passedData, $returnData);
            }
            return $returnViewData;
        } catch (Exception $err_obj) {
            $this->show_error_page(600, $err_obj->getMessage());
        }
    }

    protected function get_site_setting() {
        if (file_exists(ROOTPATH . 'fastapp/cachefiles/' . NODE . '/site_setting.txt')) {
            $site_setting = json_decode(file_get_contents(ROOTPATH . 'fastapp/cachefiles/' . NODE . '/site_setting.txt'), true);
        } else {
            $site_setting['site_setting_record_per_page'] = intval(get_option('record_per_page'));
            $site_setting['site_setting_status'] = intval(get_option('site_status'));
            $site_setting['site_setting_analytics'] = get_option('site_analitics');
            $site_setting['site_setting_copyright'] = get_option('site_copyright');
            $site_setting['site_setting_title'] = get_option('site_title');
            $site_setting['site_setting_description'] = get_option('site_description');
            $site_setting['site_setting_logo'] = get_option('site_logo');
            $site_setting['site_setting_theme'] = get_option('site_theme');
            file_put_contents(ROOTPATH . 'fastapp/cachefiles/' . NODE . '/site_setting.txt', json_encode($site_setting));
        }

        return $site_setting;
    }

    protected function sendmail($mailMeta, $printDebug = FALSE, $use_defined_config = NULL) {

        $this->load->library('email');
        /*         * send mail config* */
         $config = array(
            'protocol'  => 'smtp',//'sendmail'
            'smtp_host' => 'smtp.hostinger.com',
            'smtp_crypto' => 'ssl',
            'smtp_port' => 465,                        // Use 587 (TLS) or 465 (SSL)
            'smtp_user' => 'admin@msbbillings.in',     // FULL email address
            'smtp_pass' => 'BR66MK55@msb',      // Correct password or app password
            'mailtype'  => 'html',
            'charset'   => 'utf-8',
            'newline'   => "\r\n",
            'crlf'      => "\r\n",
            'wordwrap'  => TRUE
        );
        if (is_array($use_defined_config))
            $config = array_merge($config, $use_defined_config);
        $this->email->initialize($config);
        /*         * send mail config* */

        /*         * mail formating* */
        if (!isset($mailMeta['from']['email'])) {
            $mailMeta['from']['email'] = 'no-reply@msbbillings.in';
        }

        if (!isset($mailMeta['from']['name'])) {
            $mailMeta['from']['name'] = 'Do not Reply Msbbillings';
        }

        $this->email->from($mailMeta['from']['email'], isset($mailMeta['from']['name']) ? $mailMeta['from']['name'] : NULL);
        if (isset($mailMeta['reply_to']['email']))
            $this->email->reply_to($mailMeta['reply_to']['email'], isset($mailMeta['reply_to']['name']) ? $mailMeta['reply_to']['name'] : NULL);

        if (isset($mailMeta['to']))
            $this->email->to($mailMeta['to']);

        if (isset($mailMeta['cc']))
            $this->email->cc($mailMeta['cc']);

        if (isset($mailMeta['bcc']))
            $this->email->bcc($mailMeta['bcc']);

        $this->email->subject(isset($mailMeta['subject']) ? $mailMeta['subject'] : '');
        $this->email->message(isset($mailMeta['body']) ? $mailMeta['body'] : '');
        

        $sendMailStatus = $this->email->send();
        // if ($printDebug)
        //     echo $this->email->print_debugger();
        return $sendMailStatus;
    }

    /**
     * need modification
     */
    private function is_authorised($allowed_action = NULL) {
        // Super Admin bypass — full permission
        if (!empty($this->current_user_session['user_type_super'])
            || (isset($this->current_user_session['user_type_id']) && $this->current_user_session['user_type_id'] == 1)
        ) {
            return TRUE;
        }

        // Always allowed auth actions
        $alwaysAllowed = array('login', 'logout', 'profile', 'captcha_check', 'refresh_captcha', 'forgot_password');
        if (in_array($this->router->method, $alwaysAllowed)) {
            return TRUE;
        }

        /*         * *
         * public access set in controllers
         */
        if (isset($this->publicAccess)) {
            if (is_array($this->publicAccess) && array_search($this->router->method, $this->publicAccess) !== FALSE) {
                return TRUE;
            } else {
                if ($this->publicAccess == '*')
                    return TRUE;
            }
        }

        /**
         * check if user is login or not
         * * */
        if (isset($this->current_user_session['user_ID'])) {
            if ($allowed_action) {
                if (array_search($this->router->method, $allowed_action) !== FALSE) {
                    return TRUE;
                } else {
                    $this->show_error_page(403, 'Permission Denied: You do not have permission to perform this action (' . $this->router->method . ').');
                    return false;
                }
            }
            return true;
        } else {
            //redirect(base_url());
            $this->show_error_page(401, 'Please login to continue.');
            return false;
        }
    }

    /**
     * generate view for index listing table 
     */
    protected function generate_table_view($data = NULL, $user_config = array(), $view_template = 'elements/table_tpl') {
        /** auto field type detect Start* */
        $config = $this->auto_fieldtype_detect($user_config);
        /** auto field type detect End* */
        $config['enable_pagination'] = isset($user_config['enable_pagination']) ? $user_config['enable_pagination'] : TRUE;
        $config['total_rows'] = isset($data['total_rows']) ? $data['total_rows'] : 0;
        $config['per_page'] = isset($data['per_page']) ? $data['per_page'] : $this->current_site_settings['site_setting_record_per_page'];
        $config['uri_segment'] = isset($user_config['uri_segment']) ? $user_config['uri_segment'] : $this->default_uri_segment;
        $config['is_ajax'] = isset($user_config['is_ajax']) ? $user_config['is_ajax'] : TRUE;
        $config['title'] = isset($user_config['title']) ? $user_config['title'] : str_ireplace('_', ' ', ucfirst($this->uri->segment(2)));
        /*         * list column */
        $config['list_columns'] = is_string(@$user_config['list_columns']) ? explode(',', $user_config['list_columns']) : NULL;
        /*         * dropdown */
        $config['use_dropdown_columns_options'] = isset($user_config['use_dropdown_columns_options']) ? $user_config['use_dropdown_columns_options'] : array();
        /*         * allowed action */
        $config['allowed_action'] = is_string(@$user_config['allowed_action']) ? explode(',', $user_config['allowed_action']) : $this->allowed_action;
        /*         * enable ordering */
        $config['enable_ordering'] = isset($user_config['enable_ordering']) ? $user_config['enable_ordering'] : FALSE;
        /*         * image */
        if (!isset($user_config['use_image_columns_path'])) {
            $user_config['use_image_columns_path'] = base_url() . 'uploads/' . NODE . '/';
        }
        $config['use_image_columns'] = is_string(@$user_config['use_image_columns']) ? explode(',', $user_config['use_image_columns']) : NULL;
        $config['use_image_columns_path'] = is_string(@$user_config['use_image_columns_path']) ? explode(',', $user_config['use_image_columns_path']) : $user_config['use_image_columns_path'];
         /*         * image */
        // if (!isset($admin_config['use_image_columns_path'])) {
        //     $admin_config['use_image_columns_path'] = base_url() . 'uploads/' . NODE . '/';
        // }
        // $config['use_image_columns'] = is_string(@$admin_config['use_image_columns']) ? explode(',', $admin_config['use_image_columns']) : NULL;
        // $config['use_image_columns_path'] = is_string(@$admin_config['use_image_columns_path']) ? explode(',', $admin_config['use_image_columns_path']) : $admin_config['use_image_columns_path'];

        // if (!isset($admin_config['use_file_columns_path'])) {
        //     $admin_config['use_file_columns_path'] = base_url() . 'uploads/' . NODE . '/';
        // }

        // $config['use_file_columns'] = is_string(@$admin_config['use_file_columns']) ? explode(',', $admin_config['use_file_columns']) : NULL;
        
        // $config['use_file_columns_path'] = is_string(@$admin_config['use_file_columns_path']) ? explode(',', $admin_config['use_file_columns_path']) : $admin_config['use_file_columns_path'];
           /** imageuploader */
        $config['multi_upload'] = isset($user_config['multi_upload']) ? ($user_config['multi_upload'] ? 'true' : 'false') : 'false';
        $tabledata['table_meta']['config'] = $config;
        $tabledata['table_meta']['data'] = isset($data['current_paged_list']) ? $data['current_paged_list'] : array();
        $tabledata['orderByModelData'] = $this->targetModel;
        return $this->render($tabledata, $view_template, true, false, false);
    }

    /**
     * generate view for index search section 
     */
   protected function generate_table_search_view($user_config = array(), $view_template = 'elements/search_box_tpl') {
        /** auto field type detect Start* */
        $config = $this->auto_fieldtype_detect($user_config);
        foreach($config as $fname=>$fieldx){
		if($fname=="use_dropdown_columns_options"){

			foreach( (array_keys($fieldx)) as $field){
				$fields[] = ($field);
			}
		}else{ 
			foreach($fieldx as $field){
				$fields[] = ($field);
			}
		}	
	}

        /** auto field type detect End* */
        /*         * dropdown */
        $config['use_dropdown_columns_options'] = isset($user_config['use_dropdown_columns_options']) ? $user_config['use_dropdown_columns_options'] : array();

        //$default['searchFields'] = is_string($user_config['searchFields'])?$user_config['searchFields']:NULL;
        $config['searchFields'] = is_string(isset($user_config['searchFields']) ? $user_config['searchFields'] : 0) ? explode(',', $user_config['searchFields']) :$fields;
        $config['default_search_value'] = isset($user_config['default_search_value']) ? $user_config['default_search_value'] : NULL;

        return $this->render($config, $view_template, true, false, false);
    }

    /**
     * generate view for view details 
     */
    protected function generate_detail_view($data = NULL, $user_config = array(), $view_template = 'elements/detail_tpl') {
        /** auto field type detect Start* */
        $config = $this->auto_fieldtype_detect($user_config);
        /** auto field type detect End* */
        /** dropdown */
        $config['use_dropdown_columns_options'] = isset($user_config['use_dropdown_columns_options']) ? $user_config['use_dropdown_columns_options'] : array();

        /** image */
        if (!isset($user_config['use_image_columns_path'])) {
            $user_config['use_image_columns_path'] = base_url() . 'uploads/' . NODE . '/';
        }
        $config['use_image_columns'] = is_string(@$user_config['use_image_columns']) ? explode(',', $user_config['use_image_columns']) : NULL;
        $config['use_image_columns_path'] = is_string(@$user_config['use_image_columns_path']) ? explode(',', $user_config['use_image_columns_path']) : $user_config['use_image_columns_path'];
         /** image */
        // if (!isset($admin_config['use_image_columns_path'])) {
        //     $admin_config['use_image_columns_path'] = base_url() . 'uploads/' . NODE . '/';
        // }
        // $config['use_image_columns'] = is_string(@$admin_config['use_image_columns']) ? explode(',', $admin_config['use_image_columns']) : NULL;
        // $config['use_image_columns_path'] = is_string(@$admin_config['use_image_columns_path']) ? explode(',', $admin_config['use_image_columns_path']) : $admin_config['use_image_columns_path'];

        // if (!isset($admin_config['use_file_columns_path'])) {
        //     $admin_config['use_file_columns_path'] = base_url() . 'uploads/' . NODE . '/';
        // }
        // $config['use_file_columns'] = is_string(@$admin_config['use_file_columns']) ? explode(',', $admin_config['use_file_columns']) : NULL;
        // $config['use_file_columns_path'] = is_string(@$admin_config['use_file_columns_path']) ? explode(',', $admin_config['use_file_columns_path']) : $admin_config['use_file_columns_path'];



   /** imageuploader */
        $config['multi_upload'] = isset($user_config['multi_upload']) ? ($user_config['multi_upload'] ? 'true' : 'false') : 'false';

        $tabledata['table_meta']['config'] = $config;
        $tabledata['table_meta']['data'] = isset($data) ? $data : NULL;


        return $this->render($tabledata, $view_template, true, false, false);
    }

    /**
     * generate view for add or edit  details 
     */
    protected function generate_form_view($data = NULL, $user_config = array(), $view_template = 'elements/add_edit_tpl') {
        /** auto field type detect Start* */
        $config = $this->auto_fieldtype_detect($user_config);
        /** auto field type detect End* */
        /*         * validation */

        $config['validation'] = is_array(@$user_config['validation']) ? $user_config['validation'] : array();

        /** image */
        if (!isset($user_config['use_image_columns_path'])) {
            $user_config['use_image_columns_path'] = base_url() . 'uploads/' . NODE . '/';
        }
        $config['use_image_columns'] = is_string(@$user_config['use_image_columns']) ? explode(',', $user_config['use_image_columns']) : NULL;
        $config['use_image_columns_path'] = is_string(@$user_config['use_image_columns_path']) ? explode(',', $user_config['use_image_columns_path']) : $user_config['use_image_columns_path'];
         /** image */
        // if (!isset($admin_config['use_image_columns_path'])) {
        //     $admin_config['use_image_columns_path'] = base_url() . 'uploads/' . NODE . '/';
        // }
        // $config['use_image_columns'] = is_string(@$admin_config['use_image_columns']) ? explode(',', $admin_config['use_image_columns']) : NULL;
        // $config['use_image_columns_path'] = is_string(@$admin_config['use_image_columns_path']) ? explode(',', $admin_config['use_image_columns_path']) : $admin_config['use_image_columns_path'];

        // if (!isset($admin_config['use_file_columns_path'])) {
        //     $admin_config['use_file_columns_path'] = base_url() . 'uploads/' . NODE . '/';
        // }
        // $config['use_file_columns'] = is_string(@$admin_config['use_file_columns']) ? explode(',', $admin_config['use_file_columns']) : NULL;
        // $config['use_file_columns_path'] = is_string(@$admin_config['use_file_columns_path']) ? explode(',', $admin_config['use_file_columns_path']) : $admin_config['use_file_columns_path'];

        

        /** dropdown */
        $config['use_dropdown_columns_options'] = isset($user_config['use_dropdown_columns_options']) ? $user_config['use_dropdown_columns_options'] : array();


        /** imageuploader */
        $config['multi_upload'] = isset($user_config['multi_upload']) ? ($user_config['multi_upload'] ? 'true' : 'false') : 'false';

        /** readonly */
        $config['readonly_columns'] = is_string(@$user_config['readonly_columns']) ? explode(',', $user_config['readonly_columns']) : NULL;


        $tabledata['table_meta']['config'] = $config;
        $tabledata['table_meta']['data'] = isset($data) ? $data : NULL;

        return $this->render($tabledata, $view_template, true, false, false);
    }

    /**
     * Detect entry field type from database column type
     */
    protected function auto_fieldtype_detect($user_config = NULL) {
        if (file_exists(ROOTPATH . 'fastapp/cachefiles/' . NODE . '/field' . $this->targetModel . '.txt')) {
            $config = json_decode(file_get_contents(ROOTPATH . 'fastapp/cachefiles/' . NODE . '/field' . $this->targetModel . '.txt'), true);
        } else {

            $tableFieldMeta = $this->{$this->targetModel}->get_field_list();
            $autoTextArea = NULL;
            $autoDatePicker = NULL;
            $autoDateTimePicker = NULL;
            $autoStatus = NULL;
            $primaryKey = NULL;
	    $generalInput = null;	
            foreach ($tableFieldMeta[0] as $key => $value) {
                if ($value['Type'] == 'text' || $value['Type'] == 'longtext') {
                    $autoTextArea[] = $key;
                }else
                if ($value['Type'] == 'date') {
                    $autoDatePicker[] = $key;
                }else
                if ($value['Type'] == 'datetime') {
                    $autoDateTimePicker[] = $key;
                }else
                if ($value['Type'] == 'tinyint(1)') {
                    $autoStatus[] = $key;
                }else
                if ($value['Key'] == 'PRI') {
                    $primaryKey = $key;
                }else{
		$generalInput[] =  $key;
		}
            }
            /*             * textarea */
            $config['textarea_columns'] = is_string(@$user_config['textarea_columns']) ? explode(',', $user_config['textarea_columns']) : $autoTextArea;
            /*             * datetimepicker */
            $config['datetimepicker_columns'] = is_string(@$user_config['datetimepicker_columns']) ? explode(',', $user_config['datetimepicker_columns']) : $autoDateTimePicker;
            /*             * datepicker */
            $config['datepicker_columns'] = is_string(@$user_config['datepicker_columns']) ? explode(',', $user_config['datepicker_columns']) : $autoDatePicker;
            /*             * status */
            $config['use_status_columns'] = is_string(@$user_config['use_status_columns']) ? explode(',', $user_config['use_status_columns']) : $autoStatus;
            /*             * PRIMARY KEY */
            $config['tablePrimaryKey'] = is_string(@$user_config['tablePrimaryKey']) ? $user_config['tablePrimaryKey'] : $primaryKey;
	 
	$config['generalInput'] = $generalInput;	
            /** auto field type detect End* */
            file_put_contents(ROOTPATH . 'fastapp/cachefiles/' . NODE . '/field' . $this->targetModel . '.txt', json_encode($config));
        }
        return $config;
    }

    protected function menu_generater() {

        // Determine if current user is Super Admin
        $isSuperAdmin = !empty($this->current_user_session['user_type_super'])
            || (isset($this->current_user_session['user_type_id']) && $this->current_user_session['user_type_id'] == 1);

        $userTypeId = isset($this->current_user_session['user_type_id'])
            ? intval($this->current_user_session['user_type_id']) : 0;

        // Role-specific cache file
        $cacheDir  = ROOTPATH . 'fastapp/cachefiles/' . NODE;
        $cacheFile = $cacheDir . '/menu_cache_' . ($isSuperAdmin ? 'super' : $userTypeId) . '.txt';

        if (file_exists($cacheFile)) {
            return json_decode(file_get_contents($cacheFile), true);
        }

        // --- Build menu from DB (SELECT * FROM menus) ---
        $processedMenu = array();

        // Fetch all top-level menus (menu_parent_id = 0)
        if ($isSuperAdmin) {
            // Super Admin: show ONLY super‑admin specific menus (menu_user_type_id = 1)
            $topMenus = $this->menus_model->get_list_for_dropdown(false, array(
                'menu_parent_id'    => '0',
                'menu_user_type_id'=> 1,
            ));
        } else {
            // Regular user: only menus matching their role
            $topMenus = $this->menus_model->get_list_for_dropdown(false, array(
                'menu_parent_id'    => '0',
                'menu_user_type_id' => $userTypeId,
            ));
        }

        if (is_array($topMenus)) {
            foreach ($topMenus as $key => $value) {
                if (!is_array($value) || !isset($value['menu_ID'])) continue;
                $processedMenu[$key] = $value;

                // Fetch children
                if ($isSuperAdmin) {
                    $subMenu = $this->menus_model->get_list_for_dropdown(false, array(
                        'menu_parent_id'    => $value['menu_ID'],
                        'menu_user_type_id'=> 1,
                    ));
                } else {
                    $subMenu = $this->menus_model->get_list_for_dropdown(false, array(
                        'menu_parent_id'    => $value['menu_ID'],
                        'menu_user_type_id' => $userTypeId,
                    ));
                }

                if (is_array($subMenu)) {
                    foreach ($subMenu as $skey => $svalue) {
                        if (is_array($svalue) && isset($svalue['menu_ID'])) {
                            $processedMenu[$skey] = $svalue;
                        }
                    }
                }
            }
        }

        // --- Merge module menus from config.json (only for entries NOT already in DB) ---
        // Build a lookup of existing DB menus by menu_link and menu_name to prevent duplicates.
        // DB uses integer keys (20,27...) while config.json uses string keys ("billing","purchase"...)
        // so key-based check alone is not enough — we must compare by link+name.
        $dbMenuLinks = array();
        $dbMenuNames = array();
        foreach ($processedMenu as $dbItem) {
            if (!empty($dbItem['menu_link'])) {
                $dbMenuLinks[strtolower(trim($dbItem['menu_link']))] = true;
            }
            if (!empty($dbItem['menu_name'])) {
                $dbMenuNames[strtolower(trim($dbItem['menu_name']))] = true;
            }
        }

        $moduleMenuList = array();
        // Only load from config.json if DB returned zero menus (fallback mode)
        if (empty($processedMenu)) {
            $moduleMeta = $this->get_modules();
            if ($moduleMeta) {
                foreach ($moduleMeta as $moduleData) {
                    $configFile = ROOTPATH . 'modules/' . $moduleData . '/config.json';
                    if (!file_exists($configFile)) continue;
                    $moduleMenu = json_decode(read_file($configFile), TRUE);
                    if (isset($moduleMenu['menu']) && is_array($moduleMenu['menu'])) {
                        foreach ($moduleMenu['menu'] as $mItem) {
                            if (!isset($mItem['menu_ID'])) continue;
                            if ($isSuperAdmin) {
                                $moduleMenuList[$mItem['menu_ID']] = $mItem;
                            } elseif (!isset($mItem['menu_user_type_id']) || intval($mItem['menu_user_type_id']) == $userTypeId) {
                                $moduleMenuList[$mItem['menu_ID']] = $mItem;
                            }
                        }
                    }
                }
            }
        } else {
            // DB has menus — only add config.json entries that are genuinely missing
            // (not already covered by DB rows, checked by link AND name)
            $moduleMeta = $this->get_modules();
            if ($moduleMeta) {
                foreach ($moduleMeta as $moduleData) {
                    $configFile = ROOTPATH . 'modules/' . $moduleData . '/config.json';
                    if (!file_exists($configFile)) continue;
                    $moduleMenu = json_decode(read_file($configFile), TRUE);
                    if (isset($moduleMenu['menu']) && is_array($moduleMenu['menu'])) {
                        foreach ($moduleMenu['menu'] as $mItem) {
                            if (!isset($mItem['menu_ID'])) continue;
                            // Skip if DB already has a menu with the same link or name
                            $mLink = strtolower(trim(isset($mItem['menu_link']) ? $mItem['menu_link'] : ''));
                            $mName = strtolower(trim(isset($mItem['menu_name']) ? $mItem['menu_name'] : ''));
                            if (isset($dbMenuLinks[$mLink]) && $mLink !== '') continue;
                            if (isset($dbMenuNames[$mName]) && $mName !== '') continue;
                            // Also skip if key already present
                            if (isset($processedMenu[$mItem['menu_ID']])) continue;
                            // Permission filter
                            if ($isSuperAdmin) {
                                $moduleMenuList[$mItem['menu_ID']] = $mItem;
                            } elseif (!isset($mItem['menu_user_type_id']) || intval($mItem['menu_user_type_id']) == $userTypeId) {
                                $moduleMenuList[$mItem['menu_ID']] = $mItem;
                            }
                        }
                    }
                }
            }
        }

        $finalMenu = $moduleMenuList + $processedMenu;

        // Write role-specific cache
        if (!is_dir($cacheDir)) {
            @mkdir($cacheDir, 0777, true);
        }
        file_put_contents($cacheFile, json_encode($finalMenu));

        return $finalMenu;
    }

    /*
     * generic CRUD function in basic format
     *
     * * */

    /**
     * add detail
     */
    public function add_detail() {
        $postedData = $this->input->post();
        $config = $this->auto_fieldtype_detect(NULL);
        $this->page_config = array_merge($config, $this->page_config);
        if (isset($postedData['load_add_entry'])) {
            $entryData = $this->{$this->targetModel}->get_field_list();
            echo $this->generate_form_view($entryData[0], $this->page_config);
        } else {
            if ($postedData) {
                
               //pr($postedData);
                /** status* */
                $config = $this->auto_fieldtype_detect(NULL);
                if (isset($config['use_status_columns'])) {
                    foreach ($config['use_status_columns'] as $statusColumn) {
                        $postedData[$statusColumn] = isset($postedData[$statusColumn]) ? 1 : 0;
                    }
                }
                /*                 * multi chooser */
                if (isset($this->page_config['use_dropdown_columns_options']['multi'])) {
                    foreach ($this->page_config['use_dropdown_columns_options']['multi'] as $multiChooser => $multi) {
                        if (isset($postedData[$multiChooser]))
                            $postedData[$multiChooser] = is_array($postedData[$multiChooser]) ? json_encode($postedData[$multiChooser]) : json_encode(array());
                        else
                            $postedData[$multiChooser] = '["0"]';
                    }
                }
                $lastInsertedID = $this->{$this->targetModel}->insert_data($postedData);

                echo (json_encode(array('status' => 'success', 'message' => 'Data Added Successfully')));
            }
        }
    }

    /**
     * edit detail
     */
    public function edit_detail() {
        $postedData = $this->input->post();
        $config = $this->auto_fieldtype_detect(NULL);
        $this->page_config = array_merge($config, $this->page_config);
        if (isset($postedData['load_edit_entry'])) {
            
            $entryData2 = $this->{$this->targetModel}->get_list(array($this->{$this->targetModel}->get_primary_key() => trim($postedData['load_edit_entry'])));
            $entryData1 = $this->{$this->targetModel}->get_field_list();
            $entryData = array_intersect_key($entryData2[0], $entryData1[0]);
           
            echo $this->generate_form_view($entryData, $this->page_config);
        } else {
            if ($postedData) {
                /** status* */
                if (isset($config['use_status_columns'])) {
                    foreach ($config['use_status_columns'] as $statusColumn) {
                        $postedData[$statusColumn] = isset($postedData[$statusColumn]) ? 1 : 0;
                    }
                }
                /*                 * multi chooser */
                if (isset($this->page_config['use_dropdown_columns_options']['multi'])) {
                    foreach ($this->page_config['use_dropdown_columns_options']['multi'] as $multiChooser => $multi) {
                        $postedData[$multiChooser] = @is_array($postedData[$multiChooser]) ? json_encode($postedData[$multiChooser]) : json_encode(array());
                    }
                }

                $this->{$this->targetModel}->update_data($postedData, array($config['tablePrimaryKey'] => $postedData[$config['tablePrimaryKey']]));
                echo (json_encode(array('status' => 'success', 'message' => 'Data Updated Successfully')));
            }
        }
    }

    /**
     * view detail
     */
    public function view_detail() {
        $config = $this->auto_fieldtype_detect(NULL);
        $this->page_config = array_merge($config, $this->page_config);
        $entryID = trim($this->input->post('entry'));
        $entryData2 = $this->{$this->targetModel}->get_list(array($this->page_config['tablePrimaryKey'] => $entryID));
        $entryData1 = $this->{$this->targetModel}->get_field_list();
        $entryData = array_intersect_key($entryData2[0], $entryData1[0]);
        
        echo $this->generate_detail_view($entryData, $this->page_config);
    }

    public function autocomplete() {
        $field = $this->uri->segment(5);
        $model = $this->uri->segment(4);
        if(strpos($model,'_model')===false){
            $model.='_model';
        }
        $search = $this->input->get('term');
        $data = ($this->{$model}->get_list_for_dropdown($field, NULL, NULL, 10, NULL, array($field => $search)));
        $responce = null;
        foreach ($data as $id => $value) {
            $responce[] = array('id' => $id, 'label' => $value, 'value' => $value, 'complete' => $value);
        }
        echo json_encode($responce);
    }

    /**
     * delete
     */
    public function delete() {
        $postedData = $this->input->post();
        $config = $this->auto_fieldtype_detect(NULL);
        $this->page_config = array_merge($config, $this->page_config);
        if (isset($postedData['selectedItem'])) {
            $this->{$this->targetModel}->delete(array($this->page_config['tablePrimaryKey'] => $postedData['selectedItem']), TRUE);
        }

        if (isset($postedData['entry'])) {
            $this->{$this->targetModel}->delete(array($this->page_config['tablePrimaryKey'] => $postedData['entry']));
        }
        echo json_encode(array('status' => 'success'));
    }

    /**
     * index show list
     */
    public function index() {

        $config = $this->auto_fieldtype_detect(NULL);
        $this->page_config = array_merge($config, $this->page_config);

        $orderBy = $this->orderby_input_process();
        $likeCondition = $this->generate_search_like_condition();
        $allData = $this->{$this->targetModel}->get_list_for_tables(NULL, FALSE, $this->current_site_settings['site_setting_record_per_page'], NULL, $likeCondition, $orderBy);
        $data['generateTableView'] = $this->generate_table_view($allData, $this->page_config);
        if ($this->input->post()) {
            echo $data['generateTableView'];
        } else {
            $data['generateTableSearch'] = $this->generate_table_search_view($this->page_config);
            $this->render($data);
        }
    }

    /*     * some of helper function* */

    protected function orderby_input_process() {
        $orderBy = '';
        if (isset($_COOKIE['orderBy_' . $this->targetModel])) {
            $orderByArr = explode(':', $_COOKIE['orderBy_' . $this->targetModel]);
            $orderBy = $orderByArr[0] . ' ' . $orderByArr[1];
        }
        return $orderBy;
    }

    protected function generate_search_like_condition() {
        $config = $this->auto_fieldtype_detect(NULL);
        $posted = $this->input->post();
        if (empty($posted) || !is_array($posted)) {
            return NULL;
        }
        unset($posted['dummy'], $posted['_ajax'], $posted['ajax'], $posted['is_ajax_req'], $posted['selectedItem']);
        if (isset($config['use_status_columns'])) {
            foreach ($config['use_status_columns'] as $statusColumn) {
                unset($posted[$statusColumn]);
            }
        }
        foreach ($posted as $k => $p) {
            if (empty($p)) {
                unset($posted[$k]);
            }
        }
        if (!empty($this->page_config['searchFields'])) {
            $allowedSearch = array_map('trim', explode(',', $this->page_config['searchFields']));
            foreach ($posted as $k => $p) {
                if (!in_array($k, $allowedSearch)) {
                    unset($posted[$k]);
                }
            }
        }
        return !empty($posted) ? $posted : NULL;
    }

    public function chooseUpload() {
        $mimeTypes = explode(',', $this->input->post('mimeTypes'));
        $dirMap = directory_map('./uploads/' . NODE);
        $dataArray = [];
        foreach ($dirMap as  $value) {
            $currentFile = explode('.', $value);
            if (array_search($currentFile[1], $mimeTypes) !== FALSE) {
                $dataArray[] = $value;
            }
        }
        echo json_encode($dataArray);
    }

	private function load_model($tablename){
		require_once(ROOTPATH.'fastapp/models/dynamic_model.php');
	       $this->{$tablename.'_model'} = new Dynamic_model($tablename);	
	}
    /*
     * not translated
     * * */

    private function show_error_page($code = null, $message = null) {
        if ($this->uri->segment(1) == 'console') {
            if ($code == 403) {
                $msgText = !empty($message) ? $message : 'Permission Denied: You do not have permission to access this page.';
                $redirectUrl = isset($this->current_user_session['user_ID']) ? console_url() . 'dashboard' : console_url() . 'user/login';

                if ($this->input->is_ajax_request()) {
                    header('Content-Type: application/json');
                    echo json_encode(array('status' => 'error', 'message' => $msgText));
                    exit();
                }

                $msgBody = '<div style="padding: 20px; font-family: -apple-system, BlinkMacSystemFont, \'Segoe UI\', Roboto, Arial, sans-serif;">'
                    . '<p style="font-size: 16px; color: #a94442; background-color: #f2dede; border: 1px solid #ebccd1; border-radius: 4px; padding: 15px; margin-bottom: 20px;">'
                    . '<strong>&#9888; Permission Denied:</strong> ' . htmlspecialchars($msgText)
                    . '</p>'
                    . '<p style="color: #666; font-size: 14px;">'
                    . 'Redirecting to Dashboard in 3 seconds... '
                    . '<a href="' . $redirectUrl . '" style="color: #337ab7; text-decoration: underline; font-weight: bold;">Click here if not redirected automatically</a>'
                    . '</p>'
                    . '<script>setTimeout(function(){ window.location="' . $redirectUrl . '"; }, 3000);</script>'
                    . '</div>';

                show_error($msgBody, 403, 'Access Denied: Permission Required');
                return;
            }

            if ($code == 401) {
                $redirectUrl = console_url() . 'user/login';
                $msgText = !empty($message) ? $message : 'Please login to continue.';
                $msgBody = '<script>window.location="' . $redirectUrl . '"</script>' . $msgText;
                show_error($msgBody, 401, 'Please Login');
                return;
            }

            $msgBody = (!empty($message) ? $message : 'Please wait...') . '<script>setTimeout(function(){ window.location="' . console_url() . 'dashboard"; }, 2000);</script>';
            show_error($msgBody, $code, 'Notice');
        } else {
            $msgText = !empty($message) ? $message : 'Content is not available..please wait, while we are redirecting.';
            $message = $code . ': ' . $msgText . '<script>setTimeout(function(){ window.location="' . base_url() . '"; }, 2000);</script>';
            show_error($message, $code, 'Oops!! Please wait...');
        }
    }

    public function quick_edit() {
        $config = $this->auto_fieldtype_detect(NULL);
        $this->page_config = array_merge($config, $this->page_config);
        $postedData = $this->input->post();
        $field = explode('-', $postedData['targetItem']);
        $dataToSave = null;
        $dataToSave[$this->page_config['tablePrimaryKey']] = intval($field[1]);
        $dataToSave[$field[0]] = $postedData['targetValue'];
        $this->{$this->targetModel}->update_data($dataToSave, array($this->page_config['tablePrimaryKey'] => $dataToSave[$this->page_config['tablePrimaryKey']]));
        echo (json_encode(array('status' => 'success', 'message' => 'Data Updated Successfully')));
    }

    protected function set_user_session($user_ID) {
        $userData = $this->users_model->get_list(array('user_ID' => $user_ID));
        $this->session->set_userdata('current_user_session', $userData[0]);
    }

}
