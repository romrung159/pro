<?php
require 'vendor/autoload.php';

use PhpOffice\PhpSpreadsheet\IOFactory;

// กำหนดค่าการเชื่อมต่อฐานข้อมูล
$host = "localhost";
$dbname = "office_inventory";
$username = "root";
$password = "";


try {
    $pdo = new PDO("mysql:host=$host;dbname=$dbname;charset=utf8", $username, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    if (isset($_FILES['excelFile'])) {
        $allowedTypes = ['application/vnd.ms-excel', 'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet'];

        $inputFileName = $_FILES['excelFile']['tmp_name'];

        // ตรวจสอบ MIME type
        $finfo = finfo_open(FILEINFO_MIME_TYPE);
        $mimeType = finfo_file($finfo, $inputFileName);
        finfo_close($finfo);

        if (!in_array($mimeType, $allowedTypes)) {
            throw new Exception("Invalid file type. Only XLS and XLSX files are allowed. (MIME type: $mimeType)");
        }

        try {
            $reader = IOFactory::createReaderForFile($inputFileName);
            $spreadsheet = $reader->load($inputFileName);
            $worksheet = $spreadsheet->getActiveSheet();

            foreach ($worksheet->getRowIterator() as $row) {
                $cellIterator = $row->getCellIterator();
                $cellIterator->setIterateOnlyExistingCells(false);

                $rowData = [];
                foreach ($cellIterator as $cell) {
                    $rowData[] = $cell->getValue();
                }

                // อัปโหลดรูปภาพ (ถ้ามี)
                $imagePath = null;
                if (!empty($rowData[2])) { 
                    $imageFileName = basename($rowData[2]);
                    $targetImagePath = 'uploads/' . $imageFileName;

                    if (copy($rowData[2], $targetImagePath)) {
                        $imagePath = $targetImagePath;
                    } else {
                        throw new Exception("Error copying image file.");
                    }
                }
                foreach ($worksheet->getRowIterator() as $row) {
                    // ... (ส่วนประมวลผลข้อมูลในแต่ละแถว) ...
                
                    // อัปโหลดรูปภาพ (ถ้ามี)
                    $imagePath = null;
                    if (!empty($rowData[2])) { 
                        // ตรวจสอบว่าไฟล์รูปภาพมีอยู่จริง
                        if (file_exists($rowData[2])) { // <-- เพิ่มการตรวจสอบ
                            $imageFileName = basename($rowData[2]);
                            $targetImagePath = 'uploads/' . $imageFileName;
                
                            if (copy($rowData[2], $targetImagePath)) {
                                $imagePath = $targetImagePath;
                            } else {
                                throw new Exception("Error copying image file: $rowData[2]"); // <-- เพิ่ม path ของไฟล์ในข้อความ error
                            }
                        } else {
                            throw new Exception("Image file not found: $rowData[2]"); // <-- เพิ่ม path ของไฟล์ในข้อความ error
                        }
                    } else {
                        // ถ้าไม่มีรูปภาพ ให้ตั้งค่าเป็นค่าเริ่มต้น
                        $imagePath = 'uploads/no_image.jpg'; 
                    }
                
                    // ... (ส่วนบันทึกข้อมูลลงฐานข้อมูล) ...
                }
                
                // เตรียมคำสั่ง SQL (ปรับตามโครงสร้างตารางของคุณ)
                $stmt = $pdo->prepare("INSERT INTO img (id, file_name, image_path) VALUES (?, ?, ?)");
                $stmt->execute([$rowData[0], $rowData[1], $imagePath]);
            }

            echo "Data imported successfully.";

        } catch (\PhpOffice\PhpSpreadsheet\Reader\Exception $e) {
            die("Error loading file: " . $e->getMessage());
        } catch (\Exception $e) { // ดักจับ Exception ทั่วไป
            die("An error occurred: " . $e->getMessage());
        }

    } else {
        echo "No file uploaded.";
    }
    
} catch (PDOException $e) {
    die("Connection failed: " . $e->getMessage());
}

?>
