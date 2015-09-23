<?php

class Hooks_linked extends Hooks
{
    public function control_panel__add_to_foot() {
    	return $this->js->link('linked.js');
    }
    
    public function linked__get_values() {
    	$file = Request::get('file');
        $lookup = Request::get('lookup');
        
        // load the data file
        $data = $this->loadConfigFile($file . '.yaml');
        
        $selectize = array();

		 /*	selectize needs the data in this format:
		  *
		  * [{value: "sk", text: "Sask"}, {value: "mb", text: "Manitoba"}]
		  *
		  */
        foreach ($data[$lookup] as $key => $value) {
        	$selectize[] = array('value' => $key, 'text' => $value);
        }
 
        echo(json_encode($selectize));
    }
}