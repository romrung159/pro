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
    $sql = "SELECT * FROM assets WHERE id = $id";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        $asset = $result->fetch_assoc();
    } else {
        echo "No asset found with this ID.";
        exit;
    }
} else {
    echo "No ID provided.";
    exit;
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $name = $_POST['name'];
    $price = $_POST['price'];
    $brand = $_POST['brand'];
    $model = $_POST['model'];
    $purchase_date = $_POST['purchase_date'];
    $code = $_POST['code'];
    $image = $asset['image'];

    if ($_FILES['image']['name']) {
        $target_dir = "../images/";
        $target_file = $target_dir . basename($_FILES['image']['name']);
        if (move_uploaded_file($_FILES['image']['tmp_name'], $target_file)) {
            $image = $target_file;
        } else {
            echo "Error uploading image.";
        }
    }

    $sql = "UPDATE assets SET name='$name', price='$price', brand='$brand', model='$model', purchase_date='$purchase_date', code='$code', image='$image' WHERE id=$id";

    if ($conn->query($sql) === TRUE) {
        generateQRCode($code, $code . '.png');
        header('Location: index.php');
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }
}
?>

<form method="POST" action="" enctype="multipart/form-data">
    Name: <input type="text" name="name" value="<?php echo $asset['name']; ?>" required><br>
    Price: <input type="number" step="0.01" name="price" value="<?php echo $asset['price']; ?>" required><br>
    Brand: <input type="text" name="brand" value="<?php echo $asset['brand']; ?>" required><br>
    Model: <input type="text" name="model" value="<?php echo $asset['model']; ?>" required><br>
    Purchase Date: <input type="date" name="purchase_date" value="<?php echo $asset['purchase_date']; ?>" required><br>
    Code: <input type="text" name="code" value="<?php echo $asset['code']; ?>" required><br>
    Image: <input type="file" name="image"><br>
    <button type="submit">Update Asset</button>
</form>
