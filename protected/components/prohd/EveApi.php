<?php
/**
 * EveApi class file.
 *
 * @author Matt Nischan
 */

/**
 * Eve API base class for Yii. Do not use this class directly.
 *
 * @author Matt Nischan
 */
abstract class EveApi extends CModel implements IteratorAggregate
{
    
    private $_eveUrl;
    private $_apiResults;
    private $_apiCallUrl;
    private static $_models = array();
    private $_parameters = array();
    private $_attributes = array();
    private $_errors = array();
    
    public $error = false;
    
    /**
     * Factory method for returning the EveApi class object
     *
     * @param string $className Name of the EveApi derived class
     * @return EveApi EveApi result set object instance
     */
    public static function data($className=__CLASS__)
    {
        if (isset(self::$_models[$className]))
        {
            return self::$_models[$className];
        }
        else
        {
            $model = self::$_models[$className] = new $className;
            return $model;
        }
    }
    
    /**
     * Class constructor.
     */
    public function __construct()
    {
        $this->setEveUrl();
        $this->setApiCallUrl();
        $this->setParameters();
    }
    
    /**
     * Sets the base URL for the Eve API. Configured using Yii::app()->params['eveApiUrl'].
     */
    private function setEveUrl()
    {
        $this->_eveUrl = Yii::app()->params['eveApiUrl'];
    }
    
    /**
     * Returns the full API URL.
     * @return string Full API URL, e.g. "https://api.eveonline.com/char/MarketOrders.aspx"
     */
    public function url()
    {
        return $this->_eveUrl . $this->_apiCallUrl;
    }
    
    /**
     * Sets the specific .aspx API URL path for object.
     */
    private function setApiCallUrl()
    {
        $this->_apiCallUrl = $this->apiCallUrl();
    }
    
    /**
     * Returns the specific .aspx API URL path. Overload this function to correctly set the full API path.
     * @return string Specific API call, e.g. <i>/char/MarketOrders.aspx</i>
     */
    abstract public function apiCallUrl();

    
    /**
     * Returns an array of possible parameters. Overload this function to set the parameters needed.
     * @return array Return an array of the format <i>array('characterID'=>'optional','userID','apiKey')</i>.
     */
    abstract public function parameters();

    
    /**
     * Sets the internal api parameters property to the api parameters specified in the derived class.
     */
    private function setParameters()
    {
        foreach ($this->parameters() as $key => $parameter)
        {
            if ($parameter == 'optional')
            {
                $this->_parameters[$key] = 'optional';
            }
            else
            {
                $this->_parameters[$parameter] = 'required';
            }
        }
    }
    
    /**
     * Gets an array of the non-optional parameters required by the Eve API call.
     * @return array An array of the required API parameters
     */
    private function getRequiredParameters()
    {
        foreach ($this->_parameters as $key => $parameter)
        {
            if ($parameter == 'required')
            {
                $requiredParameters[] = $key;
            }
        }
        return $requiredParameters;
    }
    
    /**
     * Retrieves XML data from the Eve API and binds it to the EveApi object.
     * @param array $parameters An array of parameters and values to pass to the API call
     * @return bool Returns true on success, false on failure.
     */
    public function fetch($parameters=null)
    {
        //Construct the URL for the api call
        $url = $this->url();
        
        //Get the list of parameters needed
        if($this->_parameters)
        {
            if ($parameters == null)
            {
                throw new CException("No parameters were specified for this Eve API call.");
            }
            else
            {
                //Check that we have all the required parameters
                $requiredParameters = $this->getRequiredParameters();
                foreach ($requiredParameters as $requirement)
                {
                    //If a required parameter is not provided
                    if (!(in_array($requirement, array_keys($parameters))))
                    {
                        throw new CException("The required parameter {$requirement} for this Eve API call was not provided.");
                    }
                }
                
                foreach (array_keys($parameters) as $providedParameter)
                {
                    //If an extra parameter is provided
                    if (!(in_array($providedParameter, array_keys($this->_parameters))))
                    {
                        throw new CException("A parameter {$providedParameter} provided for an Eve API call was not found in the class parameters.".print_r($this->_parameters));
                    }
                }
                
                //Build the parameter string
                foreach ($parameters as $key => $parameter)
                {
                    $paramString .= "&".$key."=".$parameter;
                }
            }
        }

        //Set up the cUrl instance
        $urlRetriever = curl_init($url."?".$paramString);
        
        curl_setopt($urlRetriever, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($urlRetriever, CURLOPT_TIMEOUT, 10);
        curl_setopt($urlRetriever, CURLOPT_SSL_VERIFYPEER, false);
        
        $response = curl_exec($urlRetriever);
        
        //Bind the attributes if there is a response, else return false
        if ($response)
        {
            $httpCode = curl_getinfo($urlRetriever, CURLINFO_HTTP_CODE);
            if ($httpCode != 200)
            {
                throw new CException("The Eve API returned an error code {$httpCode}. Please check that the URL is correct.");
            }
            else
                return $this->bindAttributes($response);
        }
        else
        {
            return false;
        }
    }
    
    /**
     * Binds the Eve API XML result to the internal _attributes array.
     * @param string $xml The full xml result set of the Eve API call
     * @return mixed Returns an array of the full list of attributes from the private variable if sucessful, false otherwise
     */
    private function bindAttributes($xml)
    {
        //Create the DOMDocument object
        $doc = new DOMDocument();
        $doc->loadXML($xml);

        //Get the base resultset
        $xpath = new DOMXPath($doc);
        
        //Check for API errors
        $errors = $xpath->query('/eveapi/error');
        if(!($errors->length == 0))
        {
            $errorElement = $errors->item(0);
            $this->setErrors(array('code'=>$errorElement->getAttribute('code'),'message'=>$errorElement->nodeValue));
            return $this;
        }
        else
        {
        $node = $xpath->query('/eveapi/result');
        
        $this->_attributes = new EveApiRow();
        $this->bindAttributeContents($xpath, $node->item(0), $this->_attributes);
        
        return $this->_attributes;
        }
    }
    
    /**
     * Recursive function that handles the creation of subobjects and the binding
     * of them to the root _attributes private variable.
     * @param DOMXPath $xpath
     * @param DOMNodeList $node
     * @param array $target 
     */
    private function bindAttributeContents(&$xpath, &$node, &$target)
    {
        //Get all child nodes of this node
        $childNodes = $xpath->query('child::node()', $node);
        
        //Iterate over the nodes
        $index = 0;
        foreach ($childNodes as $child)
        {
            if ($this->hasChild($child))
            {
                if ($child->tagName == 'rowset')
                {
                    $name = $child->getAttribute('name');
                    $target->$name = array();
                    $newTarget = &$target->getReference($name);
                }
                elseif ($child->tagName == 'row')
                {
                    $rowObject = new EveApiRow();
                    foreach($child->attributes as $attribute)
                    {
                        $rowObject->{$attribute->nodeName} = $attribute->nodeValue;
                    }
                    $target[$index] = $rowObject;
                    
                    $childRowset = $xpath->query('rowset', $child);
                    $name = $childRowset->item(0)->getAttribute('name');
                    $target[$index]->$name = array();
                    
                    $child = $childRowset->item(0);
                    $newTarget = &$target[$index]->getReference($name);
                }
                else
                {
                    $name = $child->tagName;
                    $target->$name = new EveApiRow();
                    $newTarget = &$target->getReference($name);
                }
                
                //Pass the xpath object, next node to be processed, and newly created array back to the function
                $this->bindAttributeContents($xpath, $child, $newTarget);
            }
            else
            {
                if ($child->tagName == 'row')
                {
                    $rowObject = new EveApiRow();
                    foreach($child->attributes as $attribute)
                    {
                        $rowObject->{$attribute->nodeName} = $attribute->nodeValue;
                    }
                    $target[$index] = $rowObject;
                }
                else
                {
                    if ($child->nodeType == XML_ELEMENT_NODE)
                    {
                        $name = $child->tagName;
                        $target->$name = $child->nodeValue;
                    }
                }
            }
            $index++;
        } 
        /*
        echo $node->item(0)->childNodes->length;
        die($node->item(0)->childNodes->length);
        //Get our column names
        $columnString = $node->item(0)->getAttribute('columns');
        $columns = explode(',',$columnString);
        
        //Get the returned rows
        $rows = $xpath->query('row', $node->item(0));
        
        //Create the attributes array
        $index = 0;
        foreach ($rows as $row)
        {
            //Create a new EveApiRow
            $target[$index] = new EveApiRow();
            foreach ($columns as $column)
            {
                //Assign the object properties
                $target[$index]->$column = $row->getAttribute($column);
            }
            
            //If the row has a child rowset
            if ($row->hasChildNodes())
            {
                //Get the xpath of the child rowset, and create an empty array within the EveApiRow object
                $childNode = $xpath->query('rowset', $row);
                $name = $childNode->item(0)->getAttribute('name');
                $target[$index]->$name = array();
                
                //Grab a reference to the new empty array
                $newTarget = &$target[$index]->getReference($name);
                
                //Pass the xpath object, next node to be processed, and newly created array back to the function
                $this->bindAttributeContents($xpath, $childNode, $newTarget);
            }
            
            $index++;
        }
         */
    }
    
    /**
     * Sets the private _errors variable to the passed array
     * @param array $errors 
     */
    private function setErrors($errors)
    {
        $this->_errors = $errors;
        $this->error = true;
    }
    
    /**
     * Retrieves the
     * @return array An array of Eve API errors.
     */
    public function getErrors()
    {
        if (!empty($this->_errors))
        {
            return $this->_errors;
        }
        else
        {
            return false;
        }
    }
    
    /**
     * Required by interface IteratorAggregate.
     * @return EveApiIterator 
     */
    public function getIterator()
    {
        return new EveApiIterator($this->_attributes);
    }
    
    /**
     * Overloaded attributeNames as per CModel requirement
     * @return bool true
     */
    public function attributeNames()
    {
        return true;
    }
    
    function DOMinnerHTML($element) 
    { 
        $innerHTML = ""; 
        $children = $element->childNodes; 
        foreach ($children as $child) 
        { 
            $tmp_dom = new DOMDocument(); 
            $tmp_dom->appendChild($tmp_dom->importNode($child, true)); 
            $innerHTML.=trim($tmp_dom->saveHTML()); 
        } 
        return $innerHTML; 
    }
    
    function hasChild($p) 
    {
        if ($p->hasChildNodes())
        {
            foreach ($p->childNodes as $c) 
            {
                if ($c->nodeType == XML_ELEMENT_NODE)
                    return true;
            }
        }
        return false;
    }
}
?>
