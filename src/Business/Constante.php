<?php
/**
 * encoding UTF-8
 *
 * Business de Constante
 * Usado para declarar as constantes que vai ser usada na Business
 *
 *  @uses       Constante
 *  @package    src
 *  @subpackage src.business
 *  @author     Altamiro Rodrigues - <altamiro27 at gmail dot com>
 */

namespace Business;

use Intrax\Business;

class Constante extends Business {

	const ATIVO				=	'A';
    const INATIVO			=	'I';
    const OK				=	'ok';
	const FALHA				=	'falha';
	const AVISO				=	'aviso';
	const SUCESSO			=	'sucess';
	const ERROR				=	'error';
	const INFO				=	'info';

}