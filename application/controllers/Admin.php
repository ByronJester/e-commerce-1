<?php

  /**
   *
   */
  class Admin extends CI_Controller
  {

    public function index()
    {
      $this->load->view('admin/index');
    }

    public function view($page)
    {
        if (!file_exists(APPPATH.'views/admin/'.$page.'.php')) {
        show_404();
        }else{

            if (!isset($this->session->userdata['user'])) {
              redirect(base_url());
            }else{
              $data['title'] = ucfirst($page);

              $this->load->view('templates/aheader',$data);
              $this->load->view('admin/'.$page);

            }
        }
    }


  }



 ?>
