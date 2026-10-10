<?php
if (!defined('BASEPATH')) exit('No direct script access allowed');

class Prescription extends MY_Controller {

    public function __construct() {
        parent::__construct();
        $this->targetModel = 'prescriptions_model';
        $this->load->model('prescriptions_model');
        $this->page_config['title'] = 'Prescription Uploads';
    }

    public function index() {
        $status_filter = $this->input->get('status', TRUE);
        $search = trim($this->input->get('search', TRUE) ?: '');

        $this->db->from('prescriptions');
        if (!empty($status_filter) && $status_filter !== 'all') {
            $this->db->where('status', $status_filter);
        }
        if (!empty($search)) {
            $term_esc = $this->db->escape_like_str($search);
            $this->db->where("(patient_name LIKE '%{$term_esc}%' OR phone LIKE '%{$term_esc}%' OR notes LIKE '%{$term_esc}%')", NULL, FALSE);
        }
        $this->db->order_by('id', 'DESC');
        $prescriptions = $this->db->get()->result_array();

        // Summary counts
        $total = $this->db->count_all('prescriptions');
        $pending = $this->db->where('status', 'Pending Pharmacist Review')->count_all_results('prescriptions');
        $verified = $this->db->where('status', 'Verified & Processed')->count_all_results('prescriptions');
        $dispensed = $this->db->where('status', 'Medicine Dispensed')->count_all_results('prescriptions');

        $data = [
            'prescriptions' => $prescriptions,
            'status_filter' => $status_filter,
            'search' => $search,
            'summary' => [
                'total' => $total,
                'pending' => $pending,
                'verified' => $verified,
                'dispensed' => $dispensed
            ]
        ];

        $this->render($data, 'table_tpl');
    }

    public function update_status() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $id = intval($this->input->post('id', TRUE));
            $new_status = trim($this->input->post('status', TRUE));

            $allowed = ['Pending Pharmacist Review', 'Verified & Processed', 'Medicine Dispensed', 'Rejected'];
            if ($id > 0 && in_array($new_status, $allowed)) {
                $this->db->where('id', $id)->update('prescriptions', ['status' => $new_status]);
                
                if ($this->input->is_ajax_request()) {
                    header('Content-Type: application/json');
                    echo json_encode(['status' => 'success', 'message' => 'Prescription status updated']);
                    return;
                }
            }
        }
        redirect(console_url('prescription'));
    }

    public function delete($id = null) {
        $id = intval($id);
        if ($id > 0) {
            $rx = $this->db->where('id', $id)->get('prescriptions')->row_array();
            if ($rx && !empty($rx['prescription_file'])) {
                $file_path = FCPATH . 'uploads/prescriptions/' . $rx['prescription_file'];
                if (file_exists($file_path)) {
                    @unlink($file_path);
                }
            }
            $this->db->where('id', $id)->delete('prescriptions');
        }
        redirect(console_url('prescription'));
    }
}
