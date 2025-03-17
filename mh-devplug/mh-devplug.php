<?php // Start output buffering
    ob_start();
/**
 * Plugin Name: MH Plug
 * Plugin URI: https://mhdevstudio.com
 * Description: MH-Plug is a lightweight Elementor addon featuring a sleek, customizable post slider powered by Slick Slider.
 * Version: 1.0
 * Requires at least: 5.2
 * Requires PHP: 7.2
 * Author: MH-DevStudio
 * Author URI: https://mhdevstudio.com
 * License: GPL-2.0-or-later
 * License URI: https://www.gnu.org/licenses/gpl-2.0.html
 * Text Domain: mhds-plug
 * Domain Path: /languages
 */


if (!defined('ABSPATH')) {
    exit; // Prevent direct access
}

// Check if Elementor is installed and active
function mh_plug_check_elementor() {
    if (!did_action('elementor/loaded')) {
        add_action('admin_notices', function () {
            echo '<div class="error"><p><strong>MH Plug</strong> requires Elementor to be installed and activated.</p></div>';
        });
        return;
    }
    add_action('elementor/widgets/register', 'mh_plug_register_widgets');
}
add_action('plugins_loaded', 'mh_plug_check_elementor');

function mh_plug_register_widgets($widgets_manager) {
    require_once plugin_dir_path(__FILE__) . 'widgets/mh-heading-widget.php';
    require_once plugin_dir_path(__FILE__) . 'widgets/mh-post-slider.php';
    require_once plugin_dir_path(__FILE__) . 'widgets/mh-post-widget.php';
    require_once plugin_dir_path(__FILE__) . 'widgets/mh-button-widget.php';
    require_once plugin_dir_path(__FILE__) . 'widgets/mh-testimonials-widget.php';
    
    // Retrieve saved widget options
    $options = get_option('mh_plug_widgets_options', []);
    
    // Register widgets only if enabled in settings
    if ( !empty($options['mh_heading']) ) {
        $widgets_manager->register(new MH_Heading_Widget());
    }
    if ( !empty($options['mh_post_slider']) ) {
        $widgets_manager->register(new MH_Post_Slider_Widget());
    }
    if ( !empty($options['mh_post']) ) {
        $widgets_manager->register(new MH_Posts_Widget());
    }
    if ( !empty($options['mh_button']) ) {
        $widgets_manager->register(new MH_Button_Widget());
    }
    if ( !empty($options['mh_testimonials']) ) {
        $widgets_manager->register(new MH_Testimonials_Widget());
    }
}
add_action('elementor/widgets/register', 'mh_plug_register_widgets');

// Optional: Create widgets folder if doesn't exist (but don’t create the widget file programmatically)
if (!is_dir(plugin_dir_path(__FILE__) . 'widgets')) {
    mkdir(plugin_dir_path(__FILE__) . 'widgets');
}
// Register custom Elementor category for MH widgets
function mh_add_elementor_widget_categories($elements_manager) {
    $elements_manager->add_category(
        'mh-plug',
        [
            'title' => __('MH Plug', 'mhds-plug'),
            'icon'  => 'fa fa-plug', // You can change this icon
        ]
    );
}
add_action('elementor/elements/categories_registered', 'mh_add_elementor_widget_categories');

// function mh_plug_enqueue_scripts() {
//     wp_enqueue_script('swiper-js', 'https://cdn.jsdelivr.net/npm/swiper@8/swiper-bundle.min.js', ['jquery'], null, true);
//     wp_enqueue_style('swiper-css', 'https://cdn.jsdelivr.net/npm/swiper@8/swiper-bundle.min.css');
//     wp_enqueue_style( 'mh-plug-editor-css',
//         plugin_dir_url(__FILE__) . 'assets/style.css',
//         [],
//         '1.0.0');
// }
// add_action('wp_enqueue_scripts', 'mh_plug_enqueue_scripts');
function mh_enqueue_slick_slider() {
    wp_enqueue_style('slick-css', plugin_dir_url(__FILE__) . 'assets/slick.css', [], '1.0.0');
    wp_enqueue_style('slick-theme-css', plugin_dir_url(__FILE__) . 'assets/slick-theme.css', [], '1.0.0');
    wp_enqueue_script('slick-js', plugin_dir_url(__FILE__) . 'assets/slick.min.js', ['jquery'], '1.8.1', true);
    wp_enqueue_style('elementor-icons', 'https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css', [], '6.4.2');
}
add_action('wp_enqueue_scripts', 'mh_enqueue_slick_slider');

/* ---------------------------------------------
   ✅ Admin Menu & Pages
--------------------------------------------- */
function mh_plug_admin_menu() {
    add_menu_page(
        'MH Plug Settings',
        'MH Plug',
        'manage_options',
        'mh-plug-settings',
        'mh_plug_settings_page',
        'dashicons-admin-generic',
        6
    );
    add_submenu_page(
        'mh-plug-settings',
        'Add New Post Type',
        'Add New Post Type',
        'manage_options',
        'mh-plug-add-cpt',
        'mh_plug_add_cpt_page'
    );
    add_submenu_page(
        'mh-plug-settings',
        'Manage Custom Post Types',
        'Manage Custom Post Types',
        'manage_options',
        'mh-plug-manage-cpt',
        'mh_plug_manage_cpt_page'
    );
    add_submenu_page(
        'mh-plug-settings',
        'Sticky menu',
        'Sticky menu',
        'manage_options',
        'mh-plug-sticky-cpt',
        'mh_plug_sticky_cpt_page'
    );
}
add_action( 'admin_menu', 'mh_plug_admin_menu' );

// Callback for the settings page
function mh_plug_settings_page() {
    ?>
    <div class="wrap">
        <h1><?php _e('MH Plug Settings', 'mhds-plug'); ?></h1>
        <form method="post" action="options.php">
            <?php
                settings_fields('mh_plug_options_group');
                do_settings_sections('mh-plug-settings');
                submit_button();
            ?>
        </form>
    </div>
    <?php
}
function mh_plug_manage_cpt_page() {
    // Start output buffering to prevent header issues
    if (!ob_get_length()) {
        ob_start();
    }
    
    $cpts = get_option('mh_plug_custom_post_types', []);

    // Handle Delete Action Before Any Output
    if (isset($_GET['action']) && $_GET['action'] === 'delete' && !empty($_GET['slug'])) {
        $slug = sanitize_text_field($_GET['slug']);
        if (isset($cpts[$slug])) {
            unset($cpts[$slug]); // Remove from options
            update_option('mh_plug_custom_post_types', $cpts);
            flush_rewrite_rules();

            // Clear the buffer and redirect
            ob_end_clean();
            wp_redirect(admin_url('admin.php?page=mh-plug-manage-cpt'));
            exit; 
        }
    }

    // Handle Update Action
    if (isset($_POST['mh_plug_edit_cpt_submit'])) {
        $slug = sanitize_text_field($_POST['mh_plug_cpt_slug']);
        if (isset($cpts[$slug])) {
            $cpts[$slug]['post_type_name'] = sanitize_text_field($_POST['mh_plug_cpt_name']);
            $cpts[$slug]['supports'] = isset($_POST['mh_plug_supports']) ? $_POST['mh_plug_supports'] : [];
            $cpts[$slug]['taxonomies'] = isset($_POST['mh_plug_taxonomies']) ? $_POST['mh_plug_taxonomies'] : [];
            $cpts[$slug]['comments'] = isset($_POST['mh_plug_comments']) ? 1 : 0;
            update_option('mh_plug_custom_post_types', $cpts);
            flush_rewrite_rules();

            // Redirect with updated parameter to show success message and keep form visible
            ob_end_clean();
            wp_redirect(admin_url('admin.php?page=mh-plug-manage-cpt&action=edit&slug=' . $slug . '&updated=true'));
            exit;
        }
    }

    // Now output the page content
    echo '<div class="wrap"><h1>Manage Custom Post Types</h1>';
    if (!empty($cpts)) {
        echo '<table class="wp-list-table widefat fixed striped">';
        echo '<thead><tr><th>Name</th><th>Slug</th><th>Actions</th></tr></thead><tbody>';
        foreach ($cpts as $slug => $cpt) {
            echo '<tr>';
            echo '<td>' . esc_html($cpt['post_type_name']) . '</td>';
            echo '<td>' . esc_html($cpt['post_type_slug']) . '</td>';
            echo '<td>';
            echo '<a href="' . esc_url(add_query_arg(['page' => 'mh-plug-manage-cpt', 'action' => 'delete', 'slug' => $slug], admin_url('admin.php'))) . '" onclick="return confirm(\'Are you sure?\');">Delete</a> | ';
            echo '<a href="' . esc_url(add_query_arg(['page' => 'mh-plug-manage-cpt', 'action' => 'edit', 'slug' => $slug], admin_url('admin.php'))) . '">Edit</a>';
            echo '</td>';
            echo '</tr>';
        }
        echo '</tbody></table>';
    } else {
        echo '<p>No custom post types found.</p>';
    }
    echo '</div>';

    // Handle Edit Action and display the edit form
    if (isset($_GET['action']) && $_GET['action'] === 'edit' && !empty($_GET['slug'])) {
        $slug = sanitize_text_field($_GET['slug']);
        if (isset($cpts[$slug])) {
            $cpt = $cpts[$slug];
            if (isset($_GET['updated']) && $_GET['updated'] === 'true') {
                echo '<div class="updated"><p>Custom post type updated successfully.</p></div>';
            }
            ?>
            <div class="wrap">
                <h1>Edit Custom Post Type</h1>
                <form method="post">
                    <input type="hidden" name="mh_plug_cpt_slug" value="<?php echo esc_attr($slug); ?>">
                    <table class="form-table">
                        <tr>
                            <th>Post Type Name:</th>
                            <td><input type="text" name="mh_plug_cpt_name" value="<?php echo esc_attr($cpt['post_type_name']); ?>" required></td>
                        </tr>
                        <tr>
                            <th>Supports:</th>
                            <td>
                                <label><input type="checkbox" name="mh_plug_supports[]" value="title" <?php checked(in_array('title', $cpt['supports'])); ?>> Title</label><br>
                                <label><input type="checkbox" name="mh_plug_supports[]" value="editor" <?php checked(in_array('editor', $cpt['supports'])); ?>> Editor</label><br>
                                <label><input type="checkbox" name="mh_plug_supports[]" value="excerpt" <?php checked(in_array('excerpt', $cpt['supports'])); ?>> Excerpt</label><br>
                                <label><input type="checkbox" name="mh_plug_supports[]" value="thumbnail" <?php checked(in_array('thumbnail', $cpt['supports'])); ?>> Featured Image</label><br>
                            </td>
                        </tr>
                        <tr>
                            <th>Enable Comments:</th>
                            <td><input type="checkbox" name="mh_plug_comments" value="1" <?php checked(!empty($cpt['comments'])); ?>></td>
                        </tr>
                    </table>
                    <?php submit_button('Update Custom Post Type', 'primary', 'mh_plug_edit_cpt_submit'); ?>
                </form>
            </div>
            <?php
        }
    }
    // Flush the buffer at the end
    ob_end_flush();
}


function mh_plug_add_cpt_page() {
    if ( isset( $_POST['mh_plug_new_cpt_submit'] ) && check_admin_referer( 'mh_plug_new_cpt', 'mh_plug_nonce' ) ) {
        $post_type_name = sanitize_text_field( $_POST['mh_plug_cpt_name'] );
        $post_type_slug = sanitize_title( $_POST['mh_plug_cpt_slug'] );
        
        // Supports toggles
        $supports = [];
        if ( ! empty( $_POST['mh_plug_supports_title'] ) ) {
            $supports[] = 'title';
        }
        if ( ! empty( $_POST['mh_plug_supports_editor'] ) ) {
            $supports[] = 'editor';
        }
        if ( ! empty( $_POST['mh_plug_supports_excerpt'] ) ) {
            $supports[] = 'excerpt';
        }
        if ( ! empty( $_POST['mh_plug_supports_thumbnail'] ) ) {
            $supports[] = 'thumbnail';
        }
        if ( ! empty( $_POST['mh_plug_supports_comments'] ) ) {
            $supports[] = 'comments';
        }
        
        // Taxonomies toggles
        $taxonomies = [];
        if ( ! empty( $_POST['mh_plug_tax_category'] ) ) {
            $taxonomies[] = 'category';
        }
        if ( ! empty( $_POST['mh_plug_tax_tag'] ) ) {
            $taxonomies[] = 'post_tag';
        }
        
        $new_cpt = [
            'post_type_name' => $post_type_name,
            'post_type_slug' => $post_type_slug,
            'supports'       => $supports,
            'taxonomies'     => $taxonomies,
        ];
        
        $existing_cpts = get_option( 'mh_plug_custom_post_types', [] );
        $existing_cpts[ $post_type_slug ] = $new_cpt;
        update_option( 'mh_plug_custom_post_types', $existing_cpts );
        
        flush_rewrite_rules();
        
        echo '<div class="updated"><p>' . sprintf( __('Custom post type "%s" created successfully.', 'mhds-plug'), $post_type_name ) . '</p></div>';
    }
    ?>
    <div class="wrap">
        <h1><?php _e('Add New Custom Post Type', 'mhds-plug'); ?></h1>
        <form method="post" action="">
            <?php wp_nonce_field( 'mh_plug_new_cpt', 'mh_plug_nonce' ); ?>
            <table class="form-table">
                <tr valign="top">
                    <th scope="row"><?php _e('Post Type Name', 'mhds-plug'); ?></th>
                    <td><input type="text" name="mh_plug_cpt_name" required /></td>
                </tr>
                <tr valign="top">
                    <th scope="row"><?php _e('Post Type Slug', 'mhds-plug'); ?></th>
                    <td><input type="text" name="mh_plug_cpt_slug" required /></td>
                </tr>
                <tr valign="top">
                    <th scope="row"><?php _e('Supports', 'mhds-plug'); ?></th>
                    <td>
                        <label><input type="checkbox" name="mh_plug_supports_title" value="1" checked> <?php _e('Title', 'mhds-plug'); ?></label><br>
                        <label><input type="checkbox" name="mh_plug_supports_editor" value="1" checked> <?php _e('Editor', 'mhds-plug'); ?></label><br>
                        <label><input type="checkbox" name="mh_plug_supports_excerpt" value="1" checked> <?php _e('Excerpt', 'mhds-plug'); ?></label><br>
                        <label><input type="checkbox" name="mh_plug_supports_thumbnail" value="1" checked> <?php _e('Featured Image', 'mhds-plug'); ?></label><br>
                        <label><input type="checkbox" name="mh_plug_supports_comments" value="1"> <?php _e('Comments', 'mhds-plug'); ?></label><br>
                    </td>
                </tr>
                <tr valign="top">
                    <th scope="row"><?php _e('Taxonomies', 'mhds-plug'); ?></th>
                    <td>
                        <label><input type="checkbox" name="mh_plug_tax_category" value="1" checked> <?php _e('Category', 'mhds-plug'); ?></label><br>
                        <label><input type="checkbox" name="mh_plug_tax_tag" value="1" checked> <?php _e('Tag', 'mhds-plug'); ?></label><br>
                    </td>
                </tr>
            </table>
            <?php submit_button( __('Add New Post Type', 'mhds-plug'), 'primary', 'mh_plug_new_cpt_submit' ); ?>
        </form>
    </div>
    <?php
}
/* ---------------------------------------------
   ✅ Register Custom Post Types from Database
--------------------------------------------- */
function mh_plug_register_custom_post_types() {
    $custom_post_types = get_option('mh_plug_custom_post_types', []);
    if (!empty($custom_post_types)) {
        foreach ($custom_post_types as $slug => $cpt) {
            // Build labels array
            $labels = array(
                'name'               => _x($cpt['post_type_name'] . 's', 'Post Type General Name', 'mhds-plug'),
                'singular_name'      => _x($cpt['post_type_name'], 'Post Type Singular Name', 'mhds-plug'),
                'menu_name'          => $cpt['post_type_name'],
                'name_admin_bar'     => $cpt['post_type_name'],
                'archives'           => __('Archives', 'mhds-plug'),
                'attributes'         => __('Attributes', 'mhds-plug'),
                'parent_item_colon'  => __('Parent Item:', 'mhds-plug'),
                'all_items'          => __('All Items', 'mhds-plug'),
                'add_new_item'       => __('Add New ' . $cpt['post_type_name'], 'mhds-plug'),
                'add_new'            => __('Add New', 'mhds-plug'),
                'new_item'           => __('New ' . $cpt['post_type_name'], 'mhds-plug'),
                'edit_item'          => __('Edit ' . $cpt['post_type_name'], 'mhds-plug'),
                'update_item'        => __('Update ' . $cpt['post_type_name'], 'mhds-plug'),
                'view_item'          => __('View ' . $cpt['post_type_name'], 'mhds-plug'),
                'view_items'         => __('View ' . $cpt['post_type_name'] . 's', 'mhds-plug'),
                'search_items'       => __('Search ' . $cpt['post_type_name'] . 's', 'mhds-plug'),
                'not_found'          => __('Not found', 'mhds-plug'),
                'not_found_in_trash' => __('Not found in Trash', 'mhds-plug'),
            );

            $args = array(
                'labels'             => $labels,
                'public'             => true,
                'has_archive'        => true,
                'supports'           => !empty($cpt['supports']) ? $cpt['supports'] : ['title', 'editor'],
                'taxonomies'         => !empty($cpt['taxonomies']) ? $cpt['taxonomies'] : [],
                'show_in_menu'       => true,
                'show_in_rest'       => true, // Enable Gutenberg support
                'rewrite'            => ['slug' => $cpt['post_type_slug']],
            );
            register_post_type($cpt['post_type_slug'], $args);

                // Explicitly register taxonomies if selected
            if (!empty($cpt['taxonomies'])) {
                if (in_array('category', $cpt['taxonomies'])) {
                    register_taxonomy_for_object_type('category', $cpt['post_type_slug']);
                }
                if (in_array('post_tag', $cpt['taxonomies'])) {
                        register_taxonomy_for_object_type('post_tag', $cpt['post_type_slug']);
                }
            }
        }
    }
}
add_action('init', 'mh_plug_register_custom_post_types');

function mh_plug_register_settings() {
    // Register a single option to hold widget switches
    register_setting('mh_plug_options_group', 'mh_plug_widgets_options');
    register_setting('mh_plug_options_group', 'mh_display_page_title'); // Register page title toggle

    // Add a section for widget switches
    add_settings_section(
        'mh_plug_widgets_section',
        __('Widget Enable/Disable', 'mhds-plug'),
        '__return_null',
        'mh-plug-settings'
    );

    // Define an array of widget keys and labels
    $widgets = [
        'mh_heading'      => __('Heading Widget', 'mhds-plug'),
        'mh_post_slider'  => __('Post Slider Widget', 'mhds-plug'),
        'mh_button'       => __('Button Widget', 'mhds-plug'),
        'mh_testimonials' => __('Testimonials Widget', 'mhds-plug'),
        'mh_post' => __('Post Widget', 'mhds-plug'),
    ];
 // Add the "Display Page Title" on/off switch field.
 // Add a new field for the "Display Page Title" option
 add_settings_field(
    'mh_display_page_title',
    __('Display Page Title', 'mhds-plug'),
    'mh_display_page_title_callback',
    'mh-plug-settings',
    'mh_plug_widgets_section'
);

    // Create a checkbox field for each widget
    foreach ($widgets as $widget_key => $widget_label) {
        add_settings_field(
            $widget_key,
            $widget_label,
            'mh_plug_widget_field_callback',
            'mh-plug-settings',
            'mh_plug_widgets_section',
            ['id' => $widget_key]
        );
    }
}
add_action('admin_init', 'mh_plug_register_settings');


// Callback function to render a widget checkbox field
function mh_plug_widget_field_callback($args) {
    $options = get_option('mh_plug_widgets_options', []);
    $id = $args['id'];
    $checked = isset($options[$id]) && $options[$id] ? 'checked' : '';
    echo "<input type='checkbox' name='mh_plug_widgets_options[$id]' value='1' $checked />";
}
function mh_display_page_title_callback() {
    $value = get_option('mh_display_page_title', 1); // Default to enabled (1)
    echo '<label><input type="checkbox" name="mh_display_page_title" value="1" ' . checked($value, 1, false) . ' /> Enable Page Title</label>';
}








/**
 * Display the Plugin Settings Page (Sticky Menu Settings)
 */
function mh_plug_sticky_cpt_page() {
    ?>
    <div class="wrap">
        <h1>MH DevPlug Sticky Menu Settings</h1>
        <form method="post" action="options.php">
            <?php
            settings_fields('mh_devplug_settings');
            do_settings_sections('mh-plug-sticky-cpt');
            submit_button();
            ?>
        </form>
    </div>
    <?php
}


/**
 * Register Plugin Settings
 */
function mh_devplug_register_settings() {
    // Register settings with a sanitize callback to force an array for except pages
    register_setting('mh_devplug_settings', 'mh_sticky_selector');
    register_setting('mh_devplug_settings', 'mh_sticky_effect');
    register_setting('mh_devplug_settings', 'mh_sticky_transition');
    register_setting('mh_devplug_settings', 'mh_sticky_disable_pages');
    register_setting('mh_devplug_settings', 'mh_sticky_except_pages', [
        'sanitize_callback' => function ($input) {
            return is_array($input) ? array_map('sanitize_text_field', $input) : [];
        }
    ]);

    add_settings_section('mh_sticky_menu_section', 'Sticky Menu Settings', null, 'mh-plug-sticky-cpt');

    add_settings_field('mh_sticky_selector', 'Sticky Class/ID/Tag', 'mh_sticky_selector_callback', 'mh-plug-sticky-cpt', 'mh_sticky_menu_section');
    add_settings_field('mh_sticky_effect', 'Sticky Effect', 'mh_sticky_effect_callback', 'mh-plug-sticky-cpt', 'mh_sticky_menu_section');
    add_settings_field('mh_sticky_transition', 'Transition Time (ms)', 'mh_sticky_transition_callback', 'mh-plug-sticky-cpt', 'mh_sticky_menu_section');
    add_settings_field('mh_sticky_disable_pages', 'Disable on These Pages', 'mh_sticky_disable_callback', 'mh-plug-sticky-cpt', 'mh_sticky_menu_section');
    add_settings_field('mh_sticky_except_pages', 'Except for These Pages', 'mh_sticky_except_callback', 'mh-plug-sticky-cpt', 'mh_sticky_menu_section');
}
add_action('admin_init', 'mh_devplug_register_settings');

/**
 * Callback for Sticky Selector field
 */
function mh_sticky_selector_callback() {
    $value = get_option('mh_sticky_selector', '');
    echo "<input type='text' name='mh_sticky_selector' value='" . esc_attr($value) . "' placeholder='.menu or #menu' />";
}

/**
 * Callback for Sticky Effect field
 */
function mh_sticky_effect_callback() {
    $value = get_option('mh_sticky_effect', 'none');
    ?>
    <select name="mh_sticky_effect">
        <option value="none" <?php selected($value, 'none'); ?>>None</option>
        <option value="fade" <?php selected($value, 'fade'); ?>>Fade</option>
        <option value="slide" <?php selected($value, 'slide'); ?>>Slide</option>
    </select>
    <?php
}

/**
 * Callback for Transition Time field
 */
function mh_sticky_transition_callback() {
    $value = get_option('mh_sticky_transition', '300');
    echo "<input type='number' name='mh_sticky_transition' value='" . esc_attr($value) . "' min='0' /> ms";
}

/**
 * Callback for Disable Pages field
 */
function mh_sticky_disable_callback() {
    $options = get_option('mh_sticky_disable_pages', []);
    $pages = [
        'front_page' => 'Front Page',
        'blog_page'  => 'Blog Page',
        'pages'      => 'Pages',
        'tags'       => 'Tags',
        'categories' => 'Categories',
        'posts'      => 'Posts',
        'archives'   => 'Archives',
        'search'     => 'Search',
        '404'        => '404 Page'
    ];

    foreach ($pages as $key => $label) {
        $checked = in_array($key, (array)$options) ? 'checked' : '';
        echo "<label><input type='checkbox' name='mh_sticky_disable_pages[]' value='$key' $checked> $label</label><br>";
    }
}


function mh_sticky_except_callback() {
    // Retrieve the option; ensure it's an array
    $values = get_option('mh_sticky_except_pages', []);
    if ( ! is_array($values) ) {
        // If stored as a comma-separated string, convert it into an array
        $values = array_filter(array_map('trim', explode(',', $values)));
    }
    
    echo '<div id="except-pages-container">';
    if ( ! empty($values) ) {
        foreach ($values as $value) {
            echo '<div class="except-page-item">
                    <input type="text" name="mh_sticky_except_pages[]" value="' . esc_attr($value) . '" />
                    <button type="button" class="remove-field">Remove</button>
                  </div>';
        }
    }
    echo '</div>';
    echo '<button type="button" id="add-except-page">Add More</button>';
}


function mh_devplug_admin_scripts($hook) {
    // For debugging, comment out the hook check so the script always runs
    // if ($hook !== 'toplevel_page_mh-devplug') return;
    ?>
    <script type="text/javascript">
        jQuery(document).ready(function($) {
            console.log("Admin script loaded on hook: <?php echo esc_js($hook); ?>");
            
            $("#add-except-page").on("click", function() {
                console.log("Add More button clicked");
                $("#except-pages-container").append(
                    '<div class="except-page-item"><input type="text" name="mh_sticky_except_pages[]" /> <button type="button" class="remove-field">Remove</button></div>'
                );
            });
            
            $("#except-pages-container").on("click", ".remove-field", function() {
                console.log("Remove button clicked");
                $(this).closest('.except-page-item').remove();
            });
        });
    </script>
    <?php
}
add_action('admin_footer', 'mh_devplug_admin_scripts');




// Check if the "Display Page Title" option is enabled
function mh_control_page_title() {
    $show_title = get_option('mh_display_page_title', 1); // Default to enabled (1)

    if (!$show_title) {
        echo '<style> .entry-title, .page-title, h1 { display: none !important; } </style>';
    }
}
add_action('wp_head', 'mh_control_page_title');

/**
 * Enqueue Frontend JavaScript for Sticky Menu Behavior
 */
function mh_devplug_frontend_scripts() {
    $selector      = get_option('mh_sticky_selector', '');
    $effect        = get_option('mh_sticky_effect', 'none');
    $transition    = get_option('mh_sticky_transition', '300');
    $disable_pages = get_option('mh_sticky_disable_pages', []);
    $except_pages  = get_option('mh_sticky_except_pages', []);

    if ( ! $selector ) {
        return;
    }

    // Determine current page type
    $current_page = is_front_page() ? 'front_page' :
                    (is_home() ? 'blog_page' :
                    (is_page() ? 'pages' :
                    (is_tag() ? 'tags' :
                    (is_category() ? 'categories' :
                    (is_single() ? 'posts' :
                    (is_archive() ? 'archives' :
                    (is_search() ? 'search' :
                    (is_404() ? '404' : ''))))))));

    // Skip sticky behavior if current page type is disabled
    if ( in_array( $current_page, (array)$disable_pages ) ) {
        return;
    }
   


    // For singular pages, check if current page ID is in the except list
    if ( is_singular() ) {
        $current_slug = get_post_field('post_name', get_the_ID());
        if ( in_array($current_slug, (array)$except_pages) ) {
            error_log("MH DevPlug: Current singular page slug ($current_slug) is in the except list");
            return;
        }
    }
 
    ?>
    <script>
    document.addEventListener("DOMContentLoaded", function() {
        var menu = document.querySelector("<?php echo esc_js($selector); ?>");
        if (!menu) return;

        window.addEventListener("scroll", function() {
            var scrollTop = window.scrollY || document.documentElement.scrollTop;
            if (scrollTop > 100) {
                menu.classList.add("sticky-menu");
                menu.style.transition = "all <?php echo esc_js($transition); ?>ms";
                if ("<?php echo esc_js($effect); ?>" === "fade") {
                    menu.style.opacity = 1;
                } else if ("<?php echo esc_js($effect); ?>" === "slide") {
                    menu.style.transform = "translateY(0)";
                }
            } else {
                menu.classList.remove("sticky-menu");
                menu.style.opacity = "";
                menu.style.transform = "";
            }
        });
    });
    </script>
    <?php
}
add_action('wp_footer', 'mh_devplug_frontend_scripts');

/**
 * Enqueue Frontend CSS for Sticky Menu Styling
 */
function mh_devplug_enqueue_styles() {
    ?>
    <style>
        /* Basic CSS for sticky menu; adjust as needed */
        .sticky-menu {
            position: fixed;
            top: 0;
            width: 100%;
            z-index: 9999;
        }
    </style>
    <?php
}
add_action('wp_head', 'mh_devplug_enqueue_styles');
