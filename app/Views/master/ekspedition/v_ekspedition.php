<?= $this->extend('v_sidebar') ?>
<?= $this->section('content') ?>

<div class="main-content">
    <div class="modal fade" id="ekspeditionModal" tabindex="-1" aria-hidden="true" aria-labelledby="ekspeditionModal">
        <div class="modal-dialog modal-dialog-centered modal-md">
            <div class="modal-content">
                <form id="addForm" action="<?= base_url('ekspedition/add') ?>">
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
                </form>
            </div>
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
    <table class="table table-success table-stripped-columns table-hover">
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
<?= $this->endSection(); ?>
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<script>
    $(document).ready(function () {
        loadTable();

        $('#addForm').on('submit', function (e) {
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
                success: function (response) {
                    if (response.status === 'success') {
                        Swal.fire({
                            icon: 'success',
                            title: response.message,
                            showConfirmButton: false,
                            timer: 1500,
                        }).then(function () {
                            $('#ekspeditionModal').modal('hide');  
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
                error: function (xhr, status, error) {
                    Swal.fire({
                        icon: 'error',
                        title: 'System error occurred',
                        text: 'Please try again later.',
                        showConfirmButton: true,
                    });
                },
            });
        });
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
            success: function (response) {
                var tableBody = $('#tableBody');
                tableBody.empty();
                response.forEach(function (ekspedition, index) {  
                    var newRow = `
                        <tr id="row-${ekspedition.expid}">  <!-- Corrected to use ekspedition -->
                            <td>${ekspedition.expid}</td>  <!-- Corrected to use ekspedition -->
                            <td>${ekspedition.expname}</td>  <!-- Corrected to use ekspedition -->
                            <td>${ekspedition.createddate}</td>
                            <td>${ekspedition.updateddate}</td>
                            <td>${ekspedition.isactive}</td>
                            <td>
                                <button class="btn btn-danger delete-btn" data-id="${ekspedition.expid}">
                                    <i class="bx bx-trash"></i>
                                </button>
                            </td>
                        </tr>
                    `;
                    tableBody.append(newRow);
                });
            },
            error: function (xhr, status, error) {
                console.error('AJAX error:', status, error);
            }
        });
    }

</script>