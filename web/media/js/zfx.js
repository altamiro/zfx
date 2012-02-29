$(document).ajaxStart(function(){
	ajaxLoading( 'Aguarde! Carregando...' );
});
$(document).ajaxStop(function(){
    ajaxLoaded();
});

function modal( strUrl , strIdDiv )
{
	var idDiv = 'myModal';
	if ( strIdDiv )
	{
		idDiv = strIdDiv;
	} // end iF;
	
	$.get( strUrl , function( html ) {
		$( '<div class="modal" id="' + idDiv + '" >' + html + '</div>' ).modal( { keyboard: false } );
	} );
}

function modalClose( strIdDiv )
{
	var idDiv = 'myModal';
	if ( strIdDiv )
	{
		idDiv = strIdDiv;
	} // end iF;

	$( '#' + idDiv ).modal('hide');
}

/**
 * coloca na tela uma mensagem enquanto carrega o AJAX...
 */
function ajaxLoading( msg ){
	//Remove caixas de dialog do sistema
	$("#zfxDialogMsg").remove();
	$('#zfxCarregandoDialog').remove();
	
	var strHtml = '<div id="zfxCarregandoDialog" class="zfx_carregando" title="'+msg+'" style=\"display: none;\"></div>';
	$('body').prepend(strHtml);
	
	$("#zfxCarregandoDialog").dialog({
		draggable: false,
		closeOnEscape: false,
		minHeight: 60,
		minWidth: 150,
		modal: true,
		resizable: false,
		shadow: true,
		zIndex: 99999999
	});
	$('#ui-dialog-title-zfxCarregandoDialog').next().remove();
}

/**
 * depois que o AJAX carregou...
 */
function ajaxLoaded(){
	$('#zfxCarregandoDialog').dialog('close');
    $('#zfxCarregandoDialog').remove();
}


function redirecionar( url )
{
	window.location.href = url;
} // end redirecionar

function reload() 
{
	window.location.reload();
} // end reload.

function dialogUrl( id , url )
{
	$( "#" + id ).empty().load( url ).dialog('open');
	return false;
}

function mudarPaginaDataGrid( id , url , frmName , dataType )
{

	if ( dataType == "post" )
	{
		$.post( url, $( "#" + frmName ).serialize(), function( data )
		{
			$( "#" + id ).html( data );
		},
		'html' );
	}
	else
	{
		$( "#" + id ).load( url , function() { } );
	} // end iF.
	
}

function dialogClose( id )
{
	if( id )
	{
		$( "div[id^='" + id + "']" ).dialog( 'close' );
	}
	else
	{
		$( "div[jwindow]" ).dialog( 'close' );
		$( "div[id^='divJwindowModal']" ).dialog( 'close' );
	}
}