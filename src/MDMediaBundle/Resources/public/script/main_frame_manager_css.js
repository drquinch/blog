// script pour mettre le main_frame_manager.html.twig en style css
// div global
var elt = document.getElementById("management_frame");
elt.style.margin = "auto";
elt.style.width = "900px";
elt.style.fontFamily = "'Open Sans', Arial";

// div top_management_frame
elt = document.getElementById("top_management_frame");
elt.style.display = "flex";

var listElt = document.getElementsByClassName("top_link_management_frame");
for(var i = 0; i < listElt.length; i++)
{
	var link = listElt[i].getElementsByTagName("a");
	listElt[i].style.width = "300px";
	listElt[i].style.textAlign = "center";
	listElt[i].style.color = "rgb(40,40,40)";
	listElt[i].style.backgroundColor = "rgb(250,250,250)";
	listElt[i].style.paddingTop = "10px";
	listElt[i].style.paddingBottom = "10px";
	listElt[i].style.borderTop = "1px solid rgb(219,228,239)";
	listElt[i].style.borderLeft = "1px solid rgb(219,228,239)";
	listElt[i].style.borderRight = "1px solid rgb(219,228,239)";

	link[0].style.textDecoration = "none";
	link[0].style.fontWeight = "bold";
	link[0].style.color= "rgb(40,40,40)";
}

// div body_management_frame
elt = document.getElementById("body_management_frame");
elt.style.borderLeft = "1px solid rgb(219,228,239)";
elt.style.borderRight = "1px solid rgb(219,228,239)";
elt.style.backgroundColor = "rgb(250,250,250)";
elt.style.width = "898px";

// div explorer_management_frame
