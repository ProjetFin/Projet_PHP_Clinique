<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN"
        "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html lang="fr" xml:lang="fr" xmlns="http://www.w3.org/1999/xhtml">
  <head>
      <meta http-equiv="content-type" content="text/html; charset=utf-8" />
      <title>GESTION CLINIQUE</title>
      <meta name="description" lang="fr" content="contenu" />
      <meta name="keywords" lang="fr" content="cle" />
    <link rel="stylesheet" type="text/css" href="styleF.css"/>
	<script type="text/javascript" src="inde.js"></script>
<?php
session_start();
echo '<title> Identification :'.$_SESSION['cat'].'</title>';
?>
</head>
<body>

<center>
<p><label><h1>Agent</h1></label></p>
          <form name="form1" id="form1" method="post" action="agent.php" >
		  <p><input type="submit" name="ajoutp" id="ajoutp" value="Ajouter un Nouveau Patient">
		  <input type="submit" name="syntheseP" value="synthese du patient"> 
		  <input type="submit" name="comptep" id="comptep" value="Gestion de compte">
		  <input type="submit" name="rdvp" id="rdvp" value="Prendre RDV"></p>
		   
		   </form>
</center>
 <center><form name="ajoutC" id="ajoutC" method="post" action="agent.php" >
 <?php
   mysql_connect('localhost','root')or die('erreur de connexion au serveur');
   $connect=mysql_connect('localhost','root');
   mysql_select_db('Gestion_Clinique',$connect)or die('erreur de connexion a la base de donnee');  
 if(isset($_POST['ajoutp'])) {
 echo'<fieldset><legend>Ajout de nouveau patient</legend>
            <p><label>Numero de securite sociale :</label><input name="nssajout" type="text" value="" ></p>
            <p><label>Nom :</label><input name="nomajout" type="text" value="" ></p>
            <p><label>Prenom :</label><input name="prenomajout" type="text" value=""></p>
			<p> <label>date naissance AAAA-MM-JJ:</label><input name="datenajout" type="text" value="" ></p>
			<p> <label>Adresse :</label><input name="adresseajout" type="text"  value=""></p>
            <p> <label>Num Tel :</label><input name="numtelajout" type="text" value=""></p>
            <p> <label>Mail :</label><input name="mailajout" type="text"  value=""></p>
            <p> <label>Profetion :</label><input name="professionajout" type="text" value=""></p>
			<p> <label>Situation Familiale :</label><select name="situation_ajout"><option value="celibataire">celibataire</option><option value="marie">marie</option><option value"divorce">divorce</option></select></p>
            <input type="submit" name="ajouter" id="ajouter" value="Ajouter Patient"/><input type="reset" name="reset" id="reset" value"tout efface" />';

echo'</fieldset>';
}
   if(isset($_POST['ajouter'])) {
   $Nss=$_POST['nssajout'];
		$selectnss="select * from patient where nssP=$Nss"; 
        $verifnss=mysql_query($selectnss)or die('erreur d\'execution de la requete insertion');		
		 if(mysql_num_rows($verifnss)!=0){
        echo '<p>un patient avec le numero de securiter sociale : <b>'.$Nss.'</b> existe deja !<p>';
       }else{
        $Nss=$_POST['nssajout'];
		$Nom=$_POST['nomajout'];
      	$Prenom=$_POST['prenomajout'];
        $Date=$_POST['datenajout'];
        $Tel=$_POST['numtelajout'];
		$Mail=$_POST['mailajout'];
        $Adresse=$_POST['adresseajout'];
      	$Profession=$_POST['professionajout'];
        $Situation=$_POST['situation_ajout'];		
		mysql_select_db('Gestion_Clinique',$connect)or die('erreur de connexion a la base de donnee');  
		$query="insert into patient values('$Nom','$Prenom','$Date','$Adresse','$Tel','$Mail','$Profession','$Situation','$Nss')";  
        mysql_query($query)or die('erreur d\'execution de la requete insertion');
        echo'<p>patient ajouter avec succes</p>';
		}
	}
mysql_close(); 
?>
<?php
$db = mysql_connect('localhost','root');
mysql_select_db('Gestion_Clinique',$db);
if(isset($_POST['syntheseP'])){
echo'<fieldset><legend>Synthese du patient</legend>';
echo'pour afficher la synthese entrer le numero de securiter social';
echo'<p><label>NSS:</label><input name="NSS" type="text"  value=""></p>
<p><input type="submit" name="affichesyntheseP" value="afficher la synthese du patient"> </p>
<input type="submit" name="rechercheNSS" id="rechercheNSS" value="Recherche NSS d\'un patient"></p>';
}
 if(isset($_POST['affichesyntheseP'])){
   if(!empty($_POST['NSS'])){	
   $nss=$_POST['NSS'];
   $s = mysql_query("select * from synthese where nssP= '$nss'")or die("ereur requete selection sythese");
   $q = mysql_query("select * from patient where nssP= '$nss'")or die("ereur requete selection patient");
    if(mysql_num_rows($q)==0){
    echo 'pas de patient avec le nss'.$nss.'';
}else{
$raw=mysql_fetch_row($q);
$nom=$raw[0];
$prenom=$raw[1];
$date=$raw[2];
$adresse=$raw[3];
$tel=$raw[4];
$mail=$raw[5];
$prof=$raw[6];
$situ=$raw[7];
		    echo'<p> <label>Nom :</label><input name="nom" type="text"  value="'.$nom.'" readonly="readonly"></p>
            <p> <label>Prenom :</label><input name="prenom" type="text" value="'.$prenom.'" readonly="readonly"></p>
			 <p> <label>date naissance :</label><input name="daten" type="text" value="'.$date.'" readonly="readonly"></p>
			<p> <label>Adresse :</label><input name="adresse" type="text"  value="'.$adresse.'"></p>
            <p> <label>Num Tel :</label><input name="numtel" type="text" value="0'.$tel.'"></p>
            <p> <label>Mail :</label><input name="mail" type="text"  value="'.$mail.'"></p>
            <p> <label>Profetion :</label><input name="profession" type="text" value="'.$prof.'"></p>
			<p><label>Situation familiale :</label><select name="situf">';
			if($situ=='marie'){
			    echo' <option value="marie" selected="selected" name="marie">Marie</option>
			          <option value="celibataire" name="celibataire">Celibataire</option>
			          <option value="divorce" name="divorce">Divorce</option>';
			}
			else if($situ=='divorce'){
			    echo' <option value="marie" name="marie">Marie</option>
			          <option value="celibataire" name="celibataire">Celibataire</option>
			          <option value="divorce" selected="selected" name="divorce">Divorce</option>';
			}
			else if($situ=='celibataire'){
			    echo' <option value="marie" name="marie">Marie</option>
			          <option value="celibataire"  selected="selected" name="celibataire">Celibataire</option>
			          <option value="divorce" name="divorce">Divorce</option>';
			}                                         
			echo'</select></p>
		    <p> <label>NSS :</label><input name="nssp" type="text" value="'.$nss.'" readonly="readonly"></p>
            <p> <input type="submit" name="modifier" id="modifier" value="Modifier"></p></fieldset><fieldset><legend>liste des consultations et actes</legend>';
			if(mysql_num_rows($s)==0){
           echo 'pas de synthese pour le patient avec le nss'.$nss.'';
           }else{
		   echo'<table name="synthese" border="1"><tr><th>Nom Medecin consultant</th><th>Motif visite<th></th><th> Date </th><th> prix </th> <th> compte rendu </th><th> Suivi </th></tr>';
           while($raw=mysql_fetch_row($s)){
		   $nomm=$raw[0];
           $motif=$raw[1];
		   $date=$raw[2];
           $prix=$raw[3];
		   $cr=$raw[4];
           $suivi=$raw[5];
			echo'<tr><td>  '.$nomm.' </td><td> '.$motif.' </td><td> '.$date.' </td><td> '.$prix.' euro </td><td> '.$cr.' </td><td> '.$suivi.' </td></tr>';
}
echo'</table>';
}

}
}else{
echo ' champs NSS est vide !!!!!!';
echo'</fieldset>';
}

}


			if(isset($_POST['modifier'])){
			echo'<fieldset><legend>les modification enregistrer</legend>';
             if(!empty($_POST['adresse']) && !empty($_POST['numtel']) && !empty($_POST['mail']) && !empty($_POST['profession'])){
		     $adress=$_POST['adresse'];
             $telp=$_POST['numtel'];
             $mailp=$_POST['mail'];
             $profp=$_POST['profession'];
             $situp=$_POST['situf'];
             $nssp=$_POST['nssp'];
                   mysql_query("UPDATE patient SET adresseP = '$adress', telP = '$telp', mailP = '$mailp',ProfessionP = '$profp', situationP = '$situp' WHERE nssP = '$nssp' ")or die("ereur requete") ;
				   echo'le patient '.$_POST['nom'].' a bien etai modifier';
				   
				   
			echo'
			<p><label>Adresse :</label><input name="adressep" type="text"  value="'.$adress.'" readonly="readonly"></p>
            <p><label>Num Tel :</label><input name="numtelp" type="text" value="0'.$telp.'" readonly="readonly"></p>
            <p><label>Mail :</label><input name="mailp" type="text"  value="'.$mailp.'" readonly="readonly"></p>
            <p><label>Profetion :</label><input name="professionp" type="text" value="'.$profp.'" readonly="readonly"></p>
			<p><label>Situation familiale :</label><input name="professionp" type="text" value="'.$situp.'" readonly="readonly"></p>';
}else{
echo'remplir tout les champs';}
echo'</fieldset>';
}
?>
</form></center>
<center><form name="afficherC" id="afficherC" method="post" action="agent.php" >
<?php
	if(isset($_POST['comptep'])){
	    echo'<fieldset><legend>Gestion du compte</legend>';
	    echo'entrer le nss du patient pour le quelle vous voulez effectuer un payement';
		echo'<p> <label>num securite social :</label><input name="nss" type="text"  value=""></p>';
	    echo'<p> <input type="submit" name="affichagecompte" id="affichagecompte" value="afficher donnee"></p></fieldset>';
		
}
		if(isset($_POST['affichagecompte'])){
	   $nss=$_POST['nss'];
	   $qe = mysql_query("select * from patient where nssP= '$nss'")or die("ereur requete");
	   $qc = mysql_query("select * from compteP where nssP= '$nss'")or die("ereur requete");
       if(mysql_num_rows($qe)==0){
	   	   echo'<fieldset><legend>Compte</legend>';
       echo 'pas de patient avec le nss'.$nss.'';
	   	   echo'</fieldset>';
       }else{
	   	   $raw=mysql_fetch_row($qe);
	   $nom=$raw[0];
       $prenom=$raw[1];
	   	echo'<fieldset><legend>Compte</legend>';
		echo'<p> <label>nom :</label><input name="nomcompte" type="text"  value="'.$nom.'" readonly="readonly"></p>';
		echo'<p> <label>prenom :</label><input name="prenomcompte" type="text"  value="'.$prenom.'" readonly="readonly"></p>';
		echo'<p> <label>nss :</label><input name="nsscompte" type="text"  value="'.$nss.'" readonly="readonly"></p>';
	    while($rawc=mysql_fetch_row($qc)){ 
	   $datec=$rawc[0];
	   $nssc=$rawc[1];
       $solde=$rawc[2];
	    echo'<p> <label>solde a la date:</label><input name="datecompte" type="text"  value="'.$datec.'" readonly="readonly"></p>';
		echo'<p> <label>solde du compte :</label><input name="soldecompte" type="text"  value="'.$solde.'" readonly="readonly"></p>';
		  }
		echo'<p> <input type="submit" name="debiter" id="debiter" value="effectuer un payement">';
		echo'<input type="submit" name="virementp" id="virementp" value="effectuer un virement"></p>';
	    echo'</fieldset>';
		}
  }
if(isset($_POST['debiter'])){
$nss=$_POST['nsscompte'];
$qc = mysql_query("select * from compteP where nssP= '$nss'")or die("ereur requete");
       if(mysql_num_rows($qc)==0){
       echo 'pas de patient avec le nss'.$nss.'';
       }else{
	   $rawc=mysql_fetch_row($qc);
	   $nssc=$rawc[1];
       $solde=$rawc[2];

			echo'entrer le montant du payement';
			echo'<p> <label>nss :</label><input name="nsscompt" type="text"  value="'.$nssc.'" readonly="readonly"></p>';
			echo'<p> <label>solde du compte :</label><input name="soldecompt" type="text"  value="'.$solde.'" readonly="readonly"></p>';
			echo'<p> <label>le montant d\'uen rim est de :</label><input name="prix" type="text"  value="800"  readonly="readonly"></p>';
			echo'<p> <input type="submit" name="enregistrerpayement" id="virementp" value="effectuer un virement">';
			echo'<input type="submit" name="annuledebit id="annuledebit" value="tout annuler"></p>';
			}
		}
			
if(isset($_POST['enregistrerpayement'])){
$nssco=$_POST['nsscompt'];
$solde=$_POST['soldecompt'];
$prix=$_POST['prix'];
$date=date('y-m-d H:i:s');
$res=(($solde)-($prix));
mysql_query("insert into compteP values('$date','$nssco','$res','$prix','0')")or die("ereur requete insertion");
$newc=mysql_query("select * from compteP where nssP= '$nssco'")or die("ereur requete selection"); 
      $rawss=mysql_fetch_row($newc);
       $soldee=$rawss[2];
			echo'entrer le montant du payement';
			echo'<p> <label>nouveau solde du compte :</label><input name="soldecompte" type="text"  value="'.$soldee.'" readonly="readonly"></p>';
			echo'<p> <input type="submit" name="enregistrerpayeme" id="virementp" value="effectuer un virement">';
			echo'<input type="submit" name="annuledebit id="annuledebit" value="tout annuler"></p>'; 
}			

if(isset($_POST['virementp']) || isset($_POST['enregistrerpayeme']) ){
			echo'entrer le montant que vous voulez ajouter a votre compte:';
			echo'<p> <label>solde du compte :</label><input name="soldecompte" type="text"  value="" readonly="readonly"></p>';
			echo'<p> <label>le montant que vous voulez ajouter a votre compte:</label><input name="soldeajouter" type="text"  value="" ></p>';
			echo'<p> <input type="submit" name="enregistreajout" id="enregistrerajout" value="effectuer un virement">';
			echo'<input type="submit" name="annuleajout" id="annuleajout" value="tout annuler"></p>';
			}
?>
</fieldset>
</form>

<?php		
	
if(isset($_POST['rdvp'])){
echo'<center><form name="afficheC" id="afficheC" method="post" action="agent.php" ><fieldset><legend>Planning</legend>';

echo'<h1>ici le planning</h1><fieldset>';

}

mysql_close();
?>

          <form name="ajoutC" id="ajoutC" method="post" action="agent.php" >
<?php
$db = mysql_connect('localhost','root');
mysql_select_db('Gestion_Clinique',$db);
if(isset($_POST['rechercheNSS'])){
		  echo'<p>entrer le nom et la date</p>
		  <p><label>Nom :</label><input name="nomP" type="text"  value="">
		   <p><label>date naissance :</label><input name="dateP" type="text"  value="">
		  <p> <input type="submit" name="rechercheNS" value="Chercher NSS"> </p>';
}
if(isset($_POST['rechercheNS'])){
   if(!empty($_POST['nomP']) && !empty($_POST['dateP'])){
   $nom=$_POST['nomP'];
   $date=$_POST['dateP'];
   $q = mysql_query("select * from patient where nomP='$nom' AND datenP = '$date'")or die("ereur requete");
    if(mysql_num_rows($q)==0){
    echo 'pas de NSS pour le patient'.$nom.' ne en :'.$date.'';
}else{
$raw=mysql_fetch_row($q);
		    echo'<p><label>NSS :</label><input name="nss" type="text"  value="'.$raw[8].'" readonly="readonly"></p>';
   }
}else{
echo ' champs nom ou date est vide !!!!!!';
}
}
mysql_close();
?>
</body>
</html>
