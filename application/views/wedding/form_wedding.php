<?php
if (!empty($wedding)) {
    $id = $wedding->id;
    $id_company = $wedding->id_company;
    $title = $wedding->title;
    $pengantin_pria = $wedding->pengantin_pria;
    $pengantin_wanita = $wedding->pengantin_wanita;
    $tanggal = $wedding->tanggal;
    $waktu = $wedding->waktu;
    $tempat = $wedding->tempat;
    $alamat = $wedding->alamat;
    $tema = $wedding->tema;
    $hashtag = $wedding->hashtag;
    $penyelenggara = $wedding->penyelenggara;
    $undangan = $wedding->undangan;
    $status = $wedding->status;
    $nama_pic = $wedding->nama_pic;
    $wa_pic = $wedding->wa_pic;
} else {
    $id = "";
    $id_company = "";
    $title = "";
    $pengantin_pria = "";
    $pengantin_wanita = "";
    $tanggal = "";
    $waktu = "";
    $tempat = "";
    $alamat = "";
    $tema = "";
    $hashtag = "";
    $penyelenggara = "";
    $undangan = "";
    $status = "";
    $nama_pic = "";
    $wa_pic = "";
}
?>
<form class="form-horizontal" action="#" id="formWedding" method="post">
    <input type="hidden" name="id" value="<?= $id ?>">
    <input type="hidden" name="id_wedding" value="<?= $id_wedding ?>">
<div style="float: right">
    <button type="submit" onclick="simpanWedding()" class="btn btn-mini btn-primary"><i class="fa fa-save"></i> Simpan</button>
    <a href="<?= base_url() ?>Printout/printWedding?id=<?= $id_wedding ?>" target="_blank">
        <button type="button" class="btn btn-success"><i class="fa fa-print"></i> Print Data</button>
    </a>
</div>
<h2>Data Pernikahan</h2>
<hr>
<div>
    <div class="col-md-6" style="float: left">
        <div class="form-group">
            <label class="control-label">Judul Pernikahan</label>
            <input name="title" id="title" type="text" required="required" class="form-control" value="<?= $title ?>" placeholder="" />
        </div>
        <div class="form-group">
            <label class="control-label">Tanggal Pernikahan</label>
            <input name="tanggal_pernikahan" id="tanggal_pernikahan" type="date" required="required" class="form-control" value="<?= $tanggal ?>"  />
        </div>
        <div class="form-group">
            <label class="control-label">Waktu Pernikahan</label>
            <input name="waktu_pernikahan" id="waktu_pernikahan" type="time" required="required" class="form-control" value="<?= $waktu ?>"  />
        </div>
        <div class="form-group">
            <label class="control-label">Lokasi Pernikahan</label>
            <input name="lokasi_pernikahan" id="lokasi_pernikahan" type="text" required="required" class="form-control" value="<?= $tempat ?>"  />
        </div>
        <div class="form-group">
            <label class="control-label">Alamat Lokasi Pernikahan</label>
            <input name="alamat_pernikahan" id="alamat_pernikahan" type="text" required="required" class="form-control" value="<?= $alamat ?>"  />
        </div>
    </div>
    <div class="col-md-6" style="float: left">

        <div class="form-group">
            <label class="control-label">Sistem Jamuan Pernikahan</label>
            <input name="tema_pernikahan" id="tema_pernikahan" type="text" required="required" class="form-control" value="<?= $tema ?>"  />
        </div>
        <div class="form-group">
            <label class="control-label">Hastag Pernikahan</label>
            <input name="hastag_pernikahan" id="hastag_pernikahan" type="text" required="required" class="form-control" value="<?= $hashtag ?>"  />
        </div>
        <div class="form-group">
            <label class="control-label">Penyelenggara</label>
            <select class="form-control" name="penyelenggara" id="penyelenggara">
                <option value="">-- Pilih Penyelenggara --</option>
                <option value="PRIA">Pihak Pria</option>
                <option value="WANITA">Pihak Wanita</option>
                <option value="KEDUA">Kedua Pihak</option>
            </select>
        </div>
        <div class="form-group">
            <label class="control-label">Jumlah Undangan</label>
            <input name="jumlah_undangan" id="jumlah_undangan" type="number" required="required" class="form-control" value="<?= $undangan ?>"  />
        </div>
        <div class="form-group" style="background:#e7e7e7">
            <label class="control-label">Nama PIC</label>
            <input name="nama_pic" id="nama_pic" type="text" required="required" class="form-control required" value="<?= $nama_pic ?>" />
        </div>
        <div class="form-group" style="background:#e7e7e7">
            <label class="control-label">No WA PIC</label>
            <input name="wa_pic" id="wa_pic" type="text" required="required" class="form-control required" value="<?= $wa_pic ?>" />
        </div>
    </div>
</div>
</form>
<script>
    $("#penyelenggara").val('<?= $penyelenggara ?>');
</script>

<script>

    function simpanWedding(){
        var formData = new FormData($("#formWedding")[0]);
        $('#formWedding').validate({
            rules: {
                title: {
                    required: true,
                    minlength: 2
                },
                tanggal: "required"
            },
            messages: {
                title: {
                    required: "Please enter a Nama Vendor",
                    minlength: "Nama Vendor minimal 2 karakter"
                },
                tanggal: "Pilih Tanggal Pernikahan"
            },
            submitHandler: function (form) {
                $.ajax({
                    type: 'POST',
                    url: '<?= base_url() ?>Wedding/saveWedding',
                    processData: false,
                    contentType: false,
                    data: formData,
                    dataType: "JSON",
                    success: function (data) {
//                        if (data) {
                            swal("success", "Berhasil merubah data pernikahan!");
//                            $("#vendorModal").modal('hide');
//                        } else {
//                            swal("warning", "Gagal menambah vendor!");
//                        }
                    }
                });
            }
        });
    }
</script>