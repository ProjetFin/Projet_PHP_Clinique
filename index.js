function verif(){
if(document.form1.login.value==""){
document.write('champs identifiant est vide');
document.form1.login.value.focus;
}else if(document.form.pass.value==""){
document.write('champs mot de passe est vide');
document.form1.login.pass.focus;
}else{
form1.submit();
} 
}
