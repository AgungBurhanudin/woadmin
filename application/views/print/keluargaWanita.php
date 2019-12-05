<?php
echo "<pre>";
// print_r($data);
echo "</pre>";
?>
<h2>DATA BIODATA KELUARGA PENGANTIN WANITA</h2>
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
        vertical-align: top;
    }
    </style>
<table width="100%" class="table-print">
    <tr class="borderbottom">
        <td style="width:3%;">01.</td>
        <td style="width:47%">Nama Ayah</td>
        <td style="width:1%">:</td>
        <td><?= $data['nama_ayah_wanita'] ?><br><?= $data['no_hp_ayah_wanita'] ?></td>
    </tr>
    <tr class="borderbottom">
        <td style="width:3%">02.</td>
        <td style="width:47%">Nama Ibu</td>
        <td style="width:1%">:</td>
        <td><?= $data['nama_ibu_wanita'] ?><br><?= $data['no_hp_ibu_wanita'] ?></td>
    </tr>
    <tr class="borderbottom">
        <td style="width:3%">03.</td>
        <td style="width:47%">Nama Kakak</td>
        <td style="width:1%">:</td>
        <td>
                <table style="width:100%"> 
            <?php
            foreach($kakak as $v){
                ?>
                    <tr>
                        <td><?= $v->nama ?><td>
                        <td>HP : <?= $v->no_hp ?><td>    
                    </tr>
                <?php
            }
            ?>
            </table>
        </td>
    </tr>
    <tr class="borderbottom">
        <td style="width:3%">04.</td>
        <td style="width:47%">Nama Kakak Ipar</td>
        <td style="width:1%">:</td>        
        <td>
            <table style="width:100%"> 
            <?php
            foreach($kakak_ipar as $v){
                ?>
                    <tr>
                        <td><?= $v->nama ?><td>
                        <td>HP : <?= $v->no_hp ?><td>    
                    </tr>
                <?php
            }
            ?>
            </table>
        </td>
    </tr>
    <tr class="borderbottom">
        <td style="width:3%">05.</td>
        <td style="width:47%">Adik</td>
        <td style="width:1%">:</td>
        
        <td>
            <table style="width:100%"> 
            <?php
            foreach($adik as $v){
                ?>
                    <tr>
                        <td><?= $v->nama ?><td>
                        <td>HP : <?= $v->no_hp ?><td>    
                    </tr>
                <?php
            }
            ?>
            </table>
        </td>
    </tr>
    <tr class="borderbottom">
        <td style="width:3%">06.</td>
        <td style="width:47%">Adik Ipar</td>
        <td style="width:1%">:</td>
        <td>
            <table style="width:100%"> 
            <?php
            foreach($adik_ipar as $v){
                ?>
                    <tr>
                        <td><?= $v->nama ?><td>
                        <td>HP : <?= $v->no_hp ?><td>    
                    </tr>
                <?php
            }
            ?>
            </table>
        </td>
    </tr>
</table>
