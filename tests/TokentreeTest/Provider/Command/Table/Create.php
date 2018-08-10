<?php

namespace TokentreeTest\Provider\Command\Table;

use \Tokentree\Token;

class Create
{
    const BIDULE = 1;

    protected $list;

    public function __construct()
    {
        $this->list = [
            self::BIDULE => 'table bidule'
        ];
    }

    public function getSql( $name )
    {
        switch( $name ) {
        case self::BIDULE :
                return 'CREATE TABLE `bidule` ( '
                  . '`id` int(8) unsigned NOT NULL AUTO_INCREMENT,'
                  . '`name` varchar(255) CHARACTER SET utf8 DEFAULT NULL,'
                  . '`id_truc` int(8) unsigned DEFAULT NULL, '
                  . '`description` text, '
                  . '`update_date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP, '
                  . 'PRIMARY KEY (`id`), '
                  . 'KEY `id_truc` (`id_truc`), '
                  . 'CONSTRAINT `ibfk` FOREIGN KEY (`id_truc`) REFERENCES `blah` (`id`) '
                  . ') ENGINE=InnoDB DEFAULT CHARSET=latin1;';
        }
    }

    public function getToken( $name )
    {
        switch( $name ) {
            case self::BIDULE : return
              [
                  new Token( 'CREATE_TABLE', 'CREATE_TABLE ( COLUMN , COLUMN , COLUMN , COLUMN , COLUMN , KEY , KEY , FOREIGN_KEY ) ASSIGNMENT ASSIGNMENT', 'CREATE_TABLE ( COLUMN , COLUMN , COLUMN , COLUMN , COLUMN , KEY , KEY , FOREIGN_KEY ) ASSIGNMENT ASSIGNMENT', [
                      new Token( 'CREATE_TABLE', 'CREATE_TABLE NAME', 'CREATE_TABLE NAME', [
                         new Token( 'CREATE_TABLE', 'CREATE TABLE', 'CREATE TABLE' ),
                         new Token( 'NAME', 'bidule', '`bidule`' )
                      ] ),
                      new Token( '(',  '(', '(', [
                          new Token( '(',  '(', '(' )
                      ] ),
                      new Token( 'COLUMN', 'NAME DATATYPE UNSIGNED NOT_NULL AUTO_INCREMENT ', 'NAME DATATYPE UNSIGNED NOT_NULL AUTO_INCREMENT ', [
                         new Token( 'NAME', 'id', '`id`' ),
                         new Token( 'DATATYPE', 'int(8)', 'int(8)' ),
                         //new Token( 'TYPELENGTH', '8', '(8)' ),
                         new Token( 'UNSIGNED', 'UNSIGNED', 'unsigned' ),
                         new Token( 'NOT_NULL', 'NOT NULL', 'NOT NULL' ),
                         new Token( 'AUTO_INCREMENT', 'AUTO_INCREMENT', 'AUTO_INCREMENT' )

                      ] ),
                      new Token( ',',  ',', ',', [
                          new Token( ',',  ',', ',' )
                      ] ),
                      new Token( 'COLUMN', 'NAME DATATYPE CHARSET DEFAULT NULL ', 'NAME DATATYPE CHARSET DEFAULT NULL ', [
                         new Token( 'NAME', 'name', '`name`' ),
                         new Token( 'DATATYPE', 'varchar(255)', 'varchar(255)' ),
                         //new Token( 'TYPELENGTH', '255', '(255)' ),
                         new Token( 'CHARSET', 'utf8', 'CHARACTER SET utf8' ),
                         new Token( 'DEFAULT', 'DEFAULT', 'DEFAULT' ),
                         new Token( 'NULL', 'NULL', 'NULL' ),
                      ] ),
                      new Token( ',',  ',', ',', [
                          new Token( ',',  ',', ',' )
                      ] ),
                      new Token( 'COLUMN', 'NAME DATATYPE UNSIGNED DEFAULT NULL ', 'NAME DATATYPE UNSIGNED DEFAULT NULL ', [
                         new Token( 'NAME', 'id_truc', '`id_truc`' ),
                         new Token( 'DATATYPE', 'int(8)', 'int(8)' ),
                         //new Token( 'TYPELENGTH', '8', '(8)' ),
                         new Token( 'UNSIGNED', 'UNSIGNED', 'unsigned' ),
                         new Token( 'DEFAULT', 'DEFAULT', 'DEFAULT' ),
                         new Token( 'NULL', 'NULL', 'NULL' )
                      ] ),
                      new Token( ',',  ',', ',', [
                          new Token( ',',  ',', ',' )
                      ] ),
                      new Token( 'COLUMN', 'NAME DATATYPE ', 'NAME DATATYPE ', [
                         new Token( 'NAME', 'description', '`description`' ),
                         new Token( 'DATATYPE', 'text', 'text' ),
                      ] ),
                      new Token( ',',  ',', ',', [
                          new Token( ',',  ',', ',' )
                      ] ),
                      new Token( 'COLUMN', 'NAME DATATYPE NOT_NULL DEFAULT EXPRESSION ON ACTION EXPRESSION ', 'NAME DATATYPE NOT_NULL DEFAULT EXPRESSION ON ACTION EXPRESSION ', [
                         new Token( 'NAME', 'update_date', '`update_date`' ),
                         new Token( 'DATATYPE', 'timestamp', 'timestamp' ),
                         new Token( 'NOT_NULL', 'NOT NULL', 'NOT NULL' ),
                         new Token( 'DEFAULT', 'DEFAULT', 'DEFAULT' ),
                         new Token( 'EXPRESSION', 'CURRENT_TIMESTAMP', 'CURRENT_TIMESTAMP' ),
                         new Token( 'ON', 'ON', 'ON' ),
                         new Token( 'ACTION', 'UPDATE', 'UPDATE' ),
                         new Token( 'EXPRESSION', 'CURRENT_TIMESTAMP', 'CURRENT_TIMESTAMP' )
                      ] ),
                      new Token( ',',  ',', ',', [
                          new Token( ',',  ',', ',' )
                      ] ),
                      new Token( 'KEY', 'KEY ( NAME ) ', 'KEY ( NAME ) ', [
                         new Token( 'KEY', 'PRIMARY', 'PRIMARY KEY' ),
                         new Token( '(', '(', '(' ),
                         new Token( 'NAME', 'id', '`id`' ),
                         new Token( ')', ')', ')' ),
                      ] ),
                      new Token( ',',  ',', ',', [
                          new Token( ',',  ',', ',' )
                      ] ),
                      new Token( 'KEY', 'KEY NAME ( NAME ) ', 'KEY NAME ( NAME ) ', [
                         new Token( 'KEY', 'KEY', 'KEY' ),
                         new Token( 'NAME', 'id_truc', '`id_truc`' ),
                         new Token( '(', '(', '(' ),
                         new Token( 'NAME', 'id_truc', '`id_truc`' ),
                         new Token( ')', ')', ')' ),
                      ] ),
                      new Token( ',',  ',', ',', [
                          new Token( ',',  ',', ',' )
                      ] ),
                      new Token( 'FOREIGN_KEY', 'CONSTRAINT NAME FOREIGN_KEY ( NAME ) REFERENCES NAME ( NAME ) ', 'CONSTRAINT NAME FOREIGN_KEY ( NAME ) REFERENCES NAME ( NAME ) ', [
                         new Token( 'CONSTRAINT', 'CONSTRAINT', 'CONSTRAINT' ),
                         new Token( 'NAME', 'ibfk', '`ibfk`' ),
                         new Token( 'FOREIGN_KEY', 'FOREIGN KEY', 'FOREIGN KEY' ),
                         new Token( '(', '(', '(' ),
                         new Token( 'NAME', 'id_truc', '`id_truc`' ),
                         new Token( ')', ')', ')' ),
                         new Token( 'REFERENCES', 'REFERENCES', 'REFERENCES' ),
                         new Token( 'NAME', 'blah', '`blah`' ),
                         new Token( '(', '(', '(' ),
                         new Token( 'NAME', 'id', '`id`' ),
                         new Token( ')', ')', ')' ),
                      ] ),
                      new Token( ')', ')', ')', [
                         new Token( ')', ')', ')' )
                      ] ),
                      new Token( 'ASSIGNMENT', 'VALUE = VALUE', 'VALUE = VALUE', [
                         new Token( 'VALUE', 'ENGINE', 'ENGINE' ),
                         new Token( '=', '=', '=' ),
                         new Token( 'VALUE', 'InnoDB', 'InnoDB' )
                      ] ),
                      new Token( 'ASSIGNMENT', 'VALUE = VALUE', 'VALUE = VALUE', [
                         new Token( 'VALUE', 'DEFAULT CHARSET', 'DEFAULT CHARSET' ),
                         new Token( '=', '=', '=' ),
                         new Token( 'VALUE', 'latin1', 'latin1' )
                      ] ),
                  ] ),
                  new Token( 'NIL', ';', ';', [
                     new Token( ';', ';', ';', [
                         new Token( ';', ';', ';' )
                      ] )
                  ] )
              ];
        }
    }
}
