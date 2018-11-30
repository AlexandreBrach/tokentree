
# PHP Parser Library

This library parse your text and convert it to tokens based on rules you have define.
You can define tokens on multiple layers to achieve complex parsing, resulting on an array of array of tokens. (or in an n-level array of tokens, depending on the depth of the rules you have defined)

# Install libraries

    composer require alexandrebrach/tokentree

# Run the unit tests

    phpunit tests

# How to use it

## Define token extraction rules

To extract each tokens, rules must be defined in classes extending `Tokentree\Lexic\Lexic`.

Each rule can be :

* a simple string (a comma or a keyword like `class`)
* a regular expression (to extract a `$dollarBaseNamedVariable`)
* a callback function to handle critical things (think about `SET_DELIMITER` SQL instruction)

Exemple with SQL Parsing (this is for illustration purpose and may not be functionnal. A complete SQL tokenizer is provided in the code)

The following explain how to parse a SQL `CREATE TABLE` statement using 3 layers of tokens.

The first class is able to extract any word or character that may appear in a SQL `CREATE TABLE` statement.
They will be converted to tokens. Each token will have a token-type (`CREATE_TABLE`, `NAME`, etc), and a value (the value of the string or the resulting regular expresion matches)

    class Token extends Lexic
    {
        protected function _init()
        {
            $this
                ->_addRule( 'CREATE_TABLE',	'regexp', '|^(CREATE\s*TABLE(\s*IF\s*NOT\s*EXISTS)?)|' )
                ->_addRule( 'NAME',	'regexp', '|^`([^`]*)`|' )
                ->_addRule( 'DATATYPE', 'regexp', '/^(\b(int|tinyint|float|decimal|text|varchar|datetime|date|timestamp|time|point|char)\b(\s*\(\s*(\d*(\s*\,\d*)?)\s*\))?)/' )
                ->_addRule( 'CHARSET', 'regexp', '|^CHARACTER\s*SET\s*(\S*)|' )
                ->_addRule( 'UNSIGNED', 'string', 'UNSIGNED' )
                ->_addRule( 'NOT_NULL', 'string', 'NOT NULL' )
                ->_addRule( 'NULL',	'string', 'NULL' )
                ->_addRule( 'DEFAULT', 'string', 'DEFAULT' )
                ->_addRule( 'STRING', 'regexp', '|^\'(.*)\'|' )
                ->_addRule( 'STRING', 'regexp' ,'|^\"(.*)\"|' )
                ->_addRule( 'EXPRESSION', 'regexp',	'|^(CURRENT_TIMESTAMP)|' )
                ->_addRule( 'VALUE', 'regexp', '|^(DEFAULT\s*CHARSET\s*)|')
                ->_addRule( 'VALUE', 'regexp', '|^([a-zA-Z_0-9]+)|')
                ->_addRule( 'ON', 'string',	'ON' )
                ->_addRule( 'ACTION', 'regexp',	'/^(INSERT|UPDATE|DELETE)/' )
                ->_addRule( 'AUTO_INCREMENT', 'string',	'AUTO_INCREMENT' )
                ->_addRule( 'SQLCOMMENT', 'string',	'COMMENT' )
                ->_addRule( 'KEY', 'regexp', '/^(PRIMARY|UNIQUE)?\s*KEY/' )
                ->_addRule( 'USING', 'string', 'USING' )
                ->_addRule( 'CONSTRAINT', 'string',	'CONSTRAINT' )
                ->_addRule( 'FOREIGN_KEY', 'regexp', '|^(FOREIGN\s*KEY)|' )
                ->_addRule( 'REFERENCES', 'string',	'REFERENCES' )
                ->_addRule( 'TRIGGER_ACTION', 'regexp', '/^(CASCADE|RESTRICT|SET\s*NULL|NO\s*ACTION)/' )
                ->_addRule( 'ALIAS', 'regexp', '|^@+([a-zA-Z_0-9]+)|')
            ;
        }
    }

Once finished, the parser will concatenate every token-type value found in the first layer.
The resulting string will be parsed by the second layer in the same manner than previously.
So, it provide a upper abstraction-level using the previous tokens : it is able to reconize the begining of a `CREATE TABLE` statement, a colum definition, etc.

    class Expression extends Lexic
    {
        protected function _init()
        {
            $this
                ->_addRule( 'CREATE_TABLE',	'regexp', '/^CREATE_TABLE\s*NAME/' )
                ->_addRule( 'COLUMN', 'regexp',	'/^(NAME\s*DATATYPE\s*(CHARSET)?\s*(UNSIGNED)?\s*(NULL|NOT_NULL)?\s*(DEFAULT)?\s*(STRING|NULL|EXPRESSION|VALUE)?\s*(ON ACTION)?\s*(STRING|NULL|EXPRESSION)?\s*(AUTO_INCREMENT)?\s*(SQLCOMMENT\s*STRING)?)\s*/' )
                ->_addRule( 'KEY', 'regexp', '/^(KEY\s*(NAME)?\s*\(\s*(NAME(\s*\,\s*NAME\s*)*)\s*\)\s*(USING\s*VALUE)?)/' )
                ->_addRule( 'FOREIGN_KEY',	'regexp', '/^(CONSTRAINT\s*NAME\s*FOREIGN_KEY\s*\(\s*NAME\s*\)\s*REFERENCES\s*NAME\s*\(\s*NAME\s*\)\s*(ON\s*ACTION\s*TRIGGER_ACTION\s*)*)/' )
                ->_addRule( 'ASSIGNMENT', 'regexp',	'/^((VALUE|ALIAS|AUTO_INCREMENT) \= (VALUE|ALIAS|STRING))/' )
                ->_addRule( 'ASSIGNMENT', 'regexp',	'/^((NAMES) (VALUE))/' )
            ;
        }
    }


Finaly, in the same manner than we go from layer 1 to layer 2, we concatenate the value of each token of layer 2 and provide the resulting string to the layer 3.
This last layer is able to reconize the structure of any `CREATE TABLE` statement using the tokens of the second layer.
An unique rule is enough to achieve this :


    class Statement extends Lexic
    {
        protected function _init()
        {
            $this
                ->_addRule( 'CREATE_TABLE', 'regexp', '/^(CREATE_TABLE\s*\(\s*COLUMN(\s*\,\s*(COLUMN|KEY|FOREIGN_KEY))*\s*\)(\s*ASSIGNMENT)*)/' )
        }
    }

## Use the layers to parse strings

Use the tree previous classes (in the correct order) to define the multilayer parsing engine :

    $tokenTree = new \Tokentree\Tokentree();
    $tokenTree->setLexics( [ new Token(), new Expression(), new Statement() ] );

Parse the string :

    $tokenizer->tokenize( $sql );

Get the resulting tokens :

    $tokens = $tokenizer->shiftAllStack();
