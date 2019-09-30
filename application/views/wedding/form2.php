<style>
    .nav-item{
        detail-wedding: 0.1px solid gray;
    }
    .show{
        display: block;
    }
    .hidden{
        display: none;
    }
</style>
<main class="main">
    <!-- Breadcrumb-->
    <ol class="breadcrumb">
        <li class="breadcrumb-item">The Wedding</li>
        <li class="breadcrumb-item">
            <a href="<?=base_url()?>Wedding">Data Wedding</a>
        </li>
        <li class="breadcrumb-item active">Detail</li>
        <!-- Breadcrumb Menu-->
    </ol>
    <div class="container-fluid">
        <div id="ui-view"><div>
                <div class="animated fadeIn">
                    <div class="card-header">
                        <i class="fa fa-align-justify"></i> Detail Data Wedding</div>
                    <div class="email-app">
                        <nav>
                            <center>
                                <input type="hidden" name="id_wedding" id="id_wedding" value="<?=$id_wedding?>">
                                <div class="avatar">
                                    <img class="img-avatar" src="<?=base_url()?>files/images/<?=$pria->photo != "" ? $pria->photo : "user.jpg"?>" alt="<?=$pria->nama_lengkap?>">
                                </div>
                                <div class="avatar">
                                    <img class="img-avatar" src="<?=base_url()?>files/images/<?=$wanita->photo != "" ? $wanita->photo : "user.jpg"?>" alt="<?=$wanita->nama_lengkap?>">
                                </div>
                                <br><br>
                                <b id="countdown">-- </b><br>
                                <b></b>
                            </center>
                            <hr>
                            <ul class="nav nav-tabs" role="tablist">
                                <li class="nav-item detail-wedding">
                                    <a class="nav-link active" data-toggle="tab" href="#wedding" role="tab" aria-controls="wedding">Data Wedding</a>
                                </li>
                                <li class="nav-item detail-wedding">
                                    <a class="nav-link" data-toggle="tab" href="#pria" role="tab" aria-controls="pria">Groom</a>
                                </li>
                                <li class="nav-item detail-wedding">
                                    <a class="nav-link" data-toggle="tab" href="#wanita" role="tab" aria-controls="wanita">Bride</a>
                                </li>
                                <li class="nav-item detail-wedding">
                                    <a class="nav-link" data-toggle="tab" href="#keluarga" role="tab" aria-controls="keluarga">Data Keluarga</a>
                                </li>
                                <li class="nav-item detail-wedding">
                                    <a class="nav-link" data-toggle="tab" href="#vendor" role="tab" aria-controls="vendor">Daftar Vendor</a>
                                </li>
                                <li class="nav-item detail-wedding">
                                    <a class="nav-link" data-toggle="tab" href="#payment" role="tab" aria-controls="vendor">Payment Vendor</a>
                                </li>
                                <li class="nav-item detail-wedding">
                                    <a class="nav-link" data-toggle="tab" href="#undangan" role="tab" aria-controls="undangan">Daftar Undangan</a>
                                </li>
                                <li class="nav-item detail-wedding">
                                    <a class="nav-link" data-toggle="tab" href="#hadir" role="tab" aria-controls="hadir">Daftar Hadir</a>
                                </li>
                                <li class="nav-item detail-wedding">
                                    <a class="nav-link" data-toggle="tab" href="#jadwal" role="tab" aria-controls="jadwal">Jadwal Meeting</a>
                                </li>
                                <li class="nav-item detail-wedding">
                                    <a class="nav-link" data-toggle="tab" href="#acara" role="tab" aria-controls="acara">Paket Acara</a>
                                </li>
                                <li class="nav-item detail-wedding">
                                    <a class="nav-link" data-toggle="tab" href="#upacara" role="tab" aria-controls="upacara">Paket Upacara</a>
                                </li>
                                <li class="nav-item detail-wedding">
                                    <a class="nav-link" data-toggle="tab" href="#panitia" role="tab" aria-controls="panitia">Paket Panitia</a>
                                </li>
                                <li class="nav-item detail-wedding">
                                    <a class="nav-link" data-toggle="tab" href="#tambahan" role="tab" aria-controls="tambahan">Paket Tambahan</a>
                                </li>
                                <li class="nav-item detail-wedding">
                                    <a class="nav-link" data-toggle="tab" href="#layout" role="tab" aria-controls="layout">Lampiran</a>
                                </li>
                                <li class="nav-item detail-wedding">
                                    <a class="nav-link" data-toggle="tab" href="#log" role="tab" aria-controls="log">Log Aktivitas</a>
                                </li>
                            </ul>
                            <br>
                            <div>
<!--                                <a href="<?=base_url()?>Cetak/cetak?id=<?=$id_wedding?>" target="_blank">
                                    <button type="button" class="btn btn-sm btn-success" style="width:100%"><i class="fa fa-print"></i> Cetak Buku Wedding</button><br><br>
                                </a>-->
                                <button type="button" class="btn btn-sm btn-success" style="width:100%"  data-toggle="modal" data-target="#modalBukuNikah" onclick="hideProsesAll()"><i class="fa fa-print"></i> Cetak Buku Wedding</button><br><br>
                                <button type="button" onclick="nonAktifkanUser('<?=$id_wedding?>')" class="btn btn-sm btn-dark" style="width:100%"><i class="fa fa-lock"></i> Nonaktifkan User</button>
                                <br><br>
                                <?php
if ($wedding->status == 1) {
    ?>
                                    <button type="button" onclick="finishWedding('<?=$id_wedding?>')" class="btn btn-sm btn-danger" style="width:100%"><i class="fa fa-check"></i> Pernikahan Selesai</button>
                                    <?php
} else {
    ?>
                                    <b>Acara Selesai</b>
                                    <br>
                                    Klik tombol di bawah apabila ingin mengaktifkan kembali
                                    <button type="button" onclick="openWedding('<?=$id_wedding?>')" class="btn btn-sm btn-danger" style="width:100%"><i class="fa fa-check"></i> Aktifkan Lagi</button>
                                    <?php
}
?>
                            </div>
                        </nav>
                        <main>
                            <div class="tab-content" style="border: 0;" id="formDetailWedding">
                                <div class="tab-pane active" id="wedding" role="tabpanel">
                                    <?php $this->load->view('wedding/form_wedding');?>
                                </div>
                                <div class="tab-pane" id="pria" role="tabpanel">
                                    <?php $this->load->view('wedding/form_pria');?>
                                </div>
                                <div class="tab-pane" id="wanita" role="tabpanel">
                                    <?php $this->load->view('wedding/form_wanita');?>
                                </div>
                                <div class="tab-pane" id="keluarga" role="tabpanel">
                                    <?php $this->load->view('wedding/form_keluarga');?>
                                </div>
                                <div class="tab-pane" id="vendor" role="tabpanel">
                                    <?php $this->load->view('wedding/form_vendor');?>
                                </div>
                                <div class="tab-pane" id="payment" role="tabpanel">
                                    <?php $this->load->view('wedding/form_payment');?>
                                </div>
                                <div class="tab-pane" id="undangan" role="tabpanel">
                                    <?php $this->load->view('wedding/form_undangan');?>
                                </div>
                                <div class="tab-pane" id="hadir" role="tabpanel">
                                    <?php $this->load->view('wedding/form_hadir');?>
                                </div>
                                <div class="tab-pane" id="jadwal" role="tabpanel">
                                    <?php $this->load->view('wedding/jadwal_meeting');?>
                                </div>
                                <div class="tab-pane" id="acara" role="tabpanel">
                                    <?php $this->load->view('wedding/form_acara');?>
                                </div>
                                <div class="tab-pane" id="upacara" role="tabpanel">
                                    <?php $this->load->view('wedding/form_upacara');?>
                                </div>
                                <div class="tab-pane" id="panitia" role="tabpanel">
                                    <?php $this->load->view('wedding/form_panitia');?>
                                </div>
                                <div class="tab-pane" id="tambahan" role="tabpanel">
                                    <?php $this->load->view('wedding/form_tambahan');?>
                                </div>
                                <div class="tab-pane" id="layout" role="tabpanel">
                                    <?php $this->load->view('wedding/form_layout');?>
                                </div>
                                <div class="tab-pane" id="log" role="tabpanel">
                                    <?php $this->load->view('wedding/form_log');?>
                                </div>
                            </div>
                        </main>
                    </div>
                </div>
                <br>
            </div>
        </div>
    </div>
</div>
<div id="modalBukuNikah" class="modal fade" role="dialog" data-backdrop="static" data-keyboard="false">
    <div class="modal-dialog">

        <!-- Modal content-->
        <div class="modal-content">
            <div class="modal-header" style="text-align: right">
                <h4 class="modal-title">Export Buku Nikah</h4>
            </div>
            <div class="modal-body">
                <?php
$href = "#";
$class_download = "hidden";
if ($wedding->buku_nikah != "") {
    $href = base_url() . "files/output/" . $wedding->buku_nikah;
    $class_download = "show";
}
?>
                <div id="downloadBukuNikah">
                    <a href="<?=$href?>" class="<?=$class_download?>" target="_blank">
                        <button class="btn btn-success btn-sm" type="button" style="width: 100%"><i class="fa fa-download"></i> Download</button>
                    </a>
                </div><br>
                <button class="btn btn-primary btn-sm" id="generateBukuNikah" type="button" onclick="generateBukuNikah('<?=$id_wedding?>')" style="width: 100%">
                    <i class="fa fa-refresh" id="iconBukuNikah"></i>
                    <img src="<?=base_url()?>assets/loading.gif" id="loadingBukuNikah" width="auto" height="20px" style="display: none">
                    &nbsp;&nbsp;Generate Buku Nikah</button>
                <!--<button class="btn btn-primary btn-sm" type="button" onclick="cetak('<?=$id_wedding?>')"><i class="fa fa-refresh"></i> Generate Buku Nikah</button>-->
                <div id="prosesGenerate">
                    <br>
                    <table class="table table-bordered" id="tableProsesGenerate">
                        <tr id="generateWedding"></tr>
                        <tr id="generateBiodata"></tr>
                        <tr id="generateFamily"></tr>
                        <tr id="generateAcara"></tr>
                        <tr id="generateUpacara"></tr>
                        <tr id="generatePanitia"></tr>
                        <tr id="generateTambahan"></tr>
                    </table>
                </div>
            </div>
            <div class="modal-footer" style="text-align: left">
                <span style="font-size: 10px; float: left; position: absolute; left: 20px">
                    <i>
                        Proses generate membutuhkan waktu
                    </i>
                </span>
                <button type="button" class="btn btn-default" data-dismiss="modal" id="closeGenerate">Close</button>
            </div>
        </div>

    </div>
</div>
<script>

// Set the date we're counting down to
    var countDownDate = new Date("<?=$wedding->tanggal?> <?=$wedding->waktu?>").getTime();

// Update the count down every 1 second
        var x = setInterval(function () {

            // Get today's date and time
            var now = new Date().getTime();

            // Find the distance between now and the count down date
            var distance = countDownDate - now;

            // Time calculations for days, hours, minutes and seconds
            var days = Math.floor(distance / (1000 * 60 * 60 * 24));
            var hours = Math.floor((distance % (1000 * 60 * 60 * 24)) / (1000 * 60 * 60));
            var minutes = Math.floor((distance % (1000 * 60 * 60)) / (1000 * 60));
            var seconds = Math.floor((distance % (1000 * 60)) / 1000);

            $("#countdown").html(days + " Hari " + hours + " Jam ");
//                + minutes + " Menit " + seconds + " Detik ");

            if (distance < 0) {
                clearInterval(x);
                $("#countdown").html("Waktu Pengisian Data Sudah Habis");
                $("#formDetailWedding *").attr("disabled", "disabled").off('click');
            }
        }, 1000);
        $(function () {
            var status_wedding = "<?=$wedding->status?>";
            if (status_wedding == '0') {
                $("#formDetailWedding *").attr("disabled", "disabled").off('click');
            }
//        $('#tabAcara').scrollingTabs();
//        $('#tabPanitia').scrollingTabs();
//        $('#tabTambahan').scrollingTabs();
//        $('#tabUpacara').scrollingTabs();
        });
        $(".id_wedding").val('<?=$id_wedding?>');
//    $("#formDetailWedding *").attr("disabled", "disabled").off('click');

        function saveacara(id, value, type = null) {
            var id_wedding = $("#id_wedding").val();
            if (type == "addabletext") {
                var dataForm = new FormData($("#form" + value)[0]);
                dataForm.append('id', id);
                dataForm.append('id_wedding', id_wedding);
                dataForm.append('type', type);
                dataForm.append('value', value);
                $.ajax({
                    url: "<?=base_url()?>Wedding/acara/add",
                    type: "POST",
                    data: dataForm,
                    processData: false,
                    contentType: false,
                    success: function (data) {
                    }
                });
            } else {
                dataForm = "id=" + id + "&value=" + value + "&id_wedding=" + id_wedding;
                $.ajax({
                    url: "<?=base_url()?>Wedding/acara/add",
                    type: "POST",
                    data: dataForm,
                    success: function (data) {
                    }
                });
        }
        }

        function saveupacara(id, value, type = null) {
            var id_wedding = $("#id_wedding").val();
            if (type == "addabletext") {
                var dataForm = new FormData($("#form" + value)[0]);
                dataForm.append('id', id);
                dataForm.append('id_wedding', id_wedding);
                dataForm.append('type', type);
                dataForm.append('value', value);
                $.ajax({
                    url: "<?=base_url()?>Wedding/upacara/add",
                    type: "POST",
                    data: dataForm,
                    processData: false,
                    contentType: false,
                    success: function (data) {
                    }
                });
            } else if (type == "checkbox") {
                var val = "";
                if ($("#" + value).is(":checked")) {
                    val = $("#" + value).val();
                }
                dataForm = "id=" + id + "&value=" + val + "&id_wedding=" + id_wedding;
                $.ajax({
                    url: "<?=base_url()?>Wedding/upacara/add",
                    type: "POST",
                    data: dataForm,
                    success: function (data) {
                    }
                });
            } else {
                dataForm = "id=" + id + "&value=" + value + "&id_wedding=" + id_wedding;
                $.ajax({
                    url: "<?=base_url()?>Wedding/upacara/add",
                    type: "POST",
                    data: dataForm,
                    success: function (data) {
                    }
                });
        }
        }

        function savepanitia(id, value, type = null) {
            var id_wedding = $("#id_wedding").val();
            if (type == "addabletext") {
                var dataForm = new FormData($("#form" + value)[0]);
                dataForm.append('id', id);
                dataForm.append('id_wedding', id_wedding);
                dataForm.append('type', type);
                dataForm.append('value', value);
                $.ajax({
                    url: "<?=base_url()?>Wedding/panitia/add",
                    type: "POST",
                    data: dataForm,
                    processData: false,
                    contentType: false,
                    success: function (data) {
                    }
                });
            } else {
                dataForm = "id=" + id + "&value=" + value + "&id_wedding=" + id_wedding;
                $.ajax({
                    url: "<?=base_url()?>Wedding/panitia/add",
                    type: "POST",
                    data: dataForm,
                    success: function (data) {
                    }
                });
        }
        }

        function savetambahan(id, value, type = null) {
            var id_wedding = $("#id_wedding").val();
            if (type == "addabletext") {
                var dataForm = new FormData($("#form" + value)[0]);
                dataForm.append('id', id);
                dataForm.append('id_wedding', id_wedding);
                dataForm.append('type', type);
                dataForm.append('value', value);
                $.ajax({
                    url: "<?=base_url()?>Wedding/tambahan/add",
                    type: "POST",
                    data: dataForm,
                    processData: false,
                    contentType: false,
                    success: function (data) {
                    }
                });
            } else {
                dataForm = "id=" + id + "&value=" + value + "&id_wedding=" + id_wedding;
                $.ajax({
                    url: "<?=base_url()?>Wedding/tambahan/add",
                    type: "POST",
                    data: dataForm,
                    success: function (data) {
                    }
                });
        }
        }

        function nonAktifkanUser(id_wedding) {
            if (confirm('Apakah anda yakin akan menonaktifkan user pengantin wedding ini?')) {
                $.ajax({
                    url: "<?=base_url()?>Wedding/nonaktifkanUser?id=" + id_wedding,
                    type: "GET",
                    success: function (data) {
                        alert('Berhasil menonaktifkan user');
                        window.location.reload();
                    }
                });
            }
        }
        function finishWedding(id_wedding) {
            if (confirm('Apakah anda yakin akan merubah status wedding ini menjadi selesai?')) {
                $.ajax({
                    url: "<?=base_url()?>Wedding/finishWedding?id=" + id_wedding,
                    type: "GET",
                    success: function (data) {
                        alert('Berhasil menyelesaikan wedding');
                        window.location.reload();
                    }
                });
            }
        }
        function openWedding(id_wedding) {
            if (confirm('Apakah anda yakin akan merubah status wedding ini menjadi selesai?')) {
                $.ajax({
                    url: "<?=base_url()?>Wedding/openWedding?id=" + id_wedding,
                    type: "GET",
                    success: function (data) {
                        alert('Berhasil mengaktifkan wedding');
                        window.location.reload();
                    }
                });
            }
        }

        function hideProsesAll() {
            $("#generateWedding").html('');
            $("#generateFamily").html('');
            $("#generateBiodata").html('');
            $("#generateAcara").html('');
            $("#generateUpacara").html('');
            $("#generatePanitia").html('');
            $("#generateTambahan").html('');
        }

        function showDownload(href) {
            $("#downloadBukuNikah").load(location.href + " #downloadBukuNikah");
        }

        function enabledGenerate() {
            $("#generateBukuNikah").removeAttr('disabled');
            $("#closeGenerate").removeAttr('disabled');
            $("#downloadBukuNikah").removeAttr('disabled');
            $("#loadingBukuNikah").attr('style', 'display: none');
            $("#iconBukuNikah").attr('style', 'display: block; float: left');
        }

        function disabledGenerate() {
            $("#generateBukuNikah").attr('disabled', 'disabled');
            $("#closeGenerate").attr('disabled', 'disabled');
            $("#downloadBukuNikah").attr('disabled', 'disabled');
            $("#loadingBukuNikah").attr('style', 'display: block; float: left');
            $("#iconBukuNikah").attr('style', 'display: none');
        }

        function replaceIsi(bodyId, icon, message) {
            var labelIcon = "";
            if (icon == "otw") {
                labelIcon = '<img src="<?=base_url()?>assets/loading.gif" width="auto" height="20px">';
            } else if (icon == "ok") {
                labelIcon = '<i class="fa fa-check"></i>';
            } else if (icon == "error") {
                labelIcon = '<i class="fa fa-close"></i>';
            }
            var data = '<td style="width:40px">' + labelIcon + '</td><td>' + message + '</td>';
            $("#" + bodyId).html(data);
        }

        function appendTable(bodyId, icon, message) {
            var labelIcon = "";
            if (icon == "otw") {
                labelIcon = '<img src="<?=base_url()?>assets/loading.gif" width="auto" height="20px">';
            } else if (icon == "ok") {
                labelIcon = '<i class="fa fa-check"></i>';
            } else if (icon == "error") {
                labelIcon = '<i class="fa fa-close"></i>';
            }
            var data = '<td style="width:40px">' + labelIcon + '</td><td>' + message + '</td>';
            $("#" + bodyId).html(data);
        }

        function cetak(id) {
            if (id != "") {
                $.ajax({
                    url: "<?=base_url()?>Cetak/cetak?id=" + id,
                    dataType: "JSON",
                    success: function (data) {

                    },
                    timeout: 0
                });
            }
        }

        function generateBukuNikah(id) {
            disabledGenerate();
            replaceIsi('generateWedding', 'otw', 'Prosess Generate Data Pernikahan');
            if (id != "") {
                $.ajax({
                    url: "<?=base_url()?>Cetak/generateWedding?id=" + id,
                    dataType: "JSON",
                    success: function (data) {
                        if (data.code == "200") {
                            replaceIsi('generateWedding', 'ok', 'Prosess Generate Data Pernikahan Berhasil');
                            appendTable('generateBiodata', 'otw', 'Proses Generate Data Biodata');
                            setTimeout(generateBiodata(id, data.template), 3000);
                        } else {
                            replaceIsi('generateWedding', 'error', 'Gagal!  ' + data.message);
                            enabledGenerate();
                        }
                    }
                });
            }
        }
        function generateBiodata(id, template) {
            if (id != "") {
                $.ajax({
                    url: "<?=base_url()?>Cetak/generateBiodata?id=" + id + "&template=" + template,
                    dataType: "JSON",
                    success: function (data) {
                        if (data.code == "200") {
                            replaceIsi('generateBiodata', 'ok', 'Prosess Generate Data Biodata Berhasil');
                            appendTable('generateFamily', 'otw', 'Proses Generate Data Keluarga');
                            setTimeout(generateFamily(id, data.template), 3000);
                        } else {
                            replaceIsi('generateBiodata', 'error', 'Gagal!  ' + data.message);
                            enabledGenerate();
                        }
                    }
                });
            }
        }
        function generateFamily(id, template) {
            if (id != "") {
                $.ajax({
                    url: "<?=base_url()?>Cetak/generateFamily?id=" + id + "&template=" + template,
                    dataType: "JSON",
                    success: function (data) {
                        if (data.code == "200") {
                            replaceIsi('generateFamily', 'ok', 'Prosess Generate Data Keluarga Berhasil');
                            appendTable('generateAcara', 'otw', 'Proses Generate Data Acara');
                            setTimeout(generateAcara(id, data.template), 3000);
                        } else {
                            replaceIsi('generateFamily', 'error', 'Gagal!  ' + data.message);
                            enabledGenerate();
                        }
                    }
                });
            }
        }
        function generateAcara(id, template) {
            if (id != "") {
                $.ajax({
                    url: "<?=base_url()?>Cetak/generateAcara?id=" + id + "&template=" + template,
                    dataType: "JSON",
                    success: function (data) {
                        if (data.code == "200") {
                            replaceIsi('generateAcara', 'ok', 'Prosess Generate Data Acara Berhasil');
                            appendTable('generateUpacara', 'otw', 'Proses Generate Data Upacara');
                            setTimeout(generateUpacara(id, data.template), 3000);
                        } else {
                            replaceIsi('generateAcara', 'error', 'Gagal!  ' + data.message);
                            enabledGenerate();
                        }
                    }
                });
            }
        }
        function generateUpacara(id, template) {
            if (id != "") {
                $.ajax({
                    url: "<?=base_url()?>Cetak/generateUpacara?id=" + id + "&template=" + template,
                    dataType: "JSON",
                    success: function (data) {
                        if (data.code == "200") {
                            replaceIsi('generateUpacara', 'ok', 'Prosess Generate Data Upacara Berhasil');
                            appendTable('generatePanitia', 'otw', 'Proses Generate Data Panitia');
                            setTimeout(generatePanitia(id, data.template), 3000);
                        } else {
                            replaceIsi('generateUpacara', 'error', 'Gagal!  ' + data.message);
                            enabledGenerate();
                        }
                    }
                });
            }
        }
        function generatePanitia(id, template) {
            if (id != "") {
                $.ajax({
                    url: "<?=base_url()?>Cetak/generatePanitia?id=" + id + "&template=" + template,
                    dataType: "JSON",
                    success: function (data) {
                        if (data.code == "200") {
                            replaceIsi('generatePanitia', 'ok', 'Prosess Generate Data Panitia Berhasil');
                            appendTable('generateTambahan', 'otw', 'Proses Generate Data Tambahan');
                            setTimeout(generateTambahan(id, data.template), 3000);
                        } else {
                            replaceIsi('generatePanitia', 'error', 'Gagal!  ' + data.message);
                            enabledGenerate();
                        }
                    }
                });
            }
        }
        function generateTambahan(id, template) {
            if (id != "") {
                $.ajax({
                    url: "<?=base_url()?>Cetak/generateTambahan?id=" + id + "&template=" + template,
                    dataType: "JSON",
                    success: function (data) {
//                        replaceIsi('generateTambahan', 'ok', 'Prosess Generate Data Tambahan Berhasil');
//                        enabledGenerate();
                        if (data.code == "200") {
                            replaceIsi('generateTambahan', 'ok', 'Prosess Generate Data Tambahan Berhasil');
                            appendTable('generateTambahan', 'download', '<b>Klik tombol download mengunduh file</b>');
                            enabledGenerate();
                            var file_path = '<?=base_url()?>files/output/' + data.template;
                            showDownload(file_path);
//                            var a = document.createElement('A');
//                            a.href = file_path;
//                            a.download = file_path.substr(file_path.lastIndexOf('/') + 1);
//                            document.body.appendChild(a);
//                            a.click();
//                            document.body.removeChild(a);
                        } else {
                            replaceIsi('generateTambahan', 'error', 'Gagal!  ' + data.message);
                            enabledGenerate();
                        }
                    }
                });
            }
        }
</script>