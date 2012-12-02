<?php
/**
 * Controle de exceções dos métodos do projeto
 * 
 * @author Guilherme Mar <guilhermemar.dev@gmail.com>
 * @version 0.1
 */
class MQException extends Exception
{
	/**
	 * Códigos de erros mapeados
	 * 
	 * @const
	 * @var int
	 */
	const UNMAPPED_ERROR      = 001;
	const NO_SELECT_INSERTED  = 002;
	const NO_TABLE_INSERTED   = 003;
	const NO_JOINS_INSERTED   = 004;
	const NO_WHERE_INSERTED   = 005;
	const NO_GROUPBY_INSERTED = 007;
	const NO_ORDERBY_INSERTED = 006;
	/**
	 * descrições dos erros mapeados
	 * 
	 * @static
	 * @access public
	 * @var array
	 */
	private static $MESSAGES = array(
		self::NO_SELECT_INSERTED  => "Não foi informado nenhuma valor para select",
		self::NO_TABLE_INSERTED   => "Não foi informado a tabela principal para a consulta",
		self::NO_WHERE_INSERTED   => "Não foi informado parâmetros para where",
		self::NO_JOINS_INSERTED   => "Não foi informado nenhum join",
		self::NO_WHERE_INSERTED   => "Não foi informado parâmetros para where",
		self::NO_GROUPBY_INSERTED => "Não foi informado parâmetros para group by",
		self::NO_ORDERBY_INSERTED => "Não foi informado parâmetros para order by",
		self::UNMAPPED_ERROR      => "Código de erro gerado não mapeado"
			
	);
	/**
	 * Construtora da classe
	 * 
	 * @override
	 * @param int $code código do erro ocorrido. (Recomenda usar algumas das contantes da classe)
	 * @return void
	 */
	public function __construct($code)
	{
		parent::__construct(
			self::getMappedMessage($code),
			$code
		);
	}
	/**
	 * Busca a mensagem de erro para o código informado
	 * 
	 * @param int $code código do erro
	 * @return string mensagem de erro para o código informado
	 */
	public static function getMappedMessage($code)
	{
		if (array_key_exists($code, self::$MESSAGES) ) {
			return self::$MESSAGES[$code];
		} else {
			return self::$MESSAGES[self::UNMAPPED_ERROR];
		}
	}
}
?>