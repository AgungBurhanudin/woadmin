<h2>Galeri</h2>
<hr>

<!-- <a href="#" data-toggle="modal" data-target="#uploadGaleriModal">
    <button type="button" class="btn btn-mini btn-primary"><i class="fa fa-upload"></i> Add Lampiran</button>
</a> -->

<div class="clearfix"></div><br>
<div id="dataFormGaleri" class="col-sm-12" style="padding: 0">
    <?php
    if (empty($galeri)) {
        echo "<h3>Belum Ada Galeri</h3>";
    } else {
        foreach ($galeri as $l) {
            ?>
            <div class="col-md-4" style="float: left">
                <div class="card">
                    <div class="card-header"><?= $l->file ?>
                        <a href="#" onclick="deleteGaleri('<?= $l->id ?>')">
                            <span class="badge badge-pill badge-danger float-right"><i class="fa fa-close"></i> Delete</span>
                        </a>
                    </div>
                    <div class="card-body" style="padding: 0" onclick="viewImage('image_<?= $l->id ?>')">
                        <img  class="myImg" id="image_<?= $l->id ?>"  src="<?= base_url() ?>files/images/<?= $l->file ?>" width="100%">
                    </div>
                </div>
            </div>

            <?php
        }
    }
    ?>
</div>
