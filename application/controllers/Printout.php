<?php

defined('BASEPATH') or exit('No direct script access allowed');

class Printout extends CI_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->model(array('wedding_model'));
        $this->load->library('form_validation');
        checkToken();
    }

    public function printWedding() {
        $id = $_GET['id'];
        if ($id == "") {
            $result['code'] = 400;
            echo json_encode($result);
            exit();
        }
        $wedding = $this->db->query("SELECT * FROM wedding WHERE id = '$id' ")->row();
        if (empty($wedding)) {
            $result['code'] = 400;
            $result['message'] = "Data Not Found";
            echo json_encode($result);
            exit();
        }
        $print = array();
        foreach ($wedding as $w => $val) {
            $print['' . $w . ''] = $val;
        }
        $company_id = $wedding->id_company;
        $company = $this->db->query("SELECT * FROM company WHERE id = '$company_id' ")->row();
        $data = array(
            'data' => $wedding
        );
        renderPrint('print/wedding', $data);
        
    }

    public function printBiodataPria() {
        if ((!isset($_GET['id']) && $_GET['id'] == "") ) {
            $result['code'] = 400;
            echo json_encode($result);
            exit();
        }
        $id = $_GET['id'];
        $pria = $this->db->query("SELECT * FROM pengantin WHERE id_wedding = '$id' AND gender = 'L' ")->row();
        
        $data = array(
            'data' => $pria
        );
        renderPrint('print/biodataPria', $data);
    }

    public function printBiodataWanita() {
        if ((!isset($_GET['id']) && $_GET['id'] == "") ) {
            $result['code'] = 400;
            echo json_encode($result);
            exit();
        }
        $id = $_GET['id'];
        $wanita = $this->db->query("SELECT * FROM pengantin WHERE id_wedding = '$id' AND gender = 'P' ")->row();
        
        $data = array(
            'data' => $wanita
        );
        renderPrint('print/biodataWanita', $data);
    }

    public function printKeluargaPria() {

        if ((!isset($_GET['id']) && $_GET['id'] == "") ) {
            $result['code'] = 400;
            echo json_encode($result);
            exit();
        }
        $id = $_GET['id'];
        $print = array();
        //Ortu
        $ayahpria = $this->db->query("SELECT * FROM keluarga WHERE id_wedding = '$id' AND HUBUNGAN = 'AYAH' AND id_pengantin = 'pria'")->row();
        if (!empty($ayahpria)) {
            foreach ($ayahpria as $ap => $val) {
                $print['' . $ap . '_ayah_pria'] = $val;
            }
        } else {
            $print['nama_ayah_pria'] = "";
            $print['no_hp_ayah_pria'] = "";
        }
        $ibupria = $this->db->query("SELECT * FROM keluarga WHERE id_wedding = '$id' AND HUBUNGAN = 'IBU' AND id_pengantin = 'pria'")->row();
        if (!empty($ibupria)) {
            foreach ($ibupria as $ip => $val) {
                $print['' . $ip . '_ibu_pria'] = $val;
            }
        } else {
            $print['nama_ibu_pria'] = "";
            $print['no_hp_ibu_pria'] = "";
        }
        //Kakak Adik Kandung
        $kakak_pria = $this->db->query("SELECT * FROM keluarga WHERE id_wedding = '$id' AND HUBUNGAN = 'KAKAK' AND id_pengantin = 'pria'")->result();
        $adik_pria = $this->db->query("SELECT * FROM keluarga WHERE id_wedding = '$id' AND HUBUNGAN = 'ADIK' AND id_pengantin = 'pria'")->result();
        

        //Kakak Adik IPAR
        $kakak_ipar = $this->db->query("SELECT * FROM keluarga WHERE id_wedding = '$id' AND HUBUNGAN = 'KAKAK_IPAR' AND id_pengantin = 'pria'")->result();        
        $adik_ipar = $this->db->query("SELECT * FROM keluarga WHERE id_wedding = '$id' AND HUBUNGAN = 'ADIK_IPAR' AND id_pengantin = 'pria'")->result();
        

        $data = array(
            'data' => $print,
            'kakak' => $kakak_pria,
            'adik' => $adik_pria,
            'kakak_ipar' => $kakak_ipar,
            'adik_ipar' => $adik_ipar
        );
        renderPrint('print/keluargaPria', $data);
    }

    public function printKeluargaWanita() {

        if ((!isset($_GET['id']) && $_GET['id'] == "") ) {
            $result['code'] = 400;
            echo json_encode($result);
            exit();
        }
        $id = $_GET['id'];
        $print = array();

        $ayahwanita = $this->db->query("SELECT * FROM keluarga WHERE id_wedding = '$id' AND HUBUNGAN = 'AYAH' AND id_pengantin = 'wanita'")->row();
        if (!empty($ayahwanita)) {
            $print['nama_ayah_wanita'] = $ayahwanita->nama;
            $print['no_hp_ayah_wanita'] = $ayahwanita->no_hp;
        } else {
            $print['nama_ayah_wanita'] = "";
            $print['no_hp_ayah_wanita'] = "";
        }
        $ibuwanita = $this->db->query("SELECT * FROM keluarga WHERE id_wedding = '$id' AND HUBUNGAN = 'IBU' AND id_pengantin = 'wanita'")->row();
        if (!empty($ibuwanita)) {
            $print['nama_ibu_wanita'] = $ibuwanita->nama;
            $print['no_hp_ibu_wanita'] = $ibuwanita->no_hp;
        } else {
            $print['nama_ibu_wanita'] = "";
            $print['no_hp_ibu_wanita'] = "";
        }

        //Kakak Adik Kandung
        $kakak_wanita = $this->db->query("SELECT * FROM keluarga WHERE id_wedding = '$id' AND HUBUNGAN = 'KAKAK' AND id_pengantin = 'wanita'")->result();
        $adik_wanita = $this->db->query("SELECT * FROM keluarga WHERE id_wedding = '$id' AND HUBUNGAN = 'ADIK' AND id_pengantin = 'wanita'")->result();

        //Kakak Adik IPAR
        $kakak_ipar = $this->db->query("SELECT * FROM keluarga WHERE id_wedding = '$id' AND HUBUNGAN = 'KAKAK_IPAR' AND id_pengantin = 'wanita'")->result();
        $adik_ipar = $this->db->query("SELECT * FROM keluarga WHERE id_wedding = '$id' AND HUBUNGAN = 'ADIK_IPAR' AND id_pengantin = 'wanita'")->result();
    
        $data = array(
            'data' => $print,
            'kakak' => $kakak_wanita,
            'adik' => $adik_wanita,
            'kakak_ipar' => $kakak_ipar,
            'adik_ipar' => $adik_ipar
        );
        renderPrint('print/keluargaWanita', $data);
    }

    public function printAcara() {
        if ((!isset($_GET['id']) && $_GET['id'] == "") ) {
            $result['code'] = 400;
            echo json_encode($result);
            exit();
        }
        $id = $_GET['id'];
        $id_wedding = $_GET['id_wedding'];
        $print = array();
        $acara = $this->db->query("SELECT * FROM acara_tipe WHERE id = '$id'")->row();

        $paket_acara = $this->db->query("SELECT a.nama_field, a.nama_label, a.type, a.ukuran, b.value 
                    FROM acara_field a
                    LEFT JOIN ( SELECT * FROM acara_data WHERE id_wedding = '$id_wedding' ) b ON a.id = b.id_acara_field WHERE a.id_acara_tipe = '$id'")->result();
        if (!empty($paket_acara)) {
            foreach ($paket_acara as $pa => $val) {
                $label = $val->nama_label;
                $nama_field = $val->nama_field;
                $type = $val->type;
                $ukuran = $val->ukuran;
                $value = $val->value;
                if ($type == "text" || $type == "textarea" || $type == "angka" || $type == "combobox") {
                    $tag = $nama_field;
                    // $print['' . $nama_field . ''] = $value != "" ? $value : "";
                    // $print[]['label'] = $label;
                    // $print[]['value'] = $value != "" ? $value : "";
                    $print[] = array(
                        'label' => $label,
                        'value' => $value != "" ? $value : ""
                    );
                } else if ($type == "tanggal") {
                    $tag = $nama_field;
                    // $print['' . $nama_field . ''] = $value != "" ? DateToIndo($value) : "";
                    $print[] = array(
                        'label' => $label,
                        'value' => $value != "" ? DateToIndo($value) : ""
                    );
                } else if ($type == "checkbox") {
                    $tag = $nama_field;
                    // $print['' . $nama_field . ''] = $value != "" ? "Ada" : "Tidak Ada";
                    $print[] = array(
                        'label' => $label,
                        'value' => $value != "" ? "Ada" : "Tidak Ada"
                    );
                } else if ($type == "addabletext") {
                    $ukurans = explode("||", $ukuran);
                    $values = json_decode($value, true);

                    $data = array();
                    for ($ii = 0; $ii < count($ukurans); $ii++) {
                        $tag = $ukurans[$ii];
                        //echo $tag . "<br>";
                        if ($value != "" && !empty($values)) {
                        //    for ($jj = 0; $jj < count($values); $jj++) {
                            foreach ($values as $jj => $val) {
                                // $print['' . $tag . ''][] = isset($values[$jj][$ii]) ? $values[$jj][$ii] : "";
                                $data[] = array(
                                    'label' => $tag,
                                    'value' => isset($values[$jj][$ii]) ? $values[$jj][$ii] : ""
                                );
                            }
                        } else {
                            $data[] = array(
                                'label' => $tag,
                                'value' => ""
                            );
                        }
                    }
                    $print[] = array(
                        'label' => $label,
                        'value' => $data
                    );
                }
            }
        }
        $data = array(
            'title' => ucwords($acara->nama_acara),
            'data' => $print
        );
        renderPrint('print/acara', $data);
    }

    public function printUpacara() {
        if ((!isset($_GET['id']) && $_GET['id'] == "")) {
            $result['code'] = 400;
            echo json_encode($result);
            exit();
        }
        $id = $_GET['id'];
        $id_wedding = $_GET['id_wedding'];
        $print = array();
        $upacara = $this->db->query("SELECT * FROM upacara_tipe WHERE id = '$id'")->row();
        $print = array();
        $paket_upacara = $this->db->query("SELECT a.nama_field, a.nama_label, a.type, a.ukuran, b.value 
                    FROM upacara_field a
                    LEFT JOIN ( SELECT * FROM upacara_data WHERE id_wedding = '$id_wedding' ) b ON a.id = b.id_upacara_field WHERE a.id_upacara_tipe ='$id'")->result();
        if (!empty($paket_upacara)) {
            foreach ($paket_upacara as $pa => $val) {
                $label = $val->nama_label;
                $nama_field = $val->nama_field;
                $type = $val->type;
                $ukuran = $val->ukuran;
                $value = $val->value;
                if ($type == "text" || $type == "textarea" || $type == "angka" || $type == "combobox") {
                    $tag = $nama_field;
                    // $print['' . $nama_field . ''] = $value != "" ? $value : "";
                    // $print[]['label'] = $label;
                    // $print[]['value'] = $value != "" ? $value : "";
                    $print[] = array(
                        'label' => $label,
                        'value' => $value != "" ? $value : ""
                    );
                } else if ($type == "tanggal") {
                    $tag = $nama_field;
                    // $print['' . $nama_field . ''] = $value != "" ? DateToIndo($value) : "";
                    $print[] = array(
                        'label' => $label,
                        'value' => $value != "" ? DateToIndo($value) : ""
                    );
                } else if ($type == "checkbox") {
                    $tag = $nama_field;
                    // $print['' . $nama_field . ''] = $value != "" ? "Ada" : "Tidak Ada";
                    $print[] = array(
                        'label' => $label,
                        'value' => $value != "" ? "Ada" : "Tidak Ada"
                    );
                } else if ($type == "addabletext") {
                    $ukurans = explode("||", $ukuran);
                    $values = json_decode($value, true);

                    $data = array();
                    for ($ii = 0; $ii < count($ukurans); $ii++) {
                        $tag = $ukurans[$ii];
                        //echo $tag . "<br>";
                        if ($value != "" && !empty($values)) {
                        //    for ($jj = 0; $jj < count($values); $jj++) {
                            foreach ($values as $jj => $val) {
                                // $print['' . $tag . ''][] = isset($values[$jj][$ii]) ? $values[$jj][$ii] : "";
                                $data[] = array(
                                    'label' => $tag,
                                    'value' => isset($values[$jj][$ii]) ? $values[$jj][$ii] : ""
                                );
                            }
                        } else {
                            $data[] = array(
                                'label' => $tag,
                                'value' => ""
                            );
                        }
                    }
                    $print[] = array(
                        'label' => $label,
                        'value' => $data
                    );
                }
            }
        }
        $data = array(
            'title' => ucwords($upacara->nama_upacara),
            'data' => $print
        );
        renderPrint('print/acara', $data);
    }

    public function printPanitia() {
        if ((!isset($_GET['id']) && $_GET['id'] == "") ) {
            $result['code'] = 400;
            echo json_encode($result);
            exit();
        }
        $id = $_GET['id'];
        $id_wedding = $_GET['id_wedding'];
        $print = array();
        $panitia = $this->db->query("SELECT * FROM panitia_tipe WHERE id = '$id'")->row();
        $print = array();
        $paket_panitia = $this->db->query("SELECT a.nama_field, a.nama_label, a.type, a.ukuran, b.value 
                    FROM panitia_field a
                    LEFT JOIN ( SELECT * FROM panitia_data WHERE id_wedding = '$id_wedding' ) b ON a.id = b.id_panitia_field WHERE a.id_panitia_tipe = '$id'")->result();
        if (!empty($paket_panitia)) {
            foreach ($paket_panitia as $pa => $val) {
                $label = $val->nama_label;
                $nama_field = $val->nama_field;
                $type = $val->type;
                $ukuran = $val->ukuran;
                $value = $val->value;
                if ($type == "text" || $type == "textarea" || $type == "angka" || $type == "combobox") {
                    $tag = $nama_field;
                    // $print['' . $nama_field . ''] = $value != "" ? $value : "";
                    // $print[]['label'] = $label;
                    // $print[]['value'] = $value != "" ? $value : "";
                    $print[] = array(
                        'label' => $label,
                        'value' => $value != "" ? $value : ""
                    );
                } else if ($type == "tanggal") {
                    $tag = $nama_field;
                    // $print['' . $nama_field . ''] = $value != "" ? DateToIndo($value) : "";
                    $print[] = array(
                        'label' => $label,
                        'value' => $value != "" ? DateToIndo($value) : ""
                    );
                } else if ($type == "checkbox") {
                    $tag = $nama_field;
                    // $print['' . $nama_field . ''] = $value != "" ? "Ada" : "Tidak Ada";
                    $print[] = array(
                        'label' => $label,
                        'value' => $value != "" ? "Ada" : "Tidak Ada"
                    );
                } else if ($type == "addabletext") {
                    $ukurans = explode("||", $ukuran);
                    $values = json_decode($value, true);

                    $data = array();
                    for ($ii = 0; $ii < count($ukurans); $ii++) {
                        $tag = $ukurans[$ii];
                        //echo $tag . "<br>";
                        if ($value != "" && !empty($values)) {
                        //    for ($jj = 0; $jj < count($values); $jj++) {
                            foreach ($values as $jj => $val) {
                                // $print['' . $tag . ''][] = isset($values[$jj][$ii]) ? $values[$jj][$ii] : "";
                                $data[] = array(
                                    'label' => $tag,
                                    'value' => isset($values[$jj][$ii]) ? $values[$jj][$ii] : ""
                                );
                            }
                        } else {
                            $data[] = array(
                                'label' => $tag,
                                'value' => ""
                            );
                        }
                    }
                    $print[] = array(
                        'label' => $label,
                        'value' => $data
                    );
                }
            }
        }
        $data = array(
            'title' => ucwords($panitia->nama_panitia),
            'data' => $print,
            'panitia' => true
        );
        renderPrint('print/acara', $data);
    }

    public function printTambahan() {
        if ((!isset($_GET['id']) && $_GET['id'] == "") ) {
            $result['code'] = 400;
            echo json_encode($result);
            exit();
        }
        $id = $_GET['id'];
        $id_wedding = $_GET['id_wedding'];
        $print = array();
        $tambahan = $this->db->query("SELECT * FROM tambahan_tipe WHERE id = '$id'")->row();
        $head = $this->db->query("SELECT * FROM tambahan_field WHERE id = '$id'")->row();
        $print = array();
        $paket_tambahan = $this->db->query("SELECT a.nama_field, a.nama_label, a.type, a.ukuran, b.value 
                    FROM tambahan_field a
                    LEFT JOIN ( SELECT * FROM tambahan_data WHERE id_wedding = '$id_wedding' ) b ON a.id = b.id_tambahan_field WHERE a.id_tambahan_tipe = '$id'")->result();
        if (!empty($paket_tambahan)) {
            foreach ($paket_tambahan as $pa => $val) {
                $label = $val->nama_label;
                $nama_field = $val->nama_field;
                $type = $val->type;
                $ukuran = $val->ukuran;
                $value = $val->value;
                if ($type == "text" || $type == "textarea" || $type == "angka" || $type == "combobox") {
                    $tag = $nama_field;
                    // $print['' . $nama_field . ''] = $value != "" ? $value : "";
                    // $print[]['label'] = $label;
                    // $print[]['value'] = $value != "" ? $value : "";
                    $print[] = array(
                        'label' => $label,
                        'value' => $value != "" ? $value : ""
                    );
                } else if ($type == "tanggal") {
                    $tag = $nama_field;
                    // $print['' . $nama_field . ''] = $value != "" ? DateToIndo($value) : "";
                    $print[] = array(
                        'label' => $label,
                        'value' => $value != "" ? DateToIndo($value) : ""
                    );
                } else if ($type == "checkbox") {
                    $tag = $nama_field;
                    // $print['' . $nama_field . ''] = $value != "" ? "Ada" : "Tidak Ada";
                    $print[] = array(
                        'label' => $label,
                        'value' => $value != "" ? "Ada" : "Tidak Ada"
                    );
                } else if ($type == "addabletext") {
                    $ukurans = explode("||", $ukuran);
                    $values = json_decode($value, true);

                    $data = array();
                    for ($ii = 0; $ii < count($ukurans); $ii++) {
                        $tag = $ukurans[$ii];
                        //echo $tag . "<br>";
                        if ($value != "" && !empty($values)) {
                        //    for ($jj = 0; $jj < count($values); $jj++) {
                            foreach ($values as $jj => $val) {
                                // $print['' . $tag . ''][] = isset($values[$jj][$ii]) ? $values[$jj][$ii] : "";
                                $data[$jj][$ii] = isset($values[$jj][$ii]) ? $values[$jj][$ii] : "";
                            }
                        } 
                    }
                    $print[] = array(
                        'label' => $label,
                        'value' => $data,
                        'ukuran' => $ukurans
                    );
                }
            }
        }
        $data = array(
            'title' => ucwords($tambahan->nama_tambahan_paket),
            'data' => $print
        );
        renderPrint('print/tambahan', $data);
    }

    public function printUndangan(){
        if ((!isset($_GET['id']) && $_GET['id'] == "") ) {
            $result['code'] = 400;
            echo json_encode($result);
            exit();
        }
        $id = $_GET['id'];
        $data = array(
            'data' => $this->db->query("SELECT * FROM undangan WHERE id_wedding = '$id'")->result()
        );
        renderPrint('print/undangan',$data);
    }

    public function printVendor(){
        if ((!isset($_GET['id']) && $_GET['id'] == "") ) {
            $result['code'] = 400;
            echo json_encode($result);
            exit();
        }
        $id = $_GET['id'];
        $data = array(
            'data' => $this->db->query("SELECT * FROM kategori_vendor a LEFT JOIN 
            (SELECT * FROM vendor_pengantin WHERE id_wedding = '$id') b ON a.id = b.id_kategori")->result()
        );
        renderPrint('print/vendor',$data);
    }

    public function printPayment(){
        if ((!isset($_GET['id']) && $_GET['id'] == "") ) {
            $result['code'] = 400;
            echo json_encode($result);
            exit();
        }
        $id = $_GET['id'];
        $data = array(
            'data' => $this->db->query("SELECT a.*,b.nama_kategori FROM vendor_pengantin a "
                    . "LEFT JOIN kategori_vendor b "
                    . "ON a.id_kategori = b.id "
                    . "WHERE a.id_wedding = '$id'")->result()
        );
        renderPrint('print/payment',$data);
    }

    public function getHari($tanggal) {
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