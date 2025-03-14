<?= $this->extend('v_sidebar') ?>
<?= $this->section('content') ?>
<div class="card ms-3 me-3 my-3">
    <div class="card-header d-flex">
        <button class="btn btn-sm btn-primary" data-bs-toggle="modal" data-bs-target="#exampleModal">Add</button>

        <form id="formFilter">
            <input type="date" class="ms-2" name="min" id="min">
            <input type="date" class="ms-2" name="max" id="max">
        </form>
        <input type="text" class="ms-2" name="search" id="search" placeholder="Searching...">
        <button class="btn btn-primary btn-sm ms-2" id="filter">Cari</button>
        <button class="btn btn-primary btn-sm ms-2" onclick="window.location.href= '<?= base_url('category/print') ?>'">Print</button>

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

        <!-- Simpanan Aing -->
        <!-- <div class="row gx-3 gy-2 align-items-center">
            <div class="col-sm-1">
                <button type="submit" data-bs-toggle="modal" data-bs-target="#exampleModal" class="btn btn-primary btn-sm d-flex shadow-sm"><i class="fa-solid fa-plus mt-1 me-3"></i> Add</button>
            </div>
            <div class="col-sm-3 ms-4">
                <input type="date" class="form-control" name="min" id="min">
            </div>
            <div class="col-sm-3">
                <div class="input-group">
                    <input type="date" class="form-control" name="max" id="max">
                </div>
            </div>
            <div class="col-sm-3">
                <input type="text" class="form-control" name="search" id="search" placeholder="Searching">
            </div>
            <div class="col-sm-1">
                <div class="form-check">
                    <button class="btn btn-outline-primary btn-sm d-flex border" id="filter"><i class="fa-solid fa-magnifying-glass mt-1 me-3"></i> Filter</button>
                </div>
            </div>
            </div> -->

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
            <div class="ms-2" id="pagination_link"></div>
        </div>
    </div>
</div>
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
    const swalWithBootstrapButtons = Swal.mixin({
        customClass: {
            confirmButton: "btn btn-success",
            cancelButton: "btn btn-danger"
        },
        buttonsStyling: false
    });

    $('#filter').on('click', function() {
        loadTable();
    })

    function loadTable(page = 1) {
        let min = $('#min').val() || null;
        let max = $('#max').val() || null;
        let search = $('#search').val() || '';

        $.ajax({
            url: '<?= base_url('category/table') ?>',
            type: 'GET',
            data: {
                page: page,
                min: min,
                max: max,
                search: search
            },
            success: function(response) {
                let html = '';
                let no = (page - 1) * 8 + 1;

                response.data.forEach(result => {
                    html += `<tr>
                    <td>${no++}</td>
                    <td><input class="form-control catname" name="catname" type="text" id="catname${result.catid}" value="${result.catname}" data-id="${result.catid}"></td>
                    <td>${result.createddate}</td>
                    <td>${result.updateddate}</td>
                    <td><div class="form-check">
                            <input class="form-check-input checkcat" type="checkbox" name="checkcat" id="checkcat${result.catid}" value="1" data-id="${result.catid}" ${result.isactive == 1 ? 'checked' : ''}>
                        </div></td>
                        <td>
                        <button class="btn btn-sm btn-danger" onclick="hapus(${result.catid})">Delete</button>
                    </td>
                </tr>`;
                });

                $('#table tbody').html(html);
                $('#pagination_link').html(response.pager);

                $('#pagination_link a').on('click', function(e) {
                    e.preventDefault();
                    const nextPage = $(this).data('ci-pagination-page');
                    if (nextPage) {
                        loadTable(nextPage);
                    }
                });
            },
            error: function() {
                alert('Gagal memuat data.');
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
                        $('#formFilter').find('input').val('');
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
                        $('#formInsert')[0].reset();
                    });
                }
            },
            error: function(response) {
                alert('Data gagal ditambahkan');
            }
        });
    });

    function hapus(catid) {
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