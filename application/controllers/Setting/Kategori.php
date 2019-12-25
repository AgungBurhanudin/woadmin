<?php

defined('BASEPATH') or exit('No direct script access allowed');

class Kategori extends CI_Controller {

    public function __construct() {
        parent::__construct();
        checkToken();
    }

    public function index() {
        $data = array(
            'data' => $this->db->get('kategori')->result(),
        );
        render('setting/kategori/data', $data);
    }

    public function add() {
        render('setting/kategori/form');
    }

    public function save() {
        $post = $_POST;
        $id = $this->input->post("id");
        if (empty($id)) {
            $data['kategori'] = $post['kategori'];
            $data['status'] = $post['status'];
            $this->db->insert("kategori", $data);
            redirect(base_url() . 'Setting/Kategori', 'refresh');
        } else {
            $key['id'] = $id;
            $data['kategori'] = $post['kategori'];
            $data['status'] = $post['status'];
            $this->db->update("kategori", $data, $key);
            redirect(base_url() . 'Setting/Kategori', 'refresh');
        }
    }

    public function edit() {
        $key['id'] = $this->input->get("id");
        $data = array(
            'data_kategori' => $this->db->get_where("kategori", $key)->result(),
        );
        render("setting/kategori/form", $data);
    }

    public function delete() {
        $id = $this->input->get("id");
        $key['id'] = $id;
        $this->db->delete("kategori", $key);
        redirect(base_url() . 'Kategori', 'refresh');
    }

}

/* End of file Agama.php */
/* Location: ./application/controllers/Kategori.php */
