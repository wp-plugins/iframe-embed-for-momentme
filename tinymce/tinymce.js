function init() {
	tinyMCEPopup.resizeToInnerSize();
}

function insertIEFMLink() {
	
	var tagtext;
	
		var momenturl = document.getElementById('momenturl').value;
		var height = document.getElementById('momentHeight').value;
		var width = document.getElementById('momentWidth').value;
		if (momenturl != '' )
			tagtext = "[mframe url='" + momenturl + "' width='"+width+"' height='"+height+"']";
		else 
			tinyMCEPopup.close(); 
	
	if(window.tinyMCE) {
		//TODO: For QTranslate we should use here 'qtrans_textarea_content' instead 'content'
		window.tinyMCE.execInstanceCommand('content', 'mceInsertContent', false, tagtext);
		//Peforms a clean up of the current editor HTML. 
		//tinyMCEPopup.editor.execCommand('mceCleanup');
		//Repaints the editor. Sometimes the browser has graphic glitches. 
		tinyMCEPopup.editor.execCommand('mceRepaint');
		tinyMCEPopup.close();
	}
	return;
}
