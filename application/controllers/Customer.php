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

}


?>
