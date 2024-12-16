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

$id = $_GET['id'];
$sql = "SELECT * FROM siswa WHERE id=$id";
$query = $conn->query($sql);
$siswa = $query->fetch_assoc();
$jenis_kelamin = ucfirst($siswa['jenis_kelamin']);


// require_once('fpdf186/fpdf.php');

// class PDF extends FPDF {
//     function Header() {
//         $this->SetFont('Arial', 'B', 15);
//         $this->Cell(0, 10, 'SMK Coding', 0, 1, 'C');
//         $this->Cell(0, 10, 'Kartu Pendaftaran Siswa Baru', 0, 1, 'C');
//         $this->Ln(10);
//     }

//     function Footer() {
//         $this->SetY(-15);
//         $this->SetFont('Arial', 'I', 8);
//         $this->Cell(0, 10, 'Harap membawa kartu ini saat verifikasi di sekolah', 0, 0, 'C');
//     }
// }

// $pdf = new PDF();
// $pdf->AddPage();


// $pdf->SetFont('Arial', '', 12);

// $pdf->Cell(50, 10, 'Nama Lengkap', 0, 0);
// $pdf->Cell(0, 10, ': ' . $siswa['nama'], 0, 1);

// $pdf->Cell(50, 10, 'Alamat', 0, 0);
// $pdf->Cell(0, 10, ': ' . $siswa['alamat'], 0, 1);

// $pdf->Cell(50, 10, 'Jenis Kelamin', 0, 0);
// $pdf->Cell(0, 10, ': ' . $jenis_kelamin, 0, 1);

// $pdf->Cell(50, 10, 'Agama', 0, 0);
// $pdf->Cell(0, 10, ': ' . $siswa['agama'], 0, 1);

// $pdf->Cell(50, 10, 'Sekolah Asal', 0, 0);
// $pdf->Cell(0, 10, ': ' . $siswa['sekolah_asal'], 0, 1);

// $pdf->Output('F', 'kartu_pendaftaran_' . $siswa['nama'] . '.pdf');
// $pdf->Output('I', 'kartu_pendaftaran_' . $siswa['nama'] . '.pdf');
?>