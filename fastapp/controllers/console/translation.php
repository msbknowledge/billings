<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

/**
 * Description of home
 *
 * @author Kallol
 */
class Translation extends MY_Controller {

    //put your code here

    public function __construct() {
        parent::__construct();

        $this->targetModel = 'translations_model';
        $this->page_config['tablePrimaryKey'] = $this->translations_model->get_primary_key(); //pk
        /*         * page_config* */
        $this->page_config['title'] = 'Translation'; //search title bar
        $this->page_config['searchFields'] = 'translation_language_id,translation_key,translation_value'; //search box,


        $this->page_config['use_dropdown_columns'] = 'translation_language_id';
        $this->page_config['use_dropdown_columns_options']['translation_language_id'] = $this->languages_model->get_list_for_dropdown('language_name');


        /*         * end page_config* */
    }

}

?>
