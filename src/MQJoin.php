<?php
namespace phpmakequery\mysql;
/**
 * Cria JOIN para inserir na query
 *
 * @author Guilherme Mar <guilhermemar.dev@gmail.com>
 * @version 0.1
 */
class MQJoin extends MQuery
{
	/**
	 * Tipos de joins
	 * 
	 * @const
	 * @var string
	 */
	const INNER_JOIN = "INNER JOIN";
	const LEFT_JOIN  = "LEFT JOIN";
	const RIGHT_JOIN = "RIGHT JOIN";
	
	/**
	 * Tabela que será feito o join
	 * 
	 * @access private
	 * @var string
	 */
	private $table;
	/**
	 * Tipo de join.
	 *
	 * @access private
	 * @var string
	 */
	private $join;
	/**
	 * Clausula where que irá efetuar a condição para o join
	 *
	 * @access private
	 * @var string|MQWhere
	 */
	private $where;
	/**
	 * Construtora da classe
	 * 
	 * @access public
	 * @param string $table Tabela que irá participar do join
	 * @param string $join tipo de join. Recomenda-se utilizar umas das constantes (INNER_JOIN, LEFT_JOIN ou RIGHT_JOIN) da própria classe 
	 * @param string|MQWhere $where condição do join
	 */
	public function __construct($table, $join, $where)
	{
		$this->table = $table;
		$this->join  = $join;
		$this->where = $where;
	}
	/**
	 * (non-PHPdoc)
	 * @see MQBase::make()
	 */
	public function make () {
		return " {$this->join} {$this->table} ON {$this->where} ";
	}
}

?>