<?= $this->extend('v_sidebar') ?>
<?= $this->section('content') ?>
<div class="main-content content margin-t-4">
    <div class="card p-x shadow-sm w-100">
        <div class="card-header dflex align-center justify-end">
            <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#exampleModal"><i class="bx bx-plus-circle margin-r-2"></i>Add</button>
        </div>

        <table class="table table-striped-columns table-hover">
            <thead>
                <tr>
                    <th>no</th>
                    <th>name</th>
                    <th>dibuat</th>
                    <th>perbarui</th>
                    <th>isactive</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td></td>
                    <td><input type="text" id="updatename" name="updatename"></td>
                    <td></td>
                    <td></td>
                    <td></td>
                </tr>
            </tbody>
        </table>

        <!-- Modal -->
        <div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h1 class="modal-title fs-5" id="exampleModalLabel">Modal title</h1>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <form id="add-create" action="">
                        <div class="modal-body">
                            <label for="name">name</label>
                            <input type="text" id="name" name="name">
                        </div>
                    </form>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                        <button type="button" class="btn btn-primary">Save</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<?= $this->endSection() ?>
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
       $(document).ready(function() {
        // buatkan variabel blur global

       $('#updatename').change(function() {
            var blurdata = $('#updatename').val();
            alert("blur berhasil di jalankan");
            console.log(blurdata);
                })
        $('#add-create').submit(function() {
            $('#name').blur(function() {
                var data = $('#name').val();
                alert(data);
            })
        })
    });
</script>