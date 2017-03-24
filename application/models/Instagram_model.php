<?php

/**
 * Created by PhpStorm.
 * User: JuanMiguel
 * Date: 23-03-2017
 * Time: 10:37 PM
 */
class Instagram_model extends CI_Model
{
    public function __construct()
    {
        parent::__construct();
    }

    public function getInstagramUsers()
    {
        $query = $this->db->get('users');
        return $query->result();
    }

    public function updateInstagramUser($user_id,$data)
    {
        $this->db->where('user_id',$user_id);
        $this->db->update('users',$data);
    }
}