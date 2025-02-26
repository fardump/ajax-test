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
                                    <th>#</th>
                                    <th>City Name</th>
                                    <th>Country Name</th>
                                    <th>Action</th>
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
                            <input class="form-check-input" type="checkbox" id="isactive" >
                            <label class="form-check-label fs-7" for="isactive">
                                Is Active
                            </label>
                        </div>
                        <div class="modal-footer">
                            <button type="submit" class="btn btn-primary dflex align-center">
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
    <script>
        $(document).ready(function() {
            $('#add').on('click', function() {
                $('#cityModal').modal('show');
            });

            $('#cityForm').on('submit', function(e) {
                e.preventDefault();
            });
        });
    </script>
    <?= $this->endSection(); ?>
</div>