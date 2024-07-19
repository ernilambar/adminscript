( function ( $ ) {
	$( '#adminscript-wrap' )
		.find( '.adminscript_row textarea' )
		.each( function () {
			wp.codeEditor.initialize( $( this ).attr( 'id' ), codeEditorSettings.javascript );
		} );
} )( jQuery );
