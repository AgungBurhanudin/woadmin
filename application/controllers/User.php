<?php

defined('BASEPATH') or exit('No direct script access allowed');

class User extends CI_Controller {

    public function __construct() {
        parent::__construct();
        checkToken();
    }

    public function index() {
        $auth = $this->session->userdata('auth');
        $group = $auth['group'];
        $id_company = $auth['company'];
        $where = "WHERE 1=1 ";
        if ($group == 1) {
            $where .= "";
        } else {
            $where .= "  AND user_company = '$id_company'";
        }

        $jenis = isset($_POST['jenis_group']) ? $_POST['jenis_group'] : "";
        if ($jenis == "0") {
            $where .= " AND user_group_id IN (1,35,36)";
        } else if ($jenis == "1") {
            $where .= " AND user_group_id IN (37)";
        }else{
            $where .= " AND user_group_id IN (1,35,36)";
            $jenis = 0;
        }
        $query = "SELECT * FROM app_user $where";
        $data = array(
            'data' => $this->db->query($query)->result(),
            'jenis_group' => $jenis
        );
        render('user/data', $data);
    }

    public function add() {
        $auth = $this->session->userdata('auth');
        $group = $auth['group'];
        $id_company = $auth['company'];
        if ($group != 1) {
            $company = "SELECT * FROM company WHERE id = '$id_company'";
            $app_group = "SELECT * FROM app_group WHERE group_id != 1";
        } else {
            $company = "SELECT * FROM company";
            $app_group = "SELECT * FROM app_group ";
        }
        $data = array(
            'data_company' => $this->db->query($company)->result(),
            'app_group' => $this->db->query($app_group)->result(),
        );
        render('user/form', $data);
    }

    public function save() {
        $post = $_POST;
        $id = $this->input->post("id");

        $data['user_group_id'] = $post['user_group'];
        $data['user_company'] = $post['user_company'];
        $data['user_real_name'] = $post['user_real_name'];
        $data['user_user_name'] = $post['user_user_name'];
        $data['user_password'] = md5($post['password']);
        $data['user_phone'] = $post['user_phone'];
        $data['user_email'] = $post['user_email'];
        $data['user_address'] = $post['user_address'];
        $data['user_desc'] = $post['user_desc'];
        if (isset($_FILES)) {
            $path = realpath(APPPATH . '../files/foto/');

            $this->upload->initialize(array(
                'upload_path' => $path,
                'allowed_types' => 'png|jpg|gif',
                'max_size' => '5000',
                'max_width' => '3000',
                'max_height' => '3000'
            ));

            if ($this->upload->do_upload()) {
                $data_upload = $this->upload->data();
                $this->image_lib->initialize(array(
                    'image_library' => 'gd2',
                    'source_image' => $path . '/' . $data_upload['file_name'],
                    'maintain_ratio' => false,
                    //  'create_thumb' => true,
                    'overwrite' => TRUE
                ));
                if ($this->image_lib->resize()) {
                    $data['user_foto'] = $data_upload['raw_name'] . $data_upload['file_ext'];
                } else {
                    $data['user_foto'] = $data_upload['file_name'];
                }
            } else {
                $data['user_foto'] = "";
            }
        }
        if (empty($id)) {
            // print_r($data);
            $this->db->insert("app_user", $data);
            $msg = "Berhasil menambah user";
        } else {
            $key['user_id'] = $id;
            $this->db->update("app_user", $data, $key);
            $msg = "Berhasil merubah user";
        }
        $this->session->set_flashdata('success', $msg);
        redirect(base_url() . 'User', 'refresh');
    }

    public function edit() {
        $auth = $this->session->userdata('auth');
        $group = $auth['group'];
        $id_company = $auth['company'];
        if ($group != 1) {
            $company = "SELECT * FROM company WHERE id = '$id_company'";
            $app_group = "SELECT * FROM app_group WHERE group_id != 1";
        } else {
            $company = "SELECT * FROM company";
            $app_group = "SELECT * FROM app_group ";
        }
        $key['user_id'] = $this->input->get("id");
        $data = array(
            'data_user' => $this->db->get_where("app_user", $key)->result(),
            'data_company' => $this->db->query($company)->result(),
            'app_group' => $this->db->query($app_group)->result(),
        );
        render("user/form", $data);
    }

    public function delete() {
        $id = $this->input->get("id");
        $key['user_id'] = $id;
        $this->db->delete("app_user", $key);
        redirect(base_url() . 'User', 'refresh');
    }

    public function aktif() {
        $id = $this->input->get("id");
        $key['user_id'] = $id;
        $data['user_active'] = 1;
        $this->db->update("app_user", $data, $key);
        redirect(base_url() . 'User', 'refresh');
    }

    public function nonaktif() {
        $id = $this->input->get("id");
        $key['user_id'] = $id;
        $data['user_active'] = 0;
        $this->db->update("app_user", $data, $key);
        redirect(base_url() . 'User', 'refresh');
    }

}

/* End of file User.php */
/* Location: ./application/controllers/User.php */