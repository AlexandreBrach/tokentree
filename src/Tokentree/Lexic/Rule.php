<?php

namespace Tokentree\Lexic;

use Tokentree\Token;

class Rule
{
	/**
	 * Parsing rule (regexp, string or callback)
	 * @var mixed
	 */
	protected $_rule;
	
	/**
	 * type of token that will be created
	 * 
	 * @var string
	 */
	protected $_tokenType;
	
	/**
	 * rule type ( 'regexp', 'string' or 'callback')
	 * @var string
	 */
	protected $_type;
	
	/**
	 * Constructor
	 * 
	 * tokenType : type of token returned
	 * type : rule type ('callback', 'string', 'regexp')
	 * $rule : it can be a regexp, a string or a callback
	 *  
	 * callback prototype : function( $str, $position ) 
	 * return extracted string or false if failed
	 * it can also return (if these value are dirrerents) :
	 * array containing extracted string and matched substring 
	 * 
	 * @param string $type
	 * @param mixed $rule
	 */
	public function __construct( $tokenType, $type, $rule )
	{
		$this->_tokenType = $tokenType;
		if( false === array_search( $type, ['callback', 'string', 'regexp'] ) )
		{
			throw new \Exception( "The Rule type must be either callback, string or regexp. <$type> given." );
		} 
		$this->_type = $type;
		$this->_rule = $rule;
	}
	
	/**
	 * Try to apply the rule on the $str string at the $pointer position
	 * 
	 * The hydrated token is return and the $pointer value is incremented
	 * return false if the rule doesn't apply
	 * 
	 * @param string $str
	 * @param integer $pointer
	 */
	public function apply( $str, &$pointer )
	{
		switch( $this->_type ) {
			case 'string' :
				return $this->_applyStringRule( $this->_rule, $str, $pointer );
			case 'callback' :
				return $this->_applyCallback( $this->_rule, $str, $pointer );
			case 'regexp' :
				return $this->_applyRegexpRule( $this->_rule, $str, $pointer );
							
		}
	}

	/**
	 * Try to extract the string at $pointer position
	 * 
	 * The hydrated token is return and the $pointer value is incremented
	 * return false if the string doesn't appear at $position
	 *  
	 * @param string $string
	 * @param string $subject
	 * @param integer $pointer
	 */
	protected function _applyStringRule( $string, $subject, &$pointer )
	{
		$l = strlen( $string );
		$extract = substr( $subject, $pointer, $l );
		if( 0 === strcasecmp( $extract, $string ) ) {
			$token = new Token( $this->_tokenType, $string, $extract );
			$pointer += $l;
			return $token;
		} else {
			return false;
		}
	} 
	
	/**
	 * Test the $callback method and extract the string at the position of $pointer 
	 *
	 * The hydrated token is return and the $pointer value is incremented
	 * return false if the callback return false
	 * 
	 * @param callable $callback
	 * @param string $subject
	 * @param integer $pointer
	 */
	protected function _applyCallback( $callback, $subject, &$pointer )
	{
		$result = $callback( $subject, $pointer );
		if( false === $result ) {
			return false;
		}
		if( is_string( $result )) {
			$result = array( $result, $result );
		}
		$pointer += strlen( $result[0] );
		$token = new Token( $this->_tokenType, $result[0], $result[1] );
		return $token;
	}
	
	/**
	 * Try to apply regexp on $subject
	 * 
	 * The hydrated token is return and the $pointer value is incremented
	 * return false if no matches found
	 * 
	 * @param string $regexp
	 * @param string $subject
	 * @param integer $pointer
	 */
	protected function _applyRegexpRule( $regexp, $subject, &$pointer )
	{
		$subject = substr($subject, $pointer );
		preg_match( $this->_rule, $subject, $extract );
		if( 0 == count( $extract ) ) {
			return false;
		}
		$match = ( 1 === count( $extract ) ) ? $extract[0] : $extract[1];
		
		$token = new Token( $this->_tokenType, $match, $extract[0] );
		$l = strlen( $extract[0] );
		$pointer += $l;
		return $token;
	}
	
}
