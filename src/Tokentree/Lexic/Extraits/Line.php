<?php

namespace Tokentree\Lexic\Extraits;

use Tokentree\Lexic\Lexic;

$__global__delimiter = '';

class Line extends Lexic
{
	protected function _init()
	{
        $this
            ->_addRule( 'DATE',     'string', 'DATE LABEL MONTANT' )
        ;

    }
}
