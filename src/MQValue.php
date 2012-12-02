<?php
namespace phpmakequery\mysql;
/**
 * Valores para a query.
 * Utilizado para especificar o tipo de valor constante que está sendo informado
 *
 * @author Guilherme Mar <guilhermemar.dev@gmail.com>
 * @version 0.1
 */
class MQValue extends MQuery
{
	/**
	 * Tipo string
	 * 
	 * @const
	 * @var string
	 */
	const STRING = "string";
	/**
	 * Tipo number
	 * 
	 * @const
	 * @var string
	 */
	const NUMBER = "number";
	/**
	 * valor constante
	 * 
	 * @var string
	 */
	private $value  = null;
	/**
	 * Tipo do valor
	 * 
	 * var string
	 */
	private $type = null;
	/**
	 * Construtora
	 * 
	 * @access public
	 * @param string $value valor constante
	 * @param string $type tipo do valor constante. Recomenda-se utilizar as constantes da classe (STRING e NUMBER)
	 */
	public function __construct($value, $type = MQValue::STRING)
	{
		$this->value = $value;
		$this->type  = $type;
	}
	/**
	 * (non-PHPdoc)
	 * @see MQBase::make()
	 */
	public function make ()
	{
		switch ($this->type) {
		case MQValue::STRING :
			return " '{$this->value}' ";

		case MQValue::NUMBER :
		default :
			return " {$this->value} ";
		}
	}
}

?>