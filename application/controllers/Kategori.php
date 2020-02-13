<?php

defined('BASEPATH') or exit('No direct script access allowed');

class Kategori extends CI_Controller {

    public function __construct() {
        parent::__construct();
        checkToken();
    }

    public function index() {
        $data = array(
            'data_kategori' => $this->db->get('kategori_vendor')->result(),
        );
        render('vendor/kategori_data', $data);
    }

    public function add() {
        render('vendor/kategori_form');
    }

    public function save() {
        $post = $_POST;
        $id = $this->input->post("id");
        if (empty($id)) {
            $data['nama_kategori'] = $post['nama_kategori'];
            $data['tag'] = $post['tag'];
            $this->db->insert('kategori_vendor', $data);
            redirect(base_url() . 'Kategori', 'refresh');
        } else {
            $key['id'] = $id;
            $data['nama_kategori'] = $post['nama_kategori'];
            $data['tag'] = $post['tag'];
            $this->db->update('kategori_vendor', $data, $key);
            redirect(base_url() . 'Kategori', 'refresh');
        }
    }

    public function edit() {
        $key['id'] = $this->input->get("id");
        $data = array(
            'data_kategori' => $this->db->get_where('kategori_vendor', $key)->result(),
        );
        render("vendor/kategori_form", $data);
    }

    public function delete() {
        $id = $this->input->get("id");
        $key['id'] = $id;
        $this->db->delete('kategori_vendor', $key);
        redirect(base_url() . 'Kategori', 'refresh');
    }

}

/* End of file Company.php */
/* Location: ./application/controllers/Company.php */
