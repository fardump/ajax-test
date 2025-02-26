<form id="form-city" style="padding-inline: 0px;" method="post" class="modal fade">
    <input type="hidden" name="cityid" id="cityid" value="<?= encrypting($cityid) ?>">
    <div class="form-group">
        <label>City Name</label>
        <input type="text" name="cityname" id="cityname" placeholder="@ex: Jakarta" class="form-input fs-7" value="<?= $form_type == 'edit' ? $row['cityname'] : '' ?>" required>
    </div>
    <div class="from-check">
        <input type="hidden" name="isactive" value="<?= $form_type == 'edit' ? $row['isactive'] : '' ?>">
        <input class="form-check-input" type="checkbox" id="isactive" <?= $form_type == 'edit' && $row['isactive'] == 1 ? 'checked' : '' ?>>
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
<script>
    $(document).ready(function() {
        $("#form-city").on('submit', function(e) {
            e.preventDefault();
            let form_type = "<?= $form_type ?>";
            $('#isactive').is(':checked') ? $('input[name="isactive"]').val(1) : $('input[name="isactive"]').val(0);
            let link = "<?= getURL('city/add') ?>"
            if (form_type == 'edit') {
                link = "<?= getURL('city/update') ?>"
            }
            let formdata = $(this).serialize();
            $.ajax({
                url: link,
                type: 'post',
                data: formdata,
                dataType: 'json',
                success: function(res) {
                    let pesan = res.pesan;
                    let notif = 'success';
                    if (res.sukses != 1) {
                        notif = 'error';
                    }
                    Swal.fire({
                        title: 'Notification',
                        text: pesan,
                        icon: notif,
                        confirmButtonText: 'OK'
                    }).then((result) => {
                        if (result.isConfirmed) {
                            if (res.sukses == 1) {
                                window.location.href = "<?= getURL('city') ?>";
                            }
                        }
                    });
                }
            });
        });
    });
</script>