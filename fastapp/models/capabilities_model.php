<?php

/**
 *
 * @author kALLOL
 * 
 * 
 */
class Capabilities_model extends MY_Model {

    //put your code here

    public $table_name;

    public function __construct() {
        parent::__construct();
        $this->table_name = 'capabilities';
   $this->check();
    }
 public function install() {
       $this->db->query("CREATE TABLE `capabilities` (
  `capability_id` int(11) NOT NULL,
  `capability_user_type` int(11) DEFAULT NULL,
  `capability_controller` varchar(45) DEFAULT NULL,
  `capability_actions` text
) ENGINE=InnoDB DEFAULT CHARSET=latin1;");

$this->db->query("INSERT INTO `capabilities` (`capability_id`, `capability_user_type`, `capability_controller`, `capability_actions`) VALUES
(1, 2, 'dashboard', '*'),
(3, 2, 'capability', '*'),
(4, 0, 'user', 'login,forgot_password'),
(15, 2, 'user', '*'),
(16, 2, 'user_type', '*'),
(17, 2, 'site_setting', '*'),
(18, 2, 'module', '*'),
(21, 4, 'dashboard', '*'),
(23, 6, 'user', 'profile,logout,login'),
(24, 0, 'module', '*'),
(26, 3, 'user', 'profile,logout,login'),
(27, 3, 'module', '*'),
(29, 4, 'uploader', '*'),
(30, 2, 'uploader', '*'),
(31, 0, 'uploader', '*'),
(32, 2, 'option', '*'),
(33, 2, 'menu', '*'),
(34, 2, 'language', '*'),
(35, 2, 'region', '*'),
(36, 2, 'region_language', '*'),
(38, 2, 'category', '*'),
(39, 2, 'translation', '*'),
(40, 2, 'content', '*'),
(41, 3, 'dashboard', '*'),
(42, 2, 'parts_invoice', '*'),
(43, 2, 'listing_category', '*'),
(44, 2, 'listing_field', '*'),
(45, 2, 'listing', '*'),
(46, 2, 'customer', '*'),
(47, 2, 'package', '*'),
(48, 2, 'channel', '*'),
(49, 2, 'collection', '*'),
(50, 2, 'invoice', '*'),
(51, 2, 'agent', '*'),
(52, 2, 'internet_billing', '*'),
(53, 2, 'internet_tax', '*'),
(54, 2, 'internet_agent', '*'),
(55, 2, 'internet_collection', '*'),
(56, 2, 'internet_package', '*'),
(57, 2, 'internet_customer', '*'),
(58, 2, 'internet_invoice', '*'),
(59, 6, 'dashboard', '*'),
(60, 6, 'invoice', '*'),
(61, 6, 'invoice', '*'),
(62, 6, 'customer', '*'),
(63, 6, 'user', '*'),
(64, 6, 'internet_invoice', '*'),
(65, 6, 'internet_customer', '*'),
(66, 2, 'tax', '*'),
(67, 2, 'parts', '*'),
(68, 2, 'import', '*'),
(70, 2, 'internet_import', '*');
");
        
        $this->db->query("ALTER TABLE `capabilities`
  ADD PRIMARY KEY (`capability_id`);
");
        
        $this->db->query("ALTER TABLE `capabilities`
  MODIFY `capability_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=72;");
    }
}

?>
