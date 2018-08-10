<?php

use PHPUnit\Framework\TestCase;

class MysqlExpressionTest extends TestCase
{
    protected function _getMysqlTokenTokenizerInstance()
    {
        return new \Tokentree\Tokenizer( new \Tokentree\Lexic\Mysql\Expression() );
    }

    /**
     * Provide some alter table statement to resume
     *
     */
    public function alterTableStatementProvider()
    {
        return [
            'alter table add contraints 1 trigger' => [
                'ALTER_TABLE NAME ADD_CONSTRAINT NAME FOREIGN_KEY ( NAME ) REFERENCES NAME ( NAME ) ON ACTION TRIGGER_ACTION ',
                'ALTER_TABLE ADD_FOREIGN_KEY '
            ],
           'alter table add contraints 2 triggers' => [
                'ALTER_TABLE NAME ADD_CONSTRAINT NAME FOREIGN_KEY ( NAME ) REFERENCES NAME ( NAME ) ON ACTION TRIGGER_ACTION ON ACTION TRIGGER_ACTION',
                'ALTER_TABLE ADD_FOREIGN_KEY '
            ],
            'alter table tutti frutti'=> [
                'ALTER_TABLE NAME ADD_COLUMN NAME DATATYPE ADD_CONSTRAINT NAME FOREIGN_KEY ( NAME ) REFERENCES NAME ( NAME )',
                'ALTER_TABLE ADD_COLUMN COLUMN ADD_FOREIGN_KEY '
            ]
        ];
    }

    /**
     * Tests altertalbe statement rewrite
     *
     * @dataProvider alterTAbleStatementPRovider
     */
    public function testAlterTable( $source, $summary )
    {
        $tokenizer = $this->_getMysqlTokenTokenizerInstance();

        // Test ALTER TABLE Expression

        $stack = $tokenizer->tokenize( $source );
        $s = $stack->summary();
        $this->assertEquals( $summary, $s );
    }

    public function testCreateTable()
    {
        $tokenizer = $this->_getMysqlTokenTokenizerInstance();

        // TEST CREATE TABLE Expression
        $statements = array(
              'CREATE_TABLE NAME ( '
            . 'NAME DATATYPE UNSIGNED NOT_NULL AUTO_INCREMENT , '
            . 'NAME DATATYPE DEFAULT NULL , '
            . 'NAME DATATYPE NOT_NULL , '
            . 'NAME DATATYPE NULL DEFAULT NULL , '
            . 'KEY ( NAME ) , '
            . 'KEY NAME ( NAME ) USING VALUE , '
            . 'CONSTRAINT NAME FOREIGN_KEY ( NAME ) REFERENCES NAME ( NAME ) , '
            . 'CONSTRAINT NAME FOREIGN_KEY ( NAME ) REFERENCES NAME ( NAME ) ON ACTION TRIGGER_ACTION ) '
            . 'VALUE = VALUE VALUE = VALUE ; ' =>

            'CREATE_TABLE ( COLUMN , COLUMN , COLUMN , COLUMN , KEY , KEY , FOREIGN_KEY , FOREIGN_KEY ) ASSIGNMENT ASSIGNMENT ; ');

        foreach( $statements as $source => $summary ) {
            $stack = $tokenizer->tokenize( $source );
            $s = $stack->summary();
            $this->assertEquals( $summary, $s );
        }
     }
}
