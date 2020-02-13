<?php

// error_reporting(E_ALL);
// ini_set('display_errors', true);
// ini_set('display_startup_errors', true);
defined('BASEPATH') or exit('No direct script access allowed');
require_once dirname(__FILE__) . '/../libraries/PHPExcelTemplate/samples/Bootstrap.php';

defined('BASEPATH') or exit('No direct script access allowed');

class Cetak extends CI_Controller
{

    public function __construct()
    {
        parent::__construct();
        $this->load->model(array('wedding_model'));
        $this->load->library('form_validation');
        $this->PhpExcelTemplator = new alhimik1986\PhpExcelTemplator\PhpExcelTemplator;
        // checkToken();
    }

    public function cekEmail()
    {
        echo $this->wedding_model->sendEmail("agungburhanudinyusuf@gmail.com", "agung", "passwrod");
    }

    public function cetak()
    {
        echo "<pre>";
        // echo ini_get('max_execution_time');
        // echo ini_get('memory_limit');
        //        ini_set('memory_limit', '1024M');
        $path_template = realpath(APPPATH . '../files/template/');
        $path_output = realpath(APPPATH . '../files/temp/');
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

        //Ortu
        $ayahpria = $this->db->query("SELECT * FROM keluarga WHERE id_wedding = '$id' AND HUBUNGAN = 'AYAH' AND id_pengantin = 'pria'")->row();
        if (!empty($ayahpria)) {
            foreach ($ayahpria as $ap => $val) {
                $print['{' . $ap . '_ayah_pria}'] = $val;
            }
        } else {
            $print['{nama_ayah_pria}'] = "";
            $print['{no_hp_ayah_pria}'] = "";
        }
        $ibupria = $this->db->query("SELECT * FROM keluarga WHERE id_wedding = '$id' AND HUBUNGAN = 'IBU' AND id_pengantin = 'pria'")->row();
        if (!empty($ibupria)) {
            foreach ($ibupria as $ip => $val) {
                $print['{' . $ip . '_ibu_pria}'] = $val;
            }
        } else {
            $print['{nama_ibu_pria}'] = "";
            $print['{no_hp_ibu_pria}'] = "";
        }
        //Kakak Adik Kandung
        $default_row = 10;
        $kakak_pria = $this->db->query("SELECT * FROM keluarga WHERE id_wedding = '$id' AND HUBUNGAN = 'KAKAK' AND id_pengantin = 'pria'")->result();
        if (!empty($kakak_pria)) {
            foreach ($kakak_pria as $sp => $val) {
                $row = $sp + 1;
                $print['{nama_kakak_pria_' . $row . '}'] = $val->nama;
                $print['{no_hp_kakak_pria_' . $row . '}'] = $val->no_hp;
            }
            // echo count($kakak_pria);
            for ($ii = count($kakak_pria) + 1; $ii <= $default_row; $ii++) {
                $print['{nama_kakak_pria_' . $ii . '}'] = "";
                $print['{no_hp_kakak_pria_' . $ii . '}'] = "";
            }
        } else {
            for ($ii = 1; $ii <= $default_row; $ii++) {
                $print['{nama_kakak_pria_' . $ii . '}'] = "";
                $print['{no_hp_kakak_pria_' . $ii . '}'] = "";
            }
        }
        $adik_pria = $this->db->query("SELECT * FROM keluarga WHERE id_wedding = '$id' AND HUBUNGAN = 'ADIK' AND id_pengantin = 'pria'")->result();
        if (!empty($adik_pria)) {
            foreach ($adik_pria as $ap => $val) {
                $row = $ap + 1;
                $print['{nama_adik_pria_' . $row . '}'] = $val->nama;
                $print['{no_hp_adik_pria_' . $row . '}'] = $val->no_hp;
            }
            for ($ii = count($adik_pria) + 1; $ii <= $default_row; $ii++) {
                $print['{nama_adik_pria_' . $ii . '}'] = "";
                $print['{no_hp_adik_pria_' . $ii . '}'] = "";
            }
        } else {
            for ($ii = 1; $ii <= $default_row; $ii++) {
                $print['{nama_adik_pria_' . $ii . '}'] = "";
                $print['{no_hp_adik_pria_' . $ii . '}'] = "";
            }
        }

        //Kakak Adik IPAR

        $kakak_pria = $this->db->query("SELECT * FROM keluarga WHERE id_wedding = '$id' AND HUBUNGAN = 'KAKAK_IPAR' AND id_pengantin = 'pria'")->result();
        if (!empty($kakak_pria)) {
            foreach ($kakak_pria as $sp => $val) {
                $row = $sp + 1;
                $print['{nama_kakak_ipar_pria_' . $row . '}'] = $val->nama;
                $print['{no_hp_kakak_ipar_pria_' . $row . '}'] = $val->no_hp;
            }
            for ($ii = count($kakak_pria) + 1; $ii <= $default_row; $ii++) {
                $print['{nama_kakak_ipar_pria_' . $ii . '}'] = "";
                $print['{no_hp_kakak_ipar_pria_' . $ii . '}'] = "";
            }
        } else {
            for ($ii = 1; $ii <= $default_row; $ii++) {
                $print['{nama_kakak_ipar_pria_' . $ii . '}'] = "";
                $print['{no_hp_kakak_ipar_pria_' . $ii . '}'] = "";
            }
        }
        $adik_pria = $this->db->query("SELECT * FROM keluarga WHERE id_wedding = '$id' AND HUBUNGAN = 'ADIK_IPAR' AND id_pengantin = 'pria'")->result();
        if (!empty($adik_pria)) {
            foreach ($adik_pria as $ap => $val) {
                $row = $ap + 1;
                $print['{nama_adik_ipar_pria_' . $row . '}'] = $val->nama;
                $print['{no_hp_adik_ipar_pria_' . $row . '}'] = $val->no_hp;
            }
            for ($ii = count($adik_pria) + 1; $ii <= $default_row; $ii++) {
                $print['{nama_adik_ipar_pria_' . $ii . '}'] = "";
                $print['{no_hp_adik_ipar_pria_' . $ii . '}'] = "";
            }
        } else {
            for ($ii = 1; $ii <= $default_row; $ii++) {
                $print['{nama_adik_ipar_pria_' . $ii . '}'] = "";
                $print['{no_hp_adik_ipar_pria_' . $ii . '}'] = "";
            }
        }

        $ayahwanita = $this->db->query("SELECT * FROM keluarga WHERE id_wedding = '$id' AND HUBUNGAN = 'AYAH' AND id_pengantin = 'wanita'")->row();
        if (!empty($ayahwanita)) {
            foreach ($ayahwanita as $aw => $val) {
                $print['{' . $aw . '_ayah_wanita}'] = $val;
            }
        } else {
            $print['{nama_ayah_wanita}'] = "";
            $print['{no_hp_ayah_wanita}'] = "";
        }
        $ibuwanita = $this->db->query("SELECT * FROM keluarga WHERE id_wedding = '$id' AND HUBUNGAN = 'IBU' AND id_pengantin = 'wanita'")->row();
        if (!empty($ibuwanita)) {
            foreach ($ibuwanita as $iw => $val) {
                $print['{' . $iw . '_ibu_wanita}'] = $val;
            }
        } else {
            $print['{nama_ibu_wanita}'] = "";
            $print['{no_hp_ibu_wanita}'] = "";
        }

        //Kakak Adik Kandung
        $kakak_wanita = $this->db->query("SELECT * FROM keluarga WHERE id_wedding = '$id' AND HUBUNGAN = 'KAKAK' AND id_pengantin = 'wanita'")->result();
        // if (!empty($kakak_wanita)) {
        foreach ($kakak_wanita as $sp => $val) {
            $ii = $sp + 1;
            $print['{nama_kakak_wanita_' . $ii . '}'] = $val->nama;
            $print['{no_hp_kakak_wanita_' . $ii . '}'] = $val->no_hp;
        }
        for ($ii = count($kakak_wanita) + 1; $ii <= $default_row; $ii++) {
            $print['{nama_kakak_wanita_' . $ii . '}'] = "";
            $print['{no_hp_kakak_wanita_' . $ii . '}'] = "";
        }
        $adik_wanita = $this->db->query("SELECT * FROM keluarga WHERE id_wedding = '$id' AND HUBUNGAN = 'ADIK' AND id_pengantin = 'wanita'")->result();
        // if (!empty($adik_wanita)) {
        foreach ($adik_wanita as $ap => $val) {
            $ii = $ap + 1;
            $print['{nama_adik_wanita_' . $ii . '}'] = $val->nama;
            $print['{no_hp_adik_wanita_' . $ii . '}'] = $val->no_hp;
        }
        for ($ii = count($adik_wanita) + 1; $ii <= $default_row; $ii++) {
            $print['{nama_adik_wanita_' . $ii . '}'] = "";
            $print['{no_hp_adik_wanita_' . $ii . '}'] = "";
        }

        //Kakak Adik IPAR

        $kakak_wanita = $this->db->query("SELECT * FROM keluarga WHERE id_wedding = '$id' AND HUBUNGAN = 'KAKAK_IPAR' AND id_pengantin = 'wanita'")->result();
        // if (!empty($kakak_wanita)) {
        foreach ($kakak_wanita as $sp => $val) {
            $ii = $sp + 1;
            $print['{nama_kakak_ipar_wanita_' . $ii . '}'] = $val->nama;
            $print['{no_hp_kakak_ipar_wanita_' . $ii . '}'] = $val->no_hp;
        }
        for ($ii = count($kakak_wanita) + 1; $ii <= $default_row; $ii++) {
            $print['{nama_kakak_ipar_wanita_' . $ii . '}'] = "";
            $print['{no_hp_kakak_ipar_wanita_' . $ii . '}'] = "";
        }
        $adik_wanita = $this->db->query("SELECT * FROM keluarga WHERE id_wedding = '$id' AND HUBUNGAN = 'ADIK_IPAR' AND id_pengantin = 'wanita'")->result();
        // if (!empty($adik_wanita)) {
        foreach ($adik_wanita as $ap => $val) {
            $ii = $ap + 1;
            $print['{nama_adik_ipar_wanita_' . $ii . '}'] = $val->nama;
            $print['{no_hp_adik_ipar_wanita_' . $ii . '}'] = $val->no_hp;
        }
        for ($ii = count($adik_wanita) + 1; $ii <= $default_row; $ii++) {
            $print['{nama_adik_ipar_wanita_' . $ii . '}'] = "";
            $print['{no_hp_adik_ipar_wanita_' . $ii . '}'] = "";
        }

        //Paket Acara
        $paket_acara = $this->db->query("SELECT a.nama_field, a.nama_label, a.type, a.ukuran, b.value
                    FROM acara_field a
                    LEFT JOIN ( SELECT * FROM acara_data WHERE id_wedding = '$id' ) b ON a.id = b.id_acara_field")->result();
        $paket_upacara = $this->db->query("SELECT a.nama_field, a.nama_label, a.type, a.ukuran, b.value
                    FROM upacara_field a
                    LEFT JOIN ( SELECT * FROM upacara_data WHERE id_wedding = '$id' ) b ON a.id = b.id_upacara_field")->result();
        $paket_panitia = $this->db->query("SELECT a.nama_field, a.nama_label, a.type, a.ukuran, b.value
                    FROM panitia_field a
                    LEFT JOIN ( SELECT * FROM panitia_data WHERE id_wedding = '$id' ) b ON a.id = b.id_panitia_field")->result();
        $paket_tambahan = $this->db->query("SELECT a.nama_field, a.nama_label, a.type, a.ukuran, b.value
                    FROM tambahan_field a
                    LEFT JOIN ( SELECT * FROM tambahan_data WHERE id_wedding = '$id' ) b ON a.id = b.id_tambahan_field")->result();
        if (!empty($paket_acara)) {
            foreach ($paket_acara as $pa => $val) {
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
                    $rows = explode("#", $ukuran);
                    $row = 10;
                    if (count($rows) == 2) {
                        $ukurans = explode("||", $rows[1]);
                        $row = $rows[0];
                    } else {
                        $ukurans = explode("||", $ukuran);
                        $row = 10;
                    }
                    $values = json_decode($value, true);

                    for ($ii = 0; $ii < count($ukurans); $ii++) {
                        $tag = $nama_field . "." . str_replace(' ', '_', strtolower($ukurans[$ii]));
                        $tag = trim(preg_replace('/\s+/', '', $tag));
                        //echo $tag . "<br>";
                        $jj = 1;
                        if ($value != "" && !empty($values)) {
//                            for ($jj = 0; $jj < count($values); $jj++) {

                            foreach ($values as $key => $val) {
                                $print['{' . $tag . '_' . $jj . '}'] = isset($values[$key][$ii]) ? $values[$key][$ii] : "";
                                $jj++;
                            }
                        }
                        for ($kk = $jj; $kk <= $row; $kk++) {
                            $print['{' . $tag . '_' . $kk . '}'] = "";
                        }
                    }
                }
            }
        }
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
                    $rows = explode("#", $ukuran);
                    $row = 10;
                    if (count($rows) == 2) {
                        $ukurans = explode("||", $rows[1]);
                        $row = $rows[0];
                    } else {
                        $ukurans = explode("||", $ukuran);
                        $row = 10;
                    }
                    $values = json_decode($value, true);

                    for ($ii = 0; $ii < count($ukurans); $ii++) {
                        $tag = $nama_field . "." . str_replace(' ', '_', strtolower($ukurans[$ii]));
                        $tag = trim(preg_replace('/\s+/', '', $tag));
                        //echo $tag . "<br>";
                        $jj = 1;
                        if ($value != "" && !empty($values)) {
//                            for ($jj = 0; $jj < count($values); $jj++) {

                            foreach ($values as $key => $val) {
                                $print['{' . $tag . '_' . $jj . '}'] = isset($values[$key][$ii]) ? $values[$key][$ii] : "";
                                $jj++;
                            }
                        }
                        for ($kk = $jj; $kk <= $row; $kk++) {
                            $print['{' . $tag . '_' . $kk . '}'] = "";
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
                    $rows = explode("#", $ukuran);
                    $row = 10;
                    if (count($rows) == 2) {
                        $ukurans = explode("||", $rows[1]);
                        $row = $rows[0];
                    } else {
                        $ukurans = explode("||", $ukuran);
                        $row = 10;
                    }
                    $values = json_decode($value, true);

                    for ($ii = 0; $ii < count($ukurans); $ii++) {
                        $tag = $nama_field . "." . str_replace(' ', '_', strtolower($ukurans[$ii]));
                        $tag = trim(preg_replace('/\s+/', '', $tag));
                        //echo $tag . "<br>";
                        $jj = 1;
                        if ($value != "" && !empty($values)) {
//                            for ($jj = 0; $jj < count($values); $jj++) {

                            foreach ($values as $key => $val) {
                                $print['{' . $tag . '_' . $jj . '}'] = isset($values[$key][$ii]) ? $values[$key][$ii] : "";
                                $jj++;
                            }
                        }
                        for ($kk = $jj; $kk <= $row; $kk++) {
                            $print['{' . $tag . '_' . $kk . '}'] = "";
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
                    $rows = explode("#", $ukuran);
                    $row = 10;
                    if (count($rows) == 2) {
                        $ukurans = explode("||", $rows[1]);
                        $row = $rows[0];
                    } else {
                        $ukurans = explode("||", $ukuran);
                        $row = 10;
                    }
                    $values = json_decode($value, true);

                    for ($ii = 0; $ii < count($ukurans); $ii++) {
                        $tag = $nama_field . "." . str_replace(' ', '_', strtolower($ukurans[$ii]));
                        $tag = trim(preg_replace('/\s+/', '', $tag));
                        //echo $tag . "<br>";
                        $jj = 1;
                        if ($value != "" && !empty($values)) {
//                            for ($jj = 0; $jj < count($values); $jj++) {

                            foreach ($values as $key => $val) {
                                $print['{' . $tag . '_' . $jj . '}'] = isset($values[$key][$ii]) ? $values[$key][$ii] : "";
                                $jj++;
                            }
                        }
                        for ($kk = $jj; $kk <= $row; $kk++) {
                            $print['{' . $tag . '_' . $kk . '}'] = "";
                        }
                    }
                }
            }
        }
        $kategori = $this->db->query("SELECT a.nama_vendor,a.nohp_cp,a.cp,b.nama_kategori,b.tag FROM vendor_pengantin a LEFT JOIN kategori_vendor b ON a.id_kategori = b.id WHERE a.id_wedding = '$id' ")->result();

        $all = [];
        foreach ($kategori as $key => $val) {
            $tag = $val->tag;
            if ($tag == "") {
                $tag = trim(preg_replace('/\s+/', '', $val->nama_kategori));
            }

            $all[$tag][] = array(
                'nama' => $val->nama_vendor,
                'cp' => $val->cp,
                'nohp_cp' => $val->nohp_cp,
            );
        }
        $ii = 1;
        foreach ($all as $key => $value) {
            if(count($all[$key]) == 1){
                foreach ($all[$key] as $w => $val) {
                    $print['{' . $key . '.nama}'] = $val['nama'];
                    $print['{' . $key . '.cp}'] = $val['cp'];
                    $print['{' . $key . '.nphp_cp}'] = $val['nohp_cp'];
                }
            }else if(count($all[$key]) > 1){
                foreach ($all[$key] as $w => $val) {
                    $print['{' . $key . '_' . $ii . '.nama}'] = $val['nama'];
                    $print['{' . $key . '_' . $ii . '.cp}'] = $val['cp'];
                    $print['{' . $key . '_' . $ii . '.nphp_cp}'] = $val['nohp_cp'];
                }
            }else{
                $print['{' . $key . '.nama}'] = "";
                $print['{' . $key . '.cp}'] = "";
                $print['{' . $key . '.nphp_cp}'] = "";
            }
            $ii++;
        }
        $real_print = [];
        foreach ($print as $key => $val) {
            $key = trim(preg_replace('/\s+/', '', $key));
            $real_print[$key] = $val;
        }
        echo "<pre>";
        print_r($real_print);
        exit();
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

    public function generateWedding()
    {
        $id = $_GET['id'];
        if ($id == "") {
            $result['code'] = 400;
            echo json_encode($result);
            exit();
        }
        $path_template = realpath(APPPATH . '../files/template/');
        $path_output = realpath(APPPATH . '../files/temp/');
        $wedding = $this->db->query("SELECT * FROM wedding WHERE id = '$id' ")->row();
        if (empty($wedding)) {
            $result['code'] = 400;
            $result['message'] = "Data Not Found";
            echo json_encode($result);
            exit();
//            echo "Data Not Found";
            //            exit();
        }
        $print = array();
        foreach ($wedding as $w => $val) {
            $print['{' . $w . '}'] = $val;
        }
        $company_id = $wedding->id_company;
        $company = $this->db->query("SELECT * FROM company WHERE id = '$company_id' ")->row();
        $template = $company->template;
        if ($template == "") {
            $result['code'] = 400;
            $result['message'] = "Template tidak ada, silahkan upload template lagi";
            echo json_encode($result);
            exit();
        }
        $templateFile = $path_template . '/' . $template;
        $his = date('His');
        $fileName = './files/temp/Buku_Nikah_' . $id . '_' . $his . '.xlsx';
        if (!file_exists($templateFile)) {
            $result['code'] = 400;
            $result['message'] = "Template tidak ada, silahkan upload template lagi";
            echo json_encode($result);
            exit();
        }
        $tanggal_nikah = strtotime($wedding->tanggal);
        $real_print = [];
        foreach ($print as $key => $val) {
            $key = trim(preg_replace('/\s+/', '', $key));
            $real_print[$key] = $val;
        }

        $this->PhpExcelTemplator->saveToFile($templateFile, $fileName, $real_print);
        if (file_exists($fileName)) {
            $result['code'] = 200;
            $result['template'] = 'Buku_Nikah_' . $id . '_' . $his . '.xlsx';
            echo json_encode($result);
            exit();
        } else {
            $result['code'] = 400;
            echo json_encode($result);
            exit();
        }
    }

    public function generateBiodata()
    {
        if ((!isset($_GET['id']) && $_GET['id'] == "") || (!isset($_GET['template']) && $_GET['template'] == "")) {
            $result['code'] = 400;
            echo json_encode($result);
            exit();
        }
        $id = $_GET['id'];
        $template = $_GET['template'];

        $path_output = realpath(APPPATH . '../files/temp/');
        $pria = $this->db->query("SELECT * FROM pengantin WHERE id_wedding = '$id' AND gender = 'L' ")->row();
        $print = array();
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
        $his = date('His');
        $templateFile = $path_output . '/' . $template;
        $fileName = './files/temp/Buku_Nikah_' . $id . '_' . $his . '.xlsx';

        if (!file_exists($templateFile)) {
            $result['code'] = 400;
            $result['message'] = "Template tidak di temukan, silahkan upload template lagi";
            echo json_encode($result);
            exit();
        }
        $real_print = [];
        foreach ($print as $key => $val) {
            $key = trim(preg_replace('/\s+/', '', $key));
            $real_print[$key] = $val;
        }
        $this->PhpExcelTemplator->saveToFile($templateFile, $fileName, $real_print);
        if (file_exists($fileName)) {
            $result['code'] = 200;
            $result['template'] = 'Buku_Nikah_' . $id . '_' . $his . '.xlsx';
            echo json_encode($result);
            exit();
        } else {
            $result['code'] = 400;
            $result['message'] = "Process Generate Gagal";
            echo json_encode($result);
            exit();
        }
    }

    public function generateFamily()
    {

        if ((!isset($_GET['id']) && $_GET['id'] == "") || (!isset($_GET['template']) && $_GET['template'] == "")) {
            $result['code'] = 400;
            echo json_encode($result);
            exit();
        }
        $id = $_GET['id'];
        $template = $_GET['template'];

        $path_output = realpath(APPPATH . '../files/temp/');
        $print = array();

        //Ortu
        $ayahpria = $this->db->query("SELECT * FROM keluarga WHERE id_wedding = '$id' AND HUBUNGAN = 'AYAH' AND id_pengantin = 'pria'")->row();
        if (!empty($ayahpria)) {
            foreach ($ayahpria as $ap => $val) {
                $print['{' . $ap . '_ayah_pria}'] = $val;
            }
        } else {
            $print['{nama_ayah_pria}'] = "";
            $print['{no_hp_ayah_pria}'] = "";
        }
        $ibupria = $this->db->query("SELECT * FROM keluarga WHERE id_wedding = '$id' AND HUBUNGAN = 'IBU' AND id_pengantin = 'pria'")->row();
        if (!empty($ibupria)) {
            foreach ($ibupria as $ip => $val) {
                $print['{' . $ip . '_ibu_pria}'] = $val;
            }
        } else {
            $print['{nama_ibu_pria}'] = "";
            $print['{no_hp_ibu_pria}'] = "";
        }
        //Kakak Adik Kandung
        $default_row = 10;
        $kakak_pria = $this->db->query("SELECT * FROM keluarga WHERE id_wedding = '$id' AND HUBUNGAN = 'KAKAK' AND id_pengantin = 'pria'")->result();
        if (!empty($kakak_pria)) {
            foreach ($kakak_pria as $sp => $val) {
                $row = $sp + 1;
                $print['{nama_kakak_pria_' . $row . '}'] = $val->nama;
                $print['{no_hp_kakak_pria_' . $row . '}'] = $val->no_hp;
            }
            // echo count($kakak_pria);
            for ($ii = count($kakak_pria) + 1; $ii <= $default_row; $ii++) {
                $print['{nama_kakak_pria_' . $ii . '}'] = "";
                $print['{no_hp_kakak_pria_' . $ii . '}'] = "";
            }
        } else {
            for ($ii = 1; $ii <= $default_row; $ii++) {
                $print['{nama_kakak_pria_' . $ii . '}'] = "";
                $print['{no_hp_kakak_pria_' . $ii . '}'] = "";
            }
        }
        $adik_pria = $this->db->query("SELECT * FROM keluarga WHERE id_wedding = '$id' AND HUBUNGAN = 'ADIK' AND id_pengantin = 'pria'")->result();
        if (!empty($adik_pria)) {
            foreach ($adik_pria as $ap => $val) {
                $row = $ap + 1;
                $print['{nama_adik_pria_' . $row . '}'] = $val->nama;
                $print['{no_hp_adik_pria_' . $row . '}'] = $val->no_hp;
            }
            for ($ii = count($adik_pria) + 1; $ii <= $default_row; $ii++) {
                $print['{nama_adik_pria_' . $ii . '}'] = "";
                $print['{no_hp_adik_pria_' . $ii . '}'] = "";
            }
        } else {
            for ($ii = 1; $ii <= $default_row; $ii++) {
                $print['{nama_adik_pria_' . $ii . '}'] = "";
                $print['{no_hp_adik_pria_' . $ii . '}'] = "";
            }
        }

        //Kakak Adik IPAR

        $kakak_pria = $this->db->query("SELECT * FROM keluarga WHERE id_wedding = '$id' AND HUBUNGAN = 'KAKAK_IPAR' AND id_pengantin = 'pria'")->result();
        if (!empty($kakak_pria)) {
            foreach ($kakak_pria as $sp => $val) {
                $row = $sp + 1;
                $print['{nama_kakak_ipar_pria_' . $row . '}'] = $val->nama;
                $print['{no_hp_kakak_ipar_pria_' . $row . '}'] = $val->no_hp;
            }
            for ($ii = count($kakak_pria) + 1; $ii <= $default_row; $ii++) {
                $print['{nama_kakak_ipar_pria_' . $ii . '}'] = "";
                $print['{no_hp_kakak_ipar_pria_' . $ii . '}'] = "";
            }
        } else {
            for ($ii = 1; $ii <= $default_row; $ii++) {
                $print['{nama_kakak_ipar_pria_' . $ii . '}'] = "";
                $print['{no_hp_kakak_ipar_pria_' . $ii . '}'] = "";
            }
        }
        $adik_pria = $this->db->query("SELECT * FROM keluarga WHERE id_wedding = '$id' AND HUBUNGAN = 'ADIK_IPAR' AND id_pengantin = 'pria'")->result();
        if (!empty($adik_pria)) {
            foreach ($adik_pria as $ap => $val) {
                $row = $ap + 1;
                $print['{nama_adik_ipar_pria_' . $row . '}'] = $val->nama;
                $print['{no_hp_adik_ipar_pria_' . $row . '}'] = $val->no_hp;
            }
            for ($ii = count($adik_pria) + 1; $ii <= $default_row; $ii++) {
                $print['{nama_adik_ipar_pria_' . $ii . '}'] = "";
                $print['{no_hp_adik_ipar_pria_' . $ii . '}'] = "";
            }
        } else {
            for ($ii = 1; $ii <= $default_row; $ii++) {
                $print['{nama_adik_ipar_pria_' . $ii . '}'] = "";
                $print['{no_hp_adik_ipar_pria_' . $ii . '}'] = "";
            }
        }

        $ayahwanita = $this->db->query("SELECT * FROM keluarga WHERE id_wedding = '$id' AND HUBUNGAN = 'AYAH' AND id_pengantin = 'wanita'")->row();
        if (!empty($ayahwanita)) {
            foreach ($ayahwanita as $aw => $val) {
                $print['{' . $aw . '_ayah_wanita}'] = $val;
            }
        } else {
            $print['{nama_ayah_wanita}'] = "";
            $print['{no_hp_ayah_wanita}'] = "";
        }
        $ibuwanita = $this->db->query("SELECT * FROM keluarga WHERE id_wedding = '$id' AND HUBUNGAN = 'IBU' AND id_pengantin = 'wanita'")->row();
        if (!empty($ibuwanita)) {
            foreach ($ibuwanita as $iw => $val) {
                $print['{' . $iw . '_ibu_wanita}'] = $val;
            }
        } else {
            $print['{nama_ibu_wanita}'] = "";
            $print['{no_hp_ibu_wanita}'] = "";
        }

        //Kakak Adik Kandung
        $kakak_wanita = $this->db->query("SELECT * FROM keluarga WHERE id_wedding = '$id' AND HUBUNGAN = 'KAKAK' AND id_pengantin = 'wanita'")->result();
        // if (!empty($kakak_wanita)) {
        foreach ($kakak_wanita as $sp => $val) {
            $ii = $sp + 1;
            $print['{nama_kakak_wanita_' . $ii . '}'] = $val->nama;
            $print['{no_hp_kakak_wanita_' . $ii . '}'] = $val->no_hp;
        }
        for ($ii = count($kakak_wanita) + 1; $ii <= $default_row; $ii++) {
            $print['{nama_kakak_wanita_' . $ii . '}'] = "";
            $print['{no_hp_kakak_wanita_' . $ii . '}'] = "";
        }
        $adik_wanita = $this->db->query("SELECT * FROM keluarga WHERE id_wedding = '$id' AND HUBUNGAN = 'ADIK' AND id_pengantin = 'wanita'")->result();
        // if (!empty($adik_wanita)) {
        foreach ($adik_wanita as $ap => $val) {
            $ii = $ap + 1;
            $print['{nama_adik_wanita_' . $ii . '}'] = $val->nama;
            $print['{no_hp_adik_wanita_' . $ii . '}'] = $val->no_hp;
        }
        for ($ii = count($adik_wanita) + 1; $ii <= $default_row; $ii++) {
            $print['{nama_adik_wanita_' . $ii . '}'] = "";
            $print['{no_hp_adik_wanita_' . $ii . '}'] = "";
        }

        //Kakak Adik IPAR

        $kakak_wanita = $this->db->query("SELECT * FROM keluarga WHERE id_wedding = '$id' AND HUBUNGAN = 'KAKAK_IPAR' AND id_pengantin = 'wanita'")->result();
        // if (!empty($kakak_wanita)) {
        foreach ($kakak_wanita as $sp => $val) {
            $ii = $sp + 1;
            $print['{nama_kakak_ipar_wanita_' . $ii . '}'] = $val->nama;
            $print['{no_hp_kakak_ipar_wanita_' . $ii . '}'] = $val->no_hp;
        }
        for ($ii = count($kakak_wanita) + 1; $ii <= $default_row; $ii++) {
            $print['{nama_kakak_ipar_wanita_' . $ii . '}'] = "";
            $print['{no_hp_kakak_ipar_wanita_' . $ii . '}'] = "";
        }
        $adik_wanita = $this->db->query("SELECT * FROM keluarga WHERE id_wedding = '$id' AND HUBUNGAN = 'ADIK_IPAR' AND id_pengantin = 'wanita'")->result();
        // if (!empty($adik_wanita)) {
        foreach ($adik_wanita as $ap => $val) {
            $ii = $ap + 1;
            $print['{nama_adik_ipar_wanita_' . $ii . '}'] = $val->nama;
            $print['{no_hp_adik_ipar_wanita_' . $ii . '}'] = $val->no_hp;
        }
        for ($ii = count($adik_wanita) + 1; $ii <= $default_row; $ii++) {
            $print['{nama_adik_ipar_wanita_' . $ii . '}'] = "";
            $print['{no_hp_adik_ipar_wanita_' . $ii . '}'] = "";
        }

        $his = date('His');
        $templateFile = $path_output . '/' . $template;
        $fileName = './files/temp/Buku_Nikah_' . $id . '_' . $his . '.xlsx';

        if (!file_exists($templateFile)) {
            $result['code'] = 400;
            $result['message'] = "Template tidak di temukan, silahkan upload template lagi";
            echo json_encode($result);
            exit();
        }
        $real_print = [];
        foreach ($print as $key => $val) {
            $key = trim(preg_replace('/\s+/', '', $key));
            $real_print[$key] = $val;
        }
        $this->PhpExcelTemplator->saveToFile($templateFile, $fileName, $real_print);
        if (file_exists($fileName)) {
            $result['code'] = 200;
            $result['template'] = 'Buku_Nikah_' . $id . '_' . $his . '.xlsx';
            echo json_encode($result);
            exit();
        } else {
            $result['code'] = 400;
            $result['message'] = "Process Generate Gagal";
            echo json_encode($result);
            exit();
        }
    }

    public function generateAcara()
    {
        if ((!isset($_GET['id']) && $_GET['id'] == "") || (!isset($_GET['template']) && $_GET['template'] == "")) {
            $result['code'] = 400;
            echo json_encode($result);
            exit();
        }
        $id = $_GET['id'];
        $template = $_GET['template'];
        $print = array();
        $path_output = realpath(APPPATH . '../files/temp/');

        $paket_acara = $this->db->query("SELECT a.nama_field, a.nama_label, a.type, a.ukuran, b.value
                    FROM acara_field a
                    LEFT JOIN ( SELECT * FROM acara_data WHERE id_wedding = '$id' ) b ON a.id = b.id_acara_field")->result();
        if (!empty($paket_acara)) {
            foreach ($paket_acara as $pa => $val) {
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
                    $rows = explode("#", $ukuran);
                    $row = 10;
                    if (count($rows) == 2) {
                        $ukurans = explode("||", $rows[1]);
                        $row = $rows[0];
                    } else {
                        $ukurans = explode("||", $ukuran);
                        $row = 10;
                    }
                    $values = json_decode($value, true);

                    for ($ii = 0; $ii < count($ukurans); $ii++) {
                        $tag = $nama_field . "." . str_replace(' ', '_', strtolower($ukurans[$ii]));
                        $tag = trim(preg_replace('/\s+/', '', $tag));
                        //echo $tag . "<br>";
                        $jj = 1;
                        if ($value != "" && !empty($values)) {
//                            for ($jj = 0; $jj < count($values); $jj++) {

                            foreach ($values as $key => $val) {
                                $print['{' . $tag . '_' . $jj . '}'] = isset($values[$key][$ii]) ? $values[$key][$ii] : "";
                                $jj++;
                            }
                        }
                        for ($kk = $jj; $kk <= $row; $kk++) {
                            $print['{' . $tag . '_' . $kk . '}'] = "";
                        }
                    }
                }
            }
        }
        $his = date('His');
        $templateFile = $path_output . '/' . $template;
        $fileName = './files/temp/Buku_Nikah_' . $id . '_' . $his . '.xlsx';

        if (!file_exists($templateFile)) {
            $result['code'] = 400;
            $result['message'] = "Template tidak di temukan, silahkan upload template lagi";
            echo json_encode($result);
            exit();
        }
        $real_print = [];
        foreach ($print as $key => $val) {
            $key = trim(preg_replace('/\s+/', '', $key));
            $real_print[$key] = $val;
        }
        $this->PhpExcelTemplator->saveToFile($templateFile, $fileName, $real_print);
        if (file_exists($fileName)) {
            $result['code'] = 200;
            $result['template'] = 'Buku_Nikah_' . $id . '_' . $his . '.xlsx';
            echo json_encode($result);
            exit();
        } else {
            $result['code'] = 400;
            $result['message'] = "Process Generate Gagal";
            echo json_encode($result);
            exit();
        }
    }

    public function generateUpacara()
    {
        if ((!isset($_GET['id']) && $_GET['id'] == "") || (!isset($_GET['template']) && $_GET['template'] == "")) {
            $result['code'] = 400;
            echo json_encode($result);
            exit();
        }
        $id = $_GET['id'];
        $template = $_GET['template'];
        $print = array();
        $path_output = realpath(APPPATH . '../files/temp/');
        $paket_upacara = $this->db->query("SELECT a.nama_field, a.nama_label, a.type, a.ukuran, b.value
                    FROM upacara_field a
                    LEFT JOIN ( SELECT * FROM upacara_data WHERE id_wedding = '$id' ) b ON a.id = b.id_upacara_field")->result();
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
                    $rows = explode("#", $ukuran);
                    $row = 10;
                    if (count($rows) == 2) {
                        $ukurans = explode("||", $rows[1]);
                        $row = $rows[0];
                    } else {
                        $ukurans = explode("||", $ukuran);
                        $row = 10;
                    }
                    $values = json_decode($value, true);

                    for ($ii = 0; $ii < count($ukurans); $ii++) {
                        $tag = $nama_field . "." . str_replace(' ', '_', strtolower($ukurans[$ii]));
                        $tag = trim(preg_replace('/\s+/', '', $tag));
                        //echo $tag . "<br>";
                        $jj = 1;
                        if ($value != "" && !empty($values)) {
//                            for ($jj = 0; $jj < count($values); $jj++) {

                            foreach ($values as $key => $val) {
                                $print['{' . $tag . '_' . $jj . '}'] = isset($values[$key][$ii]) ? $values[$key][$ii] : "";
                                $jj++;
                            }
                        }
                        for ($kk = $jj; $kk <= $row; $kk++) {
                            $print['{' . $tag . '_' . $kk . '}'] = "";
                        }
                    }
                }
            }
        }
        $his = date('His');
        $templateFile = $path_output . '/' . $template;
        $fileName = './files/temp/Buku_Nikah_' . $id . '_' . $his . '.xlsx';

        if (!file_exists($templateFile)) {
            $result['code'] = 400;
            $result['message'] = "Template tidak di temukan, silahkan upload template lagi";
            echo json_encode($result);
            exit();
        }
        $real_print = [];
        foreach ($print as $key => $val) {
            $key = trim(preg_replace('/\s+/', '', $key));
            $real_print[$key] = $val;
        }
        $this->PhpExcelTemplator->saveToFile($templateFile, $fileName, $real_print);
        if (file_exists($fileName)) {
            $result['code'] = 200;
            $result['template'] = 'Buku_Nikah_' . $id . '_' . $his . '.xlsx';
            echo json_encode($result);
            exit();
        } else {
            $result['code'] = 400;
            $result['message'] = "Process Generate Gagal";
            echo json_encode($result);
            exit();
        }
    }

    public function generatePanitia()
    {
        if ((!isset($_GET['id']) && $_GET['id'] == "") || (!isset($_GET['template']) && $_GET['template'] == "")) {
            $result['code'] = 400;
            echo json_encode($result);
            exit();
        }
        $id = $_GET['id'];
        $template = $_GET['template'];
        $print = array();
        $path_output = realpath(APPPATH . '../files/temp/');
        $paket_panitia = $this->db->query("SELECT a.nama_field, a.nama_label, a.type, a.ukuran, b.value
                    FROM panitia_field a
                    LEFT JOIN ( SELECT * FROM panitia_data WHERE id_wedding = '$id' ) b ON a.id = b.id_panitia_field")->result();
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
                    $rows = explode("#", $ukuran);
                    $row = 10;
                    if (count($rows) == 2) {
                        $ukurans = explode("||", $rows[1]);
                        $row = $rows[0];
                    } else {
                        $ukurans = explode("||", $ukuran);
                        $row = 10;
                    }
                    $values = json_decode($value, true);

                    for ($ii = 0; $ii < count($ukurans); $ii++) {
                        $tag = $nama_field . "." . str_replace(' ', '_', strtolower($ukurans[$ii]));
                        $tag = trim(preg_replace('/\s+/', '', $tag));
                        //echo $tag . "<br>";
                        $jj = 1;
                        if ($value != "" && !empty($values)) {
//                            for ($jj = 0; $jj < count($values); $jj++) {

                            foreach ($values as $key => $val) {
                                $print['{' . $tag . '_' . $jj . '}'] = isset($values[$key][$ii]) ? $values[$key][$ii] : "";
                                $jj++;
                            }
                        }
                        for ($kk = $jj; $kk <= $row; $kk++) {
                            $print['{' . $tag . '_' . $kk . '}'] = "";
                        }
                    }
                }
            }
        }
        $his = date('His');
        $templateFile = $path_output . '/' . $template;
        $fileName = './files/temp/Buku_Nikah_' . $id . '_' . $his . '.xlsx';

        if (!file_exists($templateFile)) {
            $result['code'] = 400;
            $result['message'] = "Template tidak di temukan, silahkan upload template lagi";
            echo json_encode($result);
            exit();
        }
        $real_print = [];
        foreach ($print as $key => $val) {
            $key = trim(preg_replace('/\s+/', '', $key));
            $real_print[$key] = $val;
        }
        $this->PhpExcelTemplator->saveToFile($templateFile, $fileName, $real_print);
        if (file_exists($fileName)) {
            $result['code'] = 200;
            $result['template'] = 'Buku_Nikah_' . $id . '_' . $his . '.xlsx';
            echo json_encode($result);
            exit();
        } else {
            $result['code'] = 400;
            $result['message'] = "Process Generate Gagal";
            echo json_encode($result);
            exit();
        }
    }

    public function generateTambahan()
    {
        if ((!isset($_GET['id']) && $_GET['id'] == "") || (!isset($_GET['template']) && $_GET['template'] == "")) {
            $result['code'] = 400;
            echo json_encode($result);
            exit();
        }
        $id = $_GET['id'];
        $template = $_GET['template'];
        $print = array();
        $path_template = realpath(APPPATH . '../files/temp/');
        $path_output = realpath(APPPATH . '../files/output/');
        $paket_tambahan = $this->db->query("SELECT a.nama_field, a.nama_label, a.type, a.ukuran, b.value
                    FROM tambahan_field a
                    LEFT JOIN ( SELECT * FROM tambahan_data WHERE id_wedding = '$id' ) b ON a.id = b.id_tambahan_field")->result();
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
                    $rows = explode("#", $ukuran);
                    $row = 10;
                    if (count($rows) == 2) {
                        $ukurans = explode("||", $rows[1]);
                        $row = $rows[0];
                    } else {
                        $ukurans = explode("||", $ukuran);
                        $row = 10;
                    }
                    $values = json_decode($value, true);

                    for ($ii = 0; $ii < count($ukurans); $ii++) {
                        $tag = $nama_field . "." . str_replace(' ', '_', strtolower($ukurans[$ii]));
                        $tag = trim(preg_replace('/\s+/', '', $tag));
                        //echo $tag . "<br>";
                        $jj = 1;
                        if ($value != "" && !empty($values)) {
//                            for ($jj = 0; $jj < count($values); $jj++) {

                            foreach ($values as $key => $val) {
                                $print['{' . $tag . '_' . $jj . '}'] = isset($values[$key][$ii]) ? $values[$key][$ii] : "";
                                $jj++;
                            }
                        }
                        for ($kk = $jj; $kk <= $row; $kk++) {
                            $print['{' . $tag . '_' . $kk . '}'] = "";
                        }
                    }
                }
            }
        }
        $his = date('His');
        $templateFile = $path_template . '/' . $template;
        $fileName = './files/output/Buku_Nikah_' . $id . '.xlsx';

        if (!file_exists($templateFile)) {
            $result['code'] = 400;
            $result['message'] = "Template tidak di temukan, silahkan upload template lagi";
            echo json_encode($result);
            exit();
        }
        $real_print = [];
        foreach ($print as $key => $val) {
            $key = trim(preg_replace('/\s+/', '', $key));
            $real_print[$key] = $val;
        }
        $this->PhpExcelTemplator->saveToFile($templateFile, $fileName, $real_print);
        if (file_exists($fileName)) {
            $key4['id'] = $id;
            $data4['buku_nikah'] = 'Buku_Nikah_' . $id . '.xlsx';
            $this->db->update('wedding', $data4, $key4);
            $result['code'] = 200;
            $result['template'] = 'Buku_Nikah_' . $id . '.xlsx';
            echo json_encode($result);
            exit();
        } else {
            $result['code'] = 400;
            $result['message'] = "Process Generate Gagal";
            echo json_encode($result);
            exit();
        }
//        header("location:.$fileName");
        //        exit();
    }

    public function getHari($tanggal)
    {
        //fungsi mencari namahari
        //format $tgl YYYY-MM-DD
        //harviacode.com
        $tgl = substr($tanggal, 8, 2);
        $bln = substr($tanggal, 5, 2);
        $thn = substr($tanggal, 0, 4);
        $info = date('w', mktime(0, 0, 0, $bln, $tgl, $thn));
        switch ($info) {
            case '0':return "Minggu";
                break;
            case '1':return "Senin";
                break;
            case '2':return "Selasa";
                break;
            case '3':return "Rabu";
                break;
            case '4':return "Kamis";
                break;
            case '5':return "Jumat";
                break;
            case '6':return "Sabtu";
                break;
        };
    }

    public function generateVendor()
    {
        if ((!isset($_GET['id']) && $_GET['id'] == "") || (!isset($_GET['template']) && $_GET['template'] == "")) {
            $result['code'] = 400;
            echo json_encode($result);
            exit();
        }
        $id = $_GET['id'];
        $template = $_GET['template'];
        $print = array();
        $path_template = realpath(APPPATH . '../files/temp/');
        $path_output = realpath(APPPATH . '../files/output/');
        $kategori = $this->db->query("SELECT a.nama_vendor,a.nohp_cp,a.cp,b.nama_kategori,b.tag FROM vendor_pengantin a LEFT JOIN kategori_vendor b ON a.id_kategori = b.id WHERE a.id_wedding = '$id' ")->result();

        $all = [];
        foreach ($kategori as $key => $val) {
            $tag = $val->tag;
            if ($tag == "") {
                $tag = trim(preg_replace('/\s+/', '', $val->nama_kategori));
            }

            $all[$tag][] = array(
                'nama' => $val->nama_vendor,
                'cp' => $val->cp,
                'nohp_cp' => $val->nohp_cp,
            );
        }
        $ii = 1;
        foreach ($all as $key => $value) {
            if(count($all[$key]) == 1){
                foreach ($all[$key] as $w => $val) {
                    $print['{' . $key . '.nama}'] = $val['nama'];
                    $print['{' . $key . '.cp}'] = $val['cp'];
                    $print['{' . $key . '.nphp_cp}'] = $val['nohp_cp'];
                }
            }else if(count($all[$key]) > 1){
                foreach ($all[$key] as $w => $val) {
                    $print['{' . $key . '_' . $ii . '.nama}'] = $val['nama'];
                    $print['{' . $key . '_' . $ii . '.cp}'] = $val['cp'];
                    $print['{' . $key . '_' . $ii . '.nphp_cp}'] = $val['nohp_cp'];
                }
            }else{
                $print['{' . $key . '.nama}'] = "";
                $print['{' . $key . '.cp}'] = "";
                $print['{' . $key . '.nphp_cp}'] = "";
            }
            $ii++;
        }

        $his = date('His');
        $templateFile = $path_output . '/' . $template;
        $fileName = './files/temp/Buku_Nikah_' . $id . '_' . $his . '.xlsx';

        if (!file_exists($templateFile)) {
            $result['code'] = 400;
            $result['message'] = "Template tidak di temukan, silahkan upload template lagi";
            echo json_encode($result);
            exit();
        }
        $real_print = [];
        foreach ($print as $key => $val) {
            $key = trim(preg_replace('/\s+/', '', $key));
            $key = strtolower($tag);
            $real_print[$key] = $val;
        }
        $this->PhpExcelTemplator->saveToFile($templateFile, $fileName, $real_print);
        if (file_exists($fileName)) {
            $result['code'] = 200;
            $result['template'] = 'Buku_Nikah_' . $id . '_' . $his . '.xlsx';
            echo json_encode($result);
            exit();
        } else {
            $result['code'] = 400;
            $result['message'] = "Process Generate Gagal";
            echo json_encode($result);
            exit();
        }
    }

}
