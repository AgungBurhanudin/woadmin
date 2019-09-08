<?php
if (empty($tambahan_tipe)) {
    $id = "";
    $nama = "";
} else {
    foreach ($tambahan_tipe as $val) {
        $id = $val->id;
        $nama = $val->nama_tambahan_paket;
    }
}
?>
<main class="main">
    <!-- Breadcrumb-->
    <ol class="breadcrumb">
        <li class="breadcrumb-item">
            <a href="<?= base_url() ?>Settings">Settings</a>
        </li>
        <li class="breadcrumb-item">
            <a href="<?= base_url() ?>Setting/Tambahan">Tambahan / Lampiran</a>
        </li>
        <li class="breadcrumb-item active">Tambah</li>
        <!-- Breadcrumb Menu-->
    </ol>
    <div class="container-fluid">
        <div class="animated fadeIn">
            <!-- /.row-->
            <div class="row">
                <div class="col-md-12">
                    <form class="form-horizontal" action="<?=base_url()?>Setting/Tambahan/simpan" method="post" enctype="multipart/form-data">
                        <input type="hidden" name="id" id="id" value="<?= $id ?>">
                        <div class="card">
                            <div class="card-header">
                                <strong>Tambah Data</strong> Paket Tambahan/Lampiran</div>
                            <div class="card-body">
                                <div class="form-group row">
                                    <label class="col-md-3 col-form-label" for="text-input">Nama Paket Tambahan/Lampiran</label>
                                    <div class="col-md-9">
                                        <input class="form-control" type="text" name="nama_tambahan_paket" id="nama_tambahan_paket" placeholder="Nama Paket Tambahan/Lampiran" required="required" value="<?= $nama ?>">
                                    </div>
                                </div>
                            </div>
                            <div class="card-footer">
                                <button class="btn btn-sm btn-primary" type="submit">
                                    <i class="fa fa-dot-circle-o"></i> Submit</button>
                                <button class="btn btn-sm btn-danger" type="reset">
                                    <i class="fa fa-ban"></i> Reset</button>

                                <a href="<?=base_url()?>Setting/Tambahan">
                                    <button type="button" class="btn btn-sm btn-warning"><i class="fa fa-back"></i> Cancel</button>
                                </a>
                            </div>
                        </div>

                    </form>
                </div>
                <!-- /.col-->
            </div>
        </div>
    </div>
</main>
</div>