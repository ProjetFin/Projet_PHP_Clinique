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
   <form name="menu" id="menu" method="post" action="compte.php" onSubmit = "return verification(this,false);">
  <tr>
    <td height="23">&nbsp;</td>
    <td width="170" class="tabmenu"><input name="accueil" type="submit" class="boutton"  id="accueil" value="Accueil" /></td>
    <td width="170" class="tabmenu"><input name="ajoutp" type="submit" class="boutton"  id="ajoutp" value="Ajouter Patient" /></td>
    <td width="170" class="tabmenu"><input name="syntheseP" type="submit" class="boutton" id="synthesep" value="synthese Patient" /></td>
    <td width="195" class="tabmenu"><input name="comptep" type="submit" class="click "  id="comptep" value="Gestion Compte"></td>
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
    <form name="recherche" id="recherche" method="post" action="compte.php" onSubmit="return verification(this,false);">
		  <p>entrer le nom et la date</p>
		  <p><label for="nom">Nom :</label>          
		  <p>
		    <input name="nom" type="text"  value="">
	      <p><label>date naissance :</label>          
		  <p>
		  <select name="jour" id="jour"><option value="">jour</option>';
<?php		    
			for($i=1;$i<=31;$i++){
			if($i<10)
		echo'<option value="'.$i.'">0'.$i.'</option>';
		else
		echo'<option value="'.$i.'">'.$i.'</option>';
		}
	        echo'</select><select name="mois" id="mois"><option value="">mois</option>';
					for($i=1;$i<=12;$i++){
			if($i<10)
		echo'<option value="'.$i.'">0'.$i.'</option>';
		else
		echo'<option value="'.$i.'">'.$i.'</option>';
		}
            echo'</select>
	        <select name="annee" id="annee">
            <option value="">annee</option>';
		for($i=1999;$i>=1881;$i--){	
		echo'<option value="'.$i.'">'.$i.'</option>';
}
            echo'</select>';
?>
<p> <input type="submit" name="rechercheNS" value="Chercher NSS"></p>
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
<td colspan="4" rowspan="2"> 
    
    
    <form name="choixcompte" id="choixcompte" method="post" action="compte.php" onSubmit = "return verification(this,false);"> <fieldset>

		<p>Pour avoir un compte il faut etre enregistrer dans notre clinique </p>
		<p></p>
		<input name="ajoutcompte" type="submit"  value="Ajouter compte"/>
		<input name="cherchercompte" type="submit"  value="afficher un compte"/>
		</fieldset>
		<p></p>
		</form>
 <?php
 //ouvrire une connexion avec la base de donnee
 mysql_connect('localhost','root')or die('erreur de connexion au serveur');
 $connect=mysql_connect('localhost','root');
 //selectionnee la table
 mysql_select_db('gestionclinique',$connect)or die('erreur de connexion a la base de donnee'); 		
//entrer un nss pour cr�e un nouveau compte
?>

<form name="ajoutcompte" id="ajoutcompte" method="post" action="compte.php" onSubmit = "return verification(this,false);"> 
<?php
if(isset($_POST['ajoutcompte'])){
echo'<fieldset>';
		echo'<p><label>Numero de securite sociale :</label><input name="nss" type="text" value="" /></p>
            <input type="submit" name="ajoutercompte" id="ajoutercompte" value="Ajouter nouveau Compte" onClick="return Confirmajoutcompte()"/><input type="submit" name="comptep" id="comptep" value="Retour" />';	
			echo'</fieldset>';
}
//creation d'un compte pour le patient avec le nss.
if(isset($_POST['ajoutercompte'])){
echo'<fieldset>';
    $nss=$_POST['nss'];
	$action="creation";
	$motif="nouveau";
	$new=0;
	$newdate=date('Y-m-d H:i:s');
		$selectnss="select * from patient where nss=$nss"; 
		$selectnsc="select * from compte where NSS=$nss";
		//verifier si le pateint avec se nss existe dans la base 
        $verifnss=mysql_query($selectnss)or die('erreur d\'execution de la requete selection pateint');
        $verifnsc=mysql_query($selectnsc)or die('erreur d\'execution de la requete selection compte');		
                //s'il existe pas on l'ajoute pas 		
		        if(mysql_num_rows($verifnss)==0){
                echo '<p>pas de pateint avec le num securiter sociale : <b>'.$nss.'</b>!<p><input type="hidden" name="nss" value="'.$nss.'">';
				echo'<input type="submit" value="Ajouter Patient" name="ajoutp"><input type="submit" value="Retour" name="ajoutcompte">';
                    }else{
					if(mysql_num_rows($verifnsc)==0){
					//s'il existe pas on l'ajoute
				
		            $query="insert into compte values('$nss','$new','$newdate','$action','$new','$motif')"; 
                      mysql_query($query)or die(mysql_error());
                      echo'<p>compte ajouter avec succes</p><p><label>NSS   : </label><input type="text" name="nss" value="'.$nss.'"></p>';
					  echo'<input type="submit" value="Ajouter un Nouveau compte" name="ajoutcompte"><input type="submit" value="Afficher donnee compte" name="affichagecompte">';
		            }else{
					echo '<p>un compte avec le num securiter sociale : <b>'.$nss.'</b>existe deja!<p><input type="hidden" name="nss" value="'.$nss.'">';
					echo'<input type="submit" value="Afficher donnee compte" name="affichagecompte"><input type="submit" value="Ajouter un Nouveau compte" name="ajoutcompte">';
					}
				}
				echo'</fieldset>';
}
?>
</form>
<form name="affichagecompte" id="affichagecompte" method="post" action="compte.php" onSubmit = "return verification(this,false);"> 
<?php
//cherche les information ddu compte d'un patient par son nss !!
	if(isset($_POST['cherchercompte'])){
	    echo'<fieldset>';
	    echo'entrer le nss du patient pour le quelle vous voulez effectuer un payement';
		echo'<p> <label>num securite social :</label><input name="nss" type="text"  value=""></p>';
		//boutton pour afficher les informations du compte 
	    echo'<p> <input type="submit" name="affichagecompte" id="affichagecompte" value="afficher donnee"></p>';
		echo'</fieldset>';
}
// affichage des info du compte du patient !!

		if(isset($_POST['affichagecompte'])){
		echo'<fieldset>';
	   $nss=$_POST['nss'];
	   $qe = mysql_query("select * from patient where nss= '$nss'")or die("ereur requete");
	   $qc = mysql_query("select * from compte where NSS= '$nss' ORDER BY date DESC")or die("ereur requete");
       if(mysql_num_rows($qe)==0){
       echo 'pas de patient avec le nss'.$nss.'';
	   echo'<input type="submit" value="Ajouter Patient" name="ajoutp"><input type="submit" value="Retour" name="cherchercompte">';
       }else{
	      	   $raw=mysql_fetch_row($qe);
	   $nom=$raw[1];
       $prenom=$raw[2];
	   if(mysql_num_rows($qc)!=0){
	   $rawc=mysql_fetch_row($qc);
	   $date=$rawc[2];
	   $nss=$rawc[0];
       $solde=$rawc[1];
		echo'<p> <label>nom :</label><input name="nom" type="text"  value="'.$nom.'" readonly="readonly"></p>';
		echo'<p> <label>prenom :</label><input name="pren" type="text"  value="'.$prenom.'" readonly="readonly"></p>';
		echo'<p> <label>nss :</label><input name="nss" type="text"  value="'.$nss.'" readonly="readonly"></p>';
		echo'<p> <label>Solde du compte :</label><input name="solde" type="text"  value="'.$solde.'" readonly="readonly"></p>';
		  // boutton pour effectuer un payement .                                                  
		echo'<p><input type="submit" name="debiter" id="debiter" value="effectuer un payement">';
		 // boutton pour effectuer un virement .
		echo'<input type="submit" name="virementp" id="virementp" value="effectuer un virement">';
		echo'<input type="submit" name="historique" id="historique" value="Historique"></p>';
		}else{
		echo'Le patient '.$nom.' n\'as pas de compte 
		vous voullez lui atribuer un compte :
		<input type="submit" value="Ajouter un Nouveau compte" name="ajoutcompte">';
		}
		}
		echo'</fieldset>';
  }
  ?>
 </form>
<form name="historique" id="historique" method="post" action="compte.php" onSubmit = "return verification(this,false);"> 
  <?php
  		if(isset($_POST['historique'])){
		echo'<fieldset>';
	   $nss=$_POST['nss'];
	   $qe = mysql_query("select * from patient where nss= '$nss'")or die("ereur requete");
	   $qc = mysql_query("select * from compte where NSS= '$nss' ORDER BY date DESC")or die("ereur requete");
       if(mysql_num_rows($qe)==0){
       echo 'pas de patient avec le nss'.$nss.'';
       }else{
	   	   $raw=mysql_fetch_row($qe);
	   $nom=$raw[1];
       $prenom=$raw[2];
		echo'<p> <label>nom :</label><input name="nom" type="text"  value="'.$nom.'" readonly="readonly"></p>';
		echo'<p> <label>prenom :</label><input name="pren" type="text"  value="'.$prenom.'" readonly="readonly"></p>';
		echo'<p> <label>nss :</label><input name="nss" type="text"  value="'.$nss.'" readonly="readonly"></p><table name="compte" align="center"><tr><th>date</th><th>|</th><th>solde</th><th>|</th><th>Action</th><th>|</th><th>montant</th><th>|</th><th>Motif</th></tr><hr align="center" width="50%" color="midnightblue" size="2">';
	    echo'<tr><td>_________________</td><td></td><td>__________</td><td></td><td>________</td><td></td><td>_______</td><td></td><td>_______</td></tr>';
		while($rawc=mysql_fetch_row($qc)){ 
	   $date=$rawc[2];
	   $nss=$rawc[0];
       $solde=$rawc[1];
	   $action=$rawc[3];
	   $argent=$rawc[4];
	   $motif=$rawc[5];
	    echo'<tr><td>'.$date.'</td><td>|</td><td>'.$solde.' euro</td><td>|</td><td>'.$action.' </td><td>|</td><td>'.$argent.' euro</td><td>|</td><td>'.$motif.'</td></tr>';
	    echo'<tr><td>_________________</td><td></td><td>__________</td><td></td><td>________</td><td></td><td>_______</td>';
		  }
		  // boutton pour effectuer un payement.                                                  
		echo'<p><input type="submit" name="debiter" id="debiter" value="effectuer un payement">';
		 // boutton pour effectuer un virement.
		echo'<input type="submit" name="virementp" id="virementp" value="effectuer un virement"><input type="submit" name="affichagecompte" id="affichagecompte" value="Retour"></p>';
		}
		echo'</fieldset>';
  }
  ?>
  </form>
  <form name="debit" id="debit" method="post" action="compte.php" onSubmit = "return verification(this,false);"> 
  <?php
//------------------------------------------------------------------------------------------------------  
  // effectuer un payement !!
//si je click sur effectuer un payement  
if(isset($_POST['debiter'])){
echo'<fieldset>';
$nss=$_POST['nss'];
//je selectionne le solde du compte a la date la plus r�cente
$qc = mysql_query("select * from compte where NSS= '$nss' ORDER BY date DESC" )or die("ereur requete");
$actes = mysql_query("select * from acte");
       if(mysql_num_rows($qc)==0){
       echo 'pas de patient avec le nss'.$nss.'';
       }else{
	   $rawc=mysql_fetch_row($qc);
	   $nssc=$rawc[0];
       $solde=$rawc[1];
			echo'entrer le montant du payement';
			echo'<p> <label>nss :</label><input name="nss" type="text"  value="'.$nss.'" readonly="readonly"></p>';
			echo'<p> <label>solde du compte :</label><input name="soldecompt" type="text"  value="'.$solde.'" readonly="readonly"></p>';
			echo'<p><label>Selectionez le motif de votre payement</label>
			<select name="actep" >';
			while($option=mysql_fetch_row($actes)){
			$value=$option[0];
			echo'<option value="'.$value.'">'.$value.'</option>';
			}
			echo'</select></p>';
			echo'<p> <input type="submit" name="choixpayement" id="choixpayement" value="effectuer le payement">';
			echo'<input type="submit" name="affichagecompte" id="affichagecompte" value="Annuler Payament"></p>';
			}
			echo'</fieldset>';
		}
		?>
</form>	
<form name="choixpayement" id="choixpayement" method="post" action="compte.php" onSubmit = "return verification(this,false);"> 
<?php
	
if(isset($_POST['choixpayement'])){
echo'<fieldset>';
$choix=$_POST['actep'];
$nss=$_POST['nss'];
$solde=$_POST['soldecompt'];

			$actee = mysql_query("select prix from acte where motif='$choix'")or die ("ereur selection prix");
			$prix=mysql_fetch_row($actee);
			$valu=$prix[0];
			echo'<p> <label>nss :</label><input name="nss" type="text"  value="'.$nss.'" readonly="readonly"></p>';
			echo'<p> <label>solde du compte :</label><input name="soldecompt" type="text"  value="'.$solde.'" readonly="readonly"></p>';
			echo'<p> <label>le montant d\'une '.$choix.' est de :</label><input name="prix" type="text"  value="'.$valu.'"  readonly="readonly"></p>';
            echo'<input type="hidden" name="motif" value="'.$choix.'"/>';
			if($solde < $valu ){
echo'votre solde est insufisant pour payer  '.$choix.'';
echo'<p>vous pouvez effectuer un viremnt sur votere compte <input type="submit" name="enregistrerpayeme" id="virementp" value="effectuer virement">';
}else{			
echo'<p> <input type="submit" name="enregistrerpayement" id="enregistrerpayement" value="finaliser le payement">';
echo'<input type="hidden" name="payement" id="debiter" value="debit">';
}
echo'<input type="submit" name="debiter" id="debiter" value="Retour"></p>';
echo'</fieldset>';
}		
// enrgeitrement du payement !!!			
if(isset($_POST['enregistrerpayement'])){
echo'<fieldset>';
$nss=$_POST['nss'];
$solde=$_POST['soldecompt'];
$prix=$_POST['prix'];
$motif=$_POST['motif'];
$action=$_POST['payement'];
$newdate=date('y-m-d H:i:s');
$res=(($solde)-($prix));
mysql_query("insert into compte values('$nss','$res','$newdate','$action','$prix','$motif')")or die("ereur requete insertion");
$newc=mysql_query("select * from compte where NSS = '$nss' ORDER BY date DESC ")or die("ereur requete selection"); 
      $rawss=mysql_fetch_row($newc);
       $soldee=$rawss[1];
			echo'entrer le montant du payement';
			echo'<p> <label>nss :</label><input name="nss" type="text"  value="'.$nss.'" readonly="readonly"></p>';
			echo'<p> <label>solde du compte :</label><input name="soldecompt" type="text"  value="'.$solde.'" readonly="readonly"></p>';
			echo'<p> <label>nouveau solde du compte :</label><input name="soldecompte" type="text"  value="'.$soldee.'" readonly="readonly"></p>';
			echo'<p><input type="submit" name="debiter" id="debiter" value="r\'effectuer un payement">';
			echo'<input type="submit" name="affichagecompte" id="affichagecompte" value="information compte"></p>
			<input name="soldecompte" type="hidden"  value="'.$soldee.'" readonly="readonly"></p>'; 
			echo'</fieldset>';
}
?>			
</form>
<form name="virement" id="virement" method="post" action="compte.php" onSubmit = "return verification(this,false);"> 
<?php
if(isset($_POST['virementp']) || isset($_POST['enregistrerpayeme']) ){
echo'<fieldset>';
$nss=$_POST['nss'];
$newc=mysql_query("select * from compte where NSS= '$nss' ORDER BY date DESC ")or die("ereur requete selection"); 
      $rawss=mysql_fetch_row($newc);
       $soldee=$rawss[1];
	        echo'<p> <label>nss :</label><input name="nss" type="text"  value="'.$nss.'" readonly="readonly"></p>';
			echo'<p> <label>solde du compte :</label><input name="soldecompte" type="text"  value="'.$soldee.'" readonly="readonly"></p>';
			echo'entrer le montant que vous voulez ajouter a votre compte:';
			echo'<p> <label>le montant que vous voulez ajouter a votre compte:</label><input name="somme" type="text"  value="" ></p>';
			echo'<p> <input type="submit" name="enregistreajout" id="enregistrerajout" value="effectuer un virement">';
			echo'<input type="submit" name="affichagecompte" id="affichagecompte" value="information compte"></p>';
			echo'</fieldset>';
			}
			
if(isset($_POST['enregistreajout']) ){
echo'<fieldset>';
$nss=$_POST['nss'];
$solde=$_POST['soldecompte'];
$virement=$_POST['somme'];
$newdate=date('y-m-d H:i:s');
$vir="virement";
$mot="alimenter_compte";
$res=(($solde)+($virement));
mysql_query("insert into compte values('$nss','$res','$newdate','$vir','$virement','$mot')")or die(mysql_error());
$newc=mysql_query("select * from compte where NSS= '$nss' ORDER BY date DESC")or die("ereur requete selection"); 
      $rawss=mysql_fetch_row($newc);
       $soldee=$rawss[1];
	   	    echo'<p> <label>nss :</label><input name="nss" type="text"  value="'.$nss.'" readonly="readonly"></p>';
			echo'<p> <label>solde du compte :</label><input name="soldecompt" type="text"  value="'.$solde.'" readonly="readonly"></p>';
			echo'<p> <label>nouveau solde du compte :</label><input name="soldecompte" type="text"  value="'.$soldee.'" readonly="readonly"></p>';
			echo'<p> <input type="submit" name="enregistrerpayeme" id="virementp" value="effectuer un virement sur votre compte">';
			echo'<input type="submit" name="affichagecompte" id="affichagecompte" value="information compte"></p>';
			echo'</fieldset>';
}
mysql_close()
?>
</form>      </td>
  </tr>
  <tr>
    <td>&nbsp;</td>
  </tr>
</table>

</body>
</html>
