<h2>Lampiran</h2>
<hr>

<a href="#" data-toggle="modal" data-target="#uploadLayoutModal">
    <button type="button" class="btn btn-mini btn-primary"><i class="fa fa-upload"></i> Add Lampiran</button>
</a>

<div class="clearfix"></div><br>
<div id="dataFormLayout" class="col-sm-12" style="padding: 0">
    <?php
    if (empty($layout)) {
        echo "<h3>Belum Ada Layout</h3>";
    } else {
        foreach ($layout as $l) {
            ?>
            <div class="col-md-4" style="float: left">
                <div class="card">
                    <div class="card-header"><?= $l->nama_layout ?>
                        <a href="#" onclick="deleteLayout('<?= $l->id ?>')">
                            <span class="badge badge-pill badge-danger float-right"><i class="fa fa-close"></i> Delete</span>
                        </a>
                    </div>
                    <div class="card-body" style="padding: 0">
                        <img src="<?= base_url() ?>files/images/<?= $l->layout ?>" width="100%">
                    </div>
                </div>
            </div>

            <?php
        }
    }
    ?>
</div>
<div class="modal fade" id="uploadLayoutModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">Upload Layout</h4>
                <button class="close" type="button" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">×</span>
                </button>
            </div>
            <div class="modal-body">
                <form class="form-horizontal" id="formUploadLayout" action="<?= base_url() ?>Wedding/layout" enctype="multipart/form-data" method="post">
                    <input type="hidden" name="id_wedding" value="<?= $id_wedding ?>">
                    <div class="form-group row">
                        <label class="col-md-3 col-form-label" for="hf-email">Nama Layout</label>
                        <div class="col-md-9">
                            <input name="nama" id="nama" type="text" class="form-control" required="required"/>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-md-3 col-form-label" for="hf-email">File Layout</label>
                        <div class="col-md-9">
                            <input name="files" id="files" accept=".jpg, .png, .gif, .jpeg" type="file" class="form-control"/>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-md-3 col-form-label" for="hf-password"></label>
                        <div class="col-md-9">
                            <button class="btn btn-secondary" type="button" data-dismiss="modal">Tutup</button>
                            <button class="btn btn-primary" onclick="uploadLayout()" type="submit">Simpan</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
        <!-- /.modal-content-->
    </div>
    <!-- /.modal-dialog-->
</div>

<script>
    function uploadLayout() {

        $('#formUploadLayout').validate({
            rules: {
                files: "required"
            },
            messages: {
                files: "File Excel belum di pilih"
            },
            submitHandler: function (form) {
                var formData = new FormData($("#formUploadLayout")[0]);
                $.ajax({
                    type: 'POST',
                    url: '<?= base_url() ?>Wedding/layout',
                    processData: false,
                    contentType: false,
                    data: formData,
                    dataType: "JSON",
                    success: function (data) {
                        if (data.code == "200") {
                            $("#uploadLayoutModal").modal('hide');
                            swal("success", "Berhasil mengupload layout!");
                            $("#dataFormLayout").load(location.href + " #dataFormLayout");
                        } else {
                            $("#uploadLayoutModal").modal('hide');
                            swal("warning", "Gagal mengupload layout!");
                        }
                    }
                });
            }
        });
    }

    function deleteLayout(id) {
        if (confirm('Apakah anda yakin akan menghapus Layout ini?')) {
            $.ajax({
                url: '<?= base_url() ?>Wedding/deleteLayout?id=' + id,
                dataType: "JSON",
                success: function (data) {
                    if (data.code == "200") {
                        swal("success", "Berhasil menghapus layout!");
                        $("#dataFormLayout").load(location.href + " #dataFormLayout");
                    } else {
                        swal("warning", "Gagal menghapus undangan!");
                    }
                }
            });
        }
    }
</script>
