
<div style="float: right">
    <button type="button" data-toggle="modal" data-target="#acaraEditModal" class="btn btn-mini btn-dark" ><i class="fa fa-pencil"></i> Edit Daftar Paket Acara</button>
</div>
<h2>Paket Acara</h2>
<hr>

<div class="col-md-12" style="padding: 0">
    <!--<div class="wrapper">-->
    <ul class="nav nav-tabs" role="tablist" id="tabAcara">
        <?php
        foreach ($acara as $val) {
            ?>
            <li class="nav-item" onclick="getFieldAcara('<?= $id_wedding ?>', '<?= $val->id_field ?>')">
                <a class="nav-link" data-toggle="tab" href="#acara_<?= $val->id_field ?>" role="tab" aria-controls="acara_<?= $val->id ?>" aria-selected="true"><?= $val->nama_acara ?></a>
            </li>
            <?php
        }
        ?>
    </ul>
    <!--</div>-->
    <div class="tab-content">
        <?php
        foreach ($acara as $val) {
            ?>
            <div class="tab-pane" id="acara_<?= $val->id_field ?>" role="tabpanel">

            </div>
            <?php
        }
        ?>
    </div>
</div>

<div class="modal fade" id="acaraEditModal" tabindex="-1" role="dialog" aria-labelledby="acaraEditModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">Paket Acara</h4>
                <button class="close" type="button" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">×</span>
                </button>
            </div>
            <div class="modal-body">
                <form class="form-horizontal" action="#" name="formPaketAcara" id="formPaketAcara" method="post">
                    <input type="hidden" name="id_wedding" id="id_wedding" value="<?= $id_wedding ?>">

                    <div>
                        <fieldset>
                            <?php
                            $parent = '0';
                            foreach ($paket_acara as $val) {
                                $value = $val->id;
                                $nama = $val->nama_acara;
                                $checked = ($val->id == $val->id_acara_tipe) ? "checked='checked'" : "";
                                $id = strtolower(str_replace(array(" ", "/"), array("_", "_"), $nama)) . "_" . $value;
                                ?>
                                <div class="form-check form-check-inline mr-1">
                                    <input class="form-check-input" <?= $checked ?> id="<?= $id ?>" name="acara[]" type="checkbox" value="<?= $value ?>">
                                    <label class="form-check-label" for="<?= $id ?>"><?= $nama ?></label>
                                </div>
                                <br>
                                <?php
                            }
                            ?>
                        </fieldset>
                    </div>
                    <div class="form-group row">
                        <label class="col-md-3 col-form-label" for="hf-password"></label>
                        <div class="col-md-9">
                            <button class="btn btn-secondary" type="button" data-dismiss="modal">Tutup</button>
                            <button class="btn btn-primary" type="button" onclick="simpanPaketAcara()">Simpan</button>
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
    function getFieldAcara(id_wedding, id) {
        $.ajax({
            url: "<?= base_url() ?>Wedding/acara/field?id=" + id + "&id_wedding=" + id_wedding,
            success: function (data) {
                $("#acara_" + id).html(data);
            }
        });
    }

    function simpanPaketAcara() {
        var formData = $("#formPaketAcara").serialize();
        $.ajax({
            type: 'POST',
            url: '<?= base_url() ?>Wedding/editAcara',
            data: formData,
            dataType: "JSON",
            success: function (data) {
                if (data.code == "200") {
                    alert('Berhasil');
                    window.location.reload();
                } else {
                    swal("warning", "Gagal menambah undangan!");
                }
            }
        });
    }
</script>