<?php
/**
 * encoding UTF-8
 *
 * Business de Usuario
 *
 *  @uses       Usuario
 *  @package    src
 *  @subpackage src.business
 *  @author     Altamiro Rodrigues - <altamiro27 at gmail dot com>
 */

namespace Business;

use Intrax\Business,
	Models\Usuario as ModelUsuario;

class Usuario extends Business {

	/**
     * Define o objeto da model usuario
     * @name $_objModelUsuario
     * @access protected
     * @var object
     */
	protected $_objModelUsuario;

	/**
	 * Metodo construtor que carrega as classes da models que vai ser usada nessa business
	 *
	 * @author 	Altamiro Rodrigues
	 * @return  void
	 */
	public function __construct()
	{
		# instancia a model do ModelUsuario.
		$this->_objModelUsuario = ModelUsuario::build();
	} # end method __construct

	/**
	 * Metodo que faz a autenticacao do usuario no sistema.
	 */
	public function autentica()
	{
		try {

			// verifica os dados enviado via post e faz comparacao no banco.
			$authAdapter = new \Zend_Auth_Adapter_DbTable( parent::db() );
			$authAdapter->setTableName( 'usuario' )
					    ->setIdentityColumn( 'ds_email' )
					    ->setCredentialColumn( 'ds_senha' )
					    ->setCredentialTreatment( 'md5(?)' )
					    ->setIdentity( $this->arrFrmUsuario[ 'ds_email' ] )
					    ->setCredential( $this->arrFrmUsuario[ 'ds_senha' ] );

			// instacia a class Auth do zend.
			$auth	=	\Zend_Auth::getInstance();
			$result	=	$auth->authenticate( $authAdapter );

			// verifica se ah informacao passada via post sao validas.
			if ( $result->isValid() )
			{
				$objData	=	$authAdapter->getResultRowObject( null , "ds_senha" );

				$auth->getStorage()->write( $objData );
				$strResult = Constante::OK;
			}
			else // se nao retorne uma mensagem de error.
			{
				$strResult = parent::translate( "usuario-invalido" );
			} // end iF.

		} catch ( Zend_Db_Exception $ex ) {
			$strResult = $ex->getMessage();
		} catch ( Exception $e ) {
			$strResult = $e->getMessage();
		} // end try/catch

		return ( $strResult );

	} // end method autentica

} // end class Business\Usuario.