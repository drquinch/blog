var fullfillButtons = document.getElementsByClassName("fullfill");
var ffLen = fullfillButtons.length;
var fullfillInputs = document.getElementsByClassName("fullfill_input");
var toFills = document.getElementsByClassName("to_fill");
var delimiter = "%2C";
var url_game = "http://localhost/blog/web/app_dev.php/game/game/json/batch/";
var url_licence = "http://localhost/blog/web/app_dev.php/game/licence/json/batch/";
var inputGameId = "article_games";
var inputLicenceId = "article_licences";
// remplis l'input donné et fait les vérifications nécessaire
// param : 1) l'input à completer, 2) le array contenant le string (name) qui sera mis dedans, 3) index du array fillingString
function fillInput (inputToFill, fillingString, index)
{
	if (inputToFill.value.indexOf(fillingString[index]) === -1)
	{
		if(inputToFill.value && inputToFill.value.lastIndexOf(", ") !== inputToFill.value.length-2)
		{
			inputToFill.value += ", ";
		}
		inputToFill.value += fillingString[index].name;
		if (index+1 < fillingString[index])
		{
			inputToFill.value += ", ";
		}
	}
}

// remplis tous les inputs
function fillInputs(toFillInputs, objects)
{
	var length  = objects.length
	for(var h = 0; h < length; h++)
	{
		(function(){
			var object = objects[h];
			for(var j = 0; j < toFillInputs.length; j++)
			{
				(function() {
					switch (toFillInputs[j].id)
					{
						case "article_games":
							if (object.games)
							{
								for (var k = 0; k < object.games.length; k++)
								{
									(function() {
										fillInput(toFillInputs[j], object.games, k);
									})(k, j, object);
								}
							}
							break;
						case "article_licences":
							if (object.licence)
							{
								fillInput(toFillInputs[j], object.licence, 0);
							}
							break;
						case "article_publishers":
							if (object.publishers)
							{
								for (var k = 0; k < object.publishers.length; k++)
								{
									(function() {
										fillInput(toFillInputs[j], object.publishers, k);
									})(k, j, object);
								}
							}
							break;
						case "article_developers":
							if (object.developers)
							{
								for (var k = 0; k < object.developers.length; k++)
								{
									(function() {
										fillInput(toFillInputs[j], object.developers, k);
									})(k, j, object);
								}
							}
							break;
						case "article_tags":
							if (object.themes)
							{
								for (var k = 0; k < object.themes.length; k++)
								{
									(function() {
										fillInput(toFillInputs[j], object.themes, k);
									})(k, j, object);
								}
							}
							break;
					}
				})(j, object);
			}
		})(h, objects);
	}
}

// Pour chaque bouton fullfill, on associe l'input correspondant
// On lui ajoute un listener pour l'interaction lors du click
//   lors du click on récupère le ou les jeux/licence(s) du champs
//   on va chercher l'entité correspondante
//	 et on attribue aux autres inputs concernés les données formatées (avec ', ')
//	 TODO verifier que les mots/tag ne s'y retrouve pas deja avant de les placer dans les inputs.value
for (var i = 0; i < ffLen; i++)
{
	(function(i)
	{
		fullfillButtons[i].input = fullfillInputs[i];
		fullfillButtons[i].addEventListener('click', function(){
			// on vérifie si le champs n'est pas vide
			if(this.input.value != "")
			{
				var obj = this;
				if (this.input.id === inputGameId)
				{
					var url_ok = url_game + this.input.value.trim().replace(', ', '%2C%20').replace(' ', '%20') + '/' + delimiter;
					ajaxGet(url_ok, function(resp) {
						var games = JSON.parse(resp);
						fillInputs (toFills, games.games);
					});
				} else if (this.input.id === inputLicenceId)
				{
					var url_ok = url_licence + this.input.value.trim().replace(', ', '%2C%20').replace(' ', '%20') + '/' + delimiter;
					ajaxGet(url_ok, function(resp) {
						var licences = JSON.parse(resp);
						fillInputs (toFills, licences.licences);
					});
				}
			}
		});
	})(i);
}