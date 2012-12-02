<?php
namespace phpmakequery\mysql;
/**
 * Criação de Subquery
 *
 * @author Guilherme Mar <guilhermemar.dev@gmail.com>
 * @version 0.1
 */
class MQSubQuery extends MQuery
{
	/**
	 * Nome do alias da subquery
	 * 
	 * @access private
	 * @var string
	 */
	private $alias = "";
	/**
	 * Adiciona campo de retorno (SELECT), ignorando a partir do segundo campo
	 * @override
	 * @param string|MQField $field Campo para SELECT
	 * @return void
	 * 
	 * @see MQuery::addField()
	 */
	public function addField ($field)
	{
		if ($this->fieldsLength() == 0) {
			parent::addField($field);
		}
	}
	/**
	 * Alias para a subquery
	 * 
	 * @access private
	 * @param string $alias valor do alias a ser usado na subquery
	 * @return void
	 */
	public function setAlias ($alias)
	{
		$this->alias = $alias;
	}
	/**
	 * (non-PHPdoc)
	 * @see MQuery::make()
	 */
	public function make ()
	{
		return "( " . parent::make() . " ) {$this->alias}"; 
	}
	
	
}