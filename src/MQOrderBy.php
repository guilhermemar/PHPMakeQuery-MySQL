<?php
namespace phpmakequery\mysql;
/**
 * Compoem o trecho Order By da clausula
 *
 * @author Guilherme Mar <guilhermemar.dev@gmail.com>
 * @version 0.1
 */
class MQOrderBy extends MQuery
{
	/**
	 * Tipos de ordenação
	 * 
	 * @const
	 * @var string
	 */
	const ASC  = "ASC",
		  DESC = "DESC";
	/**
	 * Tabela do campo para a ordem
	 * 
	 * @access private
	 * @var string
	 */
	private $table = null;
	/**
	 * Campo a ser ordenado
	 *
	 * @access private
	 * @var string
	 */
	private	$field = null;
	/**
	 * Tipo de ordenação
	 *
	 * @access private
	 * @var string
	 */
	private	$order = null;
	/**
	 * Construtora
	 * 
	 * @param string $table Tabela do campo para a ordem
	 * @param string $field Campo para a ordem
	 * @param string $order Tipo de ordenação. Recomenda-se usar uma das constatnes da classe (ASC, DESC)
	 */
	public function __construct($table, $field, $order= MQOrderBy::ASC)
	{
		$this->table = $table;
		$this->field = $field;
		$this->order = $order;
	}
	/**
	 * (non-PHPdoc)
	 * @see MQBase::make()
	 */
	public function make ()
	{
		return " {$this->table}.{$this->field} {$this->order}";
	}
}

?>