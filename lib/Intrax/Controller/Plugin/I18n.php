<?php
/**
 * encoding UTF-8
 * 
 * Classe que registra o translate default do sistema e o translate dos módulos
 *
 *  @category  I18n
 *  @package   Intrax
 *  @subpackage Controller\Plugin
 *  @author     Altamiro Rodrigues - <altamiro27 at gmail dot com>
 */

namespace Intrax\Controller\Plugin;

class I18n extends \Zend_Controller_Plugin_Abstract
{
    /**
     *
     * @var array 
     */
    private $_supportedLangs = array();
    /**
     *
     * @var string
     */
    private $_translateLang = null;
    /**
     *
     * @var Zend_Translate
     */
    private $_translate = null;
    /**
     *
     * @var  Bootstrap
     */
    private $_bootstrap = null;
    
    /**
     * Dispacho inicial
     *
     * @param Zend_Controller_Request_Abstract $request
     * @return void
     */
    public function dispatchLoopStartup( \Zend_Controller_Request_Abstract $request)
    {
        $this->_setBootstrap()
             ->_setSupportedLang()
             ->_setTranslateLang()
             ->_addTranslateDefault()
             ->_addTranslateModule( $request )
             ->_registryTranslate();
    }
    
    /**
     * Seta o valor na var $_bootstrap
     * @return I18n 
     */
    private function _setBootstrap()
    {
        $front            = \Zend_Controller_Front::getInstance();
        $this->_bootstrap = $front->getParam('bootstrap');
        
        return $this;
    }
    
    /**
     * Seta a linguagem a ser uzada pelo Zend_Translate.
     * 
     * Caso não encontra suporte para a linguagem solicitada é definido a linguagem
     * padrão contida no Zend_Locale definida no application.yml
     * 
     * @return I18n 
     */
    private function _setTranslateLang()
    {
        if($this->_bootstrap === null){
            $this->_setBootstrap();
        }
        if(!$this->_supportedLangs){
            $this->_setSupportedLang();
        }
        $locale           = $this->_bootstrap->getResource('Locale');
        
        $arrDefaultLocale = array_flip($locale->getDefault());
		$strLocaleBrowser = $locale->getLanguage() . '_' . $locale->getRegion();
        
    	/** definindo idioma a ser exibido **/
		$this->_translateLang = (!array_search($strLocaleBrowser, $this->_supportedLangs)) ? $arrDefaultLocale[1] : $strLocaleBrowser;
        
        return $this;
    }
    
    /**
     * Seta array de linguagens suportadas pelo translate
     * 
     * @return I18n 
     */
    private function _setSupportedLang()
    {
        if($this->_bootstrap === null){
            $this->_setBootstrap();
        }
        $arrLang = $this->_bootstrap->getOption('languages');
        $this->_supportedLangs = $arrLang['supported'];
        
        return $this;
    }
    
    
    /**
     * Adiciona os translates defaults
     * 
     * @return I18n 
     */
    private function _addTranslateDefault()
    {
        if($this->_translateLang === null){
            $this->_setTranslateLang();
        }
        
        /** carregando arquivos de tradução **/
        $this->_translate = new \Zend_Translate(
            array(
                'adapter'	=>	APP_CONF_TRANSLATE_ADAPTER,
                'content'	=>	I18N_PATH,
                'locale' 	=>	$this->_translateLang,
                'tag'	 	=>	'i18n'
            )
        );
        return $this;
    }
    
    /**
     * Método responsável por carregar o translate do módulo acessado
     * 
     * @param \Zend_Controller_Request_Abstract $request
     * @return I18n 
     */
    private function _addTranslateModule( \Zend_Controller_Request_Abstract $request )
    {
        $module = $request->getModuleName();
        $content = MODULES_PATH . $module .'/i18n';
        if( file_exists( $content )){
            $tag     = 'tag_i18n_'.$module;
            
            $this->_translate->addTranslation(
                    array(
                        'content' => $content,
                        'locale'  => $this->_translateLang,
                        'tag'	  => $tag
                    )
                );
        }
        return $this;
    }
    
    /**
     * Registra o Translate no Registry
     * 
     * @return void
     * @throws Zend_Translate_Exception
     */
    private function _registryTranslate( )
    {
        if( $this->_translate === null){
            throw new \Zend_Translate_Exception('Zend_Translate object not defined in Intrax\Controller\Plugin\I18n');
        }
        \Zend_Registry::set('Zend_Translate', $this->_translate);
    }
}