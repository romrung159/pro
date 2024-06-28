<?php

session_start();
require_once "config.php";


// if (isset($_POST['submit'])) {
//     $firstname = $_POST['firstname'];
//     $lastname = $_POST['lastname'];
//     $position = $_POST['position'];
//     $img = $_FILES['img'];

//     $allow = array('jpg', 'jpeg', 'png');
//     $extension = explode(".", $img['name']);
//     $fileActExt = strtolower(end($extension));
//     $fileNew = rand() . "." . $fileActExt;
//     $filePath = "uploads/".$fileNew;

//     if (in_array($fileActExt, $allow)) {
//         if ($img['size'] > 0 && $img['error'] == 0) {
//             if (move_uploaded_file($img['tmp_name'], $filePath)) {
//                 $sql = $conn->prepare("INSERT INTO users(firstname, lastname, position, img) VALUES(:firstname, :lastname, :position, :img)");
//                 $sql->bindParam(":firstname", $firstname);
//                 $sql->bindParam(":lastname", $lastname);
//                 $sql->bindParam(":position", $position);
//                 $sql->bindParam(":img", $fileNew);
//                 $sql->execute();

//                 if ($sql) {
//                     $_SESSION['success'] = "Data has been inserted succesfully";
//                 } else {
//                     $_SESSION['error'] = "Data has not been inserted succesfully";
//                 }
//             }
//         }
//     }
// }

if (isset($_GET['delete'])) {
    $delete_id = $_GET['delete'];
    $deletestmt = $conn->prepare("DELETE FROM assets WHERE id = :id");
    $deletestmt->bindParam(':id', $delete_id);
    $deletestmt->execute();

    if ($deletestmt) {
        echo "<script>alert('Data has been deleted successfully');</script>";
        $_SESSION['success'] = "Data has been deleted successfully";
        header("refresh:1; url=index.php");
        exit; // ออกจากการทำงานทันทีหลังจาก redirect
    }
}


?>

<!DOCTYPE html>
<html lang="th">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ระบบบริหารจัดการครุภัณฑ์สำนักงาน</title>

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.9.0/css/bootstrap-datepicker.min.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
    <script src="https://code.jquery.com/jquery-3.6.0.js"></script>
    <script src="https://code.jquery.com/ui/1.12.1/jquery-ui.min.js"></script>

    <style>
    .alert-secondary { 
      display: block;
      margin: 0 auto;
      width: fit-content;
    }
    /* สไตล์ปุ่มโดยรวม */
.search-button {
  background-color: #6f42c1;
  color: white;
  border: none;
  border-radius: 5px;
  padding: 10px 20px;
}

/* สไตล์เมื่อ hover */
.search-button:hover {
  background-color: #5a32a3;
}

/* สไตล์ข้อความ shortcut */
.shortcut {
  margin-left: 10px;
  font-size: 12px;
  color: #ccc;
}

  </style>
</head>

<body>

    <div class="modal fade" id="userModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">เพิ่มข้อมูลครุภัณฑ์ : </h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form action="insert.php" id="formData" method="post" enctype="multipart/form-data">

                        <div class="mb-3">
                            <label for="name" class="col-form-label"> ชื่อครุภัณฑ์ :</label>
                            <input type="text" required class="form-control" name="name">
                        </div>
                        <div class="mb-3">
                            <label for="price" class="col-form-label">ราคา :</label>
                            <input type="text" required class="form-control" name="price">
                        </div>
                        <div class="mb-3">
                            <label for="brand" class="col-form-label">ยี่ห้อ/รายละเอียด:</label>
                            <input type="text" required class="form-control" name="brand">
                        </div>
                        <div class="mb-3">
                            <label for="model" class="col-form-label">รุ่น :</label>
                            <input type="text" required class="form-control" name="model">
                        </div>
                        <div class="mb-3">
                            <label for="purchase_dat" class="col-form-label">วันที่ซื้อ :</label>
                            <input type="text" required class="form-control" id="datepicker" name="purchase_dat">
                        </div>
                        <div class="mb-3">
                            <label for="code Index" class="col-form-label">เลขทะเบียนครุภัณฑ์ :</label>
                            <input type="text" required class="form-control" name="code Index">
                        </div>
                        <div class="mb-3">
                            <label for="image" class="col-form-label">Image:</label>
                            <input type="file" required class="form-control" id="imgInput" name="image">
                            <img width="100%" id="previewImg" alt="">
                        </div>

                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">ยกเลิก</button>
                            <button type="submit" id="submit" name="submit" class="btn btn-success">ตกลง</button>
                        </div>
                    </form>
                </div>

            </div>
        </div>
    </div>

    <div class="container mt-5 justify-content-md-end ">
        <div class="row">
            <div class="d-flex justify-content-center">
            <div class="alert alert-secondary w-300" role="alert">เมนู : การบริหารจัดการระบบครุภัณฑ์สำนักงาน </div>
            
  
</button>

</button> </div>
            <div class="d-grid gap-2 d-md-flex justify-content-md-end">
                <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#userModal">เพิ่มข้อมูล</button>
            </div>
        </div>
        <hr>
        <?php if (isset($_SESSION['success'])) { ?>
            <div class="alert alert-success">
                <?php
                echo $_SESSION['success'];
                unset($_SESSION['success']);
                ?>
            </div>
        <?php } ?>
        <?php if (isset($_SESSION['error'])) { ?>
            <div class="alert alert-danger">
                <?php
                echo $_SESSION['error'];
                unset($_SESSION['error']);
                ?>
            </div>
        <?php } ?>

        <script>
            $(document).ready(function() {
                // เรียกใช้ Datepicker ด้วย ID ของ input ที่ต้องการ
                $('#datepicker').datepicker({
                    format: 'dd/mm/yyyy', // รูปแบบของวันที่ที่ต้องการ
                    autoclose: true
                });
            });
        </script>

        <!-- Users Data -->
        <table class="table">
            <thead>
                <tr>
                    <th scope="col">#</th>
                    <th scope="col">ชื่อครุภัณฑ์</th>
                    <th scope="col">ราคา</th>
                    <th scope="col">ยี่ห้อ/รายละเอียด</th>
                    <th scope="col">รุ่น</th>
                    <th scope="col">วันที่ซื้อ</th>
                    <th scope="col">เลขทะเบียนครุภัณฑ์</th>
                    <th scope="col">Actions</th>
                </tr>
                <div class="text-end" a href='logout.php' id='logoutLink'>
                <button type="button" class="btn btn-dark">ออกจากระบบ</button>
    </div>
            </thead>
            <tbody>
                <?php
                $stmt = $conn->query("SELECT * FROM assets");
                $stmt->execute();
                $assets = $stmt->fetchAll();

                if (!$assets) {
                    echo "<tr><td colspan='6' class='text-center'>- ไม่พบข้อมูล -</td></tr>";
                } else {
                    foreach ($assets as $assets) {
                ?>
                        <tr>
                            <th scope="row"><?= $asset['id']; ?></th>
                            <td><?= $assets['firstname']; ?></td>
                            <td><?= $assets['lastname']; ?></td>
                            <td><?= $assets['position']; ?></td>
                            <td width="250px"><img width="100%" src="uploads/<?= $asset['img']; ?>" class="rounded" alt=""></td>
                            <td>
                                <a href="edit.php?id=<?= $assets['id']; ?>" class="btn btn-warning">Edit</a>
                                <a data-id="<?= $assets['id']; ?>" href="?delete=<?= $assets['id']; ?>" class="btn btn-danger delete-btn">Delete</a>
                            </td>
                        </tr>
                <?php }
                } ?>
            </tbody>
        </table>
    </div>

    
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ka7Sk0Gln4gmtz2MlQnikT1wXgYsOg+OMhuP+IlRH9sENBO0LRn5q+8nbTov4+1p" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.9.0/js/bootstrap-datepicker.min.js"></script>

    <script>
        let imgInput = document.getElementById('imgInput');
        let previewImg = document.getElementById('previewImg');

        imgInput.onchange = evt => {
            const [file] = imgInput.files;
            if (file) {
                previewImg.src = URL.createObjectURL(file);
            }
        }

        $(".delete-btn").click(function(e) {
            var userId = $(this).data('id');
            e.preventDefault();
            deleteConfirm(userId);
        })

        function deleteConfirm(userId) {
            Swal.fire({
                title: 'Are you sure?',
                text: "It will be deleted permanently!",
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Yes, delete it!',
                showLoaderOnConfirm: true,
                preConfirm: function() {
                    return new Promise(function(resolve) {
                        $.ajax({
                                url: 'index.php',
                                type: 'GET',
                                data: 'delete=' + userId,
                            })
                            .done(function() {
                                Swal.fire({
                                    title: 'success',
                                    text: 'Data deleted successfully!',
                                    icon: 'success',
                                }).then(() => {
                                    document.location.href = 'index.php';
                                })
                            })
                            .fail(function() {
                                Swal.fire('Oops...', 'Something went wrong with ajax !', 'error')
                                window.location.reload();
                            });
                    });
                },
            });
        }
        document.getElementById('logoutLink').addEventListener('click', function(event) {
    event.preventDefault();

    Swal.fire({
        icon: 'info',
        title: 'ออกจากระบบ',
        text: 'คุณต้องการที่จะออกจากระบบหรือไม่?',
        showCancelButton: true,
        confirmButtonText: 'ใช่',
        cancelButtonText: 'ไม่',
    }).then((result) => {
        if (result.isConfirmed) {
            // ทำการ redirect หลังจาก confirm ให้ลองออกจากระบบ
            window.location.href = 'index.php';
        }
    });
});
    </script>

</body>

</html>