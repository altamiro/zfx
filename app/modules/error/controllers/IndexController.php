<?php

use Intrax\Controller\Action;

/**
 * ErrorController for default module
 *
 * @category   Intrax
 * @package    Error
 * @subpackage Controller
 * 
 */
class Error_IndexController extends Action
{

    public function indexAction() 
    {
        if(!$this->_hasParam('error_handler')){
            $this->_helper->Redirector->gotoSimple('index', 'index', 'web');
        }
        $this->_forward( 'error' );
    }

    public function errorAction()
    {
        $errors = $this->_getParam('error_handler');
        
        switch ($errors->type) {
            case Zend_Controller_Plugin_ErrorHandler::EXCEPTION_NO_ROUTE:
            case Zend_Controller_Plugin_ErrorHandler::EXCEPTION_NO_CONTROLLER:
            case Zend_Controller_Plugin_ErrorHandler::EXCEPTION_NO_ACTION:
                // 404 error -- controller or action not found
                //$this->getResponse()->setHttpResponseCode(404);
                $this->view->message = 'Page not Found';
                $priority            = Zend_Log::NOTICE;
                break;
            default:
                // application error
                //$this->getResponse()->setHttpResponseCode(500);
                $this->view->message = 'Erro na Aplicação';
                $priority            = Zend_Log::ERR;
                break;
        }
        
        // Log exception, if logger available
        if ($log = $this->getLog()) {
            $log->log($this->view->message, $priority, $errors->exception->getMessage());
            $log->log('Request Parameters', $priority, $errors->request->getParams());
        }
        
        if( $this->_request->isXmlHttpRequest() ){
            $this->helperJsonFormat()->error($errors->exception);
        }else{
            \Intrax\Base::debug( $errors->exception->getMessage() ,1 );
            //\Intrax\Base::debug( $errors->exception->getTraceAsString() , 1 );
        }
    }

    public function getLog()
    {
        $bootstrap = $this->getInvokeArg('bootstrap');
        if (!$bootstrap->hasPluginResource('Log')) {
            return false;
        }
        return new \Intrax\Log;
    }
} # end class ErrorController