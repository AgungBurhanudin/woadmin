<main class="main">
    <!-- Breadcrumb-->
    <ol class="breadcrumb">
        <li class="breadcrumb-item">The Wedding</li>
        <li class="breadcrumb-item active">
            <a href="<?= base_url() ?>Wedding">Data Wedding</a>
        </li>
        <li class="breadcrumb-item active">Tambah Wedding Plan</li>
        <!-- Breadcrumb Menu-->
    </ol>
    <div class="container-fluid">
        <div class="animated fadeIn">
            <div class="row">
                <!-- /.col-->
                <div class="col-lg-12">
                    <div class="card">
                        <div class="card-header">
                            <i class="fa fa-align-justify"></i> Form Pendaftaran Wedding</div>
                        <div class="card-body">
                            <div class="container">
                                <div class="stepwizard">
                                    <div class="stepwizard-row setup-panel">
                                        <div class="stepwizard-step col-xs-3">
                                            <!--<a href="#step-1" class="active">-->
                                            <button onclick="moveTab('step-1', 'step-2', 'step-5')" id="btn_step-1" type="button" class="btn btn-success btn-circle">1</button>
                                            <!--</a>-->
                                            <p><small>Data Pernikahan</small></p>
                                        </div>
                                        <div class="stepwizard-step col-xs-3">
                                            <button onclick="moveTab('step-2', 'step-1', 'step-5')" id="btn_step-2" href="#step-2" type="button" class="btn btn-primary btn-circle" disabled="disabled">2</button>
                                            <p><small>Paket Pernikahan</small></p>
                                        </div>
                                        <div class="stepwizard-step col-xs-3">
                                            <button onclick="finish()" id="btn_step-5" href="#step-5" type="button" class="btn btn-primary btn-circle" disabled="disabled">3</button>
                                            <p><small>Selesai</small></p>
                                        </div>
                                    </div>
                                </div>
                                <hr>
                                <div id="form_daftar_wedding">
                                    <form method="POST" action="#" id="formWeddingRegister">
                                        <div class="active_form panel panel-primary setup-content" id="step-1">
                                            <?= $this->load->view('register/add_wedding') ?>
                                        </div>                                        
                                        <div class="hide panel panel-primary setup-content" id="step-2">
                                            <?= $this->load->view('register/add_paket') ?>
                                        </div>
                                        <div class="hide panel panel-primary setup-content" id="step-5">
                                            <?= $this->load->view('register/add_finish') ?>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- /.col-->
            </div>
        </div>
    </div>
</main>
</div>
<script>
    $(function () {
        $('.date-masked').mask('99-99-9999');
        $("#step-2").attr('class', 'hide');
        $(".required").on('focus', function () {
            $(this).removeAttr('style');
        });
    });

    function moveStep(from, to, id) {
        var valid = true;
        $("#" + id + " .required").each(function () {
            if ($(this).val() == "") {
                $(this).attr('style', 'border:1px solid red');
                valid = false;
            }
        });
        if (valid == true) {
            $("#btn_" + to).removeAttr('disabled');
            $("#btn_" + to).removeClass('btn-primary');
            $("#btn_" + to).addClass('btn-success');


            //        $("#btn_" + from).attr('disabled','disabled');
            //        $("#btn_" + from).removeClass('btn-success');
            //        $("#btn_" + from).addClass('btn-primary');

            $("#" + to).removeClass('hide');
            $("#" + to).addClass('active_form');

            $("#" + from).removeClass('active_form');
            $("#" + from).addClass('hide');
        }

    }

    function moveTab(tab, hideTab, hideTab4) {

        $("#" + tab).removeClass('hide');
        $("#" + tab).addClass('active_form');

        $("#" + hideTab).removeClass('active_form');
        $("#" + hideTab).addClass('hide');

        $("#" + hideTab2).removeClass('active_form');
        $("#" + hideTab2).addClass('hide');
    }

    function finish() {
        var to = "step-5";
        $("#btn_" + to).removeAttr('disabled');
        $("#btn_" + to).removeClass('btn-primary');
        $("#btn_" + to).addClass('btn-success');

        $("#" + to).removeClass('hide');
        $("#" + to).addClass('active_form');

        $("#step-2").removeClass('active_form');
        $("#step-2").addClass('hide');

        $("#step-1").removeClass('active_form');
        $("#step-1").addClass('hide');
    }

    function simpan() {
        $("#simpanWedding").html('Mohon tunggu...');
        $("#simpanWedding").attr('disabled', 'disabled');
        var formData = new FormData($("#formWeddingRegister")[0]);
        $.ajax({
            type: 'POST',
            url: '<?= base_url() ?>Register/save',
            processData: false,
            contentType: false,
            data: formData,
            dataType: "JSON",
            success: function (data) {
                if (data.code == "200") {
                    swal('success', "Berhasil");
                    window.location.href = "<?= base_url() ?>Wedding";
                } else {
                    swal('warning', "Gagal");
                }
            }
        });
    }
</script>