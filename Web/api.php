<?php

header('access-control-allow-origin:http://localhost:4200'); 
   header('access-control-allow-credentials:true');
   header('access-control-allow-methods:GET, POST, OPTIONS, PUT, PATCH, DELETE');
   //header('Content-Type: application/json');

   
   var_dump($_POST);
   $data = "sdffsf";
     json_encode($data);