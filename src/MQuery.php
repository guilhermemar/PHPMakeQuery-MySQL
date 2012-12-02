<?php
namespace phpmakequery\mysql;
/**
 * Criação de Query
 *
 * @author Guilherme Mar <guilhermemar.dev@gmail.com>
 * @version 0.1
 */
class MQuery extends MQBase
{
	/**
	 * Tabela da query
	 * 
	 * @access private
	 * @var string
	 */
	private $table   = null;
	/**
	 * Joins da query
	 *
	 * @access private
	 * @var array<MQJoin>
	 */
	private $joins   = Array();
	/**
	 * Field da query
	 *
	 * @access private
	 * @var array<string|MQField>
	 */
	private $fields  = Array();
	/**
	 * Clausulas where da query
	 *
	 * @access private
	 * @var array<string|MQWhere>
	 */
	private $where   = Array();
	/**
	 * Field do group by
	 *
	 * @access private
	 * @var array<string|MQField>
	 */
	private $groupby = Array();
	/**
	 * Field para o order by
	 *
	 * @access private
	 * @var array<string|MQOrderBy>
	 */
	private $orderby = Array();
	/**
	 * Limit da query
	 *
	 * @access private
	 * @var array<int>
	 */
	private $limit   = Array();
	/**
	 * Informa a tabela da query
	 * 
	 * @access public
	 * @param string $name Nome da tabela
	 * @return void
	 */
	public function setTable($name)
	{
		$this->table = $name;
	}
	/**
	 * Adiciona join a query
	 *
	 * @access public
	 * @param MQJoin $join Join
	 * @return void
	 */
	public function addJoin($join)
	{
		$this->joins[] = $join;
	}
	/**
	 * Adiciona fields a query (campos que serão setornados na consulta)
	 * 
	 * @access public
	 * @param string|MQField $field campo a ser exibido na consulta
	 * @return void 
	 */
	public function addField($field)
	{
		$this->fields[] = $field;
	}
	/**
	 * Adiciona clausula where a query
	 *
	 * @access public
	 * @param string|MQWhere $where clausula where
	 * @return void
	 */
	public function addWhere($where)
	{
		$this->where[] = $where;
	}
	/**
	 * Adiciona campos para o group by
	 *
	 * @access public
	 * @param string|MQField $field campo para o group by
	 * @return void
	 */
	public function addGroupBy($field)
	{
		$this->groupby[] = $field;
	}
	/**
	 * Adiciona fields para o order by
	 *
	 * @access public
	 * @param string|MQOrderBy $orderby campo a ser adicionado no order by
	 * @return void
	 */
	public function addOrderBy($orderby)
	{
		$this->orderby[] = $orderby;
	}
	/**
	 * Informa valores para o limit da consulta
	 *
	 * @access public
	 * @param int $start linha de inicio
	 * @param int $rows quantidade de linhas a serem exibidas
	 * @return void
	 */
	public function setLimit($start, $rows)
	{
		$this->limit['start'] = $start;
		$this->limit['rows']   = $rows;
	}
	/**
	 * Monta o trecho from da query
	 * 
	 * @access private
	 * @throws MQException
	 * @return string
	 */
	private function makeFrom ()
	{
		$from = "";
		$c    = count($this->fields);
		
		if ($c == 0) {
			throw new MQException(MQException::NO_SELECT_INSERTED);
		}
		
		for ($i=0; $i<$c; $i++) {
			$from .= " {$this->fields[$i]},";
		}
		$from = substr($from, 0, -1);
		
		return $from;
	}
	/**
	 * Monta o trecho where
	 * 
	 * @access private
	 * @throws MQException
	 * @return string
	 */
	private function makeWhere ()
	{	
		$where = "";
		$c    = count($this->where);
		
		if ($c == 0) {
			throw new MQException(
				MQException::NO_WHERE_INSERTED
			);
		}
	
		for ($i=0; $i<$c; $i++) {
			$where .= " {$this->where[$i]}";
		}
		
		return $where;
	}
	/**
	 * Monta o trecho join
	 * 
	 * @access private
	 * @throws MQException
	 * @return string
	 */
	private function makeJoin ()
	{
		$joins = "";
		$c = count($this->joins);
		
		if ($c == 0) {
			throw new MQException(
				MQException::NO_JOINS_INSERTED
			);
		}
		
		for ($i=0; $i<$c; $i++) {
			$joins .= " {$this->joins[$i]}";
		}
		
		return $joins;
	}
	/**
	 * Monta o trecho group by
	 * 
	 * @access private
	 * @throws MQException
	 * @return string
	 */
	private function makeGroupBy ()
	{
		$groupby = "";
		$c       = count($this->groupby);
	
		if ($c == 0) {
			throw new MQException(MQException::NO_GROUPBY_INSERTED);
		}
	
		for ($i=0; $i<$c; $i++) {
			$groupby .= " {$this->groupby[$i]},";
		}
		$groupby = substr($groupby, 0, -1);
	
		return $groupby;
	}
	/**
	 * Monta o trecho Order By
	 * 
	 * @access private
	 * @throws MQException
	 * @return string
	 */
	private function makeOrderBy ()
	{
		$orderby = "";
		$c       = count($this->orderby);
	
		if ($c == 0) {
			throw new MQException(MQException::NO_ORDERBY_INSERTED);
		}
	
		for ($i=0; $i<$c; $i++) {
			$orderby .= " {$this->orderby[$i]},";
		}
		$orderby = substr($orderby, 0, -1);
	
		return $orderby;
	}
	/**
	 * Informa a quantidade de campos a serem exibidos na query
	 * 
	 * @access public
	 * @return number
	 */
	public function fieldsLength ()
	{
		return count($this->fields);
	}
	/**
	 * (non-PHPdoc)
	 * @see MQBase::make()
	 */
	public function make ()
	{
		$query = "SELECT";
		
		/*
		 * Montande "SELECT campos
		 */
		try {
			$query .= $this->makeFrom();
		}
		catch (MQException $e) {
			throw $e;
		}
		/*
		 * buscando FROM
		 */
		if (!$this->table) {
			throw new MQException(MQException::NO_TABLE_INSERTED);
		}
		$query .= " FROM " . $this->table;
		/*
		 * buscando joins
		 */
		if (count($this->joins) > 0) {
			$query .=  $this->makeJoin();
		}
		/*
		 * buscando where
		 */
		if (count($this->where) > 0) {
			$query .= " WHERE " . $this->makeWhere();
		}
		/*
		 * buscando groupby
		 */
		if (count($this->groupby) > 0) {
			$query .= " GROUP BY " . $this->makeGroupBy();
		}
		/*
		 * buscando order by
		 */
		if (count($this->orderby) > 0) {
			$query .= " ORDER BY " . $this->makeOrderBy();
		}
		/*
		 * buscando limit
		 */
		if (count($this->limit) == 2) {
			$query .= " LIMIT {$this->limit['start']}, {$this->limit['rows']}";
		}
		
		return $query;
	}
}
?>