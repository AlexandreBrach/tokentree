<?php

use PHPUnit\Framework\TestCase;

use \TokenTree\Lexic\Mysql;
use \Tokentree\Token;
use \TokentreeTest\TokenAssertTrait;
use \TokentreeTest\Provider\Command\Table\Create as CreateTableProvider;
use \TokentreeTest\Provider\Command\Table\Alter as AlterTableProvider;
use \TokentreeTest\Provider\Command\Trigger\Create as CreateTriggerProvider;

class MysqlWhiteBoxTest extends TestCase
{
    use TokenAssertTrait;

    protected function _getMysqlTokenTokenizerInstance()
    {
		$tokenTree = new \Tokentree\Tokentree();
		$tokenTree->setLexics( [ new Mysql\Token(), new Mysql\Expression(), new Mysql\Statement() ] );
        return $tokenTree;
    }


    /**
     * Provide sql command and the tree that should result from parsing
     *
     */
    public function sqlToTreeProvider()
    {
        $createTableprovider = new CreateTableProvider();
        $alterTableProvider = new AlterTableProvider();
        $createTriggerProvider = new CreateTriggerProvider();
        return [
            'create trigger' => [
                  $createTriggerProvider->getSql( CreateTriggerProvider::ADD_OBJ ),
                  $createTriggerProvider->getToken( CreateTriggerProvider::ADD_OBJ )
            ],
            'create table' => [
                  $createTableprovider->getSql( CreateTableProvider::BIDULE ),
                  $createTableprovider->getToken(CreateTableProvider::BIDULE )
            ],
            'alter table ' => [
                  $alterTableProvider->getSql( AlterTableProvider::TRUCS ),
                  $alterTableProvider->getToken( AlterTableProvider::TRUCS )
            ],
            'dump_header' => [
                "-- MySQL dump 10.13  Distrib 5.6.16-64.0, for debian-linux-gnu (x86_64)\n"
                . "--\n"
                . "-- Host: localhost    Database: ids\n"
                . "-- ------------------------------------------------------\n"
                . "-- Server version        5.6.16-64.0-553.wheezy-log\n"
                . "\n"
                . "SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT ;\n"
                . "SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS ;\n"
                . "SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 ;\n"
                . "SET NAMES utf8 ;\n"
                . "SET TIME_ZONE='+00:00' ;\n",
                [
                    new Token( 'NIL', 'COMMENT', 'COMMENT', [
                        new Token( 'COMMENT', 'COMMENTLINE', 'COMMENTLINE', [
                            new Token( 'COMMENTLINE', 'MySQL dump 10.13  Distrib 5.6.16-64.0, for debian-linux-gnu (x86_64)', '-- MySQL dump 10.13  Distrib 5.6.16-64.0, for debian-linux-gnu (x86_64)' )
                        ] )
                    ] ),
                    new Token( 'NIL', 'COMMENT', 'COMMENT', [
                        new Token( 'COMMENT', 'COMMENTLINE', 'COMMENTLINE', [
                            new Token( 'COMMENTLINE', '-- Host: localhost    Database: ids',"--\n-- Host: localhost    Database: ids" )
                        ] )
                    ] ),
                    new Token( 'NIL', 'COMMENT', 'COMMENT', [
                        new Token( 'COMMENT', 'COMMENTLINE', 'COMMENTLINE', [
                            new Token( 'COMMENTLINE', '------------------------------------------------------','-- ------------------------------------------------------' )
                        ] )
                    ] ),
                    new Token( 'NIL', 'COMMENT', 'COMMENT', [
                        new Token( 'COMMENT', 'COMMENTLINE', 'COMMENTLINE', [
                            new Token( 'COMMENTLINE', 'Server version        5.6.16-64.0-553.wheezy-log','-- Server version        5.6.16-64.0-553.wheezy-log' )
                        ] )
                    ] ),
                    new Token( 'ASSIGNMENTS', 'SET ASSIGNMENT', 'SET ASSIGNMENT', [
                        new Token( 'SET', 'SET', 'SET', [
                            new Token( 'SET', 'SET', 'SET' ),
                        ] ),
                        new Token( 'ASSIGNMENT', 'ALIAS = ALIAS', 'ALIAS = ALIAS', [
                            new Token( 'ALIAS', 'OLD_CHARACTER_SET_CLIENT', '@OLD_CHARACTER_SET_CLIENT' ),
                            new Token( '=', '=', '=' ),
                            new Token( 'ALIAS', 'CHARACTER_SET_CLIENT', '@@CHARACTER_SET_CLIENT' )
                        ] )
                    ] ),
                    new Token( 'NIL', ';', ';', [
                        new Token( ';', ';', ';', [
                            new Token( ';', ';', ';' )
                        ] )
                    ] ),
                    new Token( 'ASSIGNMENTS', 'SET ASSIGNMENT', 'SET ASSIGNMENT', [
                        new Token( 'SET', 'SET', 'SET', [
                            new Token( 'SET', 'SET', 'SET' ),
                        ] ),
                        new Token( 'ASSIGNMENT', 'ALIAS = ALIAS', 'ALIAS = ALIAS', [
                            new Token( 'ALIAS', 'OLD_CHARACTER_SET_RESULTS', '@OLD_CHARACTER_SET_RESULTS' ),
                            new Token( '=', '=', '=' ),
                            new Token( 'ALIAS', 'CHARACTER_SET_RESULTS', '@@CHARACTER_SET_RESULTS' )
                        ] )
                    ] ),
                    new Token( 'NIL', ';', ';', [
                        new Token( ';', ';', ';', [
                            new Token( ';', ';', ';' )
                        ] )
                    ] ),
                    new Token( 'ASSIGNMENTS', 'SET ASSIGNMENT , ASSIGNMENT', 'SET ASSIGNMENT , ASSIGNMENT', [
                        new Token( 'SET', 'SET', 'SET', [
                            new Token( 'SET', 'SET', 'SET' ),
                        ] ),
                        new Token( 'ASSIGNMENT', 'ALIAS = ALIAS', 'ALIAS = ALIAS', [
                            new Token( 'ALIAS', 'OLD_UNIQUE_CHECKS', '@OLD_UNIQUE_CHECKS' ),
                            new Token( '=', '=', '=' ),
                            new Token( 'ALIAS', 'UNIQUE_CHECKS', '@@UNIQUE_CHECKS' )
                        ] ),
                        new Token( ',', ',', ',', [
                            new Token( ',', ',', ',' )
                        ] ),
                        new Token( 'ASSIGNMENT', 'VALUE = VALUE', 'VALUE = VALUE', [
                            new Token( 'VALUE', 'UNIQUE_CHECKS', 'UNIQUE_CHECKS' ),
                            new Token( '=', '=', '=' ),
                            new Token( 'VALUE', '0', '0' )
                        ] ),
                    ] ),
                    new Token( 'NIL', ';', ';', [
                        new Token( ';', ';', ';', [
                            new Token( ';', ';', ';' )
                        ] )
                    ] ),
                    new Token( 'ASSIGNMENTS', 'SET ASSIGNMENT', 'SET ASSIGNMENT', [
                        new Token( 'SET', 'SET', 'SET', [
                            new Token( 'SET', 'SET', 'SET' ),
                        ] ),
                        new Token( 'ASSIGNMENT', 'NAMES VALUE', 'NAMES VALUE', [
                            new Token( 'NAMES', 'NAMES', 'NAMES' ),
                            new Token( 'VALUE', 'utf8', 'utf8' )
                        ] )
                    ] ),
                    new Token( 'NIL', ';', ';', [
                        new Token( ';', ';', ';', [
                            new Token( ';', ';', ';' )
                        ] )
                    ] ),
                    new Token( 'ASSIGNMENTS', 'SET ASSIGNMENT', 'SET ASSIGNMENT', [
                        new Token( 'SET', 'SET', 'SET', [
                            new Token( 'SET', 'SET', 'SET' ),
                        ] ),
                        new Token( 'ASSIGNMENT', 'VALUE = STRING', 'VALUE = STRING', [
                            new Token( 'VALUE', 'TIME_ZONE', 'TIME_ZONE' ),
                            new Token( '=', '=', '=' ),
                            new Token( 'STRING', '+00:00', "'+00:00'" )
                        ] )
                    ] ),
                    new Token( 'NIL', ';', ';', [
                        new Token( ';', ';', ';', [
                            new Token( ';', ';', ';' )
                        ] )
                    ] )
                ]
            ]
        ];
    }

    /**
     * Test the tokenization of some sql script
     *
     * @dataProvider sqlToTreeProvider
     */
    public function testTokenization( $sql, $expectedTokens )
    {
        $tokenizer = $this->_getMysqlTokenTokenizerInstance();
        $tokenizer->tokenize( $sql );
        $tokens = $tokenizer->shiftAllStack();
        $this->assertTokenTreeEquals( $expectedTokens, $tokens );
    }
}
