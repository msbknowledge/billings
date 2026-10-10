<?php


/**
 *
 * @author kallol
 */
class Languages_model extends MY_Model {

    //put your code here

    public $table_name;

    public function __construct() {
        parent::__construct();
        $this->table_name = 'languages';
    $this->check();
    }
 public function install() {
       $this->db->query("CREATE TABLE `languages` (
  `language_id` int(10) UNSIGNED NOT NULL,
  `language_iso` char(10) NOT NULL,
  `language_name` varchar(64) NOT NULL COMMENT 'name in english language',
  `language_native` varchar(64) NOT NULL COMMENT 'name in native language',
  `language_directory` varchar(64) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;");

        $this->db->query("INSERT INTO `languages` (`language_id`, `language_iso`, `language_name`, `language_native`, `language_directory`) VALUES
(1, 'EN', 'English', 'English', 'english'),
(9, 'BEN', 'BENGALI', '?????', '');");
        
        $this->db->query("ALTER TABLE `languages`
  ADD PRIMARY KEY (`language_id`);
");
        
        $this->db->query("ALTER TABLE `languages`
  MODIFY `language_id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;");
    }

    
    /**
     * get the list of all data in table 
     */
}

?>
