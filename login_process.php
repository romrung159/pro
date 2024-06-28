<?php
session_start();
include 'config.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = filter_input(INPUT_POST, 'username');
    $password = $_POST['password'];

    try {
        $stmt = $conn->prepare("SELECT * FROM admins WHERE username = ?");
        $stmt->execute([$username]);
        $row = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($row) {
            if (password_verify($password, $row['password'])) {
                // Password verification successful, set session variables
                $_SESSION['admin_id'] = $row['id'];
                $_SESSION['admin_username'] = $row['username'];
                $_SESSION['admin_logged_in'] = true;

                // Redirect to view_equipment.php upon successful login
                header("Location: view_equipment.php?success=true");
                exit();
            } else {
                // Invalid password
                $error_message = "ชื่อผู้ใช้หรือรหัสผ่านไม่ถูกต้อง";
            }
        } else {
            // User not found
            $error_message = "ไม่พบชื่อผู้ใช้";
        }

        // Redirect back to index.php with error message
        header("Location: index.php?error=" . urlencode($error_message));
        exit();

    } catch (PDOException $e) {
        // Database error
        $error_message = "เกิดข้อผิดพลาดในการเข้าสู่ระบบ";
        error_log($e->getMessage()); // Log the error message for debugging
        header("Location: index.php?error=" . urlencode($error_message));
        exit();
    }
} else {
    // Redirect if accessed directly without POST method
    header('Location: index.php');
    exit();
}
?>
