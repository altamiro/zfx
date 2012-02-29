<?php

/**
 * encoding UTF-8
 * 
 * Classe que inicia todas as configurações do projeto
 *
 *  @category  App
 *  @package   AppKernel
 *  @author     Altamiro Rodrigues - <altamiro27 at gmail dot com>
 */
class AppKernel
{

    /**
     * Método construtor da classe.
     * 
     * @access  public
     */
    public function __construct ()
    {
        self::initConstantes();
        self::isValidAmbiente();
        self::initIncludePath();
        self::initIncludeBibliotecaExterna();
        self::runApp();
    }// end method __construct

    /**
     * Método que carrega todos os arquivos que tenha constantes e que pode ser usada no projeto
     * 
     * @access  protected
     */
    protected function initConstantes ()
    {
        require_once __DIR__ . DS . 'AppConstantes.php';
    }// end method initConstantes

    /**
     * Método que incluir os diretorios na path do PHP.
     * 
     * @access  protected
     */
    protected function initIncludePath ()
    {
        $_arrIncludePath['root'] = substr( ROOT_PATH, 0, -1 );
        $_arrIncludePath['lib'] = LIBRARY_PATH;
        $_arrIncludePath['vendor'] = VENDOR_PATH;
        $_arrIncludePath['app'] = APPLICATION_PATH;
        $_arrIncludePath['src'] = SRC_PATH;
        $_arrIncludePath['models'] = MODELS_PATH;
        $_arrIncludePath['business'] = BUSINESS_PATH;
        $_arrIncludePath['modules'] = substr( MODULES_PATH, 0, -1 );
        $_arrIncludePath['path_default'] = get_include_path();
        set_include_path( implode( PATH_SEPARATOR, $_arrIncludePath ) );
        require_once 'Intrax' . DS . 'Base.php';
    } //end method initIncludePath

    /**
     * Método que incluir bibliotecas externas que fica na pasca Vendor.
     * 
     * @access  protected
     */
    protected function initIncludeBibliotecaExterna ()
    {
		require_once 'sfYaml/sfYaml.php';
    }// end method initIncludeBibliotecaExterna

    /**
     * Método que inicia a aplicação do projeto
     * 
     * @access  protected
     */
    protected function runApp()
    {
        require_once 'Zend' . DS . 'Application.php';
        try {
            
            // inicia a funcao que carrega as constantes dos arquivos yml.
            self::initYmlConstantes();

            $objApp = new Zend_Application( APPLICATION_ENV,
                            APPLICATION_PATH . DS . 'config' . DS . 'app.json' );

            $objApp->bootstrap()
                    ->run();
        } catch (Zend_Exception $e) {
            \Intrax\Base::debug( $e->getTrace(), 1 );
        } # end try/catch
    }// end method runApp
    
    /**
     * Método que carrega os arquivos Yml e gera as constantes do mesmo.
     * @author Altamiro Rodrigues - <altamiro27@gmail.com>
     * @access protected
     */
    protected function initYmlConstantes() 
    {
        \Intrax\Base::converteYmlInConst( 'APP_CONF_' , APPLICATION_PATH . DS . 'config' . DS . 'configuration.yml'  );
        \Intrax\Base::converteYmlInConst( 'DB_' , APPLICATION_PATH . DS . 'config' . DS . 'database.yml'  );
    } // end method initYmlConstantes

    /**
     * Método que verifica o ambiente e ver se tem as configurações valida para rodar o projeto.
     * 
     * @author  Altamiro Rodrigues - <altamiro27@gmail.com>
     * @access  protected
     */
    protected function isValidAmbiente ()
    {
        $arrProblemas = array();

        if (!version_compare( phpversion(), '5.3.3', '>=' )) {
            $version = phpversion();
            $arrProblemas[] = 'A vers&atilde;o executada do PHP &eacute; "<strong>' . $version . '</strong>", mais o Projeto 
                           precisa de pelo menos o PHP "<strong>5.3.3</strong>" para ser executado. 
                           Antes de executar o Projeto, instale o PHP "<strong>5.3.3</strong>" ou mais recente.';
        } # end iF;

        if (!file_exists( CACHE_PATH )) {
            $arrProblemas[] = 'Diret&oacute;rio "<strong>' . CACHE_PATH . '</strong>" 
                           n&atilde;o existe.';
        } else if (!is_writable( CACHE_PATH )) {
            $arrProblemas[] = 'Alterar as permiss&otilde;es do diret&oacute;rio "<strong>' . CACHE_PATH . '</strong>" 
                           para que o servidor web possa escrever nele.';
        } # end iF;

        if (!file_exists( LOG_PATH )) {
            $arrProblemas[] = 'Diret&oacute;rio "<strong>' . LOG_PATH . '</strong>" 
                           n&atilde;o existe.';
        } else if (!is_writable( LOG_PATH )) {
            $arrProblemas[] = 'Alterar as permiss&otilde;es do diret&oacute;rio "<strong>' . LOG_PATH . '</strong>" 
                           para que o servidor web possa escrever nele.';
        } # end iF;

        if (!file_exists( LOG_PATH . '/app.xml' ) ) {
            $arrProblemas[] = 'O Arquivo "<strong>' . LOG_PATH . '/app.xml' . '</strong>" 
                           n&atilde;o existe.';
        } else if (!is_writable( LOG_PATH . '/app.xml' )) {
            $arrProblemas[] = 'Alterar as permiss&otilde;es do diret&oacute;rio "<strong>' . LOG_PATH . '/app.xml' . '</strong>" 
                           para que o servidor web possa escrever nele.';
        } # end iF;
        
        if (count( $arrProblemas )) {

            $p = 'O seguinte problema foi detectado e <strong>deve</strong> ser corrigido antes de prosseguir:';
            $span = 'Problema encontrado';
            if (count( $arrProblemas ) > 1) {
                $p = 'Os seguintes problemas foram detectados e <strong>devem</strong> ser corrigidos antes de prosseguir:';
                $span = 'Problema(s) encontrado(s)';
            }

            $html = '<h2>';
            $html .= '<span>' . count( $arrProblemas ) . ' ' . $span . '</span>';
            $html .= '</h2>';
            $html .= '<p>' . $p . '</p>';
            $html .= '<ol>';
            foreach ($arrProblemas as $problema) {
                $html .= '<li>' . $problema . '</li>';
            } # end foreach;
            $html .= '</ol>';

            echo $html;
            die;
        } # end iF;
    }// end method isValidAmbiente

}// end class AppKernel