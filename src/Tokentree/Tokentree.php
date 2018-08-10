<?php

namespace Tokentree;

use Tokentree\Lexic\Lexic;
use Tokentree\Tokenizer;

class Tokentree
{
	/**
	 * Lexics
	 * 
	 * @var array[Lexic]
	 */
	protected $_lexics;
	
	/**
	 * Token stack
	 * @var array[TokenStack]
	 */
	protected $_tokenStacks;
	
	/**
	 * Set the parser rules (lexics)
	 * 
	 * @param Lexic $lexics
	 * @return \Tokentree\Tokentree
	 */
	public function setLexics( array $lexics )
	{
		$this->_lexics = $lexics;
		return $this;
	}
	
	/**
	 * Tree-Tokenize the given string
	 * 
	 * @param string $string
	 */
	public function tokenize( $summary )
	{
		$this->_tokenStacks = [];
		for( $i=0; $i<count( $this->_lexics ); $i++ ) {
			$stackIndex = count($this->_lexics)-$i-1;
			$tokenizer = new Tokenizer( $this->_lexics[$i] );
			$prevStack = ( 0 === $i ) ? null : $this->_tokenStacks[$stackIndex+1]; 
			$this->_tokenStacks[$stackIndex] = $tokenizer->tokenize( $summary, $prevStack );
			if( $i < count( $this->_lexics ) - 1) {
				$summary = $this->_tokenStacks[$stackIndex]->summary();
			}
		}
	}
	
	/**
	 * Dépile un tableau hierarchisé de TokenStack
	 *
	 *
	 * @param array $tokenStacks
	 */
	public function shift()
	{
		return $this->_shift( 0 );
	}
	
    /**
     * Return the stack of tokens
     *
     * @return array
     */
    public function shiftAllStack()
    {
        $result = [];
		while( null !== $t = $this->shift() ) {
            $result[] = $t;
        }
        return $result;
    }

	/**
	 * Idem que shift, mas récursivité à travers les différents niveaux
	 * 
	 * Le paramètre $n indique le niveau dans la hierarchie
	 * 
	 * @param integer $n
	 * @return NULL|Token
	 */
	protected function _shift( $n )
	{
		$token = $this->_tokenStacks[$n]->shift();
		if( null === $token ) {
			return null;
		}
		if( $n < count( $this->_tokenStacks ) - 1) {
			$token->children = array();
			$words = explode(' ', trim( $token->value ) );
			for( $i=0; $i<count( $words ); $i++ ) {
				$token->children[] = $this->_shift($n+1 );
			}
		}
		return $token;
	}

    /**
     * Return the raw layered stack of token
     *
     * @return array
     */
    public function getStacks()
    {
        return $this->_tokenStacks;
    }
}
