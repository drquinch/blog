// Ex�cute un appel AJAX GET
// Prend en param�tres l'URL cible et la fonction callback appel�e en cas de succ�s
function ajaxGet(url, callback) {
    var req = new XMLHttpRequest();
    req.open("GET", url);
    req.addEventListener("load", function () {
        if (req.status >= 200 && req.status < 400) {
            // Appelle la fonction callback en lui passant la r�ponse de la requ�te
            callback(req.responseText);
        } else {
            console.error(req.status + " " + req.statusText + " " + url);
        }
    });
    req.addEventListener("error", function () {
        console.error("Erreur r�seau avec l'URL " + url);
    });
    req.send(null);
}

// Ex�cute un appel AJAX POST
// Prends en param�tres l'URL cible et la fonction callback appel�e en cas de succ�s
function ajaxPost(url, parameters, callback) {
	var http = new XMLHttpRequest();
	
	http.open("POST", url, true);
	http.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
	
	http.addEventListener("load", function () {
		if (http.status >= 200 && http.status < 400)
		{
			callback(http.responseText);
		} else {
			console.error(http.status + " " + http.statusText + " "+ url);
		}
	});
	http.addEventListener("error", function () {
		console.error("Erreur r�seau avec l'URL " + url);
	});
	http.send(parameters);
}