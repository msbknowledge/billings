<?php
$servername = "localhost";
$username = "u404684354_node";
$password = "BR66MK55@msb";
$dbname = "u404684354_node";
// Create connection
$conn = new mysqli($servername, $username, $password,$dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
} 
echo "Connected successfully";

$sql_node_data="SELECT node_name FROM nodes";
$result = mysqli_query($conn, $sql_node_data);
if (mysqli_num_rows($result) > 0) {
    
    while ($row = mysqli_fetch_assoc($result)) {
        $data[] = $row;
    }
}
print_r($data);
//die();
?>
