<?= $this->extend('v_sidebar') ?>
<?= $this->section('content') ?>
<div class="main-content">
    <section class="section">
        <div class="section-body">
            <div class="card">
                <div class="dflex card-header">
                    <button class="btn btn-primary dflex align-center add" name="add" id="add">
                        <i class="bx bx-plus-circle margin-r-2"></i>
                        <span class="fw-normal fs-7">Add New</span>
                    </button>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-bordered table-md table-responsive" id="table-city">
                            <thead>
                                <tr>
                                    <th style="width: 5%;" class="text-center">#</th>
                                    <th>City Name</th>
                                    <th style="width: 10%;">Is Active</th>
                                    <th style="width: 10%;" class="text-center">Action</th>
                                </tr>
                            </thead>
                            <tbody>

                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <div class="modal fade" id="cityModal" tabindex="-1" aria-labelledby="cityModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="cityModalLabel">Add New City</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form id="cityForm">
                        <div class="form-group">
                            <label>City Name</label>
                            <input type="text" name="cityname" id="cityname" placeholder="@ex: Jakarta" class="form-input fs-7" required>
                        </div>
                        <div class="from-check">
                            <input type="hidden" name="isactive" value=" ?>">
                            <input class="form-check-input" type="checkbox" id="isactive">
                            <label class="form-check-label fs-7" for="isactive">
                                Is Active
                            </label>
                        </div>
                        <div class="modal-footer">
                            <button class="btn btn-primary dflex align-center addData" id="addData" name="addData">
                                <i class="bx bx-check margin-r-2"></i>
                                <span class="fw-normal fs-7">Save</span>
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script>
        function loadTable() {
            $.ajax({
                url: '<?= base_url('city/getAll') ?>',
                type: 'GET',
                dataType: 'json',
                success: function(response) {
                    let tbody = $('#table-city tbody');
                    tbody.empty();

                    response.data.forEach(function(city, no) {
                        let isChecked = city.isactive == 1 ? 'checked' : '';
                        let row = `
                                    <tr>
                                        <td class="text-center">${no + 1}</td>
                                        <td>
                                            <input type="text" value='${city.cityname}' class='updatecity' data-id='${city.cityid}' name='updatecity' id='updatecity'>
                                        </td>
                                        <td class="text-center">
                                            <input type="checkbox" class="form-check-input updateisactive" ${isChecked} data-id="${city.cityid}" name="updateisactive" id="updateisactive">
                                        </td>
                                        <td class="text-center">
                                            <button class="btn btn-sm btn-danger delete" name="delete" id="delete" data-id="${city.cityid}">Delete</button>
                                        </td>
                                    </tr>
                                    `;
                        tbody.append(row);
                    });
                },
                error: function(xhr, status, error) {
                    console.error(error);
                }
            });
        }
        $(document).ready(function() {
            $('#add').on('click', function() {
                $('#cityModal').modal('show');
            });


            loadTable();

            $('#table-city').on('change', '.updateisactive', function() {
                let cityId = $(this).data('id');
                let isActive = $(this).is(':checked') ? 1 : 0;
                let cityname = $(this).closest('tr').find('.updatecity').val();

                $.ajax({
                    url: '<?= base_url('city/update') ?>/' + cityId,
                    type: 'POST',
                    data: {
                        cityid: cityId,
                        isactive: isActive,
                        cityname: cityname
                    },
                    success: function(response) {
                        if (response.sukses == 1) {
                            Swal.fire({
                                title: 'Notification',
                                text: response.pesan,
                                icon: 'success',
                                confirmButtonText: 'OK'
                            });
                        } else {
                            Swal.fire({
                                title: 'Notification',
                                text: response.pesan,
                                icon: 'error',
                                confirmButtonText: 'OK'
                            });
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
            });

            $('#table-city').on('blur', '.updatecity', function() {
                let cityId = $(this).data('id');
                let cityname = $(this).val();
                let isActive = $(this).closest('tr').find('.updateisactive').is(':checked') ? 1 : 0;

                $.ajax({
                    url: '<?= base_url('city/update') ?>/' + cityId,
                    type: 'POST',
                    data: {
                        cityid: cityId,
                        isactive: isActive,
                        cityname: cityname
                    },
                    success: function(response) {
                        if (response.sukses == 1) {
                            Swal.fire({
                                title: 'Notification',
                                text: response.pesan,
                                icon: 'success',
                                confirmButtonText: 'OK'
                            });
                        } else {
                            Swal.fire({
                                title: 'Notification',
                                text: response.pesan,
                                icon: 'error',
                                confirmButtonText: 'OK'
                            });
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
            });

            $('#table-city').on('click', '.delete', function(e) {
                e.preventDefault();
                let cityId = $(this).data('id');

                Swal.fire({
                    title: 'Delete?',
                    text: "Data tidak bisa dikembalikan setelah dihapus!",
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33',
                    confirmButtonText: 'Yes, delete it!'
                }).then((result) => {
                    if (result.isConfirmed) {
                        $.ajax({
                            url: '<?= base_url('city/delete') ?>/' + cityId,
                            type: 'POST',
                            data: {
                                id: cityId
                            },
                            success: function(response) {
                                if (response.sukses == 1) {
                                    Swal.fire(
                                        'Deleted!',
                                        response.pesan,
                                        'success'
                                    );
                                    loadTable();
                                } else {
                                    Swal.fire(
                                        'Error!',
                                        response.pesan,
                                        'error'
                                    );
                                }
                            },
                            error: function(xhr, status, error) {
                                console.error(error);
                                Swal.fire(
                                    'Error!',
                                    'An error occurred while deleting the data.',
                                    'error'
                                );
                            }
                        });
                    }
                });
            });

            $('#addData').on('click', function(e) {
                e.preventDefault();
                let cityname = $('#cityname').val();
                let isactive = $('#isactive').is(':checked') ? 1 : 0;

                $.ajax({
                    url: '<?= base_url('city/add') ?>',
                    type: 'post',
                    data: {
                        cityname: cityname,
                        isactive: isactive
                    },
                    dataType: 'json',
                    success: function(res) {
                        if (res.sukses == 1) {
                            $('#cityModal').modal('hide');
                            Swal.fire({
                                title: 'Notification',
                                text: res.pesan,
                                icon: 'success',
                                confirmButtonText: 'OK'
                            });
                            $('#cityForm')[0].reset();
                        } else {
                            Swal.fire({
                                title: 'Notification',
                                text: res.pesan,
                                icon: 'error',
                                confirmButtonText: 'OK'
                            });
                        }
                        loadTable();
                    }
                })
            });
        });
    </script>
    <?= $this->endSection(); ?>
</div>