<?php

/**
 * encoding UTF-8
 * 
 * Classe controller da aplicação
 *
 * Ob.: Os Controllers dos modules tem que extender(extends) da classe Controller e não da classe Action.
 * 
 * @uses        Action
 *
 *  @category  Intrax
 *  @package   Controller
 *  @author     Altamiro Rodrigues - <altamiro27 at gmail dot com>
 */

namespace Intrax\Controller;

abstract class Action extends \Zend_Controller_Action {
  
  
	public function init() {
		if ( $this->_helper->FlashMessenger->hasMessages() ) 
		{
			$this->view->messages = $this->_helper->FlashMessenger->getMessages();
		}
	}

	protected function addMessage( $strMessage )
	{
		$this->_helper->flashMessenger->addMessage( $strMessage );
	}

	protected function initSecurity()
	{
		$auth = \Zend_Auth::getInstance();
		if ( !$auth->hasIdentity() )
		{
		  $this->_redirect( 'login' );
		}

		$this->view->auth	=	$auth->getIdentity();
		$this->auth			=	$auth->getIdentity();
	}

	/**
	* Atalho para a action helper String
	*
	* @return Intrax\Controller\Action\Helper\String
	*/
	public function helperString()
	{
		return $this->_helper->String;
	}

	/**
	* Caso o método não seja encotrado
	*
	* @param STRING $strMethod
	* @param ARRAY $arrParameters
	* @return VOID
	*/
	public function __call( $strMethod , $arrParameters ) {
		\Intrax\Base::debug( "O m&eacute;todo " . $strMethod . " n&atilde;o foi encontrado na classe " . __CLASS__ . ".<br />" . __FILE__ . "(linha " . __LINE__ . ")" , 1 );
	} # end method __call

	/**
	* Métdo que faz o debug
	*
	* @param STRING $mixExpression
	* @param BOOLAN $boolExit
	* @return VOID
	*/
	protected function debug( $mixExpression , $boolExit = FALSE ) {
		\Intrax\Base::debug( $mixExpression , $boolExit ); 
	} # end method debug

	protected function layout( $strLayout )
	{
		return $this->_helper->layout->setLayout( $strLayout );
	}

	protected function json( $arrJson )
	{
		return $this->_helper->json( $arrJson )->viewRenderer->setNoRender();
	}

	protected function layoutNoRender( $strLayout )
	{
		self::layout( $strLayout );
		return $this->_helper->viewRenderer->setNoRender();
	}

	protected function _isAjax()
	{
		$this->_helper->layout()->disableLayout();
		$this->_helper->viewRenderer->setNoRender(true);
	}

	protected function _notLayout()
	{
		self::_isAjax();
	}

	protected function getPost( $data )
    {
      return $this->_request->getPost( $data );
    }

    protected function getParam( $data )
    {
      return $this->_getParam( $data );
    }
  
	protected function _Paginator( $objData , $nuPage = 25 , $nuPageRange = 6 )
	{
		self::layout( 'clear' );
		$objCache				=	\Zend_Registry::get( 'cache' );
		
		$nuList					=	$this->_getParam( 'list' );
	    
	   	$intPage				=	( isset( $nuList ) && $nuList != null ) ? $nuList : $nuPage;
	    
		$objPaginator			=	\Zend_Paginator::factory( $objData );
		$objPaginator->setCache( $objCache );
		$objPaginator->setCacheEnabled( true );
		$objPaginator->setPageRange( $nuPageRange );
		$objPaginator->setItemCountPerPage( $intPage );
		$objPaginator->setCurrentPageNumber( $this->_getParam('page') );
		$this->view->paginator	=	$objPaginator;

		# id da DIV onde vai aparecer ah listagem na tela.
		$this->view->div_id		=	"div-listar";
		$this->view->dataType 	=	"post";
		$this->view->frmName	=	"frm";
	}

	protected function translate( $strTranslate )
	{
		return $this->view->translate( $strTranslate );
	}
  
  
} # end class Intrax_Controller_Action