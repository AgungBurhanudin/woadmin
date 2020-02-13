<?php

defined('BASEPATH') or exit('No direct script access allowed');

class Settings extends CI_Controller {

    public function __construct() {
        parent::__construct();
        checkToken();
    }

    public function index() {
        render("settings");
    }

    public function splashscreen() {
        $key['setting_key'] = 'splashscreen';
        $data = array(
            'splashscreen' => $this->db->get_where('app_setting', $key)->row()
        );
        render("setting/android", $data);
    }

    public function saveSplashScreen() {
        if (isset($_FILES)) {
            $path = realpath(APPPATH . '../files/splashscreen/');

            $this->upload->initialize(array(
                'upload_path' => $path,  
                'allowed_types' => 'png|jpg|gif',              
            ));

            if ($this->upload->do_upload('file')) {
                $data_upload = $this->upload->data();
                $data['setting_value'] = $data_upload['file_name'];
            } else {
                // echo "123";
                echo $this->upload->display_errors();
                $data['setting_value'] = "";
            }
        }
        $key['setting_key'] = "splashscreen";
        $this->db->update('app_setting', $data, $key);
        $this->session->set_flashdata('success', 'Berhasil mengupload splashscreen');
        redirect(base_url() . 'Settings/splashscreen', 'refresh');
    }

}

/* End of file Settings.php */
/* Location: ./application/controllers/Settings.php */
