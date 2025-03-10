<?= $this->extend('v_sidebar') ?>
<?= $this->section('content') ?>
<div class="card ms-3 me-3 my-3">

    <a href="<?= base_url('user/exportPDF') ?>" class="btn btn-primary d-flex align-items-center">
        <i class="bx bx-export me-2"></i>
        <span class="fw-normal fs-7">Export PDF</span>
    </a>
    <div class="card-header">
        <button class="btn btn-sm btn-primary" data-bs-toggle="modal" data-bs-target="#addUserModal">Tambah User</button>

        <!-- Modal Tambah User -->
        <div class="modal fade" id="addUserModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h1 class="modal-title fs-5" id="addUserModalLabel">Form Add</h1>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <form id="addUserForm">
                            <div class="mb-3">
                                <label for="username" class="form-label">Username</label>
                                <input type="text" class="form-control" name="username" id="username" placeholder="Enter User Name" required>
                            </div>
                            <div class="mb-3">
                                <label for="" class="form-label">Active</label>
                                <div class="form-check">
                                    <input type="hidden" name="isactive" value="0" />
                                    <input class="form-check-input" type="checkbox" value="1" name="isactiveadd" id="isaactiveadd">
                                    <label class="form-check-label" for="flexCheckDefault">
                                        Active
                                    </label>
                                </div>
                            </div>
                    </div>
                    <button type="submit" id="saveButton" class="btn btn-primary saveButton mb-2 ms-2" style="max-width: 180px;">Save changes</button>
                </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Table -->
    <div class="container mt-3">
        <table id="userTable" class="table table-striped table-bordered">
            <thead>
                <tr>
                    <th width=1%>No </th>
                    <th class="text-center">Username</th>
                    <th class="text-center">Created Date</th>
                    <th class="text-center">Updated Date</th>
                    <th class="text-center">Is Active</th>
                    <th class="text-center">Actions</th>
                </tr>
            </thead>
            <tbody>
            </tbody>
    </div>
</div>

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<script>
    $(document).ready(function() {
        function loadTable() {
            $.ajax({
                url: '<?= base_url('user/loadTable') ?>',
                type: 'GET',
                dataType: 'json',
                success: function(response) {
                    if (response.status == 'success') {
                        let tableBody = $('#userTable tbody');
                        tableBody.empty();
                        $.each(response.data, function(index, data) {
                            let row = `
                            <tr>
                                <th scope="row">${index +1}</th>
                                <td>
                                    <input type="text" class="form-control" name"updateusername" id="updateusername" value="${data.username}" onblur="updateUsername(${data.userid}, this.value, '${data.isactive  == 1 ? 'checked' : ''}')">
                                </td>
                                <td>${data.createddate}</td>
                                <td>${data.updateddate}</td>
                                <td>
                                    <input type="checkbox" class="form-check input" ${data.isactive == 1 ? 'checked' : ''} onchange="updateisactive(${data.userid}, this.checked, '${data.username}')">
                                </td>
                                <td>
                                    <form action="/ajax-test/user/deleteUsers/${data.userid}" method="post" class="deleteForm d-inline">
                                    <button  type="submit" class = "btn btn-sm btn-danger">Delete</button>
                                </td>
                                </tr>
                            `;
                            tableBody.append(row);
                        });
                    } else {
                        alert('gagal memuat data pengguna');
                    }
                },
                error: function() {
                    alert('Data Gagal Dimuat');
                }
            });
        }

        loadTable();

        $('#addUserForm').on('submit', function(e) {
            e.preventDefault();
            let username = $('#username').val();
            let isactive = $('input[name="isactiveadd"]:checked').val();
            $.ajax({
                type: 'POST',
                url: '<?= base_url('user/add') ?>',
                data: {
                    username: username,
                    isactive: isactive
                },
                dataType: 'json',
                success: function(response) {
                    if (response.status == 'success') {
                        alert('Berhasil! ' + response.message);
                        $('#addUserModal').modal('hide');
                        $('#addUserForm')[0].reset();
                        loadTable();
                    } else {
                        alert('Gagal! ' + response.message);
                    }
                }
            })
        })

        window.updateUsername = function(userid, username, isactive) {
            $.ajax({
                url: '<?= base_url('user/update') ?>',
                type: 'POST',
                data: {
                    userid: userid,
                    username: username,
                    isactive: isactive ? 1 : 0
                },
                success: function(response) {
                    if (response.status == 'success') {
                        Swal.fire({
                            icon: 'success',
                            title: 'Success',
                            text: response.message,
                            confirmButtonText: 'Ok'
                        });
                    } else {
                        Swal.fire({
                            icon: 'error',
                            title: 'Failed',
                            text: response.message,
                            confirmButtonText: 'Ok'
                        });
                    }
                    loadTable();
                },
                error: function() {
                    alert('Failed to update type name');
                }
            });
        }

        window.updateisactive = function(userid, isactive, username) {
            $.ajax({
                url: '<?= base_url('user/update') ?>',
                type: 'POST',
                data: {
                    userid: userid,
                    username: username,
                    isactive: isactive ? 1 : 0
                },
                success: function(response) {
                    if (response.status == 'success') {
                        Swal.fire({
                            icon: 'success',
                            title: 'Success',
                            text: response.message,
                            confirmButtonText: 'Ok'
                        });
                    } else {
                        Swal.fire({
                            icon: 'error',
                            title: 'Failed',
                            text: response.message,
                            confirmButtonText: 'Ok'
                        });
                    }
                    loadTable();
                },
                error: function() {
                    alert('Failed to update is active');
                }
            });
        }

        $(document).on('submit', '.deleteForm', function(e) {
            e.preventDefault();
            let form = $(this);

            if (confirm('Apakah Anda Yakin?')) {
                $.ajax({
                    type: 'POST',
                    url: form.attr('action'),
                    data: form.serialize(),
                    dataType: 'json',
                    success: function(response) {
                        if (response.status == 'success') {
                            alert('Terhapus! ' + response.message);
                            loadTable();
                        } else {
                            alert('Gagal! ' + response.message);
                        }
                    },
                    error: function() {
                        alert('Gagal! Terjadi kesalahan dalam penghapusan.');
                    }
                });
            }
        });
    });
</script>
<?= $this->endSection(); ?>