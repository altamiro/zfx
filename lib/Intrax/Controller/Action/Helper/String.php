<?php
/**
 * encoding UTF-8
 * 
 * Classe para manipulação de strings
 * 
 * @name      String
 * @category  Intrax
 * @package   Controller\Action\Helper
 * @author     Altamiro Rodrigues - <altamiro27 at gmail dot com>
 */

namespace Intrax\Controller\Action\Helper;

class String extends HelperAbstract
{
    private $_objFilter;
    
    public function init() 
    {
        parent::init();
        $this->_objFilter = new \Zend_Filter();
    }
    
	public function upper($value, $encoding=APP_CONF_PARAMETERS_CHARSET)
	{
        $this->_objFilter->addFilter(new \Zend_Filter_StringToUpper(array('encoding'=>$encoding)));
		return $this->_objFilter->filter($value);
	}
	
	public function lower($value,$encoding=APP_CONF_PARAMETERS_CHARSET)
	{
        $this->_objFilter->addFilter(new \Zend_Filter_StringToLower(array('encoding'=>$encoding)));
		return $this->_objFilter->filter($value);
	}
	
}