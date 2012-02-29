<?php

/**
 * encoding UTF-8
 *
 * Arquivo que cria as constantes usada no projeto.
 *
 *  @category  App
 *  @package   AppConstatens
 *  @author     Altamiro Rodrigues - <altamiro27 at gmail dot com>
 */

# define o application environment
defined( "APPLICATION_ENV" )
    || define( "APPLICATION_ENV" , ( getenv( "APPLICATION_ENV" ) ? getenv( "APPLICATION_ENV" ) : "production" ) );

# define o diretorio root(raiz) do projeto.
defined( "ROOT_PATH" )
    || define( "ROOT_PATH" , str_replace( "\\" , "/" , realpath( __DIR__ . "/../" ) . DS ) );

# define o diretorio default da aplicação
defined( "APPLICATION_PATH" )
    || define( "APPLICATION_PATH" , str_replace( "\\" , "/" , ROOT_PATH . "app" ) );

# define o diretorio default do config da aplicação.
defined( "CONFIG_PATH" )
    | define( "CONFIG_PATH" , str_replace( "\\" , "/" , APPLICATION_PATH . DS . "config" . DS ) );

# define o diretorio default do layout da aplicação.
defined( "LAYOUT_PATH" )
    | define( "LAYOUT_PATH" , str_replace( "\\" , "/" , APPLICATION_PATH . DS . "layouts" . DS . "scripts" ) );

# define o diretorio default do modules do projeto.
defined( "MODULES_PATH" )
    || define( "MODULES_PATH" , str_replace( "\\" , "/" , APPLICATION_PATH . DS . "modules" . DS ) );

# define o diretorio de linguages da aplicação.
defined( "I18N_PATH" )
    || define( "I18N_PATH" , str_replace( "\\" , "/" , APPLICATION_PATH . DS . "i18n" ) );

# define o diretorio default da src do projeto.
defined( "SRC_PATH" )
    || define( "SRC_PATH" , str_replace( "\\" , "/" , ROOT_PATH . "src" ) );

# define o diretorio default das models do projeto.
defined( "MODELS_PATH" )
    || define( "MODELS_PATH" , str_replace( "\\" , "/" , SRC_PATH . DS . "Models" ) );

# define o diretorio default das business do projeto.
defined( "BUSINESS_PATH" )
    || define( "BUSINESS_PATH" , str_replace( "\\" , "/" , SRC_PATH . DS . "Business" ) );

# define o diretorio default da lib do projeto.
defined( "LIBRARY_PATH" )
    || define( "LIBRARY_PATH" , str_replace( "\\" , "/" , ROOT_PATH . "lib" ) );

# define o diretorio default da data do projeto.
defined( "DATA_PATH" )
    || define( "DATA_PATH" , str_replace( "\\" , "/" , ROOT_PATH . "data" ) );

# define o diretorio default do Vendor do projeto.
defined( "VENDOR_PATH" )
    || define( "VENDOR_PATH" , str_replace( "\\" , "/" , LIBRARY_PATH . DS . "Vendor" ) );

# define o diretorio default da data do projeto.
defined( "WEB_PATH" )
    || define( "WEB_PATH" , str_replace( "\\" , "/" , ROOT_PATH . "web" . DS ) );

# define o diretorio default para links de arquivos js dos módulos.
defined( "JS_MODULES_PATH" )
    || define( "JS_MODULES_PATH" , str_replace( "\\" , "/" , ROOT_PATH . "web" . DS . "media" . DS . "js" . DS . "modules" . DS ) );

# define o diretorio default para links de arquivos js dos módulos.
defined( "IMG_MODULES_PATH" )
    || define( "IMG_MODULES_PATH" , str_replace( "\\" , "/" , ROOT_PATH . "web" . DS . "media" . DS . "img" . DS . "modules" . DS ) );

# define o diretorio do cache.
defined( "CACHE_PATH" )
    || define( "CACHE_PATH" , str_replace( "\\" , "/" , DATA_PATH . DS . "cache" ) );

# define o diretorio do log da aplicação.
defined( "LOG_PATH" )
    || define( "LOG_PATH" , str_replace( "\\" , "/" , DATA_PATH . DS . "log" ) );