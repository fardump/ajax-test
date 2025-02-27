<?= $this->extend('v_sidebar') ?>
<?= $this->section('content') ?>
<div class="card ms-3 me-3 my-3">

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
                            <div class="mb-3">
                               
                                    <input class="form-check-input" type="checkbox" value="1" id="isactiveinsert" name="isactiveinsert">
                                    <label class="form-check-label" for="flexCheckDefault">
                                        Active
                                    </label>
                                
                            </div>
                        </form>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                        <button type="button" id="insert" class="btn btn-primary">Save Changes</button>
                    </div>
                </div>
            </div>
        </div>

    </div>
    <div class="card-body">
        <div class="table-responsive">
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
                </tbody>
            </table>
        </div>
    </div>
</div>
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>

    function selectone(checkbox) {
        const checkboxes = document.querySelectorAll('input[name="isactiveinsert"]');
        checkboxes.forEach((cb) => {
            if (cb !== checkbox) {
                cb.checked = false;
            }
        });
    }

    function loadTable() {
        $.ajax({
            url: '<?= base_url('category/table') ?>',
            type: 'GET',
            success: function(response) {
                let html = '';
                let no = 1;
                response.forEach(result => {
                    html += `<tr>
                        <td>${no++}</td>
                        <td><input class="form-control catname" name="catname" type="text" id="catname${result.catid}" value="${result.catname}" data-id="${result.catid}"></td>
                        <td>${result.createddate}</td>
                        <td>${result.updateddate}</td>
                        <td>
                        <div class="form-check">
                                <input class="form-check-input checkcat" type="checkbox" name="checkcat" id="checkcat${result.catid}" value="1" data-id="${result.catid}" ${result.isactive == 1 ? 'checked' : '' }>
                            </div></td>
                        <td>
                            <button class="btn btn-sm btn-danger" id="hapus" onclick="hapus(${result.catid})">Delete</button>
                        </td>
                    </tr>`;
                });
                $('#table tbody').html(html);
            },
            error: function(response) {
                alert('Data gagal ditampilkan');
            }
        });
    }

    $(document).ready(function() {
        loadTable();
    });

    $(document).on('blur', '.catname', function() {
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
                    Swal.fire({
                        title: "Gagal",
                        text: response.message,
                        icon: "error"
                    });
                } else {
                    Swal.fire({
                        title: "Berhasil",
                        text: response.message,
                        icon: "success"
                    }).then(function() {
                        loadTable();
                    });
                }
            },
            error: function(response) {
                alert('Data gagal diupdate');
            }
        });
    });

    $(document).on('change', '.checkcat', function() {
        let catid = $(this).data('id');
        let isactive = $(this).is(':checked') ? 1 : 0;

        $.ajax({
            type: 'POST',
            url: '<?= base_url('category/updateCheck/') ?>' + catid,
            dataType: 'json',
            data: {
                catid: catid,
                isactive: isactive
            },
            success: function(response) {
                if (response.status == 'error') {
                    Swal.fire({
                        title: 'Gagal',
                        text: response.message,
                        icon: 'error'
                    });
                } else {
                    Swal.fire({
                        title: 'Berhasil',
                        text: response.message,
                        icon: 'success'
                    }).then(function() {
                        loadTable();
                    });
                }
            }
        });
    })

    $('#insert').on('click', function() {

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

    function hapus(catid) {
        const swalWithBootstrapButtons = Swal.mixin({
            customClass: {
                confirmButton: "btn btn-success",
                cancelButton: "btn btn-danger"
            },
            buttonsStyling: false
        });
        swalWithBootstrapButtons.fire({
            title: "Konfirmasi",
            text: "Apakah Anda Yakin Akan Hapus Data!",
            icon: "warning",
            showCancelButton: true,
            confirmButtonText: "Ya Benar!",
            cancelButtonText: "Tidak Batal!",
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
                                title: "Gagal",
                                text: response.message,
                                icon: "error"
                            });
                        } else {
                            swalWithBootstrapButtons.fire({
                                title: "Berhasil",
                                text: response.message,
                                icon: "success"
                            }).then(function(result) {
                                loadTable();
                            })
                        }
                    },
                    error: function(response) {
                        alert('Data gagal dihapus');
                    }
                });

            } else if (
                result.dismiss === Swal.DismissReason.cancel
            ) {
                swalWithBootstrapButtons.fire({
                    title: "Pembatalan",
                    text: "Data tidak jadi dihapus",
                    icon: "error"
                });
            }
        });

    }
</script>
<?= $this->endSection(); ?>