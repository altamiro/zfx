<?php
/**
 * Debug com FirePHP. A intenção é apenas trocar alterar o nome da classe
 * Permite visualização de variáveis sem interromper a aplicação.
 * @param $var		var/string
 * @param $label	string
 * @param $style	string	LOG | INFO | WARN | ERROR | TRACE | EXCEPTION | TABLE | DUMP
 * $options 		array
 * @example _fb('mensagem'); _fb($var, 'label');
 * @return Conteúdo para o FIREPHP
 */
namespace Intrax;
class Debug extends \Zend_Wildfire_Plugin_FirePhp
{}