<?= $this->extend('v_sidebar') ?>
<?= $this->section('content') ?>
<div class="card ms-3 me-3 my-3">
    <!-- <div class="card"> -->
    <div class="card-header">
        <button class="btn btn-sm btn-primary" data-bs-toggle="modal" data-bs-target="#exampleModal">Add</button>

        <!-- Modal Insert -->
        <div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h1 class="modal-title fs-5" id="exampleModalLabel">Form Insert</h1>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <form id="formInsert">
                            <div class="mb-3">
                                <label for="nama" class="form-label">Category Name</label>
                                <input type="text" class="form-control" name="nama" id="nama" placeholder="Enter Category Name">
                            </div>
                            <div class="mb-3" id="isactive">
                                <label for="" class="form-label">Active</label>
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" value="1" name="isactiveinsert">
                                    <label class="form-check-label" for="flexCheckDefault">
                                        Active
                                    </label>
                                </div>
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" value="0" name="isactiveinsert">
                                    <label class="form-check-label" for="flexCheckDefault">
                                        Non Active
                                    </label>
                                </div>
                            </div>
                        </form>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                        <button type="button" id="insert" class="btn btn-primary">Save changes</button>
                    </div>
                </div>
            </div>
        </div>

        <!-- Modal Update -->
        <div class="modal fade" id="editModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h1 class="modal-title fs-5" id="exampleModalLabel">Form Edit</h1>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <input type="hidden" name="catid" value="1" id="catid">
                        <div class="mb-3">
                            <label for="namaupdate" class="form-label">Category Name</label>
                            <input type="email" class="form-control" id="namaupdate" placeholder="Enter Category Name">
                        </div>
                        <div class="mb-3">
                            <label for="" class="form-label">Active</label>
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" value="1" name="kuy" id="flexCheckDefault">
                                <label class="form-check-label" for="flexCheckDefault">
                                    Is Active
                                </label>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                        <button type="button" class="btn btn-primary" id="update">Save changes</button>
                    </div>
                </div>
            </div>
        </div>

    </div>
    <div class="card-body">
        <table class="table" id="table">
            <thead>
                <tr>
                    <th scope="col">No</th>
                    <th scope="col">Category Name</th>
                    <th scope="col">Created Date</th>
                    <th scope="col">Updated Date</th>
                    <th scope="col">Is Active</th>
                    <th scope="col">Action</th>
                </tr>
            </thead>
            <tbody>
                <?php $no = 1;
                        foreach ($user as $data): ?>
                    <tr>
                        <th scope="row"><?= $no++ ?></th>
                        <td>
                            <input class="form-control catname" name="catname" type="text" id="catname(<?= $data['catid'] ?>)" value="<?= $data['catname'] ?>" data-id="<?= $data['catid'] ?>">
                        </td>
                        <td><?= $data['createddate'] ?></td>
                        <td><?= $data['updateddate'] ?></td>
                        <td><?= $data['isactive'] ?></td>
                        <td>
                            <button class="btn btn-sm btn-warning" onclick="formUpdate(<?= $data['catid'] ?>)" data-bs-toggle="modal" data-bs-target="#editModal">Edit</button>
                            <button class="btn btn-sm btn-danger" type="button" onclick="hapus(<?= $data['catid'] ?>)">Delete</button>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
</div>
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
    // function loadTable() {
    //     $.ajax({
    //         url: '<?= base_url('category/getData') ?>',
    //         type: 'GET',
    //         success: function(response) {
    //             let html = '';
    //             let no = 1;
    //             response.forEach(result => {
    //                 html += `<tr>
    //                     <td>${no++}</td>
    //                     <td><input class="form-control catname" name="catname" type="text" id="catname${result.catid}" value="${result.catname}" data-id="${result.catid}"></td>
    //                     <td>${result.createddate}</td>
    //                     <td>${result.updateddate}</td>
    //                     <td>${result.isactive}</td>
    //                     <td>
    //                         <button class="btn btn-sm btn-warning" data-bs-toggle="modal" data-bs-target="#editModal" onclick="formUpdate(${result.catid})">Edit</button>
    //                         <button class="btn btn-sm btn-danger" onclick="hapus(${result.catid})">Delete</button>
    //                     </td>
    //                 </tr>`;
    //             });
    //             $('#table tbody').html(html);
    //         },
    //         error: function(response) {
    //             alert('Data gagal ditampilkan');
    //         }
    //     });
    // }

    $(document).ready(function() {
        loadTable();
    });

    function updateCategory(catid) {
        let catname = document.getElementById('catname').value;
        $.ajax({
            type: 'POST',
            url: '<?= base_url('category/updateCategory/') ?>' + catid,
            dataType: 'json',
            data: {
                catname: catname
            },
            success: function(response) {
                if (response.status == 'error') {
                    alert(response.message);
                } else {
                    alert(response.message);
                }
            },
            error: function(response) {
                alert('Data gagal diupdate');
            }
        });
    }

    $('.catname').on('blur', function() {
        let catid = $(this).data('id');
        let catname = $(this).val();
        $.ajax({
            type: 'POST',
            url: '<?= base_url('category/updateCategory/') ?>' + catid,
            dataType: 'json',
            data: {
                catid: catid,
                catname: catname
            },
            success: function(response) {
                if (response.status == 'error') {
                    alert(response.message);
                } else {
                    alert(response.message);
                }
            },
            error: function(response) {
                alert('Data gagal diupdate');
            }
        });
    });

    $('#insert').on('click', function(e) {
        e.preventDefault();

        let nama = $('#nama').val();
        let isactive = $('input[name="isactiveinsert"]:checked').val();

        $.ajax({
            type: 'POST',
            url: '<?= base_url('category/add') ?>',
            dataType: 'json',
            data: {
                nama: nama,
                isactive: isactive
            },
            success: function(response) {
                if (response.status == 'error') {
                    Swal.fire({
                        title: "Gagal",
                        text: response.message,
                        icon: "error"
                    });
                } else {
                    Swal.fire({
                        title: "Berhasil!",
                        text: response.message,
                        icon: "success"
                    }).then(function() {
                        $('#exampleModal').modal('hide');
                        loadTable();
                    });
                }
            },
            error: function(response) {
                alert('Data gagal ditambahkan');
            }
        });
    });

    function formUpdate(catid) {
        $.ajax({
            url: '<?= base_url('category/edit/') ?>' + catid,
            type: 'GET',
            success: function(response) {
                if (response.status == 'error') {
                    alert(response.message);
                } else {
                    $('#namaupdate').val(response.data.catname);
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

    $('#update').on('click', function(e) {
        e.preventDefault();

        let catid = $('#catid').val();
        let nama = $('#namaupdate').val();
        let isactive = $('input[name="isactiveupdate"]:checked').val();

        $.ajax({
            type: 'POST',
            url: '<?= base_url('category/update') ?>',
            dataType: 'json',
            data: {
                catid: catid,
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

    function hapus(catid) {
        const swalWithBootstrapButtons = Swal.mixin({
            customClass: {
                confirmButton: "btn btn-success",
                cancelButton: "btn btn-danger"
            },
            buttonsStyling: false
        });
        swalWithBootstrapButtons.fire({
            title: "Are you sure?",
            text: "You won't be able to revert this!",
            icon: "warning",
            showCancelButton: true,
            confirmButtonText: "Yes, delete it!",
            cancelButtonText: "No, cancel!",
            reverseButtons: true
        }).then((result) => {
            if (result.isConfirmed) {
                $.ajax({
                    type: 'POST',
                    url: '<?= base_url('category/delete') ?>',
                    dataType: 'json',
                    data: {
                        id: catid,
                    },
                    success: function(response) {
                        if (response.status == 'error') {
                            swalWithBootstrapButtons.fire({
                                title: "Deleted!",
                                text: "Your file has been deleted.",
                                icon: "success"
                            });
                        } else {
                            swalWithBootstrapButtons.fire({
                                title: "Deleted!",
                                text: "Your file has been deleted.",
                                icon: "success"
                            }).then(function (result) {
                                loadTable();
                            })
                        }
                    },
                    error: function(response) {
                        alert('Data gagal dihapus');
                    }
                });

            } else if (
                /* Read more about handling dismissals below */
                result.dismiss === Swal.DismissReason.cancel
            ) {
                swalWithBootstrapButtons.fire({
                    title: "Cancelled",
                    text: "Your imaginary file is safe :)",
                    icon: "error"
                });
            }
        });

    }
    
</script>
<?= $this->endSection(); ?>