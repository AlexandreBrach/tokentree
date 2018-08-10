<?php

namespace TokentreeTest\Provider\Command\Table;

use \Tokentree\Token;

class Alter
{
    const TRUCS = 1;

    const SMALL = 2;

    protected $list;

    public function __construct()
    {
        $this->list = [
            self::TRUCS => 'alter table trucs'
        ];
    }

    public function getSql( $name )
    {
        switch( $name ) {
        case self::SMALL :
            return 'ALTER TABLE      `trucs` '
                . 'ADD COLUMN `id_truc` int(8) UNSIGNED DEFAULT NULL,'
                . 'MODIFY `update_type` tinyint(3) UNSIGNED NOT NULL,'
                . 'DROP FOREIGN KEY `old_fk`';
        case self::TRUCS :
            return 'ALTER TABLE `trucs` '
                . 'ADD COLUMN `id_truc` int(8) UNSIGNED DEFAULT NULL,'
                . 'ADD CONSTRAINT `id_truc` KEY (`id_truc`),'
                . 'ADD CONSTRAINT `constraint` FOREIGN KEY ( `id_truc` ) REFERENCES `myTable` ( `id` ) ON DELETE SET NULL,'
                . 'ADD KEY `my_key` (`my_key`),'
                . 'MODIFY `update_type` tinyint(3) UNSIGNED NOT NULL,'
                . 'DROP COLUMN `old_column`,'
                . 'DROP KEY `old_key`,'
                . 'DROP FOREIGN KEY `old_fk`';
        }
    }

    /**
     * Return the summary based on the sample index
     */
    public function getSummary( $name )
    {
        switch( $name ) {
        case self::SMALL :
            return 'ALTER_TABLE NAME ADD_COLUMN NAME DATATYPE UNSIGNED DEFAULT NULL , MODIFY NAME DATATYPE UNSIGNED NOT_NULL , DROP_FOREIGN_KEY NAME ';
        }
    }

    /**
     * Return the corresponding sql marked with a [X] to any place matching with a token position
     */
    public function getMarkedSummaryWithTokenPosition( $name )
    {
        switch( $name ) {
        case self::SMALL :
            return '[X]ALTER_TABLE [X]NAME [X]ADD_COLUMN [X]NAME [X]DATATYPE [X]UNSIGNED [X]DEFAULT [X]NULL [X], [X]MODIFY [X]NAME [X]DATATYPE [X]UNSIGNED [X]NOT_NULL [X], [X]DROP_FOREIGN_KEY [X]NAME ';
        }
    }

    /**
     * Return the corresponding sql marked with a [X] to any place matching with a token position
     */
    public function getMarkedWithTokenPosition( $name )
    {
        switch( $name ) {
        case self::SMALL :
            return '[X]ALTER TABLE [X]`trucs` '
                . '[X]ADD COLUMN [X]`id_truc` [X]int(8) [X]UNSIGNED [X]DEFAULT [X]NULL [X], '
                . '[X]MODIFY [X]`update_type` [X]tinyint(3) [X]UNSIGNED [X]NOT NULL [X], '
                . '[X]DROP FOREIGN KEY [X]`old_fk` ';
        }
    }

    public function getToken( $name )
    {
        switch( $name ) {
            case self::TRUCS : return
                [
                    new Token(
                        'ALTER_TABLE',
                        'ALTER_TABLE ADD_COLUMN COLUMN , ADD_CONSTRAINT , ADD_FOREIGN_KEY , ADD_KEY , MODIFY COLUMN , DROP_COLUMN , DROP_KEY , DROP_FOREIGN_KEY ',
                        'ALTER_TABLE ADD_COLUMN COLUMN , ADD_CONSTRAINT , ADD_FOREIGN_KEY , ADD_KEY , MODIFY COLUMN , DROP_COLUMN , DROP_KEY , DROP_FOREIGN_KEY ',
                        [
                            new Token( 'ALTER_TABLE','ALTER_TABLE NAME', 'ALTER_TABLE NAME',
                                [
                                    new Token( 'ALTER_TABLE','ALTER TABLE', 'ALTER TABLE' ),
                                    new Token( 'NAME', 'trucs','`trucs`' )
                                ]
                            ),
                            new Token( 'ADD_COLUMN', 'ADD_COLUMN', 'ADD_COLUMN',
                                [
                                    new Token( 'ADD_COLUMN','ADD COLUMN', 'ADD COLUMN' ),
                                ]
                            ),
                            new Token( 'COLUMN','NAME DATATYPE UNSIGNED DEFAULT NULL ','NAME DATATYPE UNSIGNED DEFAULT NULL ',
                                [
                                    new Token( 'NAME','id_truc','`id_truc`' ),
                                    new Token( 'DATATYPE','int(8)','int(8)' ),
                                    new Token( 'UNSIGNED','UNSIGNED','UNSIGNED' ),
                                    new Token( 'DEFAULT','DEFAULT','DEFAULT' ),
                                    new Token( 'NULL','NULL','NULL' ),
                                ]
                            ),
                            new Token( ',', ',', ',',
                                [
                                    new Token( ',',',',',' )
                                ]
                            ),
                            new Token(
                                'ADD_CONSTRAINT',
                                'ADD_CONSTRAINT NAME KEY ( NAME ) ',
                                'ADD_CONSTRAINT NAME KEY ( NAME ) ',
                                [
                                    new Token( 'ADD_CONSTRAINT','ADD CONSTRAINT','ADD CONSTRAINT' ),
                                    new Token( 'NAME','id_truc','`id_truc`' ),
                                    new Token( 'KEY','KEY','KEY' ),
                                    new Token( '(','(','(' ),
                                    new Token( 'NAME','id_truc','`id_truc`' ),
                                    new Token( ')',')',')' ),
                                ]
                            ),
                            new Token( ',', ',', ',',
                                [
                                    new Token( ',',',',',' )
                                ]
                            ),
                            new Token(
                                'ADD_FOREIGN_KEY',
                                'ADD_CONSTRAINT NAME FOREIGN_KEY ( NAME ) REFERENCES NAME ( NAME ) ON ACTION TRIGGER_ACTION ',
                                'ADD_CONSTRAINT NAME FOREIGN_KEY ( NAME ) REFERENCES NAME ( NAME ) ON ACTION TRIGGER_ACTION ',
                                [
                                    new Token( 'ADD_CONSTRAINT','ADD CONSTRAINT','ADD CONSTRAINT' ),
                                    new Token( 'NAME','constraint','`constraint`' ),
                                    new Token( 'FOREIGN_KEY','FOREIGN KEY','FOREIGN KEY' ),
                                    new Token( '(','(','(' ),
                                    new Token( 'NAME','id_truc','`id_truc`' ),
                                    new Token( ')',')',')' ),
                                    new Token( 'REFERENCES','REFERENCES','REFERENCES' ),
                                    new Token( 'NAME','myTable','`myTable`' ),
                                    new Token( '(','(','(' ),
                                    new Token( 'NAME','id','`id`' ),
                                    new Token( ')',')',')' ),
                                    new Token( 'ON','ON','ON' ),
                                    new Token( 'ACTION','DELETE','DELETE' ),
                                    new Token( 'TRIGGER_ACTION','SET NULL','SET NULL' )
                                ]
                            ),
                            new Token( ',', ',', ',',
                                [
                                    new Token( ',',',',',' )
                                ]
                            ),
                            new Token( 'ADD_KEY', 'ADD_KEY NAME ( NAME )', 'ADD_KEY NAME ( NAME )',[
                                new Token( 'ADD_KEY','ADD KEY','ADD KEY' ),
                                new Token( 'NAME','my_key','`my_key`' ),
                                new Token( '(','(','(' ),
                                new Token( 'NAME','my_key','`my_key`' ),
                                new Token( ')',')',')' ),
                            ] ),
                            new Token( ',', ',', ',',
                                [
                                    new Token( ',',',',',' )
                                ]
                            ),
                            new Token( 'MODIFY','MODIFY','MODIFY',
                                [
                                    new Token( 'MODIFY','MODIFY','MODIFY' )
                                ]
                            ),
                            new Token( 'COLUMN','NAME DATATYPE UNSIGNED NOT_NULL ', 'NAME DATATYPE UNSIGNED NOT_NULL ',
                                [
                                    new Token( 'NAME','update_type','`update_type`' ),
                                    new Token( 'DATATYPE','tinyint(3)','tinyint(3)' ),
                                    //new Token( 'TYPELENGTH','3','(3)' ),
                                    new Token( 'UNSIGNED','UNSIGNED','UNSIGNED' ),
                                    new Token( 'NOT_NULL','NOT NULL','NOT NULL' )
                                ]
                            ),
                            new Token( ',', ',', ',',
                                [
                                    new Token( ',',',',',' )
                                ]
                            ),
                            new Token( 'DROP_COLUMN', 'DROP_COLUMN NAME', 'DROP_COLUMN NAME',[
                                new Token( 'DROP_COLUMN','DROP COLUMN','DROP COLUMN' ),
                                new Token( 'NAME','old_column','`old_column`' )
                            ] ),
                            new Token( ',', ',', ',',
                                [
                                    new Token( ',',',',',' )
                                ]
                            ),
                            new Token( 'DROP_KEY', 'DROP_KEY NAME', 'DROP_KEY NAME',[
                                new Token( 'DROP_KEY','DROP KEY','DROP KEY' ),
                                new Token( 'NAME','old_key','`old_key`' )
                            ] ),
                            new Token( ',', ',', ',',
                                [
                                    new Token( ',',',',',' )
                                ]
                            ),
                            new Token( 'DROP_FOREIGN_KEY', 'DROP_FOREIGN_KEY NAME', 'DROP_FOREIGN_KEY NAME',[
                                new Token( 'DROP_FOREIGN_KEY','DROP FOREIGN KEY','DROP FOREIGN KEY' ),
                                new Token( 'NAME','old_fk','`old_fk`' )
                            ] ),
                        ]
                    )
                ];
        }
    }
}
