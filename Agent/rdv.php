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
</head>

<body>
<table width="1200" height="543" border="0">
  <tr>
    <td height="23" colspan="4">&nbsp;</td>
    <td width="195"><form name="frm" action="rdv.php" method="post"/><?php echo $_SESSION['cat'] ; echo '  :  <a href="http://localhost/projet/index.php?action=logout " > Deconexion </a>';
	?></form></td>
  </tr>
  <tr>
    <td width="184" height="123">&nbsp;</td>
    <td colspan="5" class="banniere">&nbsp;</td>
  </tr>
   <form name="menu" id="menu" method="post" action="rdv.php">
  <tr>
    <td height="23">&nbsp;</td>
    <td width="170" class="tabmenu"><input name="accueil" type="submit" class="boutton"  id="accueil" value="Accueil" /></td>
    <td width="170" class="tabmenu"><input name="ajoutp" type="submit" class="boutton"  id="ajoutp" value="Ajouter Patient" /></td>
    <td width="170" class="tabmenu"><input name="syntheseP" type="submit" class="boutton" id="synthesep" value="synthese Patient" /></td>
    <td width="195" class="tabmenu"><input name="comptep" type="submit" class="boutton"  id="comptep" value="Gestion Compte"></td>
    <td width="170" class="tabmenu"><input name="rdvp" type="submit" class="click "  id="rdvp" value="Prendre Rendez-vous" /></td>
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
       <form name="recherche" id="recherche" method="post" action="compte.php" onSubmit="return verification(this,false);">
		  <p>entrer le nom et la date</p>
		  <p><label for="nom">Nom :</label>          
		  <p>
		    <input name="nom" type="text"  value="">
	      <p><label>date naissance :</label>          
		  <p> 
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
            echo'</select>
	      <p> <input type="submit" name="rechercheNS" value="Chercher NSS"></p>';
?>
</form>

<?php
	               //----------------rechercher--------------------->
   mysql_connect('localhost','root')or die('erreur de connexion au serveur');
   $connect=mysql_connect('localhost','root');
   mysql_select_db('gestionclinique',$connect)or die('erreur de connexion a la base de donnee');
if(isset($_POST['rechercheNS'])){
   if(!empty($_POST['nom'])){
   $nom=$_POST['nom'];
   $jour=$_POST['jour'];
   $mois=$_POST['mois'];
   $annee=$_POST['annee'];
   $date=$annee."-".$mois."-".$jour;
   $q = mysql_query("select * from patient where nomP='$nom' AND datenP = '$date'")or die("ereur requete selection");
    if(mysql_num_rows($q)==0){
    echo 'pas de NSS pour le patient '.$nom.' ne en : '.$date.'<p><input type="submit" name="ajoutp" value="Ajouter patient"/></p>';
	}else{
	
$raw=mysql_fetch_row($q);
            echo'<p><label>Nom :</label><input name="nom" type="text"  value="'.$nom.'" readonly="readonly"/></p>';
            echo'<p><label>Date :</label><input name="date" type="text"  value="'.$date.'" readonly="readonly"/></p>';
		    echo'<p><label>NSS :</label><input name="nss" type="text"  value="'.$raw[8].'" readonly="readonly"/></p>';
 echo'<input type="hidden" name="var" value="0">';
 }
}else{
echo ' champs nom est vide !!!!!!';
}
}
mysql_close();
?>
</form></td>
    <td colspan="4" rowspan="2"> <form name="choixrdv" id="choixrd" method="post" action="rdv.php" >


<h1>Prendre rdv</h1>
<p><label>Nom Medecin : </label><select name="nommedecin" id="nommedecin">
 <?php
 echo'<fieldset>';
 mysql_connect('localhost','root')or die('erreur de connexion au serveur');
 $connect=mysql_connect('localhost','root');
 mysql_select_db('gestionclinique',$connect)or die('erreur de connexion a la base de donnee'); 
// pour prendre un RDV	
$sepecialite = mysql_query("select * from medecin");
$nommedecin = mysql_query("select * from medecin");
while($option=mysql_fetch_row($nommedecin)){

$nomM=$option[2];

echo'<option value="'.$nomM.'">'.$nomM.'</option>';
}

echo'</select></p><p><label>Sepecialiter : </label><select name="specialite" id="specialite">';
while($option=mysql_fetch_row($sepecialite)){
$spec=$option[8];
echo'<option value="'.$spec.'">'.$spec.'</option>';
}
echo'</select></p><input type="submit" value="Rechercher" name="cherchedispo"/>';
echo'</fieldset>';

global $var;
?>
</form>
<form name="affichechoix" id="affichechoix" method="post" action="rdv.php" >
<?php
if(isset($_POST['cherchedispo'])){
echo'<fieldset>';
$spec=$_POST['specialite'];
$nomM=$_POST['nommedecin'];
echo'<input type="hidden" name="specialite" value="'.$spec.'"/><input type="hidden" name="nommedecin" value="'.$nomM.'"/>';
$dispo = mysql_query("select * from medecin where nomM='$nomM' AND specialite='$spec'");
if(mysql_num_rows($dispo)==0){
echo'<p>pas de medecin avec le nom : '.$nomM.' et la specilaite : '.$spec.'</p>'; 
echo'<p><input type="submit" name="rdvp" value="Nouvelle recherche" /></p>';
}else{

while($option=mysql_fetch_row($dispo)){
$login=$option[9];
echo'<p>Le medecin '.$nomM.' avec la secialite '.$spec.' existe !!</p><input type="hidden" name="login" value="'.$login.'" /><input type="hidden" name="var" value="0" />';
echo'<input type="hidden" name="specialite" value="'.$spec.'"/><input type="hidden" name="nommedecin" value="'.$nomM.'"/>';
echo'<p><input type="submit" name="afficheplaninng" value="affiche son planning" />';
}
}
$var=0;
echo'</fieldset>';
}

if(isset($_POST['afficheplaninng'])){
	$loginA=$_SESSION['cat'];
	$login=$_POST['login'];
	header('Location: http://localhost/projet/Agent/planning.php?login='.$loginA.'&action=login&loginM='.$login.''); 
}
mysql_close();
?></form></td>
  </tr>
  <tr>
    <td>&nbsp;</td>
  </tr>
</table>
</body>
</html>
