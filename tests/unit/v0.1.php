<?php
include  __DIR__."/../../PHPMakeQuery.php";

use phpmakequery\mysql as mq;

class makeQueryTest extends PHPUnit_Framework_TestCase
{
	
	/**
	 * Testando quando o usuário não informa os campos a serem utilizados
	 */
	public function test_01()
	{
		$q = "";
		$er = null;
		$s = new mq\MQSelect();
		
		try {
			$q = $s->make();
		}
		catch(mq\MQException $e) {
			$er = $e->getCode();
		}
				
		$this->assertEquals($er,  mq\MQException::NO_SELECT_INSERTED);
		
	}
	
	/**
	 * Testando quando o usuário não informa a tabela a ser usada
	 */
	public function test_02()
	{
		$q = "";
		$er = null;
		
		$s = new mq\MQSelect();
		$s->addField("nome");
	
		try {
			$q = $s->make();
		}
		catch(mq\MQException $e) {
			$er = $e->getCode();
		}
	
		$this->assertEquals($er,  mq\MQException::NO_TABLE_INSERTED);
	}
	
	/**
	 * testando uma query mais complexa em caso de sucesso
	 */
	public function test_success()
	{
		$expected = "SELECT  tabela01.campo01 ,  tabela02.campo01 'campo da tabela02',  tabela02.campo02  'outro campo da tabela02' , tabela03.campo01, tabela03.campo01 'campo da tabela03', ( SELECT campo01 FROM tabela04 WHERE    tabela04.id_tabela03 = tabela03.id_tabela03  ) subquery FROM tabela01  INNER JOIN tabela01 ON    tabela02.id_tabela01  =  tabela01.id_tabela01     LEFT JOIN tabela03 ON tabela03.id_tabela01 = tabela01.id_tabela01  WHERE     tabela01.campo01  !=  1    AND tabela02.campo03 = 'bla'  AND tabela03.campo05 = 'canoas'  AND  tabela01.campo01  =  '%mar%'    AND  tabela01.campo01  IN (1, 2, 3, 4)   AND (  tabela01.campo01 != 'abacate'  OR  tabela01.campo01  NOT IN (1, 2, 3, 4)  ) GROUP BY   tabela02.campo02  ORDER BY   tabela02.campo01 DESC LIMIT 0, 30";
		
		$q = new mq\MQSelect();
		$q->setTable("tabela01");
		$q->addJoin(new mq\MQJoin(
				"tabela01",
				mq\MQJoin::INNER_JOIN,
				new mq\MQWhere(
						new mq\MQField("tabela02", "id_tabela01"),
						new mq\MQField("tabela01", "id_tabela01"),
						mq\MQWhere::EQUAL
				)
		));
		$q->addJoin(new mq\MQJoin(
				"tabela03",
				mq\MQJoin::LEFT_JOIN,
				"tabela03.id_tabela01 = tabela01.id_tabela01"
		));
		$q->addField(new mq\MQField("tabela01", "campo01"));
		$q->addField(new mq\MQField("tabela02", "campo01", "'campo da tabela02'"));
		$q->addField(new mq\MQField("tabela02", "campo02", new mq\MQValue("outro campo da tabela02")));
		$q->addField("tabela03.campo01");
		$q->addField("tabela03.campo01 'campo da tabela03'");
		
		$sq = new mq\MQSubSelect();
		$sq->setTable("tabela04");
		$sq->addField("campo01");
		$sq->addField("campo02", '"alias do campo 2"');
		$sq->addWhere(new mq\MQWhere(
				"tabela04.id_tabela03",
				"tabela03.id_tabela03",
				mq\MQWhere::EQUAL
		));
		$sq->setAlias("subquery");
		
		$q->addField($sq);
		$q->addWhere(new mq\MQWhere(
				new mq\MQField("tabela01", "campo01"),
				new mq\MQValue(1, mq\MQValue::NUMBER),
				mq\MQWhere::DIFFERENT
		));
		$q->addWhere(new mq\MQWhere(
				"tabela02.campo03",
				"'bla'",
				mq\MQWhere::EQUAL,
				mq\MQWhere::W_AND
		));
		$q->addWhere("AND tabela03.campo05 = 'canoas'");
		$q->addWhere(new mq\MQWhere(
				new mq\MQField("tabela01", "campo01"),
				new mq\MQValue("%mar%"),
				mq\MQWhere::EQUAL,
				mq\MQWhere::W_AND
		));
		$q->addWhere(new mq\MQWhere(
				new mq\MQField("tabela01", "campo01"),
				array(1, 2, 3, 4),
				mq\MQWhere::IN,
				mq\MQWhere::W_AND
		));
		$q->addWhere(new mq\MQWhereGroup(
				array(
						"tabela01.campo01 != 'abacate'",
						new mq\MQWhere(
								new mq\MQField("tabela01", "campo01"),
								array(1, 2, 3, 4),
								mq\MQWhere::NOT_IN,
								mq\MQWhere::W_OR
						)
				),
				mq\MQWhereGroup::W_AND
		));
		$q->addGroupBy(new mq\MQField("tabela02", "campo02"));
		$q->addOrderBy(new mq\MQOrderBy("tabela02", "campo01", mq\MQOrderBy::DESC));
		$q->setLimit(0, 30);
		
		
		try {
			$query_string = $q->make();
		}
		catch(mq\MQException $e) {
			$erro_code = $e->getCode();
		}
	
		$this->assertEquals($query_string,  $expected);
	}
}

?>