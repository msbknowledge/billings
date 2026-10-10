<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Dashboard extends MY_Controller {

    public function __construct() {
        parent::__construct();
    }

    public function index() {
        $data = array();

        // 1. KPI Stats
        $data['total_sales'] = $this->db->query("SELECT COUNT(*) AS count, COALESCE(SUM(sale_total), 0) AS total FROM sales")->row_array();
        $data['today_sales'] = $this->db->query("SELECT COUNT(*) AS count, COALESCE(SUM(sale_total), 0) AS total FROM sales WHERE DATE(sale_date) = CURRENT_DATE")->row_array();

        $data['total_purchases'] = $this->db->query("SELECT COUNT(*) AS count, COALESCE(SUM(purchase_total), 0) AS total FROM purchases")->row_array();
        $data['today_purchases'] = $this->db->query("SELECT COUNT(*) AS count, COALESCE(SUM(purchase_total), 0) AS total FROM purchases WHERE DATE(purchase_date) = CURRENT_DATE")->row_array();

        $data['total_medicines'] = (int) $this->db->query("SELECT COUNT(*) AS count FROM medicines")->row()->count;
        $data['total_customers'] = (int) $this->db->query("SELECT COUNT(*) AS count FROM customers")->row()->count;
        $data['total_doctors'] = (int) $this->db->query("SELECT COUNT(*) AS count FROM doctors")->row()->count;
        $data['total_suppliers'] = (int) $this->db->query("SELECT COUNT(*) AS count FROM suppliers")->row()->count;

        // Portal Stats
        $data['portal_orders'] = (int) $this->db->query("SELECT COUNT(*) AS count FROM customer_orders")->row()->count;
        $data['portal_prescriptions'] = (int) $this->db->query("SELECT COUNT(*) AS count FROM prescriptions")->row()->count;
        $data['portal_consultations'] = (int) $this->db->query("SELECT COUNT(*) AS count FROM consultations")->row()->count;

        // 2. Monthly Sales vs. Purchases (Last 12 active months)
        $monthly_sql = "
            SELECT 
                t.ym,
                DATE_FORMAT(STR_TO_DATE(CONCAT(t.ym, '-01'), '%Y-%m-%d'), '%b %Y') AS label,
                COALESCE(s.sales_total, 0) AS sales,
                COALESCE(s.sales_count, 0) AS sales_count,
                COALESCE(p.purchases_total, 0) AS purchases,
                COALESCE(p.purchases_count, 0) AS purchases_count
            FROM (
                SELECT DISTINCT DATE_FORMAT(sale_date, '%Y-%m') AS ym FROM sales WHERE sale_date >= '2025-01-01'
                UNION
                SELECT DISTINCT DATE_FORMAT(purchase_date, '%Y-%m') AS ym FROM purchases WHERE purchase_date >= '2025-01-01'
            ) t
            LEFT JOIN (
                SELECT DATE_FORMAT(sale_date, '%Y-%m') AS ym, SUM(sale_total) AS sales_total, COUNT(*) AS sales_count
                FROM sales GROUP BY ym
            ) s ON t.ym = s.ym
            LEFT JOIN (
                SELECT DATE_FORMAT(purchase_date, '%Y-%m') AS ym, SUM(purchase_total) AS purchases_total, COUNT(*) AS purchases_count
                FROM purchases GROUP BY ym
            ) p ON t.ym = p.ym
            WHERE t.ym IS NOT NULL AND t.ym != ''
            ORDER BY t.ym DESC
            LIMIT 12
        ";
        $data['monthly_trends'] = array_reverse($this->db->query($monthly_sql)->result_array());

        // 3. Daily Sales Velocity (Last 14 active billing days)
        $daily_sql = "
            SELECT 
                sale_date,
                DATE_FORMAT(sale_date, '%d %b') AS label,
                COUNT(*) AS bill_count,
                COALESCE(SUM(sale_total), 0) AS total
            FROM sales
            WHERE sale_date IS NOT NULL AND sale_date != '0000-00-00'
            GROUP BY sale_date
            ORDER BY sale_date DESC
            LIMIT 14
        ";
        $data['daily_trends'] = array_reverse($this->db->query($daily_sql)->result_array());

        // 4. Top 10 Best Selling Medicines
        $top_meds_sql = "
            SELECT m.medicine_name, SUM(s.sale_strip_quantity) AS strips, SUM(s.sale_total) AS total_val
            FROM sales s
            JOIN medicines m ON s.sale_medicine_id = m.medicine_ID
            GROUP BY s.sale_medicine_id
            ORDER BY total_val DESC
            LIMIT 10
        ";
        $data['top_medicines'] = $this->db->query($top_meds_sql)->result_array();

        // 5. Payment Modes Breakdown
        $pay_modes_sql = "
            SELECT 
                COALESCE(NULLIF(TRIM(sale_paid_by), ''), 'Cash') AS mode,
                COUNT(*) AS count,
                COALESCE(SUM(sale_total), 0) AS total
            FROM sales
            GROUP BY mode
            ORDER BY total DESC
        ";
        $data['payment_modes'] = $this->db->query($pay_modes_sql)->result_array();

        // 6. Top Prescribing Doctors
        $top_docs_sql = "
            SELECT 
                COALESCE(NULLIF(d.doctor_name, ''), 'General / Self') AS doc_name,
                COUNT(*) AS count,
                COALESCE(SUM(s.sale_total), 0) AS total
            FROM sales s
            LEFT JOIN doctors d ON s.sale_doctor = d.doctor_id
            GROUP BY s.sale_doctor
            ORDER BY total DESC
            LIMIT 7
        ";
        $data['top_doctors'] = $this->db->query($top_docs_sql)->result_array();

        // 7. Inventory Audit & Risk Metrics
        $current_y = (int) date('y');
        $current_m = (int) date('m');

        $data['count_duplicate'] = (int) $this->db->query("
            SELECT COUNT(*) AS c FROM (
                SELECT medicine_name FROM medicines GROUP BY TRIM(medicine_name) HAVING COUNT(*) > 1
            ) t
        ")->row()->c;

        $data['count_no_unit'] = (int) $this->db->query("
            SELECT COUNT(*) AS c FROM medicines WHERE medicine_unit = '' OR medicine_unit IS NULL
        ")->row()->c;

        $data['count_unassigned_storage'] = (int) $this->db->query("
            SELECT COUNT(*) AS c FROM medicines WHERE medicine_storage = '' OR medicine_storage IS NULL
        ")->row()->c;

        $data['count_expired'] = (int) $this->db->query("
            SELECT COUNT(DISTINCT purchase_medicine_id) AS c
            FROM purchases
            WHERE purchase_expire_year < $current_y 
               OR (purchase_expire_year = $current_y AND purchase_expire_month < $current_m)
        ")->row()->c;

        $data['count_expiring_soon'] = (int) $this->db->query("
            SELECT COUNT(DISTINCT purchase_medicine_id) AS c
            FROM purchases
            WHERE (purchase_expire_year = $current_y AND purchase_expire_month >= $current_m AND purchase_expire_month <= $current_m + 3)
               OR (purchase_expire_year = $current_y + 1 AND $current_m >= 10 AND purchase_expire_month <= ($current_m + 3 - 12))
        ")->row()->c;

        // 8. Recent Sales & Invoices
        $data['recent_sales'] = $this->db->query("
            SELECT s.sale_ID, s.sale_invoice, s.sale_date, 
                   COALESCE(c.customer_name, 'Walk-in Patient') AS customer_name, 
                   s.sale_total, s.sale_paid_by
            FROM sales s
            LEFT JOIN customers c ON s.sale_customer = c.customer_ID
            ORDER BY s.sale_ID DESC
            LIMIT 6
        ")->result_array();

        // 9. Recent Online Orders
        $data['recent_orders'] = $this->db->query("
            SELECT id, order_code, customer_name, phone, medicine_name, quantity, status, created_at
            FROM customer_orders
            ORDER BY id DESC
            LIMIT 5
        ")->result_array();

        $this->render($data);
    }

    public function sample() {
        $this->render();
    }
}
