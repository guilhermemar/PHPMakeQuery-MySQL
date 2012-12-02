<?php
namespace phpmakequery\mysql;
/**
 * Funções auxiliares do MySQL
 *
 * @author Guilherme Mar <guilhermemar.dev@gmail.com>
 * @version 0.1
 */
class MQFunctions
{
	/**
	 * Insere chamada a função AVG
	 * 
	 * @static
	 * @access public
	 * @param string|MQField $field Campo a ser passado na função, sem alias
	 * @param string $alias Alias para o resultado da função
	 * @return string Chamada da função pronta para inserir na query
	 */
	public static function avg ($field, $alias="")
	{
		return " AVG({$field}) {$alias}";
	}
	/**
	 * Insere chamada a função COUNT
	 *
	 * @static
	 * @access public
	 * @param string|MQField $field Campo a ser passado na função, sem alias
	 * @param string $alias Alias para o resultado da função
	 * @return string Chamada da função pronta para inserir na query
	 */
	public static function count ($field, $alias="")
	{
		return " COUNT({$field}) {$alias}";
	}
	/**
	 * Insere chamada a função IFNULL
	 *
	 * @static
	 * @access public
	 * @param string|MQField $field Campo a ser passado na função, sem alias
	 * @param string|MQValue $default Valor para caso o campo esteja NULL
	 * @param string $alias Alias para o resultado da função
	 * @return string Chamada da função pronta para inserir na query
	 */
	public static function ifnull ($field, $default, $alias="")
	{
		return " IFNULL({$field}, {$default}) {$alias}";
	}
	/**
	 * Insere chamada a função MIN
	 *
	 * @static
	 * @access public
	 * @param string|MQField $field Campo a ser passado na função, sem alias
	 * @param string $alias Alias para o resultado da função
	 * @return string Chamada da função pronta para inserir na query
	 */
	public static function min ($field, $alias="")
	{
		return " MIN({$field}) {$alias}";
	}
	/**
	 * Insere chamada a função MAX
	 *
	 * @static
	 * @access public
	 * @param string|MQField $field Campo a ser passado na função, sem alias
	 * @param string $alias Alias para o resultado da função
	 * @return string Chamada da função pronta para inserir na query
	 */
	public static function max ($field, $alias="")
	{
		return " MAX({$field}) {$alias}";
	}
	/**
	 * Insere chamada a função SUM
	 *
	 * @static
	 * @access public
	 * @param string|MQField $field Campo a ser passado na função, sem alias
	 * @param string $alias Alias para o resultado da função
	 * @return string Chamada da função pronta para inserir na query
	 */
	public static function sum ($field, $alias="")
	{
		return " SUM({$field}) {$alias}";
	}
}
?>