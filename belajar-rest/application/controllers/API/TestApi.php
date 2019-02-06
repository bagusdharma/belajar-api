<?php

//import library dari rest_controller
require APPPATH . 'libraries/REST_Controller.php';

class TestApi extends REST_Controller {
    public function __construct()
    {
        parent::__construct();
    }

    public function index_get()
    {
        // testing response
        $response['status']=200;
        $response['error']=false;
        $response['message']='Hai from response';

        // tampilkan response
        $this->response($response);
    }

    public function user_get()
    {
        $response['status']=200;
        $response['error']=false;
        $response['user']['username']='bagus';
        $response['user']['email']='bagus.dharma@gmail.com';
        $response['user']['detail']['fullname']='Bagus Dharma';
        $response['user']['detail']['position']='Developer';
        $response['user']['detail']['specialize']='Web';
     
        $this->response($response);
    }
}

?>