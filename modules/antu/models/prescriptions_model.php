<?php
if (!defined('BASEPATH')) exit('No direct script access allowed');

class Prescriptions_model extends MY_Model {

    public $table_name;

    public function __construct() {
        parent::__construct();
        $this->table_name = 'prescriptions';
        $this->check();
    }

    public function install() {
        $this->db->query("CREATE TABLE IF NOT EXISTS `prescriptions` (
            `id` int(11) NOT NULL AUTO_INCREMENT,
            `patient_name` varchar(150) NOT NULL,
            `phone` varchar(30) NOT NULL,
            `email` varchar(100) DEFAULT NULL,
            `address` text DEFAULT NULL,
            `prescription_file` varchar(255) NOT NULL,
            `notes` text DEFAULT NULL,
            `status` varchar(50) DEFAULT 'Pending Pharmacist Review',
            `created_at` datetime DEFAULT current_timestamp(),
            PRIMARY KEY (`id`)
        ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;");
    }
}
