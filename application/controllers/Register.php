<?php

error_reporting(E_ALL);
ini_set('display_errors', TRUE);
ini_set('display_startup_errors', TRUE);
defined('BASEPATH') or exit('No direct script access allowed');
require_once dirname(__FILE__) . '/../libraries/PHPExcelTemplate/samples/Bootstrap.php';

class Register extends CI_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->model(array('wedding_model'));
        $this->load->model(array('register_model'));
        $this->load->library('form_validation');
        $this->PhpExcelTemplator = new alhimik1986\PhpExcelTemplator\PhpExcelTemplator;
        checkToken();
    }

    public function index() {
        $data['wedding'] = $this->wedding_model->getDataAll();
        render('register/data', $data);
    }

    public function delete() {
        $id = $_GET['id'];
        $key['id'] = $id;
        $this->db->delete('wedding', $key);
        redirect(base_url() . "Register");
    }

    public function add() {
        $data_upacara = $this->db->query("SELECT
		c1.id,		
                    p.id as parent_id,
                    p.nama_upacara as parent_name,    
                    c1.nama_upacara as child_name
                FROM 
                    upacara_tipe p
                LEFT JOIN upacara_tipe c1
                    ON c1.id_upacara = p.id
                WHERE
                    p.id_upacara=0 
                ORDER BY 
                    p.id, c1.urutan, p.nama_upacara ASC")->result();

        $auth = $this->session->userdata('auth');
        $group = $auth['group'];
        $id_company = $auth['company'];
        if ($group != 1) {
            $company = "SELECT * FROM company WHERE id = '$id_company'";
        } else {
            $company = "SELECT * FROM company";
        }
        $data = array(
            'upacara' => $data_upacara,
            'acara' => $this->db->query("SELECT * FROM acara_tipe ORDER BY urutan ASC")->result(),
            'panitia' => $this->db->query("SELECT * FROM panitia_tipe ORDER BY urutan ASC")->result(),
            'tambahan' => $this->db->query("SELECT * FROM tambahan_tipe ORDER BY urutan ASC")->result(),
            'data_company' => $this->db->query($company)->result(),
            'data_agama' => $this->db->query("SELECT * FROM agama ORDER BY agama ASC")->result(),
            'today' => date('Y-m-d')
        );
        render('register/add', $data);
    }
    
    public function save() {
        $wedding = $this->register_model;
        $validation = $this->form_validation;
        $validation->set_rules($wedding->rules_wedding());
        $result = true;
        $msg = "";
        $id_wedding = "";
        $_POST['tanggal_pernikahan'] = isset($_POST['tanggal_pernikahan']) ? date('Y-m-d', strtotime($_POST['tanggal_pernikahan'])) : "";
//        $_POST['tanggal_lahir_pria'] = isset($_POST['tanggal_lahir_pria']) ? date('Y-m-d', strtotime($_POST['tanggal_lahir_pria'])) : "";
//        $_POST['tanggal_lahir_wanita'] = isset($_POST['tanggal_lahir_wanita']) ? date('Y-m-d', strtotime($_POST['tanggal_lahir_wanita'])) : "";

        //Insert Data Wedding ke Table wedding
        if ($result) {
            $id_wedding = $wedding->insertWedding();
            $result = $result && true;
        }
        if ($id_wedding == "") {
            $return = array(
                'code' => 400,
                'message' => "Gagal Di Tambahkan . " . $msg
            );
            echo json_encode($return);
            exit();
        }

        //Insert Data Wedding ke Table Pengantin
        if ($result) {
            $catin_pria = $wedding->insertPria($id_wedding);
            $result = $result && true;
        }

        //Insert Data Wedding ke Table Wanita
        if ($result) {
            $catin_wanita = $wedding->insertWanita($id_wedding);
            $result = $result && true;
        }

        //Insert Data Paket ke Table wedding_acara / wedding_panitia / wedding_upacra / wedding_tambahan        

        if ($wedding->insertAcara($id_wedding)) {
            $result = $result && true;
        }
        if ($wedding->insertUpacara($id_wedding)) {
            $result = $result && true;
        }
        if ($wedding->insertPanitia($id_wedding)) {
            $result = $result && true;
        }
        if ($wedding->insertTambahan($id_wedding)) {
            $result = $result && true;
        }
        if ($wedding->insertUser($id_wedding, $catin_pria, $catin_wanita)) {
            $result = $result && true;
        }
        if ($wedding->insertLog($id_wedding, 'Registrasi')) {
            $result = $result && true;
        }

        if ($result) {
            $return = array(
                'code' => 200,
                'message' => "Berhasil Di Tambahkan"
            );
            echo json_encode($return);
            $this->session->set_flashdata('success', 'Berhasil Ditambahkan');
        } else {
            $return = array(
                'code' => 200,
                'message' => "Gagal Di Tambahkan . " . $msg
            );
            echo json_encode($return);
            $this->session->set_flashdata('error', 'Berhasil Ditambahkan');
        }
    }
}

/* End of file Register.php */
/* Location: ./application/controllers/Register.php */
