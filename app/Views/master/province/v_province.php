<?= $this->extend('v_sidebar') ?>
<?= $this->section('content') ?>
<div class="card ms-3 me-3 my-3">
    <div class="card-header">
        <button class="btn btn-sm btn-primary" data-bs-toggle="modal" data-bs-target="#exampleModal">Add</button>

        <div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h1 class="modal-title fs-5" id="exampleModalLabel">create</h1>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <form id="formInsert">
                        <div class="mb-3">
                            <label for="nama" class="form-label">Province Name</label>
                            <input type="text" class="form-control" name="nama" id="nama" placeholder="Province Name">
                        </div>
                        <div class="mb-3">
                            <label for="" class="form-label">Active</label>
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" value="1" name="check">
                                <label class="form-check-label" for="flexCheckDefault">
                                    Is Active
                                </label>
                            </div>
                        </div>
                        </form>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                        <button type="submit" id="insert" class="btn btn-primary">Save</button>
                    </div>
                </div>
            </div>
        </div>

        <div class="modal fade" id="editModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h1 class="modal-title fs-5" id="exampleModalLabel">Edit</h1>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <input type="hidden" name="provid" id="provid">
                        <div class="mb-3">
                            <label for="namaupdate" class="form-label">Province Name</label>
                            <input type="email" class="form-control" id="namaupdate" placeholder="Enter Province Name">
                        </div>
                        <div class="mb-3">
                        <label for="" class="form-label">Active</label>
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" value="1" name="isactiveupdate" id="flexCheckDefault">
                                <label class="form-check-label" for="flexCheckDefault">
                                    Is Active
                                </label>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                        <button type="button" class="btn btn-primary" id="update">Save</button>
                    </div>
                </div>
            </div>
        </div>

    </div>
    <div class="card-body">
        <table class="table">
            <thead>
                <tr>
                    <th scope="col">No</th>
                    <th scope="col">Province Name</th>
                    <th scope="col">Created Date</th>
                    <th scope="col">Update Date</th>
                    <th scope="col">Is Active</th>
                    <th scope="col">Action</th>
                </tr>
            </thead>
            <tbody>
                <?php $no = 1;foreach($user as $data): ?>
                <tr>
                    <th scope="row"><?= $no++ ?></th>
                    <td><input type="text" class="form-control address-input" value="<?= $data['provname'] ?> "></td>
                    <td><?= $data['createddate'] ?></td>
                    <td><?= $data['updateddate'] ?></td>
                    <td><?= $data['isactive'] ?></td>
                    <td>
                        <button class="btn btn-sm btn-warning" onclick="formUpdate(<?= $data['provid'] ?>)" data-bs-toggle="modal" data-bs-target="#editModal">Edit</button>
                        <button class="btn btn-sm btn-danger" type="button" onclick="hapus(<?= $data['provid'] ?>)">Delete</button>
                    </td>
                </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
</div>
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
<script>

$(document).ready(function(){


    $('#insert').on('click', function() {
        
        var nama = $('#nama').val();
        var isactive = $('input[name="check"]:checked').val();

        $.ajax({
            type: 'POST',
            url: '<?= base_url('province/add') ?>',
            dataType: 'json',
            data: {
                nama: nama,
                isactive: isactive
            },
            success: function(response) {
                if (response.status == 'error') {
                    alert(response.message);
                } else {
                    alert(response.message);
                    window.location.reload();
                }
            },
            error: function(response) {
                alert('Data gagal ditambahkan');
            }
        });
    });
    $('#update').on('click', function(e) {
        e.preventDefault();
        
        var provid = $('#provid').val();
        var nama = $('#namaupdate').val();
        var isactive = $('input[name="isactiveupdate"]:checked').val();
    
        $.ajax({
            type: 'get',
            url: '<?= base_url('province/update') ?>',
            dataType: 'json',
            data: {
                provid: provid,
                nama: nama,
                isactive: isactive
            },
            success: function(response) {
                if (response.status == 'error') {
                    alert(response.message);
                } else {
                    alert(response.message);
                    window.location.reload();
                }
            },
            error: function(response) {
                alert('Data gagal diupdate');
            }
        });
    });
})
   


    function formUpdate(provid) {
        $.ajax({
            url: '<?= base_url('province/edit/') ?>'+provid,
            type: 'GET',
            success: function(response) {
                if (response.status) {
                    alert(response.message);
                } else {
                    $('#namaupdate').val(response.data.provname);
                    $('#isactiveupdate').val(response.data.isactive);
                    $('input[name="genderupdate"]').prop('checked', false);
                $('input[name="genderupdate"][value="' + result.gender + '"]').prop('checked', true);
                    $('#editModal').modal('show');
                }
            },
            error: function(response) {
                alert('Data gagal diupdate');
            }
        });
    }

    function hapus(provid) {
        $.ajax({
            type: 'get',
            url: '<?= base_url('province/delete') ?>',
            dataType: 'json',
            data: {
                provid: provid,
            },
            success: function(response) {
                if (response.status == 'error') {
                    alert(response.message);
                } else {
                    alert(response.message);
                    window.location.reload();
                }
            },
            error: function(response) {
                alert('Data gagal dihapus');
            }
        });
    }
</script>
<?= $this->endSection(); ?>