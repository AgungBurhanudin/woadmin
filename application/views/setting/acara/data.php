
<main class="main">
    <!-- Breadcrumb-->
    <ol class="breadcrumb">
        <li class="breadcrumb-item">
            <a href="<?= base_url() ?>Settings">Settings</a>
        </li>
        <li class="breadcrumb-item">
            <a href="#">Acara</a>
        </li>
        <li class="breadcrumb-item active">Data</li>
        <!-- Breadcrumb Menu-->
    </ol>
    <div class="container-fluid">
        <div class="animated fadeIn">
            <div class="row">
                <!-- /.col-->
                <div class="col-lg-12">

                    <a href="<?= base_url() ?>Setting/Acara/add">
                        <button type="button" class="btn btn-mini btn-primary"><i class="fa fa-plus"></i> Tambah Paket Acara</button>
                    </a>
                    <br><br>
                    <div class="card">
                        <div class="card-header">
                            <i class="fa fa-align-justify"></i> Data Paket Acara</div>
                        <div class="card-body">

                            <div class="col-md-6">
                                <form class="form-horizontal" action="<?= base_url() ?>Setting/Acara" method="get">
                                    <div class="form-group row">
                                        <label class="col-md-4 col-form-label" for="text-input">Nama Paket Acara</label>
                                        <div class="col-md-5">
                                            <input class="form-control" type="text" name="nama_acara" id="nama_acara" placeholder="Nama Paket Acara" value="<?= isset($key['nama_acara']) ? $key['nama_acara'] : '' ?>">
                                        </div>
                                    </div>
                                    <div class="form-group row " style="text-align:center">
                                        <div class="col-md-6">
                                            <button class="btn btn-sm btn-primary" type="submit" style="margin : 0 auto">
                                                <i class="fa fa-search"></i> Cari</button>
                                        </div>
                                    </div>
                                </form>
                            </div>
                            <div  id="data_acara_tipe">
                                <table class="table table-responsive-sm table-striped">
                                    <thead>
                                        <tr>
                                            <th style="width:30px">No</th>
                                            <th>Nama Paket Acara</th>
                                            <th style="width:80px">Urutan</th>
                                            <th style="width:180px">Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php
                                        $no = 1;
                                        foreach ($acara_tipe as $val) {
                                            ?>
                                            <tr>
                                                <td><?= $no++ ?></td>
                                                <td><?= $val->nama_acara ?></td>
                                                <td>
                                                    <input type="number" id="urutan_acara_<?= $val->id ?>" name="urutan_acara" size="50" style="width: 100px" onfocusout="saveUrutanAcara('<?= $val->id ?>')" value="<?= $val->urutan ?>">
                                                </td>
        <!--                                            <td>
                                                    <label class="switch switch-label switch-pill switch-success">
                                                        <input class="switch-input" type="checkbox" checked="">
                                                        <span class="switch-slider" data-checked="On" data-unchecked="Off"></span>
                                                    </label>
                                                </td>-->
                                                <td>
                                                    <a href="<?= base_url() ?>Setting/Acara/field?id=<?= $val->id ?>" class="btn btn-sm btn-success"><i class="fa fa-list"></i></a>
                                                    <a href="<?= base_url() ?>Setting/Acara/edit?id=<?= $val->id ?>" class="btn btn-sm btn-primary"><i class="fa fa-pencil"></i></a>
                                                    <a onclick="return confirm('Apakah anda yakin akan menghapus data ini?')" href="<?= base_url() ?>Setting/Acara/delete?id=<?= $val->id ?>" class="btn btn-sm btn-danger"><i class="fa fa-trash"></i></a>

                                                </td>
                                            </tr>
                                            <?php
                                        }
                                        ?>
                                    </tbody>
                                </table>
                            </div>
                            <i>Keterangan : </i><br>
                            <a href="#" class="btn btn-sm btn-success"><i class="fa fa-list"></i></a> Untuk mengedit field inputan didalam paket<br>
                            <a href="#" class="btn btn-sm btn-primary"><i class="fa fa-pencil"></i></a> Untuk mengedit nama paket<br>
                            <a href="#" class="btn btn-sm btn-danger"><i class="fa fa-trash"></i></a> Untuk menghapus data

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

    function saveUrutanAcara(id) {
        var urutan = $("#urutan_acara_" + id).val();
        $.ajax({
            url: "<?= base_url() ?>Setting/Acara/saveUrutanAcara",
            type: "POST",
            data: "id=" + id + "&urutan=" + urutan,
            dataType: "JSON",
            success: function (data) {
                $("#data_acara_tipe").load(location.href + " #data_acara_tipe");
//                $("#urutan_" + id).focus();
            }
        });
    }
</script>