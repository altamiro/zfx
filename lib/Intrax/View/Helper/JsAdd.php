<?php
/**
 *
 * Helper responsavel por adicionar arquivo javascript na pagina de acordo com caminho passado.
 *
 * @author		Altamiro Rodrigues
 * @package		views
 * @subpackage	helpers
 */

namespace Intrax\View\Helper;

class JsAdd extends HelperAbstract {

	public function jsAdd( $strFile ) {
		echo '<script type="text/javascript" src="' . $this->view->baseUrl() . '/media/js/' . $strFile . '.js"></script>';
		echo "\n\n";
	}

}