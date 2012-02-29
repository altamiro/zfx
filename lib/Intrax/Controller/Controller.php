<?php

/**
 * encoding UTF-8
 * 
 * Classe controller da aplicacao
 * 
 * @uses        Controller
 *
 *  @category  Intrax
 *  @package   Controller
 *  @author     Altamiro Rodrigues - <altamiro27 at gmail dot com>
 */

namespace Intrax\Controller;

use Intrax\Controller\Action; 

class Controller extends Action {
  
  public function init() {
  	parent::init();
 	parent::initSecurity();
  }
  
} # end class Controller