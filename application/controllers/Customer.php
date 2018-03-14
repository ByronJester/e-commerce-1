<?php
/**
 *
 */
class Customer extends CI_Controller
{

  function __construct()
  {
    parent:: __construct();
    $this->load->library('functionslib', null, 'flib');
  }

  public function loadProducts($categ = '')
  {
    if (!$this->input->is_ajax_request()) {
       #exit('No direct script access allowed');
      exit(show_404());
    }else{

      if ($categ == '') {
        $data = $this->cmodel->loadProducts();
        echo json_encode($data);

      }

    }
  }

  public function addcart()
  {
      if (!$this->input->is_ajax_request()) {
         #exit('No direct script access allowed');
        exit(show_404());
      }else{
          $ip      = $this->flib->getIP();
          $product = $this->input->post('product');
          $res     = $this->cmodel->getCart([$product ,$ip]);

          if ($res == 0) {
              $data = [$product, '1', $ip];
              $this->cmodel->insertCart($data);
              $return = $this->cmodel->getCartcount($ip);
              echo json_encode(array('cart' => $return));
          }else{
            $data = [$product, $ip];
            $this->cmodel->addQty($data);
            $return = $this->cmodel->getCartcount($ip);
            echo json_encode(array('cart' => $return));
          }

      }
  }

  public function loadCart()
  {
      if (!$this->input->is_ajax_request()) {
         #exit('No direct script access allowed');
        exit(show_404());
      }else{
        $ip     = $this->flib->getIP();
        $res   = $this->cmodel->loadCart($ip);

        if ($res !=0) {

          echo json_encode($res);

        }else{
            echo json_encode(array('code' => 0));
        }

      }
  }
  public function loadCartcount()
  {
    if (!$this->input->is_ajax_request()) {
       #exit('No direct script access allowed');
      exit(show_404());
    }else{
      $ip     = $this->flib->getIP();
      $res   = $this->cmodel->getCartcount($ip);

      echo json_encode(array("cart" => $res));

    }
  }

  public function removeItem()
  {
    if (!$this->input->is_ajax_request()) {
       #exit('No direct script access allowed');
       exit(show_404());
    }else{
        $item   = $this->input->post('cartid');
        $res    = $this->cmodel->removeItem($item);
        echo json_encode(array('code' => 2));
    }
  }

  public function updateQty()
  {
    if (!$this->input->is_ajax_request()) {
       #exit('No direct script access allowed');
       exit(show_404());
    }else{
        $data = $this->flib->sanitizer([$this->input->post('qty'), $this->input->post('item')]);
        $res  = $this->cmodel->updateQty($data);
        echo json_encode(array('code' => 2));
    }
  }

  public function placeorder()
  {
    if (!$this->input->is_ajax_request()) {
       #exit('No direct script access allowed');
       exit(show_404());
    }else{

      $config = array(
                  array(
                          'field' => 'fname',
                          'label' => 'First Name',
                          'rules' => 'required|trim|htmlspecialchars',
                          'errors' => array(
                                  'required' => 'You must provide a %s.',
                          ),
                  ),
                  array(
                          'field' => 'mname',
                          'label' => 'Middle Name',
                          'rules' => 'required|trim|htmlspecialchars',
                          'errors' => array(
                                  'required' => 'You must provide a %s.',
                          ),
                  ),
                  array(
                          'field' => 'lname',
                          'label' => 'Last Name',
                          'rules' => 'required|trim|htmlspecialchars',
                          'errors' => array(
                                  'required' => 'You must provide a %s.',
                          ),
                  ),
                  array(
                          'field' => 'email',
                          'label' => 'Email',
                          'rules' => 'required|trim|htmlspecialchars|valid_email',
                          'errors' => array(
                                  'required'    => 'You must provide a %s.',
                                  'valid_email' => 'Invalid Email'
                          ),
                  ),
                  array(
                          'field' => 'address',
                          'label' => 'Address',
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

          $ip       = $this->flib->getIP();

          $fname    = $this->input->post('fname');
          $mname    = $this->input->post('mname');
          $lname    = $this->input->post('lname');
          $email    = $this->input->post('email');
          $address  = $this->input->post('address');
          $ordernum = $this->uniqueOrder();
          $name     = $fname.' '.$mname.' '.$lname;
          $this->flib->sanitizer([$name, $address, $email]);
          $data     = array([$ip],[$ordernum, $name, $address, $email]);
          $data1    = [$ordernum, $ip];

          $this->cmodel->placeOrder($data);
          $this->cmodel->placeOrder1($data1);
          echo json_encode(array('code' => 2, 'ordernum' => $ordernum));
      }


    }
  }

  public function uniqueOrder(){

    $unique_ref_length = 8;
     $unique_ref_found = false;
     $possible_chars = "abcdefghijklmnopqrstuvwxyz1234567890";
     while (!$unique_ref_found) {
         $unique_ref = "";
         $i = 0;
         $unique_ref = mt_rand(10000000,99999999);
         $result = $this->fmodel->uniqueOrder($unique_ref);
         if ($result->num_rows==0) {
             $unique_ref_found = true;
         }

     }

     return $unique_ref;

  }

  public function checkCart()
  {
    if (!$this->input->is_ajax_request()) {
       #exit('No direct script access allowed');
       exit(show_404());
    }else{
        $ip   = $this->flib->getIP();
        $res  = $this->cmodel->checkCart($ip);
        if (count($res['err']) == 0) {
            echo json_encode(array(["code" => 2]));
        }else{
           echo json_encode($res['err']);
        }
    }
  }

  public function searchProduct()
  {
    if (!$this->input->is_ajax_request()) {
       #exit('No direct script access allowed');
       exit(show_404());
    }else{
      $query = $this->flib->sanitize($this->input->post('query'));
      $res   = $this->fmodel->searchProduct($query);
    }
  }

}


?>
