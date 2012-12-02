<?php
namespace phpmakequery\mysql;
/**
 * Campos dos elementos para o "SELECT", clausulas "WHERE" e "JOINS"
 * 
 * @author Guilherme Mar <guilhermemar.dev@gmail.com>
 * @version 0.1
 */
class MQField extends MQBase
{
	/**
	 * Tabela na qual se refere a coluna
	 * 
	 * @access private
	 * @var string
	 */
	private $table = null;
	/**
	 * Campo da tabela
	 * 
	 * @access private
	 * @var string
	 */
	private	$field = null;
	/**
	 * Alias para o campo
	 * 
	 * @access private
	 * @var string
	 */
	private	$alias = null;
	/**
	 * Construtora da classe
	 * 
	 * @access public
	 * @param string $table Tabela ao qual o campo pertence
	 * @param string $field Campo da tabela
	 * @param string $alias Opcional - Alias para o campo
	 */
	public function __construct($table, $field, $alias="")
	{
		$this->table = $table;
		$this->field = $field;
		$this->alias = $alias;
	}
	/**
	 * (non-PHPdoc)
	 * @see MQBase::make()
	 */
	public function make ()
	{
		return " {$this->table}.{$this->field} {$this->alias}";
	}
}

?>