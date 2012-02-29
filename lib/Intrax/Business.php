<?php

/**
 * encoding UTF-8
 * 
 * Classe Business para trabalhar com regra de negocio
 * 
 * @uses        Intrax\Business
 *
 *  @category  Intrax
 *  @package   Business
 *  @author     Altamiro Rodrigues - <altamiro27 at gmail dot com>
 */

namespace Intrax;

abstract class Business {

  protected $_err;
  protected $_objTO;

  public function __construct()
  {
    $this->_err = '';
    $this->_objTO = new \stdClass();
  }

  public function __set( $attr , $value ) 
  {
    $this->$attr = $value;
  }

  public function __get( $attr ) 
  {
    return $this->$attr;
  }

  protected function toStdClass()
  { 
    foreach ( $this as $attr => $value )
    {
      if ( $attr != 'err' )
      {
        $this->_objTO->$attr = $value;
      }
    } 
    return ( $this->_objTO );
  }
  
  protected function toArray()
  {
    return (array)self::toStdClass();
  }

  protected function retornoARR( $strStatus , $strMsg , $arrData = array() )
  {
    return array_merge( array( $strStatus => $strMsg ) , $arrData );
  }

  protected function db()
  {
    return \Zend_Registry::get( 'db' );
  }

  protected function cache()
  {
    return \Zend_Registry::get( 'cache' );
  }

  protected function session()
  {
    return \Zend_Registry::get( 'session' );
  }

  protected function auth()
  {
    return \Zend_Auth::getInstance()->getIdentity();
  }

  protected function translate( $strTranslate )
  {
    return \Zend_Registry::get( 'Zend_Translate' )->translate( $strTranslate );
  }

  protected function retornoDTO( array $arrData )
  {
  	return \Intrax\Base::arrayToDTO( $arrData );
  }

  protected function getDataHora()
  {
  	return date( 'Y-m-d H:i:s' );
  }

} // end class Intrax\Business