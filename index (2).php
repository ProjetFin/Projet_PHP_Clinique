<?php
session_start();
if(isset($_GET['action']) && ($_GET['action']=='logout')){
session_destroy();
}
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN"
        "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html lang="fr" xml:lang="fr" xmlns="http://www.w3.org/1999/xhtml">
  <head>
      <meta http-equiv="content-type" content="text/html; charset=utf-8" />
      <title>GESTION CLINIQUE</title>
      <meta name="description" lang="fr" content="contenu" />
      <meta name="keywords" lang="fr" content="cle" />
 
	<title>Identification :Gestion Clinique</title>
       <link rel="stylesheet" type="text/css" href="style.css"/>
	   <script type="text/javascript" src="javascript/verifierformulaire.js"></script>
</head>

<body>
<center>
          <form name="authentification" id="authentification" method="post" action="index.php" >
		  <fieldset><legend>Authentification</legend>
            <p> <label>Identifiant  :</label><input type="text" name="login" id="login" value="" /></p> 
            <p> <label>Votre mot de passe :</label><input type="text" name="mdp" id="mdp" value="" /></p>
            <p> <input type="submit" name="Submit" value="Valider" > </p>
			</fieldset>
          </form>
</center>
     
<?php
$db = mysql_connect('localhost','root');
mysql_select_db('gestionclinique',$db);
if(isset($_POST['Submit'])) {
$login=$_POST['login'];
$passe=$_POST['mdp'];
$q = mysql_query("select categorie from identification where login= '$login' AND mdp= '$passe'")or die("ereur requete");
if(mysql_num_rows($q)==0){
echo '<form name="afficherC" id="afficherC"><fieldset><legend>Informations au utilisateurs</legend>Le pseudo'.$loginn.' est uconue ou a insere un mauvais mot de passe!!</fieldset><form>';
echo '<center><font face=verdana size=1 color=0066FF><u>mot de passe ou login incorecte</u></font></center>';
}else{
$raw=mysql_fetch_row($q);
if($raw[0]=='medecin'){
$_SESSION['cat']=$login ;
header('Location: http://localhost/Projet/Medecin/accueil.php?login='.$login.'&action=login'); 
}
else if($raw[0]=='agent'){
$_SESSION['cat']=$login ;
header('Location: http://localhost/projet/Agent/accueil.php?login='.$login.'&action=login'); 
}
else if($raw[0]=='directeur'){
$_SESSION['cat']=$login ;
header('Location: http://localhost/Projet/Directeur/directeur.php?login='.$login.'&action=login'); 
    }
  }
 }
mysql_close();
?>
</body>
</html>
