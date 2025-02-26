<?= $this->extend('v_sidebar') ?>
<?= $this->section('content') ?>

<h1>Form ekspedition</h1>

<div class="main-content content-margin-t-4">
    <div class="modal fade" id="ekspeditionModal" tabindex="-1" aria-hidden="true" aria-labelledby="ekspeditionModal">
        <div class="modal-dialog modal-dialog-centered modal-md">
            <div class="modal-content">
                <form action="<?= base_url('ekspedition/add') ?>">
                    <div class="modal-header">
                        <h5 class="modal-tittle" id="ekspeditionModal" label-required>Ekspedition Form</h5>
                    </div>

                    <div class="modal-body modal-lg">
                        <div id="inputEkspedition" class="form-group">
                            <div class="form-floating mb-3">
                                <input type="text" class="form-control" id="expname" name="expname" placeholder="Nama ekspedisi" required>
                                <label for="expname">Nama Ekspedisi</label>
                            </div>
                            <div class="form-floating mb-3">
                                <input type="text" class="form-control" id="usernm" name="usernm" placeholder="Nama Pemesan" required>
                                <label for="usernm">Dibuat Oleh</label>
                            </div>
                            <div class="form-floating mb-5 ml-2">
                                <input type="checkbox" id="isActive" name="isActive" value="1" chekced>
                                <span>IsActive</span>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismis="modal">Close</button>
                        <button type="submit" class="btn btn-success" onclick="addEkspedition()">Submit</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <div class="col-sm-4">
        <button type="button" style="margin: 10px;" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#ekspeditionModal" style="margin-left: 4px; margin-bottom: 4px;">
            <i class="bx bx-plus-circle margin-r-2"></i>Add
        </button>
    </div>
    <div class="card p-x shadow-sm w-100 mt-4 ml-3 mb-4" style="margin: 10px; padding: 4px;">
        <table class="table table-stripped-columns table-hover">
            <thead>
                <tr>
                    <th>No</th>
                    <th>Nama Ekspedisi</th>
                    <th>Dibuat Oleh</th>
                    <th>Created date</th>
                    <th>Updated date</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody id="tableBody">
                <!-- isi data table -->
            </tbody>
        </table>
    </div>
</div>

<?= $this->endSection(); ?>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
    loadTable();

    const openModalbtn = document.getElementById('openModalBtn');
    const modalEkspedition = new bootstrap.Modal(document.getElementById('ekspeditionModal'));
    openModalBtn.addEventListener('click', () => {
        modalEkspedition.show();
    });

    function loadTable() {
        $.ajax({
            url: '<?= base_url(uri_string() . "/processUpdate") ?>',
            method: 'GET',
            datatype: 'json',
            data: {
                orderBy: orderBy,
                orderDir: orderDir
            },
            success: function(response) {
                var tableBody = $('#tableBody');
                tableBody.empty();

                response.forEach(function(ekspedition, index) {
                    var newRow = ` 
                        <tr id="row-${ekspedition.expid}">
                        <td>${ekspedition.expname}</td>
                        <td>${ekspedition.createdby}</td>
                        <td>${ekspedition.updatedby}</td>
                        <td>${ekspedition.
                        
                        
                        +}</td>
                        <td>${ekspedition.isactive}</td>
                        <td>
                        <button class="btn btn-warning edit-btn" data-id="${ekspedition.expid}">
                            <i class="bx bx-trash"></i>
                        </button>
                        <button class="btn btn-danger delete-btn" data-id="${ekspedition.userid}">
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

    function deleteData() {

    }

    function addEkspediton() {
        $.ajax({
            url: url,
            method: 'post',
            data: formdata,
            success: function(response) {
                if (response.status === 'success') {
                    Swal.fire({
                        icon: 'success',
                        title: 'Data berhasil ditambahkan',
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
        })
    }
</script>