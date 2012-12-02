<?php
namespace phpmakequery\mysql;
/**
 * Clausulas where da query
 *
 * @author Guilherme Mar <guilhermemar.dev@gmail.com>
 * @version 0.1
 */
class MQWhere extends MQBase
{
	/**
	 * Tipos de comparações
	 * 
	 * @const
	 * @var string
	 */
	const EQUAL              = "=";
	const DIFFERENT          = "!=";
	const LESS_THAN          = "<";
	const GREATER_THAN       = ">";
	const LESS_THAN_EQUAL    = "<=";
	const GREATER_THAN_EQUAL = ">=";
	const LIKE               = "LIKE";
	const NOT_LIKE           = "NOT LIKE";
	const IN                 = "IN";
	const NOT_IN             = "NOT IN";
	/**
	 * Tipos de agrupamentos
	 * @var string
	 */
	const W_OR   = "OR";
	const W_AND  = "AND";
	/**
	 * Caso seja um grupo de clausulas (quando está entre parenteses) armazena nesta variável
	 * 
	 * @var MQWhereGroup
	 */
	private $where_group = null;
	/**
	 * Lado esquerdo da comparação
	 * 
	 * @var string|MQField|MQSubQuery
	 */
	private	$left        = null;
	/**
	 * Lado direito da comparação
	 *
	 * @var string|MQField|MQSubQuery
	 */
	private	$right       = null;
	/**
	 * Lado direito da comparação
	 *
	 * @var string|MQField|MQSubQuery
	 */
	private	$compare     = null;
	/**
	 * Tipo de agrupamento da clausula
	 * 
	 * @var string
	 */
	private	$type        = null;
	/**
	 * Construtora
	 * 
	 * @param string|MQField|MQSubQuery $left Lado esquerdo da comparação
	 * @param string|MQField|MQSubQuery $right Lado direito da comparação
	 * @param string $compare Tipo de comparação. Recomenda-se utilizar uma das constantes da classe para este fim
	 * @param string $type Tipo de agrupamente. Recomenda-se utilizar uma das constantes da classe para este fim
	 */
	public function __construct($left, $right, $compare, $type = "")
	{		
			$this->left    = $left;
			$this->right   = $right;
			$this->compare = $compare;
			$this->type    = $type;
	}
	/**
	 * (non-PHPdoc)
	 * @see MQBase::make()
	 */
	public function make () {
		
		switch ($this->compare) {
		case MQWhere::LIKE :
		case MQWhere::NOT_LIKE :
			return " {$this->type} {$this->left} {$this->compare} \"{$this->right}\" ";
			
		case MQWhere::IN:
		case MQWhere::NOT_IN:
			return " {$this->type} {$this->left} {$this->compare} (" . join(", ", $this->right) . ") ";
			
		default :
			return " {$this->type} {$this->left} {$this->compare} {$this->right} ";
		}
	}
}
?>