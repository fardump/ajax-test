<?= $this->extend('v_sidebar') ?>
<?= $this->section('content') ?>
<style>
    .dz-progress {
        display: none;
    }

    .dz-upload {
        display: block;
        height: 100%;
        background: #4caf50;
        width: 0;
        transition: width 0.3s ease;
    }

    #search {
        padding: 0.5rem;
        border: 1px solid #ccc;
        box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
        transition: border-color 0.3s ease, box-shadow 0.3s ease;
    }

    #search:focus {
        border-color: rgb(90, 216, 201);
        box-shadow: 0 2px 4px rgba(0, 0, 0, 0.2);
        outline: none;
    }

    .btn {
        padding: 0.5rem 1rem;
        border-radius: 0.25rem;
        transition: background-color 0.3s ease, box-shadow 0.3s ease;
    }

    .btn-primary {
        background-color: #007bff;
        border-color: #007bff;
        color: #fff;
    }

    .btn-primary:hover {
        background-color: #0056b3;
        border-color: #004085;
    }

    .btn-info {
        background-color: #17a2b8;
        border-color: #17a2b8;
        color: #fff;
    }

    .btn-info:hover {
        background-color: #117a8b;
        border-color: #0f6674;
    }

    .form-group {
        margin-bottom: 1rem;
    }

    .form-group label {
        display: block;
        margin-bottom: 0.5rem;
    }

    .form-group input {
        padding: 0.5rem;
        border: 1px solid #ccc;
        border-radius: 0.25rem;
        width: 100%;
        transition: border-color 0.3s ease, box-shadow 0.3s ease;
    }
</style>
<div class="main-content">
    <section class="section">
        <div class="section-body">
            <div class="card">
                <div class="dflex card-header">
                    <div class="d-flex justify-content-between w-100">
                        <div class="d-flex p-1">
                            <button class="btn rounded btn-primary dflex align-center add m-2" name="add" id="add">
                                <i class="bx bx-plus-circle margin-r-2"></i>
                                <span class="fw-normal fs-7">Add New</span>
                            </button>
                        </div>
                        <div class="d-flex justify-content-end">
                            <button class="btn rounded btn-info align-center filter m-3" name="filter" id="filter">
                                <i class="bx bx-filter-alt margin-r-2 text-white"></i>
                                <span class="fw-normal fs-7 text-white">Filter</span>
                            </button>
                            <input type="text" id="search" name="search" class="m-3 rounded border-none" placeholder="Search">
                        </div>
                    </div>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <div class="card mb-4" id="filter-tab" style="display: none;">
                            <div class="card-body">
                                <div class="row" id="tab-filter">
                                    <div class="col-md-4 mb-3">
                                        <div class="form-group">
                                            <label for="fromdate">From Date:</label>
                                            <input type="date" name="fromdate" id="fromdate" class="form-control" value="<?= !empty($filter->fromdate) ? $filter->fromdate : "" ?>">
                                        </div>
                                    </div>
                                    <div class="col-md-4 mb-3">
                                        <div class="form-group">
                                            <label for="todate">To Date:</label>
                                            <input type="date" name="todate" id="todate" class="form-control" value="<?= !empty($filter->todate) ? $filter->todate : "" ?>">
                                        </div>
                                    </div>
                                    <div class="col-md-4 d-flex align-items-center">
                                        <button class="btn btn-success me-2" onclick="return loadTable()">
                                            <i class="bx bx-filter-alt"></i> Filter
                                        </button>
                                        <button class="btn btn-warning" onclick="return filterData('reset')">
                                            <i class="bx bx-revision"></i> Reset
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <table class="table table-bordered table-md table-responsive" id="table-city">
                            <thead>
                                <tr>
                                    <th style="width: 5%;" class="text-center">#</th>
                                    <th>City Name</th>
                                    <th class="text-center">Image Upload</th>
                                    <th class="text-center" style="width: 15%;">Created Date</th>
                                    <th style="width: 10%;">Is Active</th>
                                    <th style="width: 20%;" class="text-center">Action</th>
                                </tr>
                            </thead>
                            <tbody>

                            </tbody>
                        </table>
                        <div class="d-flex justify-content-center">
                            <nav aria-label="Page navigation example">
                                <ul class="pagination justify-content-center" id="pagination">

                                </ul>
                            </nav>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <div class="modal fade" id="uploadModal" tabindex="-1" aria-labelledby="uploadModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="uploadModalLabel">Upload Image</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form id="uploadForm" class="dropzone">
                        <div class="dz-message">
                            Drag & Drop images here or click to select
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button class="btn btn-primary" id="uploadData">Upload</button>
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade" id="deleteImageModal" tabindex="-1" aria-labelledby="deleteImageModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="deleteImageModalLabel">Delete Image</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <p>Are you sure you want to delete this image?</p>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                    <button type="button" class="btn btn-danger" id="confirmDeleteImage">Delete</button>
                </div>
            </div>
        </div>
    </div>
</div>

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
                        <input class="form-check-input" type="checkbox" id="isactive">
                        <label class="form-check-label fs-7" for="isactive">
                            Is Active
                        </label>
                    </div>
                    <div class="modal-footer">
                        <button class="btn btn-primary dflex align-center addData" id="addData" name="addData">
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
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script src="https://unpkg.com/dropzone@6.0.0-beta.1/dist/dropzone-min.js"></script>

<script>
    function loadTable(reset = '', page = 1) {
        $.ajax({
            url: '<?= base_url('city/getAll') ?>',
            type: 'GET',
            data: {
                page: page,
                fromdate: $('#fromdate').val(),
                todate: $('#todate').val(),
                search: $('#search').val()
            },
            dataType: 'json',
            success: function(response) {
                let tbody = $('#table-city tbody');
                tbody.empty();

                if (response.data.length === 0 && page > response.total_pages) {
                    loadTable(response.total_pages);
                    return;
                }

                let startNumber = (page - 1) * response.per_page;

                response.data.forEach(function(city, no) {
                    let isChecked = city.isactive == 1 ? 'checked' : '';
                    let imageUrl = "<?= base_url('writable/uploads/') ?>" + city.image;
                    let deleteImageButton = city.image ? `<button class="btn btn-sm btn-warning delete-image mt-1" name="delete-image" id="delete-image" data-id="${city.cityid}">Delete Image</button>` : '';

                    let row = `
                            <tr>
                                <td class="text-center">${startNumber + no + 1}</td>
                                <td>
                                    <input type="text" value='${city.cityname}' class='updatecity' data-id='${city.cityid}' name='updatecity' id='updatecity'>
                                </td>
                                <td class="text-center">
                                <div class="flex">
                                    ${city.image ? `<img src="${imageUrl}" class="img-fluid city-image" style="width: 40%; height: 40%;">` : ''}
                                    <div>
                                        ${deleteImageButton}
                                    </div>
                                </div>
                                <td class="text-center">
                                    ${city.createddate}
                                </td>
                                </td>
                                <td class="text-center">
                                    <input type="checkbox" class="form-check-input updateisactive" ${isChecked} data-id="${city.cityid}" name="updateisactive" id="updateisactive">
                                </td>
                                <td class="text-center">
                                    <button class="btn btn-sm btn-danger delete" name="delete" id="delete" data-id="${city.cityid}">Delete</button>
                                    <button class="btn btn-sm btn-secondary upload" name="upload" id="upload" data-id="${city.cityid}">Upload</button>
                                </td>
                            </tr>
                        `;
                    tbody.append(row);
                });

                let pagination = $('#pagination');
                pagination.empty();

                let prevDisabled = response.current_page <= 1 ? 'disabled' : '';
                let prev = `<li class="page-item ${prevDisabled}"><a class="page-link" href="#" data-page="${Math.max(1, response.current_page - 1)}">Prev</a></li>`;
                pagination.append(prev);

                for (let i = 1; i <= response.total_pages; i++) {
                    let activeClass = i === response.current_page ? 'active' : '';
                    let pageItem = `<li class="page-item ${activeClass}"><a class="page-link" href="#" data-page="${i}">${i}</a></li>`;
                    pagination.append(pageItem);
                }

                let nextDisabled = response.current_page >= response.total_pages ? 'disabled' : '';
                let nextPage = Math.min(response.total_pages, response.current_page + 1);
                let next = `<li class="page-item ${nextDisabled}"><a class="page-link" href="#" data-page="${nextPage}">Next</a></li>`;
                pagination.append(next);
            },
            error: function(xhr, status, error) {
                console.error(error);
            }
        });
    }

    function filterData(reset = '') {
        if (reset === 'reset') {
            $('#fromdate').val('');
            $('#todate').val('');
        }
        loadTable();
    }

    $(document).ready(function() {
        let cityid = null;

        $(document).on('keyup', '#search', function() {
            loadTable();
        });

        $(document).on('click', '.filter', function() {
            $('#filter-tab').slideToggle(120);
        });

        $(document).on('click', '.delete-image', function() {
            cityid = $(this).data('id');
            $('#deleteImageModal').modal('show');
        });

        $('#confirmDeleteImage').on('click', function() {
            let imageIdToDelete = cityid;
            console.log(imageIdToDelete)
            if (imageIdToDelete) {
                $.ajax({
                    url: '<?= base_url('city/deleteImage') ?>/' + imageIdToDelete,
                    type: 'POST',
                    data: {
                        id: imageIdToDelete
                    },
                    success: function(response) {
                        if (response.sukses == 1) {
                            Swal.fire(
                                'Deleted!',
                                response.pesan,
                                'success'
                            );
                            loadTable();
                        } else {
                            Swal.fire(
                                'Error!',
                                response.pesan,
                                'error'
                            );
                        }
                        $('#deleteImageModal').modal('hide');
                    },
                    error: function(xhr, status, error) {
                        console.error(error);
                        Swal.fire(
                            'Error!',
                            'An error occurred while deleting the image.',
                            'error'
                        );
                        $('#deleteImageModal').modal('hide');
                    }
                });
            }
        });

        $('#cityModal').modal({
            backdrop: 'static',
            keyboard: false,
            show: false
        });

        $('#uploadModal').modal({
            backdrop: 'static',
            keyboard: false,
            show: false
        });

        $(document).on('click', '#pagination .page-link', function(e) {
            e.preventDefault();
            if (!$(this).parent().hasClass('disabled')) {
                let page = $(this).data('page');
                loadTable(reset = '', page);
            }
        });

        $('#add').on('click', function() {
            $('#cityModal').modal('show');
        });

        $('#table-city').on('click', '.upload', function() {
            cityid = $(this).data('id');
            $('#uploadModal').modal('show');
        });

        let chunkSize = 2 * 1024 * 1024;

        let myDropzone = new Dropzone("#uploadForm", {
            url: "<?= base_url('city/uploadChunk') ?>",
            autoProcessQueue: false,
            maxFiles: 10,
            acceptedFiles: null,
            dictDefaultMessage: "Drop files here or click to upload",
            chunking: true,
            maxThumbnailFilesize: 35,
            forceChunking: true,
            chunkSize: chunkSize,
            retryChunks: true,
            retryChunksLimit: 5,
            timeout: 0,
            addRemoveLinks: true,
            parallelUploads: 1,
            init: function() {
                let dzInstance = this;
                let real_html = $('#uploadData').html();

                this.on("addedfile", function(file) {
                    let progressElement = Dropzone.createElement('<div class="dz-progress"><span class="dz-upload"></span></div>');
                    file.previewElement.appendChild(progressElement);
                    if(file.type.startsWith('image')) {
                        $('#uploadData').attr('disabled', true);
                        $("#uploadData").html('<i class="bx bx-loader bx-spin"></i>');
                    }else{
                        $('#uploadData').attr('disabled', false);
                        $("#uploadData").html(real_html);
                    }
                });

                this.on("thumbnail", function(file) {
                    $('#uploadData').attr('disabled', false);
                    $("#uploadData").html(real_html);
                });


                this.on("removedfile", function(file) {
                    if (dzInstance.getQueuedFiles().length === 0) {
                        $('#uploadData').attr('disabled', false);
                    }
                });

                $('.btn-close').on('click', function() {
                    dzInstance.removeAllFiles();
                });

                $('#uploadData').on('click', function(e) {
                    e.preventDefault();
                    $('#uploadData').attr('disabled', true);
                    $('.btn-close').attr('disabled', true);
                    if (dzInstance.getQueuedFiles().length > 0) {
                        dzInstance.getQueuedFiles().forEach(file => {
                            let reader = new FileReader();
                            reader.readAsArrayBuffer(file);
                            reader.onload = function(event) {
                                let blob = new Blob([event.target.result], {
                                    type: file.type
                                });
                                let formData = new FormData();
                                formData.append("file", blob, file.name);
                                formData.append("id", cityid);
                                let real_html = $('#uploadData').html();
                                $("#uploadData").html('<i class="bx bx-loader bx-spin"></i>');
                                $.ajax({
                                    url: "<?= base_url('city/uploadChunk') ?>",
                                    type: "POST",
                                    data: formData,
                                    contentType: false,
                                    processData: false,
                                    success: function(response) {
                                        setTimeout(() => {
                                            Swal.fire({
                                                title: 'Success!',
                                                text: 'Files have been uploaded successfully.',
                                                icon: 'success',
                                                confirmButtonText: 'OK'
                                            });
                                            $("#uploadData").html(real_html);
                                            $('#uploadModal').modal('hide');
                                            $('#uploadData').attr('disabled', false);
                                            $('.btn-close').attr('disabled', false);
                                            dzInstance.removeAllFiles();
                                            loadTable();
                                        }, 1300);
                                    },
                                    error: function() {
                                        Swal.fire({
                                            title: 'Error!',
                                            text: 'An error occurred while uploading the file.',
                                            icon: 'error',
                                            confirmButtonText: 'OK'
                                        });
                                        $("#uploadData").html(real_html);
                                        $('#uploadData').attr('disabled', false);
                                    }
                                });
                            };
                        });
                    } else {
                        Swal.fire({
                            title: 'Warning!',
                            text: 'Please select at least one image to upload.',
                            icon: 'warning',
                            confirmButtonText: 'OK'
                        });
                        $('.btn-close').attr('disabled', false);
                        $('#uploadData').attr('disabled', false);
                    }
                });

                // this.on("queuecomplete", function() {
                //     setTimeout(() => {
                //         Swal.fire({
                //             title: 'Success!',
                //             text: 'All files have been uploaded successfully.',
                //             icon: 'success',
                //             confirmButtonText: 'OK'
                //         });
                //         $('#uploadModal').modal('hide');
                //         $('#uploadData').attr('disabled', false);
                //         dzInstance.removeAllFiles();
                //         loadTable();
                //     }, 1000);
                // });

                // this.on("errormultiple", function(files, response) {
                //     Swal.fire({
                //         title: 'Error!',
                //         text: response.pesan,
                //         icon: 'error',
                //         confirmButtonText: 'OK'
                //     });
                // });
            }
        });

        loadTable();

        $('#table-city').on('change', '.updateisactive', function() {
            let cityId = $(this).data('id');
            let isActive = $(this).is(':checked') ? 1 : 0;
            let cityname = $(this).closest('tr').find('.updatecity').val();

            $.ajax({
                url: '<?= base_url('city/update') ?>/' + cityId,
                type: 'POST',
                data: {
                    cityid: cityId,
                    isactive: isActive,
                    cityname: cityname
                },
                success: function(response) {
                    if (response.sukses == 1) {
                        Swal.fire({
                            title: 'Notification',
                            text: response.pesan,
                            icon: 'success',
                            confirmButtonText: 'OK'
                        });
                    } else {
                        Swal.fire({
                            title: 'Notification',
                            text: response.pesan,
                            icon: 'error',
                            confirmButtonText: 'OK'
                        });
                    }
                },
                error: function(xhr, status, error) {
                    console.error(error);
                    Swal.fire({
                        title: 'Error!',
                        text: 'An error occurred while updating the data.',
                        icon: 'error',
                        confirmButtonText: 'OK'
                    });
                }
            });
        });

        $('#table-city').on('blur', '.updatecity', function() {
            let cityId = $(this).data('id');
            let cityname = $(this).val();
            let isActive = $(this).closest('tr').find('.updateisactive').is(':checked') ? 1 : 0;

            $.ajax({
                url: '<?= base_url('city/update') ?>/' + cityId,
                type: 'POST',
                data: {
                    cityid: cityId,
                    isactive: isActive,
                    cityname: cityname
                },
                success: function(response) {
                    if (response.sukses == 1) {
                        Swal.fire({
                            title: 'Notification',
                            text: response.pesan,
                            icon: 'success',
                            confirmButtonText: 'OK'
                        });
                    } else {
                        Swal.fire({
                            title: 'Notification',
                            text: response.pesan,
                            icon: 'error',
                            confirmButtonText: 'OK'
                        });
                    }
                },
                error: function(xhr, status, error) {
                    console.error(error);
                    Swal.fire({
                        title: 'Error!',
                        text: 'An error occurred while updating the data.',
                        icon: 'error',
                        confirmButtonText: 'OK'
                    });
                }
            });
        });

        $('#table-city').on('click', '.delete', function(e) {
            e.preventDefault();
            let cityId = $(this).data('id');

            Swal.fire({
                title: 'Delete?',
                text: "Data tidak bisa dikembalikan setelah dihapus!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Yes, delete it!'
            }).then((result) => {
                if (result.isConfirmed) {
                    $.ajax({
                        url: '<?= base_url('city/delete') ?>/' + cityId,
                        type: 'POST',
                        data: {
                            id: cityId
                        },
                        success: function(response) {
                            if (response.sukses == 1) {
                                Swal.fire(
                                    'Deleted!',
                                    response.pesan,
                                    'success'
                                );
                                loadTable();
                            } else {
                                Swal.fire(
                                    'Error!',
                                    response.pesan,
                                    'error'
                                );
                            }
                        },
                        error: function(xhr, status, error) {
                            console.error(error);
                            Swal.fire(
                                'Error!',
                                'An error occurred while deleting the data.',
                                'error'
                            );
                        }
                    });
                }
            });
        });

        $('#addData').on('click', function(e) {
            e.preventDefault();
            let cityname = $('#cityname').val();
            let isactive = $('#isactive').is(':checked') ? 1 : 0;

            $.ajax({
                url: '<?= base_url('city/add') ?>',
                type: 'post',
                data: {
                    cityname: cityname,
                    isactive: isactive
                },
                dataType: 'json',
                success: function(res) {
                    if (res.sukses == 1) {
                        $('#cityModal').modal('hide');
                        Swal.fire({
                            title: 'Notification',
                            text: res.pesan,
                            icon: 'success',
                            confirmButtonText: 'OK'
                        });
                        $('#cityForm')[0].reset();
                    } else {
                        Swal.fire({
                            title: 'Notification',
                            text: res.pesan,
                            icon: 'error',
                            confirmButtonText: 'OK'
                        });
                    }
                    loadTable();
                }
            })
        });
    });
</script>
<?= $this->endSection(); ?>
</div>