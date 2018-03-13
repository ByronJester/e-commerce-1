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

    public function newproduct($data)
    {
      $this->db->insert('tbl_products', $data);
      $insert_id = $this->db->insert_id();

      return $insert_id;
    }

    public function editProduct($data)
    {
      $sql = "UPDATE tbl_products set product_name = ?, product_price = ?, product_stock =? WHERE id = ?";
      return $this->db->query($sql, $data);
    }

    public function getProducts()
    {
      $sql = "SELECT * FROM tbl_products";
      return $this->db->query($sql);
    }

    public function pulloutProduct($data)
    {
        $sql = "DELETE FROM tbl_products WHERE id = ?";
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


  }


 ?>
