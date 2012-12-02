<?php 
/* * * * * * * * * * * * * * * * * * * * * *
 * Tutorial rápido para uso do MakeQuery  *
 * * * * * * * * * * * * * * * * * * * * * */
require_once 'makeQuery.php';
/*
 * A biblioteca trabalha com namespaces, por isso é necessário importar o namespace
 */
use phpmakequery\mysql as mq;
/*
 * Instanciando classe
 */
$q = new mq\MQSelect();
/*
 * informando a tabela que será utilizada na query
 */
$q->setTable("tabela01");
/*
 * informando join
 * 
 * Ação passando por parâmetro uma instancia da classe MQJoin.
 * no terceiro parâmetro, onde contém o tipo de clausula para a junção das tabelas,
 * passou por parâmetro uma instância da classe MQWhere
 * 
 */
$q->addJoin(new mq\MQJoin(
	"tabela01",
	mq\MQJoin::INNER_JOIN,
	new mq\MQWhere(
		new mq\MQField("tabela02", "id_tabela01"),
		new mq\MQField("tabela01", "id_tabela01"),
		mq\MQWhere::EQUAL
	)
));
/*
 * informando outro join,
 * 
 * passando a clausula where como uma string
 */
$q->addJoin(new mq\MQJoin(
	"tabela03",
	mq\MQJoin::LEFT_JOIN,
	"tabela03.id_tabela01 = tabela01.id_tabela01"
));
/*
 * adicionando campos a serem exibidos
 * 
 * utilizando instância da classe MQField
 */
$q->addField(new mq\MQField("tabela01", "campo01"));
/*
 * adicionando campo a ser exibido, e itilizando alias
 * 
 * campos compostos de-ve usar aspas simples
 * 
 */
$q->addField(new mq\MQField("tabela02", "campo01", "'campo da tabela02'"));
/*
 * caso nqueira um maior controle utilize a classe MQValue no alias
 */
$q->addField(new mq\MQField("tabela02", "campo02", new mq\MQValue("outro campo da tabela02")));
/*
 * adicionando campo a ser exibido utilizando uma string comum
 */
$q->addField("tabela03.campo01");
/*
 * adicionando campo a ser exibido utilizando uma string comum com alias
*/
$q->addField("tabela03.campo01 'campo da tabela03'");
/*
 * adicionando um campo do tipo subselect.
 * 
 * primeiramente se precisa criar uma classe subquery
 */
$sq = new mq\MQSubSelect();
$sq->setTable("tabela04");
$sq->addField("campo01");
/*
 * não adianta adicionar outro, classe subquery só aceita um campo
 * irá ignorar os outros
 */
$sq->addField("campo02", '"alias do campo 2"');
/*
 * adicionando where
 * 
 * as classes não fazem validações.
 * pode-se tranquilamente citar tabelas de campos que não foram citados ainda na subquery
 */
$sq->addWhere(new mq\MQWhere(
	"tabela04.id_tabela03", 
	"tabela03.id_tabela03",
	mq\MQWhere::EQUAL
));
/*
 * adicionando alias para a subquery
 */
$sq->setAlias("subquery");
/*
 * adicionando subquery como field
 */
$q->addField($sq);
/*
 * adicionando where a classe.
 * utilizando uma instância de MQWhere
 * informando fields nos parâmetros
 */
$q->addWhere(new mq\MQWhere(
	new mq\MQField("tabela01", "campo01"),
	new mq\MQValue(1, mq\MQValue::NUMBER),
	mq\MQWhere::DIFFERENT
));
/*
 * adicionando where a classe.
 * utilizando uma instância de MQWhere
 * informando fields como string
 * 
 * A partir do segundo deve-se sempre imformar o quarto parâmetro que é o AND ou OR
 */
$q->addWhere(new mq\MQWhere(
		"tabela02.campo03",
		"'bla'",
		mq\MQWhere::EQUAL,
		mq\MQWhere::W_AND
));
/*
 * adicionando where a classe.
 *  utilizando string
 */
$q->addWhere("AND tabela03.campo05 = 'canoas'");
/*
 * adicionando where a classe.
 * utilizando uma instância de MQWhere
 * utilizando like
 */
$q->addWhere(new mq\MQWhere(
		new mq\MQField("tabela01", "campo01"),
		new mq\MQValue("%mar%"),
		mq\MQWhere::EQUAL,
		mq\MQWhere::W_AND
));
/*
 * adicionando where a classe.
 * utilizando in
 */
$q->addWhere(new mq\MQWhere(
		new mq\MQField("tabela01", "campo01"),
		array(1, 2, 3, 4),
		mq\MQWhere::IN,
		mq\MQWhere::W_AND
));
/*
 * adicionando um grupo
 */
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
/*
 * informando o parametro group by
 * utiliando field
 */
$q->addGroupBy(new mq\MQField("tabela02", "campo02"));
/*
 * inserindo order by
 */
$q->addOrderBy(new mq\MQOrderBy("tabela02", "campo01", mq\MQOrderBy::DESC));
/*
 * inserindo limit
 */
$q->setLimit(0, 30);

echo $q;

/*
 
 O retorno será algo semelhante a string abaixo:
 
 obs.: ele não entrega indentado como o que está abaixo
 
 SELECT
 	tabela01.campo01,
 	tabela02.campo01 'campo da tabela02',
 	tabela02.campo02 'outro campo da tabela02',
 	tabela03.campo01,
 	tabela03.campo01 'campo da tabela03',
 	(SELECT campo01 FROM tabela04 WHERE tabela04.id_tabela03 = tabela03.id_tabela03) subquery
 FROM
 	tabela01
 INNER JOIN
 	tabela01 ON tabela02.id_tabela01 = tabela01.id_tabela01
 LEFT JOIN
 	tabela03 ON tabela03.id_tabela01 = tabela01.id_tabela01
 WHERE
 	tabela01.campo01 != 1
 	AND tabela02.campo03 = 'bla'
 	AND tabela03.campo05 = 'canoas'
 	AND tabela01.campo01 = '%mar%'
 	AND tabela01.campo01 IN (1, 2, 3, 4)
 	AND (
 		tabela01.campo01 != 'abacate'
 		OR tabela01.campo01 NOT IN (1, 2, 3, 4)
 	)
 GROUP BY
 	tabela02.campo02
 ORDER BY
 	tabela02.campo01 DESC
 LIMIT
 	0, 30
 
 
 */


?>