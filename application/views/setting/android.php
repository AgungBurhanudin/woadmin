<main class="main">
    <!-- Breadcrumb-->
    <ol class="breadcrumb">
        <li class="breadcrumb-item">Setting</li>
        <li class="breadcrumb-item active">
            <a href="#">Splash Screen</a>
        </li>
        <!-- Breadcrumb Menu-->
    </ol>
    <div class="container-fluid">
        <div class="animated fadeIn">
            <!-- /.row-->
            <div class="row">
                <div class="col-md-12">
                    <form class="form-horizontal" action="<?= base_url() ?>Settings/saveSplashScreen" method="post" enctype="multipart/form-data">
                        
                        <div class="card">
                            <div class="card-body">
                                <div class="form-group row">
                                    <label class="col-md-3 col-form-label" for="file-input">Splash Screen</label>
                                    <div class="col-md-9">
                                        <input id="file" type="file" name="file" required><br>
                                        <a href="<?= base_url() ?>files/splashscreen/<?= $splashscreen->setting_value ?>">
                                            <?= $splashscreen->setting_value ?>
                                        </a><br>
                                        <img src="<?= base_url() ?>files/splashscreen/<?= $splashscreen->setting_value ?>" width="200px">
                                    </div>
                                </div>
                            </div>
                            <div class="card-footer">
                                <button class="btn btn-sm btn-primary" type="submit">
                                    <i class="fa fa-dot-circle-o"></i> Submit</button>

                                <a href="<?= base_url() ?>Settings">
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