<?php

/**
 * encoding UTF-8
 * 
 * Classe que faz o routing das urls do sistema.
 * 
 *  @uses      Route
 *
 *  @category  Intrax
 *  @package   Controller
 *  @author    Altamiro Rodrigues - <altamiro27 at gmail dot com>
 */

namespace Intrax\Controller;

class Route {
  
  protected static $_instance = null;
	
	public static function getInstance()
	{
		if ( is_null( self::$_instance ) )
		{
			self::$_instance = new self();
		} # end iF.
		
		return self::$_instance;
		
	} # end method getInstance
	
	public static function getRoutes()
	{
		$arrRoutesYml = \sfYaml::load( CONFIG_PATH . 'routing.yml' );
		$routes = self::readRoutes( $arrRoutesYml );
		return $routes;
	} # end method getRoutes
	
	private static function readRoutes( $yml )
	{
		$arrDataRoutes = array();

		if ( count( $yml ) > 0 )
		{
			foreach( $yml as $key => $arrData )
			{
				$arrDataRoutes[] = array( 'route_name'	=>	$key , 
										  'url'			=>	$arrData[ 'url' ] , 
										  'route'		=>	array_merge( array( 'module'		=>	$arrData[ 'module' ] , 
										  										'controller'	=>	$arrData[ 'controller' ] , 
										  										'action'		=>	$arrData[ 'action' ] ) , 
																		 $arrData[ 'params' ] ) );
			} # end foreach
		} # end iF.
		return $arrDataRoutes;
	} # end method readRoutes
  
} # end class Route