<!DOCTYPE html>
<html lang="th">
<head>
    <meta charset="UTF-8">
    <title>ระบบบริหารจัดการครุภัณฑ์ QR CODE</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/sweetalert2@11.12.0/dist/sweetalert2.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css" integrity="sha512-z3gLpd7yknf1YoNbCzqRKc4qyor8gaKU1qmn+CShxbuBusANI9QpRohGBreCFkKxLhei6S9CQXFEbbKuqLg0DA==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <div class="container">
        <div class="form-container sign-in">
            <form action="login_process.php" method="post">
                <div class="form-group">
                    <label for="username" class="form-label">ชื่อผู้ใช้:</label>
                    <input type="text" id="username" name="username" class="form-control" placeholder="ชื่อผู้ใช้งาน" required>
                </div>
                <div class="form-group password-field">
                    <label for="password" class="form-label">รหัสผ่าน:</label>
                    <input type="password" id="password" name="password" class="form-control" placeholder="รหัสเข้าใช้งาน" required>
                    <span class="show-password-toggle" onclick="togglePasswordVisibility()">
                        <i class="fas fa-eye">แสดงรหัสผ่าน</i>
                    </span>
                </div>
                <div class="checkbox-container">
                    <input type="checkbox" id="rememberMeCheckbox" checked>
                    <label for="rememberMeCheckbox">Remember me</label>
                </div>
                <button type="submit" class="btn btn-primary">เข้าสู่ระบบ</button>
                <a href="#" id="forgotPasswordLink" onclick="showForgotPasswordPopup()">ลืมรหัสผ่าน</a>
            </form>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11.12.0/dist/sweetalert2.all.min.js"></script>
    <script src="https://code.jquery.com/jquery-3.7.1.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        // ตรวจสอบ query parameter สำหรับข้อผิดพลาดหรือความสำเร็จ
        document.addEventListener('DOMContentLoaded', (event) => {
            const urlParams = new URLSearchParams(window.location.search);
            const success = urlParams.get('success');
            const error = urlParams.get('error');

            if (success === 'true') {
                Swal.fire({
                    title: 'เข้าสู่ระบบสำเร็จ',
                    icon: 'success',
                    timer: 1500,
                    showConfirmButton: false,
                }).then(() => {
                    window.location.href = 'view_equipment.php';
                });
            } else if (error) {
                Swal.fire({
                    icon: 'error',
                    title: 'เกิดข้อผิดพลาด',
                    text: decodeURIComponent(error), 
                }).then(() => {
                    window.history.replaceState({}, document.title, window.location.pathname);
                });
            }
        });

        // แสดง SweetAlert2 เมื่อลืมรหัสผ่าน
        function showForgotPasswordPopup() {
            Swal.fire({
                icon: 'info',
                title: 'ลืมรหัสผ่าน',
                text: 'กรุณาติดต่อผู้ดูแลระบบ'
            });
        }

        // Toggle password visibility
        function togglePasswordVisibility() {
            const passwordInput = document.getElementById("password");
            const showPasswordToggle = document.querySelector(".show-password-toggle i");

            if (passwordInput.type === "password") {
                passwordInput.type = "text";
                showPasswordToggle.classList.remove("fa-eye");
                showPasswordToggle.classList.add("fa-eye-slash");
            } else {
                passwordInput.type = "password";
                showPasswordToggle.classList.remove("fa-eye-slash");
                showPasswordToggle.classList.add("fa-eye");
            }
        }
    </script>
</body>
</html>
