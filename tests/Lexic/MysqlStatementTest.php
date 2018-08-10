<?php

use PHPUnit\Framework\TestCase;

class MysqlStatementTest extends TestCase
{
    protected function _getMysqlTokenTokenizerInstance()
    {
        return new \Tokentree\Tokenizer( new \Tokentree\Lexic\Mysql\Statement() );
    }

    /**
     * Provide expression to resume to statement
     *
     */
    public function resumeExpressionProvider()
    {
        return [
            'alter table column changes' => [
                'ALTER_TABLE DROP_COLUMN , ADD_COLUMN COLUMN , ADD_COLUMN COLUMN',
                'ALTER_TABLE '
            ],
            'alter table key changes' => [
                'ALTER_TABLE ADD_KEY , DROP_KEY , ADD_CONSTRAINT , ADD_CONSTRAINT',
                'ALTER_TABLE '
            ],
            'alter table constraint changes' => [
                'ALTER_TABLE ADD_FOREIGN_KEY , ADD_FOREIGN_KEY',
                'ALTER_TABLE '
            ],
        ];
    }

    /**
     * Test resume MySql
     *
     * @dataProvider resumeExpressionProvider
     */
    public function testAlterTable( $expression, $expectedSummary )
    {
        $tokenizer = $this->_getMysqlTokenTokenizerInstance();
        $stack = $tokenizer->tokenize( $expression );
        $summary = $stack->summary();
        $this->assertEquals( $summary, $expectedSummary );
    }

}
