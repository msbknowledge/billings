<?php
if (!defined('BASEPATH')) exit('No direct script access allowed');

class Customer_order extends MY_Controller {

    public function __construct() {
        parent::__construct();
        $this->targetModel = 'customer_orders_model';
        $this->load->model('customer_orders_model');
        $this->page_config['title'] = 'Online Medicine Orders';
    }

    public function index() {
        $status_filter = $this->input->get('status', TRUE);
        $search = trim($this->input->get('search', TRUE) ?: '');

        $this->db->from('customer_orders');
        if (!empty($status_filter) && $status_filter !== 'all') {
            $this->db->where('status', $status_filter);
        }
        if (!empty($search)) {
            $term_esc = $this->db->escape_like_str($search);
            $this->db->where("(order_code LIKE '%{$term_esc}%' OR customer_name LIKE '%{$term_esc}%' OR phone LIKE '%{$term_esc}%' OR medicine_name LIKE '%{$term_esc}%')", NULL, FALSE);
        }
        $this->db->order_by('id', 'DESC');
        $orders = $this->db->get()->result_array();

        // Calculate summary counts
        $total_orders = $this->db->count_all('customer_orders');
        $placed_orders = $this->db->where('status', 'Order Placed')->count_all_results('customer_orders');
        $delivery_orders = $this->db->where('status', 'Out for Delivery')->count_all_results('customer_orders');
        $completed_orders = $this->db->where('status', 'Delivered')->count_all_results('customer_orders');

        $data = [
            'orders' => $orders,
            'status_filter' => $status_filter,
            'search' => $search,
            'summary' => [
                'total' => $total_orders,
                'placed' => $placed_orders,
                'out_for_delivery' => $delivery_orders,
                'delivered' => $completed_orders
            ]
        ];

        $this->render($data, 'table_tpl');
    }

    public function update_status() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $id = intval($this->input->post('id', TRUE));
            $new_status = trim($this->input->post('status', TRUE));

            $allowed = ['Order Placed', 'Confirmed & Packing', 'Out for Delivery', 'Delivered', 'Cancelled'];
            if ($id > 0 && in_array($new_status, $allowed)) {
                $this->db->where('id', $id)->update('customer_orders', ['status' => $new_status]);
                
                if ($this->input->is_ajax_request()) {
                    header('Content-Type: application/json');
                    echo json_encode(['status' => 'success', 'message' => 'Order status updated successfully']);
                    return;
                }
            }
        }
        redirect(console_url('customer_order'));
    }

    public function view_detail($id = null) {
        $id = intval($id);
        $order = $this->db->where('id', $id)->get('customer_orders')->row_array();
        if ($this->input->is_ajax_request()) {
            header('Content-Type: application/json');
            if ($order) {
                echo json_encode(['status' => 'success', 'order' => $order]);
            } else {
                echo json_encode(['status' => 'error', 'message' => 'Order not found']);
            }
            return;
        }
        redirect(console_url('customer_order'));
    }

    public function delete($id = null) {
        $id = intval($id);
        if ($id > 0) {
            $this->db->where('id', $id)->delete('customer_orders');
        }
        redirect(console_url('customer_order'));
    }
}
