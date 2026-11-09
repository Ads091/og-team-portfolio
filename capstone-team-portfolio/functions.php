<?php
/** Theme functions for Capstone Team Portfolio. */
if ( ! defined( 'ABSPATH' ) ) { exit; }

define( 'CTP_VERSION', '1.0.0' );

function ctp_theme_setup() {
    load_theme_textdomain( 'capstone-team-portfolio', get_template_directory() . '/languages' );
    add_theme_support( 'title-tag' );
    add_theme_support( 'post-thumbnails' );
    add_theme_support( 'custom-logo', array( 'height' => 80, 'width' => 240, 'flex-height' => true, 'flex-width' => true ) );
    add_theme_support( 'html5', array( 'search-form', 'comment-form', 'comment-list', 'gallery', 'caption', 'style', 'script' ) );
    add_theme_support( 'responsive-embeds' );
    register_nav_menus( array(
        'primary' => __( 'Primary Menu', 'capstone-team-portfolio' ),
        'footer'  => __( 'Footer Menu', 'capstone-team-portfolio' ),
    ) );
}
add_action( 'after_setup_theme', 'ctp_theme_setup' );

function ctp_enqueue_assets() {
    wp_enqueue_style( 'ctp-style', get_stylesheet_uri(), array(), CTP_VERSION );
    wp_enqueue_script( 'ctp-main', get_template_directory_uri() . '/assets/js/main.js', array(), CTP_VERSION, true );
}
add_action( 'wp_enqueue_scripts', 'ctp_enqueue_assets' );

function ctp_register_team_member_cpt() {
    $labels = array(
        'name' => __( 'Team Members', 'capstone-team-portfolio' ),
        'singular_name' => __( 'Team Member', 'capstone-team-portfolio' ),
        'add_new_item' => __( 'Add New Team Member', 'capstone-team-portfolio' ),
        'edit_item' => __( 'Edit Team Member', 'capstone-team-portfolio' ),
        'new_item' => __( 'New Team Member', 'capstone-team-portfolio' ),
        'view_item' => __( 'View Team Member', 'capstone-team-portfolio' ),
        'search_items' => __( 'Search Team Members', 'capstone-team-portfolio' ),
        'not_found' => __( 'No team members found.', 'capstone-team-portfolio' ),
        'menu_name' => __( 'Team Members', 'capstone-team-portfolio' ),
    );
    register_post_type( 'ctp_member', array(
        'labels' => $labels,
        'public' => true,
        'show_in_rest' => true,
        'has_archive' => false,
        'menu_icon' => 'dashicons-groups',
        'supports' => array( 'title', 'editor', 'excerpt', 'thumbnail', 'page-attributes' ),
        'rewrite' => array( 'slug' => 'team-member' ),
    ) );
}
add_action( 'init', 'ctp_register_team_member_cpt' );

function ctp_add_member_meta_box() {
    add_meta_box( 'ctp_member_details', __( 'Member Details', 'capstone-team-portfolio' ), 'ctp_member_meta_box_html', 'ctp_member', 'normal', 'default' );
}
add_action( 'add_meta_boxes', 'ctp_add_member_meta_box' );

function ctp_member_meta_box_html( $post ) {
    wp_nonce_field( 'ctp_save_member_details', 'ctp_member_nonce' );
    $role = get_post_meta( $post->ID, '_ctp_member_role', true );
    $skills = get_post_meta( $post->ID, '_ctp_member_skills', true );
    $order = get_post_meta( $post->ID, '_ctp_member_order', true );
    ?>
    <p><label for="ctp_member_role"><strong><?php esc_html_e( 'Role / Position', 'capstone-team-portfolio' ); ?></strong></label><br><input type="text" id="ctp_member_role" name="ctp_member_role" value="<?php echo esc_attr( $role ); ?>" class="widefat" placeholder="e.g. Project Manager"></p>
    <p><label for="ctp_member_skills"><strong><?php esc_html_e( 'Skills / Specialization', 'capstone-team-portfolio' ); ?></strong></label><br><input type="text" id="ctp_member_skills" name="ctp_member_skills" value="<?php echo esc_attr( $skills ); ?>" class="widefat" placeholder="e.g. UI/UX Design, Research, Programming"></p>
    <p><label for="ctp_member_order"><strong><?php esc_html_e( 'Display order (1–4)', 'capstone-team-portfolio' ); ?></strong></label><br><input type="number" min="1" max="4" id="ctp_member_order" name="ctp_member_order" value="<?php echo esc_attr( $order ); ?>" style="width:100px"></p>
    <p class="description"><?php esc_html_e( 'Use the Featured image box to add this member’s photo. The excerpt is shown as the short profile on the homepage.', 'capstone-team-portfolio' ); ?></p>
    <?php
}

function ctp_save_member_details( $post_id ) {
    if ( ! isset( $_POST['ctp_member_nonce'] ) || ! wp_verify_nonce( sanitize_text_field( wp_unslash( $_POST['ctp_member_nonce'] ) ), 'ctp_save_member_details' ) ) { return; }
    if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) { return; }
    if ( ! current_user_can( 'edit_post', $post_id ) ) { return; }
    if ( get_post_type( $post_id ) !== 'ctp_member' ) { return; }
    $fields = array(
        'ctp_member_role' => '_ctp_member_role',
        'ctp_member_skills' => '_ctp_member_skills',
        'ctp_member_order' => '_ctp_member_order',
    );
    foreach ( $fields as $input => $meta_key ) {
        if ( isset( $_POST[ $input ] ) ) {
            $value = ( 'ctp_member_order' === $input ) ? absint( $_POST[ $input ] ) : sanitize_text_field( wp_unslash( $_POST[ $input ] ) );
            update_post_meta( $post_id, $meta_key, $value );
        }
    }
}
add_action( 'save_post', 'ctp_save_member_details' );

function ctp_customize_register( $wp_customize ) {
    $wp_customize->add_section( 'ctp_homepage', array( 'title' => __( 'Capstone Portfolio Homepage', 'capstone-team-portfolio' ), 'priority' => 30 ) );
    $settings = array(
        'ctp_eyebrow' => array( 'label' => 'Hero eyebrow', 'default' => 'CAPSTONE TEAM PORTFOLIO' ),
        'ctp_hero_title' => array( 'label' => 'Hero headline', 'default' => 'Four Minds. One Vision. One Innovation.' ),
        'ctp_hero_description' => array( 'label' => 'Hero description', 'default' => 'Meet the people behind our capstone project. Explore our skills, individual contributions, and collaborative journey.' ),
        'ctp_project_title' => array( 'label' => 'Capstone project title', 'default' => 'Our Capstone Project' ),
        'ctp_project_description' => array( 'label' => 'Capstone project description', 'default' => 'This is where you can introduce your capstone project, explain the problem it addresses, and describe the solution your team developed.' ),
        'ctp_contact_email' => array( 'label' => 'Contact email', 'default' => get_option( 'admin_email' ) ),
    );
    foreach ( $settings as $id => $args ) {
        $wp_customize->add_setting( $id, array( 'default' => $args['default'], 'sanitize_callback' => ( 'ctp_contact_email' === $id ) ? 'sanitize_email' : 'sanitize_text_field' ) );
        $wp_customize->add_control( $id, array( 'label' => $args['label'], 'section' => 'ctp_homepage', 'type' => 'text' ) );
    }
}
add_action( 'customize_register', 'ctp_customize_register' );

function ctp_get_option( $key, $default = '' ) {
    return get_theme_mod( $key, $default );
}

function ctp_default_content_setup() {
    if ( get_option( 'ctp_default_content_created' ) ) { return; }
    $pages = array(
        'Home' => array( 'slug' => 'home', 'content' => '' ),
        'About Our Team' => array( 'slug' => 'about-our-team', 'content' => '<!-- wp:paragraph --><p>Introduce your team, your academic program, and the shared goals that brought you together.</p><!-- /wp:paragraph -->' ),
        'Our Capstone Project' => array( 'slug' => 'our-capstone-project', 'content' => '<!-- wp:paragraph --><p>Describe your capstone project, its problem statement, objectives, scope, methodology, and expected outcomes.</p><!-- /wp:paragraph -->' ),
        'Contact' => array( 'slug' => 'contact', 'content' => '<!-- wp:paragraph --><p>Add your team’s official contact information here.</p><!-- /wp:paragraph -->' ),
    );
    $home_id = 0;
    foreach ( $pages as $title => $data ) {
        $existing = get_page_by_path( $data['slug'] );
        if ( $existing ) { $page_id = $existing->ID; }
        else {
            $page_id = wp_insert_post( array( 'post_title' => $title, 'post_name' => $data['slug'], 'post_content' => $data['content'], 'post_status' => 'publish', 'post_type' => 'page' ) );
        }
        if ( 'Home' === $title && ! is_wp_error( $page_id ) ) { $home_id = (int) $page_id; }
    }
    if ( $home_id ) {
        update_option( 'show_on_front', 'page' );
        update_option( 'page_on_front', $home_id );
    }
    $sample_members = array(
        array( 'Member 1', 'Team Leader / Project Manager', 1 ),
        array( 'Member 2', 'Research and Documentation', 2 ),
        array( 'Member 3', 'Design and Development', 3 ),
        array( 'Member 4', 'Testing and Quality Assurance', 4 ),
    );
    foreach ( $sample_members as $member ) {
        $existing = get_page_by_title( $member[0], OBJECT, 'ctp_member' );
        if ( ! $existing ) {
            $member_id = wp_insert_post( array( 'post_type' => 'ctp_member', 'post_status' => 'publish', 'post_title' => $member[0], 'post_excerpt' => 'Replace this text with a short introduction describing this team member’s background and contribution.' ) );
            if ( $member_id && ! is_wp_error( $member_id ) ) {
                update_post_meta( $member_id, '_ctp_member_role', $member[1] );
                update_post_meta( $member_id, '_ctp_member_order', $member[2] );
            }
        }
    }
    update_option( 'ctp_default_content_created', 1 );
}
add_action( 'after_switch_theme', 'ctp_default_content_setup' );

function ctp_member_query() {
    return new WP_Query( array(
        'post_type' => 'ctp_member',
        'post_status' => 'publish',
        'posts_per_page' => 4,
        'meta_key' => '_ctp_member_order',
        'orderby' => array( 'meta_value_num' => 'ASC', 'date' => 'ASC' ),
    ) );
}
