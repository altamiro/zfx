<?php
/**
 * encoding UTF-8
 * 
 * Classe que registra o translate default do sistema e o translate dos módulos
 *
 *  @package   Intrax
 *  @subpackage Controller\Plugin
 *  @author     Altamiro Rodrigues - <altamiro27 at gmail dot com>
 */

namespace Intrax\Controller\Plugin;

class ViewSetup extends \Zend_Controller_Plugin_Abstract
{
    /**
     * @var Zend_View
     */
    protected $_view;
    /**
     *
     * @var Zend_Controller_Request_Abstract 
     */
    protected $_request;
    /**
     *
     * @var Bootstrap 
     */
    protected $_bootstrap;

    /**
     * Dispacho inicial
     *
     * @param Zend_Controller_Request_Abstract $request
     * @return void
     */
    public function dispatchLoopStartup(\Zend_Controller_Request_Abstract $request)
    {
        $front            = \Zend_Controller_Front::getInstance();
        $this->_bootstrap = $front->getParam('bootstrap');
        $this->_view      = $this->_bootstrap->getPluginResource( 'view' )->getView();
        $this->_request   = $request;
        
        $this->_configureRequestVars()
             ->_configureHelpers()
             ->_configureStylesheet()
             ->_configureScript();
    }
    
    /**
     * Configura as variáveis da requisição
     * 
     * @return ViewSetup 
     */
    protected function _configureRequestVars()
    {
        $this->_view->originalModule     = $this->_request->getModuleName();
        $this->_view->originalController = $this->_request->getControllerName();
        $this->_view->originalAction     = $this->_request->getActionName();
        
        return $this;
    }
    
    /**
     *
     * @return ViewSetup 
     */
    protected function _configureHelpers()
    {
        //view Helpers
        $viewHelpers = array();
        $viewHelpers['default']['prefix'] = 'Module\Defaults\View\Helper\\';
        $viewHelpers['default']['dir'   ] = APPLICATION_PATH .'/modules/default/views/helpers';

        $viewHelpers['intrax']['prefix'] = 'Intrax\View\Helper\\';
        $viewHelpers['intrax']['dir'   ] = LIBRARY_PATH .'/Intrax/View/Helper';
        
        //CASO o modulo seja diferente do web carrega os helpers de view caso existam
        $module = strtolower($this->_view->originalModule);
        if( $module != 'default' ){
            $fullPath = APPLICATION_PATH .'/modules/'.$module.'/views/helpers';
            if( file_exists( $fullPath ) ){
                $viewHelpers[$module]['prefix'] = 'Modules\\'.ucfirst($module).'\View\Helper\\';
                $viewHelpers[$module]['dir'   ] = $fullPath;
            }
        }
        
        //adiciona os helpers de view definidos
        foreach($viewHelpers as $module=>$configs){
            $this->_view->addHelperPath($configs['dir'], $configs['prefix']);
        }
        
        //controller Helpers
        $prefixController = "Intrax\Controller\Action\Helper\\";
        $dirController    = dirname(__FILE__).'/../Action/Helper';
        \Zend_Controller_Action_HelperBroker::addPath($dirController, $prefixController);
        
        return $this;
    }
    
        
    /**
     * Configura os includes de CSS
     *
     * @return Intrax\Controller\Plugin\ViewSetup
     */
    protected function _configureStylesheet()
    {
        $pathCss     = $this->diretorioMedia( "css" );
        $pathJss     = $this->diretorioMedia( "js" );
        $pathJQuery     = $this->diretorioMedia( "jquery" );
		$this->_view->headLink()
					->appendStylesheet( "{$pathCss}bootstrap.css" )
                    ->appendStylesheet( "{$pathCss}bootstrap-responsive.css" )
                    ->appendStylesheet( "{$pathJss}google-code-prettify/prettify.css" )
                    ->appendStylesheet( "{$pathJss}zfx.css" )
                    ->appendStylesheet( "{$pathJQuery}plugins/jquery-ui/themes/redmond/jquery.ui.all.css" );
        return $this;
    }
    
    protected function _configureScript()
    {
        $this->_preScriptConfiguration()
             ->_configureFileScriptDefault();
        return $this;
    }

    /**
     * Configura o script inicial
     *
     * @return Intrax\Controller\Plugin\ViewSetup
     */
    protected function _preScriptConfiguration()
    {
        $scriptInicial  = " var baseUrl = '{$this->_view->baseUrl()}';" . PHP_EOL;
        $scriptInicial .= " var baseRequest = { " . PHP_EOL;
        $scriptInicial .= "   \"module\"     : \"{$this->_view->originalModule}\", "    . PHP_EOL;
        $scriptInicial .= "   \"controller\" : \"{$this->_view->originalController}\", ". PHP_EOL;
        $scriptInicial .= "   \"action\"     : \"{$this->_view->originalAction}\" "     . PHP_EOL;
        $scriptInicial .= " }; " . PHP_EOL;
        $this->_view->headScript()->appendScript($scriptInicial);
        return $this;
    }
    
    /**
     * Configura os includes dos scripts padrões
     *
     * @return Intrax\Controller\Plugin\ViewSetup
     */
    protected function _configureFileScriptDefault()
    {
        $type = 'text/javascript';
        $lang = array('language'=>'javascript');

        $this->_view->headScript()
                    ->appendFile("{$this->diretorioMedia( "jquery" )}jquery.js",$type,$lang)
                    ->appendFile("{$this->diretorioMedia( "jquery" )}plugins/jquery-ui/ui/i18n/jquery.ui.datepicker-pt-BR.min.js",$type,$lang)
                    ->appendFile("{$this->diretorioMedia( "jquery" )}plugins/jquery-ui/ui/jquery-ui.min.js",$type,$lang)
                    ->appendFile("{$this->diretorioMedia( "js" )}google-code-prettify/prettify.js",$type,$lang)
                    ->appendFile("{$this->diretorioMedia( "bootstrap" )}bootstrap-transition.js",$type,$lang)
                    ->appendFile("{$this->diretorioMedia( "bootstrap" )}bootstrap-alert.js",$type,$lang)
                    ->appendFile("{$this->diretorioMedia( "bootstrap" )}bootstrap-modal.js",$type,$lang)
                    ->appendFile("{$this->diretorioMedia( "bootstrap" )}bootstrap-dropdown.js",$type,$lang)
                    ->appendFile("{$this->diretorioMedia( "bootstrap" )}bootstrap-scrollspy.js",$type,$lang)
                    ->appendFile("{$this->diretorioMedia( "bootstrap" )}bootstrap-tab.js",$type,$lang)
                    ->appendFile("{$this->diretorioMedia( "bootstrap" )}bootstrap-tooltip.js",$type,$lang)
                    ->appendFile("{$this->diretorioMedia( "bootstrap" )}bootstrap-popover.js",$type,$lang)
                    ->appendFile("{$this->diretorioMedia( "bootstrap" )}bootstrap-button.js",$type,$lang)
                    ->appendFile("{$this->diretorioMedia( "bootstrap" )}bootstrap-collapse.js",$type,$lang)
                    ->appendFile("{$this->diretorioMedia( "bootstrap" )}bootstrap-carousel.js",$type,$lang)
                    ->appendFile("{$this->diretorioMedia( "bootstrap" )}bootstrap-typeahead.js",$type,$lang)
                    ->appendFile("{$this->diretorioMedia( "js" )}extras/php.min.js",$type,$lang)
                    ->appendFile("{$this->diretorioMedia( "js" )}application.js",$type,$lang)
                    ->appendFile("{$this->diretorioMedia( "js" )}zfx.js",$type,$lang);
        return $this;
    }
    
    protected function diretorioMedia( $strType ) 
    {
       switch ( $strType ) {
         case 'js':
           return $this->_view->baseUrl() . DS . 'media' . DS . 'js' . DS;
           break;
         case 'jquery':
           return $this->_view->baseUrl() . DS . 'media' . DS . 'js' . DS. 'jquery' . DS;
           break;
        case 'bootstrap':
           return $this->_view->baseUrl() . DS . 'media' . DS . 'js' . DS. 'bootstrap' . DS;
           break;
         case 'app':
           return $this->_view->baseUrl() . DS . 'media' . DS . 'js' . DS. 'lib' . DS. 'app' . DS;
           break;
         case 'css':
           return $this->_view->baseUrl() . DS . 'media' . DS . 'css' . DS;
           break;
         case 'img':
           return $this->_view->baseUrl() . DS . 'media' . DS . 'img' . DS;
           break;

        }
    }

}