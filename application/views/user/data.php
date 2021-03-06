
<main class="main">
    <!-- Breadcrumb-->
    <ol class="breadcrumb">
        <li class="breadcrumb-item">Master</li>
        <li class="breadcrumb-item">
            <a href="#">User</a>
        </li>
        <li class="breadcrumb-item active">Data</li>
        <!-- Breadcrumb Menu-->
    </ol>
    <div class="container-fluid">
        <div class="animated fadeIn">
            <div class="row">
                <!-- /.col-->
                <div class="col-lg-12">

                    <a href="<?= base_url() ?>User/add">
                        <button type="button" class="btn btn-mini btn-primary"><i class="fa fa-plus"></i> Tambah User (Khusus karyawan)</button>
                    </a>
                    <br><br>
                    <div class="card">
                        <div class="card-header">
                            <i class="fa fa-align-justify"></i> Data User</div>
                        <div class="card-body">
                            <form class="form-horizontal" action="<?= base_url() ?>User" method="post">
                                <div class="form-group row">
                                    <label class="col-md-3 col-form-label" for="text-input">Jenis User <span class="red">*</span></label>
                                    <div class="col-md-9">
                                        <select name="jenis_group" id="jenis_group" class="form-control" required="required">                                            
                                            <option value="0">Karyawan</option>
                                            <option value="1">Pengguna</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <div class="col-md-3"></div>
                                    <div class="col-md-9">
                                        <button type="submit" class="btn btn-sm btn-primary">
                                            <i class="fa fa-search"></i>
                                             Cari
                                        </button>
                                    </div>
                                </div>
                            </form>
                            <table class="table table-responsive-sm table-striped table-datatable">
                                <thead>
                                    <tr>
                                        <th style="width: 20px">No</th>
                                        <th>Nama</th>
                                        <th>Email</th>
                                        <th>Phone</th>
                                        <th>Aktif</th>
                                        <th style="width: 150px">Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                    $no = 1;
                                    foreach ($data as $val) {
                                        ?>
                                        <tr>
                                            <td><?= $no++ ?></td>
                                            <td><?= $val->user_real_name ?></td>
                                            <td><?= $val->user_email ?></td>
                                            <td><?= $val->user_phone ?></td>
                                            <td><?= $val->user_active == 1 ? "Aktif" : "Tidak Aktif" ?></td>
                                            <td nowrap="nowrap">
                                            <a href="<?= base_url() ?>User/password?id=<?= $val->user_id ?>" class="btn btn-sm btn-danger"><i class="fa fa-key"></i> Password</a>&nbsp;
                                                <?php
                                                if ($val->user_active == 1) {
                                                    ?>
                                                    <a href="<?= base_url() ?>User/nonaktif?id=<?= $val->user_id ?>" class="btn btn-sm btn-warning"><i class="fa fa-lock"></i> Nonaktifkan</a>
                                                    <a href="<?= base_url() ?>User/edit?id=<?= $val->user_id ?>" class="btn btn-sm btn-primary"><i class="fa fa-pencil"></i> Edit</a>
                                                    <!--<a href="#" onclick="swalConfirm('Apakah anda yakin akan menghapus data user?', '<?= base_url() ?>User/delete?id=<?= $val->user_id ?>')" class="btn btn-sm btn-danger"><i class="fa fa-trash"></i> Delete</a>-->

                                                    <?php
                                                } else {
                                                    ?>
                                                    <a href="<?= base_url() ?>User/aktif?id=<?= $val->user_id ?>" class="btn btn-sm btn-warning"><i class="fa fa-lock"></i> Aktifkan</a>
                                                    <a href="#" onclick="swalConfirm('Apakah anda yakin akan menghapus data user?', '<?= base_url() ?>User/delete?id=<?= $val->user_id ?>')" class="btn btn-sm btn-danger"><i class="fa fa-trash"></i> Delete</a>
                                                    <?php
                                                }
                                                ?>
                                            </td>
                                        </tr>
                                        <?php
                                    }
                                    ?>
                                </tbody>
                            </table>
                            <!-- <ul class="pagination">
                              <li class="page-item">
                                <a class="page-link" href="#">Prev</a>
                              </li>
                              <li class="page-item active">
                                <a class="page-link" href="#">1</a>
                              </li>
                              <li class="page-item">
                                <a class="page-link" href="#">2</a>
                              </li>
                              <li class="page-item">
                                <a class="page-link" href="#">3</a>
                              </li>
                              <li class="page-item">
                                <a class="page-link" href="#">4</a>
                              </li>
                              <li class="page-item">
                                <a class="page-link" href="#">Next</a>
                              </li>
                            </ul> -->
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
    $(function(){
        $("#jenis_group").val('<?= $jenis_group ?>');
    });
</script>
