<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
ini_set('error_log', 'error.log');

$host = "localhost";
$dbname = "office_inventory";
$username = "root";
$password = "";

try {
    $pdo = new PDO("mysql:host=$host;dbname=$dbname;charset=utf8", $username, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_FILES['images'])) {
        $uploadDir = 'uploads/';
        $allowedTypes = ['jpg', 'jpeg', 'png', 'gif'];

        $uploadedFiles = [];

        foreach ($_FILES['images']['name'] as $key => $val) {
            $fileTmpPath = $_FILES['images']['tmp_name'][$key];
            $fileName = basename($_FILES['images']['name'][$key]);
            $targetFilePath = $uploadDir . $fileName;
            $fileType = strtolower(pathinfo($targetFilePath, PATHINFO_EXTENSION));

            // ตรวจสอบ Error ในการอัพโหลด
            if ($_FILES['images']['error'][$key] !== UPLOAD_ERR_OK) {
                $response = ['status' => 'error', 'message' => 'เกิดข้อผิดพลาดในการอัพโหลดไฟล์: ' . $_FILES['images']['error'][$key]];
                break;
            }

            // ตรวจสอบชนิดไฟล์
            if (!in_array($fileType, $allowedTypes)) {
                $response = ['status' => 'error', 'message' => 'อนุญาตเฉพาะไฟล์ JPG, JPEG, PNG และ GIF เท่านั้น'];
                break;
            }

            // ตรวจสอบขนาดไฟล์ (ถ้าต้องการ)
            // if ($_FILES['images']['size'][$key] > MAX_FILE_SIZE) {
            //     $response = ['status' => 'error', 'message' => 'ขนาดไฟล์เกินขนาดที่กำหนด'];
            //     break;
            // }

            if (move_uploaded_file($fileTmpPath, $targetFilePath)) {
                $stmt = $pdo->prepare("INSERT INTO img (file_name, image_path) VALUES (?, ?)");
                $stmt->execute([$fileName, $targetFilePath]);

                $uploadedFiles[] = [
                    'id' => $pdo->lastInsertId(),
                    'file_name' => $fileName,
                    'file_size' => $_FILES['images']['size'][$key]
                ];
            } else {
                $response = ['status' => 'error', 'message' => 'ไม่สามารถย้ายไฟล์ไปยังโฟลเดอร์ uploads ได้'];
                break;
            }
        }

        if (!isset($response)) {
            $response = [
                'status' => 'success',
                'message' => 'อัพโหลดไฟล์และบันทึกข้อมูลเรียบร้อยแล้ว',
                'data' => $uploadedFiles
            ];
        }

        // ส่ง JSON response
        header('Content-Type: application/json');
        echo json_encode($response);
        exit;
    } else {
        // ส่ง JSON response error
        header('Content-Type: application/json');
        echo json_encode(['status' => 'error', 'message' => 'No files uploaded or invalid request method']);
        exit;
    }

} catch (PDOException $e) {
    // ส่ง JSON response error
    header('Content-Type: application/json');
    echo json_encode(['status' => 'error', 'message' => 'Connection failed: ' . $e->getMessage()]);
    exit;//
}
