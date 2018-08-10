<?php

namespace Tokentree\Lexic\Extraits;

use Tokentree\Lexic\Lexic;

$__global__delimiter = '';

class Token extends Lexic
{
	protected function _init()
	{
        $this
            ->_addRule( 'DATE',     'regexp', '|^[0-9]{2}\/[0-9]{2}[\s\t]*|' )
            ->_addRule( 'MONTANT',  'regexp', '|^\-?\s*\d+\,\d{2}\n|' )
            ->_addRule( 'LABEL',    'regexp', '|^\s*[^\t]+\t\s*|' )
            ->_addRule( 'NIL',      'regexp', '|^[\s\t]+|' )
        ;

    }
}
