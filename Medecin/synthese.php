<?php
session_start();
if(!isset($_SESSION['cat'])){
header('Location: http://localhost/projet/index.php'); 
session_destroy();
exit();
}
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN"
        "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html lang="fr" xml:lang="fr" xmlns="http://www.w3.org/1999/xhtml">
  <head>
      <meta http-equiv="content-type" content="text/html; charset=utf-8" />
      <meta name="description" lang="fr" content="contenu" />
      <meta name="keywords" lang="fr" content="cle" />
    <link rel="stylesheet" type="text/css" href="../style.css"/>
  </head>
<body>
<center>
<p><label>Page Medecin</label></p>

          <form name="form1" id="form1" method="post" action="synthese.php">
		  <fieldset>
		  <?php
		  echo'<input name="retour" type="submit" value="retour au planning"/>';
                echo'<h3><p>Information patient</p></h3>';		  
          mysql_connect('localhost','root')or die('erreur de connexion au serveur');
          $connect=mysql_connect('localhost','root');
          mysql_select_db('gestionclinique',$connect)or die('erreur de connexion a la base de donnee');
if(isset($_GET['nss']))		  
$nss=$_GET['nss'];
else
$nss=$_POST['nss'];

$selec=mysql_query("select * from synthese where nssP='$nss' order by dateC desc");
$select=mysql_query("select * from patient where nss='$nss'");
$selection=mysql_query("select * from synthese where nssP='$nss' order by dateC desc");
$planning=mysql_query("select * from planning where nssp='$nss' order by date desc");
 while($raw=mysql_fetch_row($select)){
$sexe=$raw[0];
$nom=$raw[1];
$prenom=$raw[2];
$daten=$raw[3];
$adresse=$raw[4];
$tel=$raw[5];
$mail=$raw[6];
$prof=$raw[7];
$situ=$raw[9];
		    echo'<p> <label>NSS :</label>'.$nss.'</p>
			<p> <label>sexe :</label>'.$sexe.'</p>
			<p> <label>Nom :</label>'.$nom.'</p>
            <p> <label>Prenom :</label>'.$prenom.'</p>
			<p> <label>date naissance :</label>'.$daten.'</p>
			<p> <label>Adresse :</label>'.$adresse.'</p>
            <p> <label>Num Tel :</label>0'.$tel.'</p>
            <p> <label>Mail :</label>'.$mail.'</p>
            <p> <label>Profetion :</label>'.$prof.'</p>
			<p><label>Situation familiale :</label>'.$situ.'</p>
		    <p></p>';
			echo'<input name="sexe" type="hidden"  value="'.$sexe.'" readonly="readonly">
<input name="nom" type="hidden"  value="'.$nom.'" readonly="readonly">
<input name="prenom" type="hidden" value="'.$prenom.'" readonly="readonly">
<input name="daten" type="hidden" value="'.$daten.'" readonly="readonly">
<input name="adresse" type="hidden"  value="'.$adresse.'">
<input name="numtel" type="hidden" value="0'.$tel.'">
<input name="mail" type="hidden"  value="'.$mail.'">
<input name="profession" type="hidden" value="'.$prof.'">
<input name="situf" type="hidden" value="'.$situ.'" readonly="readonly">
<input name="nss" type="hidden" value="'.$nss.'" readonly="readonly">';
 }
 if(mysql_num_rows($selec)==0){
 echo'<input type="hidden" name="pasdesynthese" value="true">';
 }else{
  echo'<input type="hidden" name="pasdesynthese" value="false">';
echo'<table class="sample" name="synthese" border="1"><tr><th>Nom Medecin consultant</th><th>Motif visite</th><th> Date </th><th> prix </th> <th> compte rendu </th><th> Suivi </th><th>prescription</th><th>explication</th>
</tr>';
 while($row=mysql_fetch_row($selection)){
$moti=$row[3];
}

$psj=mysql_query("select * from document where motifDoc='$moti'" )or die('erreur d\'execution de la requete insertion');
while($row=mysql_fetch_row($psj)){
$consigne=$row[1];
$pjointe=$row[2];
}
 while($row=mysql_fetch_row($selec)){
$nomM=$row[1];
$nssP=$row[2];
$motif=$row[3];
$datec=$row[4];
$prix=$row[5];
$rendu=$row[6];
$suivi=$row[7];
$prescription=$row[8];
$explication=$row[9];
			echo'<tr><td>  '.$nomM.' </td><td> '.$motif.' </td><td> '.$datec.' </td><td> '.$prix.' euro </td><td> '.$rendu.' </td><td> '.$suivi.' </td><td>'.$prescription.'</td><td>'.$explication.'</td></tr>';
}echo '</table></fieldset><fieldset>';
}
 while($raaw=mysql_fetch_row($planning)){
$nomM=$raaw[0];
$date=$raaw[2];
$hd=$raaw[3];
$motie=$raaw[5];
}
if($motie=="autre"){
$prixmotif=0;
$consignee="pas choisis";
$pjointee="carte identite et carte vitale";
}else{
$psjprix=mysql_query("select * from acte where motif='$motie'" )or die('erreur d\'execution de la requete insertion');
while($riw=mysql_fetch_row($psjprix)){
$prixmotif=$riw[1];
}
$psjpl=mysql_query("select * from document where motifDoc='$motie'" )or die('erreur d\'execution de la requete insertion');
while($rew=mysql_fetch_row($psjpl)){
$consignee=$rew[1];
$pjointee=$rew[2];
}
}
echo'<h3><p>Information Rendez-vous</p></h3>';	
echo'<p><label>date du rendez-vous  :</label>'.$date.'</p>';
echo'<input type="hidden" name="date" value="'.$date.'"/>';
echo'<p><label>heur du rendez vous   :</label>'.$hd.'h</p>';
echo'<p><label>Motif   :</label>'.$motie.'</p>';
echo'<input type="hidden" name="motif" value="'.$motie.'"/>';
echo'<p><label>Prix   :</label>'.$prixmotif.'euro</p>';
echo'<input type="hidden" name="prixmotif" value="'.$prixmotif.'"/>';
echo'<p><label>Consigne   :</label>'.$consignee.'</p>';
echo'<input type="hidden" name="cs" value="'.$consignee.'"/>';
echo'<p><label>piece a journir   :</label>'.$pjointee.'</p><p></p>';
echo'<input type="hidden" name="pj" value="'.$pjointee.'"/>';

$datesynthese=$date.' '.$hd.'-00-00';
$synthese=mysql_query("select * from synthese where nssP='$nss' and dateC='$datesynthese'");
if(mysql_num_rows($synthese)!=0){
echo'Consultation deja effectuer';
}else{
echo'<input name="consultation" type="submit" value="Effectuer consultation"/></fieldset>';
}

if(isset($_POST['retour'])){
$login=$_SESSION['cat'];
header('Location: http://localhost/projet/Medecin/monplanning.php?login='.$login.'&action=login'); 
}

if(isset($_POST['consultation'])){
echo'<fieldset>';
$motif=$_POST['motif'];
$prixmotif1=$_POST['prixmotif'];
$pj=$_POST['pj'];
$cs=$_POST['cs'];
echo'
<p><label>prescription  :</label></p><p><textarea name="prescription" id="prescrition" rows="3" cols="50" value="blablaaaaaaaaaaaaa"/></textarea></p>';
echo'<p><label>Conte rendu  :</label></p><p><textarea name="conterendu" id="conterendu" rows="3" cols="50"/></textarea></p>
<p><label>Suivi  :</label></p><p><textarea name="suivi" id="suivi" rows="3" cols="50"/></textarea></p>';
echo'<p><label>explication :</label></p><p><textarea name="explication" id="explication" rows="3" cols="50"/></textarea></p>';
echo'<input type="hidden" name="prixmotif1" value="'.$prixmotif1.'"/>';
echo'</select></p><p><label>Motif rendez-vous</label><select name="motifrdv" id="motifrdv">';
echo'<option value=""></option>';
$motiff=mysql_query("select * from acte");
while($raw=mysql_fetch_row($motiff)){
echo'<option value="'.$raw[0].'">'.$raw[0].'</option>';
}

echo'<input name="confirmation" type="submit" value="Fin consultation"/>';
echo'</fieldset>';
}


if(isset($_POST['confirmation'])){
echo'<fieldset>';
$prescription=$_POST['prescription'];
$rendu=$_POST['conterendu'];
$suivi=$_POST['suivi'];
if(!empty($_POST['explication']) && !empty($_POST['motifrdv'])){
$newmotif=$_POST['motifrdv'];
$prix=mysql_query("select * from acte where motif='$newmotif'" )or die('erreur d\'execution de la requete insertion');
while($riw=mysql_fetch_row($prix)){
$prixx=$riw[1];
}
$psjpl=mysql_query("select * from document where motifDoc='$motie'" )or die('erreur d\'execution de la requete insertion');
while($rew=mysql_fetch_row($psjpl)){
$consigne=$rew[1];
$pjointee=$rew[2];
}
}else{
$prixx=$_POST['prixmotif1'];
$newmotif=$_POST['motif'];
}

$explication=$_POST['explication'];

$nss=$_POST['nss'];
mysql_query("insert into synthese values('','$nomM','$nss','$newmotif','$datesynthese','$prixx','$rendu','$suivi','$prescription','$explication')")or die(mysql_error());
echo '<p></p>bravo !<p></p>';
echo'</fieldset>';
}

mysql_close();	
?>
</form>
</center>
</body>
</html>
