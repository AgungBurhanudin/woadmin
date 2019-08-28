
<main class="main">
    <!-- Breadcrumb-->
    <ol class="breadcrumb">
        <!-- <li class="breadcrumb-item">Home</li>
        <li class="breadcrumb-item">
          <a href="assets/#">Admin</a>
        </li> -->
        <li class="breadcrumb-item active">Dashboard</li>
        <!-- Breadcrumb Menu-->
    </ol>
    <div class="container-fluid">
        <div class="animated fadeIn">
            <!-- /.row-->
            <div class="row">
                <div class="col-md-12">
                    <div class="card">
                        <!--<div class="card-header">Persiapan Pernikahan yang aktif</div>-->
                        <div >
                            <!-- /.row-->
                            <br>
                            <table class="table table-responsive-sm table-hover table-outline mb-0">
                                <thead class="thead-light">
                                    <tr>
                                        <th class="text-center">
                                            <i class="icon-people"></i>
                                        </th>
                                        <th>Pengantin</th>
                                        <!--<th>Persiapan Status</th>-->
                                        <th class="text-center">Tanggal Pernikahan</th>
                                        <th>Aktifitas Terakhir</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                    if (empty($wedding)) {
                                        echo "<tr><td colspan='7'>Data Wedding kosong</td></tr>";
                                    } else {
                                        foreach ($wedding as $d) {
                                            ?>
                                            <tr>
                                                <td class="text-center" nowrap="nowarap">
                                                    <div class="avatar">
                                                        <img class="img-avatar" src="<?= base_url() ?>files/images/<?= $d->foto_pria != "" ? $d->foto_pria : "user.jpg" ?>" alt="<?= $d->nama_pria ?>">
                                                    </div>
                                                    <div class="avatar">
                                                        <img class="img-avatar" src="<?= base_url() ?>files/images/<?= $d->foto_wanita != "" ? $d->foto_wanita : "user.jpg" ?>" alt="<?= $d->nama_wanita ?>">
                                                    </div>
                                                </td>
                                                <td>
                                                    <div><?= $d->nama_pria ?> & <?= $d->nama_wanita ?></div>
                                                    <div class="small text-muted">
                                                        Registered: <?= $d->registration_date != "" ? DateToIndo($d->registration_date) : ""; ?></div>
                                                </td>
<!--                                                <td>
                                                    <div class="clearfix">
                                                        <div class="float-left">
                                                            <strong>50%</strong>
                                                        </div>
                                                        <div class="float-right">
                                                            <small class="text-muted">Jul 10, 2015</small>
                                                        </div>
                                                    </div>
                                                    <div class="progress progress-xs">
                                                        <div class="progress-bar bg-success" role="progressbar" style="width: 50%" aria-valuenow="50" aria-valuemin="0" aria-valuemax="100"></div>
                                                    </div>
                                                </td>-->
                                                <td class="text-center">
                                                    <strong><?= $d->tanggal != ""? DateToIndo($d->tanggal) : ""; ?></strong>
                                                </td>
                                                <td>
                                                    <div class="small text-muted"><?= $d->user_real_name ?> : <?= $d->deskripsi ?></div>
                                                    <strong><?= $d->datetime != "" ? DateToIndo($d->datetime) : ""; ?></strong>
                                                </td>
                                                <td>

                                                    <a href="<?= base_url() ?>Wedding/form?id=<?= $d->id ?>">
                                                        <button type="button" class="btn btn-primary btn-sm"><i class="fa fa-search"></i> </button>
                                                    </a>
                                                </td>
                                            </tr>
                                            <?php
                                        }
                                    }
                                    ?>

                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
                <!-- /.col-->
            </div>
            <!-- /.row-->
        </div>
    </div>
</main>
</div>
