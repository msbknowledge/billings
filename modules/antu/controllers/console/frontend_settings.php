<?php
if (!defined('BASEPATH')) exit('No direct script access allowed');

class Frontend_settings extends MY_Controller {

    public function __construct() {
        parent::__construct();
        $this->page_config['title'] = 'Frontend Portal CMS Settings';
    }

    public function index() {
        $saved = false;
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $keys = [
                'frontend_site_title',
                'frontend_helpline',
                'frontend_emergency',
                'frontend_whatsapp',
                'frontend_email',
                'frontend_address',
                'frontend_open_hours',
                'frontend_delivery_badge',
                'frontend_announcement',
                'frontend_stat_customers'
            ];
            foreach ($keys as $k) {
                $val = trim($this->input->post($k, TRUE) ?: '');
                set_option($k, $val);
            }
            $saved = true;
        }

        $data = [
            'saved' => $saved,
            'settings' => [
                'frontend_site_title' => get_option('frontend_site_title') ?: 'MedPulse Pharmacy & Healthcare Portal',
                'frontend_helpline' => get_option('frontend_helpline') ?: '+91 98300 12345',
                'frontend_emergency' => get_option('frontend_emergency') ?: '108 / 1800-200-6334',
                'frontend_whatsapp' => get_option('frontend_whatsapp') ?: '+919830012345',
                'frontend_email' => get_option('frontend_email') ?: 'care@medpulsepharmacy.com',
                'frontend_address' => get_option('frontend_address') ?: 'MedPulse Healthcare Hub, Main Medical Road, Kolkata, WB - 700028',
                'frontend_open_hours' => get_option('frontend_open_hours') ?: '24 / 7',
                'frontend_delivery_badge' => get_option('frontend_delivery_badge') ?: 'Express 2-Hour Doorstep Delivery',
                'frontend_announcement' => get_option('frontend_announcement') ?: 'Pharmacy Open 24/7 with 100% Genuine Certified Stock',
                'frontend_stat_customers' => get_option('frontend_stat_customers') ?: '25,000+'
            ]
        ];

        $this->render($data, 'index_tpl');
    }
}
