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
      $sql = "SELECT * FROM tbl_products  WHERE product_stock != 0 ";
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
                      "slug"  => $row['slug']
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

          $img  = $res2->row_array();
          $row1 = $res1->row_array();
          $cart[] = array(
                  "id"         => $row['id'],
                  "product_id" => $row['product_id'],
                  "quantity"   => $row['cart_quantity'],
                  "name"       => $row1['product_name'],
                  "price"      => $row1['product_price'],
                  "image"      => $img['image_link']
          );




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




}


 ?>
