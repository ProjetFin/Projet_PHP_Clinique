<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN"
        "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html lang="fr" xml:lang="fr" xmlns="http://www.w3.org/1999/xhtml">
  <head>
      <meta http-equiv="content-type" content="text/html; charset=utf-8" />
      <title>GESTION CLINIQUE</title>
      <meta name="description" lang="fr" content="contenu" />
      <meta name="keywords" lang="fr" content="cle" />
    <link rel="stylesheet" type="text/css" href="styleF.css"/>
	<title>Identification :Gestion Clinique</title>
	   <script type="text/javascript" src="inde.js"></script>
	   <script language="javascript">
function verif(){
if(document.form1.login.value==""){
alert('champs identifiant est vide');
document.form1.login.style.backgroundColor='red';
document.form1.login.focus()
}
if(document.form1.pass.value==""){
alert('champs mot de passe est vide');
document.form1.login.style.backgroundColor='red';
document.form1.pass.focus();
}
if((document.form1.pass.value!="") && (document.form1.login.value!="")){
<?php
session_start();
if(isset($_GET['action']) && ($_GET['action']=='logout')){
session_destroy();
exit();
}
$db = mysql_connect('localhost','root');
mysql_select_db('Gestion_Clinique',$db);
if(isset($_POST['Submit'])) {
$loginn=$_POST['login'];
$passe=$_POST['pass'];
$q = mysql_query("select categorie from identification where login= '$loginn' AND mdp= '$passe'")or die("ereur requete");
if(mysql_num_rows($q)==0){
echo '<form name="afficherC" id="afficherC"><fieldset><legend>Informations au utilisateurs</legend>Le pseudo'.$loginn.' est uconue ou a insere un mauvais mot de passe!!</fieldset><form>';
echo '<center><font face=verdana size=1 color=0066FF><u>mot de passe ou login incorecte</u></font></center>';
}else{
$raw=mysql_fetch_row($q);
if($raw[0]=='medecin'){
$_SESSION['cat']='medecin' ;
header('Location: http://localhost/Projet/medecin.php'); 
}
else if($raw[0]=='agent'){
$_SESSION['cat']='agent' ;
header('Location: http://localhost/Projet/agent.php'); 
}
else if($raw[0]=='directeur'){
$_SESSION['cat']='directeur' ;
header('Location: http://localhost/Projet/directeur.php'); 
}
  }
 }
mysql_close();
?>
} 
}
</script>
</head>

<body>
<center>
<p><label>Identification :</label></p>
          <form name="form1" id="form1" method="post" action="index.php" onSubmit="verif();">
            <p> <label>Identifiant :</label><input type="text" name="login" id="login" value=""></p> 
            <p> <label>Votre mot de passe :</label><input type="text" name="pass" id="pass" value=""></p>
            <p> <input type="submit" name="Submit" value="Valider" > </p>
          </form>

</center>
     

</body>
</html>
