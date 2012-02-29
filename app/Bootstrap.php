<?php

use Intrax\Controller\Route;

/**
 * encoding UTF-8
 * 
 * Classe que inicia as configurações do Zend Framework
 *
 *  @category  App
 *  @package   Bootstrap
 *  @author     Altamiro Rodrigues - <altamiro27 at gmail dot com>
 */
class Bootstrap extends \Zend_Application_Bootstrap_Bootstrap
{

    /**
     * Função responsável por redirecionar todo erro para o módulo error.
     */
    public function _initError ()
    {
        $front = Zend_Controller_Front::getInstance();
        $front->registerPlugin( new Zend_Controller_Plugin_ErrorHandler( array(
                    'module' => 'error',
                    'controller' => 'index',
                    'action' => 'error'
                ) ) );
    }# end method _initError

    public function _initHeader ()
    {
        header( "Expires:Mon, 26 Jul 1997 05:00:00 GMT" );
        header( "Last-Modified:" . gmdate( "D, dM Y H:i:s" ) . "GMT" );
        header( "Cache-Control: no-cache, must-revalidate" );
        header( "Cache-Control: post-check=0, pre-check=0", false );
        header( "Pragma: no-cache" );
        header( "Content-type: text/html; charset=" . strtolower( APP_CONF_PARAMETERS_CHARSET ) );
        header( "Accept-Charset: " . APP_CONF_PARAMETERS_CHARSET );
        header( "Accept-Language: " . APP_CONF_PARAMETERS_LOCALE );
    }# end method _initHeader

    public function _initLog ()
    {
        if ($this->hasPluginResource( 'log' )) {
            Zend_Registry::set( 'log', $this->getPluginResource( 'log' )->getLog() );
        }
    }# end method _initLog

    public function _initCache ()
    {
        $cacheParams = $this->getOption( 'cache' );

        $cache = Zend_Cache::factory(
            $cacheParams['frontend']['name'],
            $cacheParams['backend']['name'], 
            $cacheParams['frontend']['options'], 
            $cacheParams['backend']['options']
        );
        Zend_Registry::set( 'cache' , $cache );
        Zend_Translate::setCache( $cache );
        Zend_Db_Table_Abstract::setDefaultMetadataCache( $cache );
    }# end method _initCache

    public function _initSession() 
    {
        $session = new Zend_Session_Namespace( 'Sisco' );
        Zend_Registry::set( 'session' , $session );
    } 

    public function _initDb()
    {
        $db = $this->getPluginResource( 'db' )->getDbAdapter();
        Zend_Db_Table::setDefaultAdapter( $db );
        Zend_Registry::set( 'db' , $db );
    }

    /**
	 * metodo que inicia as configuracoes das rotas que foi configuradas no arquivo config/routing.yml
	 * @author Altamiro Rodrigues
	 */
	protected function _initRoutes()
    {
    	$objRouting = Route::getInstance();
    	$arrRoutes = $objRouting->getRoutes();
    	
    	if ( count( $arrRoutes ) > 0 )
    	{
    		foreach( $arrRoutes as $item => $routeItem )
    		{
    			$route = new \Zend_Controller_Router_Route( $routeItem[ 'url' ] , $routeItem[ 'route' ] );
    			
    			$this->bootstrap('frontController');
    			$frontController = $this->getResource('frontController');
    			$frontController->getRouter()->addRoute( $routeItem[ 'route_name' ] , $route );
    		} # end iF.
    	} # end iF.
		
    } # end method _initRoutes

}# end class Bootstrap