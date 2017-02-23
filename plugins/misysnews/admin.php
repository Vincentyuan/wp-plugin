<?php
class MisysNewsSettingsPage
{
    /**
     * Holds the values to be used in the fields callbacks
     */
    private $options;

    /**
     * Start up
     */
    public function __construct()
    {
        add_action( 'admin_menu', array( $this, 'add_plugin_page' ) );
        add_action( 'admin_init', array( $this, 'page_init' ) );
    }

    /**
     * Add options page
     */
    public function add_plugin_page()
    {
        // This page will be under "Settings"
        add_options_page(
            'Settings Admin', 
            'Misys News',
            'manage_options', 
            'misysnews', 
            array( $this, 'create_admin_page' )
        );
    }

    /**
     * Options page callback
     */
    public function create_admin_page()
    {
        // Set class property
        $this->options = get_option( 'misysnews_feeds' );
        ?>
        <div class="wrap">
            <h2>Misys News</h2>           
            <form method="post" action="options.php">
            <?php
                // This prints out all hidden setting fields
                settings_fields( 'misysnews_feeds_group' );   
                do_settings_sections( 'misysnews-admin' );
                submit_button(); 
            ?>
            </form>
        </div>
        <?php
    }

    /**
     * Register and add settings
     */
    public function page_init()
    {        
        register_setting(
            'misysnews_feeds_group', // Option group
            'misysnews_feeds', // Option name
            array( $this, 'sanitize' ) // Sanitize
        );

        add_settings_section(
            'misysnews_feeds_section_id', // ID
            'Configuration des sources', // Title
            array( $this, 'print_section_info' ), // Callback
            'misysnews-admin' // Page
        );     

        add_settings_field(
            'json_data', 
            'Définition', 
            array( $this, 'json_data_callback' ), 
            'misysnews-admin', 
            'misysnews_feeds_section_id'
        );      
    }

    /**
     * Sanitize each setting field as needed
     *
     * @param array $input Contains all settings fields as array keys
     */
    public function sanitize( $input )
    {
        $new_input = array();

        if( isset( $input['json_data'] ) ) {
            $new_input['json_data'] = $input['json_data'];
        }

        return $new_input;
    }

    /** 
     * Print the Section text
     */
    public function print_section_info()
    {
        print 'Modifier le JSON ci-dessous:';
    }

    /** 
     * Get the settings option array and print one of its values
     */
    public function json_data_callback()
    {
        printf(
            '<textarea  id="json_data" name="misysnews_feeds[json_data]" type="textarea" cols="150" rows="20" style="resize:none;">%s</textarea>',
            isset( $this->options['json_data'] ) ? esc_attr( $this->options['json_data']) : ''
        );
    }
}

if( is_admin() )
    $misysnews_settings_page = new MisysNewsSettingsPage();