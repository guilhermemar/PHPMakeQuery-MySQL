<?php
namespace phpmakequery\mysql;
/**
 * Base para uso das demais classe do projeto MakeQuery
 * 
 * @author Guilherme Mar <guilhermemar.dev@gmail.com>
 * @version 0.1
 */
abstract class MQuery
{
	/**
	 * Versão atual do projeto
	 * 
	 * @access public
	 * @var double
	 */
	public static $version = 0.1;
	/**
	 * Monta o trecho da query de sua responsábilidade
	 * 
	 * @abstract
	 * @access public
	 * @return string trecho de query de responsabilidade da classe
	 */
	abstract public function make ();
	/**
	 * Retorna o trecho da query de responsabilidade da classe.
	 * Classe mpagica, chamada quando se tenta acessar a classe como se ela fosse uma string
	 * 
	 * @access public
	 * @return string trecho de responsabilidade da classe
	 */
	public function __toString()
	{
		try {
			return $this->make();
		}
		catch (MQException $e) {
			return "Error to make : ({$e->getCode()}) {$e->getMessage()}";
		}
	}
}
?>