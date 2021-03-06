<div class="panel-body">
    <div id="addWanita">
        <div class="col-md-6" style="float: left">
            <div class="form-group">
                <!--<label class="control-label">Foto</label>-->
                <!--<input name="nama_lengkap_pria" id="nama_lengkap_pria" type="file" required="required" class="form-control" placeholder="" />-->
                <!--<div class="col-sm-3" style="float: left"></div>-->
                <div class="col-sm-6 imgUp" style="margin: 0 auto;">
                    <div class="imagePreview"></div>
                    <label class="btn btn-upload btn-primary">
                        Foto Pengantin Wanita
                        <input type="file" name="foto_wanita" class="uploadFile img" value="Upload Photo" accept="image/png, image/jpeg, image/gif" style="width: 0px;height: 0px;overflow: hidden;">
                    </label>
                </div>
                <!--<div class="col-sm-3" style="float: left"></div>-->
            </div>
            <div class="form-group">
                <label class="control-label">Nama Lengkap Pengantin Wanita</label>
                <input name="nama_lengkap_wanita" id="nama_lengkap_wanita" type="text" required="required" class="form-control required" placeholder="" />
            </div>
            <div class="form-group">
                <label class="control-label">Nama Panggilan Pengantin Wanita</label>
                <input name="nama_panggilan_wanita" id="nama_panggilan_wanita" type="text" required="required" class="form-control required" />
            </div>
            <div class="form-group">
                <label class="control-label">Alamat Sekarang Pengantin Wanita</label>
                <input name="alamat_sekarang_wanita" id="alamat_sekarang_wanita" type="text" required="required" class="form-control" />
            </div>
            <div class="form-group">
                <label class="control-label">Alamat setelah nikah Pengantin Wanita</label>
                <input name="alamat_nikah_wanita" id="alamat_nikah_wanita" type="text" required="required" class="form-control" />
            </div>
        </div>
        <div class="col-md-6" style="float: left">
            <div class="form-group">
                <label class="control-label">Tempat Lahir Pengantin Wanita</label>
                <input name="tempat_lahir_wanita" id="tempat_lahir_wanita" type="text" required="required" class="form-control" />
            </div>

            <div class="form-group">
                <label class="control-label">Tanggal Lahir Pengantin Wanita</label>
                <input name="tanggal_lahir_wanita" id="tanggal_lahir_wanita" onkeypress="return isNumberKey(event)" type="text" max='<?= $today ?>' required="required" class="form-control required datepicker-less date-masked" />
            </div>
            <div class="form-group">
                <label class="control-label">No Hp Pengantin Wanita</label>
                <input name="no_hp_wanita" id="no_hp_wanita" type="text" required="required" class="form-control required" />
            </div>
            <div class="form-group">
                <label class="control-label">Email Pengantin Wanita</label>
                <input name="email_wanita" id="email_wanita" type="email" required="required" class="form-control required" />
            </div>
            <div class="form-group">
                <label class="control-label">Agama Pengantin Wanita</label>

<!--                <select class="form-control required" name="agama_wanita" id="agama_wanita">
                    <option value="">-- Pilih Agama --</option>
                    <option value="Islam">Islam</option>
                    <option value="Kristen">Kristen</option>
                    <option value="Katholik">Katholik</option>
                    <option value="Budha">Budha</option>
                    <option value="Hindu">Hindu</option>
                </select>-->
                <select name="agama_wanita" id="agama_wanita" class="form-control">
                    <option value=""> -- Pilih Agama --</option>
                    <?php
                    foreach ($data_agama as $val) {
                        ?>
                        <option value="<?= $val->agama ?>"><?= $val->agama ?></option>
                        <?php
                    }
                    ?>
                </select>
            </div>
            <div class="form-group">
                <label class="control-label">Pendidikan Pengantin Wanita</label>
                <input name="pendidikan_wanita" id="pendidikan_wanita" type="text" required="required" class="form-control" />
            </div>
            <div class="form-group">
                <label class="control-label">Hobi Pengantin Wanita</label>
                <input name="hobi_wanita" id="hobi_wanita" type="text" required="required" class="form-control" />
            </div>
            <div class="form-group">
                <label class="control-label">Akun Facebook Pengantin Wanita</label>
                <input name="sosmed_wanita" id="sosmed_wanita" type="text" required="required" class="form-control" />
            </div>
            <div class="form-group">
                <label class="control-label">Akun Instagram Pengantin Wanita</label>
                <input name="instagram_wanita" id="instagram_wanita" type="text" required="required" class="form-control" />
            </div>
        </div>
    </div>
    <button onclick="moveStep('step-3', 'step-4', 'addWanita')" class="btn btn-primary nextBtn pull-right" type="button">Next</button>    
</div>