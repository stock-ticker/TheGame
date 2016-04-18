<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Manageaccn extends Application {
    
    function __construct() {
        parent::__construct();
        $this->load->helper('url');
    }
    
    function index() {
        $currentUserName = $this->session->userdata('userName');
         
        $this->data['pagebody'] = 'manageAccnView';
        $this->data['name'] = $currentUserName;

        $this->data['ID'] = $this->session->userdata('userID');
        

         if(file_exists (FCPATH . '/assets/avatars/' . $currentUserName . '.png'))
        {
            $this->data['imagePath'] = '/assets/avatars/' . $currentUserName . '.png';
        }
        elseif(file_exists (FCPATH . '/assets/avatars/' . $currentUserName . '.gif'))
        {
            $this->data['imagePath'] = '/assets/avatars/' . $currentUserName . '.png';
        }
        elseif(file_exists (FCPATH . '/assets/avatars/' . $currentUserName . '.jpg'))
        {
            $this->data['imagePath'] = '/assets/avatars/' . $currentUserName . '.png';
        }
        else 
        {
            $this->data['imagePath'] = '/assets/avatars/defaultAvatar.png';
        }
        
        $this->data['privilege'] = $this->session->userdata('userRole');
        if($this->session->userdata('userRole') == "admin") {
            $users = $this->users->all();
            foreach ($users as $user) {
                $deleteUser[] = array('userID' => $user->id);
            }
            $this->data['deleteUser'] = $deleteUser;
            $this->data['editUser'] = $deleteUser;
            $this->data['adminView'] = $this->parser->parse('adminView', $this->data, true);
        } else {
            $this->data['adminView'] = '';
        }
        $this->render();
    }
    
    function submit() {
        $user = $this->users->get($this->session->userdata('userID'));
        if (password_verify($this->input->post('oldPassword'),$user->password)) {
            $user->name = $this->input->post('name');
            $user->password = password_hash($this->input->post('newPassword'), PASSWORD_DEFAULT);
            $this->users->delete($this->session->userdata('userID'));
            $this->users->add((array) $user);
            $this->session->set_userdata('userName',$user->name);
            redirect('/');
        } else{
            redirect('/Manageaccn');
        }
    }
    
    function deleteUser() {
        $userID =$this->input->post('deleteUser');
        $this->users->delete($userID);
        redirect('/Manageaccn');
    }
    
    function createUser() {
        $name = $this->input->post('name');
        $id = $this->input->post('userid');
        $pword = $this->input->post('password');
        $privilege = $this->input->post('selectPrivilege');
        $user = $this->users->create();
        $user->id = $id;
        $user->name = $name;
        $user->password = password_hash($pword, PASSWORD_DEFAULT);
        $user->role = $privilege;
        $this->users->add((array) $user);
        redirect('/Manageaccn');
    }
    
    function editUser() {
        $this->users->delete($this->input->post('editUser'));
        $id = $this->input->post('editUser');
        $name = $this->input->post('name');
        $pword = $this->input->post('password');
        $privilege = $this->input->post('selectPrivilege');
        $user = $this->users->create();
        $user->id = $id;
        $user->name = $name;
        $user->password = password_hash($pword, PASSWORD_DEFAULT);
        $user->role = $privilege;
        $this->users->add((array) $user);
        redirect('/Manageaccn');
    }
}
