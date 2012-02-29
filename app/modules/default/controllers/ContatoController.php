<?php

use Intrax\Controller\Controller,
	Business\Contato,
	Business\Constante;

/**
 * ContatoController for default module
 */
class ContatoController extends Controller
{

    public function indexAction ()
    {
    	$this->_redirect( '/' );
    }

    public function listarAction()
    {
    	if ( $this->_request->isPost() )
		{
			$arrDataForm		=	$this->getPost( 'data' );
			$arrFrmPesquisar	=	$arrDataForm[ 'contato' ];

			$objContato					=	new Contato;
			$strTipoFiltro				=	$arrFrmPesquisar[ 'tipo_pesquisa' ];
			$objContato->$strTipoFiltro	=	$arrFrmPesquisar[ 'texto_pesquisado' ];
			$objResult					=	$objContato->listar();

			parent::_Paginator( $objResult );
			$this->view->frmName 		=	"frmPesquisar";
		} // end iF.
    } // end method listarAction

	public function formularioAction()
	{
		$intCoContato = (int) $this->getParam( 'co_contato' );

    	$objContato				=	new Contato;
    	$objContato->co_contato	=	$intCoContato;
    	$this->view->data 		=	$objContato->getDados();

	} // end method formularioAction

	public function salvarAction() 
    {
    	if ( $this->_request->isPost() )
		{
	    	$arrDataForm		=	$this->getPost( 'data' );
	    	$arrFrmCadastro		=	$arrDataForm[ 'contato' ];

	    	$objContato				=	new Contato;
			$objContato->arrDataForm	=	$arrFrmCadastro;
			$arrRetorno				=	$objContato->salvar();

			parent::addMessage( $arrRetorno );

			if ( isset( $arrRetorno[ Constante::SUCESSO ] ) )
			{
				$this->_redirect( '/' );
			}

			$this->_redirect( 'contato/new' );
			
	    	# retorna o resultado para view.
    	} // end iF.
    } // end method salvarAction
    
} # end class ContatoController