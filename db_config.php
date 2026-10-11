<?php
/**
 * Shared Database Configuration for Standalone Search & Batch Scripts
 */
if (!defined('DB_SERVER')) {
    $server_name = isset($_SERVER['SERVER_NAME']) ? $_SERVER['SERVER_NAME'] : (isset($_SERVER['HTTP_HOST']) ? $_SERVER['HTTP_HOST'] : 'localhost');
    if ($server_name === 'localhost' || $server_name === '127.0.0.1' || strpos($server_name, 'localhost') !== false) {
        $db_server = 'localhost';
        $db_user = 'root';
        $db_pass = '';
        $db_name = 'antu';
        try {
            $nConn = @new mysqli('localhost', 'root', '', 'nodes');
            if ($nConn && !$nConn->connect_error) {
                $escaped = $nConn->real_escape_string($server_name);
                $nRes = $nConn->query("SELECT node_name FROM nodes WHERE node_url = '$escaped' OR node_url LIKE '%$escaped%' LIMIT 1");
                if ($nRes && $nRes->num_rows > 0) {
                    $nRow = $nRes->fetch_assoc();
                    if (!empty($nRow['node_name'])) {
                        $db_name = $nRow['node_name'];
                    }
                }
                $nConn->close();
            }
        } catch (Exception $e) {}
    } else {
        $nodeSegment = explode('.', $server_name);
        $node = 'u404684354_' . $nodeSegment[0];
        $db_server = 'localhost';
        $db_user = $node;
        $db_pass = 'BR66MK55@msb';
        $db_name = $node;
    }

    define('DB_SERVER', $db_server);
    define('DB_USER', $db_user);
    define('DB_PASSWORD', $db_pass);
    define('DB_NAME', $db_name);
}

if (!function_exists('get_app_pdo')) {
    function get_app_pdo() {
        $conn = new PDO("mysql:host=" . DB_SERVER . ";port=3306;dbname=" . DB_NAME . ";charset=utf8", DB_USER, DB_PASSWORD);
        $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        return $conn;
    }
}
