<?= $this->extend('v_sidebar') ?>
<?= $this->section('content') ?>
<div class="main-content content margin-t-4 m-3">
    <!-- Button trigger modal -->
    <button type="button" class="btn btn-primary mb-2" data-bs-toggle="modal" data-bs-target="#exampleModal">
        Add+
    </button>

    <!-- Modal -->
    <div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Add Type</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form id="formadd">
                        <input type="text" name="typeid" id="typeid" hidden>
                        <div id="typename-group" class="form-group">
                            <label for="typename">Type Name</label>
                            <input type="text" class="form-control" id="typename" name="typename"
                                placeholder="Type Name" required />
                        </div>
                        <br>
                        <input type="checkbox" id="isactive" name="isactive" value="1" checked>
                        <label for="isactive">Active</label>
                        <br>
                        <button type=" submit" class="btn btn-success">Submit</button>
                    </form>
                </div>
                <div class="modal-footer">
                </div>
            </div>
        </div>
    </div>
    <div class="card p-x shadow-sm w-100 m-2">
        <table id="tableType" class="table table-sm table-hover p-3">
            <thead>
                <tr>
                    <th>no</th>
                    <th>typename</th>
                    <th>created date</th>
                    <th>updated date</th>
                    <th>isactive</th>
                    <th>action</th>
                </tr>
            </thead>
            <tbody>
                <!-- Data  !-->
            </tbody>
        </table>
    </div>
</div>
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

<script>
    $(document).ready(function() {
        function loadTable() {
            $.ajax({
                url: '<?= base_url('type/loadTable') ?>',
                type: 'GET',
                dataType: 'json',
                success: function(response) {
                    if (response.status == 'success') {
                        let tableBody = $('#tableType tbody');
                        tableBody.empty();
                        $.each(response.data, function(index, data) {
                            let row = `
                                <tr>
                                    <th scope="row">${index + 1}</th>
                                    <td>
                                        <input type="text" class="form-control" value="${data.typename}" onblur="updateTypeName(${data.typeid}, this.value, ${data.isactive == 1 ? 'checked' : ''})">
                                    </td>
                                    <td>${data.createddate}</td>
                                    <td>${data.updateddate}</td>
                                    <td>
                                        <input type="checkbox" class="form-check input" ${data.isactive == 1 ? 'checked' : ''} onchange="updateIsActive(${data.typeid}, this.checked, '${data.typename}')">
                                    </td>
                                    <td>
                                        <form action="/ajax-test/type/delete/${data.typeid}" method="post" class="deleteForm d-inline">
                                            <button type="submit" class="btn btn-sm btn-danger">Delete</button>
                                        </form>
                                    </td>
                                </tr>
                                `;
                            tableBody.append(row);
                        });
                    } else {
                        alert('Failed to load data');
                    }
                },
                error: function() {
                    alert('Failed to load data');
                }
            });
        }

        loadTable();

        $("#formadd").on('submit', function(event) {
            var formData = {
                typename: $("#typename").val(),
                isactive: $("#isactive").is(':checked') ? 1 : 0,
            };

            $.ajax({
                type: "POST",
                url: '<?= base_url('type/save') ?>',
                data: formData,
                dataType: "json",
                encode: true,
                success: function(response) {
                    if (response.status == 'success') {
                        alert('Success! ' + response.message);
                        $('#exampleModal').modal('hide');
                        $('#formadd')[0].reset();
                        loadTable();
                    } else {
                        alert('Failed! ' + response.message);
                    }
                },
                error: function() {
                    alert('Failed! An error occurred while adding.');
                }
            });

            event.preventDefault();
        });

        $(document).on('submit', '.deleteForm', function(e) {
            e.preventDefault();
            let form = $(this);

            if (confirm('Are you sure?')) {
                $.ajax({
                    type: 'POST',
                    url: form.attr('action'),
                    data: form.serialize(),
                    dataType: 'json',
                    success: function(response) {
                        if (response.status == 'success') {
                            alert('Deleted! ' + response.message);
                            loadTable();
                        } else {
                            alert('Failed! ' + response.message);
                        }
                    },
                    error: function() {
                        alert('Failed! An error occurred while deleting.');
                    }
                });
            }
        });

        window.updateTypeName = function(typeid, typename, isactive) {
            $.ajax({
                url: '<?= base_url('type/update') ?>',
                type: 'POST',
                data: {
                    typeid: typeid,
                    typename: typename,
                    isactive: isactive ? 1 : 0
                },
                success: function(response) {
                    console.log(response);
                },
                error: function() {
                    alert('Failed to update type name');
                }
            });
        }

        window.updateIsActive = function(typeid, isactive, typename) {
            $.ajax({
                url: '<?= base_url('type/update') ?>',
                type: 'POST',
                data: {
                    typeid: typeid,
                    typename: typename,
                    isactive: isactive ? 1 : 0
                },
                success: function(response) {
                    console.log(response);
                },
                error: function() {
                    alert('Failed to update is active');
                }
            });
        }
    });
</script>
<?= $this->endSection(); ?>