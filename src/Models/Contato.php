<?php
/**
 * encoding UTF-8
 * 
 * Model de Contato
 * 
 *  @uses       Contato
 *  @package    src
 *  @subpackage src.models
 *  @author     Altamiro Rodrigues - <altamiro27 at gmail dot com>
 */

namespace Models;

use Intrax\Db\Table;

class Contato extends Table {

    public static $_instance;

    protected $_name            =   'contato';
    protected $_primary         =   array( 'co_contato' );
    protected $_dependentTables =   array( 'Models\Telefone' );
    protected $_referenceMap    =   array( 'Usuario' => array( 'columns'         =>  array( 'co_usuario' ) , 
                                                               'refTableClass'   =>  'Models\Usuario' , 
                                                               'refColumns'      =>  array( 'co_usuario' ) ) );

    public static function build()
    {
        if ( !isset( self::$_instance ) )
        {
            self::$_instance = new self();
        }

        return self::$_instance;
    }

    /**
	 * findAll
	 * 
	 * Listar dos os registros da tabela de acordo com filtro passado.
	 */
    public function findAll( \stdClass $objDTO )
    {

    	if ( isset( $objDTO->co_contato ) && $objDTO->co_contato != '' )
    	{
    		$this->_objSelect->where( "co_contato IN ({$objDTO->co_contato})" );
    	} // end iF;

    	if ( isset( $objDTO->no_contato ) && $objDTO->no_contato != '' )
    	{
    		$this->_objSelect->where( 'no_contato ILIKE ?' , (string) '%'.$objDTO->no_contato.'%' );
    	} // end iF;

    	if ( isset( $objDTO->no_apelido ) && $objDTO->no_apelido != '' )
    	{
    		$this->_objSelect->where( 'no_apelido ILIKE ?' , (string) '%'.$objDTO->no_apelido.'%' );
    	} // end iF;

    	$objResult	=	$this->fetchAll( $this->_objSelect );
    	return $objResult;
    } // end method findAll

} # end class Contato