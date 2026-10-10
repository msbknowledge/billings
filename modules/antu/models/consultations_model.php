<?php
if (!defined('BASEPATH')) exit('No direct script access allowed');

class Consultations_model extends MY_Model {

    public $table_name;

    public function __construct() {
        parent::__construct();
        $this->table_name = 'consultations';
        $this->check();
    }

    public function install() {
        $this->db->query("CREATE TABLE IF NOT EXISTS `consultations` (
            `id` int(11) NOT NULL AUTO_INCREMENT,
            `doctor_id` int(11) DEFAULT NULL,
            `patient_name` varchar(150) NOT NULL,
            `phone` varchar(30) NOT NULL,
            `email` varchar(100) DEFAULT NULL,
            `department` varchar(100) DEFAULT NULL,
            `preferred_date` date DEFAULT NULL,
            `preferred_time` varchar(50) DEFAULT NULL,
            `message` text DEFAULT NULL,
            `status` varchar(30) DEFAULT 'Scheduled',
            `created_at` datetime DEFAULT current_timestamp(),
            PRIMARY KEY (`id`)
        ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;");
    }
}
