<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Register_model extends CI_Model {

    public function __construct() {
        parent::__construct();
    }

    private $_table = 'wedding';
    public $id;
    public $id_company;
    public $title;
    public $pengantin_pria;
    public $pengantin_wanita;
    public $tanggal;
    public $waktu;
    public $tempat;
    public $tema;
    public $alamat;
    public $hashtag;
    public $penyelenggara;
    public $undangan;
    public $status;
    public $registration_date;

    public function rules_wedding() {
        return [
            ['field' => 'title', 'label' => 'Title', 'rules' => 'required'],
            ['field' => 'pengantin_pria', 'label' => 'Pengantin Pria', 'rules' => 'required'],
            ['field' => 'pengantin_wanita', 'label' => 'Pengantin Wanita', 'rules' => 'required'],
            ['field' => 'tanggal', 'label' => 'Tanggal', 'rules' => 'required'],
            ['field' => 'waktu', 'label' => 'Waktu', 'rules' => 'required'],
            ['field' => 'tempat', 'label' => 'Tempat', 'rules' => 'required'],
            ['field' => 'tema', 'label' => 'Tema', 'rules' => 'required'],
            ['field' => 'alamat', 'label' => 'Alamat', 'rules' => 'required'],
            ['field' => 'penyelenggara', 'label' => 'Penyelenggara', 'rules' => 'required'],
            ['field' => 'undangan', 'label' => 'Undangan', 'rules' => 'required'],
            ['field' => 'status', 'label' => 'Status', 'rules' => 'required'],
        ];
    }

    public function rules_pria() {
        return [
            ['field' => 'title', 'label' => 'Title', 'rules' => 'required'],
            ['field' => 'pengantin_pria', 'label' => 'Pengantin Pria', 'rules' => 'required'],
            ['field' => 'pengantin_wanita', 'label' => 'Pengantin Wanita', 'rules' => 'required'],
            ['field' => 'tanggal', 'label' => 'Tanggal', 'rules' => 'required'],
            ['field' => 'waktu', 'label' => 'Waktu', 'rules' => 'required'],
            ['field' => 'tempat', 'label' => 'Tempat', 'rules' => 'required'],
            ['field' => 'tema', 'label' => 'Tema', 'rules' => 'required'],
            ['field' => 'alamat', 'label' => 'Alamat', 'rules' => 'required'],
            ['field' => 'hashtag', 'label' => 'Hashtag', 'rules' => 'required'],
            ['field' => 'penyelenggara', 'label' => 'Penyelenggara', 'rules' => 'required'],
            ['field' => 'undangan', 'label' => 'Undangan', 'rules' => 'required'],
            ['field' => 'status', 'label' => 'Status', 'rules' => 'required'],
        ];
    }

    public function insertWedding() {
        $auth = $this->session->userdata('auth');
        $group = $auth['group'];
        $id_company = $auth['company'];
        $_POST = $this->input->post();
        $this->id_company = $_POST["user_company"];
        $this->title = $_POST["title"];
        $this->pengantin_pria = $_POST["nama_panggilan_pria"];
        $this->pengantin_wanita = $_POST["nama_panggilan_wanita"];
        $this->tanggal = $_POST["tanggal_pernikahan"];
        $this->waktu = $_POST["waktu_pernikahan"];
        $this->tempat = $_POST["lokasi_pernikahan"];
        $this->alamat = $_POST["alamat_pernikahan"];
        $this->tema = $_POST["tema_pernikahan"];
        $this->hashtag = $_POST["hastag_pernikahan"];
        $this->penyelenggara = $_POST["penyelenggara"];
        $this->undangan = $_POST["jumlah_undangan"];
        $this->status = 1;
        $this->registration_date = date('Y-m-d H:i:s');
        $this->db->insert($this->_table, $this);
        return $this->db->insert_id();
    }

    public function insertPria($id_wedding) {
        $_POST = $this->input->post();
        $data['id_wedding'] = $id_wedding;
        $data['gender'] = "L";
//        $data['nama_lengkap'] = $_POST["nama_lengkap_pria"];
        $data['nama_panggilan'] = $_POST['nama_panggilan_pria'];
//        $data['alamat_sekarang'] = $_POST['alamat_sekarang_pria'];
//        $data['alamat_nikah'] = $_POST['alamat_nikah_pria'];
//        $data['tempat_lahir'] = $_POST['tempat_lahir_pria'];
//        $data['tanggal_lahir'] = $_POST['tanggal_lahir_pria'];
        $data['no_hp'] = $_POST['no_hp_pria'];
        $data['email'] = $_POST['email_pria'];
//        $data['agama'] = $_POST['agama_pria'];
//        $data['pendidikan'] = $_POST['pendidikan_pria'];
//        $data['hobi'] = $_POST['hobi_pria'];
//        $data['sosmed'] = 1;
        $data['status'] = 1;
        $data['photo'] = "";

//        if (isset($_FILES)) {
//            $path = realpath(APPPATH . '../files/images/');
//
//            $this->upload->initialize(array(
//                'upload_path' => $path,
//                'allowed_types' => 'png|jpg|gif',
//                'max_size' => '5000',
//                'max_width' => '3000',
//                'max_height' => '3000'
//            ));
//
//            if ($this->upload->do_upload('foto_pria')) {
//                $data_upload = $this->upload->data();
//                $this->image_lib->initialize(array(
//                    'image_library' => 'gd2',
//                    'source_image' => $path . '/' . $data_upload['file_name'],
//                    'maintain_ratio' => false,
//                    //  'create_thumb' => true,
//                    'overwrite' => TRUE
//                ));
//                if ($this->image_lib->resize()) {
//                    $data['photo'] = $data_upload['raw_name'] . $data_upload['file_ext'];
//                } else {
//                    $data['photo'] = $data_upload['file_name'];
//                }
//            } else {
//                $data['photo'] = "";
//            }
//        } else {
//            $data['photo'] = "";
//        }
        $this->db->insert('pengantin', $data);
        return $this->db->insert_id();
    }

    public function insertWanita($id_wedding) {
        $_POST = $this->input->post();
        $data['id_wedding'] = $id_wedding;
        $data['gender'] = "P";
//        $data['nama_lengkap'] = $_POST["nama_lengkap_wanita"];
        $data['nama_panggilan'] = $_POST['nama_panggilan_wanita'];
//        $data['alamat_sekarang'] = $_POST['alamat_sekarang_wanita'];
//        $data['alamat_nikah'] = $_POST['alamat_nikah_wanita'];
//        $data['tempat_lahir'] = $_POST['tempat_lahir_wanita'];
//        $data['tanggal_lahir'] = $_POST['tanggal_lahir_wanita'];
        $data['no_hp'] = $_POST['no_hp_wanita'];
        $data['email'] = $_POST['email_wanita'];
//        $data['agama'] = $_POST['agama_wanita'];
//        $data['pendidikan'] = $_POST['pendidikan_wanita'];
//        $data['hobi'] = $_POST['hobi_wanita'];
//        $data['sosmed'] = $_POST['sosmed_wanita'];
        $data['status'] = 1;
        $data['photo'] = "";
//        if (isset($_FILES)) {
//            $path = realpath(APPPATH . '../files/images/');
//
//            $this->upload->initialize(array(
//                'upload_path' => $path,
//                'allowed_types' => 'png|jpg|gif',
//                'max_size' => '5000',
//                'max_width' => '3000',
//                'max_height' => '3000'
//            ));
//
//            if ($this->upload->do_upload('foto_wanita')) {
//                $data_upload = $this->upload->data();
//                $this->image_lib->initialize(array(
//                    'image_library' => 'gd2',
//                    'source_image' => $path . '/' . $data_upload['file_name'],
//                    'maintain_ratio' => false,
//                    //  'create_thumb' => true,
//                    'overwrite' => TRUE
//                ));
//                if ($this->image_lib->resize()) {
//                    $data['photo'] = $data_upload['raw_name'] . $data_upload['file_ext'];
//                } else {
//                    $data['photo'] = $data_upload['file_name'];
//                }
//            } else {
//                $data['photo'] = "";
//            }
//        } else {
//            $data['photo'] = "";
//        }
        $this->db->insert('pengantin', $data);
        return $this->db->insert_id();
    }

    public function insertAcara($id_wedding) {
        $_POST = $this->input->post();
        $acara = $_POST['acara'];
        $no = 1;
        if (!empty($acara)) {
            foreach ($acara as $val) {

                $data['id_wedding'] = $id_wedding;
                $data['id_acara_tipe'] = $val;
                $data['urutan'] = $no++;
                $this->db->insert('wedding_acara', $data);
            }
        }
        return true;
    }

    public function insertUpacara($id_wedding) {
        $_POST = $this->input->post();
        $upacara = $_POST['upacara'];
        $no = 1;
        if (!empty($upacara)) {
            foreach ($upacara as $val) {

                $data['id_wedding'] = $id_wedding;
                $data['id_upacara_tipe'] = $val;
                $data['urutan'] = $no++;
                $this->db->insert('wedding_upacara', $data);
            }
        }
        return true;
    }

    public function insertPanitia($id_wedding) {
        $_POST = $this->input->post();
        $panitia = $_POST['panitia'];
        $no = 1;
        if (!empty($panitia)) {
            foreach ($panitia as $val) {

                $data['id_wedding'] = $id_wedding;
                $data['id_panitia_tipe'] = $val;
                $data['urutan'] = $no++;
                $this->db->insert('wedding_panitia', $data);
            }
        }
        return true;
    }

    public function insertTambahan($id_wedding) {
        $_POST = $this->input->post();
        $tambahan = $_POST['tambahan'];
        $no = 1;
        if (!empty($tambahan)) {
            foreach ($tambahan as $val) {

                $data['id_wedding'] = $id_wedding;
                $data['id_tambahan_tipe'] = $val;
                $data['urutan'] = $no++;
                $this->db->insert('wedding_tambahan', $data);
            }
        }
        return true;
    }

    public function insertUser($id_wedding, $catin_pria, $catin_wanita) {
        $auth = $this->session->userdata('auth');
        $group = $auth['group'];
        $id_company = $auth['company'];
        $_POST = $this->input->post();
        $username_pria = strtolower(str_replace(" ", "_", $_POST['nama_panggilan_pria'])) . "_" . $id_wedding;
        $password_pria = $this->generateRandomString(6);
        $data['id_wedding'] = $id_wedding;
        $data['user_company'] = $_POST['user_company'];
        $data['user_group_id'] = 37;
        $data['user_real_name'] = $_POST['nama_panggilan_pria'];
        $data['user_user_name'] = $username_pria;
        $data['user_email'] = $_POST['email_pria'];
        $data['user_password'] = md5($password_pria);
//        $data['user_address'] = $_POST['alamat_sekarang_pria'];
        $data['user_phone'] = $_POST['no_hp_pria'];
        $data['id_pengantin'] = $catin_pria;
        $this->sendEmail($_POST['email_pria'], $username_pria, $password_pria);
        $this->db->insert('app_user', $data);

        $username_wanita = strtolower(str_replace(" ", "_", $_POST['nama_panggilan_wanita'])) . "_" . $id_wedding;
        $password_wanita = $this->generateRandomString(6);
        $data['id_wedding'] = $id_wedding;
        $data['user_company'] = $_POST['user_company'];
        $data['user_group_id'] = 37;
        $data['user_real_name'] = $_POST['nama_panggilan_wanita'];
        $data['user_user_name'] = $username_wanita;
//        $data['user_email'] = $_POST['email_wanita'];
        $data['user_password'] = md5($password_wanita);
//        $data['user_address'] = $_POST['alamat_sekarang_wanita'];
        $data['user_phone'] = $_POST['no_hp_wanita'];
        $data['id_pengantin'] = $catin_wanita;
        $this->sendEmail($_POST['email_wanita'], $username_wanita, $password_wanita);
        return $this->db->insert('app_user', $data);
    }

    public function sendEmail($email, $username, $password) {
        //Load email library
//        $this->load->library('encrypt');
        $this->load->library('email');
        $config = array(
            'protocol' => 'smtp',
            'smtp_host' => 'ssl://smtp.gmail.com',
            'smtp_port' => 465,
            'smtp_user' => 'afnanafifudin@gmail.com',
            'smtp_pass' => 'afnan2016',
            'mailtype' => 'html',
            'charset' => 'utf-8'
        );
        $this->email->initialize($config);
        $this->email->set_mailtype("html");
        $this->email->set_newline("\r\n");

//Email content
        $htmlContent = '<h1>Wedding Organizer</h1>';
        $htmlContent .= '<p>Berikut kami lampirkan username dan password untuk login aplikasi Mahkota Wedding Organizer.</p>';
        $htmlContent .= '<p>username : <b> ' . $username . ' </b></p>';
        $htmlContent .= '<p>password : <b> ' . $password . ' </b></p>';
        $htmlContent .= '<p>Pastikan untuk langsung merubah password setelah anda login.</p>';

        $this->email->to($email);
        $this->email->from('afnanafifudin@gmail.com', 'Mahkota Wedding Organizer');
        $this->email->subject('Konfirmasi Akun Mahkota Wedding Organizer');
        $this->email->message($htmlContent);

//Send email
        $this->email->send();
    }

    function generateRandomString($length = 10) {
        $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
        $charactersLength = strlen($characters);
        $randomString = '';
        for ($i = 0; $i < $length; $i++) {
            $randomString .= $characters[rand(0, $charactersLength - 1)];
        }
        return $randomString;
    }

    public function insertLog($id_wedding, $deskripsi) {
        $auth = $this->session->userdata('auth');
        $group = $auth['group'];
        $id_company = $auth['company'];
        $data['id_wedding'] = $id_wedding;
        $data['id_user'] = $auth['noid'];
        $data['username'] = $auth['username'];
        $data['deskripsi'] = $deskripsi;
        $data['datetime'] = date('Y-m-d H:i:s');
        $this->db->insert('log_aktivitas', $data);
        return true;
    }

    public function update() {
        $_POST = $this->input->post();
        $this->id = $_POST["id"];
        $this->id_company = $_POST["id_company"];
        $this->title = $_POST["title"];
        $this->pengantin_pria = $_POST["pengantin_pria"];
        $this->pengantin_wanitan = $_POST["pengantin_wanitan"];
        $this->tanggal = $_POST["tanggal"];
        $this->waktu = $_POST["waktu"];
        $this->tempat = $_POST["tempat"];
        $this->alamat = $_POST["alamat"];
        $this->tema = $_POST["tema"];
        $this->hashtag = $_POST["hashtag"];
        $this->penyelenggara = $_POST["penyelenggara"];
        $this->undangan = $_POST["undangan"];
        $this->status = $_POST["status"];
        $this->db->update($this->_table, array("id" => $_POST['$id']));
    }

    public function delete($id) {
        return $this->db->delete($this->_table, array('id' => $id));
    }

}