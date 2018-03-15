<?php

  /**
   *
   */
  class FunctionsModel extends CI_Model
  {

    public function login($data)
    {
      $sql = "SELECT * FROM tbl_users WHERE username = ? and password = ? LIMIT 1";
      return $this->db->query($sql, $data);
    }

    /* ========================================================================================= *
     * ====================================PRODUCTS============================================= *
     * ========================================================================================= *
    */

    public function checkProduct($data)
    {
      $sql = "SELECT * FROM tbl_products where product_name = ? LIMIT 1";
      return $this->db->query($sql, $data);

    }

    public function checkProduct1($data)
    {
      $sql = "SELECT * FROM tbl_products where product_name = ? and id != ?LIMIT 1";
      return $this->db->query($sql, $data);
    }

    public function uniqueCode($data)
    {
      $sql = "SELECT * FROM tbl_products WHERE product_code = ? LIMIT 1";
      return $this->db->query($sql, $data);
    }

    public function uniqueOrder($data)
    {
      $sql = "SELECT * FROM tbl_orders WHERE order_num = ? LIMIT 1";
      return $this->db->query($sql, $data);
    }

    public function newproduct($data)
    {
      $this->db->insert('tbl_products', $data);
      $insert_id = $this->db->insert_id();

      return $insert_id;
    }

    public function editProduct($data)
    {
      $sql = "UPDATE tbl_products set product_name = ?, product_description = ?,product_price = ?, product_stock =?, product_categ = ?, slug = ? WHERE id = ?";
      return $this->db->query($sql, $data);
    }

    public function getProducts()
    {
      $sql = "SELECT * FROM tbl_products WHERE status = 0";
      return $this->db->query($sql);
    }

    public function pulloutProduct($data)
    {
        $sql = "UPDATE tbl_products set status = 1 WHERE id = ?";
        $res = $this->db->query($sql, $data);

        $sql1 = "DELETE FROM tbl_images WHERE product_id = ?";
        $res1 = $this->db->query($sql1, $data);
        return true;

    }

    public function productImg($data)
    {
        $sql = "INSERT INTO tbl_images (product_id, image_link) VALUES (?,?)";
        $this->db->query($sql, $data);
    }

    public function getImages($prod)
    {
      $sql = "SELECT * FROM tbl_images WHERE product_id = ?";
      return $this->db->query($sql, $prod);
    }

    /* ========================================================================================= *
     * ====================================PRODUCTS END========================================= *
     * ========================================================================================= *
    */
    /* ========================================================================================= *
     * ======================================ORDERS============================================= *
     * ========================================================================================= *
    */

    public function loadOrders()
    {
        $sql = "SELECT    b.*,group_concat(a.order_products) as product,group_concat(a.order_quantity) as quantity
                FROM tbl_orders as a INNER JOIN tbl_orderinfo as b  ON a.order_num = b.order_num
                WHERE b.order_status = ? OR b.order_status = ? GROUP BY b.order_num ORDER BY b.id ASC";

        $res = $this->db->query($sql,[0,1]);

        if ($res->num_rows()>0) {

          $data['orderinfo']    = $res->result_array();
          $data['productinfo']  = [];

            foreach ($res->result_array() as $row) {

              $prod = explode(',', $row['product']);

              foreach ($prod as $pid) {

                  $sql1   = "SELECT id,product_name,product_price,product_stock FROM tbl_products WHERE id =? LIMIT 1";
                  $data['productinfo'][$pid] = $this->db->query($sql1, $pid)->row_array();

              }

            }

            return $data;

        }else{
          return 0;
        }
        //return $res->result_array();
    }

    public function deleteOrder($data)
    {
        $sql = "UPDATE tbl_orderinfo set order_status = 5 WHERE order_num = ?";
        $sql1 = "UPDATE tbl_orders set order_status = 5 WHERE order_num = ?";
        $this->db->query($sql1, $data);
        return $this->db->query($sql, $data);
    }
    public function archiveOrder($data)
    {
        $sql = "UPDATE tbl_orderinfo set order_status = 3 WHERE order_num = ?";
        $sql1 = "UPDATE tbl_orders set order_status = 3 WHERE order_num = ?";
        $this->db->query($sql1, $data);
        return $this->db->query($sql, $data);
    }

    public function checkInvent($order)
    {
        $sql       = "SELECT * FROM tbl_orders WHERE order_num = ?";
        $res       = $this->db->query($sql, $order);
        $data['err'] = [];
        if ($res->num_rows()>0) {

          foreach ($res->result_array() as $row) {

            $sql1 = "SELECT * FROM tbl_products WHERE id = ? LIMIT 1";
            $res1 = $this->db->query($sql1, $row['order_products']);
            if ($res1->row_array()>0) {
              $row1 = $res1->row_array();
              if ($row1['product_stock'] < $row['order_quantity']) {
                  $data['err'][] = array("code" => 3, "msg" => "Not enough stock of ".$row1['product_name']);
              }

            }else{
              $data['err'][] = array("code" => 3, "msg" => "Error , item in cart is not in the database");
            }


          }

        }

        return $data;
    }

    public function orderSuccess($order)
    {
        $sql       = "SELECT * FROM tbl_orders WHERE order_num = ?";
        $res       = $this->db->query($sql, $order);
        $data['err'] = [];
        if ($res->num_rows()>0) {

          foreach ($res->result_array() as $row) {

            $sql1 = "UPDATE tbl_products SET product_stock = product_stock-?, sold = sold+1 WHERE id = ?";
            $res1 = $this->db->query($sql1, [$row['order_quantity'] ,$row['order_products']]);
            $sql2 = "UPDATE tbl_orders set order_status = 1 WHERE order_num = ?";
            $sql3 = "UPDATE tbl_orderinfo set order_status = 1 WHERE order_num = ?";
            $this->db->query($sql2, $order);
            $this->db->query($sql3, $order);


          }

        }

        return $data;
    }

    public function closeOrder($order)
    {
      $sql2 = "UPDATE tbl_orders set order_status = 2 , date_closed = ? WHERE order_num = ?";
      $sql3 = "UPDATE tbl_orderinfo set order_status = 2, date_closed = ? WHERE order_num = ?";
      $this->db->query($sql2, $order);
      $this->db->query($sql3, $order);
    }

    /* ========================================================================================= *
     * ======================================ORDERS END========================================= *
     * ========================================================================================= *
    */

    public function genrangeReport($data)
    {
        $sql = "SELECT    b.*,group_concat(a.order_products) as product,group_concat(a.order_quantity) as quantity
                FROM tbl_orders as a INNER JOIN tbl_orderinfo as b  ON a.order_num = b.order_num
                WHERE b.order_status = 2 OR b.order_status = 3 AND b.date_closed >= ? AND b.date_closed <= ? GROUP BY b.order_num ORDER BY b.id ASC";

        $res = $this->db->query($sql,$data);

        if ($res->num_rows()>0) {

          $data['orderinfo']    = $res->result_array();
          $data['productinfo']  = [];

            foreach ($res->result_array() as $row) {

              $prod = explode(',', $row['product']);

              foreach ($prod as $pid) {

                  $sql1   = "SELECT id,product_name,product_price,product_stock FROM tbl_products WHERE id =? LIMIT 1";
                  $data['productinfo'][$pid] = $this->db->query($sql1, $pid)->row_array();

              }

            }

            return $data;

        }else{
          return 0;
        }
    }

    public function genallReport()
    {
      /*
      $sql = "SELECT * FROM tbl_orders WHERE order_status = 2 OR order_status = 3";
      $res = $this->db->query($sql);
      if ($res->num_rows() > 0) {
        return $res->result_array();
      }else{
        return 0;
      } */

      $sql = "SELECT    b.*,group_concat(a.order_products) as product,group_concat(a.order_quantity) as quantity
              FROM tbl_orders as a INNER JOIN tbl_orderinfo as b  ON a.order_num = b.order_num
              WHERE b.order_status = ? OR b.order_status = ? GROUP BY b.order_num ORDER BY b.id ASC";

      $res = $this->db->query($sql,[2,3]);

      if ($res->num_rows()>0) {

        $data['orderinfo']    = $res->result_array();
        $data['productinfo']  = [];

          foreach ($res->result_array() as $row) {

            $prod = explode(',', $row['product']);

            foreach ($prod as $pid) {

                $sql1   = "SELECT id,product_name,product_price,product_stock FROM tbl_products WHERE id =? LIMIT 1";
                $data['productinfo'][$pid] = $this->db->query($sql1, $pid)->row_array();

            }

          }

          return $data;

      }else{
        return 0;
      }

    }

  }


 ?>
