<?php
/**
 *
 * Helper responsavel por formatar o telefone.
 *
 * @author		Altamiro Rodrigues
 * @package		views
 * @subpackage	helpers
 */

namespace Intrax\View\Helper;

class FormatarTelefone extends HelperAbstract {

	public function formatarTelefone( $strDDD , $strTelefone ) {
		return "(" . trim( $strDDD ) . ") " . substr( trim( $strTelefone ) , 0 , 4 ) . "-" . substr( trim( $strTelefone ) , 4 );
	}

}