<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "office_inventory";

try {
    $conn = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
    // set the PDO error mode to exception
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    // echo "Connected successfully"; // สามารถเอา comment ออกได้หากไม่ต้องการแสดงข้อความนี้
} catch(PDOException $e) {
    echo "Connection failed: " . $e->getMessage();
    // หากเชื่อมต่อไม่สำเร็จ จะแสดงข้อความผิดพลาด
    // ในการใช้งานจริงควรเปลี่ยนเป็นการจัดการข้อผิดพลาดที่เหมาะสมตามนโยบายของระบบ
}
?>
