<?php namespace Devdk;

use Closure;

class Widgify {

    /**
     * Widget id
     * @var string
     */
    private $id;

    /**
     * Widget name
     * @var string
     */
    private $name;

    /**
     * Widget description
     * @var string
     */
    private $description = null;

    /**
     * Widget fields
     * @var Devdk\Widget\Fields
     */
    private $fields;

    /**
     * Class constructor
     */
    public function __construct()
    {
        $this->fields = new Fields();
    }

    /**
     * Make a new widget
     * @param  string  $id
     * @param  string  $name
     * @param  string  $description
     * @param  Closure $callback
     * @return void
     */
    private function make($id, $name, $description=null, Closure $callback)
    {
        $this->id          = $id;
        $this->name        = $name;
        $this->description = $description;

        call_user_func_array($callback, [$this->fields]);

        $this->register_widget();
    }

    /**
     * Register the widget with Wordpress
     * @return void
     */
    protected function register_widget()
    {
        global $wp_widget_factory;
        global $wp_registered_widgets;

        $wp_widget_factory->widgets[md5($this->id)] = new Factory($this->id, $this->name, ["description" => $this->description], $this->fields);

        $wp_widget_factory->widgets[md5($this->id)]->_register();
    }

    /**
     * Class facade for cleaner API
     * @param  string $method
     * @param  array  $args
     * @return mixed
     */
    public static function __callStatic( $method, array $args=array() )
    {
          call_user_func_array([new self, $method], $args);
    }
}