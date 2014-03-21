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
<script language="javascript">
function popup(a){
window.open(a.href,'synthese','height=500, width=500, top=100, left=100, toolbar=no, menubar=yes, location=no, resizable=yes, scrollbars=no, status=no');
}
</script>
</head>
<body>
<table name="menu" id="menu" width="1200px" height="543">
  <tr>
    <td height="23" colspan="4">&nbsp;</td>
    <td width="195"><?php echo $_SESSION['cat'] ; echo '  :  <a href="http://localhost/projet/index.php?action=logout " > Deconexion </a>';?></td>
  </tr>
  <tr>
    <td width="184" height="123">&nbsp;</td>
    <td colspan="5" class="banniere">&nbsp;</td>
  </tr>
  <form name="form1" id="form1" method="post" action="monplanning.php">
  <tr>
    <td height="23"></td>
    <td width="170" class="tabmenu"><input name="accueil" type="submit" class="boutton"  id="accueil" value="Accueil" /></td>
    <td width="170" class="tabmenu"><input name="medecin" type="submit" class="boutton"  id="medecin" value="Medecin" /></td>
    <td width="170" class="tabmenu"><input name="monplanning" type="submit" class="click " id="monplanning" value="Mon planning" /></td>
    <td width="195" class="tabmenu"><input name="autreplanning" type="submit" class="boutton"  id="autreplanning" value="Autres planning"/></td>
    <td width="170" class="tabmenu"></td>
    <td width="4"></td>
  </tr>
</form>
    <?php
	if(isset($_POST['accueil'])){
	//$login=$_GET['login'];
	$login=$_SESSION['cat'];
	header('Location: http://localhost/projet/Medecin/accueil.php?login='.$login.'&action=login'); 
	}
	if(isset($_POST['medecin'])){
	//$login=$_GET['login'];
	$login=$_SESSION['cat'];
	header('Location: http://localhost/projet/Medecin/medecin.php?login='.$login.'&action=login'); 
	}	
	if(isset($_POST['autreplanning'])){
	//$login=$_GET['login'];
	$login=$_SESSION['cat'];
	header('Location: http://localhost/projet/Medecin/autreplanning.php?login='.$login.'&action=login'); 
	}
		if(isset($_POST['monplanning'])){
	//$login=$_GET['login'];
	$login=$_SESSION['cat'];
	header('Location: http://localhost/projet/Medecin/monplanning.php?login='.$login.'&action=login'); 
	}
	?>
  <tr>
    <td height="192" ></td>
    <td colspan="6" rowspan="2" class="tabfond">
   <center>
<p><label>Page Medecin</label></p>

          <form name="form" id="form" method="post" action="monplanning.php">
		  <?php
          mysql_connect('localhost','root')or die('erreur de connexion au serveur');
          $connect=mysql_connect('localhost','root');
          mysql_select_db('gestionclinique',$connect)or die('erreur de connexion a la base de donnee');   
		 
		   		  echo'<fieldset><input name="journee" type="submit"  value="Planning journee"/><input name="semaine" type="submit"  value="planning semaine"></fieldset>';		   
		    //********************planning journee***********************//
if(isset($_POST['journee'])){
$login=$_SESSION['cat'];
$recupe=mysql_query("select * from medecin where log='$login'");
while($row=mysql_fetch_row($recupe)){
$spec=$row[8];
$nomM=$row[2];
}
$var=0;
echo'<input type="hidden" name="specialite" value="'.$spec.'"/><input type="hidden" name="nommedecin" value="'.$nomM.'"/>';
echo'Planning du medecin  '.$spec.' , '.$nomM.'';

if(isset($_GET['pagination'])){
$semaine=$_GET['pagination'];
$login=$_GET['loginM'];
}else{
$semaine=0;
if($var==0)
$login=$_SESSION['cat'];
else if($_POST['var']==1)
$login=$_GET['loginM'];
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
echo'<p></p><table class="sample" name="planning" id="planning" border="1" width="50%" >';
echo'<tr><th></th>';

$joursuivant=date('d-l');
$d=date('Y-m-d');
$l=date('l');
echo'<th>'.$joursuivant.'</th>';
$se[$l]=$d;
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
for($i=9;$i<=19;$i++){
echo'<tr><th>'.($i-1).' - '.$i.'</th>';
if(!empty(${$l}[($i-1).'-'.$i]) || !empty(${$l.'nss'}[($i-1).'-'.$i])){
if(${$l}[($i-1).'-'.$i]=="accomplir des taches administratives")
echo'<td bgcolor="#ffffff">'.${$l}[($i-1).'-'.$i].'</td>';
else
echo'<td bgcolor="#ffffff"><a href="http://localhost/projet/Medecin/synthese.php?nss='.${$l.'nss'}[($i-1).'-'.$i].'&login='.$_SESSION['cat'].'&action=login" class="caseh" onMouseover="popup(a)" >'.${$l}[($i-1).'-'.$i].'</a></td>';
}else{
echo'<td></td>';
}
echo'</tr>';
}
echo'</tabel>';

echo'<input type="submit" name="monplanning" value="Retour"/>';
}
		   
		   //********************planning semaine***********************//
if(isset($_POST['semaine'])){
$login=$_SESSION['cat'];
$recupe=mysql_query("select * from medecin where log='$login'");
while($row=mysql_fetch_row($recupe)){
$spec=$row[8];
$nomM=$row[2];
}
$var=0;
echo'<input type="hidden" name="specialite" value="'.$spec.'"/><input type="hidden" name="nommedecin" value="'.$nomM.'"/>';
echo'Planning du medecin  '.$spec.' , '.$nomM.'';

if(isset($_GET['pagination'])){
$semaine=$_GET['pagination'];
$login=$_GET['loginM'];
}else{
$semaine=0;
if($var==0)
$login=$_SESSION['cat'];
else if($_POST['var']==1)
$login=$_GET['loginM'];
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
echo'<p></p><table class="sample" name="planning" id="planning" border="1" width="100%" >';
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
}}
for($i=8;$i<19;$i++){
echo'<tr><th>'.$i.' - '.($i+1).'</th>';
if(!empty($Monday[$i.'-'.($i+1)]) || !empty($Mondaynss[$i.'-'.($i+1)])){
if($Mondaynss[$i.'-'.($i+1)]==0)
echo'<td bgcolor="#ffffff">'.$Monday[$i.'-'.($i+1)].'</td>';
else if(${$Monday}[($i-1).'-'.$i]=='accomplir des taches administratives')
echo'<td bgcolor="#ffffff">'.${$Monday}[($i-1).'-'.$i].'</td>';
else
echo'<td bgcolor="#ffffff"><a href="http://localhost/projet/Medecin/synthese.php?nss='.$Mondaynss[$i.'-'.($i+1)].'&login='.$_SESSION['cat'].'&action=login" class="caseh"  >'.$Monday[$i.'-'.($i+1)].'</a></td>';
}else
echo'<td></td>';
if(!empty($Tuesday[$i.'-'.($i+1)]) || !empty($Tuesdaynss[$i.'-'.($i+1)])){
if($Tuesdaynss[$i.'-'.($i+1)]==0)
echo'<td bgcolor="#ffffff">'.$Tuesday[$i.'-'.($i+1)].'</td>';
else if(${$Tuesday}[($i-1).'-'.$i]=='accomplir des taches administratives')
echo'<td bgcolor="#ffffff">'.${$Tuesday}[($i-1).'-'.$i].'</td>';
else
echo'<td bgcolor="#ffffff"><a href="http://localhost/projet/Medecin/synthese.php?nss='.$Tuesdaynss[$i.'-'.($i+1)].'&login='.$_SESSION['cat'].'&action=login" class="caseh">'.$Tuesday[$i.'-'.($i+1)].'</a></td>';
}else
echo'<td></td>';


if(!empty($Wednesday[$i.'-'.($i+1)]) || !empty($Wednesdaynss[$i.'-'.($i+1)])){
if($Wednesdaynss[$i.'-'.($i+1)]==0)
echo'<td bgcolor="#ffffff">'.$Wednesday[$i.'-'.($i+1)].'</td>';
else if(${$Wednesday}[($i-1).'-'.$i]=='accomplir des taches administratives')
echo'<td bgcolor="#ffffff">'.${$Wednesday}[($i-1).'-'.$i].'</td>';
else
echo'<td bgcolor="#ffffff"><a href="http://localhost/projet/Medecin/synthese.php?nss='.$Wednesdaynss[$i.'-'.($i+1)].'&login='.$_SESSION['cat'].'&action=login" class="caseh">'.$Wednesday[$i.'-'.($i+1)].'</a></td>';
}else
echo'<td></td>';


if(!empty($Thursday[$i.'-'.($i+1)]) || !empty($Thursdaynss[$i.'-'.($i+1)])){
if($Thursdaynss[$i.'-'.($i+1)]==0)
echo'<td bgcolor="#ffffff">'.$Thursday[$i.'-'.($i+1)].'</td>';
else if(${$Thursday}[($i-1).'-'.$i]=='accomplir des taches administratives')
echo'<td bgcolor="#ffffff">'.${$Thursday}[($i-1).'-'.$i].'</td>';
echo'<td bgcolor="#ffffff"><a href="http://localhost/projet/Medecin/synthese.php?nss='.$Thursdaynss[$i.'-'.($i+1)].'&login='.$_SESSION['cat'].'&action=login" class="caseh">'.$Thursday[$i.'-'.($i+1)].'</a></td>';
}else
echo'<td></td>';


if(!empty($Friday[$i.'-'.($i+1)]) || !empty($Fridaynss[$i.'-'.($i+1)])){
if($Fridaynss[$i.'-'.($i+1)]==0)
echo'<td bgcolor="#ffffff">'.$Friday[$i.'-'.($i+1)].'</td>';
else if(${$Friday}[($i-1).'-'.$i]=='accomplir des taches administratives')
echo'<td bgcolor="#ffffff">'.${$Friday}[($i-1).'-'.$i].'</td>';
else
echo'<td bgcolor="#ffffff"><a href="http://localhost/projet/Medecin/synthese.php?nss='.$Fridaynss[$i.'-'.($i+1)].'&login='.$_SESSION['cat'].'&action=login" class="caseh">'.$Friday[$i.'-'.($i+1)].'</a></td>';
}else
echo'<td></td>';
if(!empty($Saturday[$i.'-'.($i+1)]) || !empty($Saturdaynss[$i.'-'.($i+1)])){
if($Saturdaynss[$i.'-'.($i+1)]==0)
echo'<td bgcolor="#ffffff">'.$Saturday[$i.'-'.($i+1)].'</td>';
else if(${$Saturday}[($i-1).'-'.$i]=='accomplir des taches administratives')
echo'<td bgcolor="#ffffff">'.${$Saturday}[($i-1).'-'.$i].'</td>';
else
echo'<td bgcolor="#ffffff"><a href="http://localhost/projet/Medecin/synthese.php?nss='.$Saturdaynss[$i.'-'.($i+1)].'&login='.$_SESSION['cat'].'&action=login" class="caseh">'.$Saturday[$i.'-'.($i+1)].'</a></td>';
}else
echo'<td></td>';
if(!empty($Sunday[$i.'-'.($i+1)]) || !empty($Sundaynss[$i.'-'.($i+1)])){
if($Sundaynss[$i.'-'.($i+1)]==0)
echo'<td bgcolor="#ffffff">'.$Sunday[$i.'-'.($i+1)].'</td>';
else if(${$Sunday}[($i-1).'-'.$i]=='accomplir des taches administratives')
echo'<td bgcolor="#ffffff">'.${$Sunday}[($i-1).'-'.$i].'</td>';
else
echo'<td bgcolor="#ffffff"><a href="http://localhost/projet/Medecin/synthese.php?nss='.$Sundaynss[$i.'-'.($i+1)].'&login='.$_SESSION['cat'].'&action=login" class="caseh">'.$Sunday[$i.'-'.($i+1)].'</a></td></tr>';
}else
echo'<td></td></tr>';
}
echo'<input type="submit" name="monplanning" value="Retour"/>';
/*echo'<p></p><a href="medecin.php?pagination='.($semaine+1).'&loginM='.$login.'">suivant</a><label>     -     <label>';
if($semaine > 0){
$var=1;
echo'<a href="medecin.php?pagination='.($semaine-1).'&loginM='.$login.'">precedant</a>';}*/		  
}
mysql_close();	
?>

		  </form>
</center>  </td>
  </tr>
  <tr>
    <td>&nbsp;</td>
  </tr>
</table>
</body>
</html>
