<?php namespace Devdk\Widgify;

class Factory extends \WP_Widget {

    /**
     * Instance of Fields
     * @var Devdk\Widget\Fields
     */
    private $fields;

    /**
     * Class constructor
     * @param string $id
     * @param string $name
     * @param array $options
     * @param Fields $fields
     */
    public function __construct($id, $name, array $options, Fields $fields)
    {
        $this->fields = $fields;
        parent::__construct($id, $name, $options);
    }

    /**
     * Widget frontend outpur
     * @param  array $args
     * @param  array $instance
     * @return mixed
     */
    public function widget(array $args, array $instance)
    {
        call_user_func_array($this->fields->output, [$args, $instance]);
    }

    /**
     * Widget form
     * @param  array $instance
     * @return HTML
     */
    public function form(array $instance)
    {
        echo $this->fields->form($instance, $this);
    }

    /**
     * Update widget fields
     * @param  array $instance
     * @return array $instance
     */
    public function update($instance)
    {
        return $instance;
    }

}