<?= $this->extend('v_sidebar') ?>
<?= $this->section('content') ?>
<link rel="stylesheet" type="text/css" href="https://npmcdn.com/flatpickr/dist/themes/material_green.css">
<style>
    /* #min,
    #max {
        width: 100%;
    } */

    /* input[type="date"] {
        appearance: none;
        -webkit-appearance: none;
        -moz-appearance: none;
        background-color: #fff;
        border: 1px solid #ced4da;
        border-radius: 4px;
        padding: 8px 12px;
        font-size: 16px;
        color: #495057;
        position: relative;
        width: 100%;
        max-width: 300px;
    }

    input[type="date"]::before {
        content: '\1F4C5';
        position: absolute;
        right: 10px;
        top: 50%;
        transform: translateY(-50%);
        pointer-events: none;
        font-size: 18px;
        color: #495057;
    }

    input[type="date"]::placeholder {
        color: #6c757d;
        opacity: 1;
    } */
</style>
<div class="card ms-3 me-3 my-3">
    <div class="card-header">
        <button class="btn btn-sm btn-primary" data-bs-toggle="modal" data-bs-target="#exampleModal">Add</button>
        <button class="btn btn-warning" onclick="window.location.href='<?= getURL('province/fpdf') ?>'"><i class="bi bi-file-pdf">fpdf</i></button>
        <div class="table-responsive filter">
            <form action="" id="filterdate" method="post">
                <div style="display: flex; gap: 10px; width: 500px;">
                    <input type="date" id="min" name="min" class="form-control" placeholder="date start" style="cursor: text;">
                    <input type="date" id="max" name="max" class="form-control" placeholder="date end" style="cursor: text;">
                    <input type="text" id="searching" name="searching" class="form-control" placeholder="searh here re.." style="width: 180px;">
                    <button type="reset" class="btn btn-warning btnreset" data-bs-toggle="tooltip" title="reset form"><box-icon name='reset'></box-icon></button>
                    <button type="button" class="btn btn-warning" onclick="filterdata()">filter</button>
                </div>
            </form>
        </div>

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
                                <input type="text" class="form-control" name="nama" id="nama" placeholder="Province Name" required>
                            </div>
                            <div class="mb-3">
                                <label for="" class="form-label">Active</label>
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" value="1" id="isactive" name="check">
                                    <label class="form-check-label" for="flexCheckDefault">
                                        Is Active
                                    </label>
                                </div>
                            </div>
                        </form>
                    </div>
                    <div class="modal-footer">
                        <button type="submit" id="insert" class="btn btn-primary">Save</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-hover table-striped" id="table-province">
                <thead>
                    <tr>
                        <th scope="col">No</th>
                        <th scope="col">Province Name</th>
                        <th scope="col">Dibuat</th>
                        <th scope="col">Updated</th>
                        <th scope="col">Action</th>
                    </tr>
                </thead>
                <tbody>

                </tbody>
            </table>
        </div>

        <nav>
            <ul class="pagination" id="pagination-list">

            </ul>
        </nav>
    </div>
</div>
<script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
    $(document).ready(function() {
        loadprov();

        $(document).on('click', '#insert', function() {

            var nama = $('#nama').val();
            var isactive = $('input[name="check"]:checked').val();
            var datetime = $('#datetime').val();

            $.ajax({
                type: 'POST',
                url: '<?= base_url('province/add') ?>',
                dataType: 'json',
                data: {
                    nama: nama,
                    isactive: isactive,
                    datetime: datetime
                },
                success: function(response) {
                    const Toast = Swal.mixin({
                        toast: true,
                        position: "top-end",
                        showConfirmButton: false,
                        timer: 3000,
                        timerProgressBar: true,
                        didOpen: (toast) => {
                            toast.onmouseenter = Swal.stopTimer;
                            toast.onmouseleave = Swal.resumeTimer;
                        }
                    });
                    Toast.fire({
                        icon: response.success ? 'success' : 'error',
                        title: response.message,
                    })
                    if (response.success) {
                        $('#exampleModal').modal('hide');
                        $('.modal-backdrop').remove();
                        $('#formInsert')[0].reset();
                        $(this).find('.modal-body').css('overflow-y', 'auto');
                        $('#filterdate').trigger('reset');
                        loadprov();
                    }
                },
                error: function(response) {
                    const Toast = Swal.mixin({
                        toast: true,
                        position: "top-end",
                        showConfirmButton: false,
                        timer: 3000,
                        timerProgressBar: true,
                        didOpen: (toast) => {
                            toast.onmouseenter = Swal.stopTimer;
                            toast.onmouseleave = Swal.resumeTimer;
                        }
                    });
                    Toast.fire({
                        icon: "error",
                        title: "data gagal ditambahkan"
                    });
                }
            });
        });

        $(document).on('change', '.updateisactive', function() {
            let provid = $(this).data('id');
            let isactive = $(this).is(':checked') ? 1 : 0;
            let nama = $(this).closest('tr').find('.nama').val();
            let check = $(this);

            $.ajax({
                url: '<?= base_url('province/updateAddress') ?>/' + provid,
                type: 'POST',
                data: {
                    provid: provid,
                    nama: nama,
                    isactive: isactive,
                },
                success: function(response) {
                    const Toast = Swal.mixin({
                        toast: true,
                        position: "top-end",
                        showConfirmButton: false,
                        timer: 3000,
                        timerProgressBar: true,
                        didOpen: (toast) => {
                            toast.onmouseenter = Swal.stopTimer;
                            toast.onmouseleave = Swal.resumeTimer;
                        }
                    });
                    Toast.fire({
                        icon: response.success ? "success" : "error",
                        title: response.success,
                    });
                    if (response.message) {
                        check.prop('checked', isactive == 1);
                        $('#filterdate').find("input").val("");
                        loadprov();
                    }
                },
                error: function(xhr, status, error) {
                    console.error(error);
                    Swal.fire({
                        title: 'Error!',
                        text: 'An error occurred while updating the data.',
                        icon: 'error',
                        confirmButtonText: 'OK'
                    });
                }
            });
        })


        $(document).on('blur', '.nama', function() {
            let provid = $(this).data('id');
            let nama = $(this).val();
            let isactive = $(this).closest('tr').find('.updateisactive').is(':checked') ? 1 : 0
            let check = $(this)

            $.ajax({
                url: '<?= base_url('province/updateAddress') ?>/' + provid,
                type: 'POST',
                data: {
                    provid: provid,
                    nama: nama,
                    isactive: isactive
                },
                dataType: 'json',
                success: function(response) {
                    const Toast = Swal.mixin({
                        toast: true,
                        position: "top-end",
                        showConfirmButton: false,
                        timer: 3000,
                        timerProgressBar: true,
                        didOpen: (toast) => {
                            toast.onmouseenter = Swal.stopTimer;
                            toast.onmouseleave = Swal.resumeTimer;
                        }
                    });
                    Toast.fire({
                        icon: response ? "success" : "error",
                        title: response.success,
                    });
                    // $('#filterdate').find("input").val("");
                    $('#filterdate').trigger('reset')
                    loadprov();
                }
            })
        })

        $('#pagination-list').on('click', '.page-link', function(e) {
            e.preventDefault();
            const page = $(this).data('page');
            filterdata(page);
        });

        $('.btnreset').on('click', function() {
            loadprov();
        });
    });


    function loadprov(startDate = null, endDate = null, searching = null, page = 1, limit = 10) {
        $.ajax({
            url: "<?= base_url('province/getdata') ?>",
            type: "GET",
            data: {
                page: page,
                limit: limit,
                startDate: startDate || null,
                endDate: endDate || null,
                searching: searching || null
            },
            dataType: "json",
            success: function(response) {
                if (response.success == 1) {
                    let tbody = $('#table-province tbody');
                    tbody.empty();

                    if (response.data.length === 0) {
                        tbody.append(`<tr><td colspan="6" class="text-center">Data tidak ditemukan</td></tr>`);
                    } else {
                        $.each(response.data, function(index, data) {
                            let row = `
                            <tr>
                                <td>${(page - 1) * limit + (index + 1)}</td>
                                <td>
                                    <input type="text" id="nama${data.provid}" name="nama" class="form-control nama" data-id="${data.provid}" value="${data.provname}">
                                </td>
                                <td>${data.createddate}</td>
                                <td>${data.updateddate}</td>
                                <td>
                                    <input type="checkbox" class="form-check-input updateisactive" data-id="${data.provid}" ${data.isactive == 1 ? 'checked' : ''}>
                                </td>
                                <td>
                                    <button class="btn btn-danger hapus" onclick="hapus(${data.provid})">Hapus</button>
                                </td>
                            </tr>
                        `;
                            tbody.append(row);
                        });
                    }
                    renderPagination(response.total, page, limit, startDate, endDate, searching);
                } else {
                    swal.fire('Error', response.message, 'error');
                }
            },
            error: function(xhr, textStatus, error) {
                console.error(error);
            }
        });
    }


    function renderPagination(total, currentPage, itemsPerPage, startDate, endDate, searching) {
        const totalPage = Math.ceil(total / itemsPerPage);
        const paginationList = $('#pagination-list');
        paginationList.empty();

        if (totalPage > 1) {
            if (currentPage > 1) {
                paginationList.append(`<li class="page-item"><a class="page-link" href="#" data-page="${currentPage - 1}">&laquo;</a></li>`);
            }
        }

        for (let i = 1; i <= totalPage; i++) {
            paginationList.append(`<li class="page-item ${i == currentPage ? 'active' : ''}">
            <a class="page-link" href="#" data-page="${i}">${i}</a>
        </li>`);
        }

        if (currentPage < totalPage) {
            paginationList.append(`<li class="page-item"><a class="page-link" href="#" data-page="${currentPage + 1}">&raquo;</a></li>`);
        }
    }

    function filterdata(page) {
        let startDate = $("#min").val();
        let endDate = $("#max").val();
        let searching = $("#searching").val().trim().toLowerCase();

        loadprov(startDate, endDate, searching, page);
    }


    function hapus(provid) {
        const swalWithBootstrapButtons = Swal.mixin({
            customClass: {
                confirmButton: "btn btn-success",
                cancelButton: "btn btn-danger"
            },
            buttonsStyling: true
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
                    url: '<?= base_url('province/delete') ?>/' + provid,
                    dataType: 'json',
                    data: {
                        provid: provid,
                    },
                    success: function(response) {
                        const Toast = Swal.mixin({
                            toast: true,
                            position: "top-end",
                            showConfirmButton: false,
                            timer: 3000,
                            timerProgressBar: true,
                            didOpen: (toast) => {
                                toast.onmouseenter = Swal.stopTimer;
                                toast.onmouseleave = Swal.resumeTimer;
                            }
                        });
                        Toast.fire({
                            icon: response.success ? "success" : "error",
                            title: response.message,
                        });
                        if (response.success) {
                            loadprov();
                        }
                    },
                    error: function(response) {
                        const Toast = Swal.mixin({
                            toast: true,
                            position: "top-end",
                            showConfirmButton: false,
                            timer: 3000,
                            timerProgressBar: true,
                            didOpen: (toast) => {
                                toast.onmouseenter = Swal.stopTimer;
                                toast.onmouseleave = Swal.resumeTimer;
                            }
                        });
                        Toast.fire({
                            icon: "error",
                            title: "data gagal dihapus",
                            text: "data gagal dihapus"
                        });
                    }
                });
            } else if (
                result.dismiss === Swal.DismissReason.cancel
            ) {
                swalWithBootstrapButtons.fire({
                    title: "Pembatalan",
                    text: "Gak jadi dihapus",
                    icon: "warning"
                });
            }
        });
    }

    document.addEventListener("DOMContentLoaded", function() {
        flatpickr("#min", {
            dateFormat: "Y-m-d",
            altInput: true,
            altFormat: "d F Y",
            // minDate: "today",
            disableMobile: "true",
            // theme: "confetti",
            allInputClass: "form-control"
        });

        flatpickr("#max", {
            dateFormat: "Y-m-d",
            altInput: true,
            altFormat: "d F Y",
            // minDate: "today",
            disableMobile: "true",
            // theme: "confetti",
            allInputClass: "form-control"
        });
    });


    setInterval(() => {
        document.body.style.overflow = "visible";
        document.body.style.paddingRight = "0px";
    }, 500);
</script>

<?= $this->endSection(); ?>