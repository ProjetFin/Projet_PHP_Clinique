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
   <form name="form1" id="form1" method="post" action="autreplanning.php">
  <tr>
      <td height="23">&nbsp;</td>
    <td width="170" class="tabmenu"><input name="accueil" type="submit" class="boutton"  id="accueil" value="Accueil" /></td>
    <td width="170" class="tabmenu"><input name="medecin" type="submit" class="boutton"  id="medecin" value="Medecin" /></td>
    <td width="170" class="tabmenu"><input name="monplanning" type="submit" class="boutton" id="monplanning" value="Mon planning" /></td>
    <td width="195" class="tabmenu"><input name="autreplanning" type="submit" class="click "  id="autreplanning" value="Autres planning"></td>
    <td width="170" class="tabmenu"></td>
    <td width="4">&nbsp;</td>
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
          <form name="form1" id="form1" method="post" action="autreplanning.php">
		  <?php
          mysql_connect('localhost','root')or die('erreur de connexion au serveur');
          $connect=mysql_connect('localhost','root');
          mysql_select_db('gestionclinique',$connect)or die('erreur de connexion a la base de donnee');   

			      echo'<fieldset><p><label>choix du medecin</label><select name="medecin1">';
				  $recup=mysql_query("select * from medecin");
				  while($row=mysql_fetch_row($recup)){
				  $nomM=$row[2];
				  $loginM=$row[9];
				  if($loginM==$_SESSION['cat'])
				  echo'';
				  else
				  echo'<option value="'.$loginM.'">'.$nomM.'</option>';
				  }
		   		  echo'</select></p><input name="journeemed" type="submit"  value="Planning journee"/><input name="semainemed" type="submit"  value="planning semaine"></fieldset>';
			   //********************planning journee par medecin***********************//
if(isset($_POST['journeemed'])){
$loginn=$_POST['medecin1'];
$recupe=mysql_query("select * from medecin where log='$loginn'");
while($row=mysql_fetch_row($recupe)){
$spec=$row[8];
$nomM=$row[2];
}
echo'<input type="hidden" name="specialite" value="'.$spec.'"/><input type="hidden" name="nommedecin" value="'.$nomM.'"/>';
echo'Planning du medecin  '.$spec.' , '.$nomM.'';

$recupe=mysql_query("select * from planning where loginM='$loginn'");
while($row=mysql_fetch_row($recupe)){
$nomM=$row[0];
}

$joursemaine=date('w');
$limite=0;
$date=date('Y-m-d');

$sem=date('d-m-Y', mktime(0, 0, 0, date('m'),date('d')-$joursemaine+1+$limite, date('Y')));
echo'<input type="hidden" name="specialite" value="'.$spec.'"/><input type="hidden" name="nommedecin" value="'.$nomM.'"/>';
echo'<h2>Planning du medecin  '.$nomM.'  specialiser en '.$spec.' a la semaine du<p> '.$sem.'</p></h2>';

$se = Array(); 
echo'<p></p><table name="planning" id="planning" border="1" width="100%" >';
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
$recuperer=mysql_query("select * from planning where date='$d' AND loginM='$loginn'");
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
echo'<tr><th>'.$i.' - '.($i+1).'</th>';
if(!empty(${$l}[$i.'-'.($i+1)]) || !empty(${$l.'nss'}[$i.'-'.($i+1)]))
echo'<td bgcolor="#ffffff">'.${$l}[$i.'-'.($i+1)].''.${$l.'nss'}[$i.'-'.($i+1)].'</td></tr>';
else
echo'<td></td></tr>';

         }
        echo'<input type="submit" name="monplanning" value="Retour"/>';
    }
			//********************************************************************//
			 
			 
			//********************planning semaine par medecin***********************//
			  
			  if(isset($_POST['semainemed'])){
$loginn=$_POST['medecin1'];
$recupe=mysql_query("select * from medecin where log='$loginn'");
while($row=mysql_fetch_row($recupe)){
$spec=$row[8];
$nomM=$row[2];
}
$var=0;
echo'<input type="hidden" name="specialite" value="'.$spec.'"/><input type="hidden" name="nommedecin" value="'.$nomM.'"/>';
echo'Planning du medecin  '.$spec.' , '.$nomM.'';

if(isset($_GET['pagination'])){
$semaine=$_GET['pagination'];
//$login=$_GET['loginM'];
}else{
$semaine=0;
if($var==0)
$login=$_POST['medecin1'];
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
echo'<tr><th>'.$i.' - '.($i+1).'</th>';
if(!empty($Monday[$i.'-'.($i+1)]) || !empty($Mondaynss[$i.'-'.($i+1)]))
echo'<td bgcolor="#ffffff">'.$Monday[$i.'-'.($i+1)].''.$Mondaynss[$i.'-'.($i+1)].'</td>';
else
echo'<td></td>';
if(!empty($Tuesday[$i.'-'.($i+1)]) || !empty($Tuesdaynss[$i.'-'.($i+1)]))
echo'<td bgcolor="#ffffff">'.$Tuesday[$i.'-'.($i+1)].'</td>';
else
echo'<td></td>';
if(!empty($Wednesday[$i.'-'.($i+1)]) || !empty($Wednesdaynss[$i.'-'.($i+1)]))
echo'<td bgcolor="#ffffff">'.$Wednesday[$i.'-'.($i+1)].'</td>';
else
echo'<td></td>';
if(!empty($Thursday[$i.'-'.($i+1)]) || !empty($Thursdaynss[$i.'-'.($i+1)]))
echo'<td bgcolor="#ffffff">'.$Thursday[$i.'-'.($i+1)].'.'.$Thursdaynss[$i.'-'.($i+1)].'</td>';
else
echo'<td></td>';
if(!empty($Friday[$i.'-'.($i+1)]) || !empty($Fridaynss[$i.'-'.($i+1)]))
echo'<td bgcolor="#ffffff">'.$Friday[$i.'-'.($i+1)].'</td>';
else
echo'<td></td>';
if(!empty($Saturday[$i.'-'.($i+1)]) || !empty($Saturdaynss[$i.'-'.($i+1)]))
echo'<td bgcolor="#ffffff">'.$Saturday[$i.'-'.($i+1)].'</td>';
else
echo'<td></td>';
if(!empty($Sunday[$i.'-'.($i+1)]) || !empty($Sundaynss[$i.'-'.($i+1)]))
echo'<td bgcolor="#ffffff">'.$Sunday[$i.'-'.($i+1)].'</td></tr>';
else
echo'<td></td></tr>';
}
echo'<input type="submit" name="monplanning" value="Retour"/>';
/*echo'<p></p><a href="medecin.php?pagination='.($semaine+1).'&loginM='.$login.'">suivant</a><label>     -     <label>';
if($semaine > 0){
$var=1;
echo'<a href="medecin.php?pagination='.($semaine-1).'&loginM='.$login.'">precedant</a>';}*/		  
}
			  
		    //******************************************************************//
		   
mysql_close();	
?>

		  </form>
</center></td>
  </tr>
  <tr>
    <td>&nbsp;</td>
  </tr>
</table>
</body>
</html>
