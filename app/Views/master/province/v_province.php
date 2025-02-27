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
        <table class="table table-hover table-striped" id="table-province">
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

            </tbody>
        </table>
    </div>
</div>
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
    $(document).ready(function() {
        loadprov();

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
                    if (response.success) {
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
                            icon: 'success',
                            title: response.message,
                        });
                    } else {
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
                            title: response.message
                        });
                    }
                    loadprov();
                    $('#exampleModal').modal('hide');
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
                        icon: "errror",
                        title: "data gagal ditambahkan"
                    });
                }
            });
        });

        $('#table-province').on('change', '.updateisactive', function() {
            let provid = $(this).data('id');
            let isactive = $(this).is(':checked') ? 1: 0;
            let nama = $(this).closest('tr').find('.nama').val();
            let check = $(this);

            $.ajax({
                url: '<?= base_url('province/updateAddress') ?>/' + provid,
                type: 'POST',
                data: {
                    provid: provid,
                    isactive: isactive,
                    nama: nama
                },
                success: function(response) {
                    if (response.message) {
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
                        icon: "success",
                        title: response.success,
                    });
                    check.prop('checked', isactive == 1);
                    } else {
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
                        icon: "success",
                        title: response.success,
                    });
                    }
                    loadprov();
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
  


    $('#table-province').on('blur', '.nama', function() {
        var provid = $(this).data('id');
        var nama = $(this).val();

        $.ajax({
            url: '<?= base_url('province/updateAddress') ?>/' + provid,
            type: 'POST',
            data: {
                provid: provid,
                nama: nama
            },
            dataType: 'json',
            success: function(response) {
                if (response.message) {
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
                        icon: "success",
                        title: response.success,
                    });
                } else {
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
                        title: response.success
                    });
                }
                var check = $(this).closest('tr').find('.updateisactive');
                check.prop('checked', response.data.isactive == 1);
                loadprov();
            }
        })
    })
})

function loadprov() {
            $.ajax({
                url: "<?= base_url('province/getdata') ?>",
                type: "GET",
                dataType: "json",
                success: function(response) {
                    if (response.success == 1) {
                        let tbody = $('#table-province tbody');
                        tbody.empty();
                        $.each(response.data, function(index, data) {
                            let row = `
                            <tr>
                                <td scope="row">${index + 1}</td>
                                <td>
                                    <input type="text" id="nama"${data.provid} name="nama" class="form-control nama" data-id="${data.provid}" value="${data.provname}">
                                </td>
                                <td>${data.createddate}</td>
                                <td>${data.updateddate}</td>
                                <td>
                                    <input type="checkbox" class="form-check-input updateisactive" data-id="${data.provid}" name="updateisactive" id="updateisactive" ${data.isactive == 1 ? 'checked' : ''}>
                                </td>
                                <td>
                                    <button class="btn btn-danger hapus" id="hapus" name="hapus" type="button" onclick="hapus(${data.provid})">Hapus</button>
                                </td>
                            </tr>
                            `;
                            tbody.append(row);
                        })
                    } else {
                        swal.fire('error', response.message, 'error')
                    }
                },
                error: function(xhr, textStatus, error) {
                    console.error(error);
                }
            });
        }


    function hapus(provid) {
        $('#provid').data(provid)
        $.ajax({
            type: 'POST',
            url: '<?= base_url('province/delete') ?>/' + provid,
            dataType: 'json',
            data: {
                provid: provid,
            },
            success: function(response) {
                if (response.success) {
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
                        icon: "success",
                        title: response.message,
                    });
                } else {
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
                        title: response.message,
                    });
                }
                loadprov();
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
                });
            }
        });
    }
</script>

<?= $this->endSection(); ?>