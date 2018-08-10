<?php

namespace Tokentree;

class Token
{
	/**
	 * Type
	 * @var string
	 */
	public $type;
	
	/**
	 * Value
	 * @var string
	 */
	public $value;
	
	/**
	 * Matching substring from the source
	 * @var string
	 */
	public $match;

    /**
     * children
     *
     * @var array
     */
    public $children = null;

	public function __construct( $type, $value, $match, $children = null )
	{
		$this->type = $type;
		$this->value = $value;
		$this->match = $match;
        if( (null !== $children ) && ( !is_array( $children ) ) ) {
            throw new \Exception( "Token children must be an array, '$children' given." );
        }
        $this->children = $children;
	}
}
