document.addEventListener('DOMContentLoaded', function () {
    const addFileBtn = document.getElementById('addFileBtn');
    const fileInputsContainer = document.getElementById('fileInputsContainer');
    let fileInputCounter = 1;

    const dataTable = $('#dataTable').DataTable({
        pagingType: "full_numbers",
        pageLength: 10,
        language: {
            lengthMenu: "แสดง _MENU_ รายการต่อหน้า",
            zeroRecords: "ไม่พบข้อมูล",
            info: "แสดงหน้า _PAGE_ จาก _PAGES_",
            infoEmpty: "ไม่มีข้อมูล",
            infoFiltered: "(กรองจาก _MAX_ รายการทั้งหมด)",
            paginate: {
                first: "หน้าแรก",
                last: "หน้าสุดท้าย",
                next: "ถัดไป",
                previous: "ก่อนหน้า"
            }
        },
        columns: [
            { data: 'file_name' },
            { data: 'file_size' },
            { data: null, // สำหรับ action column
              render: function (data, type, row) {
                return '<button class="btn btn-danger delete-btn" data-id="' + row.id + '">Delete</button>';
              }
            }
        ]
    });

    addFileBtn.addEventListener('click', addFileInput);
    addFileInput(); 

    function addFileInput() {
        fileInputCounter++;
        const newFileInput = `
            <div class="file-input-wrapper">
                <label for="fileInput${fileInputCounter}" class="file-label">เลือกไฟล์</label>
                <input type="file" name="images[]" id="fileInput${fileInputCounter}" multiple>
                <button type="button" class="remove-file-btn" onclick="removeFileInput(this)">ลบ</button>
            </div>
        `;
        fileInputsContainer.insertAdjacentHTML('beforeend', newFileInput);
    }

    function removeFileInput(button) {
        button.parentNode.remove();
    }

    $('#uploadForm').submit(function (event) {
        event.preventDefault();

        let hasFiles = false;
        $('input[type="file"]').each(function() {
            if ($(this).get(0).files.length > 0) {
                hasFiles = true;
                return false; 
            }
        });

        if (!hasFiles) {
            Swal.fire({
                icon: 'error',
                title: 'ผิดพลาด',
                text: 'กรุณาเลือกไฟล์ก่อนอัปโหลด'
            });
            return;
        }

        var formData = new FormData(this);

        $.ajax({
            url: "uploadpc.php",
            type: "POST",
            data: formData,
            processData: false,
            contentType: false,
            beforeSend: function() {
                Swal.fire({
                    title: 'กำลังอัปโหลด',
                    text: 'กรุณารอสักครู่...',
                    allowOutsideClick: false,
                    didOpen: () => {
                        Swal.showLoading();
                    }
                });
            },
            success: function(response) {
                var result = JSON.parse(response);
                Swal.fire({
                    icon: result.status,
                    title: result.status == 'success' ? 'สำเร็จ' : 'ผิดพลาด',
                    text: result.message
                });
                if (result.status == 'success') {
                    dataTable.clear().draw();
                    result.data.forEach(function(file) {
                        dataTable.row.add(file).draw(false);
                    });
                }
            },
            error: function() {
                Swal.fire({
                    icon: 'error',
                    title: 'ผิดพลาด',
                    text: 'เกิดข้อผิดพลาดในการอัปโหลด'
                });
            }
        });
    });

    // Event listener for delete button
    $('#dataTable tbody').on('click', '.delete-btn', function() {
        const fileId = $(this).data('id');
        // ... (Add your delete logic here)
    });
});
