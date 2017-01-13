function InputAutoCompletion (url, inputElt, autocompletion)
{
	this.url = url;
	this.inputElt = inputElt;
	this.autocompletion = autocompletion;
	this.setAutoCompletion = function ()
	{
		ajaxGet(url, autocompletion.setElementList);
	}
	this.addEventListener = function ()
	{
		inputElt.addEventListener ("keyup", function(e){
			var inputText = "";
			// on soustrait d'abord tout le contenu avant ', ' (', ' y compris) et on l'envois à l'objet autocompletion
			if(~e.target.value.indexOf(', '))
			{
				inputText = e.target.value.substring(e.target.value.lastIndexOf(', ')+2, e.target.value.length);
			} else {
				inputText = e.target.value;
			}
			console.log(autocompletion);
			console.log("it autocompl : " + autocompletion.inputText);
			autocompletion.setInputText(inputText);
			
			// on recherche le mot le plus proche qui pourrait coller
			result = autocompletion.completeWord();
			console.log("proposal " + autocompletion.proposal);
			// highlight du texte
			autocompletion.highlightInputText(e);
		});
	};
}