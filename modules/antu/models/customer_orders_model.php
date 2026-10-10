<?php
if (!defined('BASEPATH')) exit('No direct script access allowed');

class Customer_orders_model extends MY_Model {

    public $table_name;

    public function __construct() {
        parent::__construct();
        $this->table_name = 'customer_orders';
        $this->check();
    }

    public function install() {
        $this->db->query("CREATE TABLE IF NOT EXISTS `customer_orders` (
            `id` int(11) NOT NULL AUTO_INCREMENT,
            `order_code` varchar(50) NOT NULL,
            `customer_name` varchar(150) NOT NULL,
            `phone` varchar(30) NOT NULL,
            `email` varchar(100) DEFAULT NULL,
            `delivery_address` text NOT NULL,
            `medicine_id` int(11) DEFAULT NULL,
            `medicine_name` varchar(200) NOT NULL,
            `quantity` int(11) DEFAULT 1,
            `payment_method` varchar(50) DEFAULT 'Cash on Delivery',
            `order_notes` text DEFAULT NULL,
            `status` varchar(50) DEFAULT 'Order Placed',
            `created_at` datetime DEFAULT current_timestamp(),
            PRIMARY KEY (`id`)
        ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;");
    }
}
