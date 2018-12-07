<?php
    /*$name=$_GET["nom"];
    $MotDePasse=$_GET["mdp"];
    if(isset($name)){
        //echo $name;
    }*/
?>
<html>
    <head>
        <title>Appli</title>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <link rel="stylesheet" type="text/css" href="appliCSS.css" media="all"/>
        <script type="text/javascript" src="https://code.jquery.com/jquery-3.3.1.js"></script>
        <script type="text/javascript">
                  var indice = 0;
                  var indice_inj = 0;
                  var val = 0;
                  var lesSousCat;
                  var lesRecettes;
                  var chemin = "";
                  var arrayAliment = [];

                  $(document).ready(function()
                  {
                     genererCategorie("Aliment", indice);
                  });


                  function genererCategorie(nom, i){
                      indice_inj = i;
                      var tmp = chemin;
                      var condition = document.getElementById("div"+indice_inj+"input").value;
                      if(condition == 0){ //sous catégorie déjà généré
                        if(!arrayAliment.includes(nom)){
                          chemin = chemin + " > " + nom;
                          arrayAliment.push(nom);
                        }
                      }else {
                        var pos = arrayAliment.indexOf(nom);
                        arrayAliment.splice(pos, arrayAliment.length);
                        chemin = tmp;
                      }
                      document.getElementById("chemin").innerHTML = arrayAliment.toString();
                      ajaxGetSubCategorie(nom);
                  }


                  function injecter(array){
                      //alert(array);
                      var newArray = array.split("|");
                      //alert(newArray);
                      injecter_sub_categorie(newArray[0]);
                      injecter_recettes(newArray[1]);
                  }

                  function injecter_recettes(array){
                      var string = ""
                      var i = 0;
                      var newArray = array.split("*");
                      indice++;
                      var tmpVal = val;
                      var str = "<table border=\"2\"><tr><td>";
                      if(newArray.length > 1){
                          for(var i = 0; i< newArray.length-1; i++){
                              val++;
                              var tmp = newArray[i];


                              str+="<div id=\""+tmp+"\">"
                              str+=tmp +" ";

                              str+="<a href=\"./like.php\"><img src=\"./Photos/icon-like.png \" width=\"20\" height=\"20\"></a><br><br>";
                              $.get("./test?image="+newArray[i], function(data, status){
                                  if(data!=0){
                                    var arr = data.split("|");
                                    //alert(arr);
                                    document.getElementById(arr[0]).innerHTML +="<img src=\"./"+arr[1]+"\" width=\"50\" height=\"50\">";
                                  }

                              });

                              str+="</div>"
                              if(i%10 == 0){
                                str+="</td><td>"
                              }
                              if(i%(newArray.length/4)== 0){
                                str+="</td></tr><tr><td>";
                              }
                          }
                          str+="</td></tr></table>";
                          //alert(indice_inj);
                          document.getElementById("rec").innerHTML = str;
                      }
                  }

                  function injecter_sub_categorie(array){
                      //alert(array);
                      var condition = document.getElementById("div"+indice_inj+"input").value;
                      if(condition == 1){ //sous catégorie déjà généré
                         document.getElementById("div"+indice_inj+"input").value = 0;
                         document.getElementById("div"+indice_inj).innerHTML = "";
                      } else {
                          array = array.slice(1);
                          //alert("======+>"+array);
                          var i = 0;
                          var newArray = array.split("*");
                          var tmpVal = val;
                          var str = "";

                          indice++;

                          if(newArray.length > 1){
                              str+="<ul class=\"cat\">";
                              for(var i = 0; i< newArray.length-1; i++){
                                  val++;
                                  //alert("...."+newArray[i]);
                                  var tmp = newArray[i].replace(/ /g,"_");
                                  //alert("...."+tmp);

                                  str+=" <li class=\"t\" value=\""+(val) +
                                      "\" onclick=getValue(\""+tmp+"\","+
                                      val+") ><span>"+newArray[i]+"</span>"+
                                      "</li>"+
                                      "<input type=\"hidden\" id=\"div"+val+"input\" value=\"0\">"+
                                      "<div id=\"div"+val+"\"></div>";
                              }
                              str+="</ul>";
                              //alert(str);
                              document.getElementById("div"+indice_inj).innerHTML += str;
                              document.getElementById("div"+indice_inj+"input").value = 1;
                          }
                      }
                  }

                  function ajaxGetSubCategorie(nom){
                  //alert(nom);
                  //test les differents navigateur
                  try{
                      xhr = new ActiveXObject("Microsoft.XMLHTTP"); // Essayer IE
                  }
                  catch(e){   // Echec, utiliser l'objet standard
                      xhr = new XMLHttpRequest();
                  }

                  //fonction anonyme a executer lorsque les données sont traitées
                  xhr.onreadystatechange = function(){
                      injecter(xhr.responseText);
                  };


                  xhr.onreadystatechange  = function() {
                     if(xhr.readyState  == 4){
                          if(xhr.status  == 200)
                              injecter(xhr.responseText);
                          else
                              alert("Error code " + xhr.status);
                     }
                  };

                  xhr.open("GET", "test.php?ingredient="+nom);
                  xhr.send(null); //car methode get

              }

              function getValue(str, ind){
                  var tmp = str.replace(/_/g," ");
                  //alert(tmp +" "+ ind);
                  genererCategorie(tmp, ind);
              }

              </script>
    </head>
    <body>
        <div class="page">
            <table>
                <tr class="titre">
                    <td colspan="3" width="100%" ><a href="Appli.php">Appli</a></td>
                </tr>
                <tr class="menu">
                    <td><a href="MesRecettes.html">Mes recettes préférées</a></td>
                    <td><a href="Recherche.html">Recherche</a></td>
                    <td><a href="Connexion.html">Connexion</a></td>
                </tr>
                <tr class="sousmenu">
                    <td colspan="3">

                        <table class="texte">
                            <tr>
                                <td>

                                  <!--- Bloc sur lequel JS va travailler----------->
                                  <table border="1" >

                                      <tr>
                                        <td align="center" colspan="2">
                                          <p id="chemin"> X </p>
                                        </td>
                                      <tr>
                                          <td align="left">
                                              <div id="div0" onclick="test()">
                                                  <input type="hidden" id="div0input" value="0">
                                              </div>
                                           </td>

                                           <td>
                                               <div id="rec">


                                               LES RECETTES :
                                               </div>
                                              </td>
                                      </tr>
                                  </table>


                                </td>
                            </tr>
                        </table>

                    </td>
                </tr>
            </table>
        </div>
    </body>
</html>
