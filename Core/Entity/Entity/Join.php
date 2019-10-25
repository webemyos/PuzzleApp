<?php

/*
 * PuzzleApp
 * Webemyos
 * Jérôme Oliva
 * GNU Licence
 */

namespace Core\Entity\Entity;

use Core\Core\Core;

class join
{
    public $Table;
    public $Alias;
    public $TypeJoin;
    public $PrimaryKey;
    public $ForeignKey;
    public $Where;

    public function __construct($table, $alias, $type, $primaryKey, $foreignKey, $where = "")
    {
        $this->Table = $table;
        $this->Alias = $alias;
        $this->TypeJoin = $type;
        $this->PrimaryKey = $primaryKey;
        $this->ForeignKey = $foreignKey;
        $this->Where = $where;
    }
}