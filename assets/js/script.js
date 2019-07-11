function getNewPrice(id, quantity, originPrice) {
    //On récupère l'objet HTML qui a l'id "pht_"+id
    //Donc si id = 0 alors on ira récupérer l'objet html qui a l'id "pht_0"
    //Ne pas hésiter à utiliser l'inspecteur pour bien comprendre
    var objHT = document.getElementById('pht_'+id);

    //Même principe qu'au dessus
    var objTTC = document.getElementById('pttc_'+id);

    //On multiplie le prix d'origine de la biere sélectionnée à la valeur du champs quantité de la bière
    var newPrice = originPrice * quantity.value;

    //On multiplie le prix à 1.2(TVA) pour obtenir le prix TTC
    var TTCprice = newPrice *1.2;

    if(quantity.value > 0) {
        //toFixed(2) permet de limiter de 2 le nombre de chiffre apres la virgule de la variable newPrice
        //String permet de convertir(Caster) le résultat en chaine de caractère
        //Puis replace('.', ',') va remplacer les "." par des ","
        //Exemple: 12.56 deviendra 12,56
        objHT.innerHTML = String(newPrice.toFixed(2)).replace('.', ',')+'€';
        objTTC.innerHTML = String(TTCprice.toFixed(2)).replace('.', ',')+'€';
    }
}
