jQuery( function( $ ) {
	var editor = CodeMirror.fromTextArea( document.getElementById( 'smc-custom-css-textarea' ), {
		mode: "css",
		theme: "default",
		styleActiveLine: true,
		matchBrackets: true,
		lineNumbers: true
	} );
} )
