<h2>Payment Vendor</h2>
<hr>
<br>
<h3>Di Bayarkan Oleh WO</h3>
<div id="dataPaymentVendor">
    <table class="table table-responsive-sm table-hover table-outline mb-0" id="tablePaymentVendor">
        <thead class="thead-light">
            <tr>
                <th style="width: 3%">No</th>
                <th>Nama Vendor</th>
                <th style="width: 15%">CP</th>
                <th style="width: 10%">Phone</th>
                <th style="width: 15%">Biaya</th>
                <th style="width: 15%">Status</th>
                <th style="width: 100px">Action</th>
            </tr>
            <tr>
                <td colspan="8">
                    <h5>Di  Bayarkan Oleh WO</h5>
                </td>
            </tr>
        </thead>
        <tbody>
            <?php
            $no = 1;
            $total = 0;
            if (!empty($vendor)) {
                foreach ($vendor as $val) {
                    if ($val->dibayaroleh == "wo") {
                        ?>
                        <tr>
                            <td><?= $no++ ?></td>
                            <td><?= $val->nama_vendor ?></td>
                            <td><?= $val->cp ?></td>
                            <td><?= $val->nohp_cp ?></td>
                            <td align="right"><?= number_format($val->biaya, 2) ?></td>
                            <td><?php
                                if ($val->status == 0) {
                                    echo "Belum Terbayar";
                                } else if ($val->status == 1) {
                                    echo "Menunggu konfirmasi";
                                } else if ($val->status == 2) {
                                    echo "Terbayar Sebagian";
                                } else if ($val->status == 3) {
                                    echo "Terbayar";
                                }
                                ?>
                            </td>
                            <td>
                                <?php
                                if ($val->status == 0) {
                                    ?>
                                    <a href="#" onclick="editPayment('<?= $val->id ?>')" class="btn btn-sm btn-success"><i class="fa fa-dollar"></i> Bayar</a>
                                    <?php
                                } else if ($val->status == 1) {
                                    ?>
                                    <a href="#" onclick="editPayment('<?= $val->id ?>')" class="btn btn-sm btn-warning"><i class="fa fa-eye"></i> Konfirmasi</a>
                                    <?php
                                } else if ($val->status == 2) {
                                    ?>
                                    <a href="#" onclick="editPayment('<?= $val->id ?>')" class="btn btn-sm btn-warning"><i class="fa fa-pencil"></i> Bayar Sisa</a>
                                    <?php
                                } else if ($val->status == 3) {
                                    ?>
                                    <a href="#" onclick="editPayment('<?= $val->id ?>')" class="btn btn-sm btn-primary"><i class="fa fa-pencil"></i> Edit</a>
                                    <?php
                                }
                                ?>

                            </td>
                        </tr>
                        <?php
                        $total += $val->biaya;
                    }
                }
            } else {
                echo "<tr><td colspan='7'>Payment Vendor Masih Kosong</td></tr>";
            }
            ?>
            <tr>
                <td colspan="4">Total</td>
                <td align="right"><?= number_format($total, 2) ?></td>
                <td></td>
                <td></td>
            </tr>
            <tr>
                <td colspan="8">
                    <h5>Di  Bayarkan Sendiri</h5>
                </td>
            </tr>
            <?php
            $no = 1;
            $total = 0;
            if (!empty($vendor)) {
                foreach ($vendor as $val) {
                    if ($val->dibayaroleh == "sendiri") {
                        ?>
                        <tr>
                            <td><?= $no++ ?></td>
                            <td><?= $val->nama_vendor ?></td>
                            <td><?= $val->cp ?></td>
                            <td><?= $val->nohp_cp ?></td>
                            <td align="right"><?= number_format($val->biaya, 2) ?></td>
                            <td><?php
                                if ($val->status == 0) {
                                    echo "Belum Terbayar";
                                } else if ($val->status == 1) {
                                    echo "Menunggu konfirmasi";
                                } else if ($val->status == 2) {
                                    echo "Terbayar";
                                }
                                ?>
                            </td>
                            <td>

                                <?php
                                if ($val->status == 0) {
                                    ?>
                                    <a href="#" onclick="editPayment('<?= $val->id ?>')" class="btn btn-sm btn-success"><i class="fa fa-dollar"></i> Bayar</a>
                                    <?php
                                } else if ($val->status == 1) {
                                    ?>
                                    <a href="#" onclick="editPayment('<?= $val->id ?>')" class="btn btn-sm btn-warning"><i class="fa fa-eye"></i> Konfirmasi</a>
                                    <?php
                                } else if ($val->status == 2) {
                                    ?>
                                    <a href="#" onclick="editPayment('<?= $val->id ?>')" class="btn btn-sm btn-warning"><i class="fa fa-pencil"></i> Bayar Sisa</a>
                                    <?php
                                } else if ($val->status == 3) {
                                    ?>
                                    <a href="#" onclick="editPayment('<?= $val->id ?>')" class="btn btn-sm btn-primary"><i class="fa fa-pencil"></i> Edit</a>
                                    <?php
                                }
                                ?>
                            </td>
                        </tr>
                        <?php
                        $total += $val->biaya;
                    }
                }
            } else {
                echo "<tr><td colspan='7'>Payment Vendor Masih Kosong</td></tr>";
            }
            ?>
        </tbody>
        <tfoot>
            <tr>
                <td colspan="4">Total</td>
                <td align="right"><?= number_format($total, 2) ?></td>
                <td></td>
                <td></td>
            </tr>
        </tfoot>
    </table>
</div>

<div class="modal fade" id="paymentModal" tabindex="-1" role="dialog" aria-labelledby="paymentModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">Payment Vendor</h4>
                <button class="close" type="button" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">×</span>
                </button>
            </div>
            <div class="modal-body">
                <form class="form-horizontal" action="#" id="formPaymentVendor" method="post">
                    <input type="hidden" class="id_wedding" name="id_wedding" value="<?= $id_wedding ?>">
                    <input type="hidden" name="id_payment_pengantin" id="id_payment_pengantin" value="">                    
                    <div class="form-group row">
                        <label class="col-md-3 col-form-label" for="hf-email">Nama Vendor</label>
                        <div class="col-md-9">
                            <input readonly="readonly" name="nama_vendor_payment" id="nama_vendor_payment" type="text" required="required" class="form-control" placeholder="" />
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-md-3 col-form-label">CP </label>
                        <div class="col-md-9">
                            <input readonly="readonly" name="cp_payment" id="cp_payment" type="text" required="required" class="form-control" />
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-md-3 col-form-label">No Telepone</label>
                        <div class="col-md-9">
                            <input readonly="readonly" name="nohp_payment" id="nohp_payment" onkeypress="return isNumberKey(event)" type="text" required="required" class="form-control" />
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-md-3 col-form-label">Biaya</label>
                        <div class="col-md-9">
                            <input readonly="readonly" name="biaya_payment" id="biaya_payment" type="text" required="required" class="form-control" />
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-md-3 col-form-label">Cara Bayar</label>
                        <div class="col-md-9">
                            <select class="form-control" name="cara" id="cara">
                                <option value="">-- Cara Pembayaran --</option>
                                <option value="CASH">CASH</option>
                                <option value="TRANSFER">TRANSFER</option>
                            </select>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-md-3 col-form-label">Di Bayarkan ke</label>
                        <div class="col-md-9">
                            <select class="form-control" name="dibayarke" id="dibayarke">
                                <option value="">-- Di Bayar ke --</option>
                                <option value="WO">WO</option>
                                <option value="VENDOR">VENDOR</option>
                            </select>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-md-3 col-form-label">Tanggal Pembayaran</label>
                        <div class="col-md-9">
                            <input name="tanggal_bayar" id="tanggal_bayar" type="text" required="required" class="form-control datepicker" />
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-md-3 col-form-label">Bukti Pembayaran</label>
                        <div class="col-md-9">
                            <input name="bukti" id="bukti" type="file" required="required" class="form-control" />
                            <br>
                            <span id="bukti_download"></span>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-md-3 col-form-label">Status Pembayaran</label>
                        <div class="col-md-9">
                            <select class="form-control" name="status_pembayaran" id="status_pembayaran">
                                <option value="">-- Status Pembayaran --</option>
                                <option value="0">Belum Terbayar</option>
                                <option value="1">Menunggu Konfirmasi</option>
                                <option value="2">Terbayar Sebagian</option>
                                <option value="3">Lunas</option>
                            </select>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-md-3 col-form-label"></label>
                        <div class="col-md-9">
                            <button class="btn btn-secondary" type="button" data-dismiss="modal">Tutup</button>
                            <button class="btn btn-primary" type="submit" onclick="simpanPaymentVendor()">Simpan</button>
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

    function simpanPaymentVendor() {
//        var formData = new FormData($("#formVendor")[0]);
//        var formData = $("#formVendor").serialize();
        $('#formPaymentVendor').validate({
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
                var formData = new FormData($("#formPaymentVendor")[0]);
                $.ajax({
                    type: 'POST',
                    url: '<?= base_url() ?>Wedding/payment',
                    processData: false,
                    contentType: false,
                    data: formData,
                    dataType: "JSON",
                    success: function (data) {
                        if (data.code == "200") {
                            swal("success", "Berhasil menambah pembayaran!");
                            $("#paymentModal").modal('hide');
                            $("#dataPaymentVendor").load(location.href + " #dataPaymentVendor");
                            document.getElementById("formPaymentVendor").reset();
                        } else {
                            swal("warning", "Gagal menambah pembayaran!");
                        }
                    }
                });
            }
        });
    }
    function editPayment(id) {
        document.getElementById("formVendor").reset();
        $.ajax({
            url: '<?= base_url() ?>Wedding/vendor/get?id=' + id,
            dataType: "JSON",
            success: function (data) {
                $("#paymentModal").modal('show');
                $("#id_payment_pengantin").val(data.id);
                $("#nama_vendor_payment").val(data.nama_vendor);
                $("#cp_payment").val(data.cp);
                $("#nohp_payment").val(data.nohp_cp);
                $("#biaya_payment").val(data.biaya);
                $("#bayar_oleh").val(data.dibayaroleh);
                $("#dibayarke").val(data.dibayarke);

                $("#cara").val(data.cara_pembayaran);
                $("#tanggal_bayar").val(data.tanggal_bayar);
                if (data.bukti != "" & data.bukti != null) {
                    $("#bukti_download").html("<a href='<?= base_url() ?>/files/bukti/" + data.bukti + "'>Download</a>");
                }
                $("#status_pembayaran").val(data.status);
            }
        });
    }
</script>