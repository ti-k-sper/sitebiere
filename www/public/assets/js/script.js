function calcPrice(obj, id, originalPrice){
	var qty = obj.value;

	var pHT = originalPrice;

	pHT = (pHT * qty);
	var pTTC =  pHT * 1.2;

	document.getElementById('PHT_'+id).innerHTML = String(pHT.toFixed(2)).replace('.', ',')+"€";
	document.getElementById('PTTC_'+id).innerHTML = String(pTTC.toFixed(2)).replace('.', ',')+"€";
	console.log(pTTC);
}

function getValue() {
	/* TO DO
		Gérer la casse,
		Supprimer les spans en trop de l'article traité
	*/

	//$('span').removeAttr('style');
	$('span').contents().unwrap();
	var word = $('#inputSearch').val();// Récupère la valeur de l'input#inputSearch
	var field = $('.articles').html();//Récupère le contenu html de l'article#article
	var pos = field.indexOf(word); //Cherche la première occurence du mot word
	var re = new RegExp('('+word+')(?![^<]*>)', "gi"); //Créé une expression régulière qui accepte le mot word mais exclue les caractères spéciaux
	if (pos > -1){
		//Remplace tous les mots word de la chaine de caractère originale en fonction de la regExp puis la stocke dans content
		var content = field.replace (re, '<span style="background-color: #00FF00">'+word+'</span>');
		//remplace le contenu orginal par le nouveau contenu
		$('.articles').html(content);  
	}
}