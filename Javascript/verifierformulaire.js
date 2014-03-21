//une fonction pour les erreurs
function erreur(f, nom){
	f.elements[nom].style.backgroundColor="red";
	f.elements[nom].focus();
	return false;	
}

//une fonction qui affiche en fonction des champs utilisé
function message(nom){
	if (nom == "login")
		alert("Veuillez indiquer un Login");
	if (nom == "prenom")
		alert("Veuillez indiquer un Prénom");
	if (nom == "nom")
		alert ("Veuillez indiquer un Nom");
	if (nom == "dateNaiss")
		alert ("Veuillez indiquer une Date de Naissance");
	if (nom == "mail")
		alert ("Veuillez indiquer un E-mail");
	if (nom == "nss")
		alert ("Veuillez indiquer un numéro de sécurité social");
	if (nom == "profession")
		alert ("Veuillez indiquer la Profession");
	if (nom == "tel")
		alert ("Veuillez indiquer un numéro de téléphone");
	if (nom == "adresse")
		alert ("Veuillez indiquer une adresse");
	if(nom == "mdp")
		alert ("Veuillez indiquer un mot de passe d'au moins 8 caractères");
		
}

/*--------------------------------------------------------------------------------------------------------------------------------------------------------*/

//la fonction qui verifie pour un numero de telephone
function verifTel(f, nom){
	var num = f.elements[nom].value;
	
	if (num.charAt(0) == '0' && num.length >= 10){
		return true;
	}else{
		alert('Veuillez saisir un numero de telephone correcte');
		return erreur(f, nom);
	}
}

/*--------------------------------------------------------------------------------------------------------------------------------------------------------*/

//la fonction qui verifie pour un mail 
function verifMail(f,nom){
	var mail = f.elements[nom].value;
	var arobaz = false; // on suppose avant le test qu'il n y a pas de '@'
	var point = false; // on suppose avant le test qu'on a pas de '.'
	var c = 0;
	
	for(i=0 ; i < mail.length ; i ++){

		if(mail.charAt(i) == "@" && i!=0){
			c=i;
			arobaz = true;
		}
		if(mail.charAt(i) == '.' && i > c && i < mail.length-1){	
			point = true;
		}
	}
	if(point==true && arobaz==true){
		return true;	
	}
	else{
		alert("Veuillez saisir une adresse mail valide");
		return erreur(f,nom);
	}
}

/*--------------------------------------------------------------------------------------------------------------------------------------------------------*/


//la fonction qui verifie l'adresse
function verifAdresse(f, nom){
	var adresse = f.elements[nom].value;
	if(adresse.length < 10){
		alert('Veuillez saisir une adresse valide');
		return erreur(f, nom);
	}
	return true;
}


/*--------------------------------------------------------------------------------------------------------------------------------------------------------*/

//pour vérifier si l'année est bissextile ou non 
Number.prototype.isBissextile=function(){
	return (new Date(this,2,0).getDate()>=29 );
}

//la fonction qui verifie la date de naissance 
function verifDateNaiss(f){
	
	var annee = f.elements['annee'].value;
	var mois = f.elements['mois'].value;
	var jour = f.elements['jour'].value;	
	
	if (mois.charAt(0) == "0")
		mois = mois.charAt(1);
	if (jour.charAt(0) == "0")
		jour = jour.charAt(1);
		
	annee = parseInt(annee);
	mois = parseInt(mois);
	jour = parseInt(jour);
	

	
	if(mois == 4 || mois == 6 || mois == 9 || mois == 11){
		if(jour > 30){
			alert('Veuillez sélectionner une date valide');
				return false;	
		}	
	}
		
	if(mois == 2){
		if(annee.isBissextile()){
			if(jour > 29){
				alert('Année Bissextile, Veuillez Sélectionner une date valide');
				return false;
			}
		}else {
			if(jour > 28){
				alert('Veuillez sélectionner une date valide');
				return false;
			}
		}
	}
	return true;
}



/*--------------------------------------------------------------------------------------------------------------------------------------------------------*/


//la fonction qui verifie pour les mots de passes en cas de creation de compte
function verifMdp(f, nom, nom2){
	var pass = f.elements[nom].value;
	var conf = f.elements[nom2].value;
	
	if(pass.length < 8){
		alert ('Veuillez saisir un mot de passe valide d\'au moins 8 caractères');
		return erreur(f,nom);
	}
	if(pass != conf){
		alert ('Votre mot de passe de confirmation ne correspond pas au mot de passe initial');
		return erreur (f,nom);
	}
	return true;
}

/*--------------------------------------------------------------------------------------------------------------------------------------------------------*/

//la fonction qui vérifie le numéro de sécurité social
function verifNSS(f, nom){
	var nss = f.elements[nom].value;
	
	if(isNaN(nss)){
		alert('Veuillez saisir des données valides (Chiffres)');
		return erreur(f,nom);	
	}else{
		if(nss.length < 15){
			alert('Numéro de sécurité sociale trop court. \n Veuillez indiquer un numéro de sécurité sociale valide.');
			return erreur(f,nom);
		}
		else if(nss.charAt(0) != '1' && nss.charAt(0) != '2'){
			alert('Numéro de sécurité sociale invalide');
			return erreur(f,nom);	
		}
	}
	return true;
	
	
}

/*--------------------------------------------------------------------------------------------------------------------------------------------------------*/
//la fonction qui vérifie pour champ somme (chiffre)
function verifSomme (f, nom){
    var valeur = f.elements[nom].value;
    if(isNaN (valeur)){
        alert ('Veuillez saisir un Chiffre');
        return erreur(f,nom);
    }else{
        valeur = parseInt(valeur);
        if(valeur < 0){
            alert ('Veuillez saisir un nombre strictement positif');
            return erreur(f,nom);
        }
    }
    return true;
}


/*--------------------------------------------------------------------------------------------------------------------------------------------------------*/


//la fonction global qui nous permettera de vérifier si un formulaire est bien rempli ou non 
/*ici on va rejouter un argument modele qui va nous permettre de savoir si la verification s'effectue pour 
 formulaire de creation de compte ou pour une connexion normal*/
function verification(f, model){
		var deroulante = false;
		var verif = true;
	// nous servira pour la verification d'un radio 
		var rad = false;
	//on va parcourir tout le formulaire 
		var n = f.elements.length;
		for (i = 0 ; i < n ; i++){
			var nom = f.elements[i].name;
			var T = f.elements[i].type;
			var valeur = f.elements[i].value;
			
			//verification des types select
			if(T == "select-one" && deroulante == false){
				verif = verifDateNaiss(f);
				if(verif == false)
					return verif;
				else
					deroulante = true;
			}
			
			//verification des types password 
			if(T == "password" && nom =="mdp"){
				if (f.elements[i].value==""){
					message(nom);
					return false;
				}
				else if(model == true){
					verif = verifMdp(f,nom,"confirmMdp");
					if(verif == false)
						return verif;
					else
						f.elements[i].style.backgroundColor="white";
				}
					
			}
			
			//si c'est un champ input text on vérifie la saisie
			if(T == "text"){
				// si le champ est vide on affiche une alert et on retourne faux
				if(valeur==""){
					message(nom); // on affiche un message specifique au champ vide 		
					return erreur(f, nom);
				
				}else if(nom != 'tel' && nom != "somme" && nom != "nss" && !isNaN(valeur)){
					alert ('Veuillez saisir des données valide');
					return erreur(f, nom);
					
				}else{
                    if(nom == "somme"){
                        verif = verifSomme(f,nom);
                        if(verif == false)
                            return verif;
                    }
					else if(nom == "tel"){
						verif = verifTel(f,nom);
						if (verif == false)
							return verif;
					}
					else if(nom == "mail"){
						verif = verifMail(f,nom);
						if(verif == false)
							return verif;		
					}	
					else if(nom == "adresse"){
						verif = verifAdresse(f,nom);
						if(verif == false)
							return verif;	
					}
					else if(nom == "nss"){
						verif = verifNSS(f, nom);
						if (verif == false)
							return verif;	
					}
				}
				// pour ne pas laisser le background rouge apres la correction du champ
				f.elements[i].style.backgroundColor="white";			
			}
			
			// verification des types radio
			if(T == "radio" && rad == false){
				for(j = i ; j < n ; j++){
					var titype = f.elements[j].type;
					var ninom = f.elements[j].name;
					var nichecked = f.elements[j].checked;
					if(titype == "radio" && ninom == nom && nichecked )
						rad = true ;	
				}
				if(rad == false){
					alert("Veuillez sélectionner un des choix précisés");
					return false;	
				}
			}
			
		}//fin de la boucle for du formulaire
		return verif;
}


function Confirmmodification(){
if(confirm("Voulez-vous vraiment modifier les informations du patient ?")){
return true;
}else{
retun false;
alert("infomrations modifier avec succes (^_^) !!");
}

}
/*--------------------------------------------------------------------------------------------------------------------------------------------------------*/
