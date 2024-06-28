<?php
session_start();
include '../includes/config.php';
include '../includes/functions.php';

if (!isLoggedIn()) {
    header('Location: ../auth/login.php');
    exit;
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $name = $_POST['name'];
    $price = $_POST['price'];
    $brand = $_POST['brand'];
    $model = $_POST['model'];
    $purchase_date = $_POST['purchase_date'];
    $code = $_POST['code'];

    $image = $_FILES['image']['name'];
    $target_dir = "../images/";
    $target_file = $target_dir . basename($image);

    if (move_uploaded_file($_FILES['image']['tmp_name'], $target_file)) {
        $sql = "INSERT INTO assets (name, price, brand, model, purchase_date, code, image) VALUES ('$name', '$price', '$brand', '$model', '$purchase_date', '$code', '$target_file')";

        if ($conn->query($sql) === TRUE) {
            $qrFile = generateQRCode($code, $code . '.png');
            header('Location: index.php');
        } else {
            echo "Error: " . $sql . "<br>" . $conn->error;
        }
    } else {
        echo "Error uploading image.";
    }
}
?>

<form method="POST" action="" enctype="multipart/form-data">
    Name: <input type="text" name="name" required><br>
    Price: <input type="number" step="0.01" name="price" required><br>
    Brand: <input type="text" name="brand" required><br>
    Model: <input type="text" name="model" required><br>
    Purchase Date: <input type="date" name="purchase_date" required><br>
    Code: <input type="text" name="code" required><br>
    Image: <input type="file" name="image" required><br>
    <button type="submit">Add Asset</button>
</form>
