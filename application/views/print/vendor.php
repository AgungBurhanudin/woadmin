<?php
echo "<pre>";
// print_r($data);
echo "</pre>";
?>
<h2>Daftar Vendor</h2>
<div style="float: right; position: absolute; right: 10px">
    <img src="<?=base_url()?>files/images/lores_mahkota.png" height="50px">
</div>

<div style="width:100%; border-bottom:2px solid #000"></div>
<br>
<style>
    .table-print{
        width:100%;
    }
    .table-print td{
        padding : 7px;
    }
    .table-print .borderbottom{
        border: 1px solid #000;
        vertical-align: top;
    }
    </style>
<table width="100%" class="table table-bordered">
    <thead>
    <tr class="borderbottom">
        <th style="width:3%; text-align: center;">No</th>
        <th style="width:20%; text-align: center;">Vendor</th>
        <th style="width:20%; text-align: center;">Nama Vendor</th>
        <th style="width:20%; text-align: center;">CP</th>
        <th style="text-align: center;">No Hp</th>
        <th style="width:20%; text-align: center;">Keterangan</th>
    </tr>
    </thead>
    <?php
$no = 1;
foreach ($data as $val) {
    ?>
    <tr class="borderbottom">
        <td style="text-align: center;"><?=$no++?></td>
        <td><?=$val->nama_kategori ?></td>
        <td><?=$val->nama_vendor ?></td>
        <td><?=$val->cp ?></td>
        <td><?=$val->nohp_cp ?></td>
        <td><?=$val->dibayaroleh ?></td>

    </tr>
    <?php
}
?>
</table>
