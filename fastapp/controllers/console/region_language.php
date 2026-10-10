<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of home
 *
 * @author Kallol
 */
class Region_language extends MY_Controller {

    //put your code here

    public function __construct() {
        parent::__construct();

        $this->targetModel = 'region_languages_model';
        $this->page_config['tablePrimaryKey'] = $this->region_languages_model->get_primary_key(); //pk
        /*         * page_config* */
        $this->page_config['title'] = 'Region Languages'; //search title bar
        $this->page_config['searchFields'] = 'regions_language_region_id,regions_language_language_id'; //search box,
        
        $this->page_config['use_dropdown_columns'] = 'regions_language_region_id,regions_language_language_id';
        $this->page_config['use_dropdown_columns_options']['regions_language_region_id'] = $this->regions_model->get_list_for_dropdown('region_name');
        $this->page_config['use_dropdown_columns_options']['regions_language_language_id'] = $this->languages_model->get_list_for_dropdown('language_name');


        /*         * end page_config* */
    }

}

?>
