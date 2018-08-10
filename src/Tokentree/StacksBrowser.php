<?php

namespace TokenTree;

class StacksBrowser
{
    /**
     * array of array of string positions of tokens in each stacks in their
     * respective parsed string
     *
     * @var array 
     */
    protected $sourcePositions = [];

    /**
     * array of array of string positions of tokens in each stacks in their
     * respective summary
     *
     * @var array 
     */
    protected $summaryPositions = [];

    /**
     * Summary of each stacks
     *
     * @var array 
     */
    protected $summaries;

    /**
     * the parsed source string
     *
     * @var string
     */
    protected $source;

    /**
     * set the parsed source string
     *
     * @return \Tokentree\StacksBrowser
     */
    public function setSource( $source )
    {
        $this->source = $source;
        return $this;
    }

    /**
     * set the stacks
     *
     * @return \Tokentree\StacksBrowser
     */
    public function setStacks( $stacks )
    {
        foreach( $stacks as $stack ) {
            $this->sourcePositions[] = $stack->getSourcePosition();
            $this->summaryPositions[] = $stack->getSummaryPosition();
            $this->summaries[] = $stack->getSummary();
        }
        return $this;
    }

    public function getSourcePositions( $index )
    {
        $result = [];
        for( $i=0; $i < count( $this->sourcePositions ); $i++ ) {
            $result[] = $this->sourcePositions[$i][$index];
        }
        return $result;
    }
}
