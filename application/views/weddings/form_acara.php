
<div style="float: right">
    <button type="button" class="btn btn-mini btn-dark"><i class="fa fa-pencil"></i> Edit Daftar Paket Acara</button>
</div>
<h2>Paket Acara</h2>
<hr>

<div class="col-md-12" style="padding: 0">
    <!--<div class="wrapper">-->
    <ul class="nav nav-tabs" role="tablist" id="tabAcara">
        <?php
        foreach ($acara as $val) {
            ?>
            <li class="nav-item" onclick="getFieldAcara('<?= $id_wedding ?>','<?= $val->id_field ?>')">
                <a class="nav-link" data-toggle="tab" href="#acara_<?= $val->id_field ?>" role="tab" aria-controls="acara_<?= $val->id ?>" aria-selected="true"><?= $val->nama_acara ?></a>
            </li>
            <?php
        }
        ?>
    </ul>
    <!--</div>-->
    <div class="tab-content">
        <?php
        foreach ($acara as $val) {
            ?>
            <div class="tab-pane" id="acara_<?= $val->id_field ?>" role="tabpanel">

            </div>
            <?php
        }
        ?>
    </div>
</div>
<script>
    function getFieldAcara(id_wedding, id) {
        $.ajax({
            url: "<?= base_url() ?>Wedding/acara/field?id=" + id + "&id_wedding=" + id_wedding,
            success: function (data) {
                $("#acara_" + id).html(data);
            }
        });
    }
</script>