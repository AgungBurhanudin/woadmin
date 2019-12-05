<style>
    .table_biasa {
        border-collapse: collapse;
    }

    .table_biasa, .table_biasa td,.table_biasa th {
        border: 1px solid #e7e7e7;
        padding: 5px;
    }
</style>
<h2>Payment Vendor</h2>
<hr>
<a href="<?= base_url() ?>Printout/printPayment?id=<?= $id_wedding ?>" target="_blank" style="float: right; margin-left:10px">
    <button type="button" class="btn btn-mini btn-success"><i class="fa fa-print"></i> Cetak Payment Vendor</button>
</a>
<br>
<div id="dataPaymentVendor">

    <table class="table table-responsive-sm table-hover table-outline mb-0" id="tablePaymentVendor">
        <thead class="thead-light">
            <tr>
                <th style="width: 3%">No</th>
                <th>Nama Vendor</th>
                <th style="width: 15%">CP</th>
                <th style="width: 10%">Phone</th>
                <th style="width: 15%">Biaya</th>
                <th style="width: 15%">Terbayar</th>
                <th style="width: 15%">Kekurangan</th>
            </tr>
        </thead>
    </table>
    <?php
    $no = 1;
    $total = 0;
    $total_terbayar = 0;
    if (!empty($vendor)) {
        foreach ($vendor as $val) {
            ?>
            <a href="#demo" data-toggle="collapse" style="width: 100%">
                <table class="table table-responsive-sm table-hover table-outline mb-0" id="tablePaymentVendor">            

                    <tr>
                        <th style="width: 3%; text-align: center"><?= $no++ ?></th>
                        <th><?= $val->nama_vendor ?></th>
                        <th style="width: 15%"><?= $val->cp ?></th>
                        <th style="width: 10%"><?= $val->nohp_cp ?></th>
                        <th style="width: 15%; text-align: right;"><?= number_format($val->biaya, 2) ?></th>
                        <th style="width: 15%; text-align: right;"><?= number_format($val->terbayar, 2) ?></th>
                        <th style="width: 15%; text-align: right;"><?= number_format($val->biaya - $val->terbayar, 2) ?></th>
                    </tr>
                </table>
            </a>
            <div id="demo" class="collapse" style="border-left: 1px solid #c8ced3;border-right: 1px solid #c8ced3; padding: 10px ">
                <b>History Pembayaran</b>
                <div style="float:right">
                    <a href="#" onclick="editPayment('<?= $val->id ?>')" class="btn btn-sm btn-success"><i class="fa fa-dollar"></i> Bayar</a>
                </div>
                <table style="width: 100%" class="table_biasa">
                    <tr>
                        <td style="width: 5%; text-align: center;">No</td>
                        <td style="width: 20%; text-align: center;">Tanggal Bayar</td>
                        <td style="width: 15%; text-align: center;">Cara Bayar</td>
                        <td style="width: 30%">Nominal</td>
                        <td style="width: 30%; text-align: center;">Status</td>
                        <td style="width: 10%; text-align: center;">Action</td>
                    </tr>
                    <?php
                    $i = 1;
                    $id = $val->id;
                    $detail = $this->db->query("SELECT * FROM payment WHERE id_vendor = '$id' ORDER BY tanggal_bayar ASC")->result();
                    foreach ($detail as $d) {
                        ?>
                        <tr>
                            <td style="text-align: center"><?= $i++ ?></td>
                            <td style="text-align: center"><?= DateToIndo($d->tanggal_bayar) ?></td>
                            <td style="text-align: center"><?= $d->cara_pembayaran ?></td>
                            <td style="text-align: right"><?= number_format($d->terbayar, 2) ?></td>
                            <td style="text-align: center">
                                <?php
                                if ($d->status == 0) {
                                    echo "MENUNGGU KONFIRMASI";
                                } else if ($d->status == 1) {
                                    echo "TERKONFIRMASI";
                                } else if ($d->status == 2) {
                                    echo "PEMBAYARAN GAGAL";
                                }
                                ?>
                            </td>
                            <td style="text-align: center">
                                <?php
                                if ($d->status == 0) {
                                    ?>
                                    <a href="#" onclick="confirmPayment('<?= $d->id ?>')">
                                        <button type="button" class="btn btn-mini btn-primary" title="Konfirmasi">
                                            <i class="fa fa-check"></i>
                                        </button>
                                    </a>
                                    <?php
                                }
                                ?>
                            </td>
                        </tr>
                        <?php
                    }
                    ?>
                </table>
            </div>
            <?php
            $total += $val->biaya;
            $total_terbayar += $val->terbayar;
        }
    } else {
        echo "<tr><td colspan='7'>Payment Vendor Masih Kosong</td></tr>";
    }
    ?>
    <table class="table table-responsive-sm table-hover table-outline mb-0">
        <tfoot>
            <tr>
                <th style="width: 3%"></th>
                <th><b>Total</b></th>
                <th style="width: 15%"></th>
                <th style="width: 10%"></th>
                <th style="width: 15%; text-align: right;"><b><?= number_format($total, 2) ?></b></th>
                <th style="width: 15%; text-align: right;"><b><?= number_format($total_terbayar, 2) ?></b></th>
                <th style="width: 15%; text-align: right;"><b><?= number_format($total - $total_terbayar, 2) ?></b></th>
            </tr>
        </tfoot>
    </table>
</div>
<div class="modal fade modal-lg" id="paymentModal" tabindex="-1" role="dialog" aria-labelledby="paymentModalLabel" aria-hidden="true">
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
                        <label class="col-md-3 col-form-label">Kekurangan</label>
                        <div class="col-md-9">
                            <input readonly="readonly" name="sisa" id="sisa" type="text" required="required" class="form-control" />
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-md-3 col-form-label">Total Pembayaran</label>
                        <div class="col-md-9">
                            <input name="terbayar" id="terbayar" type="number" required="required" class="form-control" />
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
                                
                                <option value="1">Terkonfirmasi</option>
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
                var sisa = parseInt(data.biaya) - parseInt(data.terbayar);
                $("#sisa").val(sisa);
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
    function confirmPayment(id) {
        $.ajax({
            url: '<?= base_url() ?>Wedding/confirmPayment?id=' + id,
            success: function (data) {
                swal("success", "Berhasil menambah pembayaran!");
                $("#paymentModal").modal('hide');
                $("#dataPaymentVendor").load(location.href + " #dataPaymentVendor");
                document.getElementById("formPaymentVendor").reset();
            }
        });
    }
</script>