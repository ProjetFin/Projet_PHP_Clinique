<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Untitled Document</title>
</head>
<body>
<form name="afecterdv" id="afecterd" action="planning.php" method="post">
<?php
mysql_connect('localhost','root')or die('erreur de connexion au serveur');
$connect=mysql_connect('localhost','root');
mysql_select_db('gestionclinique',$connect)or die('erreur de connexion a la base de donnee');

if(isset($_GET['loginM']))
$login=$_GET['loginM'];
else
$login=$_POST['login'];

$recupe=mysql_query("select * from medecin where log='$login'");
while($row=mysql_fetch_row($recupe)){
$nomM=$row[2];
$spec=$row[8];
$login=$row[9];
}
echo'<input type="hidden" name="specialite" value="'.$spec.'"/><input type="hidden" name="nommedecin" value="'.$nomM.'"/>';
echo'Planning du medecin  '.$spec.' , '.$nomM.'';
echo'<input type="hidden" name="login" value="'.$login.'"/>';

if(isset($_POST['afficheplaninng'])|| isset($_GET['pagination'])){
$semaine=$_GET['pagination'];
$login=$_GET['loginM'];
}else{
$semaine=0;
if(isset($_GET['loginM']))
$login=$_GET['loginM'];
else
$login=$_POST['login'];
}

if($semaine==0){
$recupe=mysql_query("select * from planning where loginM='$login'");
while($row=mysql_fetch_row($recupe)){

$nomM=$row[0];
}
}

$joursemaine=date('w');
$limite=7*$semaine;
$date=date('Y-m-d');

$sem=date('d-m-Y', mktime(0, 0, 0, date('m'),date('d')-$joursemaine+1+$limite, date('Y')));
echo'<input type="hidden" name="specialite" value="'.$spec.'"/><input type="hidden" name="nommedecin" value="'.$nomM.'"/>';
echo'<h2>Planning du medecin  '.$nomM.'  specialiser en '.$spec.' a la semaine du<p> '.$sem.'</p></h2>';

$se = Array(); 
echo'<p></p><table name="planning" id="planning" border="1" width="100%" >';
echo'<tr><th></th>';
for($i=1;$i<=7;$i++){
$joursuivant=date('d-l', mktime(0, 0, 0, date('m'),date('d')-$joursemaine+$i+$limite, date('Y')));
$d=date('Y-m-d', mktime(0, 0, 0, date('m'),date('d')-$joursemaine+$i+$limite, date('Y')));
$l=date('l', mktime(0, 0, 0, date('m'),date('d')-$joursemaine+$i+$limite, date('Y')));
echo'<th>'.$joursuivant.'</th>';
$se[$l]=$d;
}
echo'</tr>';

$Monday = array(); $Tuesday= array(); $Wednesday= array();	 $Thursday= array();	 $Friday= array(); $Saturday= array();	 $Sunday= array();
$Mondaynss = array();$Tuesdaynss = array();$Wednedaynss = array(); $Thursdaynss = array();$Fridaynss = array();$Saturdaynss = array();$Sundaynss = array();
foreach($se as $l => $d){
$recuperer=mysql_query("select * from planning where date='$d' AND loginM='$login'");
mysql_num_rows($recuperer);
while($row=mysql_fetch_row($recuperer)){
$hdebu=$row[3];
$hfin=$row[4];
$titre=$row[5];
$nss=$row[7];
$vardate=$hdebu.'-'.$hfin;
${$l}[$vardate]=$titre;
${$l.'nss'}[$vardate]=$nss;
}
}

for($i=8;$i<19;$i++){
echo'<tr>';
echo'<th>'.$i.' - '.($i+1).'</th>';
if(!empty($Monday[$i.'-'.($i+1)]) || !empty($Mondaynss[$i.'-'.($i+1)]))
echo'<td bgcolor="#dfffdd">'.$Monday[$i.'-'.($i+1)].''.$Mondaynss[$i.'-'.($i+1)].'</td>';
else
echo'<td></td>';
if(!empty($Tuesday[$i.'-'.($i+1)]) || !empty($Tuesdaynss[$i.'-'.($i+1)]))
echo'<td bgcolor="#dfffdd">'.$Tuesday[$i.'-'.($i+1)].'</td>';
else
echo'<td></td>';
if(!empty($Wednesday[$i.'-'.($i+1)]) || !empty($Wednesdaynss[$i.'-'.($i+1)]))
echo'<td bgcolor="#dfffdd">'.$Wednesday[$i.'-'.($i+1)].'</td>';
else
echo'<td></td>';
if(!empty($Thursday[$i.'-'.($i+1)]) || !empty($Thursdaynss[$i.'-'.($i+1)]))
echo'<td bgcolor="#dfffdd">'.$Thursday[$i.'-'.($i+1)].'.'.$Thursdaynss[$i.'-'.($i+1)].'</td>';
else
echo'<td></td>';
if(!empty($Friday[$i.'-'.($i+1)]) || !empty($Fridaynss[$i.'-'.($i+1)]))
echo'<td bgcolor="#dfffdd">'.$Friday[$i.'-'.($i+1)].'</td>';
else
echo'<td></td>';
if(!empty($Saturday[$i.'-'.($i+1)]) || !empty($Saturdaynss[$i.'-'.($i+1)]))
echo'<td bgcolor="#dfffdd">'.$Saturday[$i.'-'.($i+1)].'</td>';
else
echo'<td></td>';
if(!empty($Sunday[$i.'-'.($i+1)]) || !empty($Sundaynss[$i.'-'.($i+1)]))
echo'<td bgcolor="#dfffdd">'.$Sunday[$i.'-'.($i+1)].'</td>';
else
echo'<td></td></tr>';
}
?>
<?php	      		  
		    echo'<p><label>date du rendez vous :</label>          
		   <select name="jour" id="jour"><option value="">Jour</option>';
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
		for($i=date('Y');$i<=2030;$i++){	
		echo'<option value="'.$i.'">'.$i.'</option>';
}
echo'</select></p>';
echo'<p><label>nss Patient</label><input type="text" name="nss" value=""/></p>';
echo'<p><label>heur du rendez-vous</label><select name="heur">';
for($i=8;$i<=19;$i++){
echo'<option value="'.$i.'">'.$i.'h</option>';
}
echo'</select></p><p><label>Motif rendez-vous</label><select name="motifrdv" id="motifrdv">';
$motif=mysql_query("select * from acte");
while($raw=mysql_fetch_row($motif)){
echo'<option value="'.$raw[0].'">'.$raw[0].'</option>';
}echo'<option value="autre">autre</option></select></p><p>';
echo'<input type="hidden" name="login" value="'.$login.'" />';
echo'<input type="submit" name="affecterdv" value="affectation rdv"/></p>';
echo'<p></p><a href="planning.php?pagination='.($semaine+1).'&loginM='.$login.'">suivant</a><label>     -     <label>';
if($semaine > 0){
$var=1;
echo'<a href="planning.php?pagination='.($semaine-1).'&loginM='.$login.'">precedant</a>';}
//--------------------------------------------------------------
if(isset($_POST['affecterdv'])){

if(isset($_GET['pagination'])){
$login=$_GET['loginM'];
}else{
if(isset($_GET['loginM']))
$login=$_GET['loginM'];
else
$login=$_POST['login'];
}
$aujourdhui=date('d');
$cemois=date('m');
$cetteannee=date('Y');
$nomM=$_POST['nommedecin'];
$nss=$_POST['nss'];
$hd=$_POST['heur'];
$hf=$hd+1;
$titre=$_POST['motifrdv'];
$jour=$_POST['jour'];
$mois=$_POST['mois'];
$annee=$_POST['annee'];
$date=$annee."-".$mois."-".$jour;
if($cetteannee > $annee){
echo 'l\'annee que vous avez choisis est ancinne choisissez une date plus recente ';
}else{ 
     if( $cemois > $mois){
     echo 'le mois que vous avez choisis est ancinne choisissez une date plus recente ';
    }else{
	echo $cetteannee;
          if($aujourdhui > $jour){ 
          echo 'le jours que vous avez choisis est ancinne choisissez une date plus recente ';
          }else{
$rech1=mysql_query("select * from patient where nss='$nss'");
$rech2=mysql_query("select * from planning where nssp='$nss' and date='$date' and hdeb='$hd'");
if(mysql_num_rows($rech1)==0){
echo'pas de patient avec le nss '.$nss.'
<label>ajouter patient : </label><input type="submit" name="ajoutp" value="ajouter patient"/>';
}else{
if(mysql_num_rows($rech2)==0){
$query="insert into planning values('$nomM','','$date','$hd','$hf','$titre','$login','$nss')";  
mysql_query($query)or die(mysql_error());
echo'<h3>le patient avec le nss '.$nss.' a pris un rendez-vous pour le '.$date.'  de '.$hd.'h a '.$hf.'h pour une '.$titre.' avec le medecin '.$nomM.'</h3>';

if($titre=="autre"){
echo '<h3><p><label>les consigne:</label></p>pas definie pour autre';
echo '<p><label>les piece a founir :</label></p>carte identite et carte vitale</h3>';
}else{ 
$psj=mysql_query("select * from document where motifDoc='$titre'" )or die('erreur d\'execution de la requete insertion');
while($row=mysql_fetch_row($psj)){
$consigne=$row[1];
$pjointe=$row[2];
}
echo '<h3><p><label>les consigne:</label></p>'.$consigne.'';
echo '<p><label>les piece a founir :</label></p>'.$pjointe.'</h3>';
}
}else{
echo'veuiller choisisr un autre creneaux horraires pour le rendez-vous ! le '.$nomM.' a deja un rendez-vous le'.$date.' a '.$hd.'h';
}
}
}
}
}
}
mysql_close();

?>
</form>
</body>
</html>
