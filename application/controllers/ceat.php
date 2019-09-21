<?php

    public function cetak() {
        echo "<pre>";
        echo ini_get('max_execution_time');
        echo ini_get('memory_limit');
//        ini_set('memory_limit', '1024M');
        $path_template = realpath(APPPATH . '../files/template/');
        $path_output = realpath(APPPATH . '../files/output/');
        $id = $_GET['id'];
        $wedding = $this->db->query("SELECT * FROM wedding WHERE id = '$id' ")->row();
        if (empty($wedding)) {
            echo "Data Not Found";
            exit();
        }
        $print = array();
        foreach ($wedding as $w => $val) {
            $print['{' . $w . '}'] = $val;
        }
        $company_id = $wedding->id_company;
        $company = $this->db->query("SELECT * FROM company WHERE id = '$company_id' ")->row();
        $pria = $this->db->query("SELECT * FROM pengantin WHERE id_wedding = '$id' AND gender = 'L' ")->row();

        foreach ($pria as $p => $val) {
            if (strpos($p, 'tanggal') !== false) {
                $val = DateToIndo($val);
            }
            $print['{' . $p . '_pria}'] = $val;
        }
        $wanita = $this->db->query("SELECT * FROM pengantin WHERE id_wedding = '$id' AND gender = 'P' ")->row();
        foreach ($wanita as $w => $val) {
            if (strpos($w, 'tanggal') !== false) {
                $val = DateToIndo($val);
            }
            $print['{' . $w . '_wanita}'] = $val;
        }


        //Paket Acara 
        
        $paket_upacara = $this->db->query("SELECT a.nama_field, a.nama_label, a.type, a.ukuran, b.value 
                    FROM upacara_field a
                    LEFT JOIN ( SELECT * FROM upacara_data WHERE id_wedding = '$id' ) b ON a.id = b.id_upacara_field")->result();
        $paket_panitia = $this->db->query("SELECT a.nama_field, a.nama_label, a.type, a.ukuran, b.value 
                    FROM panitia_field a
                    LEFT JOIN ( SELECT * FROM panitia_data WHERE id_wedding = '$id' ) b ON a.id = b.id_panitia_field")->result();
        $paket_tambahan = $this->db->query("SELECT a.nama_field, a.nama_label, a.type, a.ukuran, b.value 
                    FROM tambahan_field a
                    LEFT JOIN ( SELECT * FROM tambahan_data WHERE id_wedding = '$id' ) b ON a.id = b.id_tambahan_field")->result();

        if (!empty($paket_upacara)) {
            foreach ($paket_upacara as $pa => $val) {
                $nama_field = $val->nama_field;
                $type = $val->type;
                $ukuran = $val->ukuran;
                $value = $val->value;
                if ($type == "text" || $type == "textarea" || $type == "angka" || $type == "combobox") {
                    $tag = $nama_field;
                    $print['{' . $nama_field . '}'] = $value != "" ? $value : "";
                } else if ($type == "tanggal") {
                    $tag = $nama_field;
                    $print['{' . $nama_field . '}'] = $value != "" ? DateToIndo($value) : "";
                } else if ($type == "checkbox") {
                    $tag = $nama_field;
                    $print['{' . $nama_field . '}'] = $value != "" ? "Ada" : "Tidak Ada";
                } else if ($type == "addabletext") {
                    $ukurans = explode("||", $ukuran);
                    $values = json_decode($value, true);
                    for ($ii = 0; $ii < count($ukurans); $ii++) {
                        $tag = $nama_field . "." . str_replace(' ', '_', strtolower($ukurans[$ii]));
                        //echo $tag . "<br>";
                        if ($value != "" && !empty($values)) {
//                            for ($jj = 0; $jj < count($values); $jj++) {
                            foreach ($values as $jj => $val) {
                                $print['{' . $tag . '}'][] = isset($values[$jj][$ii]) ? $values[$jj][$ii] : "";
                            }
                        } else {
                            $print['{' . $tag . '}'][] = "";
                        }
                    }
                }
            }
        }
        if (!empty($paket_panitia)) {
            foreach ($paket_panitia as $pa => $val) {
                $nama_field = $val->nama_field;
                $type = $val->type;
                $ukuran = $val->ukuran;
                $value = $val->value;
                if ($type == "text" || $type == "textarea" || $type == "angka" || $type == "combobox") {
                    $tag = $nama_field;
                    $print['{' . $nama_field . '}'] = $value != "" ? $value : "";
                } else if ($type == "tanggal") {
                    $tag = $nama_field;
                    $print['{' . $nama_field . '}'] = $value != "" ? DateToIndo($value) : "";
                } else if ($type == "checkbox") {
                    $tag = $nama_field;
                    $print['{' . $nama_field . '}'] = $value != "" ? "Ada" : "Tidak Ada";
                } else if ($type == "addabletext") {
                    $ukurans = explode("||", $ukuran);
                    $values = json_decode($value, true);
                    for ($ii = 0; $ii < count($ukurans); $ii++) {
                        $tag = $nama_field . "." . str_replace(' ', '_', strtolower($ukurans[$ii]));
                        //echo $tag . "<br>";
                        if ($value != "" && !empty($values)) {
//                            for ($jj = 0; $jj < count($values); $jj++) {
                            foreach ($values as $jj => $val) {
                                $print['{' . $tag . '}'][] = isset($values[$jj][$ii]) ? $values[$jj][$ii] : "";
                            }
                        } else {
                            $print['{' . $tag . '}'][] = "";
                        }
                    }
                }
            }
        }
        if (!empty($paket_tambahan)) {
            foreach ($paket_tambahan as $pa => $val) {
                $nama_field = $val->nama_field;
                $type = $val->type;
                $ukuran = $val->ukuran;
                $value = $val->value;
                if ($type == "text" || $type == "textarea" || $type == "angka" || $type == "combobox") {
                    $tag = $nama_field;
                    $print['{' . $nama_field . '}'] = $value != "" ? $value : "";
                } else if ($type == "tanggal") {
                    $tag = $nama_field;
                    $print['{' . $nama_field . '}'] = $value != "" ? DateToIndo($value) : "";
                } else if ($type == "checkbox") {
                    $tag = $nama_field;
                    $print['{' . $nama_field . '}'] = $value != "" ? "Ada" : "Tidak Ada";
                } else if ($type == "addabletext") {
                    $ukurans = explode("||", $ukuran);
                    $values = json_decode($value, true);
                    for ($ii = 0; $ii < count($ukurans); $ii++) {
                        $tag = $nama_field . "." . str_replace(' ', '_', strtolower($ukurans[$ii]));
                        //echo $tag . "<br>";
                        if ($value != "" && !empty($values)) {
//                            for ($jj = 0; $jj < count($values); $jj++) {
                            foreach ($values as $jj => $val) {
                                $print['{' . $tag . '}'][] = isset($values[$jj][$ii]) ? $values[$jj][$ii] : "";
                            }
                        } else {
                            $print['{' . $tag . '}'][] = "";
                        }
                    }
                }
            }
        }

        if (isset($_GET['list'])) {
            echo "<pre>";
            print_r($print);
            exit();
        }
        $template = $company->template;
        if ($template == "") {
            echo "Template tidak ada, silahkan upload template lagi";
            exit();
        }
        $templateFile = $path_template . '/' . $template;
        $fileName = './files/output/Buku_Nikah_' . $id . '.xlsx';

        if (!file_exists($templateFile)) {
            echo "Template tidak di temukan, silahkan upload template lagi";
            exit();
        }
        $tanggal_nikah = strtotime($wedding->tanggal);
        $this->PhpExcelTemplator->saveToFile($templateFile, $fileName, $print);
        // $file = './files/output/'.$fileName.'.xlsx' ;
        header("location:.$fileName");
    }