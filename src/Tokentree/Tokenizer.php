<?php

namespace Tokentree;

use Tokentree\Lexic\Lexic;
use Tokentree\Exception;

class Tokenizer
{
	/**
	 * Used lexic for tokenization
	 *
	 * @var Lexic
	 */
	protected $_lexic;

	public function __construct( Lexic $lexic )
	{
		$this->_lexic = $lexic;
	}

	/**
	 * explode $str in tokens
     * This will alter $str, collapsing invisible chars in an unique white space
	 *
	 * @param string $str
	 * @return TokenStack
	 */
	public function tokenize( &$str, TokenStack $inferior = null )
	{
		$stack = new TokenStack( $inferior );
		$pointer = $this->collapseWhiteChars( $str );
		while( $pointer < strlen( $str ) )
		{
			$previousPointer = $pointer;
			$token = $this->_lexic->extractNextToken( $str, $pointer );
			if( false === $token ) {
				$prefix = substr($str, ( $pointer < 60 ) ? 0 : $pointer - 60 , ( $pointer < 60 ) ? $pointer : 60 );
				$extract = ( strlen( trim($prefix) ) > 0 ? "BEFORE : [\"...$prefix\"] \n\"" : '"' )
					. substr($str, $pointer, 480 );
				$a = array_merge(array($extract), $stack->getInferiorMatch( $pointer, $str ) );
				$a = implode( "...\"\n----------- Previous level ----------\n\"", $a );
				throw new Exception\Token( "Cannot extract next token, parsing the string at position $pointer : \n$a...\"\n" );
			}
			$stack->add($token, $previousPointer);
			$this->collapseWhiteChars( $str, $pointer++ );
		}
		return $stack;
	}

	/**
	 * Update $str, replacing any blank chars by a unique space at
	 * $pointer position
	 *
	 * $pointer is incremented
	 *
	 * @param string $str
	 * @param integer $pointer
	 */
	public function collapseWhiteChars( &$str, $pointer = 0 )
    {
		$w = ["\n", "\r", "\t", " "];
		$p = $pointer;
		while( ( $p < strlen( $str ) &&  false !== array_search( $str[$p], $w ) ) ) {
			$p++;
		}
        if( 0 !== $pointer ) {
            $str = substr( $str, 0, $pointer ) . ' '. substr( $str, $p, strlen( $str ) );
            return $pointer+1;
        } else {
            // Begining of the string : no need to replace with an extra space
            $str = substr( $str, $p, strlen( $str ) );
            return $pointer;
        }
	}
}
