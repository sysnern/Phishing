<?php
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: GET, POST, OPTIONS");
header("Access-Control-Allow-Headers: Content-Type, Authorization");
header('Content-Type: application/json');

$con = mysqli_connect("localhost", "root", "", "test");
if (!$con) {
    die(json_encode(["success" => false, "message" => "Veritabanı bağlantısı başarısız: " . mysqli_connect_error()]));
}

$sql = "SELECT id, email, password FROM credentials";

$result = mysqli_query($con, $sql);
$users = [];
if (mysqli_num_rows($result) > 0) {
    while ($row = mysqli_fetch_assoc($result)) {
        $users[] = $row;
    }
    mysqli_free_result($result);
}
mysqli_close($con);

echo json_encode(["success" => true, "users" => $users]);

?>
