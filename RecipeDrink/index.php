<?php
    session_start();

    if(!isset($_SESSION['validite'])){
      $milliseconds = round(microtime(true) * 1000);
      $_SESSION['validite'] = $milliseconds + 10;
    }

    function getKey($len = 64){
      $res = "";
      $now = explode(' ', microtime())[1] ;
      $res = hash('ripemd160', $now, false);
      return $res;
    }

    if(!isset($_SESSION['id']) || strlen($_SESSION['id'])!=40 || $_SESSION['validite'] < round(microtime(true) * 1000) ){
      $_SESSION['id'] = getKey();
    }


    echo "<input id=\"sessionID\" type=\"hidden\" value=\"".$_SESSION['id']."\">";
?>
<html>
    <head>
        <title>Appli</title>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <link rel="stylesheet" type="text/css" href="appliCSS.css" media="all"/>
        <script type="text/javascript" src="https://code.jquery.com/jquery-3.3.1.js"></script>
        <script type="text/javascript" src="melting.js"></script>
        <script type="text/javascript">
          $(document).ready(function()
          {
            genererCategorie("Aliment", indice);
            session_id = document.getElementById("sessionID").value;
          });
        </script>
    </head>
    <body>
        <div class="page">
            <table>
                <tr class="titre">
                    <td colspan="3" width="100%" ><a href="Appli.php">Appli</a></td>
                </tr>
                <tr class="menu">
                    <td><a href="MesRecettes.php">Mes recettes préférées</a></td>
                    <td><a href="Recherche.html">Recherche</a></td>
                    <td><a href="Connexion.html">Connexion</a></td>
                </tr>
                <tr class="sousmenu">
                    <td colspan="3">

                        <table class="texte">
                            <tr>
                                <td>
                                  <!--<a onclick="like(1);">laa</a>-->
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
