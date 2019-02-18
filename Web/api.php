<?php



header("Access-Control-Allow-Headers:Access-Control-Allow-Origin");
header("Access-Control-Allow-Origin: http://localhost:4200"); 
header('Content-type: Application/json; charset=utf-8'); 


switch($_GET["action"])
{
case "consult" :
 echo api::Consult();
break;

}

class api{

  public static function consult()
  {
    // $rawpostdata = file_get_contents("php://input");
    // var_dump($rawpostdata);

    $name = $_GET["name"];
      
    if($name == "Json")
    {

      $data = array();
      $data[] = array("id" => 1 , "Name"=> "Fiche Sécurite");
      $data[] = array("id" => 2 , "Name"=> "Fiche Incendie");

      return json_encode($data);
    }
    else
    {
      $html = "<label>Fournisseur</label>";
      $html .= "<input type='text' placeholder='nom du fournisseur'>";

      return $html;
    }
 }
}