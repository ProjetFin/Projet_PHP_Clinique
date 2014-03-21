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
    <td colspan="5" class="banniere">&nbsp;</td>
  </tr>
   <form name="Menu" id="Menu" method="post" action="accueil.php">
  <tr>
    <td height="23">&nbsp;</td>
    <td width="170" class="tabmenu"><input name="accueil" type="submit" class="click "  id="accueil" value="Accueil" /></td>
    <td width="170" class="tabmenu"><input name="ajoutp" type="submit" class="boutton"  id="ajoutp" value="Ajouter Patient" /></td>
    <td width="170" class="tabmenu"><input name="syntheseP" type="submit" class="boutton" id="synthesep" value="synthese Patient" /></td>
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
    <form name="Recherche" id="Recherche" method="post" action="accueil.php" onSubmit = "return verification(this,false);">
		  <p>entrer le nom et la date</p>
		  <p><label for="nom">Nom :</label>          
		  </p>
		    <p><input name="nom" type="text"  value=""></p>
	       <p><label>date naissance :</label> </p>        
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
<p><input type="submit" name="rechercheNS" value="Chercher NSS" /></p></fieldset>	   
</form>		   


<?php		               //----------------rechercher--------------------->

   mysql_connect('localhost','root')or die('erreur de connexion au serveur');
   $connect=mysql_connect('localhost','root');
   mysql_select_db('gestionclinique',$connect)or die('erreur de connexion a la base de donnee');
if(isset($_POST['rechercheNS'])){
   if(!empty($_POST['jour']) && !empty($_POST['annee']) && !empty($_POST['mois'])){
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
            echo'<p><label>Date :</label><input name="date" type="text"  value="'.$date.'" readonly="readonly"/></p>';
		    echo'<p><label>NSS :</label><input name="nss" type="text"  value="'.$raw[8].'" readonly="readonly"/></p>';
 echo'<input type="hidden" name="var" value="0">';
 }
}else{
echo 'Selectionez une date ';
}
}
mysql_close();
?>
</td>
    <td colspan="6" rowspan="2" class="tabfond">
<?php
	$moi=$_SESSION['cat'];
   mysql_connect('localhost','root')or die('erreur de connexion au serveur');
   $connect=mysql_connect('localhost','root');
   mysql_select_db('gestionclinique',$connect)or die('erreur de connexion a la base de donnee');
   $res=mysql_query("select * from agent where log='$moi'");
   $raw=mysql_fetch_row($res);
     $nomAgent=$raw[2];
      $prenomAgent=$raw[3];
  echo'<p><label>Bienvenu vous etez sur la session de</label></p>';
  echo'<p><label>'.$nomAgent.'</label></p>';
  echo'<p><label>'.$prenomAgent.'</label></p>';

	?>     </td>
  </tr>
  <tr>
    <td>&nbsp;</td>
  </tr>
</table>
</body>
</html>
