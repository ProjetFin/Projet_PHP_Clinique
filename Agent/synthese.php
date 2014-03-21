<?php
session_start();
if(!isset($_SESSION['cat'])){
header('Location: http://localhost/projet/index.php'); 
session_destroy();
exit();
}
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Untitled Document</title>
<link rel="stylesheet" type="text/css" href="../style.css" />
<script type="text/javascript" src="../Javascript/verifierformulaire.js"></script>
</head>

<body>
<table width="1200" height="543" border="0">
  <tr>
    <td height="23" colspan="4">&nbsp;</td>
    <td width="195"><?php echo $_SESSION['cat'] ; echo '  :  <a href="http://localhost/projet/index.php?action=logout " > Deconexion </a>';?></td>
  </tr>
  <tr>
    <td width="184" height="123">&nbsp;</td>
    <td colspan="5" class="banniere"></td>
  </tr>
   <form name="Recherche" id="Recherche" method="post" action="synthese.php">
  <tr>
    <td height="23">&nbsp;</td>
    <td width="170" class="tabmenu"><input name="accueil" type="submit" class="boutton"  id="accueil" value="Accueil" /></td>
    <td width="170" class="tabmenu"><input name="ajoutp" type="submit" class="boutton"  id="ajoutp" value="Ajouter Patient" /></td>
    <td width="170" class="tabmenu"><input name="syntheseP" type="submit" class="click " id="synthesep" value="synthese Patient" /></td>
    <td width="195" class="tabmenu"><input name="comptep" type="submit" class="boutton"  id="comptep" value="Gestion Compte"></td>
    <td width="170" class="tabmenu"><input name="rdvp" type="submit" class="boutton"  id="rdvp" value="Prendre Rendez-vous" /></td>
    <td width="4">&nbsp;</td>
  </tr>
   </form>
    <?php
	if(isset($_POST['accueil'])){
	//$login=$_GET['login'];
	$login=$_SESSION['cat'];
	header('Location: http://localhost/projet/Agent/accueil.php?login='.$login.'&action=login'); 
	}
	if(isset($_POST['ajoutp'])){
	//$login=$_GET['login'];
	$login=$_SESSION['cat'];
	header('Location: http://localhost/projet/Agent/ajout.php?login='.$login.'&action=login'); 
	}
	if(isset($_POST['syntheseP'])){
	//$login=$_GET['login'];
	$login=$_SESSION['cat'];
	header('Location: http://localhost/projet/Agent/synthese.php?login='.$login.'&action=login'); 
	}
	if(isset($_POST['comptep'])){
	//$login=$_GET['login'];
	$login=$_SESSION['cat'];
	header('Location: http://localhost/projet/Agent/compte.php?login='.$login.'&action=login'); 
	}
	if(isset($_POST['rdvp'])){
	//$login=$_GET['login'];
	$login=$_SESSION['cat'];
	header('Location: http://localhost/projet/Agent/rdv.php?login='.$login.'&action=login'); 
	}
	?>
  <tr>
    <td height="192" class="recherche">
      <form name="recherche" id="recherche" method="post" action="synthese.php" onSubmit = "return verification(this,false);">
		  <p>entrer le nom et la date</p>
		  <p><label for="nom">Nom :</label>          
		  <p>
		    <input name="nom" type="text"  value="">
	      <p><label>date naissance :</label>          <p>
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
            echo'</select></p>';   
?>	
<p> <input type="submit" name="rechercheNS" value="Chercher NSS"></p>
<?php		               //----------------rechercher--------------------->
   mysql_connect('localhost','root')or die('erreur de connexion au serveur');
   $connect=mysql_connect('localhost','root');
   mysql_select_db('gestionclinique',$connect)or die('erreur de connexion a la base de donnee');
if(isset($_POST['rechercheNS'])){
   $nom=$_POST['nom'];
   $jour=$_POST['jour'];
   $mois=$_POST['mois'];
   $annee=$_POST['annee'];
   $date=$annee."-".$mois."-".$jour;
   $q = mysql_query("select * from patient where nomP='$nom' AND datenP = '$date'")or die("ereur requete selection");
    if(mysql_num_rows($q)==0){
    echo 'pas de NSS pour le patient '.$nom.' ne en : '.$date.'';
	}else{
	
$raw=mysql_fetch_row($q);
            echo'<p><label>Nom :</label><input name="nom" type="text"  value="'.$nom.'" readonly="readonly"/></p>';
            echo'<p><label>Date :</label><input name="dateNaiss" type="text"  value="'.$date.'" readonly="readonly"/></p>';
		    echo'<p><label>NSS :</label><input name="rechnss" type="text"  value="'.$raw[8].'" readonly="readonly"/></p>';
 echo'<input type="hidden" name="var" value="0">';
 }

}
mysql_close();
?></td>
    <td colspan="4" rowspan="2"> 
     
 <form name="affichesynthese" id="affichesynthese" method="post" action="synthese.php" onSubmit ="return verification(this,false); return Confirmmodification();">
      <!----------------code ajout--------------------->
<!--pour afficher kle formulaire de l'ajout d'un nouveau patient!!! --->   
 <?php
$db = mysql_connect('localhost','root');
mysql_select_db('gestionclinique',$db);
  if(isset($_POST['affichesyntheseP'])){
  echo'<fieldset>';
   $nss=$_POST['recupnss'];
   $s = mysql_query("select * from synthese where nssP= '$nss'")or die("ereur requete selection sythese");
   $q = mysql_query("select * from patient where nss= '$nss'")or die("ereur requete selection patient");
    if(mysql_num_rows($q)==0){
    echo 'pas de patient avec le nss'.$nss.'';
	echo'<p><input type="submit" name="ajoutp" id="ajoutp" value="Ajouter Patient"><input type="submit" name="syntheseP" id="syntheseP" value="Retour"></p>';
echo'</fieldset>';
	}else{
$raw=mysql_fetch_row($q);
$sexe=$raw[0];
$nom=$raw[1];
$prenom=$raw[2];
$date=$raw[3];
$adresse=$raw[4];
$tel=$raw[5];
$mail=$raw[6];
$prof=$raw[7];
$situ=$raw[9];
		    echo'<p> <label>sexe :</label><input name="sexe" type="text"  value="'.$sexe.'" readonly="readonly"></p>
			<p> <label>Nom :</label><input name="nom" type="text"  value="'.$nom.'" readonly="readonly"></p>
            <p> <label>Prenom :</label><input name="prenom" type="text" value="'.$prenom.'" readonly="readonly"></p>
			 <p> <label>date naissance :</label><input name="dateNaiss" type="text" value="'.$date.'" readonly="readonly"></p>
			<p> <label>Adresse :</label><input name="adresse" type="text"  value="'.$adresse.'"></p>
            <p> <label>Num Tel :</label><input name="tel" type="text" value="0'.$tel.'"></p>
            <p> <label>Mail :</label><input name="mail" type="text"  value="'.$mail.'"></p>
            <p> <label>Profetion :</label><input name="profession" type="text" value="'.$prof.'"></p>
			<p><label>Situation familiale :</label><input name="situation" type="text" value="'.$situ.'" readonly="readonly"></p>
		    <p> <label>NSS :</label><input name="nss" type="text" value="'.$nss.'" readonly="readonly"></p><p></p>
            <input type="submit" name="modifierp" id="modifierp" value="Modifier">';
			echo'<input type="submit" name="syntheseP" id="syntheseP" value="Retour"><p></p>';
			echo'</fieldset>';
			if(mysql_num_rows($s)==0){
           echo '<p></p><label>pas de synthese pour le patient avec le nss'.$nss.'</label><p></p>';
           }else{
		   echo'<table class="tablesynthese" name="synthese" border="1"><tr><th>Nom Medecin consultant</th><th>Motif visite</th><th> Date </th><th> prix </th> <th> compte rendu </th><th> Suivi </th></tr>';
           while($raw=mysql_fetch_row($s)){
		   $nomm=$raw[1];
           $motif=$raw[3];
		   $date=$raw[4];
           $prix=$raw[5];
		   $cr=$raw[6];
           $suivi=$raw[7];
			echo'<tr><td>  '.$nomm.' </td><td> '.$motif.' </td><td> '.$date.' </td><td> '.$prix.' euro </td><td> '.$cr.' </td><td> '.$suivi.' </td></tr>';
}
echo '</table>';
}
}
  echo'</fieldset>';}
?>
</form>
 <form name="newaffichesynthese" id="newaffichesynthese" method="post" action="synthese.php" onSubmit ="return verification(this,false); return Confirmmodification();">
<?php
//------------------------------------------------
//----------------------------------------------------------
  if(isset($_POST['newaffichesyntheseP'])){
  echo'<fieldset>';	
   $nss=$_POST['nss'];
   $s = mysql_query("select * from synthese where nssP= '$nss'")or die("ereur requete selection sythese");
   $q = mysql_query("select * from patient where nss= '$nss'")or die("ereur requete selection patient");
    if(mysql_num_rows($q)==0){
    echo 'pas de patient avec le nss'.$nss.'';
	echo'<p><input type="submit" name="ajoutp" id="ajoutp" value="Ajouter Patient"><input type="submit" name="rechercheNS" id="rechercheNS" value="Retour"></p>';
echo'</fieldset>';
	}else{
$raw=mysql_fetch_row($q);
$sexe=$raw[0];
$nom=$raw[1];
$prenom=$raw[2];
$date=$raw[3];
$adresse=$raw[4];
$tel=$raw[5];
$mail=$raw[6];
$prof=$raw[7];
$situ=$raw[9];
		    echo'<p> <label>Nom :</label><input name="sexe" type="text"  value="'.$sexe.'" readonly="readonly"></p>
			<p> <label>Nom :</label><input name="nom" type="text"  value="'.$nom.'" readonly="readonly"></p>
            <p> <label>Prenom :</label><input name="prenom" type="text" value="'.$prenom.'" readonly="readonly"></p>
			 <p> <label>date naissance :</label><input name="dateNaiss" type="text" value="'.$date.'" readonly="readonly"></p>
			<p> <label>Adresse :</label><input name="adresse" type="text"  value="'.$adresse.'"></p>
            <p> <label>Num Tel :</label><input name="tel" type="text" value="0'.$tel.'"></p>
            <p> <label>Mail :</label><input name="mail" type="text"  value="'.$mail.'"></p>
            <p> <label>Profetion :</label><input name="profession" type="text" value="'.$prof.'"></p>
			<p><label>Situation familiale :</label><input name="situation" type="text" value="'.$situ.'" readonly="readonly"></p>
		    <p> <label>NSS :</label><input name="nss" type="text" value="'.$nss.'" readonly="readonly"></p><p></p>
            <input type="submit" name="modifierp" id="modifierp" value="Modifier">';
			echo'<input type="submit" name="syntheseP" id="syntheseP" value="Retour"><p></p>';
			echo'</fieldset>';
			if(mysql_num_rows($s)==0){
			
           echo '<fieldset><p></p> <label> pas de synthese pour le patient avec le nss'.$nss.'</label> <p></p> </fieldset>';
		  
           }else{
		   echo'<table class="tablesynthese" name="synthese" border="1"><tr><th>Nom Medecin consultant</th><th>Motif visite</th><th> Date </th><th> prix </th> <th> compte rendu </th><th> Suivi </th></tr>';
           while($raw=mysql_fetch_row($s)){
		   $nomm=$raw[1];
           $motif=$raw[3];
		   $date=$raw[4];
           $prix=$raw[5];
		   $cr=$raw[6];
           $suivi=$raw[7];
			echo'<tr><td>'.$nomm.' </td><td> '.$motif.' </td><td> '.$date.' </td><td> '.$prix.' euro </td><td> '.$cr.' </td><td> '.$suivi.' </td></tr>';
}

echo '</table>';

}
}
  echo'</fieldset>';}
?>
</form>
 <form name="modifierp" id="modifierp" method="post" action="synthese.php" onSubmit ="return verification(this,false); return Confirmmodification();">
<?php
//-----------------------------------------------------------
//-------------------------------------------------

if(isset($_POST['modifierp'])){
echo'<fieldset>';
$sexe=$_POST['sexe'];
$nom=$_POST['nom'];
 $prenom=$_POST['prenom'];
  $date=$_POST['dateNaiss'];
   $adresse=$_POST['adresse'];
    $tel=$_POST['tel'];
	 $mail=$_POST['mail'];
	  $prof=$_POST['profession']; 
	   $situ=$_POST['situation'];
	   $nss=$_POST['nss'];  
	   
	   echo $situ;
			echo'<p> <label>NSS :</label>'.$nss.'</p>
			<p> <label>Sexe :</label>'.$sexe.'</p>
		    <p> <label>Nom :</label>'.$nom.'</p>
            <p> <label>Prenom :</label>'.$prenom.'</p>
			 <p> <label>date naissance :</label>'.$date.'</p>
			<p> <label>Adresse :</label><input name="adresse" type="text"  value="'.$adresse.'"></p>
            <p> <label>Num Tel :</label><input name="tel" type="text" value="'.$tel.'"></p>
            <p> <label>Mail :</label><input name="mail" type="text"  value="'.$mail.'"></p>
            <p> <label>Profetion :</label><input name="profession" type="text" value="'.$prof.'"></p>
			<p><label>Situation familiale :</label><select name="situation">';
			if($situ=='marie'){
			    echo' <option value="marie" selected="selected" >marie</option>
			          <option value="celibataire">celibataire</option>
			          <option value="divorce" >divorce</option>
					    <option value="autre" >autre</option>';
			}
			else if($situ=='divorce'){
			    echo' <option value="marie" >marie</option>
			          <option value="celibataire" >celibataire</option>
			          <option value="divorce" selected="selected" >divorce</option>
					    <option value="autre" >autre</option>';
			}
			else if($situ=='celibataire'){
			    echo' <option value="marie" >marie</option>
			          <option value="celibataire"  selected="selected" >celibataire</option>
			          <option value="divorce" >divorce</option>
					  <option value="autre" >autre</option>';
			}  
            else if($situ=='autre'){
			    echo' <option value="marie" >marie</option>
			          <option value="celibataire" >celibataire</option>
			          <option value="divorce" >divorce</option>
					  <option value="autre"  selected="selected" >autre</option>';
			}  			
			echo'</select></p>
			<input name="dateNaiss" type="hidden" value="'.$date.'" readonly="readonly">
			<input name="prenom" type="hidden" value="'.$prenom.'" readonly="readonly">
			<input name="nss" type="hidden" value="'.$nss.'" readonly="readonly">
			<input name="sexe" type="hidden" value="'.$sexe.'" readonly="readonly">
			<input name="nom" type="hidden" value="'.$nom.'" readonly="readonly">
			<input type="hidden" name="var" value="1">
			
            <input type="submit" name="modifier" id="modifier" value="Modifier" /><input type="submit" name="newaffichesyntheseP" id="newaffichesyntheseP" value="Retour a la synthese" /></fieldset>';
	   echo'</fieldset>';
}
?>
</form>
 <form name="modifier" id="modifier" method="post" action="synthese.php" onSubmit ="return verification(this,false); return Confirmmodification();">
<?php
// modification de certaine info du patient !!!
			if(isset($_POST['modifier'])){
			echo'<fieldset>';
$sexe=$_POST['sexe'];
$nom=$_POST['nom'];
 $prenom=$_POST['prenom'];
  $date=$_POST['dateNaiss'];
   $adresse=$_POST['adresse'];
    $tel=$_POST['tel'];
	 $mail=$_POST['mail'];
	  $prof=$_POST['profession']; 
	   $situ=$_POST['situation'];
	   $nss=$_POST['nss'];
	   echo $situ;
                   mysql_query("UPDATE patient SET adresseP = '$adresse', telP = '$tel', mailP = '$mail',profession = '$prof', situation = '$situ' WHERE nss = '$nss' ")or die("ereur requete") ;
				   echo'le patient '.$_POST['nom'].' avec le nss  '.$nss.' a bien etai modifier<input name="nss" type="hidden" value="'.$nss.'" readonly="readonly">';
				   
				   
			echo'
			<input name="nom" type="hidden"  value="'.$nom.'" ><input name="sexe" type="hidden"  value="'.$sexe.'" ><input name="prenom" type="hidden"  value="'.$prenom.'" ><input name="dateNaiss" type="hidden"  value="'.$date.'" >
			<p><label>Adresse :</label><input name="adresse" type="text"  value="'.$adresse.'" readonly="readonly"></p>
            <p><label>Num Tel :</label><input name="tel" type="text" value="'.$tel.'" readonly="readonly"></p>
            <p><label>Mail :</label><input name="mail" type="text"  value="'.$mail.'" readonly="readonly"></p>
            <p><label>Profetion :</label><input name="profession" type="text" value="'.$prof.'" readonly="readonly"></p>
			<p><label>Situation familiale :</label><input name="situation" type="text" value="'.$situ.'" readonly="readonly"></p>
			<input type="hidden" name="var" value="1">
			<input type="submit" name="
			
			p" value="nouvelle modification"/><input type="submit" name="newaffichesyntheseP" value="affiche synthese"/>';		
echo'</fieldset>';
}
mysql_close();
?>

</form>
 <form name="choixsynthese" id="choixsynthese" method="post" action="synthese.php" onSubmit ="return verification(this,false); return Confirmmodification();">
<fieldset>
<p></p>pour afficher la synthese entrer le numero de securiter social
<p><label>NSS:</label><input name="recupnss" type="text"  value=""></p>
<p><input type="submit" name="affichesyntheseP" value="afficher synthese"> </p>
<input type="hidden" name="var" value="1"> </fieldset>
</form> </td>
  </tr>
  <tr>
    <td>&nbsp;</td>
  </tr>
</table>
</body>
</html>
