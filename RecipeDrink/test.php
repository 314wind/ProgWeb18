
<?php
    include("Donnees.inc.php");

    //retourne la sous catégorie du $nom
    function get_sous_categorie($nom, $the_array)
    {
      $string = "";
        if(array_key_exists($nom, $the_array)){ //la categorie existe
            /* @var $sous_categorie ArrayObject */
            if(array_key_exists('sous-categorie', $the_array[$nom])){
              $sous_categorie = $the_array[$nom]['sous-categorie'];
              $string = "";
              foreach($sous_categorie as $key => $value){
                if($value!=""){
                  $string = $string  . $value . "|";
                  utf8_encode($string);
                }
              }
            }
        }
        if($string == ""){
          return array();
        } else {
          return explode("|", $string);
        }
    }

    function getRecetteByIngredientRecursive($les_recettes, $ingredient, $hierarchie, $res){
      $arr = get_sous_categorie($ingredient, $hierarchie);
      //print_r($arr);
      if($arr!="" || count($arr) > 0){
        $res = getRecetteByIngredient($les_recettes, $ingredient);
        for($i=0; $i<count($arr); $i++){
          //echo "<br>xxx ".$arr[$i]  ." xxx <br>";
          $tmp = getRecetteByIngredientRecursive($les_recettes, $arr[$i], $hierarchie, $res);
          //echo gettype($res);
          //echo "<br>=======<br>";
          //echo gettype($tmp);
          $res = array_merge($res, $tmp);
        }

      } else {
        return array();
      }

      return $res;
    }

    //retourne toutes les recettes en fonction de l'ingredient
    // si l'ingredient est contenu dans la recette (la préparation)
    // on l'ajoute
    function getRecetteByIngredient($les_recettes, $ingredient){
        $string ="";
        for($i=0; $i<count($les_recettes); $i++){
            $index = $les_recettes[$i]['index'];
            if(in_array($ingredient, $index)){
              foreach($index as $value){
                if(stristr($value, $ingredient)){
                  $string = $string . $les_recettes[$i]['titre']."|";


                }
              }
            }
        }
        if($string == ""){
          return array();
        } else {
          return explode("|", $string);
        }
    }

    function imageExists($nom){
      //iterrer sur les noms des images dans le dossier photos
      $res = "0";
      $files = scandir('Photos/');
      foreach($files as $file) {
        if(stristr($file, $nom)){
          $res = "$nom|Photos/".$file;
        }
      }
      return $res;
    }



    //=====MAIN=====//


    $string = "";

    if(isset($_GET['ingredient']) && $_GET['ingredient'] != ""){

        $the_array = array();
        $ingredient = $_GET['ingredient'];
        $arr = get_sous_categorie($ingredient, $Hierarchie);

        foreach($arr as $value){
          if($value!="" && !in_array($value, $the_array)){
            array_push($the_array, count($the_array)+1, $value);
            $string = $string.$value."*";
          }
        }


        $arr2 = getRecetteByIngredientRecursive($Recettes, $ingredient, $Hierarchie, "");
        //echo "here";

        $string = $string . "|";
        foreach($arr2 as $value){
          if($value!="" && !in_array($value, $the_array)){
            array_push($the_array, count($the_array)+1, $value);
            $string = $string.$value."*";
          }
        }

        echo $string;

    }

    if (isset($_GET['image']) && $_GET['image'] !=""){
        $string = imageExists($_GET['image']);
        echo $string;
    }

    if(isset($_GET['like']) && $_GET['like'] !="" ){
      $data = $_GET['like']."*";
      file_put_contents ("panier.txt" , $data , FILE_APPEND | LOCK_EX);
    }

    if(isset($_GET['data_like']) && $_GET['data_like'] !=""){
      $file = file_get_contents('panier.txt');
      $string = "";
      $arr = explode("*", $file);
      //echo "==== key : " . $_GET['data_like'] . " ====<br>";
      foreach($arr as $key=>$value){

        //echo "key " . $key . "<br> value " . $value . "<br>";
        if($value !=""){
          $data = explode("|", $value);
          //echo "<br>====>". $data[0] . "<br>====>". $data[1]. "<br>===<br>";
          $string = $string . $data[0] . "*";
          //string += hello ne fonctionne pas
        }

      }
      echo $string;
    }


?>
