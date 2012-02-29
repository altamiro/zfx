<?php
/**
 *
 * Helper responsavel para gerar o DataGrid com padrao de layout do sistema.
 *
 * @author		Altamiro Rodrigues
 * @package		views
 * @subpackage	helpers
 */

namespace Intrax\View\Helper;

class DataGrid extends HelperAbstract {

	protected $_arrColumn		=	array();
	protected $_arrAttrColumn	=	array();

	protected $_arrRow 			=	array();
	protected $_arrAttrRow		=	array();

	protected $_arrAttrRowTr	=	array();

	protected $_arrMergeTable	=	array();
	protected $_arrAttrTable	=	array( 'style'			=> 'width:100%' ,
										   'cellspacing'	=> '0' ,
										   'cellpadding'	=> '0' ,
										   'border'			=> '0' ,
										   'class'			=> 'table' ,
                                           'id'             => 'tbDataGrid' );
	protected $thead			= array();
	protected $tbody			= array();
	protected $tfoot			= array();
	protected $row				= array();

	/**
     * Classe que retorna a instancia
     *
     * @author 	Altamiro Rodrigues
     * @access	public
     */
	public function dataGrid( $strTabelaAtributo = array() )
	{
		$this->_arrMergeTable = array_merge( $this->_arrAttrTable , $strTabelaAtributo );

		return $this;
	} # end method dataGridNova

	public function addColumn( $strName , $arrAttr = array() )
	{
		$th	= new \Intrax\Element('th');
		$th->addAttrs( $arrAttr );
		$th->setValue( $strName );
        $th->addAttr( 'class' , 'linha_th_nova_grid');
		$this->thead[] = $th->show();
	} # end method addColumn

	public function addRow( $strCampo , $arrAttr = array() )
	{
		$td	= new \Intrax\Element('td');
		$td->addAttrs( $arrAttr );
		$td->setValue( $strCampo );
        //$td->addAttr( 'style' , 'padding: 2px' );
		$this->row[] = $td->show();
	} # end method addRow

	public function setTr( $arrAttr = array() )
	{
		$tr		= new \Intrax\Element('tr');
		$tr->addAttrs( $arrAttr );
		foreach( $this->row as $valor )
		{
			$tr->setValue( $valor );
		}
		$this->row = null;
		$this->tbody[] = $tr;
	}

	/**
	 * Metodo que monta o cabeçalho da grid
	 */
	protected function compositeThead()
	{
		$thead  = new \Intrax\Element('thead');
		$tr		= new \Intrax\Element('tr');
		$tr->addAttrs( array( 'bgcolor' => '#eeeeee' , 'class' => 'linha_th_nova_grid' ) );

		if ( count( $this->thead ) > 0 )
		{
			foreach( $this->thead as $valor )
			{
				$tr->setValue( $valor );
			}
			$thead->setValue( $tr->show() );
		} # end iF.

		return $thead->show();
	}

/**
	 * Metodo que monta o corpo da grid
	 */
	protected function compositeTbody()
	{
		$tbody  = new \Intrax\Element('tbody');
		$tbody->addAttr( 'id' ,  'tbyDados' );

		if( count( $this->tbody ) > 0 )
		{
			foreach( $this->tbody as $chave=>$tr )
			{
				$strClass = ( $chave % 2 == 0 ) ? "linha_tr_body_nova_grid" : "linha_tr_body_nova_grid_old";
				$tr->addAttr( 'class' , $strClass);
				$tbody->setValue( $tr->show() );
			}
		} # end iF;

		return $tbody->show();
	}

	/**
	 * Metodo que monta o rodape da grid
	 */
	protected function compositeTfoot()
	{
		# verificando se esta setado o view partial e setando
		if( is_null( \Zend_View_Helper_PaginationControl::getDefaultViewPartial() ) )
		{
			# setando o view partial default
			\Zend_View_Helper_PaginationControl::setDefaultViewPartial( 'paginator.phtml' );
		}

		if ( $this->view->paginator instanceof \Zend_Paginator && $this->view->paginator->getTotalItemCount() > 0 )
		{
			if ( $this->view->paginator->getTotalItemCount() >= $this->view->paginator->getItemCountPerPage() )
			{
				$tfoot  = new \Intrax\Element('tfoot');
                $tfoot->addAttr( 'class' , 'novo_pagination' );
				$tr		= new \Intrax\Element('tr');
				$td     = new \Intrax\Element('td');
				$td->addAttrs( array( 'colspan' => count( $this->thead ) , 'height' => '34' , 'style' => 'padding:2px;text-align: left'  ) );
				$td->setValue( $this->view->paginationControl() );
                $tr->addAttrs( array( 'height' => '34' , 'style' => 'text-align: left'  ) );
				$tr->setValue( $td->show() );
				$tfoot->setValue( $tr->show() );
				return $tfoot->show();
			} # end iF;
		}
		else if ( count( $this->tbody ) == 0 )
		{
			$tfoot  = new \Intrax\Element('tfoot');
            $tfoot->addAttr( 'class' , 'novo_pagination' );
			$tr		= new \Intrax\Element('tr');
			$td     = new \Intrax\Element('td');
			$tr->addAttr( 'class','linha_tr_body_nova_grid_old' );
			$td->addAttrs( array( 'colspan' => count( $this->thead ) , 'height' => '34' , 'style' => 'padding:2px;text-align: center'  ) );
			$td->addAttr( 'style','text-align: center; font-weight: bold;font-size:12px;height: 34px;background-color: #ffffff;' );
            $td->setValue( 'Nenhum registro encontrado!' );
            $tr->addAttrs( array( 'height' => '34' , 'style' => 'text-align: center'  ) );
			$tr->setValue( $td->show() );
			$tfoot->setValue( $tr->show() );
			return $tfoot->show();
		} # end iF.

	} # end method tfoot

	public function show()
	{
		$table = new \Intrax\Element('table');
		$table->addAttrs( $this->_arrMergeTable );
		$table->setValue( $this->compositeThead() );

		if( count( $this->tbody ) > 0 ) 
		{
			$table->setValue( $this->compositeTbody() );
		}
		$table->setValue( $this->compositeTfoot() );

        // zerando os arrays
		$this->thead = array();
		$this->tbody = array();
        
        self::style();

		return $table->show();
	} # end method show
    
    protected function style()
    {
      $strCSS = "<style type='text/css'>
                <!--
                th {
                  font-weight: bold;
                  border-top: 1px solid #e5e5e5;
                  border-bottom: 1px solid #e5e5e5;
                }

                #novo_pagination_style  {
                border:1px solid #e5e5e5;
                padding:10px 15px;
                background-color:#eeeeee;
                }


                #novo_pagination_style a {
                color:#3B5998;
                cursor:pointer;
                text-decoration:none;
                font-family:'lucida grande',tahoma,verdana,arial,sans-serif;
                font-size:11px;
                text-align:left;
                }

                .div_pagination 
                {
                	border:1px solid #e5e5e5;
                	padding:10px 15px;
                	background-color:#eeeeee;
                }

                .linha_th_nova_grid
                {
                  background-color: #eeeeee;
                  font-size:11px;
                  padding: 4px;
                  height: 34px;
                  font-weight: bold;
                }

                .linha_tr_body_nova_grid
                {
               	  height: 34px;
                  text-align:left;
                  background-color: #ffffff;
                }
                
                tr.linha_tr_body_nova_grid:hover
                {
                  height: 34px;
                  text-align:left;
                  background-color: #fcf8e3;
                }

                .linha_tr_body_nova_grid_old
                {
                  height: 34px;
                  text-align:left;
                  background-color: #dff0d8;                  
                }
                
                tr.linha_tr_body_nova_grid_old:hover
                {
                  height: 34px;
                  text-align:left;
                  background-color: #fcf8e3;
                }
                
                .order
                {
                    background: #eeeeee url('" . $this->view->baseUrl() . "/media/img/ordenar.gif') no-repeat right;
                    cursor: hand;
                    cursor: pointer;
                    padding-right: 15px;
                }
                .orderDesc
                {
                    background: #eeeeee url('" . $this->view->baseUrl() . "/media/img/ordenar-decrescente.gif') no-repeat right;
                    cursor: hand;
                    cursor: pointer;
                    padding-right: 15px;
                }
                .orderAsc
                {
                    background: #eeeeee url('" . $this->view->baseUrl() . "/media/img/ordenar-crescente.gif') no-repeat right;
                    cursor: hand;
                    cursor: pointer;
                    padding-right: 15px;
                }

                .div-registro 
                {
                	font-family:'lucida grande',tahoma,verdana,arial,sans-serif;
                	font-size:12px;
                }

                .selectpagination
                {
                	width: 55px;
                	font-family:'lucida grande',tahoma,verdana,arial,sans-serif;
                	font-size:12px;
                	height: 24px;
                }
                
                -->
                </style>";

      echo $strCSS;
      
    }

}