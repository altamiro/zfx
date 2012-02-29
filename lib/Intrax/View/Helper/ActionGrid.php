<?php
/**
 *
 * Helper responsavel para criar o botao de acao que vai ser usada na grid.
 *
 * @author		Altamiro Rodrigues
 * @package		views
 * @subpackage	helpers
 */

namespace Intrax\View\Helper;

class ActionGrid extends HelperAbstract {

	public function actionGrid( $arrActions = array() ) 
	{
		
		$strLi = '';

		foreach ( $arrActions as $key => $value ) 
		{
			$strLi .= '<li><a ';

			if ( isset( $value[ 'url' ] ) && $value[ 'url' ] != null )
			{
				$strLi .= 'href="' . $value[ 'url' ] . '" ';
			} // end iF;

			if ( isset( $value[ 'js' ] ) && $value[ 'js' ] != null )
			{
				$strLi .= 'href="javascript:;" onClick="' . $value[ 'js' ] . ' "';
			} // end iF;

			$strLi .= ' title="' . $value[ 'label' ] . '">';

			if ( isset( $value[ 'icon' ] ) && $value[ 'icon' ] != null )
			{
				$strLi .= '<i class="' . $value[ 'icon' ] . '"></i> ';
			} // end iF;

			$strLi .= $value[ 'label' ];

			$strLi .= '<li>';
			$strLi .= "\n";
		} // end foreach;

		$html = '<div class="btn-group">';
		$html .= '<a class="btn dropdown-toggle" data-toggle="dropdown" href="javascript:;" title="' . $this->view->translate( 'lAcao' ) . '">';
		$html .= '&nbsp;' . $this->view->translate( 'lAcao' ) . '&nbsp;';
		$html .= '<span class="caret"></span>';
		$html .= '</a>';
		$html .= '<ul class="dropdown-menu">';
		$html .= $strLi;
		$html .= '</ul>';
		$html .= '</div>';

		return $html;

	}

}