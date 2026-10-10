<?php
/**
 *
 * @author kallol
 */
class Regions_model extends MY_Model {

    //put your code here

    public $table_name;

    public function __construct() {
        parent::__construct();
        $this->table_name = 'regions';
        $this->check();
    }
 public function install() {
       $this->db->query("CREATE TABLE `regions` (
  `region_ID` int(10) NOT NULL,
  `region_iso` char(2) NOT NULL,
  `region_name` varchar(64) NOT NULL,
  `region_native` varchar(64) DEFAULT NULL,
  `region_language` varchar(64) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;");

       
        
        $this->db->query("ALTER TABLE `regions`
  ADD PRIMARY KEY (`region_ID`);
");
        
        $this->db->query("ALTER TABLE `regions`
  MODIFY `region_ID` int(10) NOT NULL AUTO_INCREMENT;");
    }
  

    /**
     * get the list of all data in table 
     */
}

?>
