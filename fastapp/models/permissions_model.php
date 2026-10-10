<?php

/**
 *
 * @author kALLOL
 * 
 * 
 */
class Permissions_model extends MY_Model {
    //put your code here
    
    public $table_name;
    public function __construct() {
        parent::__construct();
        $this->table_name = 'permissions';
        $this->check();
    }
 public function install() {
       $this->db->query("CREATE TABLE `permissions` (
  `permission_ID` int(11) NOT NULL,
  `permission_user_type_id` int(11) NOT NULL,
  `permission_controller` varchar(50) NOT NULL,
  `permission_type` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;");

        $this->db->query("INSERT INTO `permissions` (`permission_ID`, `permission_user_type_id`, `permission_controller`, `permission_type`) VALUES
(15, 2, 'site_setting', 'index'),
(16, 2, 'site_setting', 'edit_detail');");
        
        $this->db->query("ALTER TABLE `permissions`
  ADD PRIMARY KEY (`permission_ID`);
");
        
        $this->db->query("ALTER TABLE `permissions`
  MODIFY `permission_ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=17;");
    }

    /**
     * get the list of all data in table 
     */
   
}

?>
