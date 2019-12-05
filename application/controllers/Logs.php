<?php

defined('BASEPATH') or exit('No direct script access allowed');

class Logs extends CI_Controller {

    public function __construct() {
        parent::__construct();
        checkToken();
    }

    public function index() {
        $this->load->model('wedding_model');
        $data['wedding'] = $this->wedding_model->getDataAllLogs();
        render('logs', $data);
    }

}

/* End of file Logs.php */
/* Location: ./application/controllers/Logs.php */