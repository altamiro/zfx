<?php
/**
 * encoding UTF-8
 * 
 * Classe que recupera o log do registry e implementa os médotos
 * necessário para a escrita do log
 *
 *  @category  Intrax
 *  @package   Log
 *  @author     Altamiro Rodrigues - <altamiro27 at gmail dot com>
 */

namespace Intrax;

class Log 
{
    /**
     *
     * @var Zend_Log
     */
    protected $logger;
    
    /**
     *
     * @var Intrax\Log 
     */
    static $filelogger = null;
    
    /**
     * Construtor da classe
     * verifica se existe o resource Log configurado e recupera do registry
     * 
     * @return void
     * @throws Zend_Log_Exception
     */
    public function __construct ()
    {
        $front      = \Zend_Controller_Front::getInstance();
        $bootstrap  = $front->getParam('bootstrap');
        
        if( !$bootstrap->hasPluginResource('Log') ){
            throw new \Zend_Log_Exception('Resource Log not defined in application.');
        }
        
        $this->logger = \Zend_Registry::get('log');
    }
    
    /**
     * 
     * @return \Intrax\Log 
     */
    public static function getInstance ()
    {
        if( self::$filelogger === null ){
            self::$filelogger = new self();
        }
        return self::$filelogger;
    }
    
    /**
     * Recupera o objeto Zend_Log registrado
     * 
     * @return Zend_Log
     */
    public function getLog ()
    {
        return $this->logger;
    }
    
    /**
     * Log a message at a priority
     *
     * @param  string   $message   Message to log
     * @param  integer  $priority  Priority of message
     * @param  mixed    $extras    Extra information to log in event
     * @return void
     */
    public function log($message, $priority, $extras = null)
    {
        self::getInstance()->getLog()->log( $message, $priority, $extras );
    }

    /**
     * Log a message emergency
     * 
     * @param string $msg 
     * @return void
     */
    public function emerg ( $msg )
    {
        self::getInstance()->getLog()->emerg( $msg );
    }
    
    /**
     * Log a message alert
     * 
     * @param string $msg 
     * @return void
     */
    public function alert ( $msg )
    {
        self::getInstance()->getLog()->alert( $msg );
    }
    
    /**
     * Log a message crit
     * 
     * @param string $msg 
     * @return void
     */
    public function crit ( $msg )
    {
        self::getInstance()->getLog()->crit( $msg );
    }
    
    /**
     * Log a message error
     * 
     * @param string $msg 
     * @return void
     */
    public function err ( $msg )
    {
        self::getInstance()->getLog()->err( $msg );
    }
    
    /**
     * Log a message warning
     * 
     * @param string $msg 
     * @return void
     */
    public function warn ( $msg )
    {
        self::getInstance()->getLog()->warn( $msg );
    }
    
    /**
     * Log a message notice
     * 
     * @param string $msg 
     * @return void
     */
    public function notice ( $msg )
    {
        self::getInstance()->getLog()->notice( $msg );
    }
    
    /**
     * Log a message info
     * 
     * @param string $msg 
     * @return void
     */
    public function info ( $msg )
    {
        self::getInstance()->getLog()->info( $msg );
    }
    
    /**
     * Log a message debug
     * 
     * @param string $msg 
     * @return void
     */
    public function debug ( $msg )
    {
        self::getInstance()->getLog()->debug( $msg );
    }
}