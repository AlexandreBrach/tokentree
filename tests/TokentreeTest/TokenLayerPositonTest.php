<?php

namespace TokentreeTest;

use PHPUnit\Framework\TestCase;
use TokentreeTest\Provider\Command\Table\Alter;
use Tokentree\Lexic;

class TokenLayerPositionTest extends TestCase
{
    protected function setUp()
    {
        $this->alterProvider =  new Alter();
        $this->tokenizer = new \Tokentree\Tokenizer( new \Tokentree\Lexic\Mysql\Token() );
    }

    public function testPositionInSource()
    {
        $sql = $this->alterProvider->getSql( Alter::SMALL );
        $stack = $this->tokenizer->tokenize( $sql );
        $positions = $stack->getSourcePosition();
        // Mark all token position with [X] in the sql string
        $marked = '';
        for( $i=1; $i < count( $positions ); $i++ ) {
            $l = $positions[$i] - $positions[$i-1];
            $marked .= '[X]' . substr( $sql, $positions[$i-1], $l );
        }
        $l = strlen( $sql ) - $positions[$i-1];
        $marked .= '[X]' . substr( $sql, $positions[$i-1], $l );
        $expectedMarkedSql = $this->alterProvider->getMarkedWithTokenPosition( Alter::SMALL );
        $this->assertEquals( $expectedMarkedSql, $marked );
    }

    public function testMaxInferiorIndex()
    {
        $stack = new \Tokentree\Tokenstack();
        $array = [0,10,20,30,40,50,60];

        $this->assertEquals( 2, $stack->getMaxInferiorIndex( $array, 25 ) );
        $this->assertEquals( 3, $stack->getMaxInferiorIndex( $array, 30 ) );

    }

    public function testSummary()
    {
        $sql = $this->alterProvider->getSql( Alter::SMALL );
        $stack = $this->tokenizer->tokenize( $sql );
        $summary = $stack->getSummary();
        $expectedSummary = $this->alterProvider->getSummary( Alter::SMALL );
        $this->assertEquals( $expectedSummary, $summary );

        $positions = $stack->getSummaryPosition();
        // Mark all token position with [X] in the sql string
        $marked = '';
        for( $i=1; $i < count( $positions ); $i++ ) {
            $l = $positions[$i] - $positions[$i-1];
            $marked .= '[X]' . substr( $summary, $positions[$i-1], $l );
        }
        $l = strlen( $summary ) - $positions[$i-1];
        $marked .= '[X]' . substr( $summary, $positions[$i-1], $l );
        $expectedMarkedSummary = $this->alterProvider->getMarkedSummaryWithTokenPosition( Alter::SMALL );
        $this->assertEquals( $expectedMarkedSummary, $marked );
    }

    public function stringToCollapseProvider()
    {
        return [
            [
                "  \nChaine", 0,
                'Chaine',     0
            ],
            [
                "  \nChaine   Chaine2",  9,
                "  \nChaine Chaine2",   10
            ],
            [
                "  \nChaine\n\n\nChaine2",  9,
                "  \nChaine Chaine2",      10
            ]
        ];
    }

    /**
     * @dataProvider stringToCollapseProvider
     */
    public function testCollapseWhiteChars( $originalString, $startPosition, $expectedString, $expectedPosition )
    {
        $pointer = $this->tokenizer->collapseWhiteChars( $originalString, $startPosition );
        $this->assertEquals( $expectedString, $originalString );
        $this->assertEquals( $expectedPosition, $pointer );

    }
}
