<?php
session_start();
include '../includes/config.php';
include '../includes/functions.php';

if (!isLoggedIn()) {
    header('Location: ../auth/login.php');
    exit;
}

$sql = "SELECT * FROM assets";
$result = $conn->query($sql);
?>

<a href="add.php">Add New Asset</a>

<table border="1">
    <tr>
        <th>Name</th>
        <th>Price</th>
        <th>Brand</th>
        <th>Model</th>
        <th>Purchase Date</th>
        <th>Code</th>
        <th>Image</th>
        <th>QR Code</th>
        <th>Actions</th>
    </tr>
    <?php while ($row = $result->fetch_assoc()): ?>
        <tr>
            <td><?php echo $row['name']; ?></td>
            <td><?php echo $row['price']; ?></td>
            <td><?php echo $row['brand']; ?></td>
            <td><?php echo $row['model']; ?></td>
            <td><?php echo $row['purchase_date']; ?></td>
            <td><?php echo $row['code']; ?></td>
            <td><img src="<?php echo $row['image']; ?>" width="100"></td>
            <td><img src="../qr_codes/<?php echo $row['code']; ?>.png" width="100"></td>
            <td>
                <a href="edit.php?id=<?php echo $row['id']; ?>">Edit</a>
                <a href="delete.php?id=<?php echo $row['id']; ?>" onclick="return confirm('Are you sure?')">Delete</a>
            </td>
        </tr>
    <?php endwhile; ?>
</table>
