<?php namespace Devdk\Widgify;

class Fields {

    /**
     * Widget fields.
     * @var array
     */
    public $fields = array();

    /**
     * Widget output callback.
     * @var mixed
     */
    public $output;

    /**
     * Add new Widget field.
     * @param array $args
     */
    public function add_field(array $args)
    {
        $defaults = [
            "default" => null,
            "classes" => null,
            "label"   => null,
            "type"    => "text",
            "options" => array()
        ];

        $this->fields[$args['name']] = array_merge($defaults, $args);
    }

    /**
     * Set widget frontend output callback.
     * @param  mixed $callback
     * @return void
     */
    public function output($callback)
    {
        $this->output = $callback;
    }

    /**
     * Generate widget form.
     * @param  array   $instance
     * @param  Factory $factory  [description]
     * @return void
     */
    public function form(array $instance, Factory $factory)
    {
        foreach( $this->fields as $field )
        {
            $name       = strtolower($field['name']);
            $label      = ( $field['label'] ?: ucfirst($field['name']) );
            $field_id   = $factory->get_field_id($name);
            $field_name = $factory->get_field_name($name);
            $value      = isset($instance[$name]) ? esc_attr($instance[$name]) : $field['default'];

            echo '<p>';
            printf('<label for="%s">%s</label>', $field_id, _e($label));

            switch($field['type'])
            {
                case "text":
                    $markup = $this->text();
                    break;
                case "textarea":
                    $markup = $this->textarea();
                    break;
                case "pages":
                    $markup = "";
                    echo $this->page($value, $field_name, $field_id);
                    break;
                case "upload":
                    $markup = "";
                    echo $this->upload($value, $field_name, $field_id);
                    break;
                case "select":
                    $markup = "";
                    echo $this->select($value, $field_name, $field_id, $field['options']);
                    break;
                default:
                    $markup = "";
            }

            printf( $markup, $field_id, $field_name, $value, $field_name);

            echo '</p>';
        }
    }

    /**
     * Generate text field.
     * @return string
     */
    protected function text()
    {
        return '<input class="widefat" id="%s" name="%s" type="text" value="%s" />';
    }

    /**
     * Generate textarea field.
     * @return string
     */
    protected function textarea()
    {
        return '<textarea class="widefat" id="%s" name="%s" rows="5">%s</textarea>';
    }

    /**
     * Generate dropdown with pages created.
     * in Wordpress.
     * @param  mixed  $value
     * @param  string $name
     * @param  string $id
     * @return string
     */
    protected function page($value=null, $name, $id)
    {
        return "<br />".wp_dropdown_pages([
            'selected' => $value,
            'echo'     => 0,
            'name'     => $name,
            'id'       => $id
        ]);
    }

    /**
     * Generate upload field.
     * @param  mixed  $value
     * @param  string $name
     * @param  string $id
     * @return string
     */
    protected function upload($value=null, $name, $id)
    {
        $return = '<span class="devdk-img-placeholder" style="display:block; text-align:center;">';

        if( $value AND $src = wp_get_attachment_image_src($value, 'thumbnail') )
        {
            $return .= '<img src="'.$src[0].'">';
        }

        $return .= '</span>';

        $return .= '<div style="text-align:left;">';
            $return .= sprintf('<input type="hidden" class="devdk-image-field" name="%s" value="%s" id="%s">', $name, $value, $id);
            $return .= sprintf('<input type="button" class="devdk-select-img button" value="%s" />', __('Vælg billede'));
        $return .= '</div>';

        return $return;
    }

    /**
     * Generate select field.
     * @param  mixed  $value
     * @param  string $name
     * @param  string $id
     * @param  array  $options
     * @return string
     */
    protected function select($value=null, $name, $id, array $options)
    {
        $return = "<br />";
        $return .= sprintf('<select id="%s" name="%s">', $id, $name);
        foreach( $options as $val => $txt)
        {
            $selected = ($val === $value ? ' selected="selected"' : '');
            $return .= sprintf('<option%s value="%s">%s</option>', $selected, $val, $txt);
        }
        $return .= "</select>";

        return $return;
    }

}