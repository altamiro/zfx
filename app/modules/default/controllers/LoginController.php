<?php

use Intrax\Controller\Auth,
	Business\Usuario,
	Business\Constante;

/**
 * LoginController for default module
 */
class LoginController extends Auth
{
    public function indexAction () { }

    /**
	 * metodo que valida os dados do usuario informado para logar no sistema
	 * @author	Altamiro Rodrigues
	 * @access	public
	 * @return  json
	 */
	public function authAction()
	{
		parent::_notLayout();
		if ( $this->_request->isPost() )
		{
			$arrDataForm = $this->getPost( 'data' );

			$objUsuario					=	new Usuario;
			$objUsuario->arrFrmUsuario	=	$arrDataForm[ 'usuario' ];
			$resultUsuario				=	$objUsuario->autentica();

			if ( $resultUsuario != Constante::OK )
			{
				parent::addMessage( $resultUsuario );
				$this->_redirect( 'login' );
			} // end iF;

			$this->_redirect( '/' );

		} // end iF.

	} # end method authAction

	/**
	 * metodo que limpa ah sessao do sistema e redireciona para pagina de login
	 * @author	Altamiro Rodrigues
	 * @access	public
	 * @return  json
	 */
	public function sairAction()
	{
		\Zend_Auth::getInstance()->clearIdentity();
		parent::addMessage( parent::translate( 'sessao-encerrada' ) );
        $this->_redirect( 'login' );
	} # end method authAction
    
} # end class LoginController