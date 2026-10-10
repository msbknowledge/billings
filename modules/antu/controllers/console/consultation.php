<?php
if (!defined('BASEPATH')) exit('No direct script access allowed');

class Consultation extends MY_Controller {

    public function __construct() {
        parent::__construct();
        $this->targetModel = 'consultations_model';
        $this->load->model('consultations_model');
        $this->page_config['title'] = 'Doctor Consultations';
    }

    public function index() {
        $status_filter = $this->input->get('status', TRUE);
        $search = trim($this->input->get('search', TRUE) ?: '');

        $this->db->select('c.*, d.doctor_name as assigned_doctor_name');
        $this->db->from('consultations c');
        $this->db->join('doctors d', 'c.doctor_id = d.doctor_ID', 'left');

        if (!empty($status_filter) && $status_filter !== 'all') {
            $this->db->where('c.status', $status_filter);
        }
        if (!empty($search)) {
            $term_esc = $this->db->escape_like_str($search);
            $this->db->where("(c.patient_name LIKE '%{$term_esc}%' OR c.phone LIKE '%{$term_esc}%' OR c.department LIKE '%{$term_esc}%' OR d.doctor_name LIKE '%{$term_esc}%')", NULL, FALSE);
        }
        $this->db->order_by('c.id', 'DESC');
        $consultations = $this->db->get()->result_array();

        // Doctor list for reassignment modal
        $doctors = $this->db->select('doctor_ID, doctor_name')->where('doctor_name !=', '')->get('doctors')->result_array();

        // Summary counts
        $total = $this->db->count_all('consultations');
        $requested = $this->db->where('status', 'Requested')->count_all_results('consultations');
        $scheduled = $this->db->where('status', 'Scheduled')->count_all_results('consultations');
        $completed = $this->db->where('status', 'Completed')->count_all_results('consultations');

        $data = [
            'consultations' => $consultations,
            'doctors' => $doctors,
            'status_filter' => $status_filter,
            'search' => $search,
            'summary' => [
                'total' => $total,
                'requested' => $requested,
                'scheduled' => $scheduled,
                'completed' => $completed
            ]
        ];

        $this->render($data, 'table_tpl');
    }

    public function update_status() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $id = intval($this->input->post('id', TRUE));
            $new_status = trim($this->input->post('status', TRUE));

            $allowed = ['Requested', 'Scheduled', 'Completed', 'Cancelled'];
            if ($id > 0 && in_array($new_status, $allowed)) {
                $this->db->where('id', $id)->update('consultations', ['status' => $new_status]);
                
                if ($this->input->is_ajax_request()) {
                    header('Content-Type: application/json');
                    echo json_encode(['status' => 'success', 'message' => 'Status updated']);
                    return;
                }
            }
        }
        redirect(console_url('consultation'));
    }

    public function assign_doctor() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $id = intval($this->input->post('id', TRUE));
            $doctor_id = intval($this->input->post('doctor_id', TRUE));
            if ($id > 0) {
                $this->db->where('id', $id)->update('consultations', [
                    'doctor_id' => $doctor_id,
                    'status' => 'Scheduled'
                ]);
            }
        }
        redirect(console_url('consultation'));
    }

    public function delete($id = null) {
        $id = intval($id);
        if ($id > 0) {
            $this->db->where('id', $id)->delete('consultations');
        }
        redirect(console_url('consultation'));
    }
}
