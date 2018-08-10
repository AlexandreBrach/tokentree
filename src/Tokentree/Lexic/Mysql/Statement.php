<?php

namespace Tokentree\Lexic\Mysql;

use Tokentree\Lexic\Lexic;

class Statement extends Lexic
{
	protected function _init()
	{
		$this
			->_addRule( 'ASSIGNMENTS',		'regexp',	'/^(SET (ASSIGNMENT)( \, ASSIGNMENT)*)/' )
			->_addRule( 'ATTRIB',   		'string',	'ASSIGNMENT' )
			->_addRule( 'NIL',				'string',	';' )
			->_addRule( 'NIL',				'string',	'COMMENT' )
			->_addRule( 'NIL',				'string',	'USE' )
			->_addRule( 'CREATE_TRIGGER',	'regexp',	'/^(SET_DELIMITER\s*CREATE_TRIGGER((?!DELIMITER).)*DELIMITER)/' )
			->_addRule( 'SET_DELIMITER',	'string',	'SET_DELIMITER' )
			->_addRule( 'DELIMITER',		'string',	'DELIMITER' )
			->_addRule( 'CREATE_TABLE',		'regexp',	'/^(CREATE_TABLE\s*\(\s*COLUMN(\s*\,\s*(COLUMN|KEY|FOREIGN_KEY))*\s*\)(\s*ASSIGNMENT)*)/' )
			->_addRule( 'DROP_TRIGGER',		'string',	'DROP_TRIGGER' )
			->_addRule( 'DROP_TABLE',		'string',	'DROP_TABLE' )
			->_addRule( 'ALTER_TABLE',		'regexp',	'/^(ALTER_TABLE\s*(ADD_FOREIGN_KEY|DROP_FOREIGN_KEY|ADD_CONSTRAINT|ADD_COLUMN COLUMN|DROP_COLUMN|ADD_KEY|DROP_KEY|MODIFY COLUMN)(\s*\,\s*(ADD_FOREIGN_KEY|DROP_FOREIGN_KEY|ADD_CONSTRAINT|ADD_COLUMN COLUMN|DROP_COLUMN|ADD_KEY|DROP_KEY|MODIFY COLUMN)\s*)*)/' )
			;
		;
	}
}
