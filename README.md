# Widgify

Widgify is a simple wrapper class for the WP_Widget class, providing a simple and clean API for crating new widgets for your Wordpress site.

## Usage
Install the Widgify plugin and activate it.

Now, either in your own plugin or in your theme functions.php you can use the Widget class.

    <?php
    use Devdk\Widgify;

    Widgify::make($id, $name, $desc, function($widget){

        $widget->add_field([
            "name"    => "title",
            "label"   => "Title",
            "default" => "Enter your title"
        ]);

        $widget->output(function($args, $instance)
        {
            $title = apply_filters( 'widget_title', $instance['title'] );

            echo $args['before_widget'];
            if ( !empty($title) )
                echo $args['before_title'] . $title . $args['after_title'];

            echo $args['after_widget'];
        });

    });

## Available field types
Widgify has, for now, these field types build in.
* text
* textarea
* pages
* select
* upload