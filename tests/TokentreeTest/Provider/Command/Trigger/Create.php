<?php

namespace TokentreeTest\Provider\Command\Trigger;

use \Tokentree\Token;

class Create
{
    const ADD_OBJ = 1;

    protected $list;

    public function __construct()
    {
        $this->list = [
            self::ADD_OBJ => 'add obj'
        ];
    }

    public function getSql( $name )
    {
        switch( $name ) {
            case self::ADD_OBJ :
                return 'DELIMITER ;; '
                . 'CREATE TRIGGER `myTrigger` '
                . 'AFTER INSERT ON `obj` '
                . 'FOR EACH ROW '
                . 'BEGIN '
                . 'IF NEW.state IS NOT NULL THEN '
                . 'INSERT INTO `obj_state` (`id_obj`,`state`) VALUES (NEW.id,NEW.state); '
                . 'END IF; '
                . 'END ;;'
                . 'DELIMITER ;';
        }
    }

    public function getToken( $name )
    {
        switch( $name ) {
            case self::ADD_OBJ : return [
                new Token (
                    'CREATE_TRIGGER',
                    'SET_DELIMITER CREATE_TRIGGER FOR_EACH_ROW IF_CONDITION INSERT_INTO ; END_IF ; END ; SET_DELIMITER',
                    'SET_DELIMITER CREATE_TRIGGER FOR_EACH_ROW IF_CONDITION INSERT_INTO ; END_IF ; END ; SET_DELIMITER',
                   [
                       new Token( 'SET_DELIMITER',  'SET_DELIMITER', 'SET_DELIMITER', [
                           new Token( 'SET_DELIMITER',  'DELIMITER ;;', 'DELIMITER ;;' )
                       ] ),
                       new Token( 'CREATE_TRIGGER',  'CREATE_TRIGGER NAME WHEN ACTION ON NAME', 'CREATE_TRIGGER NAME WHEN ACTION ON NAME', [
                           new Token( 'CREATE_TRIGGER', 'CREATE TRIGGER', 'CREATE TRIGGER' ),
                           new Token( 'NAME',  'myTrigger', '`myTrigger`' ),
                           new Token( 'WHEN',  'AFTER', 'AFTER' ),
                           new Token( 'ACTION',  'INSERT', 'INSERT' ),
                           new Token( 'ON',  'ON', 'ON' ),
                           new Token( 'NAME',  'obj', '`obj`' )
                       ] ),
                       new Token( 'FOR_EACH_ROW',  'FOR_EACH_ROW BEGIN', 'FOR_EACH_ROW BEGIN', [
                           new Token( 'FOR_EACH_ROW',  'FOR EACH ROW', 'FOR EACH ROW' ),
                           new Token( 'BEGIN',  'BEGIN', 'BEGIN' ),
                       ] ),
                       new Token( 'IF_CONDITION',  'IF_CONDITION', 'IF_CONDITION', [
                           new Token( 'IF_CONDITION',  'NEW.state IS NOT NULL', 'IF NEW.state IS NOT NULL THEN' ),
                       ] ),
                       new Token( 'INSERT_INTO',  'INSERT_INTO NAME ( NAME , NAME ) VALUES ( NEW_ROW_FIELD , NEW_ROW_FIELD )', 'INSERT_INTO NAME ( NAME , NAME ) VALUES ( NEW_ROW_FIELD , NEW_ROW_FIELD )', [
                           new Token( 'INSERT_INTO',  'INSERT INTO', 'INSERT INTO' ),
                           new Token( 'NAME',  'obj_state', '`obj_state`' ),
                           new Token( '(',  '(', '(' ),
                           new Token( 'NAME',  'id_obj', '`id_obj`' ),
                           new Token( ',',  ',', ',' ),
                           new Token( 'NAME',  'state', '`state`' ),
                           new Token( ')',  ')', ')' ),
                           new Token( 'VALUES',  'VALUES', 'VALUES' ),
                           new Token( '(',  '(', '(' ),
                           new Token( 'NEW_ROW_FIELD',  'NEW.id', 'NEW.id' ),
                           new Token( ',',  ',', ',' ),
                           new Token( 'NEW_ROW_FIELD',  'NEW.state', 'NEW.state' ),
                           new Token( ')',  ')', ')' ),
                       ] ),
                       new Token( ';',  ';', ';', [
                           new Token( ';',  ';', ';' )
                       ] ),
                       new Token( 'END_IF',  'END_IF', 'END_IF', [
                           new Token( 'END_IF',  'END IF', 'END IF' )
                       ] ),
                       new Token( ';',  ';', ';', [
                           new Token( ';',  ';', ';' )
                       ] ),
                       new Token( 'END',  'END', 'END', [
                           new Token( 'END',  'END', 'END' )
                       ] ),
                       new Token( ';',  ';', ';', [
                           new Token( ';',  ';;', ';;' )
                       ] ),
                       new Token( 'SET_DELIMITER',  'SET_DELIMITER', 'SET_DELIMITER', [
                           new Token( 'SET_DELIMITER',  'DELIMITER ;', 'DELIMITER ;' )
                       ] )
                   ]
               )
           ];
        }
    }
}
