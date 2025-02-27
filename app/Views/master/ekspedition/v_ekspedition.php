<?= $this->extend('v_sidebar') ?>
<?= $this->section('content') ?>

<div class="main-content">
    <div class="modal fade" id="ekspeditionModal" tabindex="-1" aria-hidden="true" aria-labelledby="ekspeditionModal">
        <form id="inputForm">
            <div class="modal-dialog modal-dialog-centered modal-md">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-tittle" id="ekspeditionModal" label-required>Ekspedition Form</h5>
                    </div>
                    <div class="modal-body modal-lg">
                        <div id="inputEkspedition" class="form-group">
                            <div class="form-floating mb-3">
                                <input type="text" class="form-control" id="expname" name="expname"
                                    placeholder="Nama ekspedisi" required>
                                <label for="expname">Nama Ekspedisi</label>
                            </div>
                            <div class="form-floating mb-5 m-2">
                                <input type="checkbox" id="isActive" style="width: 1rem; height: 1rem;" name="isActive"
                                    value="1" chekced>
                                <span>IsActive</span>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                        <button type="submit" id="submitBtn" class="btn btn-success">Submit</button>

                    </div>
                </div>
        </form>
    </div>
</div>
</div>
<div class="card p-x shadow m-3">
    <div class="col-sm-4">
        <button type="button" style="margin: 10px;" class="btn btn-primary" data-bs-toggle="modal"
            data-bs-target="#ekspeditionModal" style="margin-left: 4px; margin-bottom: 4px;">
            <i class="bx bx-plus-circle margin-r-2"></i>Tambah
        </button>
    </div>
    <table class="table table-stripped-columns table-hover">
        <thead class="thead-dark">
            <tr>
                <th>No</th>
                <th>Nama Ekspedisi</th>
                <th>Created Date</th>
                <th>Updated Date</th>
                <th>Is Active</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody id="tableBody">

        </tbody>
    </table>
</div>
</table>
</div>

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<script>
    $(document).ready(function() {
        loadTable();

        $('#submitBtn').on('click', function(e) {
            e.preventDefault();
            var expname = $('#expname').val();
            let isActive = $('#isActive').is(":checked") ? 1 : 0;

            $.ajax({
                url: '<?= base_url('ekspedition/add') ?>',
                dataType: 'json',
                type: 'POST',
                data: {
                    expname: expname,
                    isActive: isActive,
                },
                success: function(response) {
                    if (response.status === 'success') {
                        Swal.fire({
                            icon: 'success',
                            title: response.message,
                            showConfirmButton: true,
                        }).then(function() {
                            $('#ekspeditionModal').modal('hide');
                            $('.modal-backdrop').remove();
                            loadTable();
                        });
                    } else {
                        Swal.fire({
                            icon: 'error',
                            title: response.message,
                            text: 'Terjadi Kesalahan Silahkan coba lagi',
                            showConfirmButton: true,
                        });
                    }
                },
                error: function(xhr, status, error) {
                    Swal.fire({
                        icon: 'error',
                        title: 'System error occurred',
                        text: 'Please try again later.',
                        showConfirmButton: true,
                    });
                },
            });
        });
        // end first document
    });

    function deleteExp(expid) {
        Swal.fire({
            icon: 'question',
            title: 'Yakin menghapus data ini?',
            showConfirmButton: true,
            showCancelButton: true,
        }).then((result) => {
            if (result.isConfirmed) {
                $.ajax({
                    url: '<?= base_url('ekspedition/delete') ?> ',
                    type: 'POST',
                    data: {
                        expid: expid
                    },
                    dataType: 'json',
                    success: function(response) {
                        if (response.status === 'success') {
                            Swal.fire({
                                title: 'Deleted',
                                icon: 'success',
                                text: 'Your file has been deleted',
                            }).then(() => {
                                loadTable();
                            });
                        } else {
                            Swal.fire({
                                icon: 'error',
                                title: 'Error',
                                text: response.message
                            });
                        }
                    },
                    error: function() {
                        Swal.fire({
                            icon: 'error',
                            title: 'Error',
                            text: 'Terjadi kesalahan, coba lagi nanti.'
                        });
                    }
                });
            }
        });
    }

    function updateActive(expid, isActive) {
        $.ajax({
            url: '<?= base_url('ekspedition/update') ?>',
            method: 'post',
            dataType: 'json',
            data: {
                expid: expid,
                isactive: isActive
            },
            success: function(response) {
                if (response.status === 'success') {
                    Swal.fire({
                        icon: 'success',
                        title: 'Your data has been updated',
                        showConfirmButton: true,
                    });
                } else {
                    Swal.fire({
                        icon: 'error',
                        title: response.message,
                        showConfirmButton: true,
                    });
                }
            },
            error: function(response) {
                Swal.fire({
                    icon: 'error',
                    title: 'System error occured',
                    showConfirmButton: true,
                });
            }
        })
    }

    function updateBlur(expid, newName) {
        $.ajax({
            url: '<?= base_url('ekspedition/update') ?>',
            method: 'POST',
            dataType: 'json',
            data: {
                expid: expid,
                expname: newName
            },
            success: function(response) {
                if (response.status === 'success') {
                    Swal.fire({
                        icon: 'success',
                        title: 'Data Updated',
                        text: 'Expedition name has been updated successfully!',
                    });
                } else {
                    Swal.fire({
                        icon: 'error',
                        title: 'Update Failed',
                        text: response.message,
                    });
                }
            },
            error: function() {
                Swal.fire({
                    icon: 'error',
                    title: 'System Error',
                    text: 'An error occurred while updating the data.',
                });
            }
        });
    }

    $(document).on('blur', '.edit-expname', function() {
        let expid = $(this).data('id');
        let newName = $(this).val();
        updateBlur(expid, newName);
    });

    function loadTable(orderBy = 'expid', orderDir = 'ASC') {
        var tableBody = $('#tableBody');
        $.ajax({
            url: '<?= base_url('ekspedition/getData') ?>',
            method: 'GET',
            data: {
                orderBy: orderBy,
                orderDir: orderDir,
            },
            dataType: 'json',
            success: function(response) {
                var tableBody = $('#tableBody');
                tableBody.empty();
                response.forEach(function(ekspedition, index) {
                    var checked = ekspedition.isactive == 1 ? 'checked' : '';
                    var newRow = `
                        <tr id="row-${ekspedition.expid}"> 
                            <td>${ekspedition.expid}</td>  
                            <td>
                                <input type="text" value="${ekspedition.expname}" class="form-control edit-expname" data-id="${ekspedition.expid} onblur'updateBlur()'">
                            </td>  
                            <td>${ekspedition.createddate}</td>
                            <td>${ekspedition.updateddate}</td>
                            <td>
                                <input type="checkbox" ${checked} onchange='updateActive(${ekspedition.expid}, ${ekspedition.isactive})' value='${ekspedition.isactive}' class='updateisactive' data-id='${ekspedition.isActive}' name='updateisactive' id='updateisactive'>
                              </td>
                            <td>
                            <button class="btn btn-danger delete-btn" onclick="deleteExp(${ekspedition.expid})" data-id="${ekspedition.expid}">
                                <i class="bx bx-trash"></i>
                            </button>
                        </td>                  
                    </tr>
                    `;
                    tableBody.append(newRow);
                });
            },
            error: function(xhr, status, error) {
                console.error('AJAX error:', status, error);
            }
        });
    }
</script>
<?= $this->endSection(); ?>