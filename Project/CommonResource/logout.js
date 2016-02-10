function logout(){
	var scadenza = new Date();
			var adesso = new Date();
			scadenza.setTime(adesso.getTime() + (parseInt(-1) * 60000));
			document.cookie ='loginSession = valore; expires=' + scadenza.toGMTString() + '; path=/';
			//document.write('Cancellato');
			location.href = '/';
}