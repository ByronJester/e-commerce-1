<?php

  /**
   *
   */
  class Pages extends CI_Controller
  {

    public function index()
    {
      $res = $this->cmodel->loadCateg();
      if ($res->num_rows()>0) {
        $data['categories'] = $res->result_array();
      }

      $this->load->view('templates/header');
      $this->load->view('pages/index',$data);
    }

    public function view($page)
    {
      if (!file_exists(APPPATH.'views/pages/'.$page.'.php')) {
      show_404();
      }else{

          if (!isset($this->session->userdata['user'])) {
            redirect(base_url());
          }else{
            $data['title'] = ucfirst($page);

            $this->load->view('templates/header',$data);
            $this->load->view('pages/'.$page);

          }
      }
    }

  }


 ?>
