<div class="panel-body">
    <div id="addWedding">
        <div class="col-md-6" style="float: left">

            <div class="form-group">        
                <label class="control-label">Perusahaan <span class="red">*</span></label>
                <select name="user_company" id="user_company" class="form-control required">                      
                    <?php
                    $auth = $this->session->userdata('auth');
                    $group = $auth['group'];
                    if ($group == 1) {
                        echo "<option value=''>-- Pilih Perusahaan --</option>";
                    }
                    foreach ($data_company as $val) {
                        ?>
                        <option value="<?= $val->id ?>"><?= $val->nama ?></option>
                        <?php
                    }
                    ?>
                </select>
            </div>
            <div class="form-group">
                <label class="control-label">Judul Pernikahan</label>
                <input name="title" id="title" type="text" required="required" class="form-control required" placeholder="" />
            </div>
            <div class="form-group">
                <label class="control-label">Tanggal Pernikahan</label>
                <input name="tanggal_pernikahan" id="tanggal_pernikahan" type="text" required="required" class="form-control required datepicker-more" />                
            </div>
            <div class="form-group">
                <label class="control-label">Waktu Pernikahan</label>
                <input name="waktu_pernikahan" id="waktu_pernikahan" type="time" required="required" class="form-control required" />
            </div>
            <div class="form-group">
                <label class="control-label">Lokasi Pernikahan</label>
                <input name="lokasi_pernikahan" id="lokasi_pernikahan" type="text" required="required" class="form-control required" />
            </div>
            <div class="form-group">
                <label class="control-label">Alamat Lokasi Pernikahan</label>
                <input name="alamat_pernikahan" id="alamat_pernikahan" type="text" required="required" class="form-control required" />
            </div>
            <div class="form-group">
                <label class="control-label">Sistem Jamuan Pernikahan</label>
                <input name="tema_pernikahan" id="tema_pernikahan" type="text" required="required" class="form-control required" />
            </div>
            <div class="form-group">
                <label class="control-label">Hastag Pernikahan</label>
                <input name="hastag_pernikahan" id="hastag_pernikahan" type="text" required="required" class="form-control" />
            </div>
            <div class="form-group">
                <label class="control-label">Penyelenggara</label>

                <select class="form-control required" name="penyelenggara" id="penyelenggara">
                    <option value="">-- Pilih Penyelenggara --</option>
                    <option value="PRIA">Pihak Pria</option>
                    <option value="WANITA">Pihak Wanita</option>
                    <option value="KEDUA">Kedua Pihak</option>
                </select>
            </div>
            <div class="form-group">
                <label class="control-label">Jumlah Undangan</label>
                <input name="jumlah_undangan" id="jumlah_undangan" type="number" required="required" class="form-control required" />
            </div>
        </div>
        <div class="col-md-6" style="float: left">
            <div class="form-group">
                <label class="control-label">Nama Panggilan Pengantin Pria</label>
                <input name="nama_panggilan_pria" id="nama_panggilan_pria" type="text" required="required" class="form-control required" />
            </div>
            <div class="form-group">
                <label class="control-label">No Hp Pengantin Pria</label>
                <input name="no_hp_pria" id="no_hp_pria" onkeypress="return isNumberKey(event)" type="text" required="required" class="form-control required" />
            </div>
            <div class="form-group">
                <label class="control-label">Email Pengantin Pria</label>
                <input name="email_pria" id="email_pria" type="email" required="required" class="form-control required" />
            </div>
            <div class="form-group">
                <label class="control-label">Nama Panggilan Pengantin Wanita</label>
                <input name="nama_panggilan_wanita" id="nama_panggilan_wanita" type="text" required="required" class="form-control required" />
            </div>
            <div class="form-group">
                <label class="control-label">No Hp Pengantin Wanita</label>
                <input name="no_hp_wanita" id="no_hp_wanita" type="text" required="required" class="form-control required" />
            </div>
            <div class="form-group">
                <label class="control-label">Email Pengantin Wanita</label>
                <input name="email_wanita" id="email_wanita" type="email" required="required" class="form-control required" />
            </div>
            <div class="form-group" style="background:#e7e7e7">
                <label class="control-label">Nama PIC</label>
                <input name="nama_pic" id="nama_pic" type="text" required="required" class="form-control required" />
            </div>
            <div class="form-group" style="background:#e7e7e7">
                <label class="control-label">No WA PIC</label>
                <input name="wa_pic" id="wa_pic" type="text" required="required" class="form-control required" />
            </div>

        </div>
    </div>
    <div style="clear: both"></div>
    <button class="btn btn-primary nextBtn pull-right" type="button" onclick="moveStep('step-1', 'step-2', 'addWedding')">Next</button>
</div>