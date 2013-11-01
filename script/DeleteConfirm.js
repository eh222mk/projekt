
deleteLink = document.getElementById("deleteLink");
deleteCommentLink = document.getElementById("commentDeleteLink");

deleteCommentLink.onclick = function(){
	return confirm("Vill du verkligen radera den här kommentaren?");
}

deleteLink.onclick = function(){
	return confirm("Vill du verkligen radera den här tråden?");
}
