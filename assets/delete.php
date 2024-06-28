<?php
session_start();
include '../includes/config.php';
include '../includes/functions.php';

if (!isLoggedIn()) {
    header('Location: ../auth/login.php');
    exit;
}

if (isset($_GET['id'])) {
    $id = $_GET['id'];

    // Get the current asset information
    $sql = "SELECT * FROM assets WHERE id = $id";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        $asset = $result->fetch_assoc();
        
        // Delete the asset
        $sql = "DELETE FROM assets WHERE id = $id";
        if ($conn->query($sql) === TRUE) {
            // Optionally, you can delete the image file and QR code file
            if (file_exists($asset['image'])) {
                unlink($asset['image']);
            }
            $qrFilePath = '../qr_codes/' . $asset['code'] . '.png';
            if (file_exists($qrFilePath)) {
                unlink($qrFilePath);
            }
            header('Location: index.php');
        } else {
            echo "Error: " . $conn->error;
        }
    } else {
        echo "No asset found with this ID.";
    }
} else {
    echo "No ID provided.";
}
?>
