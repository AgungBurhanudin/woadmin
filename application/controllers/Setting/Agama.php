<?php

defined('BASEPATH') or exit('No direct script access allowed');

class Agama extends CI_Controller {

    public function __construct() {
        parent::__construct();
        checkToken();
    }

    public function index() {
        $data = array(
            'data' => $this->db->get('agama')->result(),
        );
        render('setting/agama/data', $data);
    }

    public function add() {
        render('setting/agama/form');
    }

    public function save() {
        $post = $_POST;
        $id = $this->input->post("id");
        if (empty($id)) {
            $data['agama'] = $post['agama'];
            $this->db->insert("agama", $data);
            redirect(base_url() . 'Setting/Agama', 'refresh');
        } else {
            $key['id'] = $id;
            $data['agama'] = $post['agama'];
            $this->db->update("agama", $data, $key);
            redirect(base_url() . 'Setting/Agama', 'refresh');
        }
    }

    public function edit() {
        $key['id'] = $this->input->get("id");
        $data = array(
            'data_agama' => $this->db->get_where("agama", $key)->result(),
        );
        render("setting/agama/form", $data);
    }

    public function delete() {
        $id = $this->input->get("id");
        $key['id'] = $id;
        $this->db->delete("agama", $key);
        redirect(base_url() . 'Agama', 'refresh');
    }

}

/* End of file Agama.php */
/* Location: ./application/controllers/Agama.php */
