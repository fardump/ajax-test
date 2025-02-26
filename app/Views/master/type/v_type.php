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
                <form id="formadd" action="type/save" method="POST">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel">Add Type</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <input type="text" name="typeid" id="typeid" hidden>
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
                        <td><input type="text" value="<?= $data['typename'] ?>" onblur="blurfunction()"></td> 
                        <td><?= $data['createddate'] ?></td>
                        <td><?= $data['updateddate'] ?></td>
                        <td><input type="checkbox" value="<?= $data['isactive'];
                        if ($data['isactive'] == 1) {
                            'isactive' == 'checked';
                        } ?>" onchange="changefunction()"></td>
                        <td>
                            <form id="formdelete" action="type/delete" method="POST"
                                data-confirm="Are you sure you wish to delete this resource?">
                                <input type="hidden" name="_method" value="DELETE"/>
                                <button class="btn btn-danger" id="formdelete" type="submit">Delete</button>
                            </form>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
</div>
<?= $this->endSection(); ?>
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

<script>
    $(document).ready(function () {

        $("#formadd").on('click', function (event) {
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

        function blurfunction() {
            let x = document.getElementById("typename");
            alert('test');
        }

        window.changefunction = function () {
            var checkbox = document.querySelector("input[type=checkbox]");
            checkbox.addEventListener('change', function () {
                if (checkbox.checked) {
                    alert('checked');
                } else {
                    alert('not checked');
                }
            });
        }

        $("#formdelete").on('click', function (event) {
            var formData = {
                typeid: $("#typeid").val(),
            };

            $.ajax({
                type: "POST",
                url: "type/delete/" + typeid,
                data: formData,
                dataType: "json",
                encode: true,
            }).done(function (data) {
                console.log(typeid);
            });

            event.preventDefault();
        });
    });
</script>