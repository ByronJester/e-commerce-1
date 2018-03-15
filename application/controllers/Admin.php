<?php

  /**
   *
   */
  class Admin extends CI_Controller
  {

    public function index()
    {
      if (isset($this->session->userdata['user'])) {
          redirect(base_url('admin/home'));
      }else{
        $this->load->view('admin/index');
      }
    }

    public function reports($a = NULL, $b = NULL, $c = NULL)
    {
      switch ($a) {
        case 'genall':
          $data['reports'] = "<input type='hidden' value='genall' id='action'>";
          $data['from']    = "";
          $data['to']      = "";
          break;
        case 'genrange':
          $data['reports'] = "<input type='hidden' value='genrange' id='action' />";

          $data['from']    = "<input type='hidden' value='$b' id='datefrom'/>";
          $data['to']      = "<input type='hidden' value='$c' id='dateto'/>";

          break;
          default:
          show_404();
          break;
      }

      $this->load->view('admin/reports',$data);
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
              $data['page']  = $page;

              $this->load->view('templates/aheader',$data);
              $this->load->view('admin/'.$page);
              $this->load->view('templates/afooter',$data);

            }
        }
    }




  }



 ?>
