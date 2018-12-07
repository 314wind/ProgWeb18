<html>
    <head> <meta charset="utf-8">
	<title>Listes ingrédient</title>
        <script type="text/javascript" src="https://code.jquery.com/jquery-3.3.1.js"></script>
	<script type="text/javascript">

            var indice = 0;
            var indice_inj = 0;
            var val = 0;
            var lesSousCat;
            var lesRecettes;

            $(document).ready(function()
            {

               genererCategorie("Aliment", indice);


            });


            function genererCategorie(nom, i){
                indice_inj = i;
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
                var str = ""
                if(newArray.length > 1){
                    for(var i = 0; i< newArray.length-1; i++){
                        val++;
                        var tmp = newArray[i];
                        //alert(tmp);
                        str+=tmp + "<br>";
                    }
                    str+="</div>";
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

            function injecterImageRecette(xhrObj){

              alert(xhrObj);

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
    <table border="1">
        <tr>
            <td>
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
</body>
</html>
