  function charger_prix()
{
  var prix="";
  var dep_text = document.getElementById("selectcat").value;

 
  if(dep_text!="00"){
    //alert(dep_text);
    if(dep_text=="j10"){
     document.getElementById("prix").value="133";
    }
    if(dep_text=="j11"){
     document.getElementById("prix").value="133";
    }
    if(dep_text=="j12"){
     document.getElementById("prix").value="133";
    }
    if(dep_text=="j13"){
     document.getElementById("prix").value="214";
    }
    if(dep_text=="j14"){
     document.getElementById("prix").value="214";
    }
    if(dep_text=="j15"){
     document.getElementById("prix").value="224";
    }
    if(dep_text=="j16"){
     document.getElementById("prix").value="224";
    }
    if(dep_text=="j17"){
     document.getElementById("prix").value="255";
    }
    if(dep_text=="j18"){
     document.getElementById("prix").value="255";
    }
    if(dep_text=="Sénior Compétition étudiant"){
     document.getElementById("prix").value="260";
    }if(dep_text=="Sénior Compétition non étudiant"){
     document.getElementById("prix").value="326";
    }if(dep_text=="Sénior Loisir Bateau seul étudiant"){
     document.getElementById("prix").value="260";
    }if(dep_text=="Sénior Loisir Bateau seul non étudiant"){
     document.getElementById("prix").value="326";
    }if(dep_text=="Sénior Loisir Bateau + Avifit étudiant"){
     document.getElementById("prix").value="355";
    }if(dep_text=="Sénior Loisir Bateau + Avifit non étudiant"){
     document.getElementById("prix").value="421";
    }if(dep_text=="Sénior Loisir Avifit seul"){
     document.getElementById("prix").value="179";
    }if(dep_text=="Sénior Loisir Avifit entreprise"){
     document.getElementById("prix").value="128";
    }if(dep_text=="Sénior Loisir AVACS"){
      document.getElementById("prix").value="60";
     }
     if(dep_text=="Sénior Loisir SANTE"){
      document.getElementById("prix").value="60";
     }
 }
  else
  alert("veuillez selectionner une catégorie");
}

function charger_prix2()
{
  var prix="";
  var dep_text = document.getElementById("selectcat2").value;

 
  if(dep_text!="00"){
    //alert(dep_text);
    if(dep_text=="j10"){
     document.getElementById("prix").value="133";
    }
    if(dep_text=="j11"){
     document.getElementById("prix").value="133";
    }
    if(dep_text=="j12"){
     document.getElementById("prix").value="133";
    }
    if(dep_text=="j13"){
     document.getElementById("prix").value="214";
    }
    if(dep_text=="j14"){
     document.getElementById("prix").value="214";
    }
    if(dep_text=="j15"){
     document.getElementById("prix").value="224";
    }
    if(dep_text=="j16"){
     document.getElementById("prix").value="224";
    }
    if(dep_text=="j17"){
     document.getElementById("prix").value="255";
    }
    if(dep_text=="j18"){
     document.getElementById("prix").value="255";
    }
    if(dep_text=="Sénior Compétition étudiant"){
     document.getElementById("prix").value="260";
    }if(dep_text=="Sénior Compétition non étudiant"){
     document.getElementById("prix").value="326";
    }if(dep_text=="Sénior Loisir Bateau seul étudiant"){
     document.getElementById("prix").value="260";
    }if(dep_text=="Sénior Loisir Bateau seul non étudiant"){
     document.getElementById("prix").value="326";
    }if(dep_text=="Sénior Loisir Avifit entreprise"){
     document.getElementById("prix").value="128";
     
     document.getElementById("droit").value="0";
    }if(dep_text=="Sénior Loisir AVACS"){
      document.getElementById("prix").value="60";
     }
     if(dep_text=="Sénior Loisir SANTE"){
      document.getElementById("prix").value="60";
     }
 }
  else
  alert("veuillez selectionner une catégorie");
}

function mystageete() {
  // Get the checkbox
  var checkBox = document.getElementById("StageEte");
  // Get the output text
  var text = document.getElementById("text");

  // If the checkbox is checked, display the output text
  if (checkBox.checked == true){
    text.style.display = "block";
  } else {
    text.style.display = "none";
  }
}



  $(function () {
    var jeune = ["Choisir...","j10", "j11", "j12","j13", "j14", "j15","j16","j17", "j18"];
    var checkBoxjeune = document.getElementById("check")
    var checked = ["Choisir...","j10", "j11", "j12","j13", "j14", "j15","j16","j17", "j18","Sénior Compétition étudiant", "Sénior Loisir Bateau seul étudiant"];
    var unchecked = ["Choisir...", "Sénior Compétition non étudiant", "Sénior Loisir Bateau seul non étudiant", "Sénior Loisir Avifit entreprise", "Sénior Loisir AVACS","Sénior Loisir SANTE"];

    updateSelect(unchecked);
    function updateSelect (arr) {
      $("#selectcat2").html("");
      $.each(arr, function (i, v) {
        $("#selectcat2").append('<option value="' + v + '">' + v + '</option>');
      });
    }



      if (checkBoxjeune.checked)
        updateSelect(checked);
      else 
        updateSelect(unchecked);

        $('#check').change(function () {
          //if (Agean <= 2008)
          // updateSelect(jeune);
          if (this.checked)
            updateSelect(checked);
          else 
            updateSelect(unchecked);
            
          
        });
        
      }); 

    function slectjeune () {
      var checkBox = document.getElementById("check")
      var age = document.getElementById("inputan").value;
    
      if(age > 2003 ){
        checkBox.checked = true
      }
    
    
    }

function mymoi() {
  var jeune = ["Choisir...","j10", "j11", "j12","j13", "j14", "j15","j16","j17", "j18"];
  var checkBoxjeune = document.getElementById("check")
  var checked = ["Choisir...","j10", "j11", "j12","j13", "j14", "j15","j16","j17", "j18","Sénior Compétition étudiant", "Sénior Loisir Bateau seul étudiant"];
  var unchecked = ["Choisir...", "Sénior Compétition non étudiant", "Sénior Loisir Bateau seul non étudiant",  "Sénior Loisir Avifit entreprise", "Sénior Loisir AVACS","Sénior Loisir SANTE"];

  updateSelect(unchecked);
  function updateSelect (arr) {
    $("#selectcat2").html("");
    $.each(arr, function (i, v) {
      $("#selectcat2").append('<option value="' + v + '">' + v + '</option>');
    });
  }



    if (checkBoxjeune.checked)
      updateSelect(checked);
    else 
      updateSelect(unchecked);
      


  $('#check').change(function () {
    //if (Agean <= 2008)
     // updateSelect(jeune);
    if (this.checked)
      updateSelect(checked);
    else 
      updateSelect(unchecked);
      
    
  });
}; 






function charger_textpaiement()
{
  var prix="";
  var select_cat = document.getElementById("Catégorie_paiement").value;

 
  if(select_cat!="00"){
    //alert(select_cat);
    if(select_cat=="stage été"){
     document.getElementById("description_paiement").value="Inscription stage d'été pour la / les semaine(s) ... ";
    }
    if(select_cat=="Adhésion"){
      document.getElementById("description_paiement").value="Paiment adhésion au Cercle Nautique de Meaux aviron de ... en catégorie... ";
     }
     if(select_cat=="Compétition"){
      document.getElementById("description_paiement").value="Paiment pour la nourriture et le logement de la compétition ... ";
     }
     if(select_cat=="Randonnée"){
      document.getElementById("description_paiement").value="Paiment pour ... de la randonnée ... ";
     }    

 }
  else
  alert("veuillez selectionner une catégorie");
}




