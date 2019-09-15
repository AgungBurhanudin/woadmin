
<div style="float: right">
    <button type="button" data-toggle="modal" data-target="#upacaraEditModal" class="btn btn-mini btn-dark"><i class="fa fa-pencil"></i> Edit Daftar Paket Upacara</button>
</div>
<h2>Paket Upacara</h2>
<hr>

<div class="col-md-12" style="padding: 0">
    <?php
    foreach ($upacara_parent as $v) {
        ?>
        <div class="accordion" id="acordionParent_<?= $v->id ?>">
            <div class="card" style="margin: 0">
                <div class="card-header" id="headingOne">
                    <h2 class="mb-0">
                        <button class="btn btn-link" type="button" data-toggle="collapse" data-target="#parent_<?= $v->id ?>" aria-expanded="true" aria-controls="collapseOne">
                            <?= $v->nama_upacara ?>
                        </button>
                    </h2>
                </div>

                <div id="parent_<?= $v->id ?>" class="collapse show" aria-labelledby="headingOne" data-parent="#acordionParent_<?= $v->id ?>" style="padding: 0">
                    <div class="card-body" style="padding: 0">
                        <!--<div class="wrapper">-->
                        <ul class="nav nav-tabs" role="tablist" id="tabUpacara">
                            <?php
                            foreach ($upacara as $val) {
                                if ($val->id_upacara == $v->id) {
                                    ?>
                                    <li class="nav-item" onclick="getFieldUpacara('<?= $id_wedding ?>', '<?= $val->id_field ?>', '<?= $v->id ?>')">
                                        <a class="nav-link" data-toggle="tab" href="#upacara_<?= $v->id ?>_<?= $val->id_field ?>" role="tab" aria-controls="upacara_<?= $val->id ?>" aria-selected="true"><?= $val->nama_upacara ?></a>
                                    </li>
                                    <?php
                                }
                            }
                            ?>
                        </ul>
                        <!--</div>-->
                        <div class="tab-content">
                            <?php
                            foreach ($upacara as $val) {
                                ?>
                                <div class="tab-pane" id="upacara_<?= $v->id ?>_<?= $val->id_field ?>" role="tabpanel">

                                </div>
                                <?php
                            }
                            ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <?php
    }
    ?>
</div>

<div class="modal fade" id="upacaraEditModal" tabindex="-1" role="dialog" aria-labelledby="upacaraEditModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">Paket Acara</h4>
                <button class="close" type="button" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">×</span>
                </button>
            </div>
            <div class="modal-body">
                <form class="form-horizontal" action="#" name="formPaketUpacara" id="formPaketUpacara" method="post">
                    <input type="hidden" name="id_wedding" id="id_wedding" value="<?= $id_wedding ?>">

                    <div>
                        <fieldset>
                            <?php
                            $parent = '0';
                            foreach ($paket_upacara as $key => $val) {
                                $value = $val->id;
                                $id_parent_child = $val->parent_id;
                                $nama = $val->child_name;
                                $checked = ($val->id == $val->id_upacara_tipe) ? "checked='checked'" : "";
                                $id = strtolower(str_replace(array(" ", "/"), array("_", "_"), $nama)) . "_" . $value;
                                if ($parent == '0') {
                                    $parent = $val->parent_id;
                                } else if ($parent != $id_parent_child) {
                                    $parent = '0';
                                }
                                if ($parent == '0' || $parent == '00' || $key == 0) {
                                    ?>
                                    <b><?= $val->parent_name ?></b><br>
                                    <?php
                                }
                                if ($nama != "") {
                                    ?>
                                    <div class="form-check form-check-inline mr-1" style="margin-left: 10px">
                                        <input class="form-check-input" <?= $checked ?> id="<?= $id ?>" name="upacara[]" type="checkbox" value="<?= $value ?>">
                                        <label class="form-check-label" for="<?= $id ?>"><?= $nama ?></label>
                                    </div><br>
                                    <?php
                                }
                            }
                            ?>
                        </fieldset>
                    </div>
                    <div class="form-group row">
                        <label class="col-md-3 col-form-label" for="hf-password"></label>
                        <div class="col-md-9">
                            <button class="btn btn-secondary" type="button" data-dismiss="modal">Tutup</button>
                            <button class="btn btn-primary" type="button" onclick="simpanPaketUpacara()">Simpan</button>
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
    function getFieldUpacara(id_wedding, id, parent) {
        $.ajax({
            url: "<?= base_url() ?>Wedding/upacara/field?id=" + id + "&id_wedding=" + id_wedding,
            success: function (data) {
                $("#upacara_" + parent + "_" + id).html(data);
            }
        });
    }

    function simpanPaketUpacara() {
        var formData = $("#formPaketUpacara").serialize();
        $.ajax({
            type: 'POST',
            url: '<?= base_url() ?>Wedding/editUpacara',
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