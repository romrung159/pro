<!DOCTYPE html>
<html lang="th">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Upload Multiple Files</title>
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.6/css/jquery.dataTables.min.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/sweetalert2@11.12.0/dist/sweetalert2.min.css" rel="stylesheet">
    <link rel="stylesheet" href="multiple.css"> 
</head>

<body>
    <div class="container">
        <h2>Upload Multiple Files</h2>
        <form id="uploadForm" action="uploadpc.php" method="post" enctype="multipart/form-data">
            <div id="fileInputsContainer">
                <div class="file-input-wrapper">
                    <label for="fileInput1" class="file-label">เลือกไฟล์</label>
                    <input type="file" name="images[]" id="fileInput1" multiple>
                    <button type="button" class="remove-file-btn" onclick="removeFileInput(this)">ลบ</button>
                </div>
            </div>
            <button type="button" id="addFileBtn">เพิ่มไฟล์</button>
            <br><br>
            <button type="submit" class="btn btn-primary">Upload Files</button>
        </form>

        <table id="dataTable" class="display">
            <thead>
                <tr>
                    <th>ชื่อไฟล์</th>
                    <th>ขนาดไฟล์</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
            </tbody>
        </table>
    </div>

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script src="multiple.js"></script> 
</body>

</html>
