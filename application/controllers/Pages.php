<?php

  /**
   *
   */
  class Pages extends CI_Controller
  {

    function __construct()
    {
      parent:: __construct();
      $this->load->library('functionslib', null, 'flib');
    }

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


            $data['title'] = ucfirst($page);

            $this->load->view('templates/header',$data);
            $this->load->view('pages/'.$page);


      }
    }

    public function product($slug)
    {
        $slug            = $this->flib->sanitize($slug);
        $res             = $this->cmodel->getProduct($slug);
        $data            = "";
        if ($res != 0) {
          $data['product'] = $res['product'];
          $data['images']  = $res['images'];
        }else{
          $data['product'] = 0;
        }



        $this->load->view('templates/header');
        $this->load->view('pages/product',$data);


    }

  }


 ?>
