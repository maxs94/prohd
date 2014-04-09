<?php
/*
 * EveApiIterator class file.
 */

/**
 * An iterator class for the attributes of the EveApi class.
 *
 * @author Matt Nischan
 */
class EveApiIterator implements Iterator
{
    
    private $_data;
    private $_position;
    
    public function __construct($data)
    {
        $this->$_data = $data;
        $this->_position = 0;
    }
    
    function rewind()
    {
        $this->_position = 0;
    }
    
    function current()
    {
        return $this->_data[$this->_position];
    }
    
    function key()
    {
        return $this->_position;
    }
    
    function next()
    {
        ++$this->_position;
    }
    
    function valid()
    {
        return isset($this->_data[$this->_position]);
    }
}

?>
