var Contato = {

	init: function( param )
	{
		this.param = param;
		this.pesquisar();
		$( '#frmPesquisar' ).submit( this.pesquisar );
	} , 

	pesquisar: function()
	{
		$.post( baseUrl + '/contato/listar' , $( '#frmPesquisar' ).serialize() , function( html ) 
		{
			$( '#div-listar' ).html( html );
        });
	} , 


}; // end Filial