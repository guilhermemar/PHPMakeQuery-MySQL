<?php
namespace phpmakequery\mysql;
/**
 * Agrupamento de wheres em grupos (entre parenteses)
 *
 * @author Guilherme Mar <guilhermemar.dev@gmail.com>
 * @version 0.1
 */
class MQWhereGroup extends MQuery
{
	/**
	 * Tipos de agrupamentos
	 * @var string
	 */
	const W_OR   = "OR";
	const W_AND  = "AND";
	/**
	 * Clausulas where da query
	 *
	 * @access private
	 * @var array<string|MQWhere>
	 */
	private $where = Array();
	/**
	 * Tipo de agrupamento da clausula
	 *
	 * @var string
	 */
	private	$type        = null;
	/**
	 * Construtora
	 *
	 * @param array<string|MQWhere $where Clausulas where do grupo
	 * @param string $type Tipo de agrupamente. Recomenda-se utilizar uma das constantes da classe para este fim
	 */
	public function __construct($where, $type = "")
	{
		$c = count($where);
		
		if ($c > 0) {
			for ($i=0; $i<$c; ++$i) {
				$this->where[] = $where[$i];
			}
			
			$this->type = $type;
			
		}
	}
	/**
	 * Adiciona clausula where ao grupo
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
	 * (non-PHPdoc)
	 * @see MQBase::make()
	 */
	public function make ()
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
		
		return " {$this->type} ( {$where} )";
	}
}
?>