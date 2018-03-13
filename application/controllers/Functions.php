<?php

  /**
   *
   */
  class Functions extends CI_Controller
  {

    function __construct()
    {
      parent:: __construct();
      $this->load->library('functionslib', null, 'flib');
    }

    public function login()
    {
      if (!$this->input->is_ajax_request()) {
			   #exit('No direct script access allowed');
				exit(show_404());
			}

      $username = $this->input->post('username');
      $password = $this->input->post('password');

      $config = array(
              array(
                      'field' => 'username',
                      'label' => 'Username',
                      'rules' => 'required|trim|htmlspecialchars'
              ),
              array(
                      'field' => 'password',
                      'label' => 'Password',
                      'rules' => 'required|trim|htmlspecialchars',
                      'errors' => array(
                              'required' => 'You must provide a %s.',
                      ),
              ),
      );

      $this->form_validation->set_rules($config);

      if ($this->form_validation->run() == FALSE) {
          echo json_encode(array('code' => 1, 'reply' => validation_errors()));
      }else{

          $password = md5($password);

          $data = $this->flib->sanitizer([$username,$password]);
          $res  = $this->fmodel->login($data);

          if ($res->num_rows()>0) {
            $row = $res->row_array();
            $session_data = array(
  							'username' 	=> $username,
  							'access' 	  => $row['access']
  						);

            $this->session->set_userdata('user', $session_data);

            echo json_encode(array('code' => 2));
          }else{
            echo json_encode(array('code' => 1, 'reply' => 'Incorrect username or password'));
          }

      }



    }// login

    public function getProducts()
    {
      $res = $this->fmodel->getProducts();
      $res = $res->result_array();
      echo json_encode($res);
    }

    public function pulloutProduct()
    {
       $this->fmodel->pulloutProduct($this->input->post('product'));
       echo json_encode(array('code' => 2));
    }

    public function newproduct()
    {
        if (!$this->input->is_ajax_request()) {
           #exit('No direct script access allowed');
          exit(show_404());
        }else{

          $pname  = $this->input->post('pname');
          $pprice = $this->input->post('pprice');
          $pstock = $this->input->post('pstock');

          $config = array(
                  array(
                          'field' => 'pname',
                          'label' => 'Product Name',
                          'rules' => 'required|trim|htmlspecialchars'
                  ),
                  array(
                          'field' => 'pprice',
                          'label' => 'Product Price',
                          'rules' => 'required|numeric|is_natural_no_zero',
                  ),
                  array(
                          'field' => 'pstock',
                          'label' => 'Product Stock',
                          'rules' => 'required|numeric|is_natural_no_zero',
                  ),
          );

          $this->form_validation->set_rules($config);

          if ($this->form_validation->run() == FALSE) {
              echo json_encode(array('code' => 1, 'reply' => validation_errors()));
          }else{
              $pcode = $this->genCode();
              $check = $this->fmodel->checkProduct($pname);
              if ($check->num_rows()>0) {
                echo json_encode(array('code' => 1, 'reply' => 'Product is already existing'));
              }else{

                $pname  = $this->flib->sanitize($pname);
                $pprice = $this->flib->sanitize($pprice);
                $pstock = $this->flib->sanitize($pstock);
                $slug   = str_replace(' ', '-', $pname);

                $data  = array(
                          'product_code'  => $pcode,
                          'product_name'  => $pname,
                          'product_price' => $pprice,
                          'product_stock' => $pstock,
                          'slug'          => $slug
                        );
                $res   = $this->fmodel->newproduct($data);
                echo json_encode(array('code' => 2, 'reply' => 'Product added', 'product' => $res));
              }

          }

        }
    }

    public function editProduct()
    {
      if (!$this->input->is_ajax_request()) {
         #exit('No direct script access allowed');
        exit(show_404());
      }else{

        $pname   = $this->input->post('epname');
        $pprice  = $this->input->post('epprice');
        $pstock  = $this->input->post('epstock');
        $product = $this->input->post('product');

        $config = array(
                array(
                        'field' => 'epname',
                        'label' => 'Product Name',
                        'rules' => 'required|trim|htmlspecialchars'
                ),
                array(
                        'field' => 'epprice',
                        'label' => 'Product Price',
                        'rules' => 'required|numeric|is_natural_no_zero',
                ),
                array(
                        'field' => 'epstock',
                        'label' => 'Product Stock',
                        'rules' => 'required|numeric|is_natural_no_zero',
                ),
        );

        $this->form_validation->set_rules($config);

        if ($this->form_validation->run() == FALSE) {
            echo json_encode(array('code' => 1, 'reply' => validation_errors()));
        }else{
            $check = $this->fmodel->checkProduct1([$pname, $product]);
            if ($check->num_rows()>0) {
              echo json_encode(array('code' => 1, 'reply' => 'Product is already existing'));
            }else{
              $data  = $this->flib->sanitizer([$pname, $pprice, $pstock, $product]);
              $res   = $this->fmodel->editProduct($data);
              echo json_encode(array('code' => 2, 'reply' => 'Product edited', 'product' => $data));
            }

        }

      }
    }


    public function genCode()
    {
      $unique_ref_found = false;
      while (!$unique_ref_found) {
          $unique_ref = "";
          $i = 0;
          $unique_ref = mt_rand(100000000,999999999);
          $result = $this->fmodel->uniqueCode($unique_ref);
          if ($result->num_rows()==0) {
              $unique_ref_found = true;
          }

      }
      return $unique_ref;
    }



    public function multiple_upload($code)
		{
		  $this->load->library('upload');
		  if (isset($_FILES['userfilex'])) {
				$number_of_files_uploaded = count($_FILES['userfilex']['name']);
        $name = '';
				// Faking upload calls to $_FILE
				for ($i = 0; $i < $number_of_files_uploaded; $i++) :
          $name = mt_rand(1000000, 99999999);
					$_FILES['userfile']['name']     = $_FILES['userfilex']['name'][$i];
					$_FILES['userfile']['type']     = $_FILES['userfilex']['type'][$i];
					$_FILES['userfile']['tmp_name'] = $_FILES['userfilex']['tmp_name'][$i];
					$_FILES['userfile']['error']    = $_FILES['userfilex']['error'][$i];
					$_FILES['userfile']['size']     = $_FILES['userfilex']['size'][$i];
					$config = array(
						'file_name'     => $name,
						'allowed_types' => 'jpg|jpeg|png|gif',
						'max_size'      => 3000,
						'overwrite'     => FALSE,
						/* real path to upload folder ALWAYS */
						'upload_path'
								=> './assets/images/products/'
					);
					$this->upload->initialize($config);
					if ( ! $this->upload->do_upload()) :
						$error = array('error' => $this->upload->display_errors());
					// var_dump($error);
					continue;
					else :

            $exten = substr($_FILES['userfile']['type'],6);
            $exten = str_replace('jpeg','jpg', $exten);
            $path = 'assets/images/products/'.$name.'.'.$exten;
            $this->fmodel->productImg([$code, $path]);
						$final_files_data[] = $this->upload->data();
						// Continue processing the uploaded data
					endif;
				endfor;
		  }
		}

    public function loadCateg()
    {
      if (!$this->input->is_ajax_request()) {
         #exit('No direct script access allowed');
        exit(show_404());
      }else{
          $res = $this->cmodel->loadCateg();
          $res = $res->result_array();
          echo json_encode(array('categories' => $res));
      }
    }



  }



 ?>
