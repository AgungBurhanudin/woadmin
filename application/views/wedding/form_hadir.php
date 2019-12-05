<h2>Daftar Hadir</h2>
<hr>
<br>
<br>
<div id="dataHadir">
    <table class="table table-responsive-sm table-hover table-outline mb-0 table-datatable" id="tableHadir">
        <thead class="thead-light">
            <tr>
                <th>No</th>
                <th>Nama Hadir</th>
                <th>Alamat</th>
                <th>Tipe Hadir</th>
                <th>Status</th>
            </tr>
        </thead>
        <tbody>
            <?php
            $no = 1;
            if (!empty($undangan)) {
                foreach ($undangan as $val) {
                    if ($val->status == 1) {
                        ?>
                        <tr>
                            <td><?= $no++ ?></td>
                            <td><?= $val->nama ?></td>
                            <td><?= $val->alamat ?></td>
                            <td><?= $val->tipe_undangan ?></td>
                            <td>
                                <?php
                                echo "<i class='fa fa-check'></i>";
                                ?>
                            </td>
                        </tr>
                        <?php
                    }
                }
            } else {
                echo "<tr><td colspan='7'>Daftar Hadir Masih Kosong</td></tr>";
            }
            ?>
        </tbody>
    </table>
</div>