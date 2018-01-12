<?php

namespace Apps\Api;

use Core\App\Application;

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
class Api extends Application
{

    function Execute()
    {
        
    //  echo json_encode( $_POST);
    //  echo json_encode($_FILES);
      
      echo "RECUPERATION DES DONNeeS";
      print_r($_POST);
      
      print_r($_FILES);
       echo file_get_contents('php://input');
      
      
      echo json_encode(array_merge($_FILES));
       // $data = '{"test":"test"}';
     //echo $data;
       // echo "qsdqdqdqqdqd";
        
       // var_dump($_POST);
    }
    
}
