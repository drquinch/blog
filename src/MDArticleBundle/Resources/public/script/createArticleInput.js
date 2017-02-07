// on créé les différents array
var inputs = [document.getElementById("article_tags"),
				document.getElementById("article_games"),
				document.getElementById("article_licences"),
				document.getElementById("article_developers"),
				document.getElementById("article_publishers")];
var urls = ["http://localhost/blog/web/app_dev.php/tags/tag/json_all",
			"http://localhost/blog/web/app_dev.php/game/game/json_all",
			"http://localhost/blog/web/app_dev.php/game/licence/json_all",
			"http://localhost/blog/web/app_dev.php/game/developer/json_all",
			"http://localhost/blog/web/app_dev.php/game/publisher/json_all"];

//on affecte les valeurs par défaut de chacun des champs //TODO
//inputTextTagElt.value = "tag 1, tag 2, ...";
for (var i = 0; i < urls.length; i++)
{
	// closure pour capturer la valeur de i
	(function (i){
		inputs[i].autocompletion = new AutoCompletion();
		inputs[i].setElementList = function (resp) {
			this.autocompletion.elementList = new Array();
				var tempList = new Array();
				tempList = JSON.parse(resp);
				// après avoir parsé le json, on transforme le array d'objet en simple array de string
				for (var i = 0; i < tempList.elements.length; i++)
				{
					//console.log(tempList.elements[i].element);
					this.autocompletion.elementList.push(tempList.elements[i].element);
				}
				//console.log(this.autocompletion.elementList);
		};
		// on récupère les données en bdd et on l'injecte dans l'objet autocompletion
		ajaxGet(urls[i], function(resp){
			inputs[i].setElementList(resp);
		});
		// ajout de l'EL keyup à chapue input text
		inputs[i].addEventListener('keyup', function(e){
			// on vérifie d'abord si le focus est bien sur l'input actuel
			if (this === document.activeElement)
			{
				// si on n'a pas appuyé sur backspace et si ce nest pas keyup sur shift
				if (e.keyCode != 16 && e.keyCode != 8)// 16 == shift / 8 = backspace
				{
					var inputText = "";
					// on soustrait d'abord tout le contenu avant ', ' (', ' y compris) et on l'envois à l'objet autocompletion
					if(~e.target.value.indexOf(', '))
					{
						inputText = e.target.value.substring(e.target.value.lastIndexOf(', ')+2, e.target.value.length);
					} else {
						inputText = e.target.value;
					}
					this.autocompletion.setInputText(inputText);
					// on recherche le mot le plus proche qui pourrait coller
					result = this.autocompletion.completeWord();
					// highlight du texte
					this.autocompletion.highlightInputText(e);
					//console.log(this.autocompletion.proposal);
				}
			}
		});
	})(i);
}

// Gestion du titre et sous-titre
// On modifie le style si != de la value par default
// si la value est vide on remet la value par defaut
var titleInput = document.getElementById("article_title");
var subtitleInput = document.getElementById("article_subtitle");
var defaultTitle = titleInput.value;
var defaultSubtitle = subtitleInput.value;

function onFocus(obj, defaultText)
	{
		obj.color = "rgb(20,20,20)";
		obj.borderBottomColor = "rgb(20,20,20)";
		if (obj.value === defaultText)
		{
			obj.select();
		}
	};

function onBlur (obj, defaultText)
	{
		if(obj.value === "")
		{
			obj.value = defaultText;
			obj.style.color = "rgb(200,200,200)";
			obj.style.borderBottomColor = "rgb(200,200,200)";
		} else if (obj.value !== defaultText) {
			obj.style.color = "rgb(20,20,20)";
			obj.style.borderBottomColor = "rgb(20,20,20)";
		}
	};

titleInput.addEventListener('focus', function(){ onFocus(titleInput, defaultTitle); });
titleInput.addEventListener('blur', function() {onBlur(titleInput, defaultTitle); });
subtitleInput.addEventListener('focus', function(){ onFocus(subtitleInput, defaultSubtitle); });
subtitleInput.addEventListener('blur', function(){ onBlur(subtitleInput, defaultSubtitle); });