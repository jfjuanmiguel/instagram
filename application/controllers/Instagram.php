<?php

/**
 * Created by PhpStorm.
 * User: JuanMiguel
 * Date: 23-03-2017
 * Time: 10:43 PM
 */

class Instagram extends CI_Controller
{
    private $_api_url = 'https://api.instagram.com/v1';
    private $_api_user_info = '';

    public function __construct()
    {
        parent::__construct();
        $this->_api_user_info = $this->_api_url.'/users/self/?access_token=';
        $this->_api_user_info_by_dappry = $this->_api_url.'/users';
    }


    public function showUsers()
    {
        $this->load->model('instagram_model');

        $users = $this->instagram_model->getInstagramUsers();

        $data['users'] = $users;

        $this->load->view('instagram', $data);
    }

    public function updateUser()
    {
        $this->form_validation->set_rules('user_id','User ID','required|trim|xss_clean');
        $this->form_validation->set_rules('user_token','User Token','required|trim|xss_clean');

        if ($this->form_validation->run() == false) {
            echo -1;
        } else {
            $this->load->model('instagram_model');

            $user_id = $this->input->post('user_id');
            $user_token = $this->input->post('user_token');

            $json_response = $this->getUserInfo($user_token);

            $data = array(
               'user_bio' => $json_response->data->bio,
               'user_picture' => $json_response->data->profile_picture,
                'user_follows' => $json_response->data->counts->follows,
                'user_followedby' => $json_response->data->counts->followed_by,
                'user_media' => $json_response->data->counts->media
            );

            $this->instagram_model->updateInstagramUser($user_id,$data);
            echo 0;
        }
    }

    public function getUserInfo($access_token)
    {
        $options = array('http' => array(
            'method'  => 'GET',
            'ignore_errors' => TRUE
        ));

        $context  = stream_context_create($options);

        $response  = file_get_contents($this->_api_user_info.$access_token,false,$context);

        $response = json_decode($response);

        return $response;
    }
}