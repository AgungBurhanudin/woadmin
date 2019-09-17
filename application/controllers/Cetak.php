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
//        $kakak_pria = $this->db->query("SELECT * FROM keluarga WHERE id_wedding = '$id' AND HUBUNGAN = 'KAKAK' AND id_pengantin = 'pria'")->result();
//        foreach ($kakak_pria as $sp => $val) {
//            $print['[' . $sp . '_kakak_pria]'][] = $val->nama;
//        }
        $ayahwanita = $this->db->query("SELECT * FROM keluarga WHERE id_wedding = '$id' AND HUBUNGAN = 'AYAH' AND id_pengantin = 'wanita'")->row();
        foreach ($ayahwanita as $aw => $val) {
            $print['{' . $aw . '_ayah_wanita}'] = $val;
        }
        $ibuwanita = $this->db->query("SELECT * FROM keluarga WHERE id_wedding = '$id' AND HUBUNGAN = 'IBU' AND id_pengantin = 'wanita'")->row();
        foreach ($ibuwanita as $iw => $val) {
            $print['{' . $iw . '_ibu_wanita}'] = $val;
        }
//        $saudara_wanita = $this->db->query("SELECT * FROM keluarga WHERE id_wedding = '$id' AND HUBUNGAN not in ('AYAH', 'IBU') AND id_pengantin = 'wanita'")->result();
//        foreach ($saudara_wanita as $sw => $val) {
//            $print['{' . $sw . '_saudara_wanita}'] = $val;
//        }

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