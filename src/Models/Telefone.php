<?php
/**
 * encoding UTF-8
 * 
 * Model de Telefone
 * 
 *  @uses       Telefone
 *  @package    src
 *  @subpackage src.models
 *  @author     Altamiro Rodrigues - <altamiro27 at gmail dot com>
 */

namespace Models;

use Intrax\Db\Table;

class Telefone extends Table {

    public static $_instance;

    protected $_name            =   'telefone';
    protected $_primary         =   array( 'co_telefone' );
    protected $_referenceMap    =   array( 'Contato' => array( 'columns'         =>  array( 'co_contato' ) , 
                                                               'refTableClass'   =>  'Models\Contato' , 
                                                               'refColumns'      =>  array( 'co_contato' ) ) );

    public static function build()
    {
        if ( !isset( self::$_instance ) )
        {
            self::$_instance = new self();
        }

        return self::$_instance;
    }

} # end class Telefone