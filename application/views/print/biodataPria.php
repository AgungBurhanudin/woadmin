<?php
echo "<pre>";
// print_r($data);
echo "</pre>";
?>
<h2>DATA BIODATA PENGANTIN PRIA</h2>
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
    <tr class="borderbottom">
        <td style="width:3%">01.</td>
        <td style="width:47%">Nama Lengkap</td>
        <td style="width:1%">:</td>
        <td><?= $data->nama_lengkap ?></td>
    </tr>
    <tr class="borderbottom">
        <td style="width:3%">02.</td>
        <td style="width:47%">Nama Panggilan</td>
        <td style="width:1%">:</td>
        <td><?= $data->nama_panggilan ?></td>
    </tr>
    <tr class="borderbottom">
        <td style="width:3%">03.</td>
        <td style="width:47%">Alamat Sekarang</td>
        <td style="width:1%">:</td>
        <td><?= $data->alamat_sekarang ?></td>
    </tr>
    <tr class="borderbottom">
        <td style="width:3%">04.</td>
        <td style="width:47%">Alamat setelah nikah</td>
        <td style="width:1%">:</td>
        <td><?= $data->alamat_nikah ?></td>
    </tr>
    <tr class="borderbottom">
        <td style="width:3%">05.</td>
        <td style="width:47%">Tempat / Tanggal Lahir</td>
        <td style="width:1%">:</td>
        <td><?= $data->tempat_lahir ?> / <?= $data->tanggal_lahir != "" ? DateToIndo($data->tanggal_lahir) : "" ?></td>
    </tr>
    <tr class="borderbottom">
        <td style="width:3%">06.</td>
        <td style="width:47%">Nomor HP / Whatsapp</td>
        <td style="width:1%">:</td>
        <td><?= $data->no_hp ?></td>
    </tr>
    <tr class="borderbottom">
        <td style="width:3%">07.</td>
        <td style="width:47%">Agama</td>
        <td style="width:1%">:</td>
        <td><?= $data->agama ?></td>
    </tr>
    <tr class="borderbottom">
        <td style="width:3%">08.</td>
        <td style="width:47%">Pendidikan terkahir</td>
        <td style="width:1%">:</td>
        <td><?= $data->pendidikan ?></td>
    </tr>
    <tr class="borderbottom">
        <td style="width:3%">09.</td>
        <td style="width:47%">Hobby</td>
        <td style="width:1%">:</td>
        <td><?= $data->hobi ?></td>
    </tr>
    <tr class="borderbottom">
        <td style="width:3%">10.</td>
        <td style="width:47%">Email</td>
        <td style="width:1%">:</td>
        <td><?= $data->email ?></td>
    </tr>
    <tr class="borderbottom">
        <td style="width:3%">11.</td>
        <td style="width:47%">Facebook</td>
        <td style="width:1%">:</td>
        <td><?= $data->sosmed ?></td>
    </tr>
    <tr class="borderbottom">
        <td style="width:3%">12.</td>
        <td style="width:47%">Instagram</td>
        <td style="width:1%">:</td>
        <td><?= $data->instagram ?></td>
    </tr>
</table>
