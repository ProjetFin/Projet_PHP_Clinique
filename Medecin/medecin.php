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
     <form name="form1" id="form1" method="post" action="medecin.php">
    <td height="23">&nbsp;</td>
    <td width="170" class="tabmenu"><input name="accueil" type="submit" class="boutton"  id="accueil" value="Accueil" /></td>
    <td width="170" class="tabmenu"><input name="medecin" type="submit" class="click "  id="medecin" value="Medecin" /></td>
    <td width="170" class="tabmenu"><input name="monplanning" type="submit" class="boutton" id="monplanning" value="Mon planning" /></td>
    <td width="195" class="tabmenu"><input name="autreplanning" type="submit" class="boutton"  id="autreplanning" value="Autres planning"></td>
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

</center></td>
  </tr>
  <tr>
    <td>&nbsp;</td>
  </tr>
</table>
</body>
</html>
