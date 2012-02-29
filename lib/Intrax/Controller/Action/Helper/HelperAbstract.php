<?php
/**
 * encoding UTF-8
 * 
 * @name      HelperAbstract
 * @category  Intrax
 * @package   Controller\Action\Helper
 * @author     Altamiro Rodrigues - <altamiro27 at gmail dot com>
 */

namespace Intrax\Controller\Action\Helper;

class HelperAbstract extends \Zend_Controller_Action_Helper_Abstract {
    
    /**
     * Desabilita a renderização do layout, menu e phtml
     *
     * @return Intrax\Controller\Action\Helper\Abstract
     */
    protected function _disableLayout()
    {
        $this->getActionController()
             ->getHelper('Disable')
             ->layout()
             ->phtml();
        return $this;
    }
}