<?php

namespace Tokentree\Lexic\Mysql;

use Tokentree\Lexic\Lexic;

class Expression extends Lexic
{
	protected function _init()
	{
		$this
			->_addRule( 'ASSIGNMENT',		'regexp',	'/^((VALUE|ALIAS|AUTO_INCREMENT) \= (VALUE|ALIAS|STRING))/' )
			->_addRule( 'ASSIGNMENT',		'regexp',	'/^((NAMES) (VALUE))/' )
			->_addRule( ';',				'string',	';' )
			->_addRule( ',',				'string',	',' )
			->_addRule( '(',				'string',	'(' )
			->_addRule( ')',				'string',	')' )
			->_addRule( 'SET_DELIMITER',	'string',	'SET_DELIMITER' )
			->_addRule( 'SET',				'string',	'SET' )
			->_addRule( 'COMMENT',			'string',	'COMMENTLINE' )
			->_addRule( 'COMMENT',			'string',	'COMMENT' )
			->_addRule( 'USE',				'string',	'USE NAME' )
			->_addRule( 'DELIMITER',		'string',	'DELIMITER' )
			->_addRule( 'ADD_COLUMN',   	'string',	'ADD_COLUMN' )
			->_addRule( 'MODIFY',        	'string',	'MODIFY' )
			->_addRule( 'ADD_KEY',        	'string',	'ADD_KEY NAME ( NAME )' )
			->_addRule( 'CREATE_TRIGGER',	'regexp',	'/^CREATE_TRIGGER\s*NAME\s*WHEN\s*ACTION\s*ON\s*NAME/' )
			->_addRule( 'ADD_CONSTRAINT',	'regexp',	'/^(ADD_CONSTRAINT\s*NAME\s*KEY\s*\(\s*NAME\s*\)\s*)/' )
			->_addRule( 'ADD_FOREIGN_KEY',	'regexp',	'/^(ADD_CONSTRAINT\s*NAME\s*FOREIGN_KEY\s*\(\s*NAME\s*\)\s*REFERENCES\s*NAME\s*\(\s*NAME\s*\)\s*(ON\s*ACTION\s*TRIGGER_ACTION\s*)*)/' )
			->_addRule( 'FOREIGN_KEY', 		'regexp',	'/^(CONSTRAINT\s*NAME\s*FOREIGN_KEY\s*\(\s*NAME\s*\)\s*REFERENCES\s*NAME\s*\(\s*NAME\s*\)\s*(ON\s*ACTION\s*TRIGGER_ACTION\s*)*)/' )
			->_addRule( 'DROP_TABLE',		'regexp',	'/^DROP_TABLE\s*NAME/' )
			->_addRule( 'CREATE_TABLE',		'regexp',	'/^CREATE_TABLE\s*NAME/' )
			->_addRule( 'ALTER_TABLE',		'regexp',	'/^ALTER_TABLE\s*NAME/' )
			->_addRule( 'INSERT_INTO',		'regexp',	'/^(INSERT_INTO\s*NAME\s*\((\s*NAME\s*\,)*\s*NAME\s*\)\s*VALUES\s*\((\s*NEW_ROW_FIELD\s*\,)*\s*NEW_ROW_FIELD\s*\))/' )
			->_addRule( 'FOR_EACH_ROW',		'string',	'FOR_EACH_ROW BEGIN' )
			->_addRule( 'IF_CONDITION',		'string',	'IF_CONDITION' )
			->_addRule( 'END_IF',			'string',	'END_IF' )
			->_addRule( 'END',				'string',	'END' )
			->_addRule( 'COLUMN',			'regexp',	'/^(NAME\s*DATATYPE\s*(CHARSET)?\s*(UNSIGNED)?\s*(NULL|NOT_NULL)?\s*(DEFAULT)?\s*(STRING|NULL|EXPRESSION|VALUE)?\s*(ON ACTION)?\s*(STRING|NULL|EXPRESSION)?\s*(AUTO_INCREMENT)?\s*(SQLCOMMENT\s*STRING)?)\s*/' )
			->_addRule( 'KEY',				'regexp',	'/^(KEY\s*(NAME)?\s*\(\s*(NAME(\s*\,\s*NAME\s*)*)\s*\)\s*(USING\s*VALUE)?)/' )
			->_addRule( 'DROP_TRIGGER',		'string',	'DROP_TRIGGER NAME' )
			->_addRule( 'DROP_COLUMN',		'string',	'DROP_COLUMN NAME' )
			->_addRule( 'DROP_FOREIGN_KEY', 'string',	'DROP_FOREIGN_KEY NAME' )
			->_addRule( 'DROP_KEY',         'string',	'DROP_KEY NAME' )
			
		;
	}
}
