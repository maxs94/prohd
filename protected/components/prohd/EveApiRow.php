<?php

/*
 * EveApiRow class file.
 */

/**
 * A simple data object representing one row of Eve API results.
 *
 * @author Matt Nischan
 */
class EveApiRow
{
    private $_rowData;
    
    public function __get($value)
    {
        return $this->_rowData[$value];
    }
    
    public function __set($name, $value)
    {
        $this->_rowData[$name] = $value;
    }
    
    public function &getReference($value)
    {
        return $this->_rowData[$value];
    }
}

?>
