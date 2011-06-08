<?php
if (!defined('BASE_PATH')) {
	define('BASE_PATH', realpath(dirname(__FILE__) . '/../'));
}
class Bootstrap extends Zend_Application_Bootstrap_Bootstrap
{
    protected function _initDoctype()
    {
 		$this->bootstrap('view');
        $view = $this->getResource('view');
		$view->doctype('XHTML1_STRICT');
        $view->setEncoding('UTF-8');
		$view->headMeta()->appendHttpEquiv('Content-Type', 'text/html;charset=utf-8');
		$view->addHelperPath('ZendX/JQuery/View/Helper/', 'ZendX_JQuery_View_Helper');
		$viewRenderer = Zend_Controller_Action_HelperBroker::getStaticHelper('ViewRenderer');
		$viewRenderer->setView($view);
		Zend_Controller_Action_HelperBroker::addHelper($viewRenderer);
    }
}

