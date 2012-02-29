<?php
/**
 * encoding UTF-8
 *
 * Business de Contato
 *
 *  @uses       Contato
 *  @package    src
 *  @subpackage src.business
 *  @author     Altamiro Rodrigues - <altamiro27 at gmail dot com>
 */

namespace Business;

use Intrax\Business,
	Models\Contato as ModelContato;

class Contato extends Business {

	/**
     * Define o objeto da model usuario
     * @name $_objModelContato
     * @access protected
     * @var object
     */
	protected $_objModelContato;

	/**
	 * Metodo construtor que carrega as classes da models que vai ser usada nessa business
	 *
	 * @author 	Altamiro Rodrigues
	 * @return  void
	 */
	public function __construct()
	{
		# instancia a model do ModelContato.
		$this->_objModelContato = ModelContato::build();
	} # end method __construct

	/**
	 * metodo que busca todos os registros da tabela
	 * @author 	Altamiro Rodrigues
	 * @access	public
	 */
	public function listar()
	{
		$objResult = $this->_objModelContato->findAll( parent::toStdClass() );
		
		return ( $objResult );
	} # end method listar

	/**
	 * metodo que salva/atualiza os dados do registro na tabela
	 * @author 	Altamiro Rodrigues
	 * @access	public
	 */
	public function salvar()
	{
		# iniciando uma transaction.
		parent::db()->beginTransaction();

		try {

			$strMsg = parent::translate( "registro-atualizado" );

			$objFilial	=	$this->_objModelContato->fetchRow( 'co_contato = ' . (int) $this->arrDataForm[ 'co_contato' ] );

			if ( empty( $objFilial ) )
			{
				$objFilial	=	$this->_objModelContato->createRow();
				unset( $this->arrDataForm[ 'co_contato' ] );
				$strMsg = parent::translate( "registro-cadastro" );
			}
			else
			{
				$this->arrDataForm[ 'dt_alteracao' ] = parent::getDataHora();
			} # end iF;

			$objFilial->setFromArray( $this->arrDataForm );
			$objFilial->save();

			# finaliza com commit.
			parent::db()->commit();
			$arrJsonResult = parent::retornoARR( Constante::SUCESSO , $strMsg );

		} catch ( Zend_Db_Exception $ex ) {
			# retorna um rollback caso tenha erro.
			parent::db()->rollback();
			$arrJsonResult = parent::retornoARR( Constante::ERROR , $ex->getMessage() );
		} catch ( Exception $e ) {
			# retorna um rollback caso tenha erro.
			parent::db()->rollback();
			$arrJsonResult = parent::retornoARR( Constante::ERROR , $e->getMessage() );
		} // end try/catch

		return ( $arrJsonResult );
	} # end method salvar

	/**
	 * metodo que retorna os dados da tabela de acordo com parametro informado.
	 * @author 	Altamiro Rodrigues
	 * @access	public
	 */
	public function getDados()
	{
		// pega o nome dos campos dessa model.
		$arrFilialColumns = $this->_objModelContato->getColumns();

		if ( $this->co_contato > 0 ) 
		{
			$objResult = $this->_objModelContato->find( $this->co_contato );

			if ( $objResult->count() > 0 )
			{
				$arrFilialColumns = $objResult->current()->toArray();
			} // end iF;
		} // end iF;

		return parent::retornoDTO( $arrFilialColumns );

	} # end method getDados

} // end class Business\Contato.