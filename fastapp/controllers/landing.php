<?php
#[AllowDynamicProperties]
class Landing extends MY_Controller {

    public $publicAccess = array(
        'index', 'search_medicines', 'get_medicine_details', 
        'upload_prescription', 'book_consultation', 'quick_order', 
        'doctors', 'categories', 'messegebox', 'blogs', 'wishes', 
        'home', 'wishe', 'about_us', 'blogdetails', 'contact_us', 
        'payment_terms_and_conditions', 'privacy_policy', 'details', 'main'
    );

    public function __construct() {
        parent::__construct();
        $this->load->model('help_model');
    }
    
    /**
     * Medical Store & Healthcare Portal Homepage
     */
    public function index() {
        // Fetch active categories with counts
        $categories_raw = $this->db->order_by('medicine_category_id', 'ASC')->get('medicine_categories')->result_array();
        
        // Curated icon & color metadata for healthcare categories
        $category_meta = [
            'TABLET' => ['icon' => 'fa-tablets', 'color' => '#0d9488', 'badge' => 'Oral Solid', 'desc' => 'High quality compressed tablets for systemic relief'],
            'TAB' => ['icon' => 'fa-tablets', 'color' => '#0d9488', 'badge' => 'Oral Solid', 'desc' => 'Prescription and generic tablets'],
            'CAPSULE' => ['icon' => 'fa-capsules', 'color' => '#0891b2', 'badge' => 'Oral Encapsulated', 'desc' => 'Fast absorption soft and hard gelatin capsules'],
            'CAPSUL' => ['icon' => 'fa-capsules', 'color' => '#0891b2', 'badge' => 'Oral Encapsulated', 'desc' => 'Fast absorption capsules'],
            'SYRUP' => ['icon' => 'fa-prescription-bottle', 'color' => '#10b981', 'badge' => 'Liquid Oral', 'desc' => 'Pediatric and adult soothing liquid syrups & suspensions'],
            'INJECTION' => ['icon' => 'fa-syringe', 'color' => '#ef4444', 'badge' => 'Clinical Parenteral', 'desc' => 'Sterile intravenous and intramuscular injectable medicines'],
            'CREAM' => ['icon' => 'fa-hand-sparkles', 'color' => '#f59e0b', 'badge' => 'Topical Care', 'desc' => 'Dermatological creams, antifungals & skin barrier remedies'],
            'CREM' => ['icon' => 'fa-hand-sparkles', 'color' => '#f59e0b', 'badge' => 'Topical Care', 'desc' => 'Skin and dermatological creams'],
            'OINTMENT' => ['icon' => 'fa-pump-medical', 'color' => '#ec4899', 'badge' => 'Topical Balm', 'desc' => 'Healing soothing ointments and antiseptic balms'],
            'DROPS' => ['icon' => 'fa-eye-dropper', 'color' => '#3b82f6', 'badge' => 'Ophthalmic & ENT', 'desc' => 'Sterile eye, ear, and nasal pediatric drops'],
            'INHALER' => ['icon' => 'fa-lungs', 'color' => '#6366f1', 'badge' => 'Respiratory Care', 'desc' => 'Bronchodilators and respiratory inhalers for asthma care'],
            'SURGICAL' => ['icon' => 'fa-briefcase-medical', 'color' => '#8b5cf6', 'badge' => 'Clinical Supplies', 'desc' => 'Hospital grade dressings, bandages and surgical care']
        ];

        $categories = [];
        foreach ($categories_raw as $cat) {
            $name_upper = strtoupper(trim($cat['medicine_category_name']));
            $meta = $category_meta[$name_upper] ?? [
                'icon' => 'fa-pills',
                'color' => '#0d9488',
                'badge' => 'Healthcare',
                'desc' => 'Essential medical pharmaceutical products'
            ];
            $categories[] = [
                'id' => $cat['medicine_category_id'],
                'name' => $cat['medicine_category_name'],
                'icon' => $meta['icon'],
                'color' => $meta['color'],
                'badge' => $meta['badge'],
                'desc' => $meta['desc']
            ];
        }

        // Fetch sample popular medicines across categories
        $featured_medicines = $this->db->select('medicine_id, medicine_name, medicine_category, medicine_manufacturer, medicine_unit, medicine_discount, medicine_gst, medicine_storage, medicine_schedule')
            ->where('medicine_name !=', '')
            ->where_in('medicine_category', ['TABLET', 'TAB', 'SYRUP', 'CAPSULE', 'CAPSUL', 'INJECTION', 'CREAM', 'OINTMENT', 'DROPS'])
            ->limit(24)
            ->get('medicines')
            ->result_array();

        // Sample doctors with specialties
        $specialties = [
            'General Medicine & Physician',
            'Cardiology & Vascular Specialist',
            'Pediatrics & Child Specialist',
            'Orthopedic & Joint Care',
            'Dermatology & Skin Care',
            'Neurology Specialist',
            'ENT & Sinus Specialist',
            'Gastroenterology'
        ];

        $doctors_raw = $this->db->select('doctor_ID, doctor_name, doctor_address, doctor_contact')
            ->where('doctor_name !=', '')
            ->where('doctor_name !=', 'N/A')
            ->where('doctor_name !=', 'SELF')
            ->order_by('doctor_ID', 'ASC')
            ->limit(8)
            ->get('doctors')
            ->result_array();

        $doctors = [];
        $i = 0;
        foreach ($doctors_raw as $doc) {
            $clean_name = trim($doc['doctor_name']);
            if (stripos($clean_name, 'DR') === false && stripos($clean_name, 'DR.') === false) {
                $clean_name = 'Dr. ' . ucwords(strtolower($clean_name));
            } else {
                $clean_name = ucwords(strtolower($clean_name));
            }
            $doctors[] = [
                'id' => $doc['doctor_ID'],
                'name' => $clean_name,
                'specialty' => $specialties[$i % count($specialties)],
                'experience' => (8 + ($i * 2)) . '+ Years Exp.',
                'availability' => ($i % 2 === 0) ? 'Available Today' : 'Mon - Sat (10 AM - 6 PM)',
                'contact' => !empty($doc['doctor_contact']) && $doc['doctor_contact'] !== '0' ? $doc['doctor_contact'] : '+91 98300 12345'
            ];
            $i++;
        }

        // Live Database Statistics
        $total_medicines = $this->db->count_all('medicines');
        $total_doctors = $this->db->count_all('doctors');
        $total_categories = count($categories_raw);

        $data = [
            'site_title' => get_option('frontend_site_title') ?: 'MedPulse Pharmacy & Healthcare Portal',
            'announcement' => get_option('frontend_announcement') ?: 'Pharmacy Open 24/7 with 100% Genuine Certified Stock',
            'delivery_badge' => get_option('frontend_delivery_badge') ?: 'Express 2-Hour Doorstep Delivery',
            'categories' => $categories,
            'featured_medicines' => $featured_medicines,
            'doctors' => $doctors,
            'stats' => [
                'medicines' => number_format($total_medicines > 0 ? $total_medicines : 17920),
                'doctors' => number_format($total_doctors > 0 ? $total_doctors : 600),
                'categories' => $total_categories > 0 ? $total_categories : 23,
                'customers' => get_option('frontend_stat_customers') ?: '25,000+',
                'open_hours' => get_option('frontend_open_hours') ?: '24 / 7'
            ],
            'contact' => [
                'helpline' => get_option('frontend_helpline') ?: '+91 98300 12345',
                'emergency' => get_option('frontend_emergency') ?: '108 / 1800-200-6334',
                'email' => get_option('frontend_email') ?: 'care@medpulsepharmacy.com',
                'address' => get_option('frontend_address') ?: 'MedPulse Healthcare Hub, Main Medical Road, Kolkata, WB - 700028',
                'whatsapp' => get_option('frontend_whatsapp') ?: '+919830012345'
            ]
        ];

        $this->load->view('frontend/medical_portal_tpl', $data);
    }

    /**
     * AJAX Live Search across 17,900+ Medicines
     */
    public function search_medicines() {
        header('Content-Type: application/json; charset=utf-8');
        try {
            $term = trim($this->input->get('term', TRUE) ?: '');
            $category = trim($this->input->get('category', TRUE) ?: '');
            $page_param = $this->input->get('page', TRUE);
            $page = ($page_param !== FALSE && $page_param !== '') ? max(1, intval($page_param)) : 1;
            $limit_param = $this->input->get('limit', TRUE);
            $limit = ($limit_param !== FALSE && $limit_param !== '') ? min(60, max(1, intval($limit_param))) : 24;
            $offset = ($page - 1) * $limit;

            $where_sql = [];
            if (!empty($term)) {
                $term_escaped = $this->db->escape_like_str($term);
                $where_sql[] = "(medicine_name LIKE '%{$term_escaped}%' OR medicine_manufacturer LIKE '%{$term_escaped}%')";
            }
            if (!empty($category) && $category !== 'all') {
                $cat_escaped = $this->db->escape_like_str($category);
                $where_sql[] = "medicine_category LIKE '%{$cat_escaped}%'";
            }

            // Total count
            $this->db->from('medicines');
            foreach ($where_sql as $w) {
                $this->db->where($w, NULL, FALSE);
            }
            $total = $this->db->count_all_results();

            // Fetch results
            $this->db->from('medicines');
            foreach ($where_sql as $w) {
                $this->db->where($w, NULL, FALSE);
            }

            $this->db->order_by('medicine_name', 'ASC');
            $this->db->limit($limit, $offset);
            $results = $this->db->get()->result_array();

            echo json_encode([
                'status' => 'success',
                'term' => $term,
                'category' => $category,
                'page' => $page,
                'limit' => $limit,
                'total' => $total,
                'results' => $results
            ]);
        } catch (Exception $e) {
            echo json_encode([
                'status' => 'error',
                'message' => $e->getMessage()
            ]);
        }
    }

    /**
     * Get details for single medicine
     */
    public function get_medicine_details($id = null) {
        header('Content-Type: application/json; charset=utf-8');
        try {
            $medicine_id = intval($id ?: $this->input->get('id', TRUE));
            if ($medicine_id <= 0) {
                echo json_encode(['status' => 'error', 'message' => 'Invalid Medicine ID']);
                return;
            }

            $medicine = $this->db->where('medicine_id', $medicine_id)->get('medicines')->row_array();
            if (!$medicine) {
                echo json_encode(['status' => 'error', 'message' => 'Medicine not found']);
                return;
            }

            // Check if stock entry exists
            $stock = $this->db->where('medicine_stock_medicine', $medicine_id)->order_by('medicine_stock_ID', 'DESC')->get('medicine_stocks')->row_array();

            echo json_encode([
                'status' => 'success',
                'medicine' => $medicine,
                'stock' => $stock
            ]);
        } catch (Exception $e) {
            echo json_encode(['status' => 'error', 'message' => $e->getMessage()]);
        }
    }

    /**
     * Upload Prescription Endpoint
     */
    public function upload_prescription() {
        header('Content-Type: application/json; charset=utf-8');
        try {
            if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
                echo json_encode(['status' => 'error', 'message' => 'Invalid request method']);
                return;
            }

            $patient_name = trim($this->input->post('patient_name', TRUE) ?? '');
            $phone = trim($this->input->post('phone', TRUE) ?? '');
            $email = trim($this->input->post('email', TRUE) ?? '');
            $address = trim($this->input->post('address', TRUE) ?? '');
            $notes = trim($this->input->post('notes', TRUE) ?? '');

            if (empty($patient_name) || empty($phone)) {
                echo json_encode(['status' => 'error', 'message' => 'Please provide patient name and contact phone number.']);
                return;
            }

            $uploaded_file_name = '';
            if (isset($_FILES['prescription_file']) && $_FILES['prescription_file']['error'] === UPLOAD_ERR_OK) {
                $upload_path = FCPATH . 'uploads/prescriptions/';
                if (!is_dir($upload_path)) {
                    @mkdir($upload_path, 0777, TRUE);
                }

                $file_info = pathinfo($_FILES['prescription_file']['name']);
                $ext = strtolower($file_info['extension'] ?? '');
                $allowed_exts = ['jpg', 'jpeg', 'png', 'webp', 'pdf'];

                if (!in_array($ext, $allowed_exts)) {
                    echo json_encode(['status' => 'error', 'message' => 'Invalid file format. Please upload JPG, PNG, WEBP, or PDF.']);
                    return;
                }

                if ($_FILES['prescription_file']['size'] > 12 * 1024 * 1024) {
                    echo json_encode(['status' => 'error', 'message' => 'Prescription file is too large (max 12MB).']);
                    return;
                }

                $new_name = 'rx_' . date('Ymd_His') . '_' . substr(md5(uniqid()), 0, 8) . '.' . $ext;
                if (move_uploaded_file($_FILES['prescription_file']['tmp_name'], $upload_path . $new_name)) {
                    $uploaded_file_name = $new_name;
                } else {
                    echo json_encode(['status' => 'error', 'message' => 'Failed to save the uploaded prescription file.']);
                    return;
                }
            } else {
                echo json_encode(['status' => 'error', 'message' => 'Please select a prescription document or image to upload.']);
                return;
            }

            $insert_data = [
                'patient_name' => $patient_name,
                'phone' => $phone,
                'email' => $email,
                'address' => $address,
                'prescription_file' => $uploaded_file_name,
                'notes' => $notes,
                'status' => 'Pending Pharmacist Review',
                'created_at' => date('Y-m-d H:i:s')
            ];

            $this->db->insert('prescriptions', $insert_data);
            $rx_id = $this->db->insert_id();
            $tracking_code = 'RX-' . date('Y') . '-' . str_pad($rx_id, 5, '0', STR_PAD_LEFT);

            echo json_encode([
                'status' => 'success',
                'rx_id' => $rx_id,
                'tracking_code' => $tracking_code,
                'message' => 'Prescription uploaded successfully! Token: ' . $tracking_code . '. Our registered pharmacist will review your prescription and call you within 15 minutes.'
            ]);
        } catch (Exception $e) {
            echo json_encode(['status' => 'error', 'message' => $e->getMessage()]);
        }
    }

    /**
     * Book Doctor Consultation Endpoint
     */
    public function book_consultation() {
        header('Content-Type: application/json; charset=utf-8');
        try {
            if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
                echo json_encode(['status' => 'error', 'message' => 'Invalid request method']);
                return;
            }

            $patient_name = trim($this->input->post('patient_name', TRUE) ?? '');
            $phone = trim($this->input->post('phone', TRUE) ?? '');
            $email = trim($this->input->post('email', TRUE) ?? '');
            $doctor_id = intval($this->input->post('doctor_id', TRUE) ?? 0);
            $department = trim($this->input->post('department', TRUE) ?? 'General Medicine');
            $preferred_date = trim($this->input->post('preferred_date', TRUE) ?? date('Y-m-d'));
            $preferred_time = trim($this->input->post('preferred_time', TRUE) ?? 'Morning (10:00 AM - 1:00 PM)');
            $message = trim($this->input->post('message', TRUE) ?? '');

            if (empty($patient_name) || empty($phone)) {
                echo json_encode(['status' => 'error', 'message' => 'Please provide patient name and contact number.']);
                return;
            }

            $doctor_name = '';
            if ($doctor_id > 0) {
                $doc = $this->db->where('doctor_ID', $doctor_id)->get('doctors')->row_array();
                if ($doc) {
                    $doctor_name = $doc['doctor_name'];
                }
            }

            $insert_data = [
                'doctor_id' => $doctor_id,
                'patient_name' => $patient_name,
                'phone' => $phone,
                'email' => $email,
                'department' => $department,
                'preferred_date' => $preferred_date,
                'preferred_time' => $preferred_time,
                'message' => $message,
                'status' => 'Requested',
                'created_at' => date('Y-m-d H:i:s')
            ];

            $this->db->insert('consultations', $insert_data);
            $consultation_id = $this->db->insert_id();
            $token = 'MED-APT-' . str_pad($consultation_id, 4, '0', STR_PAD_LEFT);

            echo json_encode([
                'status' => 'success',
                'token' => $token,
                'consultation_id' => $consultation_id,
                'doctor_name' => $doctor_name,
                'date' => $preferred_date,
                'message' => 'Appointment request registered! Token: ' . $token . '. Our medical coordinator will contact you shortly to confirm your slot.'
            ]);
        } catch (Exception $e) {
            echo json_encode(['status' => 'error', 'message' => $e->getMessage()]);
        }
    }

    /**
     * Quick Medicine Order Endpoint
     */
    public function quick_order() {
        header('Content-Type: application/json; charset=utf-8');
        try {
            if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
                echo json_encode(['status' => 'error', 'message' => 'Invalid request method']);
                return;
            }

            $customer_name = trim($this->input->post('customer_name', TRUE) ?? '');
            $phone = trim($this->input->post('phone', TRUE) ?? '');
            $email = trim($this->input->post('email', TRUE) ?? '');
            $delivery_address = trim($this->input->post('delivery_address', TRUE) ?? '');
            $medicine_id = intval($this->input->post('medicine_id', TRUE) ?? 0);
            $medicine_name = trim($this->input->post('medicine_name', TRUE) ?? '');
            $quantity = max(1, intval($this->input->post('quantity', TRUE) ?? 1));
            $payment_method = trim($this->input->post('payment_method', TRUE) ?? 'Cash on Delivery');
            $notes = trim($this->input->post('order_notes', TRUE) ?? '');

            if (empty($customer_name) || empty($phone) || empty($medicine_name) || empty($delivery_address)) {
                echo json_encode(['status' => 'error', 'message' => 'Please provide your name, phone number, delivery address, and medicine name.']);
                return;
            }

            $order_code = 'ORD-' . strtoupper(substr(uniqid(), 7, 5)) . '-' . rand(100, 999);

            $order_data = [
                'order_code' => $order_code,
                'customer_name' => $customer_name,
                'phone' => $phone,
                'email' => $email,
                'delivery_address' => $delivery_address,
                'medicine_id' => $medicine_id,
                'medicine_name' => $medicine_name,
                'quantity' => $quantity,
                'payment_method' => $payment_method,
                'order_notes' => $notes,
                'status' => 'Order Placed',
                'created_at' => date('Y-m-d H:i:s')
            ];

            $this->db->insert('customer_orders', $order_data);
            $order_id = $this->db->insert_id();

            echo json_encode([
                'status' => 'success',
                'order_id' => $order_id,
                'order_code' => $order_code,
                'medicine_name' => $medicine_name,
                'quantity' => $quantity,
                'message' => 'Order submitted successfully! Tracking Ref: ' . $order_code . '. Our dispatch pharmacy team is packing your order for doorstep delivery.'
            ]);
        } catch (Exception $e) {
            echo json_encode(['status' => 'error', 'message' => $e->getMessage()]);
        }
    }

    // 🟢 Chat Insert + Fetch (API)
    public function messegebox() {
        header('Content-Type: application/json');
        try {
            if ($_SERVER['REQUEST_METHOD'] === 'POST') {
                $message = $this->input->post('message', true);
                $role = $this->input->post('role', true) ?? 'guest';
                $user_id = intval($this->input->post('user_id'));
                $device_id = $this->input->post('device_id', true);
                if (!empty($message)) {
                    $data = [
                        'user_id' => $user_id,
                        'device_id' => $device_id,
                        'role' => $role,
                        'message' => $message,
                        'created_at' => date('Y-m-d H:i:s')
                    ];
                    $this->db->insert('chat_messages', $data);

                    echo json_encode([
                        'status' => 'success',
                        'id' => $this->db->insert_id(),
                        'device_id' => $device_id,
                        'message' => $message,
                        'role' => $role
                    ]);
                } else {
                    echo json_encode(['status' => 'error', 'message' => 'Empty message']);
                }
                return;
            } else {
                $device_id = $this->input->get('device_id', true);
                if ($device_id) {
                    $this->db->where('device_id', $device_id);
                }
                $query = $this->db->order_by('created_at', 'ASC')->get('chat_messages');
                echo json_encode($query->result_array());
            }
        } catch(Exception $e) {
            echo json_encode([
                'status'=>'error',
                'message'=>$e->getMessage()
            ]);
        }
    }

    public function contact_us() {
        $this->render();
    }

    public function about_us() {
        $this->render();
    }

    public function wishes() {
        $this->load->view('2024_tpl.php');
    }
}