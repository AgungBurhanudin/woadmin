<?php
if (empty($data_user)) {
    $id = "";
    $company = "";
    $group = "";
    $user_real_name = "";
    $user_user_name = "";
    $user_email = "";
    $user_phone = "";
    $user_address = "";
    $user_desc = "";
    $user_foto = "";
} else {
    foreach ($data_user as $val) {
        $id = $val->user_id;
        $group = $val->user_group_id;
        $company = $val->user_company;
        $user_real_name = $val->user_real_name;
        $user_user_name = $val->user_user_name;
        $user_email = $val->user_email;
        $user_phone = $val->user_phone;
        $user_address = $val->user_address;
        $user_desc = $val->user_desc;
        $user_foto = $val->user_foto;
    }
}
?>
<main class="main">
    <!-- Breadcrumb-->
    <ol class="breadcrumb">
        <li class="breadcrumb-item">Master</li>
        <li class="breadcrumb-item">
            <a href="#">User</a>
        </li>
        <li class="breadcrumb-item active">Tambah</li>
        <!-- Breadcrumb Menu-->
    </ol>
    <div class="container-fluid">
        <div class="animated fadeIn">
            <!-- /.row-->
            <div class="row">
                <div class="col-md-12">
                    <form class="form-horizontal" action="<?= base_url() ?>User/savePassword" method="post" enctype="multipart/form-data">
                        <input type="hidden" name="id" id="id" value="<?= $id ?>">
                        <div class="card">
                            <div class="card-header">
                                <strong>Tambah Data</strong> User</div>
                            <div class="card-body ">
                                <div>
                                    <div class="col-md-6" style="float: left">
                                        <div class="form-group row">
                                            <label class="col-md-3 col-form-label" for="text-input">Password <span class="red">*</span></label>
                                            <div class="col-md-9">
                                                <input onkeyup="validationForm(this)" class="form-control" type="password" name="password" id="password" placeholder="Password">
                                                <span class="msg_form"></span>
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <label class="col-md-3 col-form-label" for="text-input">Konfirmasi Password <span class="red">*</span></label>
                                            <div class="col-md-9">
                                                <input onkeyup="validationForm(this)" class="form-control" type="password" name="repassword" id="repassword" placeholder="Konfirmasi Password" >
                                                <span class="msg_form"></span>
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <label class="col-md-3 col-form-label" for="text-input">Kirim Email ke pengguna <span class="red">*</span></label>
                                            <div class="col-md-9">
                                                <label>
                                                    <input type="checkbox" name="is_email" id="is_email" checked="checked" value=1> Ya
                                                </label>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="card-footer">
                                <button class="submit btn btn-sm btn-primary" type="submit" id="submit">
                                    <i class="fa fa-dot-circle-o"></i> Simpan</button>
                                <button class="btn btn-sm btn-danger" type="reset">
                                    <i class="fa fa-ban"></i> Reset</button>

                                <a href="<?= base_url() ?>User">
                                    <button type="button" class="btn btn-sm btn-warning"><i class="fa fa-back"></i> Cancel</button>
                                </a>
                            </div>
                        </div>
                </div>
                </form>
                <!-- /.col-->
            </div>
        </div>
    </div>
</main>
<script>
</script>
</div>