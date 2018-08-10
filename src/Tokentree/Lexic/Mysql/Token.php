<?php

namespace Tokentree\Lexic\Mysql;

use Tokentree\Lexic\Lexic;

$__global__delimiter = '';

class Token extends Lexic
{
	protected function _init()
	{
		$this
			->_addRule( 'COMMENT',			'regexp',	'|^/\*(.*)\*/|' )
			->_addRule( 'COMMENTLINE',		'regexp',	'|^\#([^\n]*)|' )
			->_addRule( 'COMMENTLINE',		'regexp',	'|^--\s*([^\n]*)|' )
			->_addRule( 'STRING', 			'regexp',	'|^\'(.*)\'|' )
			->_addRule( 'STRING', 			'regexp',	'|^\"(.*)\"|' )
			->_addRule( 'VALUE',	    	'regexp', 	'|^(DEFAULT\s*CHARSET\s*)|')
			->_addRule( 'NAME', 			'regexp',	'|^`([^`]*)`|' )
			->_addRule( 'TRIGGER_ACTION',	'regexp',	'/^(CASCADE|RESTRICT|SET\s*NULL|NO\s*ACTION)/' )
			->_addRule( 'NAMES', 			'string',	'NAMES' )
			->_addRule( 'USE', 				'string',	'USE' )
			->_addRule( 'USING', 			'string',	'USING' )
			->_addRule( 'MODIFY', 			'string',	'MODIFY' )
			->_addRule( 'CREATE_TABLE',		'regexp',	'|^(CREATE\s*TABLE(\s*IF\s*NOT\s*EXISTS)?)|' )
			->_addRule( 'ALTER_TABLE',		'regexp',	'|^(ALTER\s*TABLE)|' )
			->_addRule( 'ADD_CONSTRAINT',	'regexp',	'|^(ADD\s*CONSTRAINT)|' )
			->_addRule( 'ADD_COLUMN',	    'regexp',	'|^(ADD\s*COLUMN)|' )
			->_addRule( 'DROP_COLUMN',	    'regexp',	'|^(DROP\s*COLUMN)|' )
			->_addRule( 'ADD_KEY',	        'regexp',	'/^(ADD\s*(KEY|INDEX))/' )
			->_addRule( 'DROP_KEY',	        'regexp',	'|^(DROP\s*KEY)|' )
			->_addRule( 'DROP_FOREIGN_KEY',	'regexp',	'|^(DROP\s*FOREIGN\s*KEY)|' )
			->_addRule( 'FOREIGN_KEY',		'regexp',	'|^(FOREIGN\s*KEY)|' )
			->_addRule( 'INSERT_INTO',		'regexp',	'|^(INSERT\s*INTO)|' )
			->_addRule( 'VALUES',			'string',	'VALUES' )
			->_addRule( 'FOR_EACH_ROW',		'regexp',	'|^(FOR\s*EACH\s*ROW)|' )
			->_addRule( 'REFERENCES',		'string',	'REFERENCES' )
			->_addRule( 'IF_CONDITION',		'regexp',	'|^IF\s*(.*?)\s*THEN|' )
			->_addRule( 'END_IF',			'regexp',	'|^(END\s*IF)|' )
			->_addRule( 'BEGIN',			'string',	'BEGIN' )
			->_addRule( 'END',				'string',	'END' )
			->_addRule( 'CREATE_TRIGGER',	'regexp',	'|^(CREATE\s*TRIGGER)|' )
			->_addRule( 'WHEN',				'regexp',	'/^(AFTER|BEFORE)/' )
			->_addRule( 'ACTION',			'regexp',	'/^(INSERT|UPDATE|DELETE)/' )
			->_addRule( 'ON',				'string',	'ON' )
			->_addRule( 'NEW_ROW_FIELD',	'regexp',	'|^(NEW\.\w*)|' )
			->_addRule( 'DROP_TABLE',		'regexp',	'|^DROP\s*TABLE\s*(IF\s*EXISTS)?|' )
			->_addRule( 'DROP_TRIGGER',		'regexp',	'|^DROP\s*TRIGGER\s*(IF\s*EXISTS)?|' )
			->_addRule( 'KEY',				'regexp',	'/^(PRIMARY|UNIQUE)?\s*KEY/' )
			->_addRule( 'UNSIGNED',			'string',	'UNSIGNED' )
			->_addRule( 'NOT_NULL',			'string',	'NOT NULL' )
			->_addRule( 'CONSTRAINT',		'string',	'CONSTRAINT' )
			->_addRule( 'NULL',				'string',	'NULL' )
			->_addRule( 'EXPRESSION',		'regexp',	'|^(CURRENT_TIMESTAMP)|' )
			->_addRule( 'AUTO_INCREMENT',	'string',	'AUTO_INCREMENT' )
			->_addRule( 'DEFAULT',			'string',	'DEFAULT' )
			->_addRule( 'SQLCOMMENT',		'string',	'COMMENT' )
			->_addRule( 'CHARSET',			'regexp',	'|^CHARACTER\s*SET\s*(\S*)|' )
			->_addRule( 'DATATYPE',			'regexp',	'/^(\b(int|tinyint|float|decimal|text|varchar|datetime|date|timestamp|time|point|char)\b(\s*\(\s*(\d*(\s*\,\d*)?)\s*\))?)/' )
			->_addRule( 'ALIAS', 			'regexp', 	'|^@+([a-zA-Z_0-9]+)|')
			->_addRule( '=', 				'string',	'=' )
			->_addRule( ';', 				'regexp',	'|^(\;+)|' )
			->_addRule( ',', 				'string',	',' )
			//->_addRule( 'TYPELENGTH', 		'regexp',	'|^\(\s*(\d*(\s*\,\d*)?)\s*\)|' )
			->_addRule( '(', 				'string',	'(' )
			->_addRule( ')', 				'string',	')' )
			->_addRule( 'SET_DELIMITER', 		'callback',	function( $str, $position ) use ( &$__global__delimiter ) {
				if( '' === $__global__delimiter ) {
					return;
				}
				$str = substr($str, $position );
				preg_match( '|^DELIMITER\s*([^\s]*)|', $str, $extract );
				if( 0 == count( $extract ) ) {
					return false;
				}
				$__global__delimiter = $extract[1];
				return "DELIMITER $__global__delimiter";
			})
			->_addRule( 'DELIMITER', 		'callback',	function( $str, $position ) use ( &$__global__delimiter ) {
				if( '' === $__global__delimiter ) {
					return;
				}
				$extract = substr( $str, $position, strlen( $__global__delimiter ) );
				if( $extract !== $__global__delimiter ) {
					return false;
				}
				return $__global__delimiter;
			})
			->_addRule( 'SET', 				'string',	'SET' )
			->_addRule( 'VALUE', 			'regexp', 	'|^([a-zA-Z_0-9]+)|')
		;
	}
}
