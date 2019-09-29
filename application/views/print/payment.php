<?php
echo "<pre>";
// print_r($data);
echo "</pre>";
?>
<h2>Daftar Pembayaran Vendor</h2>
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
        border-bottom: 1px solid #000;
        vertical-align: top;
    }
    </style>
<table width="100%" class="table table-bordered">
    <thead>
    <tr class="borderbottom">
        <td style="width:3%">No</td>
        <td style="width:15%">Vendor</td>
        <td>Nama Vendor</td>
        <td style="width:15%">CP</td>
        <td style="width:10%">No Hp</td>
        <td style="width:10%">Biaya</td>
        <td style="width:10%">Terbayar</td>
        <td style="width:10%">Kekurangan</td>
    </tr>
    </thead>
    <?php
$no = 1;
foreach ($data as $val) {
    ?>
    <tr class="borderbottom">
        <td><?=$no++?></td>
        <td><?=$val->nama_vendor ?></td>
        <td><?=$val->cp ?></td>
        <td><?=$val->nohp_cp ?></td>
        <td><?=$val->dibayaroleh ?></td>

    </tr>
    <?php
}
?>
</table>
