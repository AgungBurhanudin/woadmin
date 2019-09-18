<?php

error_reporting(E_ALL);
ini_set('display_errors', TRUE);
ini_set('display_startup_errors', TRUE);
defined('BASEPATH') or exit('No direct script access allowed');
require_once dirname(__FILE__) . '/../libraries/PHPExcelTemplate/samples/Bootstrap.php';

defined('BASEPATH') or exit('No direct script access allowed');

class Cetak extends CI_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->model(array('wedding_model'));
        $this->load->library('form_validation');
        $this->PhpExcelTemplator = new alhimik1986\PhpExcelTemplator\PhpExcelTemplator;
        checkToken();
    }

    public function cetak() {
        echo "<pre>";
        $path_template = realpath(APPPATH . '../files/template/');
        $path_output = realpath(APPPATH . '../files/output/');
        $id = $_GET['id'];
        $wedding = $this->db->query("SELECT * FROM wedding WHERE id = '$id' ")->row();

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
        $ayahpria = $this->db->query("SELECT * FROM keluarga WHERE id_wedding = '$id' AND HUBUNGAN = 'AYAH' AND id_pengantin = 'pria'")->row();
        foreach ($ayahpria as $ap => $val) {
            $print['{' . $ap . '_ayah_pria}'] = $val;
        }
        $ibupria = $this->db->query("SELECT * FROM keluarga WHERE id_wedding = '$id' AND HUBUNGAN = 'IBU' AND id_pengantin = 'pria'")->row();
        foreach ($ibupria as $ip => $val) {
            $print['{' . $ip . '_ibu_pria}'] = $val;
        }
        //Kakak Adik Kandung
        $kakak_pria = $this->db->query("SELECT * FROM keluarga WHERE id_wedding = '$id' AND HUBUNGAN = 'KAKAK' AND id_pengantin = 'pria'")->result();
        foreach ($kakak_pria as $sp => $val) {
            $print['[nama_kakak_pria]'][] = $val->nama;
            $print['[nohp_kakak_pria]'][] = $val->no_hp;
        }
        $adik_pria = $this->db->query("SELECT * FROM keluarga WHERE id_wedding = '$id' AND HUBUNGAN = 'ADIK' AND id_pengantin = 'pria'")->result();
        foreach ($adik_pria as $ap => $val) {
            $print['[nama_adik_pria]'][] = $val->nama;
            $print['[nohp_adik_pria]'][] = $val->no_hp;
        }

        //Kakak Adik IPAR

        $kakak_pria = $this->db->query("SELECT * FROM keluarga WHERE id_wedding = '$id' AND HUBUNGAN = 'KAKAK_IPAR' AND id_pengantin = 'pria'")->result();
        foreach ($kakak_pria as $sp => $val) {
            $print['[nama_kakak_ipar_pria]'][] = $val->nama;
            $print['[nohp_kakak_ipar_pria]'][] = $val->no_hp;
        }
        $adik_pria = $this->db->query("SELECT * FROM keluarga WHERE id_wedding = '$id' AND HUBUNGAN = 'ADIK_IPAR' AND id_pengantin = 'pria'")->result();
        foreach ($adik_pria as $ap => $val) {
            $print['[nama_adik_ipar_pria]'][] = $val->nama;
            $print['[nohp_adik_ipar_pria]'][] = $val->no_hp;
        }

        $ayahwanita = $this->db->query("SELECT * FROM keluarga WHERE id_wedding = '$id' AND HUBUNGAN = 'AYAH' AND id_pengantin = 'wanita'")->row();
        foreach ($ayahwanita as $aw => $val) {
            $print['{' . $aw . '_ayah_wanita}'] = $val;
        }
        $ibuwanita = $this->db->query("SELECT * FROM keluarga WHERE id_wedding = '$id' AND HUBUNGAN = 'IBU' AND id_pengantin = 'wanita'")->row();
        foreach ($ibuwanita as $iw => $val) {
            $print['{' . $iw . '_ibu_wanita}'] = $val;
        }

        //Kakak Adik Kandung
        $kakak_wanita = $this->db->query("SELECT * FROM keluarga WHERE id_wedding = '$id' AND HUBUNGAN = 'KAKAK' AND id_pengantin = 'wanita'")->result();
        foreach ($kakak_wanita as $sp => $val) {
            $print['[nama_kakak_wanita]'][] = $val->nama;
            $print['[nohp_kakak_wanita]'][] = $val->no_hp;
        }
        $adik_wanita = $this->db->query("SELECT * FROM keluarga WHERE id_wedding = '$id' AND HUBUNGAN = 'ADIK' AND id_pengantin = 'wanita'")->result();
        foreach ($adik_wanita as $ap => $val) {
            $print['[nama_adik_wanita]'][] = $val->nama;
            $print['[nohp_adik_wanita]'][] = $val->no_hp;
        }

        //Kakak Adik IPAR

        $kakak_wanita = $this->db->query("SELECT * FROM keluarga WHERE id_wedding = '$id' AND HUBUNGAN = 'KAKAK_IPAR' AND id_pengantin = 'wanita'")->result();
        foreach ($kakak_wanita as $sp => $val) {
            $print['[nama_kakak_ipar_wanita]'][] = $val->nama;
            $print['[nohp_kakak_ipar_wanita]'][] = $val->no_hp;
        }
        $adik_wanita = $this->db->query("SELECT * FROM keluarga WHERE id_wedding = '$id' AND HUBUNGAN = 'ADIK_IPAR' AND id_pengantin = 'wanita'")->result();
        foreach ($adik_wanita as $ap => $val) {
            $print['[nama_adik_ipar_wanita]'][] = $val->nama;
            $print['[nohp_adik_ipar_wanita]'][] = $val->no_hp;
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
                    $print['[' . $nama_field . ']'] = $value != "" ? $value : "";
                } else if ($type == "tanggal") {
                    $tag = $nama_field;
                    $print['[' . $nama_field . ']'] = $value != "" ? DateToIndo($value) : "";
                } else if ($type == "checkbox") {
                    $tag = $nama_field;
                    $print['[' . $nama_field . ']'] = $value != "" ? "Ada" : "Tidak Ada";
                } else if ($type == "addabletext") {
                    $ukurans = explode("||", $ukuran);
                    $values = json_decode($value, true);
                    for ($ii = 0; $ii < count($ukurans); $ii++) {
                        $tag = $nama_field . "." . str_replace(' ', '_', strtolower($ukurans[$ii]));
                        //echo $tag . "<br>";
                        for ($jj = 0; $jj < count($values); $jj++) {
                            $print['[' . $tag . ']'][] = isset($values[$jj][$ii]) ? $values[$jj][$ii] : "";
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
                    $print['[' . $nama_field . ']'] = $value != "" ? $value : "";
                } else if ($type == "tanggal") {
                    $tag = $nama_field;
                    $print['[' . $nama_field . ']'] = $value != "" ? DateToIndo($value) : "";
                } else if ($type == "checkbox") {
                    $tag = $nama_field;
                    $print['[' . $nama_field . ']'] = $value != "" ? "Ada" : "Tidak Ada";
                } else if ($type == "addabletext") {
                    $ukurans = explode("||", $ukuran);
                    $values = json_decode($value, true);
                    for ($ii = 0; $ii < count($ukurans); $ii++) {
                        $tag = $nama_field . "." . str_replace(' ', '_', strtolower($ukurans[$ii]));
                        //echo $tag . "<br>";
                        for ($jj = 0; $jj < count($values); $jj++) {
                            $print['[' . $tag . ']'][] = isset($values[$jj][$ii]) ? $values[$jj][$ii] : "";
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
                    $print['[' . $nama_field . ']'] = $value != "" ? $value : "";
                } else if ($type == "tanggal") {
                    $tag = $nama_field;
                    $print['[' . $nama_field . ']'] = $value != "" ? DateToIndo($value) : "";
                } else if ($type == "checkbox") {
                    $tag = $nama_field;
                    $print['[' . $nama_field . ']'] = $value != "" ? "Ada" : "Tidak Ada";
                } else if ($type == "addabletext") {
                    $ukurans = explode("||", $ukuran);
                    $values = json_decode($value, true);
                    for ($ii = 0; $ii < count($ukurans); $ii++) {
                        $tag = $nama_field . "." . str_replace(' ', '_', strtolower($ukurans[$ii]));
                        //echo $tag . "<br>";
                        for ($jj = 0; $jj < count($values); $jj++) {
                            $print['[' . $tag . ']'][] = isset($values[$jj][$ii]) ? $values[$jj][$ii] : "";
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
                    $print['[' . $nama_field . ']'] = $value != "" ? $value : "";
                } else if ($type == "tanggal") {
                    $tag = $nama_field;
                    $print['[' . $nama_field . ']'] = $value != "" ? DateToIndo($value) : "";
                } else if ($type == "checkbox") {
                    $tag = $nama_field;
                    $print['[' . $nama_field . ']'] = $value != "" ? "Ada" : "Tidak Ada";
                } else if ($type == "addabletext") {
                    $ukurans = explode("||", $ukuran);
                    $values = json_decode($value, true);
                    for ($ii = 0; $ii < count($ukurans); $ii++) {
                        $tag = $nama_field . "." . str_replace(' ', '_', strtolower($ukurans[$ii]));
                        //echo $tag . "<br>";
                        for ($jj = 0; $jj < count($values); $jj++) {
                            $print['[' . $tag . ']'][] = isset($values[$jj][$ii]) ? $values[$jj][$ii] : "";
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
        $params = [
            '{hari}' => $this->getHari($wedding->tanggal),
            '{waktu}' => date('d', $tanggal_nikah),
            '{tanggal}' => date('d', $tanggal_nikah),
            '{bulan}' => date('m', $tanggal_nikah),
            '{tahun}' => date('Y', $tanggal_nikah),
            '{tanggal_indo}' => DateToIndo($wedding->tanggal),
            '{nama_pria}' => $pria->nama_lengkap,
            '{nama_wanita}' => $wanita->nama_lengkap,
            '[date]' => [
                '01-06-2018',
                '02-06-2018',
                '03-06-2018',
                '04-06-2018',
                '05-06-2018',
            ],
            '[code]' => [
                '0001543',
                '0003274',
                '000726',
                '0012553',
                '0008245',
            ],
            '[manager]' => [
                'Adams D.',
                'Baker A.',
                'Clark H.',
                'Davis O.',
                'Evans P.',
            ],
            '[sales_amount]' => [
                '10 230 $',
                '45 100 $',
                '70 500 $',
                '362 180 $',
                '5 900 $',
            ],
            '[sales_manager]' => [
                'Nalty A.',
                'Ochoa S.',
                'Patel O.',
            ],
            '[[hours]]' => [
                ['01', '02', '03', '04', '05', '06', '07', '08'],
            ],
            '[[sales_amount_by_hours]]' => [
                ['100', '200', '300', '400', '500', '600', '700', '800'],
                ['1000', '2000', '3000', '4000', '5000', '6000', '7000', '8000'],
                ['10000', '20000', '30000', '40000', '50000', '60000', '70000', '80000'],
            ],
        ];
        $this->PhpExcelTemplator->saveToFile($templateFile, $fileName, $print);
        // $file = './files/output/'.$fileName.'.xlsx' ;
        header("location:.$fileName");
    }

    public function getHari($tanggal) {
        //fungsi mencari namahari
        //format $tgl YYYY-MM-DD
        //harviacode.com
        $tgl = substr($tanggal, 8, 2);
        $bln = substr($tanggal, 5, 2);
        $thn = substr($tanggal, 0, 4);
        $info = date('w', mktime(0, 0, 0, $bln, $tgl, $thn));
        switch ($info) {
            case '0': return "Minggu";
                break;
            case '1': return "Senin";
                break;
            case '2': return "Selasa";
                break;
            case '3': return "Rabu";
                break;
            case '4': return "Kamis";
                break;
            case '5': return "Jumat";
                break;
            case '6': return "Sabtu";
                break;
        };
    }

}

?>