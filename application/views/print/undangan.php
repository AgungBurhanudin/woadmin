<?php
echo "<pre>";
// print_r($data);
echo "</pre>";
?>
<h2>Daftar Undangan</h2>
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
<table width="100%" class="table-print">
    <thead>
    <tr class="borderbottom">
        <td style="width:3%">No</td>
        <td style="width:35%">Nama Undangan</td>
        <td>No Hp</td>
        <td style="width:35%">Alamat</td>
    </tr>
    </thead>
    <?php
$no = 1;
foreach ($data as $val) {
    ?>
    <tr class="borderbottom">
        <td><?=$no++?></td>
        <td><?=$val->nama ?></td>
        <td><?=$val->nohp ?></td>
        <td><?=$val->alamat ?></td>

    </tr>
    <?php
}
?>
</table>
