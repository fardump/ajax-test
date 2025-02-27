<?= $this->extend('v_sidebar') ?>
<?= $this->section('content') ?>

<div class="main-content">
    <div class="modal fade" id="ekspeditionModal" tabindex="-1" aria-hidden="true" aria-labelledby="ekspeditionModal">
        <div class="modal-dialog modal-dialog-centered modal-md">
            <div class="modal-content">
                <form id="formtambah" action="<?= base_url('ekspedition/add') ?>">
                    <div class="modal-header">
                        <h5 class="modal-tittle" id="ekspeditionModal" label-required>Ekspedition Form</h5>
                    </div>

                    <div class="modal-body modal-lg">
                        <div id="inputEkspedition" class="form-group">
                            <div class="form-floating mb-3">
                                <input type="text" class="form-control" id="expname" name="expname" placeholder="Nama ekspedisi" required>
                                <label for="expname">Nama Ekspedisi</label>
                            </div>
                            <div class="form-floating mb-5 m-2">
                                <input type="checkbox" id="isActive" style="width: 1rem; height: 1rem;" name="isActive" value="1" chekced>
                                <span>IsActive</span>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                        <button type="submit" id="btnTambah" class="btn btn-success">Submit</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
<div class="card p-x shadow m-2">
    <div class="col-sm-4">
        <button type="button" style="margin: 10px;" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#ekspeditionModal" style="margin-left: 4px; margin-bottom: 4px;">
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
<?= $this->endSection(); ?>
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<script>
    $(document).ready(function() {
        var formdata = $(this).serialize();
        const openModalbtn = document.getElementById('openModalBtn');
        const modalEkspedition = new bootstrap.Modal(document.getElementById('ekspeditionModal'));
        openModalBtn.addEventListener('click', () => {
            modalEkspedition.show();
        });

        function loadTable(orderBy = 'userid', orderDir = 'ASC') {
            $.ajax({
                url: '<?= base_url("ekspediton/getData") ?>',
                method: 'GET',
                datatype: 'json',
                data: {
                    orderBy: orderBy,
                    orderDir: orderDir
                },
                success: function(response) {
                    let tableBody = $('#tableBody');
                    tableBody.empty();

                    response.forEach(function(ekspedition, index) {
                        let isChecked = ekspedition.isActive == 1 ? 'checked' : '';
                        let newRow = ` 
                            <tr id="row-${ekspedition.expid}">
                            <td>${ekspedition.expname}</td>
                            <td>${ekspedition.createdby}</td>
                            <td>${ekspedition.updatedby}</td>
                            <td>${ekspedition.updateddate}</td>
                            <td>${ekspedition.isactive}</td>
                            <td>
                            <button class="btn btn-warning edit-btn" data-id="${ekspedition.expid}">
                            <i class="bx bx-trash"></i>
                            </button>
                            <button class="btn btn-danger delete-btn" data-id="${ekspedition.expid}">
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

        loadTable();

        $('#btnTambah').on('click', function(e) {
            e.preventDefault();

            $.ajax({
                url: url,
                type: 'POST',
                data: formdata,
                datatype: 'json',
                success: function(response) {
                    if (response.status == 'successs') {
                        Swal.fire({
                            icon: 'success',
                            title: response.message,
                            showConfirmButton: false,
                            timer: 1500
                        });
                    } else {
                        Swal.fire({
                            icon: 'error',
                            title: 'Error',
                            text: response.message
                        });
                    }
                },
                error: function(xhr, status, error) {
                    Swal.fire({
                        icon: 'error',
                        title: 'Error',
                        text: 'An error occurred: ' + error
                    });
                }
            });
        });
    });
</script>