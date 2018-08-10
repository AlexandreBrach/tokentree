<?php

use PHPUnit\Framework\TestCase;

class TokenTest extends TestCase
{
    public function testConstruct()
    {
        $t = new \Tokentree\Token( 'monType', 'token', 'chaine contenant le token');

        $this->assertEquals( $t->type, 'monType' );
        $this->assertEquals( $t->value, 'token' );
        $this->assertEquals( $t->match, 'chaine contenant le token' );
    }

}

