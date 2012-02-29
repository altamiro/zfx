<?php

/**
 * 
 * encoding UTF-8
 * 
 * Arquivo que inicializa a aplicação.
 *
 *  @category  Web
 *  @package   index
 *  @author    Altamiro Rodrigues - <altamiro27@gmail.com>
 */

$DIRECTORY_SEPARATOR = DIRECTORY_SEPARATOR;
 
if ( "WINNT" == PHP_OS )
{
	$DIRECTORY_SEPARATOR = "/";
} // end iF;

// define a barra de separação de diretórios
defined( 'DS' ) 
  || define( 'DS' , $DIRECTORY_SEPARATOR );

# incluir o arquivo que tem as configurações do projeto.
require_once __DIR__ . DS . '..' . DS . 'app' . DS . 'AppKernel.php';

# inicializa objeto de configuração do projeto.
new AppKernel;