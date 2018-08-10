<?php

use PHPUnit\Framework\TestCase;

class MysqlTokenTest extends TestCase
{
    protected function _getMysqlTokenTokenizerInstance()
    {
        return new \Tokentree\Tokenizer( new \Tokentree\Lexic\Mysql\Token() );
    }

    /**
     * Provide sql command to resume
     *
     */
    public function resumeSqlProvider()
    {
        return [
            'alter table constraint' => [
                'ALTER TABLE `account`'
                    . ' ADD CONSTRAINT `account_ibfk_1` FOREIGN KEY (`id_truc`) REFERENCES `track` (`id`) ON DELETE CASCADE,'
                    . ' ADD CONSTRAINT `account_ibfk_2` FOREIGN KEY (`id_country`) REFERENCES `location_country` (`id`) ON DELETE CASCADE;',
                'ALTER_TABLE NAME ADD_CONSTRAINT NAME FOREIGN_KEY ( NAME ) REFERENCES NAME ( NAME ) ON ACTION TRIGGER_ACTION ,'
                    . ' ADD_CONSTRAINT NAME FOREIGN_KEY ( NAME ) REFERENCES NAME ( NAME ) ON ACTION TRIGGER_ACTION ; '
            ],
            'alter table constraint 2' => [
                'ALTER TABLE `account`'
                    . ' ADD CONSTRAINT `account_ibfk_1` FOREIGN KEY (`id_truc`) REFERENCES `track` (`id`) ;',
                'ALTER_TABLE NAME ADD_CONSTRAINT NAME FOREIGN_KEY ( NAME ) REFERENCES NAME ( NAME ) ; '
            ],
            'alter name tutti frutti' => [
                'ALTER TABLE `bibule` ADD COLUMN `id_truc` int(8) UNSIGNED DEFAULT NULL,'
             	. 'ADD CONSTRAINT `id_truc` KEY (`id_truc`),'
                . 'ADD CONSTRAINT `appointment_id_lot` FOREIGN KEY ( `id_truc` ) REFERENCES `lot` ( `id` ) ON DELETE SET NULL;',
                'ALTER_TABLE NAME ADD_COLUMN NAME DATATYPE UNSIGNED DEFAULT NULL , '
                . 'ADD_CONSTRAINT NAME KEY ( NAME ) , '
                . 'ADD_CONSTRAINT NAME FOREIGN_KEY ( NAME ) REFERENCES NAME ( NAME ) ON ACTION TRIGGER_ACTION ; '
            ],
            'alter table drop' => [
                'ALTER TABLE `blabla`'
                    . ' DROP KEY `key`,'
                    . ' DROP COLUMN `column`,'
                    . ' DROP FOREIGN KEY `fk`',
                'ALTER_TABLE NAME DROP_KEY NAME , DROP_COLUMN NAME , DROP_FOREIGN_KEY NAME '
            ],
            'alter table add' => [
                'ALTER TABLE `blabla`'
                    . " ADD INDEX `myIndex` ( `myCOlumn`) "
                    . " ADD COLUMN `col` char(40) NOT NULL DEFAULT '0'",
                'ALTER_TABLE NAME ADD_KEY NAME ( NAME ) ADD_COLUMN NAME DATATYPE NOT_NULL DEFAULT STRING '
            ]
        ];
    }

    /**
     * Test resume MySql
     *
     * @dataProvider resumeSqlProvider
     */
    public function testAlterTable( $sql, $expectedSummary )
    {
        $tokenizer = $this->_getMysqlTokenTokenizerInstance();
        $stack = $tokenizer->tokenize( $sql );
        $summary = $stack->summary();
        $this->assertEquals( $expectedSummary, $summary );
    }

    public function testCreateTable()
    {
        $tokenizer = $this->_getMysqlTokenTokenizerInstance();

        // Test ALTER TABLE parsing
        $sql = 'CREATE TABLE `account` ('
            . '`id` int(8) unsigned NOT NULL AUTO_INCREMENT,'
            . ' `id_machin` int(8) DEFAULT NULL,'
            . ' `id_truc` int(8) NOT NULL,'
            . '  PRIMARY KEY (`id`),'
            . ' KEY `keyName` (`column`) USING BTREE,'
            . '  CONSTRAINT `account_ibfk_2` FOREIGN KEY (`id_country`) REFERENCES `location_country` (`id`),'
            . '  CONSTRAINT `account_ibfk_3` FOREIGN KEY (`id_machin`) REFERENCES `account_profession` (`id`) ON DELETE CASCADE'
            . ') AUTO_INCREMENT=10 DEFAULT CHARSET=utf8;';

        $stack = $tokenizer->tokenize( $sql );
        $summary = $stack->summary();
        $alterStatement = 'CREATE_TABLE NAME ( '
            . 'NAME DATATYPE UNSIGNED NOT_NULL AUTO_INCREMENT , '
            . 'NAME DATATYPE DEFAULT NULL , '
            . 'NAME DATATYPE NOT_NULL , '
            . 'KEY ( NAME ) , '
            . 'KEY NAME ( NAME ) USING VALUE , '
            . 'CONSTRAINT NAME FOREIGN_KEY ( NAME ) REFERENCES NAME ( NAME ) , '
            . 'CONSTRAINT NAME FOREIGN_KEY ( NAME ) REFERENCES NAME ( NAME ) ON ACTION TRIGGER_ACTION ) '
            . 'AUTO_INCREMENT = VALUE VALUE = VALUE ; ';
        $this->assertEquals( $summary, $alterStatement );
    }

    public function testCreateTrigger()
    {
        $tokenizer = $this->_getMysqlTokenTokenizerInstance();

        $sql =
            'DELIMITER ;; '
            . 'CREATE TRIGGER  `my_trigger` '
            . 'AFTER INSERT ON `bibule` '
            . 'FOR EACH ROW '
            . 'BEGIN '
            . 'IF NEW.state IS NOT NULL THEN '
            . 'INSERT INTO `state` (`id_bidule`,`state`,`id_user`) VALUES (NEW.id,NEW.state,NEW.id_user); '
            . 'END IF; '
            . 'END ;;'
            . 'DELIMITER ;';
        $stack = $tokenizer->tokenize( $sql );
        $summary = $stack->summary();
        $alterStatement = 'SET_DELIMITER CREATE_TRIGGER NAME WHEN ACTION ON NAME FOR_EACH_ROW BEGIN IF_CONDITION INSERT_INTO NAME ( NAME , NAME , NAME ) VALUES ( NEW_ROW_FIELD , NEW_ROW_FIELD , NEW_ROW_FIELD ) ; END_IF ; END ; SET_DELIMITER ';
        $this->assertEquals( $alterStatement, $summary );
    }
}
