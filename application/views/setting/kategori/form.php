<?php
if (empty($data_kategori)) {
    $id = "";
    $kategori = "";
    $status = "1";
} else {
    foreach ($data_kategori as $val) {
        $id = $val->id;
        $kategori = $val->kategori;
        $status = $val->status;
    }
}
?>
<main class="main">
    <!-- Breadcrumb-->
    <ol class="breadcrumb">
        <li class="breadcrumb-item">Settings</li>
        <li class="breadcrumb-item">
            <a href="<?= base_url() ?>Setting/Kategori">Kategori</a>
        </li>
        <li class="breadcrumb-item active">Tambah</li>
        <!-- Breadcrumb Menu-->
    </ol>
    <div class="container-fluid">
        <div class="animated fadeIn">
            <!-- /.row-->
            <div class="row">
                <div class="col-md-12">
                    <form class="form-horizontal" action="<?=base_url()?>Setting/Kategori/save" method="post" enctype="multipart/form-data">
                        <input type="hidden" name="id" id="id" value="<?= $id ?>">
                        <div class="card">
                            <div class="card-header">
                                <strong>Tambah Data</strong> Kategori</div>
                            <div class="card-body">
                                <div class="form-group row">
                                    <label class="col-md-3 col-form-label" for="text-input">Nama Kategori</label>
                                    <div class="col-md-9">
                                        <input class="form-control" type="text" name="kategori" id="kategori" placeholder="Nama Kategori" required="required" value="<?= $kategori ?>">
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label class="col-md-3 col-form-label" for="text-input">Status Kategori</label>
                                    <div class="col-md-9">                                        
                                        <select name="status" id="status" class="form-control">
                                            <!-- <option value=""> -- Pilih Status --</option> -->
                                            <option value=1>Aktif</option>
                                            <option value=0>Tidak Aktif</option>
                                        </select>
                                    </div>
                                </div>
                            </div>
                            <div class="card-footer">
                                <button class="btn btn-sm btn-primary" type="submit">
                                    <i class="fa fa-dot-circle-o"></i> Submit</button>
                                <button class="btn btn-sm btn-danger" type="reset">
                                    <i class="fa fa-ban"></i> Reset</button>

                                <a href="<?=base_url()?>Setting/Kategori">
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
</div>
<script>
    $(function(){
        $("#status").val('<?= $status ?>');
    })
</script>