<?php
echo "<pre>";
// print_r($data);
echo "</pre>";
?>
<h2>DATA PERNIKAHAN</h2>
<div style="float: right; position: absolute; right: 10px">
    <img src="<?= base_url() ?>files/images/lores_mahkota.png" height="50px">
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
    }
    </style>
<table width="100%" class="table-print">
    <tr>
        <td style="width:24%" class="borderbottom">Tanggal Acara</td>
        <td style="width:1%" class="borderbottom">:</td>
        <td style="width:24%" class="borderbottom"><?= DateToIndo($data->tanggal) ?></td>
        <td></td>
        <td style="width:24%" class="borderbottom">Hashtag Wedding</td>
        <td style="width:1%" class="borderbottom">:</td>
        <td style="width:24%" class="borderbottom"><?= $data->hashtag ?></td>
    </tr>
    <tr>
        <td class="borderbottom">Tempat Resepsi</td>
        <td class="borderbottom">:</td>
        <td colspan="5" class="borderbottom"><?= $data->tempat ?></td>
    </tr>
    <tr>
        <td class="borderbottom">Jam Undangan</td>
        <td class="borderbottom">:</td>
        <td class="borderbottom"><?= $data->waktu ?></td>
        <td></td>
        <td class="borderbottom">Jumlah Undangan</td>
        <td class="borderbottom">:</td>
        <td class="borderbottom"><?= $data->undangan ?> lembar</td>
    </tr>
    <tr class="borderbottom">
        <td>Sistem Jamuan</td>
        <td>:</td>
        <td colspan="5"><?= $data->tema ?></td>
    </tr>
    <tr class="borderbottom">
        <td>Diselenggarakan oleh</td>
        <td>:</td>
        <td colspan="5"><?= $data->penyelenggara ?></td>
    </tr>
</table>
