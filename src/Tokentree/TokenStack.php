<?php

namespace Tokentree;

class TokenStack
{
    /**
     * Summary of the tokenization
     * It's the concatenation of every token type value separated with
     * a space char
     *
     * @var string
     */
    protected $summary;

	/**
	 * Stack of token
	 * 
	 * @var array[Token]
	 */
	protected $_stack;
	
	/**
	 * Any token position in the source string
	 *  
	 * @var array[integer]
	 */
	protected $tokenSourcePosition = [];

	/**
	 * Any token position in the summary string
	 *  
	 * @var array[integer]
	 */
    protected $tokenSummaryPosition = [];

	/**
	 * TokenStack in the inferior level
	 * 
	 * @var TokenStack
	 */
	protected $_inferiorStack;
	
	/**
	 * contructor
	 * 
	 * $stack : stack in the inferior level (if many level tokenization occurs)
	 * 
	 * @param TokenStack $inferior
	 */
	public function __construct( TokenStack $inferior = null )
	{
		$this->_inferiorStack = $inferior;
        $this->summary = '';
	}
	
	/**
	 * Add token in stack
	 * 
	 * @param \Tokentree\Token $token
	 * @return \Tokentree\TokenStack
	 */
	public function add( Token $token, $position )
	{
        // add in the stack
		$this->_stack[] = $token;
        // Record a new token position in the summary
        $this->tokenSummaryPosition[] = strlen( $this->summary );
        // populate the summary
        $this->summary .= "{$token->type} ";
        // Record the position of the token in the source string
		$this->tokenSourcePosition[] = $position;
		return $this;
	}

    /**
     * Return an array representing the position in the source string of each token found
     * @return array
     */
    public function getSourcePosition()
    {
        return $this->tokenSourcePosition;
    }

    /**
     * Return an array representing the position in the summary string of each token found
     * @return array
     */
    public function getSummaryPosition()
    {
        return $this->tokenSummaryPosition;
    }
	/**
	 * Return token as summary string (the <type> values are concatened)
	 *
	 * @param array[Token] $tokens
	 */
	public function summary()
	{
        return $this->summary;
	}
	
	/**
	 * Return substring from inferior level, matching to the $position in 
	 * the current level
	 * 
	 * @param integer $position
	 */
	public function getInferiorMatch( $position, $source )
	{
		if( null === $this->_inferiorStack ) {
			return array();
		}

		//$newPosition = $this->_inferiorStack->summaryToSourcePosition( $position );
		//$newPosition = $this->_inferiorStack->sourceToSummaryPosition( $position );
        $tokenIndexInSummary = $this->getMaxInferiorIndex( $this->tokenSummaryPosition, $position );
        $positionInSummary = $this->tokenSummaryPosition[$tokenIndexInSummary];
        $string = substr( $source, $position, 100 );

		//$string = $this->_inferiorStack->sourceSubstr( $newPosition, 180 ); 
		return array_merge( array( $string ), $this->_inferiorStack->getInferiorMatch($positionInSummary, $this->summary ) );
	}

    public function getSummary()
    {
        return $this->summary;
    }

    /**
     * Return the maximum value in $array that is inferior or equal to $value
     * The first found index is returned
     *
     * return -1 if not found
     *
     * @param array $array
     * @param integer $value
     *
     * @return integer
     */
    public function getMaxInferiorIndex( $array, $value )
    {
        if( 0 === count( $array ) ) {
            return -1;
        }

        for( $i=0; $i < count( $array ); $i++ ) {
            if( $array[$i] > $value ) {
                break;
                //return $i-1;
            }
        }
        return ( 0 === $i ) ? 0 : $i-1;

    }

	/**
	 * Return position from source, matching to the $position in 
	 * the current level
	 * 
	 * @param integer $position
	 */
	public function summaryToSourcePosition( $position )
    {
        $p = $this->getMaxInferiorIndex( $this->tokenSummaryPosition, $position );
        return $this->tokenSourcePosition[$p];
	}
	
	/**
     *
	 * Return position from source, matching to the $position in 
	 * the current level
	 * 
	 * @param integer $position
	 */
	public function sourceToSummaryPosition( $position )
    {
        $p = $this->getMaxInferiorIndex( $this->tokenSourcePosition, $position );
        return $this->tokenSummaryPosition[$p];
	}
	
	/**
	 * Extract a piece of source string
	 *
	 * @param integer $position
	 * @param integer $length
	 */
	public function sourceSubstr( $position, $length )
	{
        $i = $this->getMaxInferiorIndex( $this->tokenSourcePosition, $position );
		$l = 0;
		$result = '';
		while( ( strlen( $result ) < $length ) && ( $i < count( $this->_stack ) ) ){
			$result .= $this->_stack[$i++]->match . ' ';
		}
		return $result;
	}
	
	/**
	 * Return token index matching to the position in the summary
	 *
	 * @param integer $position
	 */
	public function getTokenIndexAtSummaryPosition( $position )
	{
		$i = 0;
		$l = 0;
		while( $l < $position ) {
			$l += strlen( $this->_stack[$i]->type ) + 1;
			$i++;
		}
		
		return $i-1;
	}
	
	/**
	 * shift an element 
	 * 
	 * @return \Tokentree\Token
	 */
	public function shift()
	{
		return array_shift( $this->_stack );
	}
}
