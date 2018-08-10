<?php

require_once __DIR__ . '/vendor/autoload.php';

use Tokentree\Lexic;

use Tokentree\Tokentree;

$sql = file_get_contents( $argv[1] );

$tokenTree = new Tokentree();

$tokenTree->setLexics( [ new Lexic\Mysql\Token(), new Lexic\Mysql\Expression(), new Lexic\Mysql\Statement() ] )
	->tokenize( $sql );

while( null !== $t = $tokenTree->shift() ) {
	print_r( $t );
}
