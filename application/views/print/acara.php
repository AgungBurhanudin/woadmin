<?php
echo "<pre>";
// print_r($data);
echo "</pre>";
?>
<h2><?=$title?></h2>
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
        <td style="width:47%"><?= isset($panitia) ? "Tugas" : "Kegiatan" ?></td>
        <td>Keterangan</td>
    </tr>
    </thead>
    <?php
$no = 1;
foreach ($data as $val) {
    ?>
    <tr class="borderbottom">
        <td><?=$no++?></td>
        <td><?=$val['label']?></td>
        <td><?php
    if (is_array($val['value'])) {
        echo "<table width='100%'>";
        $baris = 1;
        foreach($val['value'] as $val2){
            echo "<tr>";
            // echo "<td rowspan=2>". $baris++  ."</td>";
            echo "<td>".$val2['label'] . " : " .$val2['value']."</td>";
            echo "</tr>";
        }
        echo "</table>";
    } else {
        echo $val['value'];
    }
    ?></td>

    </tr>
    <?php
}
?>
</table>
