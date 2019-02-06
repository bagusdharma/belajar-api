<?php

require APPPATH . 'libraries/REST_Controller.php';

class Person extends REST_Controller {

    public function __construct()
    {
        parent::__construct();
        $this->load->model('Model_Person');
    }

    // method index menampilkan semua data person dengan get
    public function index_get()
    {
        $response = $this->Model_Person->all_person();
        $this->response($response);
    }

    // menambha person dengan method post
    public function add_post() 
    {
        $response = $this->Model_Person->add_person(
            $this->post('name'),
            $this->post('address'),
            $this->post('phone')
        );

        $this->response($response);
    }

    // update data

    public function update_data_put()
    {
        $response = $this->Model_Person->update_person(
            $this->put('id'),
            $this->put('name'),
            $this->put('address'),
            $this->put('phone')
        );
        $this->response($response);
    }

    // delete data
    public function delete_delete() 
    {
        $response = $this->Model_Person->delete_person(
            $this->delete('id')
        );
        $this->response($response);
    }

}

?>