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
    .table-print tr{
        border-bottom: 1px solid #000;
        vertical-align: top;
    }
    </style>
    <?php
$no = 1;
foreach ($data as $val) {
    ?><?php
    if (is_array($val['value'])) {
        ?><b><?=$val['label']?></b><hr><?php
        $ukuran = $val['ukuran'];
        echo "<table class='table-print'>";
        echo "<tr>";
        echo "<td style='width:3%'>No</td>";
        for($ii = 0; $ii < count($ukuran); $ii++){
            echo "<td>".$ukuran[$ii] ."</td>";
        }        
        echo "</tr>";
        $baris = 1;
        foreach($val['value'] as $key => $value){            
            echo "<tr>";
            echo "<td>". $baris++  ."</td>";
            for($ii = 0; $ii < count($value); $ii++){
                echo "<td>".$value[$ii] ."</td>";
            }    
            echo "</tr>";
        }
        echo "</table>";
    } else {
        echo "<table class='table-print'>";
        echo "<tr>";
        echo "<td>";
        echo $val['label'];
        echo "</td>";
        echo "<td>";
        echo $val['value'];
        echo "</td>";
        echo "</tr>";
        echo "</table>";
    }
    ?>
    <?php
}
?>
