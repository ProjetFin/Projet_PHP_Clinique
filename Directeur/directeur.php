<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN"
        "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html lang="fr" xml:lang="fr" xmlns="http://www.w3.org/1999/xhtml">
  <head>
      <meta http-equiv="content-type" content="text/html; charset=utf-8" />
      <title>GESTION CLINIQUE</title>
      <meta name="description" lang="fr" content="contenu" />
      <meta name="keywords" lang="fr" content="cle" />
    <link rel="stylesheet" type="text/css" href="styleF.css"/>
  </head>
<?php
session_start();
echo '<title> Identification :'.$_SESSION['cat'].' </title>';
?>
</head>

<body>

<center>
<p><label>Page Directeur</label></p>
          <form name="form1" id="form1" method="post" action="directeur.php">
            <p> <label></label><input name="login" type="text"  value=""></p>
            <p> <label></label><input name="pass" type="text" value=""></p>
            <p> <input type="submit" name="Submit" value="Valider"> </p>
          </form>
         

</center>
     

</body>
</html>
