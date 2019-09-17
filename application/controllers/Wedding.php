<?php

error_reporting(E_ALL);
ini_set('display_errors', TRUE);
ini_set('display_startup_errors', TRUE);
defined('BASEPATH') or exit('No direct script access allowed');
require_once dirname(__FILE__) . '/../libraries/PHPExcelTemplate/samples/Bootstrap.php';

class Wedding extends CI_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->model(array('wedding_model'));
        $this->load->library('form_validation');
        $this->PhpExcelTemplator = new alhimik1986\PhpExcelTemplator\PhpExcelTemplator;
        checkToken();
    }

    public function index() {
        $data['wedding'] = $this->wedding_model->getDataAll();
        render('wedding/data', $data);
    }

    public function delete() {
        $id = $_GET['id'];
        $key['id'] = $id;
        $this->db->delete('wedding', $key);
        redirect(base_url() . "Wedding");
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
        render('wedding/add', $data);
    }

    public function save() {
        $wedding = $this->wedding_model;
        $validation = $this->form_validation;
        $validation->set_rules($wedding->rules_wedding());
        $result = true;
        $msg = "";
        $id_wedding = "";
        $_POST['tanggal_pernikahan'] = isset($_POST['tanggal_pernikahan']) ? date('Y-m-d', strtotime($_POST['tanggal_pernikahan'])) : "";
        $_POST['tanggal_lahir_pria'] = isset($_POST['tanggal_lahir_pria']) ? date('Y-m-d', strtotime($_POST['tanggal_lahir_pria'])) : "";
        $_POST['tanggal_lahir_wanita'] = isset($_POST['tanggal_lahir_wanita']) ? date('Y-m-d', strtotime($_POST['tanggal_lahir_wanita'])) : "";

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

    public function form() {
        $id = $_GET['id'];
        if (empty($id) || $id == "") {
            redirect(base_url() . "Wedding");
        }
        $wedding = $this->db->query("SELECT * FROM wedding WHERE id = '$id'")->row();
        //        if (empty($wedding)) {
        //            redirect(base_url() . "Wedding");
        //        }
        $data = array(
            'id_wedding' => $id,
            'wedding' => $wedding,
            'pria' => $this->db->query("SELECT * FROM pengantin WHERE id_wedding = '$id' AND gender = 'L'")->row(),
            'wanita' => $this->db->query("SELECT * FROM pengantin WHERE id_wedding = '$id' AND gender = 'P'")->row(),
            'vendor' => $this->db->query("SELECT a.*,b.nama_kategori FROM vendor_pengantin a "
                    . "LEFT JOIN kategori_vendor b "
                    . "ON a.id_kategori = b.id "
                    . "WHERE a.id_wedding = '$id'")->result(),
            'undangan' => $this->db->query("SELECT * FROM undangan WHERE id_wedding = '$id'")->result(),
            'data_agama' => $this->db->query("SELECT * FROM agama")->result(),
            'meeting' => $this->db->query("SELECT * FROM jadwal_meeting WHERE id_wedding = '$id' ORDER BY tanggal DESC")->result(),
            'log' => $this->db->query("SELECT a.*,b.user_real_name  FROM log_aktivitas a "
                    . "LEFT JOIN app_user b "
                    . "ON a.id_user = b.user_id "
                    . "WHERE a.id_wedding = '$id' ORDER BY datetime DESC")->result(),
            'kategori_vendor' => $this->db->get('kategori_vendor')->result(),
            'upacara_parent' => $this->db->query("SELECT
                                        c.*
                                FROM
                                        wedding_upacara a
                                        LEFT JOIN upacara_tipe b ON a.id_upacara_tipe = b.id 
                                        LEFT JOIN upacara_tipe c ON b.id_upacara = c.id 
                                WHERE 
                                       a.id_wedding = '$id'
                                GROUP BY
                                        b.id_upacara 
                                ORDER BY
                                        b.urutan ASC")->result(),
            'upacara' => $this->db->query("SELECT
                                a.*,
                                b.id AS id_field,
                                b.id_upacara,
                                b.nama_upacara 
                        FROM
                                wedding_upacara a
                        LEFT JOIN upacara_tipe b ON a.id_upacara_tipe = b.id 
                        WHERE 
                                a.id_wedding = '$id' 
                        GROUP BY b.id 
                        ORDER BY
                                b.urutan ASC")->result(),
            'acara' => $this->db->query("SELECT
                                a.*,
                                b.id AS id_field,
                                b.nama_acara 
                        FROM
                                wedding_acara a
                                LEFT JOIN acara_tipe b ON a.id_acara_tipe = b.id 
                        WHERE 
                                a.id_wedding = '$id'
                        ORDER BY
                                b.urutan ASC")->result(),
            'panitia' => $this->db->query("SELECT
                                a.*,
                                b.id AS id_field,
                                b.nama_panitia 
                        FROM
                                wedding_panitia a
                                LEFT JOIN panitia_tipe b ON a.id_panitia_tipe = b.id 
                        WHERE 
                                a.id_wedding = '$id'
                        ORDER BY
                                b.urutan ASC")->result(),
            'tambahan' => $this->db->query("SELECT
                                a.*,
                                b.id AS id_field,
                                b.nama_tambahan_paket as nama_tambahan 
                        FROM
                                wedding_tambahan a
                                LEFT JOIN tambahan_tipe b ON a.id_tambahan_tipe = b.id 
                        WHERE 
                                a.id_wedding = '$id'
                        ORDER BY
                                b.urutan ASC")->result(),
            'layout' => $this->db->query("SELECT * FROM layout WHERE id_wedding = '$id'")->result(),
            'ayahpria' => $this->db->query("SELECT * FROM keluarga WHERE id_wedding = '$id' AND HUBUNGAN = 'AYAH' AND id_pengantin = 'pria'")->row(),
            'ibupria' => $this->db->query("SELECT * FROM keluarga WHERE id_wedding = '$id' AND HUBUNGAN = 'IBU' AND id_pengantin = 'pria'")->row(),
            'saudara_pria' => $this->db->query("SELECT * FROM keluarga WHERE id_wedding = '$id' AND HUBUNGAN not in ('AYAH', 'IBU') AND id_pengantin = 'pria'")->result(),
            'ayahwanita' => $this->db->query("SELECT * FROM keluarga WHERE id_wedding = '$id' AND HUBUNGAN = 'AYAH' AND id_pengantin = 'wanita'")->row(),
            'ibuwanita' => $this->db->query("SELECT * FROM keluarga WHERE id_wedding = '$id' AND HUBUNGAN = 'IBU' AND id_pengantin = 'wanita'")->row(),
            'saudara_wanita' => $this->db->query("SELECT * FROM keluarga WHERE id_wedding = '$id' AND HUBUNGAN not in ('AYAH', 'IBU') AND id_pengantin = 'wanita'")->result(),
            'paket_acara' => $this->db->query("SELECT a.*,b.id_acara_tipe FROM acara_tipe a "
                    . "LEFT JOIN (SELECT * FROM wedding_acara WHERE id_wedding = '$id') b ON a.id=b.id_acara_tipe ORDER BY a.urutan ASC")->result(),
            'paket_upacara' => $this->db->query("SELECT
                    c1.id,b.id_upacara_tipe,
                    p.id as parent_id,
                    p.nama_upacara as parent_name,    
                    c1.nama_upacara as child_name
                FROM 
                    upacara_tipe p
                LEFT JOIN upacara_tipe c1
                    ON c1.id_upacara = p.id
                LEFT JOIN (SELECT * FROM wedding_upacara WHERE id_wedding = '$id') b ON c1.id=b.id_upacara_tipe 
                WHERE
                    p.id_upacara=0 
                GROUP BY c1.id 
                ORDER BY 
                    p.id, c1.urutan, p.nama_upacara ASC")->result(),
            'paket_panitia' => $this->db->query("SELECT a.*,b.id_panitia_tipe FROM panitia_tipe a "
                    . "LEFT JOIN (SELECT * FROM wedding_panitia WHERE id_wedding = '$id') b ON a.id=b.id_panitia_tipe ORDER BY a.urutan ASC")->result(),
            'paket_tambahan' => $this->db->query("SELECT a.*,b.id_tambahan_tipe FROM tambahan_tipe a "
                    . "LEFT JOIN (SELECT * FROM wedding_tambahan WHERE id_wedding = '$id') b ON a.id=b.id_tambahan_tipe ORDER BY a.urutan ASC")->result(),
        );
        render('wedding/form2', $data);
    }

    public function saveWedding() {
        $id_wedding = $_POST['id_wedding'];
        $data['title'] = $_POST["title"];
        $data['tanggal'] = $_POST["tanggal_pernikahan"];
        $data['waktu'] = $_POST["waktu_pernikahan"];
        $data['tempat'] = $_POST["lokasi_pernikahan"];
        $data['alamat'] = $_POST["alamat_pernikahan"];
        $data['tema'] = $_POST["tema_pernikahan"];
        $data['hashtag'] = $_POST["hastag_pernikahan"];
        $data['penyelenggara'] = $_POST["penyelenggara"];
        $data['undangan'] = $_POST["jumlah_undangan"];
        $data['status'] = 1;
        $key['id'] = $_POST['id'];
        $this->db->update('wedding', $data, $key);
        $this->wedding_model->insertLog($id_wedding, "Merubah data pernikahan");
    }

    public function saveBiodataPria() {
        $id = $_POST['id_wedding'];
        $id_wedding = $_POST['id_wedding'];
        $data['id_wedding'] = $id;
        $data['gender'] = "L";
        $data['nama_lengkap'] = isset($_POST["nama_lengkap_pria"]) ? $_POST["nama_lengkap_pria"] : "";
        $data['nama_panggilan'] = $_POST['nama_panggilan_pria'];
        $data['alamat_sekarang'] = $_POST['alamat_sekarang_pria'];
        $data['alamat_nikah'] = $_POST['alamat_nikah_pria'];
        $data['tempat_lahir'] = $_POST['tempat_lahir_pria'];
        $data['tanggal_lahir'] = $_POST['tanggal_lahir_pria'];
        $data['no_hp'] = $_POST['no_hp_pria'];
        $data['email'] = $_POST['email_pria'];
        $data['agama'] = $_POST['agama_pria'];
        $data['pendidikan'] = $_POST['pendidikan_pria'];
        $data['hobi'] = $_POST['hobi_pria'];
        $data['sosmed'] = 1;
        $data['status'] = 1;

        $user['user_real_name'] = $_POST['nama_lengkap_pria'];
        $user['user_email'] = $_POST['email_pria'];
        $user['user_address'] = $_POST['alamat_sekarang_pria'];
        $user['user_phone'] = $_POST['no_hp_pria'];

        if (isset($_FILES)) {
            $path = realpath(APPPATH . '../../files/images/');

            $this->upload->initialize(array(
                'upload_path' => $path,
                'allowed_types' => 'png|jpg|gif',
                'max_size' => '5000',
                'max_width' => '3000',
                'max_height' => '3000'
            ));

            if ($this->upload->do_upload('foto_pria')) {
                $data_upload = $this->upload->data();
                $this->image_lib->initialize(array(
                    'image_library' => 'gd2',
                    'source_image' => $path . '/' . $data_upload['file_name'],
                    'maintain_ratio' => false,
                    //  'create_thumb' => true,
                    'overwrite' => TRUE
                ));
                if ($this->image_lib->resize()) {
                    $data['photo'] = $data_upload['raw_name'] . $data_upload['file_ext'];
                } else {
                    $data['photo'] = $data_upload['file_name'];
                }
            } else {
//                $data['photo'] = "";
            }
        } else {
//            $data['photo'] = "";
        }

        $key['id'] = $_POST['id'];
        $key_user['id_pengantin'] = $_POST['id'];
        $key_user['id_wedding'] = $_POST['id_wedding'];
        $this->db->update('pengantin', $data, $key);
        $this->db->update('app_user', $user, $key_user);
        $this->wedding_model->insertLog($id_wedding, "Merubah biodata pengantin pria");
    }

    public function saveBiodataWanita() {
        $id = $_POST['id_wedding'];
        $id_wedding = $_POST['id_wedding'];
        $_POST = $this->input->post();
        $data['id_wedding'] = $id;
        $data['gender'] = "P";
        $data['nama_lengkap'] = $_POST["nama_lengkap_wanita"];
        $data['nama_panggilan'] = $_POST['nama_panggilan_wanita'];
        $data['alamat_sekarang'] = $_POST['alamat_sekarang_wanita'];
        $data['alamat_nikah'] = $_POST['alamat_nikah_wanita'];
        $data['tempat_lahir'] = $_POST['tempat_lahir_wanita'];
        $data['tanggal_lahir'] = $_POST['tanggal_lahir_wanita'];
        $data['no_hp'] = $_POST['no_hp_wanita'];
        $data['email'] = $_POST['email_wanita'];
        $data['agama'] = $_POST['agama_wanita'];
        $data['pendidikan'] = $_POST['pendidikan_wanita'];
        $data['hobi'] = $_POST['hobi_wanita'];
        $data['sosmed'] = $_POST['sosmed_wanita'];
        $data['status'] = 1;

        $user['user_real_name'] = $_POST['nama_lengkap_wanita'];
        $user['user_email'] = $_POST['email_wanita'];
        $user['user_address'] = $_POST['alamat_sekarang_wanita'];
        $user['user_phone'] = $_POST['no_hp_wanita'];
        if (isset($_FILES)) {
            $path = realpath(APPPATH . '../../files/images/');

            $this->upload->initialize(array(
                'upload_path' => $path,
                'allowed_types' => 'png|jpg|gif',
                'max_size' => '5000',
                'max_width' => '3000',
                'max_height' => '3000'
            ));

            if ($this->upload->do_upload('foto_wanita')) {
                $data_upload = $this->upload->data();
                $this->image_lib->initialize(array(
                    'image_library' => 'gd2',
                    'source_image' => $path . '/' . $data_upload['file_name'],
                    'maintain_ratio' => false,
                    //  'create_thumb' => true,
                    'overwrite' => TRUE
                ));
                if ($this->image_lib->resize()) {
                    $data['photo'] = $data_upload['raw_name'] . $data_upload['file_ext'];
                } else {
                    $data['photo'] = $data_upload['file_name'];
                }
            } else {
//                $data['photo'] = "";
            }
        } else {
//            $data['photo'] = "";
        }
        $key['id'] = $_POST['id'];
        $key_user['id_pengantin'] = $_POST['id'];
        $key_user['id_wedding'] = $_POST['id_wedding'];
        $this->db->update('pengantin', $data, $key);
        $this->db->update('app_user', $user, $key_user);
        $this->wedding_model->insertLog($id_wedding, "Merubah biodata pengantin wanita");
    }

    public function vendor() {
        $uri = $this->uri->segment(3);
        $id_wedding = isset($_POST['id_wedding']) ? $_POST['id_wedding'] : "";
//        $this->db->where('id', $uri);
        if ($uri == "add") {
            if ($_POST['id_vendor_pengantin'] == "") {
                $data = array(
                    'id_wedding' => $_POST['id_wedding'],
                    'id_kategori' => $_POST['kategori_vendor'],
                    'id_vendor' => $_POST['vendor'],
                    'nama_vendor' => $_POST['nama_vendor'],
                    'cp' => $_POST['cp'],
                    'nohp_cp' => $_POST['nohp'],
                    'biaya' => $_POST['biaya'],
                    'dibayaroleh' => $_POST['bayar_oleh'],
                );
                $this->db->insert('vendor_pengantin', $data);
                $this->wedding_model->insertLog($id_wedding, "Menambah vendor");
                $return = array(
                    'code' => '200',
                    'msg' => 'Berhasil menambah vendor'
                );
                echo json_encode($return);
            } else {
                $key['id'] = $_POST['id_vendor_pengantin'];
                $data = array(
                    'id_wedding' => $_POST['id_wedding'],
                    'id_kategori' => $_POST['kategori_vendor'],
                    'id_vendor' => $_POST['vendor'],
                    'nama_vendor' => $_POST['nama_vendor'],
                    'cp' => $_POST['cp'],
                    'nohp_cp' => $_POST['nohp'],
                    'biaya' => $_POST['biaya'],
                    'dibayaroleh' => $_POST['bayar_oleh'],
                );
                $this->db->update('vendor_pengantin', $data, $key);
                $this->wedding_model->insertLog($id_wedding, "Merubah data vendor");
                $result = array(
                    'code' => 200
                );
                echo json_encode($result);
            }
        } else if ($uri == "delete") {
            $key['id'] = $_GET['id'];
            $this->db->delete('vendor_pengantin', $key);
            $this->wedding_model->insertLog($id_wedding, "Menghapus data vendor");
            $result = array(
                'code' => 200
            );
            echo json_encode($result);
        } else if ($uri == "get") {
            $key['id'] = $_GET['id'];
            $data = $this->db->get_where('vendor_pengantin', $key)->row();
            echo json_encode($data);
        }
    }

    public function confirmPayment() {
        $id = $_GET['id'];
        $key['id'] = $id;
        $data['status'] = 1;
        $detail = $this->db->get_where('payment', $key)->row();
        $key2['id'] = $detail->id_vendor;
        $vendor = $this->db->get_where('vendor_pengantin', $key2)->row();
        if ($vendor->biaya == $vendor->terbayar) {
            $status = 3;
        } else {
            $status = 2;
        }
        $data2['status'] = $status;

        $this->db->update('payment', $data, $key);
        $this->db->update('vendor_pengantin', $data2, $key2);
    }

    public function payment() {
        $id_wedding = isset($_POST['id_wedding']) ? $_POST['id_wedding'] : "";
        $key['id'] = $_POST['id_payment_pengantin'];
        $vendor = $this->db->get_where('vendor_pengantin', $key)->row();
        $total_terbayar = $vendor->terbayar;
        $total_biaya = $vendor->biaya;
        $temp_terbayar = $total_terbayar + $_POST['terbayar'];
        if ($temp_terbayar >= $total_biaya) {
            $status = 2;
        } else if ($temp_terbayar < $total_biaya) {
            $status = 1;
        }
        $upvendor['status'] = $status;
        $upvendor['terbayar'] = $temp_terbayar;
        $this->db->update('vendor_pengantin', $upvendor, $key);
        $key['id'] = $_POST['id_payment_pengantin'];
        $data = array(
            'id_vendor' => $_POST['id_payment_pengantin'],
            'terbayar' => $_POST['terbayar'],
            'status' => $_POST['status_pembayaran'],
            'tanggal_bayar' => date('Y-m-d', strtotime($_POST['tanggal_bayar'])),
            'cara_pembayaran' => $_POST['cara'],
            'dibayarke' => $_POST['dibayarke']
        );
        if (isset($_FILES)) {
            $path = realpath(APPPATH . '../files/bukti/');
            $this->upload->initialize(array(
                'upload_path' => $path,
                'allowed_types' => 'png|jpg|gif|docx|doc|xls|xlsx|pdf',
                'max_size' => '5000',
                'max_width' => '3000',
                'max_height' => '3000'
            ));

            if ($this->upload->do_upload('bukti')) {
                $data_upload = $this->upload->data();
                $this->image_lib->initialize(array(
                    'image_library' => 'gd2',
                    'source_image' => $path . '/' . $data_upload['file_name'],
                    'maintain_ratio' => false,
                    'overwrite' => TRUE
                ));
                if ($this->image_lib->resize()) {
                    $data['bukti'] = $data_upload['raw_name'] . $data_upload['file_ext'];
                } else {
                    $data['bukti'] = $data_upload['file_name'];
                }
            }
        }
        $this->db->insert('payment', $data);
        $this->wedding_model->insertLog($id_wedding, "Payment vendor " . $_POST['nama_vendor_payment']);
        $result = array(
            'code' => 200
        );
        echo json_encode($result);
    }

    public function meeting() {
        $uri = $this->uri->segment(3);
        $id = isset($_GET['id']) ? $_GET['id'] : "";
        $id_wedding = isset($_POST['id_wedding']) ? $_POST['id_wedding'] : "";
        $wedding = array();
        $pria = array();
        $wanita = array();
        if ($id_wedding != "") {
            $keyy['id'] = $id_wedding;
            $wedding = $this->db->get_where('wedding', $keyy)->row();
            $keyyy['id_wedding'] = $id_wedding;
            $keyyy['gender'] = 'L';
            $key_w['id_wedding'] = $id_wedding;
            $key_w['gender'] = 'P';
            $pria = $this->db->get_where('pengantin', $keyyy)->row();
            $wanita = $this->db->get_where('pengantin', $key_w)->row();
        }
        if ($uri == "add") {
            $_POST['tanggal'] = date('Y-m-d', strtotime($_POST['tanggal']));
            if ($_POST['id_meeting'] == "") {
                $data = array(
                    'tanggal' => $_POST['tanggal'],
                    'waktu' => $_POST['waktu'],
                    'tempat' => $_POST['tempat'],
                    'keperluan' => $_POST['materi'],
                    'id_wedding' => $_POST['id_wedding'],
//                    'kepada' => $_POST['kepada']
                );
                $this->db->insert('jadwal_meeting', $data);
                $this->wedding_model->insertLog($_POST['id_wedding'], "Menambah jadwal meeting");
                $this->wedding_model->sendEmailMeeting($pria->email, $wedding, $data);
                $this->wedding_model->sendEmailMeeting($wanita->email, $wedding, $data);
                $result = array(
                    'code' => 200
                );
                echo json_encode($result);
            } else {
                $key['id'] = $_POST['id_meeting'];
                $data = array(
                    'tanggal' => $_POST['tanggal'],
                    'waktu' => $_POST['waktu'],
                    'tempat' => $_POST['tempat'],
                    'keperluan' => $_POST['materi'],
                    'id_wedding' => $_POST['id_wedding'],
//                    'kepada' => $_POST['kepada']
                );
                $this->db->update('jadwal_meeting', $data, $key);
                $this->wedding_model->insertLog($_POST['id_wedding'], "Menambah jadwal meeting");
                $result = array(
                    'code' => 200
                );
                echo json_encode($result);
            }
        } else if ($uri == "delete") {
            $key['id'] = $_GET['id'];
            $this->db->delete('jadwal_meeting', $key);
            $this->wedding_model->insertLog($id_wedding, "Menghapus jadwal meeting");
            $result = array(
                'code' => 200
            );
            echo json_encode($result);
        } else if ($uri == "get") {
            $key['id'] = $_GET['id'];
            $data = $this->db->get_where('jadwal_meeting', $key)->row();
            echo json_encode($data);
        }
    }

    public function undangan() {
        $uri = $this->uri->segment(3);
        if ($uri == "add") {
            if ($_POST['id_undangan'] == "") {
                $data = array(
                    'id_wedding' => $_POST['id_wedding'],
                    // 'id_pengantin' => $_POST[''],
                    'nama' => $_POST['nama_lengkap'],
                    'alamat' => $_POST['alamat_undangan'],
                    'tipe_undangan' => $_POST['tipe_undangan'],
                    'nohp' => $_POST['nohp_undangan']
                );
                $this->db->insert('undangan', $data);
                $this->wedding_model->insertLog($_POST['id_wedding'], "Menambah data undangan");
                $result = array(
                    'code' => 200
                );
                echo json_encode($result);
            } else {
                $key['id'] = $_POST['id_undangan'];
                $data = array(
                    'id_wedding' => $_POST['id_wedding'],
                    // 'id_pengantin' => $_POST[''],
                    'nama' => $_POST['nama_lengkap'],
                    'alamat' => $_POST['alamat_undangan'],
                    'tipe_undangan' => $_POST['tipe_undangan'],
                    'nohp' => $_POST['nohp_undangan']
                );
                $this->db->update('undangan', $data, $key);
                $this->wedding_model->insertLog($_POST['id_wedding'], "Merubah data undangan");
                $result = array(
                    'code' => 200
                );
                echo json_encode($result);
            }
        } else if ($uri == "delete") {
            $key['id'] = $_GET['id'];
            $this->db->delete('undangan', $key);
            $result = array(
                'code' => 200
            );
            echo json_encode($result);
            $this->wedding_model->insertLog($_POST['id_wedding'], "Menghapus data undangan");
        } else if ($uri == "upload") {
            $id_wedding = $_POST['id_wedding_upload_undangan'];
            $this->uploadUndangan();
            $this->wedding_model->insertLog($id_wedding, "Mengupload data undangan");
        } else if ($uri == "barcode") {
            $id_wedding = $_GET['id'];
            $this->barcodeUndangan();
            $this->wedding_model->insertLog($id_wedding, "Mencetak Barcode undangan");
        } else if ($uri == "get") {
            $key['id'] = $_GET['id'];
            $data = $this->db->get_where('undangan', $key)->row();
            echo json_encode($data);
        }
    }

    public function uploadUndangan() {

//        require_once base_url() . '/application/libraries/Excel/reader.php';
        $this->load->library('Excel/Spreadsheet_Excel_Reader');
        $id_wedding = $_POST['id_wedding_upload_undangan'];
        if (isset($_FILES['files']) && $_FILES['files']['size'] > 0) {
            $result = true;
            $data = new Spreadsheet_Excel_Reader();
            $data->setOutputEncoding('CP1251');
            $typeFile = $_FILES['files']['type'];
            $data->read($_FILES['files']['tmp_name']);

            $listSiswa = array();
            $message = array();
            $validFormat = false;
            foreach ($data->sheets[0]['cells'] as $i => $val) {
                if (trim($val[1]) == "") {
                    // nothing to do
                } else if (strtoupper(trim($val[1])) == "NO") {
                    if (strtoupper(trim($val[1])) == "NO" &&
                            strtoupper(trim($val[2])) == "NAMA" &&
                            strtoupper(trim($val[3])) == "ALAMAT" &&
                            strtoupper(trim($val[4])) == "TIPE") {
                        $validFormat = true;
                    } else {
                        $msg .= "";
                        break;
                    }
                } else if ($validFormat == true) {
                    $validData = true;
                    if (!isset($val[2])) {
                        $validData = false;
                    } else {
                        $nama_lengkap = trim($val[2]);
                    }

                    if (!isset($val[3])) {
                        $validData = false;
                    } else {
                        $alamat = trim($val[3]);
                    }

                    if (!isset($val[4])) {
                        $tipe = "";
                    } else {
                        $tipe = trim($val[4]);
                    }

                    $data = array(
                        'nama' => $nama_lengkap,
                        'alamat' => $alamat,
                        'tipe_undangan' => $tipe,
                        'id_wedding' => $id_wedding
                    );
                    $this->db->insert('undangan', $data);
                }
            }
            $response = array(
                'code' => '200',
                'message' => $message,
            );
        } else {
            $response = array(
                'code' => '400',
                'message' => 'Tidak ada file yang di upload atau File yang diupload kosong',
            );
        }

        echo json_encode($response);
    }

    public function barcodeUndangan() {
        $this->load->library('QRCode/QRCodeLib');
        $qr_lib = new QRCodeLib();
        $qr_name = '';
        $new_qr = '';
        $id_wedding = $_GET['id'];
        $undangan = $this->db->query("SELECT * FROM undangan WHERE id_wedding = '$id_wedding'")->result();
        foreach ($undangan as $val) {
            $barcode = $val->barcode;
            if ($val->barcode == "") {
                $qr_lib->setFileName($val->id . "_QR_Code" . date('Y-m-d_H_i_s') . ".png");
                $qr_lib->setSize("5");
                if ($qr_lib->generateImage("undangan_" . $val->id)) {
                    $key['id'] = $val->id;
                    $data['barcode'] = $qr_lib->getFileName();
                    $barcode = $qr_lib->getFileName();
                    $this->db->update('undangan', $data, $key);
                }
            }
            echo "<table style='float:left' border='1' cellpading=0 cellspacing=0><tr><td>";
            echo "<img src='" . base_url() . "/files/qrcode/" . $barcode . "' width='140px'>";
            echo "</td></tr>";
            echo "<tr><td align='center'>";
            echo $val->nama;
            echo "</td></tr>";
            echo "</table>";
            echo "<script>window.print()</script>";
        }
    }

    public function upacara() {
        $uri = $this->uri->segment(3);
        $id = isset($_GET['id']) ? $_GET['id'] : "";
        if ($uri == "field") {
            $id_wedding = $_GET['id_wedding'];
            $field = $this->db->query("SELECT a.*,b.value FROM upacara_field a "
                            . "LEFT JOIN (SELECT * FROM upacara_data WHERE id_wedding = '$id_wedding') b ON b.id_upacara_field = a.id "
                            . "WHERE a.id_upacara_tipe = '$id' "
                            . "ORDER BY a.urutan ASC")->result();
            $data = array(
                'field' => $field,
                'type' => 'upacara'
            );
            $this->load->view('wedding/field_upacara', $data);
        } else if ($uri == "add") {
            $id_wedding = $_POST['id_wedding'];
            $id_acara = $_POST['id'];
            $value = $_POST['value'];
            if (isset($_POST['type']) && $_POST['type'] == "addabletext") {
                $value = json_encode($_POST[$value]);
            }

            $cek = $this->db->query("SELECT * FROM upacara_data WHERE id_wedding = '$id_wedding' AND id_upacara_field = '$id_acara'")->result();
            if (count($cek) > 0) {
                $key = array(
                    'id_wedding' => $id_wedding,
                    'id_upacara_field' => $id_acara
                );
                $data = array(
                    'value' => $value
                );
                $this->db->update('upacara_data', $data, $key);
            } else {
                $data = array(
                    'id_wedding' => $id_wedding,
                    'id_upacara_field' => $id_acara,
                    'value' => $value
                );
                $this->db->insert('upacara_data', $data);
            }
            $this->wedding_model->insertLog($id_wedding, "Mengisi paket upacara");
        }
    }

    public function acara() {
        $uri = $this->uri->segment(3);
        $id = isset($_GET['id']) ? $_GET['id'] : "";
        if ($uri == "field") {
            $id_wedding = $_GET['id_wedding'];
            $field = $this->db->query("SELECT a.*,b.value FROM acara_field a "
                            . "LEFT JOIN (SELECT * FROM acara_data WHERE id_wedding = '$id_wedding') b  "
                            . "ON a.id = b.id_acara_field "
                            . "WHERE a.id_acara_tipe = '$id' "
                            . "ORDER BY a.urutan ASC")->result();
            $data = array(
                'field' => $field,
                'type' => 'acara'
            );
            $this->load->view('wedding/field_upacara', $data);
        } else if ($uri == "add") {
            $id_wedding = $_POST['id_wedding'];
            $id_acara = $_POST['id'];
            $value = $_POST['value'];
            if (isset($_POST['type']) && $_POST['type'] == "addabletext") {
                $value = json_encode($_POST[$value]);
            }
            $cek = $this->db->query("SELECT * FROM acara_data WHERE id_wedding = '$id_wedding' AND id_acara_field = '$id_acara'")->result();
            if (count($cek) > 0) {
                $key = array(
                    'id_wedding' => $id_wedding,
                    'id_acara_field' => $id_acara
                );
                $data = array(
                    'value' => $value
                );
                $this->db->update('acara_data', $data, $key);
            } else {
                $data = array(
                    'id_wedding' => $id_wedding,
                    'id_acara_field' => $id_acara,
                    'value' => $value
                );
                $this->db->insert('acara_data', $data);
            }
            $this->wedding_model->insertLog($id_wedding, "Mengisi paket acara");
        }
    }

    public function panitia() {
        $uri = $this->uri->segment(3);
        $id = isset($_GET['id']) ? $_GET['id'] : "";
        if ($uri == "field") {
            $id_wedding = $_GET['id_wedding'];
            $field = $this->db->query("SELECT a.*,b.value FROM panitia_field a "
                            . "LEFT JOIN (SELECT * FROM panitia_data WHERE id_wedding = '$id_wedding') b  "
                            . "ON a.id = b.id_panitia_field "
                            . "WHERE a.id_panitia_tipe = '$id' "
                            . "ORDER BY a.urutan ASC")->result();
            $data = array(
                'field' => $field,
                'type' => 'panitia'
            );
            $this->load->view('wedding/field_upacara', $data);
        } else if ($uri == "add") {
            $id_wedding = $_POST['id_wedding'];
            $id_acara = $_POST['id'];
            $value = $_POST['value'];
            if (isset($_POST['type']) && $_POST['type'] == "addabletext") {
                $value = json_encode($_POST[$value]);
            }
            $cek = $this->db->query("SELECT * FROM panitia_data WHERE id_wedding = '$id_wedding' AND id_panitia_field = '$id_acara'")->result();
            if (count($cek) > 0) {
                $key = array(
                    'id_wedding' => $id_wedding,
                    'id_panitia_field' => $id_acara
                );
                $data = array(
                    'value' => $value
                );
                $this->db->update('panitia_data', $data, $key);
            } else {
                $data = array(
                    'id_wedding' => $id_wedding,
                    'id_panitia_field' => $id_acara,
                    'value' => $value
                );
                $this->db->insert('panitia_data', $data);
            }
            $this->wedding_model->insertLog($id_wedding, "Mengisi panitia");
        }
    }

    public function tambahan() {
        $uri = $this->uri->segment(3);
        $id = isset($_GET['id']) ? $_GET['id'] : "";
        if ($uri == "field") {
            $id_wedding = $_GET['id_wedding'];
            $field = $this->db->query("SELECT a.*,b.value FROM tambahan_field a "
                            . "LEFT JOIN (SELECT * FROM tambahan_data WHERE id_wedding = '$id_wedding') b  "
                            . "ON a.id = b.id_tambahan_field "
                            . "WHERE id_tambahan_tipe = '$id' "
                            . "ORDER BY urutan ASC")->result();
            $data = array(
                'field' => $field,
                'type' => 'tambahan'
            );
            $this->load->view('wedding/field_upacara', $data);
        } else if ($uri == "add") {
            $id_wedding = $_POST['id_wedding'];
            $id_acara = $_POST['id'];
            $value = $_POST['value'];
            if (isset($_POST['type']) && $_POST['type'] == "addabletext") {
                $value = json_encode($_POST[$value]);
            }
            $cek = $this->db->query("SELECT * FROM tambahan_data WHERE id_wedding = '$id_wedding' AND id_tambahan_field = '$id_acara'")->result();
            if (count($cek) > 0) {
                $key = array(
                    'id_wedding' => $id_wedding,
                    'id_tambahan_field' => $id_acara
                );
                $data = array(
                    'value' => $value
                );
                $this->db->update('tambahan_data', $data, $key);
            } else {
                $data = array(
                    'id_wedding' => $id_wedding,
                    'id_tambahan_field' => $id_acara,
                    'value' => $value
                );
                $this->db->insert('tambahan_data', $data);
            }
            $this->wedding_model->insertLog($id_wedding, "Mengisi paket tambahan/lampiran");
        }
    }

    public function layout() {
        $id_wedding = $_POST['id_wedding'];
        $nama = $_POST['nama'];
        $data['nama_layout'] = $nama;
        $data['id_wedding'] = $id_wedding;
        if (isset($_FILES)) {
            $path = realpath(APPPATH . '../files/images/');

            $this->upload->initialize(array(
                'upload_path' => $path,
                'allowed_types' => 'png|jpg|gif',
                'max_size' => '15000'
            ));

            if ($this->upload->do_upload('files')) {
                $data_upload = $this->upload->data();
                $data['layout'] = $data_upload['file_name'];
            } else {
                $data['layout'] = "";
            }
        } else {
            $data['layout'] = "";
        }
        $this->db->insert('layout', $data);
        $result = array(
            'code' => 200
        );
        echo json_encode($result);
    }

    public function deleteLayout() {
        $key['id'] = $_GET['id'];
        $this->db->delete('layout', $key);
        $result = array(
            'code' => 200
        );
        echo json_encode($result);
    }

    public function cetak() {
        $path_template = realpath(APPPATH . '../files/template/');
        $path_output = realpath(APPPATH . '../files/output/');
        $id = $_GET['id'];
        $wedding = $this->db->query("SELECT * FROM wedding WHERE id = '$id' ")->row();
        $company_id = $wedding->id_company;
        $company = $this->db->query("SELECT * FROM company WHERE id = '$company_id' ")->row();
        $pria = $this->db->query("SELECT * FROM pengantin WHERE id_wedding = '$id' AND gender = 'L' ")->row();
        $wanita = $this->db->query("SELECT * FROM pengantin WHERE id_wedding = '$id' AND gender = 'P' ")->row();

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
        $this->PhpExcelTemplator->saveToFile($templateFile, $fileName, $params);
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

    public function saveOrtu() {
        $tipe = $_POST['tipe'];
        $key = array();
        if ($tipe == "pria") {
            $key['id_pengantin'] = "pria";
        } else {
            $key['id_pengantin'] = "wanita";
        }
        $key['id_wedding'] = $_POST['id_wedding'];
        $key['hubungan'] = 'AYAH';
        $cek_ayah = $this->db->get_where('keluarga', $key)->result();
        if (empty($cek_ayah)) {
            $ayah['id_wedding'] = $key['id_wedding'];
            $ayah['id_pengantin'] = $key['id_pengantin'];
            $ayah['hubungan'] = 'AYAH';
            $ayah['nama'] = $_POST['ayah'];
            $ayah['no_hp'] = $_POST['nohpayah'];
            $this->db->insert('keluarga', $ayah);
        } else {
            $ayah['hubungan'] = 'AYAH';
            $ayah['nama'] = $_POST['ayah'];
            $ayah['no_hp'] = $_POST['nohpayah'];
            $this->db->update('keluarga', $ayah, $key);
        }
        $keyibu['id_pengantin'] = $key['id_pengantin'];
        $keyibu['id_wedding'] = $key['id_wedding'];
        $keyibu['hubungan'] = 'IBU';
//        print_r($keyibu);
        $cek_ibu = $this->db->get_where('keluarga', $keyibu)->result();
//        print_r($cek_ibu);
        if (empty($cek_ibu)) {
            $ibu['id_wedding'] = $key['id_wedding'];
            $ibu['id_pengantin'] = $key['id_pengantin'];
            $ibu['hubungan'] = 'IBU';
            $ibu['nama'] = $_POST['ibu'];
            $ibu['no_hp'] = $_POST['nohpibu'];
            $this->db->insert('keluarga', $ibu);
        } else {
            $ibu['hubungan'] = 'IBU';
            $ibu['nama'] = $_POST['ibu'];
            $ibu['no_hp'] = $_POST['nohpibu'];
            $this->db->update('keluarga', $ibu, $keyibu);
        }
        $result['code'] = 200;
        echo json_encode($result);
    }

    function getKeluarga() {
        $key['id'] = $_GET['id'];
        $data = $this->db->get_where('keluarga', $key)->row();
        echo json_encode($data);
    }

    function deleteKeluarga() {
        $key['id'] = $_GET['id'];
        $this->db->delete('keluarga', $key);
        $data['code'] = 200;
        echo json_encode($data);
    }

    public function saveSaudara() {
        $tipe = $_POST['tipe'];
        $data = array();
        if ($tipe == "pria") {
            $data['id_pengantin'] = "pria";
        } else {
            $data['id_pengantin'] = "wanita";
        }
        $data['id_wedding'] = $_POST['id_wedding'];
        $data['nama'] = $_POST['nama'];
        $data['hubungan'] = $_POST['hubungan'];
        $data['no_hp'] = $_POST['nohp'];
        if (isset($_POST['idsaudara']) && $_POST['idsaudara'] != "") {
            $key['id'] = $_POST['idsaudara'];
            $this->db->update('keluarga', $data, $key);
        } else {
            $this->db->insert('keluarga', $data);
        }
        $result['code'] = 200;
        echo json_encode($result);
    }

    public function editAcara() {
        $_POST = $this->input->post();
        $acara = isset($_POST['acara']) ? $_POST['acara'] : array();
        $id_wedding = $_POST['id_wedding'];
        $key['id_wedding'] = $id_wedding;
        $this->db->delete('wedding_acara', $key);
        $no = 1;
        if (!empty($acara)) {
            foreach ($acara as $val) {
                $data['id_wedding'] = $id_wedding;
                $data['id_acara_tipe'] = $val;
                $data['urutan'] = $no++;
                $this->db->insert('wedding_acara', $data);
            }
        }
        $result['code'] = 200;
        echo json_encode($result);
    }

    public function editUpacara() {
        $_POST = $this->input->post();
        $id_wedding = $_POST['id_wedding'];
        $key['id_wedding'] = $id_wedding;
        $this->db->delete('wedding_upacara', $key);
        $upacara = isset($_POST['upacara']) ? $_POST['upacara'] : array();
        $no = 1;
        if (!empty($upacara)) {
            foreach ($upacara as $val) {

                $data['id_wedding'] = $id_wedding;
                $data['id_upacara_tipe'] = $val;
                $data['urutan'] = $no++;
                $this->db->insert('wedding_upacara', $data);
            }
        }
        $result['code'] = 200;
        echo json_encode($result);
    }

    public function editPanitia() {
        $_POST = $this->input->post();
        $id_wedding = $_POST['id_wedding'];
        $key['id_wedding'] = $id_wedding;
        $this->db->delete('wedding_panitia', $key);
        $panitia = isset($_POST['panitia']) ? $_POST['panitia'] : array();
        $no = 1;
        if (!empty($panitia)) {
            foreach ($panitia as $val) {

                $data['id_wedding'] = $id_wedding;
                $data['id_panitia_tipe'] = $val;
                $data['urutan'] = $no++;
                $this->db->insert('wedding_panitia', $data);
            }
        }
        $result['code'] = 200;
        echo json_encode($result);
    }

    public function editTambahan() {
        $_POST = $this->input->post();
        $tambahan = isset($_POST['tambahan']) ? $_POST['tambahan'] : array();
        $id_wedding = $_POST['id_wedding'];
        $key['id_wedding'] = $id_wedding;
        $this->db->delete('wedding_tambahan', $key);
        $no = 1;
        if (!empty($tambahan)) {
            foreach ($tambahan as $val) {

                $data['id_wedding'] = $id_wedding;
                $data['id_tambahan_tipe'] = $val;
                $data['urutan'] = $no++;
                $this->db->insert('wedding_tambahan', $data);
            }
        }
        $result['code'] = 200;
        echo json_encode($result);
    }

    public function nonaktifkanUser() {
        $id_wedding = $_GET['id'];
        $key['id_wedding'] = $id_wedding;
        $data['status'] = 0;
        $data['user_active'] = 0;
        $this->db->update('app_user', $data, $key);
        $result['code'] = 200;
        echo json_encode($result);
    }

    public function finishWedding() {
        $id_wedding = $_GET['id'];
        $key['id'] = $id_wedding;
        $data['status'] = 0;
        $this->db->update('wedding', $data, $key);
        $result['code'] = 200;
        echo json_encode($result);
    }

}

/* End of file Wedding.php */
/* Location: ./application/controllers/Wedding.php */
