<?php

namespace TokentreeTest;

use \Tokentree\Token;
use PHPUnit\Framework\TestCase;

trait TokenAssertTrait
{
    /**
     * Assert that two token are equals
     *
     */
    public function assertTokenEquals( Token $expected, Token $value, $path )
    {
        $strPath = implode( '/', $path );
        $this->assertEquals( $expected->type, $value->type, "type mismatch at [$strPath]" );
        $this->assertEquals( $expected->value, $value->value, "value mismatch at [$strPath]" );
        $this->assertEquals( $expected->match, $value->match, "match sequence mismatch at [$strPath]" );
        if( null !==  $expected->children ) {
            if( null === $value->children ) {
                // FALSE : value doesn't have expected children
                $this->assertEquals( true, false, "Missing expected children at [$strPath]" );
            } else {
                $this->assertTokenTreeEquals( $expected->children, $value->children, $path );
            }
        } elseif( null !== $value->children ) {
            // FALSE : value have unexpected children
            $this->assertEquals( true, false, "Unexpected children <{$value->children[0]->type}> at [$strPath]" );
        }
    }

    /**
     * Assert that two TokenTree instance are Equals
     *
     */
    public function assertTokenTreeEquals( $expected, $value, $path = [] )
    {
        $strPath = implode( '/', $path );
        $this->assertEquals( count( $expected ), count( $value ) , "Tokens number mismatch at [$strPath]" );
        for( $i = 0; $i < count( $expected ); $i++ ) {
            if( !isset( $value[$i] ) ) {
                $this->assertEquals( true, false, "Missing Token in stack" );
            }
            $p = $path;
            $p[] = $value[$i]->type;
            $this->assertTokenEquals( $expected[$i], $value[$i], $p );
        }
    }
}

