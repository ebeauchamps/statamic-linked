<?php

class Fieldtype_linked extends Fieldtype
{
    public function render()
    {
        $field_data = $this->field_data;

        $suggestions = array();

        /*
        |--------------------------------------------------------------------------
        | Misc options
        |--------------------------------------------------------------------------
        |
        */

        $allow_blank = array_get($this->field_config, 'allow_blank', false);
        $placeholder = array_get($this->field_config, 'placeholder', false);

        $placeholder_string = $placeholder ? "placeholder='$placeholder'" : '';

        /*
        |--------------------------------------------------------------------------
        | Hardcoded list of options
        |--------------------------------------------------------------------------
        |
        | Any list can contain a preset list of options available for suggestion,
        | exactly like how the Select fieldtype works.
        |
        */

        if (isset($this->field_config['options'])) {
            $data = $this->field_config['options'];
            $suggestions = array_merge($suggestions, $data);
        }


        /*
        |--------------------------------------------------------------------------
        | Options from a file
        |--------------------------------------------------------------------------
        |
        | Any list can contain a preset list of options available for suggestion,
        | exactly like how the Select fieldtype works.
        |
        */

        if (isset($this->field_config['options_file'])) {
            $file = $this->field_config['options_file'];
            $data = $this->loadConfigFile($file . '.yaml');
            $suggestions = array_merge($suggestions, $data[$file]);
        }


        /*
        |--------------------------------------------------------------------------
        | Input HTML
        |--------------------------------------------------------------------------
        |
        | Generate the HTML for the select field. A single, blank option is
        | needed if allow blank is true.
        |
        */

        $options = json_encode(array(
            'sortField'      => 'text',
            'delimiter'      => ',',
            'maxItems'		 => 1,
            'create'         => array_get($this->field_config, 'create', false),
            'persist'        => array_get($this->field_config, 'persist', true),
            'hideSelected'   => array_get($this->field_config, 'hide_selected', true),
            'sortDirection'  => array_get($this->field_config, 'sort_dir', 'asc'),
            'plugins'        => array('drag_drop'),
            'dropdownParent' => 'body'
        ));

        $required_str = ($this->is_required) ? 'required' : '';
        $link_to_str = '';
        $data_key = '';
        
        if (isset($this->field_config['link_to'])) {
        	$link_to_str = 'data-linked-linkto=' . $this->field_config['link_to'];
        }

        if (isset($this->field_config['options_key'])) {
        	$data_key = 'data-linked-key=' . $this->field_config['options_key'];
        }

        $html = "<div id='$this->field_id' class='suggest-field-container' data-config='$options'>";
        $html .= "<select {$required_str} name='{$this->fieldname}' tabindex='{$this->tabindex}' $placeholder_string class='suggest' data-linked-field='$this->field' {$link_to_str} {$data_key}>\n";

        $is_indexed = (array_values($suggestions) === $suggestions);

        // Preserve existing data's order
        if (is_array($field_data)) {
            $field_data = array_combine($field_data, $field_data);
            $suggestions = array_merge($field_data, $suggestions);
        }

        if ($allow_blank) {
            $html .= "<option value=''></option>\n";
        }

        foreach ($suggestions as $value => $label) {

            $value = $is_indexed ? $label : $value; #allows setting custom values and labels

            $selected = $field_data == $value ? " selected " : '';

            $html .= '<option value="'. $value .'" ' . $selected .'>' . $label .'</option>';
        }

        $html .= "</select>";
        $html .= "<div class='count-placeholder'></div></div>";

        $html .= "<script>$('#{$this->field_id}').statamicSuggest();</script>";

        return $html;
    }


    public function process($settings)
    {
        // If empty, save as null
        if ($this->field_data === '') {
            return null;
        }

        // If we're forcing lowercase taxonomies (which we are by default), save them as lower too
        if (array_get($settings, 'taxonomy', false) && Config::get('taxonomy_force_lowercase', false)) {
            $this->field_data = Helper::ensureArray($this->field_data);

            foreach ($this->field_data as $key => $value) {
                $this->field_data[$key] = strtolower($value);
            }
        }

        return $this->field_data;
    }
}
