<?php 

defined('BASEPATH') OR exit('No direct script access allowed');

require APPPATH . '../vendor/autoload.php';
require APPPATH . '/libraries/REST_Controller.php';
use \Firebase\JWT\JWT;

class Rest extends REST_Controller {
    private $secretkey = '06111997'; // ubah dg kode rahasia kita
    
    public function __construct()
    {
        parent::__construct();
        $this->load->library('form_validation');
    }

    // method melihat token user
    public function generate_token_post()
    {
        $this->load->model('Model_Login');
        $date = new DateTime();
        $username = $this->post('username', TRUE); // kolom username pada database
        $pass = $this->post('password', TRUE); // kolom password pada database
        $dataadmin = $this->Model_Login->is_valid($username);

        // $result = json_encode(password_hash($dataadmin->password, PASSWORD_DEFAULT));
        // return $result;

        if($dataadmin) {
            if (password_verify($this->post('password'), password_hash($dataadmin->password, PASSWORD_DEFAULT))) {
                $payload ['id'] = $dataadmin->id_user;
                $payload ['username'] = $dataadmin->username;
                $payload ['iat'] = $date->getTimestamp(); // waktu di buat
                $payload ['exp'] = $date->getTimestamp() + 3600; // satu jam masa berlaku token
                $output ['token'] = JWT::encode($payload, $this->secretkey);
                return $this->response($output, REST_Controller::HTTP_OK);
            } else {
                $this->viewtokenfail($username);
            }
        } else {
            $this->viewtokenfail($username);
        }
    }

    // method jika generate token salah
    public function viewtokenfail()
    {
        $this->response([
            'status' => '0',
            'username' => $username,
            'message' => 'Invalid Username or Password'
        ], REST_Controller::HTTP_BAD_REQUEST);
    }

    // method mengecek token setiap melakukan post,put,etc
    public function cektoken()
    {
        $this->load->model('Model_Login');
        $jwt = $this->input->get_request_header('Authorization');

        try {
            $decode = JWT::decode($jwt, $this->secretkey, array('HS256'));
            
            if($this->Model_Login->is_valid_num($decode->username)>0) {
                return true;
            }
        } catch (Exception $e) {
            exit(json_encode(array('status' => '0', 'message' => 'Invalid Token',)));
        }
    }
}

?>