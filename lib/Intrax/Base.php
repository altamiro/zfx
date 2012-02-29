<?php

/**
 * encoding UTF-8
 * 
 * Classe base do pacote Intrax
 * 
 * @uses        Intrax\Base
 *
 *  @category  Intrax
 *  @package   Base
 *  @author     Altamiro Rodrigues - <altamiro27 at gmail dot com>
 */

namespace Intrax;

class Base {
  
  /**
   * Exibe informacoes relacionadas a expressao. Se o segundo parametro for
   * TRUE a execucao e interrompida
   * 
   * @access  static
   * @param   MIX $mixExpression
   * @param   BOOLEAN $boolExit
   * @return  VOID
   */
  public static function debug( $mixExpression , $boolExit = FALSE ) {
    
    $arrBacktrace = debug_backtrace();
    $strMessage = "<fieldset><legend><font color=\"#007000\">debug</font></legend><pre>";
    foreach ( $arrBacktrace[ 0 ] as $strAttribute => $mixValue )
    {
        if ( ( $strAttribute != "class" ) && ( $strAttribute != "object" ) && ( $strAttribute != "args" ) )
        {
            if ( $strAttribute == "type" )
            {
                $strMessage .= "<b>" . $strAttribute . "</b> " . gettype( $mixExpression ) . "\n";
            }
            else
            {
                $strMessage .= "<b>" . $strAttribute . "</b> " . $mixValue . "\n";
            }
        }
    }
    $strMessage .= "<b>time</b> " . date( "d/m/Y H:i:s" ) . "\n";
    $strMessage .= "<hr />";	
    ob_start();
    print_r( $mixExpression );
    $strMessage .= ob_get_clean();
    $strMessage .= "</pre></fieldset>";
    print $strMessage;
    if ( $boolExit )
    {
        print "<br /><font color=\"#700000\" size=\"4\"><b>D I E</b></font>";
        die();
    }
        
  } // end method debug

  /**
   * Metodo que converte um arquivo Yml em Constante para ser usado no sistema.
   * 
   * @author     Altamiro Rodrigues - <altamiro27 at gmail dot com>
   * @access static
   * @param  STRING $strPrefixName
   * @param  STRING $strFile
   * @param  CONST  $strConstEnv
   * @return VOID
   **/
  public static function converteYmlInConst( $strPrefixName = NULL , $strFile , $strConstEnv = APPLICATION_ENV ) {
    
      $arrDados = array();
    
      $strName = $strPrefixName;

      require_once 'Zend' . DS . 'Config' . DS . 'Yaml.php';
      
      $arrConfigYml = new \Zend_Config_Yaml( $strFile , $strConstEnv );

      if ( count( $arrConfigYml->toArray() ) > 0 ) 
      {
        foreach( $arrConfigYml->toArray() as $key1 => $value1 ) {
          
          foreach( $value1 as $key2 => $value2 ) {
            
            if ( is_string( $value2 ) ) 
            {
              defined( strtoupper( $strName . $key1 . '_' . $key2 ) )
                    || define( strtoupper( $strName . $key1 . '_' . $key2 ) , $value2 );
            }
            else if ( is_array( $value2 ) ) 
            {
              foreach( $value2 as $key3 => $value3 ) 
              {
                if ( is_string( $value3 ) ) 
                {
                  defined( strtoupper( $strName . $key2 . '_' . $key3 ) )
                    || define( strtoupper( $strName . $key2 . '_' . $key3 ) , $value3 );
                }
                else if ( is_array( $value3 ) )
                {
                  foreach( $value3 as $key4 => $value4 ) 
                  {
                    if ( is_string( $value4 ) ) 
                    {
                      defined( strtoupper( $strName . $key2 . '_' . $key3 . '_' . $key4 ) )
                        || define( strtoupper( $strName . $key2 . '_' . $key3 . '_' . $key4 ) , $value4 );
                    } # end iF;
                    
                  } # end foreach $value3
                  
                } # end iF;
                
              } # end foreach $value2;
              
            } # end iF;
            
          } # end foreach $value1;
          
        } # end foreach $arrConfigYml;
        
      } # end iF;

  } // end method converteYmlInConst

  public static function arrayToDTO( array $array )
  {
    $objDTO = new \stdClass();
    
    foreach( $array as $key => $value )
    {
      $strValue = $value;
      if ( $value === 0 )
      {
        $strValue = 0;
      }
      else if ( $value == '' && $value == NULL )
      {
        $strValue = NULL;
      } # end iF.
      
      $objDTO->$key = $strValue;
    }
    
    return $objDTO;
  }
  
  public static function arrayToResult( array $arrData )
  {
    $arrRetorno = array();
    if ( count( $arrData ) > 0 )
    {
      foreach( $arrData as $strNoCampo )
      {
        $arrRetorno[ $strNoCampo ] = NULL;
      } # end foreach.
    } # end iF.
    
    return ( $arrRetorno );
    
  } # end arrayToResult
  
    
  /**
   * Aloca a memoria necessaria para execucao de certo script 
   * caso o valor requisitado seja menor que o atualmente 
   * alocado a alocacao eh ignorada
   *
   * @param INTEGER $intMemoriaMegabyte ex.: 34M ou 34
   * @return BOOLEAN
   */
  public static function alocaMemoria( $intMemoriaMegabyte )
  {
    # Tratamento dos dados
    $intMemoriaMegabyte = (integer) str_ireplace( array( "M" , "Mb" ) , "" , $intMemoriaMegabyte );
    $intMemoriaMegabyteAlocada = (integer) str_ireplace( array( "M" , "Mb" ) , "" , ini_get( "memory_limit" ) );
    if ( $intMemoriaMegabyte < $intMemoriaMegabyteAlocada ) 
    {
      ini_set( "memory_limit" , $intMemoriaMegabyte . "M" );
      return ( TRUE );
    }
    return ( FALSE );
  }
  
} // end class Intrax\Base