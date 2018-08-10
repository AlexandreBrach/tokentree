<?php

namespace Tokentree\Lexic;

use Tokentree\Lexic\Rule;

abstract class Lexic
{
	/**
	 * Parsing rules for token generation
	 * @var array[Tokentree\Lexic\Rule]
	 */
	protected $_rules = array();
	
	/**
	 * constructor
	 */
	public function __construct()
	{
		$this->_init();
	}
	
	/**
	 * Class initialisation
	 *
	 * To be implemented by derived classes
	 */
	abstract protected function _init();
	
	/**
	 * Add a parsing rule for token generaion
	 * To be used in init phase
	 * 
	 * @param string $tokenType
	 * @param string $type
	 * @param mixed $rules
	 * @return \Lexic\Lexic
	 */
	protected function _addRule( $tokenType, $type, $rule )
	{
		$this->_rules[] = new Rule($tokenType, $type, $rule);
		return $this;
	}
	
	
	/**
	 * Extract next token and pull the string pointer
	 * 
	 * false is returned if no token can be applied
	 * 
	 * @param string $str
	 * @param integer $pointer
	 */
	public function extractNextToken( $str, &$pointer )
	{
		for( $i=0; $i < count( $this->_rules ); $i++ ) {
			$token = $this->_rules[$i]->apply( $str, $pointer );
			if( false !== $token ) {
				return $token;
			}
		}
		return $token;
	}
}