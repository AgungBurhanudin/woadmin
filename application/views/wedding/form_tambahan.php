
<div style="float: right">
    <button type="button" data-toggle="modal" data-target="#tambahanEditModal" class="btn btn-mini btn-dark"><i class="fa fa-pencil"></i> Edit Daftar Paket Tambahan</button>
</div>
<h2>Paket Tambahan</h2>
<hr>

<div class="col-md-12" style="padding: 0">
    <!--<div class="wrapper">-->
    <ul class="nav nav-tabs" role="tablist" id="tabTambahan">
        <?php
        foreach ($tambahan as $val) {
            ?>
            <li class="nav-item" onclick="getFieldTambahan('<?= $id_wedding ?>', '<?= $val->id_field ?>')">
                <a class="nav-link" data-toggle="tab" href="#tambahan_<?= $val->id_field ?>" role="tab" aria-controls="tambahan_<?= $val->id ?>" aria-selected="true"><?= $val->nama_tambahan ?></a>
            </li>
            <?php
        }
        ?>
    </ul>
    <!--</div>-->
    <div class="tab-content">
        <?php
        foreach ($tambahan as $val) {
            ?>
            <div class="tab-pane" id="tambahan_<?= $val->id_field ?>" role="tabpanel">

            </div>
            <?php
        }
        ?>
    </div>
</div>

<div class="modal fade" id="tambahanEditModal" tabindex="-1" role="dialog" aria-labelledby="tambahanEditModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">Paket Tambahan</h4>
                <button class="close" type="button" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">×</span>
                </button>
            </div>
            <div class="modal-body">
                <form class="form-horizontal" action="#" name="formPaketTambahan" id="formPaketTambahan" method="post">
                    <input type="hidden" name="id_wedding" id="id_wedding" value="<?= $id_wedding ?>">

                    <div>
                        <fieldset>
                            <?php
                            $parent = '0';
                            foreach ($paket_tambahan as $val) {
                                $value = $val->id;
                                $nama = $val->nama_tambahan_paket;
                                $checked = ($val->id == $val->id_tambahan_tipe) ? "checked='checked'" : "";
                                $id = strtolower(str_replace(array(" ", "/"), array("_", "_"), $nama)) . "_" . $value;
                                ?>
                                <div class="form-check form-check-inline mr-1">
                                    <input class="form-check-input" <?= $checked ?> id="<?= $id ?>" name="tambahan[]" type="checkbox" value="<?= $value ?>">
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
                            <button class="btn btn-primary" type="button" onclick="simpanPaketTambahan()">Simpan</button>
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
    function getFieldTambahan(id_wedding, id) {
        $.ajax({
            url: "<?= base_url() ?>Wedding/tambahan/field?id=" + id + "&id_wedding=" + id_wedding,
            success: function (data) {
                $("#tambahan_" + id).html(data);
            }
        });
    }

    function simpanPaketTambahan() {
        var formData = $("#formPaketTambahan").serialize();
        $.ajax({
            type: 'POST',
            url: '<?= base_url() ?>Wedding/editTambahan',
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