<?php


/**
 *
 * @author kallol
 */
class Translations_model extends MY_Model {

    //put your code here

    public $table_name;

    public function __construct() {
        parent::__construct();
        $this->table_name = 'translations';
        $this->check();
    }
 public function install() {
     $this->db->query("CREATE TABLE `translations` (
  `translation_id` int(11) NOT NULL,
  `translation_language_id` varchar(10) NOT NULL,
  `translation_key` varchar(100) CHARACTER SET utf32 NOT NULL,
  `translation_value` varchar(100) CHARACTER SET utf32 NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;
");
     $this->db->query("INSERT INTO `translations` (`translation_id`, `translation_language_id`, `translation_key`, `translation_value`) VALUES
(0, '1', '[{admin_nav_pages}]', 'Pages'),
(11, '3', '[{admin_nav_content}]', '??'),
(8, '9', 'Select All', '??? ???????? ????'),
(10, '3', '[{admin_nav_admin}]', '??'),
(4, '9', 'Language', '????'),
(5, '9', 'Translation', '??????'),
(6, '9', 'Visit Site', '???? ?????'),
(7, '9', 'Search', '?????????'),
(13, '3', '[{admin_nav_blog}]', '??'),
(14, '3', '[{admin_nav_files}]', '??'),
(15, '3', '[{admin_nav_messages}]', '??'),
(16, '3', '[{admin_nav_listings}]', '??'),
(17, '3', '[{admin_nav_structure}]', '??'),
(18, '3', '[{admin_nav_sites_regions}]', '?? / ??'),
(19, '3', '[{admin_nav_languages}]', '??'),
(20, '3', '[{admin_nav_blog_categories}]', '????'),
(21, '3', '[{admin_nav_categories}]', '??'),
(22, '3', '[{admin_nav_currencies}]', '??'),
(23, '3', '[{admin_nav_messages}]', '??'),
(24, '3', '[{admin_nav_email_templates}]', '??????'),
(25, '3', '[{admin_nav_users}]', '??'),
(26, '3', '[{admin_nav_groups}]', '??'),
(27, '3', '[{admin_nav_users}]', '??'),
(28, '3', '[{admin_nav_system}]', '??'),
(29, '3', '[{admin_nav_settings}]', '??'),
(30, '3', '[{admin_nav_maintenance}]', '??'),
(31, '3', '[{nav_account_dashboard}]', '????'),
(32, '3', '[{nav_logout}]', '??'),
(33, '3', '[{main_nav_buy}]', '??'),
(34, '3', '[{main_nav_new_arrivals}]', '????'),
(35, '3', '[{main_nav_top_viewed}]', '???'),
(36, '3', '[{main_nav_how_buy}]', '????'),
(37, '3', '[{main_nav_view_all}]', '??????'),
(38, '3', '[{main_nav_sell}]', '?'),
(39, '3', '[{main_nav_individual}]', '??'),
(40, '3', '[{main_nav_dealer}]', '???'),
(41, '3', '[{main_nav_how_sell}]', '???'),
(42, '3', '[{main_nav_login_register}]', '?? / ??'),
(43, '3', '[{button_view}]', '??'),
(44, '3', '[{button_delete}]', '??'),
(45, '3', '[{button_cancel}]', '??'),
(46, '3', '[{button_create_new}]', '???'),
(47, '3', '[{button_save}]', '??'),
(48, '3', '[{button_edit}]', '??'),
(49, '3', '[{button_go}]', '?'),
(50, '3', '[{button_login}]', '??'),
(51, '3', '[{button_register}]', '??'),
(52, '3', '[{button_login_facebook}]', '?Facebook??'),
(53, '3', '[{title_actions}]', '??'),
(54, '3', '[{title_search}]', '??'),
(55, '3', '[{title_region_language}]', '?? / ??'),
(56, '3', '[{title_list}]', '??'),
(57, '3', '[{title_create}]', '??'),
(58, '3', '[{title_edit}]', '??'),
(59, '3', '[{title_view}]', '??'),
(60, '3', '[{title_login}]', '??'),
(61, '3', '[{title_register}]', '??'),
(62, '', '', ''),
(63, '1', '[{admin_nav_maintenance}]', 'Maintainence'),
(64, '1', '[{main_nav_buy}]', 'Buy'),
(65, '1', '[{main_nav_dealer}]', 'Dealer'),
(66, '1', '[{main_nav_how_buy}]', 'How to buy'),
(67, '1', '[{main_nav_how_sell}]', 'How to cell'),
(68, '1', '[{main_nav_individual}]', 'individual'),
(69, '1', '[{main_nav_login_register}]', 'Login / Register'),
(70, '1', '[{main_nav_new_arrivals}]', 'New Arrival'),
(71, '1', '[{main_nav_sell}]', 'Sell'),
(72, '1', '[{main_nav_top_viewed}]', 'Top Viewed'),
(73, '1', '[{main_nav_view_all}]', 'View All'),
(74, '1', '[{title_search}]', 'Search'),
(75, '1', '[{button_go}]', 'Go'),
(76, '3', '[{message_invalid_login}]', '????????????????????.'),
(77, '1', '[{message_invalid_login}]', 'Invalid Login'),
(78, '3', '[{message_delete_confirm}]', '?????'),
(79, '1', '[{message_delete_confirm}]', 'Are You Sure to delete?'),
(80, '3', '[{field_language_iso_code}]', '??ISO??'),
(81, '1', '[{field_language_iso_code}]', 'ISO code'),
(82, '3', '[{field_region_iso_code}]', '??ISO??'),
(83, '1', '[{field_region_iso_code}]', 'Region ISO'),
(84, '3', '[{field_user_type}]', '????'),
(85, '1', '[{field_user_type}]', 'User Type'),
(86, '3', '[{field_confirm_password}]', '????'),
(87, '1', '[{field_confirm_password}]', 'Confirm Password'),
(88, '3', '[{field_user_name}]', '???'),
(89, '1', '[{field_user_name}]', 'User Name'),
(90, '3', '[{field_password}]', '??'),
(91, '1', '[{field_password}]', 'Password'),
(92, '1', '[{button_cancel}]', 'Cancel'),
(93, '1', '[{button_create_new}]', 'Create New'),
(94, '1', '[{button_delete}]', 'Delete'),
(95, '3', '[{button_edit}]', 'Edit'),
(96, '1', '[{button_login_facebook}]', 'Facebook Login'),
(97, '1', '[{button_login}]', 'Login'),
(98, '1', '[{button_register}]', 'Register'),
(99, '1', '[{button_save}]', 'Button Save'),
(100, '1', '[{button_view}]', 'View'),
(101, '1', '[{nav_logout}]', 'Logout'),
(102, '1', '[{nav_account_dashboard}]', 'Dashboard'),
(103, '1', '[{nav_account_console}]', 'Console'),
(104, '3', '[{nav_account_console}]', '?????');
");
     
     $this->db->query("ALTER TABLE `translations`
  ADD PRIMARY KEY (`translation_id`);");
     $this->db->query("ALTER TABLE `translations`
  MODIFY `translation_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=105;");
     
 }
    
    /**
     * get the list of all data in table 
     */
}

?>
