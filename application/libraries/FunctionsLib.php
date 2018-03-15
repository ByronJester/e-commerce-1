<?php

  /**
   *
   */
  class FunctionsLib
  {



     public function helloworld()
     {
       echo "HELLO WORLD";
     }

     public function sanitize($data)
     {
        $data = trim($data);
        $data = addslashes($data);
   	    //$data = stripslashes($data);
        $data = htmlspecialchars($data);
   	    return $data;
     }

     public function sanitizer($data)
     {
       $return = [];

       foreach ($data as $key) {

          $key = trim($key);
    	    $key = stripslashes($key);
    			//$key = addslashes($key);
    	    $key = htmlspecialchars($key);
          array_push($return, $key);
       }

       return $return;
     }


     public function uniqueImage(){

       $unique_ref_length = 8;
     		$unique_ref_found = false;
     		$possible_chars = "abcdefghijklmnopqrstuvwxyz1234567890";
     		while (!$unique_ref_found) {
     		    $unique_ref = "";
     		    $i = 0;
     		    $unique_ref = mt_rand(100000000,999999999);
     		    $result = $this->functionsmodel->uniqueImage($unique_ref);
     		    if ($result->num_rows==0) {
     		        $unique_ref_found = true;
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
     		    $result = $this->functionsmodel->uniqueOrder($unique_ref);
     		    if ($result->num_rows==0) {
     		        $unique_ref_found = true;
     		    }

     		}

     }

      public function getIP() {
               $ipaddress = '';
               if (getenv('HTTP_CLIENT_IP'))
                   $ipaddress = getenv('HTTP_CLIENT_IP');
               else if(getenv('HTTP_X_FORWARDED_FOR'))
                   $ipaddress = getenv('HTTP_X_FORWARDED_FOR');
               else if(getenv('HTTP_X_FORWARDED'))
                   $ipaddress = getenv('HTTP_X_FORWARDED');
               else if(getenv('HTTP_FORWARDED_FOR'))
                   $ipaddress = getenv('HTTP_FORWARDED_FOR');
               else if(getenv('HTTP_FORWARDED'))
                  $ipaddress = getenv('HTTP_FORWARDED');
               else if(getenv('REMOTE_ADDR'))
                   $ipaddress = getenv('REMOTE_ADDR');
               else
                   $ipaddress = 'UNKNOWN';
               return $ipaddress;
       }




  }


 ?>
