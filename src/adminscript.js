import './adminscript.css';

( function ( $ ) {
	const $asWrapper = $( '#adminscript-wrap' );

	$asWrapper.find( '.adminscript_js_code_row textarea' ).each( function () {
		wp.codeEditor.initialize( $( this ).attr( 'id' ), codeEditorSettings.javascript );
	} );
} )( jQuery );
