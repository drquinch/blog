var resetButtons = document.getElementsByClassName("reset");
var resetButtonsLen = resetButtons.length;

for (var i = 0; i < resetButtonsLen; i++)
{
	(function () 
	{
		resetButtons[i].addEventListener("click", function()
		{
			switch (this.id)
			{
				case "reset_games":
					document.getElementById("article_games").value = "";
				break;
				case "reset_licences":
					document.getElementById("article_licences").value = "";
				break;
				case "reset_publishers":
					document.getElementById("article_publishers").value = "";
				break;
				case "reset_developers":
					document.getElementById("article_developers").value = "";
				break;
				case "reset_tags":
					document.getElementById("article_tags").value = "";
				break;
			}
		});
	})(i);
}