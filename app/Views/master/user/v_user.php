<?= $this->extend('v_sidebar') ?>
<?= $this->section('content') ?>
<div class="card ms-3 me-3 my-3">

    <div class="card-header">
        <button class="btn btn-sm btn-primary" data-bs-toggle="modal" data-bs-target="#addModal">Tambah User</button>

        <!-- Modal Tambah User -->
        <div class="modal fade" id="addModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h1 class="modal-title fs-5" id="exampleModalLabel">Form Add</h1>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <form id="formAdd">
                            <div class="mb-3">
                                <label for="username" class="form-label">Username</label>
                                <input type="text" class="form-control" name="username" id="username" placeholder="Enter User Name">
                            </div>
                            <div class="mb-3">
                                <label for="" class="form-label">Active</label>
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" value="1" name="isactiveadd">
                                    <label class="form-check-label" for="flexCheckDefault">
                                        Is Active
                                    </label>
                                </div>
                            </div>
                    </div>
                    <button type="submit" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
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
                <?php $no = 1;
                foreach ($user as $data): ?>
                    <tr>
                        <th scope="row"><?= $no++ ?></th>
                        <td><?= $data['username'] ?></td>
                        <td><?= $data['createddate'] ?></td>
                        <td><?= $data['updateddate'] ?></td>
                        <td><?= $data['isactive'] ?></td>
                        <td>
                            <button class="btn btn-sm btn-warning" id="update" data-bs-toggle="modal" data-bs-target="#editModal">Edit</button>
                            <button class="btn btn-sm btn-danger" type="button" onclick="deleteUser(<?= $data['userid'] ?>)">Delete</button>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
    </div>
</div>

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
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
                    location.reload()
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




    }
</script>
<?= $this->endSection(); ?>