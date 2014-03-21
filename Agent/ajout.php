<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Ajout</title>

  <link rel="stylesheet" type="text/css" href="global/css/main.css">
 <script  language="javascript" src="verifierformulaire.js" ></script>
</head>
<body onLoad="onPageLoad()">
<div id="site_header"> </div>
<table width="930" cellpadding="0" cellspacing="0" align="center" border="0" summary="Main content table">
<tbody><tr>
  <td width="104"><a href="accueil.php"><img src="images/tab1_unselectedd.jpg" name="tab1" width="103" height="25" border="0" id="tab1"></a></td>
  <td class="tab_divider"> </td>
  <td width="104"><a href="ajout.php" onClick="selectPage(&quot;generator&quot;);return false;"><img src="images/tab2_selectedd.jpg" name="tab2" width="103" height="25" border="0" id="tab2"></a></td>
  <td class="tab_divider"> </td>
  <td width="104"><a href="synthese.php"><img src="images/tab3_unselected.jpg" name="tab3" width="103" height="25" border="0" id="tab3"></a></td>
  <td class="tab_divider"> </td>
  <td width="104"><a href="compte.php"><img src="images/tab4_unselected.jpg" name="tab4" width="103" height="25" border="0" id="tab4"></a></td>
  <td class="tab_divider"> </td>
  <td width="104"><a href="rdv.php"><img src="images/tab5_unselected.jpg" name="tab5" width="103" height="25" border="0" id="tab5"></a></td>
  <td class="tab_divider"> </td>
  <td width="104">&nbsp;</td>
  <td nowrap="" valign="bottom" width="300">
	  <div style="position: relative">
	  <div id="page_loading_icon" style="position: absolute; right: 0px; top: -20px; display: none; "><img src="generatedata.com_files/loading2.gif" width="16" height="16"></div>
		      <img src="generatedata.com_files/spacer.gif" height="1" width="300">		</div>	</td>
  <td width="7"> </td>
</tr>
</tbody></table>
<table width="930" cellpadding="0" cellspacing="0" align="center" border="0" summary="Main content table">
<tr>
  <td id="corp" height="200" colspan="12">
<center><form name="ajoutC" id="ajoutC" method="post" action="ajout.php" onSubmit = "return verification(this,false)" ><legend>   </legend>
            <p><label>Sexe :</label><select name="sexe" id="sexe"><option value="homme">homme</option><option value="femme">femme</option></select></p>
            <p><label>Numero de securite sociale :</label><input name="nss" type="text" value="" /></p>
            <p><label>Nom :</label><input name="nom" type="text" value="" /></p>
            <p><label>Prenom :</label><input name="prenom" type="text" value=""/></p>
			<p> <label>date naissance :</label>
			 <?php		  
		    echo'<select name="jour" id="jour"><option value="">Jour</option>';
			for($i=1;$i<=31;$i++){
			if($i<10)
		echo'<option value="'.$i.'">0'.$i.'</option>';
		else
		echo'<option value="'.$i.'">'.$i.'</option>';
		}
	        echo'</select><select name="mois" id="mois"><option value="">Mois</option>';
					for($i=1;$i<=12;$i++){
			if($i<10)
		echo'<option value="'.$i.'">0'.$i.'</option>';
		else
		echo'<option value="'.$i.'">'.$i.'</option>';
		}
            echo'</select>
	        <select name="annee" id="annee">
            <option value="">Annee</option>';
		for($i=1999;$i>=1881;$i--){	
		echo'<option value="'.$i.'">'.$i.'</option>';
}
            echo'</select>';
?>
			</p>
			<p> <label>Adresse :</label><input name="adresse" type="text"  value=""/></p>
            <p> <label>Num Tel :</label><input name="tel" type="text" value=""/></p>
            <p> <label>Mail :</label><input name="mail" type="text"  value=""/>
            </p>
            <p> <label>Profetion :</label><input name="profession" type="text" value=""></p>
			<p> <label>Situation Familiale :</label> 
		  <select name="situation" id="situation"><option value="celibataire">celibataire</option><option                 value="marie">marie</option><option value="divorce" >divorce</option><option value="autre">autre</option></select></p>
            <input type="submit" name="ajouter" id="ajouter" value="Ajouter Patient" /> <input type="reset"                 name="reset" id="reset" value"tout efface"/>
</form>
     <?php
    mysql_connect('localhost','root')or die('erreur de connexion au serveur');
   $connect=mysql_connect('localhost','root');
   mysql_select_db('gestionclinique',$connect)or die('erreur de connexion a la base de donnee');
   
   if(isset($_POST['ajouter'])) {
        $nss=$_POST['nss'];
		$selectnss="select * from patient where nss=$nss"; 
        $verifnss=mysql_query($selectnss)or die('erreur d\'execution de la requete selection');		
		        if(mysql_num_rows($verifnss)!=0){
				echo'</form>';
				 echo'<form name="ajoutpatient" id="ajoutpatient" method="post" action="synthese.php" >';
                echo '<p>un patient avec le numero de securiter sociale  :  <b>'.$nss.'</b>  existe deja !<p><p><input type="submit"     name="affichesyntheseP" value="affiche la synthese du patient"><input type="submit" name="ajoutp" id="ajoutp" value="Retour"></p>';
				echo'<input type="hidden" name="nss" value="'.$nss.'">';
				echo'</form>';
                    }else{
					  $sexe=$_POST['sexe'];
                      $nss=$_POST['nss'];
		              $Nom=$_POST['nom'];
      	              $Prenom=$_POST['prenom'];
                      $jour=$_POST['jourajout'];
                      $mois=$_POST['moisajout'];
                      $annee=$_POST['anneeajout'];
                      $Date=$annee."-".$mois."-".$jour;
                      $Tel=$_POST['tel'];
		              $Mail=$_POST['mail'];
                      $Adresse=$_POST['adresse'];
      	              $Profession=$_POST['professionajout'];
                      $Situation=$_POST['situation_ajout'];		
		              mysql_select_db('gestionclinique',$connect)or die('erreur de connexion a la base de donnee');  
		              $query="insert into patient values('$sexe','$Nom','$Prenom','$Date','$Adresse','$Tel','$Mail','$Profession','$nss','$Situation')";  
                      mysql_query($query)or die('erreur d\'execution de la requete insertion');
                      echo'<p>patient ajouter avec succes</p><input type="submit" name="ajoutp" id="ajoutp" value="Ajouter un Nouveau Patient"/>';
		            }
	}
mysql_close(); 
?> 
</center></p>
    </td>
  <td id="main_table_right_col"><img src="images/main_table_right_top_corner_bg.jpg" border="0" /></td>
</tr>
<tr>
  <td colspan="12" id="bottom_row">

    <table cellpadding="0" cellspacing="0" width="100%" summary="Main Table Bottom Row">
    <tr>
      <td width="20"><img src="images/main_table_left_bottom_rounded_corner.jpg" border="0" /></td>
      <td align="center" valign="top">

        <table cellpadding="0" cellspacing="0" width="100%">
        <tr>
          <td width="100"> </td>
          <td align="center" id="footer"></td>
          <td width="100" align="right"></td>
        </tr>
        </table>      </td>
      <td width="19"><img src="images/main_table_right_bottom_rounded_corner.jpg" border="0" /></td>
    </tr>
    </table></td>
  <td><img src="images/main_table_right_bottom_corner_bg.jpg" border="0" /></td>
</tr>
</table>
</body>
</html>
