<?php
if (!empty($ayahpria)) {
    $id_ayah_pria = $ayahpria->id;
    $ayah_pria = $ayahpria->nama;
    $nohp_ayah_pria = $ayahpria->no_hp;
} else {
    $id_ayah_pria = "";
    $ayah_pria = "";
    $nohp_ayah_pria = "";
}
if (!empty($ibupria)) {
    $id_ibu_pria = $ibupria->id;
    $ibu_pria = $ibupria->nama;
    $nohp_ibu_pria = $ibupria->no_hp;
} else {
    $id_ibu_pria = "";
    $ibu_pria = "";
    $nohp_ibu_pria = "";
}
if (!empty($ayahwanita)) {
    $id_ayah_wanita = $ayahwanita->id;
    $ayah_wanita = $ayahwanita->nama;
    $nohp_ayah_wanita = $ayahwanita->no_hp;
} else {
    $id_ayah_wanita = "";
    $ayah_wanita = "";
    $nohp_ayah_wanita = "";
}
if (!empty($ibuwanita)) {
    $id_ibu_wanita = $ibuwanita->id;
    $ibu_wanita = $ibuwanita->nama;
    $nohp_ibu_wanita = $ibuwanita->no_hp;
} else {
    $id_ibu_wanita = "";
    $ibu_wanita = "";
    $nohp_ibu_wanita = "";
}
?>
<h2>Biodata Keluarga Calon Pengantin</h2>
<hr>
<ul class="nav nav-tabs" role="tablist" id="tabKeluarga">
    <li class="nav-item" >
        <a class="nav-link active" data-toggle="tab" href="#tabKeluarga_pria" role="tab" aria-controls="tabKeluarga_pria" aria-selected="true">Keluarga Pria</a>
    </li>
    <li class="nav-item" >
        <a class="nav-link" data-toggle="tab" href="#tabKeluarga_wanita" role="tab" aria-controls="tabKeluarga_wanita" aria-selected="true">Keluarga Wanita</a>
    </li>
</ul>

<div class="tab-content">
    <div class="tab-pane active" id="tabKeluarga_pria" role="tabpanel">

        <form class="form-horizontal" action="#" id="" method="post">
            <input type="hidden" name="id" value="<?= $id_wedding ?>">
            <input type="hidden" name="id_wedding" value="<?= $id_wedding ?>">
            <div style="float: right">
                <button type="button" onclick="saveOrtu('pria')" class="btn btn-mini btn-primary"><i class="fa fa-save"></i> Simpan</button>
                <a href="<?= base_url() ?>Printout/printKeluargaPria?id=<?= $id_wedding ?>" target="_blank">
                    <button type="button" class="btn btn-success"><i class="fa fa-print"></i> Print Data</button>
                </a>
            </div>
            <div class="clearfix"></div><br>
            <div class="form-group row">
                <label class="col-md-3 col-form-label" for="ayah_pria">Ayah</label>
                <div class="col-md-5">
                    <input class="form-control" id="ayah_pria" type="text" name="ayah_pria" value="<?= $ayah_pria ?>" placeholder="Nama Ayah" autocomplete="text">                
                </div>
                <div class="col-md-4">
                    <input class="form-control" id="nohp_ayah_pria" type="text" value="<?= $nohp_ayah_pria ?>" onkeypress="return isNumberKey(event)"  name="nohp_ayah_pria" placeholder="No Hp Ayah" autocomplete="text">                
                </div>
            </div>
            <div class="form-group row">
                <label class="col-md-3 col-form-label" for="ibu_pria">Ibu</label>
                <div class="col-md-5">
                    <input class="form-control" id="ibu_pria" type="text" name="ibu_pria" value="<?= $ibu_pria ?>" placeholder="Nama Ibu" autocomplete="current-password">                
                </div>
                <div class="col-md-4">
                    <input class="form-control" id="nohp_ibu_pria" type="text" name="nohp_ibu_pria" value="<?= $nohp_ibu_pria ?>" onkeypress="return isNumberKey(event)"  placeholder="No Hp Ibu" autocomplete="text">                
                </div>
            </div>
            <div class="form-group row" style="padding: 10px">
                <h3>Saudara</h3><br>
                <div id="dataSaudara_pria">
                    <table class="table">
                        <thead>
                            <tr>
                                <th style="width: 3%">No</th>
                                <th style="width: 20%">Hubungan</th>
                                <th>Nama</th>
                                <th style="width: 18%">No Hp</th>
                                <th style="width: 10%"></th>
                            </tr>
                            <tr>
                                <td>
                                    <input type="hidden" name="idsaudara_pria" id="idsaudara_pria">
                                </td>
                                <td>
                                    <select name="hubungan_pria" id="hubungan_pria" class="form-control">
                                        <option value="">-- Pilih Saudara --</option>
                                        <option value="KAKAK">KAKAK</option>
                                        <option value="ADIK">ADIK</option>
                                        <option value="KAKAK_IPAR">KAKAK IPAR</option>
                                        <option value="KAKAK_IPAR">ADIK IPAR</option>
                                    </select>
                                </td>
                                <td>
                                    <input type="text" name="nama_saudara_pria" id="nama_saudara_pria" class="form-control">
                                </td>
                                <td>
                                    <input type="text" name="nohp_saudara_pria" id="nohp_saudara_pria" onkeypress="return isNumberKey(event)" class="form-control">
                                </td>
                                <td>
                                    <button type="button" onclick="saveSaudara('pria')" class="btn btn-mini btn-primary"><i class="fa fa-plus"></i></button>
                                </td>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            $no = 1;
                            foreach ($saudara_pria as $val) {
                                ?>
                                <tr>
                                    <td><?= $no++ ?></td>
                                    <td><?= $val->hubungan ?></td>
                                    <td><?= $val->nama ?></td>
                                    <td><?= $val->no_hp ?></td>
                                    <td nowrap='nowrap'>
                                        <button type="button" class="btn btn-sm btn-dark" onclick="editSaudara('pria', '<?= $val->id ?>')">
                                            <i class="fa fa-pencil"></i>
                                        </button>
                                        <button type="button" class="btn btn-sm btn-danger" onclick="deleteSaudara('pria', '<?= $val->id ?>')">
                                            <i class="fa fa-trash   "></i>
                                        </button>
                                    </td>
                                </tr>
                                <?php
                            }
                            ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </form>
    </div>
    <div class="tab-pane" id="tabKeluarga_wanita" role="tabpanel">

        <form class="form-horizontal" action="#" id="" method="post">
            <input type="hidden" name="id" value="<?= $id_wedding ?>">
            <input type="hidden" name="id_wedding" value="<?= $id_wedding ?>">
            <div style="float: right">
                <button type="button" onclick="saveOrtu('wanita')" class="btn btn-mini btn-primary"><i class="fa fa-save"></i> Simpan</button>
                <a href="<?= base_url() ?>Printout/printKeluargaWanita?id=<?= $id_wedding ?>" target="_blank">
                    <button type="button" class="btn btn-success"><i class="fa fa-print"></i> Print Data</button>
                </a>
            </div>
            <div class="clearfix"></div><br>
            <div class="form-group row">
                <label class="col-md-3 col-form-label" for="ayah_wanita">Ayah</label>
                <div class="col-md-5">
                    <input class="form-control" id="ayah_wanita" type="text" name="ayah_wanita" value="<?= $ayah_wanita ?>" placeholder="Nama Ayah" autocomplete="text">                
                </div>
                <div class="col-md-4">
                    <input class="form-control" id="nohp_ayah_wanita" type="text" value="<?= $nohp_ayah_wanita ?>" onkeypress="return isNumberKey(event)"  name="nohp_ayah_wanita" placeholder="No Hp Ayah" autocomplete="text">                
                </div>
            </div>
            <div class="form-group row">
                <label class="col-md-3 col-form-label" for="ibu_wanita">Ibu</label>
                <div class="col-md-5">
                    <input class="form-control" id="ibu_wanita" type="text" name="ibu_wanita" value="<?= $ibu_wanita ?>" placeholder="Nama Ibu" autocomplete="current-password">                
                </div>
                <div class="col-md-4">
                    <input class="form-control" id="nohp_ibu_wanita" type="text" name="nohp_ibu_wanita" value="<?= $nohp_ibu_wanita ?>" onkeypress="return isNumberKey(event)"  placeholder="No Hp Ibu" autocomplete="text">                
                </div>
            </div>
            <div class="form-group row" style="padding: 10px">
                <h3>Saudara</h3><br>
                <div id="dataSaudara_wanita">
                    <table class="table">
                        <thead>
                            <tr>
                                <th style="width: 3%">No</th>
                                <th style="width: 20%">Hubungan</th>
                                <th>Nama</th>
                                <th style="width: 18%">No Hp</th>
                                <th style="width: 10%"></th>
                            </tr>
                            <tr>
                                <td>
                                    <input type="hidden" name="idsaudara_wanita" id="idsaudara_wanita">
                                </td>
                                <td>
                                    <select name="hubungan_wanita" id="hubungan_wanita" class="form-control">
                                        <option value="">-- Pilih Saudara --</option>
                                        <option value="KAKAK">KAKAK</option>
                                        <option value="ADIK">ADIK</option>
                                        <option value="KAKAK_IPAR">KAKAK IPAR</option>
                                        <option value="KAKAK_IPAR">ADIK IPAR</option>
                                    </select>
                                </td>
                                <td>
                                    <input type="text" name="nama_saudara_wanita" id="nama_saudara_wanita" class="form-control">
                                </td>
                                <td>
                                    <input type="text" name="nohp_saudara_wanita" id="nohp_saudara_wanita" onkeypress="return isNumberKey(event)" class="form-control">
                                </td>
                                <td>
                                    <button type="button" onclick="saveSaudara('wanita')" class="btn btn-mini btn-primary"><i class="fa fa-plus"></i></button>
                                </td>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            $no = 1;
                            foreach ($saudara_wanita as $val) {
                                ?>
                                <tr>
                                    <td><?= $no++ ?></td>
                                    <td><?= $val->hubungan ?></td>
                                    <td><?= $val->nama ?></td>
                                    <td><?= $val->no_hp ?></td>
                                    <td nowrap='nowrap'>
                                        <button type="button" class="btn btn-sm btn-dark" onclick="editSaudara('wanita', '<?= $val->id ?>')">
                                            <i class="fa fa-pencil"></i>
                                        </button>
                                        <button type="button" class="btn btn-sm btn-danger" onclick="deleteSaudara('wanita', '<?= $val->id ?>')">
                                            <i class="fa fa-trash   "></i>
                                        </button>
                                    </td>
                                </tr>
                                <?php
                            }
                            ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </form>
    </div>
</div>

<script>

    function saveOrtu(tipe) {
        var id = $("#id").val();
        var id_wedding = $("#id_wedding").val();
        var ayah = $("#ayah_" + tipe).val();
        var ibu = $("#ibu_" + tipe).val();
        var nohpayah = $("#nohp_ayah_" + tipe).val();
        var nohpibu = $("#nohp_ibu_" + tipe).val();
        $.ajax({
            url: "<?= base_url() ?>Wedding/saveOrtu",
            data: "id=" + id + "&id_wedding=" + id_wedding + "&ayah=" + ayah + "&ibu=" + ibu
                    + "&nohpayah=" + nohpayah + "&nohpibu=" + nohpibu + "&tipe=" + tipe,
            type: "POST",
            dataType: "JSON",
            success: function (data) {
                if (data.code == 200) {
                    alert("Berhasil merubah Orang Tua");
                    $("#tabKeluarga_" + tipe).load(location.href + " #tabKeluarga_" + tipe);
                } else {
                    alert("Gagal menambah Orang Tua");
                }
            }
        });
    }
    function editSaudara(tipe, id) {
        $.ajax({
            url: "<?= base_url() ?>Wedding/getKeluarga?id=" + id,
            dataType: "JSON",
            success: function (data) {
                $("#idsaudara_" + tipe).val(data.id);
                $("#hubungan_" + tipe).val(data.hubungan);
                $("#nama_saudara_" + tipe).val(data.nama);
                $("#nohp_saudara_" + tipe).val(data.no_hp);
            }
        });
    }
    function deleteSaudara(tipe, id) {
        if (confirm('Apakah anda yakin akan menghapus data saudara?')) {
            $.ajax({
                url: "<?= base_url() ?>Wedding/deleteKeluarga?id=" + id,
                dataType: "JSON",
                success: function (data) {
                    $("#dataSaudara_" + tipe).load(location.href + " #dataSaudara_" + tipe);
                }
            });
        }
    }
    function saveSaudara(tipe) {
        var id = $("#id").val();
        var id_wedding = $("#id_wedding").val();
        var idsaudara = $("#idsaudara_" + tipe).val();
        var hubungan = $("#hubungan_" + tipe).val();
        var nama = $("#nama_saudara_" + tipe).val();
        var nohp = $("#nohp_saudara_" + tipe).val();
        $.ajax({
            url: "<?= base_url() ?>Wedding/saveSaudara",
            data: "id=" + id + "&id_wedding=" + id_wedding + "&idsaudara=" + idsaudara + "&hubungan=" + hubungan
                    + "&nama=" + nama + "&nohp=" + nohp + "&tipe=" + tipe,
            type: "POST",
            dataType: "JSON",
            success: function (data) {
                if (data.code == 200) {
                    alert("Berhasil merubah saudara");
                    $("#dataSaudara_" + tipe).load(location.href + " #dataSaudara_" + tipe);
                    $("#idsaudara_" + tipe).val('');
                    $("#hubungan_" + tipe).val('');
                    $("#nama_saudara_" + tipe).val('');
                    $("#nohp_saudara_" + tipe).val('');
                } else {
                    alert("Gagal merubah saudara");
                }
            }
        });
    }
</script>