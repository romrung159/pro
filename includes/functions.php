<?php
function isLoggedIn() {
    return isset($_SESSION['user_id']);
}

function generateQRCode($data, $filename) {
    include 'phpqrcode/qrlib.php';
    $filePath = 'qr_codes/' . $filename;
    QRcode::png($data, $filePath, QR_ECLEVEL_L, 4);
    return $filePath;
}
?>
