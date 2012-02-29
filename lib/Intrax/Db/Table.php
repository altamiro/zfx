<?php

/**
 * encoding UTF-8
 * 
 * Classe de banco da aplicação
 *
 * Ob.: As Models tem que extender(extends) da classe Table.
 * 
 * @uses        Table
 *
 *  @category  Intrax
 *  @package   Db
 *  @author     Altamiro Rodrigues - <altamiro27 at gmail dot com>
 */

namespace Intrax\Db;

class Table extends \Zend_Db_Table {
  
	public $_objSelect;

	public function __construct() 
	{
		parent::__construct();
		$this->_objSelect = $this->select();
	}

	public function getColumns()
	{
		$arrColumns = $this->info( self::COLS );
		
		$arrDados = array();
		
		foreach( $arrColumns as $key => $value )
		{
			$arrDados[ $value ] = NULL;
		} # end foreach;
		
		return $arrDados;
	}

} # end class Table