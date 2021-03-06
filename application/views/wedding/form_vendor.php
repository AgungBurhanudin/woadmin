<h2>Daftar Vendor</h2>
<hr>
<a href="#" onclick="addVendor()">
    <button type="button" class="btn btn-mini btn-primary"><i class="fa fa-plus"></i> Tambah Vendor</button>
</a>
<a href="<?= base_url() ?>Printout/printVendor?id=<?= $id_wedding ?>" target="_blank" style="float: right; margin-left:10px">
    <button type="button" class="btn btn-mini btn-success"><i class="fa fa-print"></i> Cetak Vendor</button>
</a>
<br>
<br>
<table class="table table-responsive-sm table-hover table-outline mb-0" id="tableDataVendor">
    <thead class="thead-light">
        <tr>
            <th>No</th>
            <th>Nama Vendor</th>
            <th>CP</th>
            <th>Phone</th>
            <th>Tipe Vendor</th>
            <th>Biaya</th>
            <th>Action</th>
        </tr>
    </thead>
    <tbody>
        <?php
        $no = 1;
        if (!empty($vendor)) {
            foreach ($vendor as $val) {
                ?>
                <tr>
                    <td><?= $no++ ?></td>
                    <td><?= $val->nama_vendor ?></td>
                    <td><?= $val->cp ?></td>
                    <td><?= $val->nohp_cp ?></td>
                    <td><?= $val->nama_kategori ?></td>
                    <td align="right"><?= number_format($val->biaya, 2) ?></td>
                    <td>
                        <a href="#" onclick="editVendor('<?= $val->id ?>')" class="btn btn-sm btn-primary"><i class="fa fa-pencil"></i> Edit</a>
                        <a href="#" onclick="deleteVendor('<?= $val->id ?>')" class="btn btn-sm btn-danger"><i class="fa fa-trash"></i> Delete</a>
                    </td>
                </tr>
                <?php
            }
        } else {
            echo "<tr><td colspan='7'>Data Jadwal Meeting Masih Kosong</td></tr>";
        }
        ?>
    </tbody>
</table>

<div class="modal fade" id="vendorModal" tabindex="-1" role="dialog" aria-labelledby="vendorModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">Form Vendor</h4>
                <button class="close" type="button" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">×</span>
                </button>
            </div>
            <div class="modal-body">
                <form class="form-horizontal" action="#" id="formVendor" method="post">
                    <input type="hidden" class="id_wedding" name="id_wedding" value="<?= $id_wedding ?>">
                    <input type="hidden" name="id_vendor_pengantin" id="id_vendor_pengantin" value="">
                    <div class="form-group row">
                        <label class="col-md-3 col-form-label">Kategori Vendor </label>
                        <div class="col-md-9">
                            <select class="form-control" name="kategori_vendor" id="kategori_vendor" onchange="getVendor(this.value)" style="width: 100%; height: 40px">
                                <option value="">-- Pilih Tipe Vendor --</option>
                                <?php
                                foreach ($kategori_vendor as $kv) {
                                    ?>
                                    <option value="<?= $kv->id ?>"><?= $kv->nama_kategori ?></option>
                                    <?php
                                }
                                ?>
                            </select>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-md-3 col-form-label">Vendor Yang Tersedia </label>
                        <div class="col-md-9">
                            <select class="form-control" name="vendor" id="vendorcombobox" onchange="setVendor(this.value)">
                                <option value="">

                            </select>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-md-3 col-form-label" for="hf-email">Nama Vendor</label>
                        <div class="col-md-9">
                            <input name="nama_vendor" id="nama_vendor" type="text" required="required" class="form-control" placeholder="" />
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-md-3 col-form-label">CP </label>
                        <div class="col-md-9">
                            <input name="cp" id="cp" type="text" required="required" class="form-control" />
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-md-3 col-form-label">No Telepone</label>
                        <div class="col-md-9">
                            <input name="nohp" id="nohp" onkeypress="return isNumberKey(event)" type="text" required="required" class="form-control" />
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-md-3 col-form-label">Biaya</label>
                        <div class="col-md-9">
                            <input name="biaya" id="biaya" type="number" required="required" class="form-control" />
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-md-3 col-form-label">Di Bayar oleh </label>
                        <div class="col-md-9">
                            <select class="form-control" name="bayar_oleh" id="bayar_oleh">
                                <option value="">-- Pilih Pembayaran --</option>
                                <option value="wo">Mahkota / Tiara</option>
                                <option value="sendiri">Langsung Ke Vendor</option>
                            </select>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-md-3 col-form-label"></label>
                        <div class="col-md-9">
                            <button class="btn btn-secondary" type="button" data-dismiss="modal">Tutup</button>
                            <button class="btn btn-primary" type="submit" onclick="simpanVendor()">Simpan</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
        <!-- /.modal-content-->
    </div>
    <!-- /.modal-dialog-->
</div>
<script>
    $(function () {
        $("#kategori_vendor").select2();
    });

    function addVendor() {
        document.getElementById("formVendor").reset();
        $("#formVendor")[0].reset();
        $('#formVendor').each(function () {
            this.reset();
        });
        $("#vendorModal").modal('show');
    }

    function getVendor(kategori) {
        $.ajax({
            url: "<?= base_url() ?>Combobox/vendor?kategori=" + kategori,
            success: function (data) {
                $("#vendorcombobox").html(data);
            }
        });
    }

    function setVendor(id) {
        $.ajax({
            url: "<?= base_url() ?>Combobox/getVendor?id=" + id,
            dataType: "JSON",
            success: function (data) {
                $("#nama_vendor").val(data.vendor);
                $("#cp").val(data.cp);
                $("#nohp").val(data.nohp_cp);
            }
        });
    }

    function simpanVendor() {
//        var formData = new FormData($("#formVendor")[0]);
//        var formData = $("#formVendor").serialize();
        $('#formVendor').validate({
            rules: {
                nama_vendor: {
                    required: true,
                    minlength: 2
                },
                bayar_oleh: "required"
            },
            messages: {
                nama_vendor: {
                    required: "Please enter a Nama Vendor",
                    minlength: "Nama Vendor minimal 2 karakter"
                },
                bayar_oleh: "Pilih Pembayaran"
            },
            submitHandler: function (form) {
                var formData = $("#formVendor").serialize();
                console.log(log);
                console.log(formData);
                $.ajax({
                    type: 'POST',
                    url: '<?= base_url() ?>Wedding/vendor/add',
                    data: formData,
                    dataType: "JSON",
                    success: function (data) {
                        if (data.code == "200") {
                            swal("success", "Berhasil menambah vendor!");
                            $("#vendorModal").modal('hide');
                            $("#tableDataVendor").load(location.href + " #tableDataVendor");
                            document.getElementById("formVendor").reset();
                            $("#formVendor")[0].reset();
                            $('#formVendor').each(function () {
                                this.reset();
                            });
                        } else {
                            swal("warning", "Gagal menambah vendor!");
                        }
                    }
                });
            }
        });
    }
    function deleteVendor(id) {
        if (confirm('Apakah anda yakin akan menghapus data ini?')) {
            $.ajax({
                url: '<?= base_url() ?>Wedding/vendor/delete?id=' + id,
                dataType: "JSON",
                success: function (data) {
                    if (data.code == "200") {
                        swal("success", "Berhasil menghapus vendor!");
                        $("#tableDataVendor").load(location.href + " #tableDataVendor");
                    } else {
                        swal("warning", "Gagal menghapus vendor!");
                    }
                }
            });
        }
    }
    function editVendor(id) {
        document.getElementById("formVendor").reset();
        $("#formVendor")[0].reset();
        $('#formVendor').each(function () {
            this.reset();
        });
        $.ajax({
            url: '<?= base_url() ?>Wedding/vendor/get?id=' + id,
            dataType: "JSON",
            success: function (data) {
                $("#vendorModal").modal('show');
                $("#id_vendor_pengantin").val(data.id);
                getVendor(data.id);
                $("#kategori_vendor").select2('val', data.id_kategori);
                setTimeout(function () {
                    $("#vendorcombobox").val(data.id_vendor);
                }, 1000);
                $("#nama_vendor").val(data.nama_vendor);
                $("#cp").val(data.cp);
                $("#nohp").val(data.nohp_cp);
                $("#biaya").val(data.biaya);
                $("#bayar_oleh").val(data.dibayaroleh);
            }
        });
    }
</script>