<?= $this->extend('v_sidebar') ?>
<?= $this->section('content') ?>
<div class="main-content content margin-t-4">
    <!-- Button trigger modal -->
    <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#exampleModal">
        Add+
    </button>

    <!-- Modal -->
    <div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <form action="type/save" method="POST">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel">Add Type</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <div id="typename-group" class="form-group">
                            <label for="typename">Type Name</label>
                            <input type="text" class="form-control" id="typename" name="typename"
                                placeholder="Type Name" required />
                        </div>
                        <br>
                        <input type="checkbox" id="isactive" name="isactive" value="1" checked>
                        <label for="isactive">Active</label><br>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                        <button type=" submit" class="btn btn-success">Submit</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <div class="card p-x shadow-sm w-100">

        <table class="table table-striped-columns table-hover">
            <thead>
                <tr>
                    <th>no</th>
                    <th>typename</th>
                    <th>created date</th>
                    <th>updated date</th>
                    <th>isactive</th>
                </tr>
            </thead>
            <tbody>
                <?php $no = 1;
                foreach ($type as $data): ?>
                    <tr>
                        <th scope="row"><?= $no++ ?></th>
                        <td><?= $data['typename'] ?></td>
                        <td><?= $data['createddate'] ?></td>
                        <td><?= $data['updateddate'] ?></td>
                        <td><?= $data['isactive'] ?></td>
                        <td>
                            <button class="btn btn-sm btn-warning" onclick="formUpdate(<?= $data['typeid'] ?>)"
                                data-bs-toggle="modal" data-bs-target="#editModal">Edit</button>
                            <button class="btn btn-sm btn-danger" type="button"
                                onclick="hapus(<?= $data['typeid'] ?>)">Delete</button>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
</div>
<?= $this->endSection(); ?>

<script>
    $(document).ready(function () {

        $("form").on('click', function (event) {
            var formData = {
                typename: $("#typename").val(),
                isactive: $("#isactive").val(),
            };

            $.ajax({
                type: "POST",
                url: "type/save",
                data: formData,
                dataType: "json",
                encode: true,
            }).done(function (data) {
                console.log(data);
            });

            event.preventDefault();
        });

        function hapus(typeid) {
            $.ajax({
                type: 'POST',
                url: 'type/delete',
                dataType: 'json',
                data: {
                    typeid: typeid,
                },
                success: function (response) {
                    if (response.status == 'error') {
                        alert(response.message);
                    } else {
                        alert(response.message);
                        window.location.reload();
                    }
                },
                error: function (response) {
                    alert('Data gagal dihapus');
                }
            });
        }

        function formUpdate(catid) {
            $.ajax({
                url: '<?= base_url('type/edit/') ?>' + typeid,
                type: 'POST',
                dataType: 'json',
                data: {
                    typeid: typeid,
                },
                success: function (response) {
                    if (response.status == 'error') {
                        alert(response.message);
                    } else {
                        $('#namaupdate').val(response.data.typename);
                        $('#editModal').modal('show');
                    }
                },
                error: function (response) {
                    alert('Data gagal diupdate');
                }
            });
        }
    });
</script>