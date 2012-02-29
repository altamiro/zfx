<?php

/**
 * encoding UTF-8
 * 
 * Classe controller da aplicacao
 * 
 * @uses        Auth
 *
 *  @category  Intrax
 *  @package   Controller
 *  @author     Altamiro Rodrigues - <altamiro27 at gmail dot com>
 */

namespace Intrax\Controller;

use Intrax\Controller\Action; 

class Auth extends Action {
  
  public function init() {
  	parent::init();
  	parent::layout( 'layout-login' );
  }
  
} # end class Auth