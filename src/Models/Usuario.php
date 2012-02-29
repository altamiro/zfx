<?php
/**
 * encoding UTF-8
 * 
 * Model de Usuario
 * 
 *  @uses       Usuario
 *  @package    src
 *  @subpackage src.models
 *  @author     Altamiro Rodrigues - <altamiro27 at gmail dot com>
 */

namespace Models;

use Intrax\Db\Table;

class Usuario extends Table {

    public static $_instance;

    protected $_name            =   'usuario';
    protected $_primary         =   array( 'co_usuario' );
    protected $_dependentTables =   array( 'Models\Contato' );

    public static function build()
    {
        if ( !isset( self::$_instance ) )
        {
            self::$_instance = new self();
        }

        return self::$_instance;
    }

} # end class Usuario