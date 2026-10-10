<?php

/**
 *
 * @author kallol
 */
class Region_languages_model extends MY_Model {

    //put your code here

    public $table_name;

    public function __construct() {
        parent::__construct();
        $this->table_name = 'regions_languages';
        $this->joiningArray[0]['table'] = 'regions';
        $this->joiningArray[1]['table'] = 'languages';
        $this->joiningArray[0]['condition'] = 'region_ID = regions_language_region_id';
        $this->joiningArray[1]['condition'] = 'language_ID = regions_language_language_id';
   $this->check();
    }
 public function install() {
       $this->db->query("CREATE TABLE `regions_languages` (
  `region_language_ID` int(11) NOT NULL,
  `regions_language_region_id` int(10) UNSIGNED NOT NULL,
  `regions_language_language_id` int(10) UNSIGNED NOT NULL,
  `priority` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;");

        $this->db->query("INSERT INTO `regions_languages` (`region_language_ID`, `regions_language_region_id`, `regions_language_language_id`, `priority`) VALUES
(1, 1, 3, 1),
(2, 1, 1, 0);");
        
        $this->db->query("ALTER TABLE `regions_languages`
  ADD PRIMARY KEY (`region_language_ID`);
");
        
        $this->db->query("ALTER TABLE `regions_languages`
  MODIFY `region_language_ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;");
    }
  
    /**
     * get the list of all data in table 
     */
}

?>
