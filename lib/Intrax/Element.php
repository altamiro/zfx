<?php

/**
 * encoding UTF-8
 * 
 * Classe base do pacote Intrax
 * 
 * @uses        Intrax\Element
 *
 *  @category  Intrax
 *  @package   Element
 *  @author     Altamiro Rodrigues - <altamiro27 at gmail dot com>
 */

namespace Intrax;

class Element {

	protected $_element;
	protected $_name;
	protected $_closeTags = array( 'img','br','input','hr' );
	protected $_value;

	/**
	 * Metodo construtor, inicia a criação de um elemento
	 * Lança uma exceção do tipo Emec_Exception_erro em caso de erro
	 * 
	 * @param string elemento		 
	 * @param array $atributos 
	 */
	public function __construct( $elemento, array $atributos = array() )
	{
		if( empty( $elemento ) ){
			throw new \Zend_Exception('Erro: elemento não pode ser criado!');
			return false;
		}
		$this->_name = $elemento;
		$this->_element = "<".$elemento." ";
		if( !empty( $atributos ) )
		{
			$this->addAttrs( $atributos );
		}
	}
	
	/**
	 * Metodo para adicionar varios atributos
	 * 
	 * @access public
	 * @param array - atributos
	 * @return string
	 */
	public function addAttrs( array $atributos = array() )
	{
		if ( count( $atributos ) > 0 )
		{
			foreach( $atributos as $chave=>$valor )
			{
				$this->addAttr( $chave, $valor );
			}
		}
	}
	
	/**
	 * metodo para adicionar um atributo
	 * 
	 * @access public
	 * @param string atributo
	 * @param string valor
	 */
	public function addAttr( $attr, $valor )
	{
		$this->_element .= $attr.'="'.$valor.'" ';
	}

	/**
	 * Metodo para setar os valor que vai no elemento
	 * 
	 * @param string
	 */
	public function setValue( $valor )
	{
		$this->_value[] = $valor;		
	}
	
	/**
	 * Metodo para retornar o elemento pronto
	 * @return string html
	 */
	public function show()
	{
		
		if( in_array( strtolower( $this->_name ), $this->_closeTags ) )
		{
		    return $this->_element .= " />";
		}
		return $this->_element .= ">".implode( '', $this->_value )."</".$this->_name.">";
	}

} // end class Intrax\Element