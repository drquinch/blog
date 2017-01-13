function AutoCompletion ()
{
	this.inputText = "";
	this.defaultText = "no element found!";
	this.elementList = new Array();
	this.proposal = "";
	this.url = "";
	
	this.clearInputText = function()
	{
		this.inputText = "";
	}
	
	this.setInputText = function(inputText)
	{
		this.inputText = inputText;
	}
	
	this.clearProposal = function ()
	{
		this.proposal = "";
	}
	
	this.setUrl = function (url)
	{
		this.url = url;
		ajaxGet(this.url, this.setElementList);
	}
	
	/**
	 * setElementList function
	 * @param elementList json format
	 * fill this.elementList with simple string
	 */
	this.setElementList = function (elementList)
	{
		this.elementList = new Array();
		var tempList = new Array();
		tempList = JSON.parse(elementList);
		// après avoir parsé le json, on transforme le array d'objet en simple array de string
		for (var i = 0; i < tempList.elements.length; i++)
		{
			//console.log(tempList.elements[i].element);
			this.elementList.push(tempList.elements[i].element);
		}
		console.log(elementList);
	}
	
	this.completeWord = function ()
	{
		this.proposal = "";
		if(this.inputText.length >= 0)
		{
			for(var i = 0; i < this.elementList.length; i++)
			{
				if (this.elementList[i].indexOf(this.inputText) == 0)
				{
					this.proposal = this.elementList[i];
					return this.proposal;
				}
			}
		}
		return this.proposal;
	}
	
	/**
	 * highlight function
	 * @param element html (ex. input text) // Com : pour un textarea, faire autre fonction
	 * @return void
	 */
	this.highlightInputText = function (evt)
	{
		// on sépare la fin du mot proposé avec ce qu'il y a déjà dans l'input (ex. proposal = démons; inputText = dé; toHighlight = mons)
		var toHighlight = this.proposal.substring(this.inputText.length, this.proposal.length);
		// on rajoute la fin du mot proposé à l'input (ex. indé, dé; devient : indé, démons)
		evt.target.value = evt.target.value + toHighlight;
		// on sélectionne la fin du mot proposé pour que le user aie plus facile à éditer le champs input
		evt.target.selectionStart = evt.target.value.length - toHighlight.length;
	}
	
}