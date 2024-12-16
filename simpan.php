<?php
session_start();

if (!isset($_SESSION['user_id'])) {
    header("Location: index.php");
    exit();
}

$servername = "localhost";
$username = "root";
$password = "";
$dbname = "pendaftaran_siswa";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nama = mysqli_real_escape_string($conn, $_POST['nama']);
    $alamat = mysqli_real_escape_string($conn, $_POST['alamat']);
    $jenis_kelamin = ucwords(strtolower(mysqli_real_escape_string($conn, $_POST['jenis_kelamin'])));
    $agama = mysqli_real_escape_string($conn, $_POST['agama']);
    $sekolah_asal = mysqli_real_escape_string($conn, $_POST['sekolah_asal']);

    $foto = $_FILES['foto'];
    $targetDir = "uploads/";
    $fotoName = uniqid() . "-" . basename($foto['name']);
    $targetFile = $targetDir . $fotoName;
    
    $stmt = $conn->prepare("INSERT INTO siswa (nama, alamat, jenis_kelamin, agama, sekolah_asal) VALUES (?, ?, ?, ?, ?)");
    $stmt->bind_param("sssss", $nama, $alamat, $jenis_kelamin, $agama, $sekolah_asal);

    $response = ['status' => 'error', 'message' => 'Gagal mendaftarkan siswa'];

    try {
        if ($stmt->execute()) {
            tambahLog($conn, $_SESSION['username'], "Mendaftarkan Siswa Baru: $nama");
            
            $response = [
                'status' => 'success', 
            ];
        } else {
            $response = ['status' => 'error', 'message' => 'Gagal mendaftarkan siswa'];
        }
        
        $stmt->close();
    } catch (Exception $e) {
        $response['message'] = "Error: " . $e->getMessage();
    }

    header('Content-Type: application/json');
    echo json_encode($response);
    exit();
}

function tambahLog($conn, $username, $aktivitas) {
    $ip_address = $_SERVER['REMOTE_ADDR'];

    $stmt = $conn->prepare("INSERT INTO log_aktivitas (username, aktivitas, ip_address) VALUES (?, ?, ?)");
    $stmt->bind_param("sss", $username, $aktivitas, $ip_address);
    
    try {
        $stmt->execute();
    } catch (Exception $e) {
        error_log("Logging error: " . $e->getMessage());
    }
    $stmt->close();
}
?>