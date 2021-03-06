<?php

/**
 *
 */
class CustomerModel extends CI_Model
{
  public function loadCateg()
  {
    $sql = "SELECT * FROM tbl_categories";
    return $this->db->query($sql);
  }

  public function loadProducts()
  {
      $sql = "SELECT * FROM tbl_products  WHERE product_stock != 0 AND status = 0";
      $res = $this->db->query($sql);

      $data = [];

      if ($res->num_rows()>0) {

        foreach ($res->result_array() as $row) {

          $sql1 = "SELECT * FROM tbl_images where product_id = ?LIMIT 1";
          $res1 = $this->db->query($sql1, $row['id']);
          if ($res1->num_rows()>0) {
            $row1  = $res1->row_array();
            $image = $row1['image_link'];
          }else{
            $image = 'assets/images/product-default.jpg';
          }

          $data[] = array(
                      "id"    => $row['id'],
                      "code"  => $row['product_code'],
                      "name"  => $row['product_name'],
                      "price" => $row['product_price'],
                      "stock" => $row['product_stock'],
                      "image" => $image,
                      "slug"  => $row['slug'],
                      "desc"  => $row['product_description']
                    );

        }

        return $data;
      }else{
        return 0;
      }
  }

  public function getCart($ip)
  {
       $sql = "SELECT * FROM tbl_cart WHERE product_id =? and ip = ? LIMIT 1";
       $res = $this->db->query($sql, $ip);
       if ($res->num_rows() == 0) {
         return 0;
       }else{
         return $res->num_rows();
       }

  }

  public function insertCart($data)
  {
    $sql = "INSERT INTO tbl_cart (product_id, cart_quantity, ip) VALUES (?,?,?)";
    $res = $this->db->query($sql, $data);
  }


  public function getCartcount($ip)
  {
    $sql = "SELECT * FROM tbl_cart WHERE ip = ?";
    $res = $this->db->query($sql, $ip);
    if ($res->num_rows() == 0) {
      return '';
    }else{
      return $res->num_rows();
    }
  }

  public function addQty($data)
  {
    $sql = "UPDATE tbl_cart set cart_quantity = cart_quantity+1 WHERE product_id = ? and ip = ?";
    $res = $this->db->query($sql, $data);
  }

  public function loadCart($data)
  {
      $sql = "SELECT * FROM tbl_cart WHERE ip = ?";
      $res = $this->db->query($sql, $data);
      $cart = [];
      if ($res->num_rows()>0) {

        foreach($res->result_array() as $row) {

          $sql1 = "SELECT * FROM tbl_products WHERE id = ? LIMIT 1";
          $res1 = $this->db->query($sql1, $row['product_id']);
          $sql2 = "SELECT * FROM tbl_images WHERE product_id = ? LIMIT 1";
          $res2 = $this->db->query($sql2, $row['product_id']);

          if ($res2->num_rows()>0) {
            $img  = $res2->row_array();
            $img  = $img['image_link'];
          }else{
            $img  = "assets/images/product-default.jpg";
          }

          $row1 = $res1->row_array();
          if ($row1['status'] == 0) {

            $cart[] = array(
                    "id"         => $row['id'],
                    "product_id" => $row['product_id'],
                    "quantity"   => $row['cart_quantity'],
                    "name"       => $row1['product_name'],
                    "price"      => $row1['product_price'],
                    "image"      => $img,
                    "extra"      => ''
            );

          }else{

            $cart[] = array(
                    "id"         => $row['id'],
                    "product_id" => $row['product_id'],
                    "quantity"   => $row['cart_quantity'],
                    "name"       => $row1['product_name'],
                    "price"      => 0,
                    "image"      => $img,
                    "extra"      => " <b style='font-size:18px !important'>* This product is currently unavailable </b>"
            );

          }




        }
        return $cart;

      }else{
        return 0;
      }
  }

  public function removeItem($item)
  {
      $sql = "DELETE FROM tbl_cart WHERE id = ?";
      return $this->db->query($sql, $item);
  }

  public function updateQty($data)
  {
      $sql = "UPDATE tbl_cart set cart_quantity = ? WHERE id = ?";
      return $this->db->query($sql, $data);
  }

  public function placeOrder($data)
  {
      $sql   = "SELECT * FROM tbl_cart WHERE ip = ?";
      $res   = $this->db->query($sql, $data[0]);
      $total = 0;
      if ($res->num_rows()>0) {

          foreach ($res->result_array() as $row) {
            $sql1 = "SELECT * FROM tbl_products WHERE id = ? LIMIT 1";
            $res1 = $this->db->query($sql1, $row['product_id']);
            $row1 = $res1->row_array();
            $total += $row['cart_quantity']*$row1['product_price'];
          }

          $sql2 = "INSERT INTO tbl_orderinfo (order_num, cus_name, cus_address,  cus_email,total) VALUES (?,?,?,?,?)";
          $datanew = [$data[1][0], $data[1][1], $data[1][2], $data[1][3], $total];
          return $this->db->query($sql2, $datanew);

      }
  }

  public function placeOrder1($data)
  {
      $sql  = "INSERT INTO tbl_orders (order_num, order_products, order_quantity) SELECT (?),product_id, cart_quantity FROM tbl_cart WHERE ip = ?";
      $res  = $this->db->query($sql, $data);
      $sql1 = "DELETE FROM tbl_cart WHERE ip = ?";
      $res  = $this->db->query($sql1, $data[1]);
  }


  public function checkCart($ip)
  {
      $sql  = "SELECT * FROM tbl_cart where ip = ?";
      $res  = $this->db->query($sql, $ip);
      $data['err'] = [];
      if ($res->num_rows() > 0) {

            foreach ($res->result_array() as $row) {

              $sql1 = "SELECT * FROM tbl_products WHERE id = ? LIMIT 1";
              $res1 = $this->db->query($sql1, $row['product_id']);
              $row1 = $res1->row_array();

              if ($row1['status'] == 1) {
                $data['err'][] = array("code" => 3, "msg" => $row1['product_name']." is currently unavailable");
              }

            }
            return $data;
      }
  }

  public function searchProduct($query)
  {
      $this->db->select('product_name');
      $this->db->select('slug');
      $this->db->select('product_price');
      $this->db->select('product_description');
      $this->db->select('product_categ');
      $this->db->where('product_stock !=',0);
      $this->db->where('status =',0);
      $this->db->from('tbl_products');
      if ($query != '') {
          $this->db->like('product_name', $query);
          $this->db->or_like('product_name', $query);
          $this->db->or_like('product_description', $query);
          $this->db->or_like('product_categ', $query);

      }

        $this->db->order_by('id', 'DESC');
        return $this->db->get();

  }


    public function getProduct($slug)
    {
        $sql = "SELECT * FROM tbl_products WHERE slug = ? LIMIT 1";
        $res = $this->db->query($sql, $slug);
        if ($res->num_rows()>0) {

          $row = $res->row_array();

          $sql2 = "SELECT * FROM tbl_images WHERE product_id = ?";
          $res2 = $this->db->query($sql2, $row['id']);
          $data = [];
          if ($res2->num_rows()>0) {
              $data['images'] = $res2->result_array();
          }
          $data['product'] = $res->row_array();

          return $data;

        }else{
          return 0;
        }
    }


}


 ?>
