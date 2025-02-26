<?= $this->extend('v_sidebar') ?>
<?= $this->section('content') ?>
<div class="card ms-3 me-3 my-3">

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
                                    <input class="form-check-input" type="checkbox" value="1" name="isactiveadd" id="isaactiveadd">
                                    <label class="form-check-label" for="flexCheckDefault">
                                        Active
                                    </label>
                                </div>
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" value="0" name="isactiveadd" id="isaactiveadd">
                                    <label class="form-check-label" for="flexCheckDefault">
                                        Non Active
                                    </label>
                                </div>
                            </div>
                    </div>
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    <button type="submit" id="saveButton" class="btn btn-primary saveButton">Save changes</button>
                </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Modal Edit User -->

    <div class="modal fade" id="editModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h1 class="modal-title fs-5" id="exampleModalLabel">Form Edit</h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <input type="hidden" name="userid" id="userid">
                    <form id="formUpdate">
                        <div class="mb-3">
                            <label for="usernameupdate" class="form-label">Username</label>
                            <input type="email" class="form-control" id="usernameupdate" placeholder="Enter User Name">
                        </div>
                        <div class="mb-3">
                            <label for="" class="form-label">Active</label>
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" value="" name="isactiveupdate" id="flexCheckDefault">
                                <label class="form-check-label" for="flexCheckDefault">
                                    Is Active
                                </label>
                            </div>
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" value="" name="isactiveupdate" id="flexCheckDefault">
                                <label class="form-check-label" for="flexCheckDefault">
                                    Active
                                </label>
                            </div>
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    <button type="button" class="btn btn-primary" id="saveupdate">Save changes</button>
                </div>
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
                                <input type = "text" class =form-control" id="username" value="${data.username}" onblur="updateUser(${data.userid})">
                                <td>${data.createddate}</td>
                                <td>${data.updateddate}</td>
                                <td>${data.isactive}</td>
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

        function updateUser(userid) {
            let username = $('#username').val();

            $.ajax({
                type: 'POST',
                url: '<?= base_url('user/update') ?>',
                dataType: 'json',
                data: {
                    username: username
                },
                success: function(response) {
                    if (response.status == 'success') {
                        alert(response.message);
                        loadTable();
                    } else {
                        alert(response.message);
                    }
                },
            })
        }



        function deleteUser(userid) {
            $.ajax({
                type: 'POST',
                url: '<?= base_url('user/deleteUsers') ?>',
                dataType: 'json',
                data: {
                    id: userid
                },
                success: function(response) {
                    if (response.status == 'success') {
                        alert(response.message)
                        loadTable();
                    } else {
                        alert(response.message)
                    }
                }
            })

            $('#formAdd').on('submit', function(e) {
                e.preventDefault();
                let username = $('#username').val();
                let isactive = $('input[name="isactiveadd"]:checked').val();

                $.ajax({
                    type: 'POST',
                    url: '<?= base_url('user/add') ?>',
                    dataType: 'json',
                    data: {
                        username: username,
                        isactive: isactive

                    },
                    success: function(response) {
                        if (response.status == 'success') {
                            alert(response.message)
                            location.reload()
                        } else {
                            alert(response.message)
                        }
                    },
                    error: function() {
                        alert('Data Gagal Ditambahkan')
                    }
                });
            });


            $('#saveupdate').on('click', function(e) {
                e.preventDefault();

                let username = $('$usernameupdate').val();
                let isactive = $('input[name="isactiveupdate"]:checked').val();

                $.ajax({
                    type: 'POST',
                    url: '<?= base_url('user/update') ?>',
                    dataType: 'json',
                    data: {
                        username: username,
                        isactive: isactive

                    },
                    success: function(response) {
                        if (response.status == 'success') {
                            alert(response.message)
                            location.reload()
                        } else {
                            alert(response.message)
                        }
                    },
                    error: function() {
                        alert('Data Gagal Diupdate')
                    }
                });
            });

            function loadTable() {

            }
        }

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