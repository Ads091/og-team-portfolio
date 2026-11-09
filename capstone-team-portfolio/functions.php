<?php
/** Theme functions for Capstone Team Portfolio. */
if ( ! defined( 'ABSPATH' ) ) { exit; }

define( 'CTP_VERSION', '3.0.3' );

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
    wp_enqueue_style( 'ctp-fonts', 'https://fonts.googleapis.com/css2?family=Instrument+Serif:ital@0;1&family=Hanken+Grotesk:wght@400;500;600&family=JetBrains+Mono:wght@400;500&display=swap', array(), null );
    wp_enqueue_style( 'ctp-style', get_stylesheet_uri(), array( 'ctp-fonts' ), CTP_VERSION );
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
    $email = get_post_meta( $post->ID, '_ctp_member_email', true );
    ?>
    <p><label for="ctp_member_role"><strong><?php esc_html_e( 'Role / Position', 'capstone-team-portfolio' ); ?></strong></label><br><input type="text" id="ctp_member_role" name="ctp_member_role" value="<?php echo esc_attr( $role ); ?>" class="widefat" placeholder="e.g. Project Manager"></p>
    <p><label for="ctp_member_skills"><strong><?php esc_html_e( 'Skills / Specialization', 'capstone-team-portfolio' ); ?></strong></label><br><input type="text" id="ctp_member_skills" name="ctp_member_skills" value="<?php echo esc_attr( $skills ); ?>" class="widefat" placeholder="e.g. UI/UX Design, Research, Programming"></p>
    <p><label for="ctp_member_order"><strong><?php esc_html_e( 'Display order', 'capstone-team-portfolio' ); ?></strong></label><br><input type="number" min="1" id="ctp_member_order" name="ctp_member_order" value="<?php echo esc_attr( $order ); ?>" style="width:100px"></p>
    <p><label for="ctp_member_email"><strong><?php esc_html_e( 'Contact email (private)', 'capstone-team-portfolio' ); ?></strong></label><br><input type="email" id="ctp_member_email" name="ctp_member_email" value="<?php echo esc_attr( $email ); ?>" class="widefat" placeholder="member@example.com"><span class="description"><?php esc_html_e( 'Used only to route contact form messages. This address is never displayed publicly.', 'capstone-team-portfolio' ); ?></span></p>
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
        'ctp_member_email' => '_ctp_member_email',
    );
    foreach ( $fields as $input => $meta_key ) {
        if ( isset( $_POST[ $input ] ) && is_scalar( $_POST[ $input ] ) ) {
            if ( 'ctp_member_order' === $input ) {
                $value = absint( $_POST[ $input ] );
            } elseif ( 'ctp_member_email' === $input ) {
                $value = sanitize_email( wp_unslash( $_POST[ $input ] ) );
            } else {
                $value = sanitize_text_field( wp_unslash( $_POST[ $input ] ) );
            }
            update_post_meta( $post_id, $meta_key, $value );
        }
    }
}
add_action( 'save_post', 'ctp_save_member_details' );

function ctp_customize_register( $wp_customize ) {
    $wp_customize->add_section( 'ctp_homepage', array( 'title' => __( 'Capstone Portfolio Homepage', 'capstone-team-portfolio' ), 'priority' => 30 ) );
    $settings = array(
        'ctp_brand_name' => array( 'label' => 'Team name (header, footer and browser tab)', 'default' => 'OG Team Portfolio' ),
        'ctp_eyebrow' => array( 'label' => 'Hero eyebrow', 'default' => 'OG TEAM PORTFOLIO' ),
        'ctp_hero_title' => array( 'label' => 'Hero headline', 'default' => 'Four Minds. One Vision. One Innovation.' ),
        'ctp_hero_description' => array( 'label' => 'Hero description', 'default' => 'Meet the people behind our capstone project. Explore our skills, individual contributions, and collaborative journey.' ),
        'ctp_project_title' => array( 'label' => 'Capstone project title', 'default' => 'Our Capstone Project' ),
        'ctp_project_description' => array( 'label' => 'Capstone project description', 'default' => 'This is where you can introduce your capstone project, explain the problem it addresses, and describe the solution your team developed.' ),
        'ctp_contact_email' => array( 'label' => 'Contact email', 'default' => get_option( 'admin_email' ) ),
    );
    foreach ( $settings as $id => $args ) {
        $wp_customize->add_setting( $id, array( 'default' => $args['default'], 'sanitize_callback' => ( 'ctp_contact_email' === $id ) ? 'sanitize_email' : 'sanitize_text_field' ) );
        $wp_customize->add_control( $id, array( 'label' => $args['label'], 'section' => 'ctp_homepage', 'type' => ( 'ctp_contact_email' === $id ) ? 'email' : 'text', 'description' => ( 'ctp_contact_email' === $id ) ? __( 'Team inbox for contact form inquiries. Individual member addresses are managed under Team Members.', 'capstone-team-portfolio' ) : '' ) );
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
        'posts_per_page' => -1,
        'meta_key' => '_ctp_member_order',
        'orderby' => array( 'meta_value_num' => 'ASC', 'date' => 'ASC' ),
    ) );
}

/** Register the portfolio project content type and its filterable categories. */
function ctp_register_project_content() {
    register_post_type( 'ctp_project', array(
        'labels' => array(
            'name' => __( 'Projects', 'capstone-team-portfolio' ),
            'singular_name' => __( 'Project', 'capstone-team-portfolio' ),
            'add_new_item' => __( 'Add New Project', 'capstone-team-portfolio' ),
            'edit_item' => __( 'Edit Project', 'capstone-team-portfolio' ),
            'view_item' => __( 'View Project', 'capstone-team-portfolio' ),
            'search_items' => __( 'Search Projects', 'capstone-team-portfolio' ),
            'not_found' => __( 'No projects found.', 'capstone-team-portfolio' ),
            'menu_name' => __( 'Projects', 'capstone-team-portfolio' ),
        ),
        'public' => true,
        'show_in_rest' => true,
        'has_archive' => true,
        'menu_icon' => 'dashicons-portfolio',
        'supports' => array( 'title', 'editor', 'excerpt', 'thumbnail', 'revisions' ),
        'rewrite' => array( 'slug' => 'projects' ),
    ) );

    register_taxonomy( 'ctp_project_category', 'ctp_project', array(
        'labels' => array(
            'name' => __( 'Project Categories', 'capstone-team-portfolio' ),
            'singular_name' => __( 'Project Category', 'capstone-team-portfolio' ),
            'add_new_item' => __( 'Add Project Category', 'capstone-team-portfolio' ),
        ),
        'public' => true,
        'hierarchical' => true,
        'show_in_rest' => true,
        'rewrite' => array( 'slug' => 'project-category' ),
    ) );
}
add_action( 'init', 'ctp_register_project_content', 11 );

/** Add project details used by the project cards and single-project page. */
function ctp_add_project_meta_box() {
    add_meta_box( 'ctp_project_details', __( 'Project Details', 'capstone-team-portfolio' ), 'ctp_project_meta_box_html', 'ctp_project', 'side', 'default' );
}
add_action( 'add_meta_boxes', 'ctp_add_project_meta_box' );

function ctp_project_meta_box_html( $post ) {
    wp_nonce_field( 'ctp_save_project_details', 'ctp_project_nonce' );
    $year = get_post_meta( $post->ID, '_ctp_project_year', true );
    $url = get_post_meta( $post->ID, '_ctp_project_url', true );
    ?>
    <p><label for="ctp_project_year"><strong><?php esc_html_e( 'Year', 'capstone-team-portfolio' ); ?></strong></label><br><input class="widefat" type="text" id="ctp_project_year" name="ctp_project_year" value="<?php echo esc_attr( $year ); ?>" placeholder="2026"></p>
    <p><label for="ctp_project_url"><strong><?php esc_html_e( 'External project link (optional)', 'capstone-team-portfolio' ); ?></strong></label><br><input class="widefat" type="url" id="ctp_project_url" name="ctp_project_url" value="<?php echo esc_url( $url ); ?>" placeholder="https://"></p>
    <?php
}

function ctp_save_project_details( $post_id ) {
    if ( ! isset( $_POST['ctp_project_nonce'] ) || ! is_scalar( $_POST['ctp_project_nonce'] ) || ! wp_verify_nonce( sanitize_text_field( wp_unslash( $_POST['ctp_project_nonce'] ) ), 'ctp_save_project_details' ) ) { return; }
    if ( ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) || wp_is_post_revision( $post_id ) ) { return; }
    if ( ! current_user_can( 'edit_post', $post_id ) || 'ctp_project' !== get_post_type( $post_id ) ) { return; }
    if ( isset( $_POST['ctp_project_year'] ) && is_scalar( $_POST['ctp_project_year'] ) ) {
        update_post_meta( $post_id, '_ctp_project_year', sanitize_text_field( wp_unslash( $_POST['ctp_project_year'] ) ) );
    }
    if ( isset( $_POST['ctp_project_url'] ) && is_scalar( $_POST['ctp_project_url'] ) ) {
        update_post_meta( $post_id, '_ctp_project_url', esc_url_raw( wp_unslash( $_POST['ctp_project_url'] ) ) );
    }
}
add_action( 'save_post', 'ctp_save_project_details' );

/** Resolve the team inbox, falling back to the WordPress administrator email. */
function ctp_get_team_contact_email() {
    $email = sanitize_email( get_theme_mod( 'ctp_contact_email', get_option( 'admin_email' ) ) );
    if ( ! is_email( $email ) ) {
        $email = sanitize_email( get_option( 'admin_email' ) );
    }
    return is_email( $email ) ? $email : '';
}

/** Route individual inquiries to a published member; otherwise use the team inbox. */
function ctp_get_contact_recipient( $contact_type, $member_id = 0 ) {
    $team_email = ctp_get_team_contact_email();
    if ( 'individual' !== sanitize_text_field( $contact_type ) ) {
        return $team_email;
    }

    $member_id = absint( $member_id );
    $member = $member_id ? get_post( $member_id ) : null;
    if ( $member && isset( $member->post_type, $member->post_status ) && 'ctp_member' === $member->post_type && 'publish' === $member->post_status ) {
        $member_email = sanitize_email( get_post_meta( $member_id, '_ctp_member_email', true ) );
        if ( is_email( $member_email ) ) {
            return $member_email;
        }
    }

    return $team_email;
}

/** Return the editable Contact page URL, or a stable fallback URL. */
function ctp_get_contact_page_url() {
    $contact_page = get_page_by_path( 'contact' );
    return $contact_page ? get_permalink( $contact_page->ID ) : home_url( '/contact/' );
}

/** Render the contact form. Email recipients are resolved only on the server. */
function ctp_render_contact_form() {
    $members = get_posts( array(
        'post_type' => 'ctp_member',
        'post_status' => 'publish',
        'posts_per_page' => -1,
        'meta_key' => '_ctp_member_order',
        'orderby' => array( 'meta_value_num' => 'ASC', 'title' => 'ASC' ),
    ) );
    $selected_member = ( isset( $_GET['member'] ) && is_scalar( $_GET['member'] ) ) ? absint( wp_unslash( $_GET['member'] ) ) : 0;
    $status = ( isset( $_GET['ctp_contact'] ) && is_scalar( $_GET['ctp_contact'] ) ) ? sanitize_text_field( wp_unslash( $_GET['ctp_contact'] ) ) : '';
    ob_start();
    ?>
    <div class="contact-form-wrap" id="contact-form">
        <?php if ( 'sent' === $status ) : ?><div class="form-notice form-notice-success" role="status"><?php esc_html_e( 'Your message has been sent. Thank you for getting in touch!', 'capstone-team-portfolio' ); ?></div><?php elseif ( 'error' === $status ) : ?><div class="form-notice form-notice-error" role="alert"><?php esc_html_e( 'We could not send your message. Please check the fields and try again.', 'capstone-team-portfolio' ); ?></div><?php endif; ?>
        <form class="ctp-contact-form" method="post" action="<?php echo esc_url( admin_url( 'admin-post.php' ) ); ?>">
            <input type="hidden" name="action" value="ctp_submit_contact">
            <?php wp_nonce_field( 'ctp_submit_contact', 'ctp_contact_nonce' ); ?>
            <div class="form-field">
                <label for="ctp_contact_type"><?php esc_html_e( 'Who would you like to contact?', 'capstone-team-portfolio' ); ?></label>
                <select id="ctp_contact_type" name="contact_type" required>
                    <option value="team"><?php esc_html_e( 'Contact the Team', 'capstone-team-portfolio' ); ?></option>
                    <option value="individual" <?php selected( $selected_member > 0 ); ?>><?php esc_html_e( 'Contact an Individual Member', 'capstone-team-portfolio' ); ?></option>
                </select>
            </div>
            <div class="form-field contact-member-field" <?php echo $selected_member ? '' : 'hidden'; ?>>
                <label for="ctp_member_id"><?php esc_html_e( 'Select a team member', 'capstone-team-portfolio' ); ?></label>
                <select id="ctp_member_id" name="member_id" <?php echo $selected_member ? 'required' : ''; ?>>
                    <option value=""><?php esc_html_e( 'Choose a member', 'capstone-team-portfolio' ); ?></option>
                    <?php foreach ( $members as $member ) : ?>
                        <option value="<?php echo esc_attr( $member->ID ); ?>" <?php selected( $selected_member, $member->ID ); ?>><?php echo esc_html( get_the_title( $member ) ); ?></option>
                    <?php endforeach; ?>
                </select>
                <?php if ( empty( $members ) ) : ?><small><?php esc_html_e( 'No published team members are available yet. You can still contact the team.', 'capstone-team-portfolio' ); ?></small><?php endif; ?>
            </div>
            <div class="form-grid">
                <div class="form-field"><label for="ctp_contact_name"><?php esc_html_e( 'Your name', 'capstone-team-portfolio' ); ?></label><input id="ctp_contact_name" name="contact_name" type="text" autocomplete="name" maxlength="120" required></div>
                <div class="form-field"><label for="ctp_contact_email"><?php esc_html_e( 'Email address', 'capstone-team-portfolio' ); ?></label><input id="ctp_contact_email" name="contact_email" type="email" autocomplete="email" maxlength="190" required></div>
            </div>
            <div class="form-field"><label for="ctp_contact_subject"><?php esc_html_e( 'Subject', 'capstone-team-portfolio' ); ?></label><input id="ctp_contact_subject" name="contact_subject" type="text" maxlength="180" required></div>
            <div class="form-field"><label for="ctp_contact_message"><?php esc_html_e( 'Message', 'capstone-team-portfolio' ); ?></label><textarea id="ctp_contact_message" name="contact_message" rows="6" maxlength="5000" required></textarea></div>
            <div class="ctp-honeypot" aria-hidden="true"><label for="ctp_website"><?php esc_html_e( 'Leave this field empty', 'capstone-team-portfolio' ); ?></label><input id="ctp_website" name="website" type="text" tabindex="-1" autocomplete="off"></div>
            <button class="button button-primary" type="submit"><?php esc_html_e( 'Send message', 'capstone-team-portfolio' ); ?><span aria-hidden="true">→</span></button>
            <p class="form-privacy-note"><?php esc_html_e( 'Your email address is used only to respond to your inquiry. Team member email addresses are kept private.', 'capstone-team-portfolio' ); ?></p>
        </form>
    </div>
    <?php
    return ob_get_clean();
}

function ctp_contact_redirect( $status ) {
    $redirect = wp_get_referer();
    if ( ! $redirect ) {
        $redirect = ctp_get_contact_page_url();
    }
    $redirect = remove_query_arg( 'ctp_contact', $redirect );
    wp_safe_redirect( add_query_arg( 'ctp_contact', $status, $redirect ) . '#contact-form' );
    exit;
}

/** Validate and send contact submissions using WordPress mail configuration. */
function ctp_handle_contact_submission() {
    if ( 'POST' !== strtoupper( isset( $_SERVER['REQUEST_METHOD'] ) ? sanitize_text_field( wp_unslash( $_SERVER['REQUEST_METHOD'] ) ) : '' ) ) {
        ctp_contact_redirect( 'error' );
    }
    if ( ! isset( $_POST['ctp_contact_nonce'] ) || ! is_scalar( $_POST['ctp_contact_nonce'] ) || ! wp_verify_nonce( sanitize_text_field( wp_unslash( $_POST['ctp_contact_nonce'] ) ), 'ctp_submit_contact' ) ) {
        ctp_contact_redirect( 'error' );
    }

    $honeypot = ( isset( $_POST['website'] ) && is_scalar( $_POST['website'] ) ) ? sanitize_text_field( wp_unslash( $_POST['website'] ) ) : '';
    if ( '' !== $honeypot ) {
        ctp_contact_redirect( 'sent' );
    }

    $contact_type = ( isset( $_POST['contact_type'] ) && is_scalar( $_POST['contact_type'] ) ) ? sanitize_text_field( wp_unslash( $_POST['contact_type'] ) ) : 'team';
    $member_id = ( isset( $_POST['member_id'] ) && is_scalar( $_POST['member_id'] ) ) ? absint( wp_unslash( $_POST['member_id'] ) ) : 0;
    $name = ( isset( $_POST['contact_name'] ) && is_scalar( $_POST['contact_name'] ) ) ? sanitize_text_field( wp_unslash( $_POST['contact_name'] ) ) : '';
    $email = ( isset( $_POST['contact_email'] ) && is_scalar( $_POST['contact_email'] ) ) ? sanitize_email( wp_unslash( $_POST['contact_email'] ) ) : '';
    $subject = ( isset( $_POST['contact_subject'] ) && is_scalar( $_POST['contact_subject'] ) ) ? sanitize_text_field( wp_unslash( $_POST['contact_subject'] ) ) : '';
    $message = ( isset( $_POST['contact_message'] ) && is_scalar( $_POST['contact_message'] ) ) ? sanitize_textarea_field( wp_unslash( $_POST['contact_message'] ) ) : '';

    if ( ! in_array( $contact_type, array( 'team', 'individual' ), true ) || '' === $name || strlen( $name ) > 120 || ! is_email( $email ) || strlen( $email ) > 190 || '' === $subject || strlen( $subject ) > 180 || '' === $message || strlen( $message ) > 5000 ) {
        ctp_contact_redirect( 'error' );
    }
    if ( 'individual' === $contact_type ) {
        $member = $member_id ? get_post( $member_id ) : null;
        if ( ! $member || 'ctp_member' !== $member->post_type || 'publish' !== $member->post_status ) {
            ctp_contact_redirect( 'error' );
        }
    }

    $recipient = ctp_get_contact_recipient( $contact_type, $member_id );
    if ( ! is_email( $recipient ) ) {
        ctp_contact_redirect( 'error' );
    }

    $member_name = ( 'individual' === $contact_type ) ? get_the_title( $member_id ) : __( 'Entire team', 'capstone-team-portfolio' );
    $body = sprintf(
        "New portfolio inquiry\n\nTo: %s\nFrom: %s\nEmail: %s\nSubject: %s\n\nMessage:\n%s\n",
        $member_name,
        $name,
        $email,
        $subject,
        $message
    );
    $sent = wp_mail( $recipient, '[Portfolio Contact] ' . $subject, $body, array( 'Reply-To: ' . $email ) );
    ctp_contact_redirect( $sent ? 'sent' : 'error' );
}
add_action( 'admin_post_nopriv_ctp_submit_contact', 'ctp_handle_contact_submission' );
add_action( 'admin_post_ctp_submit_contact', 'ctp_handle_contact_submission' );

/** Dashboard overview for editors and administrators. */
function ctp_register_dashboard_widget() {
    if ( current_user_can( 'edit_posts' ) ) {
        wp_add_dashboard_widget( 'ctp_portfolio_overview', __( 'Portfolio Overview', 'capstone-team-portfolio' ), 'ctp_dashboard_widget_html' );
    }
}
add_action( 'wp_dashboard_setup', 'ctp_register_dashboard_widget' );

function ctp_dashboard_widget_html() {
    $member_counts = wp_count_posts( 'ctp_member' );
    $project_counts = wp_count_posts( 'ctp_project' );
    $members = isset( $member_counts->publish ) ? (int) $member_counts->publish : 0;
    $projects = isset( $project_counts->publish ) ? (int) $project_counts->publish : 0;
    ?>
    <div class="ctp-admin-overview">
        <div><strong><?php echo esc_html( number_format_i18n( $members ) ); ?></strong><span><?php esc_html_e( 'Published team members', 'capstone-team-portfolio' ); ?></span></div>
        <div><strong><?php echo esc_html( number_format_i18n( $projects ) ); ?></strong><span><?php esc_html_e( 'Published projects', 'capstone-team-portfolio' ); ?></span></div>
    </div>
    <p class="ctp-admin-actions"><a class="button button-primary" href="<?php echo esc_url( admin_url( 'post-new.php?post_type=ctp_member' ) ); ?>"><?php esc_html_e( 'Add team member', 'capstone-team-portfolio' ); ?></a> <a class="button" href="<?php echo esc_url( admin_url( 'post-new.php?post_type=ctp_project' ) ); ?>"><?php esc_html_e( 'Add project', 'capstone-team-portfolio' ); ?></a></p>
    <p><a href="<?php echo esc_url( admin_url( 'customize.php?autofocus[section]=ctp_homepage' ) ); ?>"><?php esc_html_e( 'Edit homepage and team inbox settings', 'capstone-team-portfolio' ); ?> →</a></p>
    <?php
}

function ctp_admin_enqueue_assets( $hook ) {
    if ( 'index.php' === $hook || 'edit.php' === $hook || 'post.php' === $hook || 'post-new.php' === $hook ) {
        wp_enqueue_style( 'ctp-admin', get_template_directory_uri() . '/assets/css/admin.css', array(), CTP_VERSION );
    }
}
add_action( 'admin_enqueue_scripts', 'ctp_admin_enqueue_assets' );

/** Add useful content columns without exposing private member emails publicly. */
function ctp_member_admin_columns( $columns ) {
    $updated = array();
    foreach ( $columns as $key => $label ) {
        $updated[ $key ] = $label;
        if ( 'title' === $key ) {
            $updated['ctp_member_role'] = __( 'Role', 'capstone-team-portfolio' );
            $updated['ctp_member_email'] = __( 'Private contact email', 'capstone-team-portfolio' );
        }
    }
    return $updated;
}
add_filter( 'manage_ctp_member_posts_columns', 'ctp_member_admin_columns' );

function ctp_member_admin_column_content( $column, $post_id ) {
    if ( 'ctp_member_role' === $column ) {
        echo esc_html( get_post_meta( $post_id, '_ctp_member_role', true ) ?: '—' );
    } elseif ( 'ctp_member_email' === $column ) {
        $email = get_post_meta( $post_id, '_ctp_member_email', true );
        echo $email ? '<a href="mailto:' . esc_attr( $email ) . '">' . esc_html( $email ) . '</a>' : '<span class="description">' . esc_html__( 'Team inbox fallback', 'capstone-team-portfolio' ) . '</span>';
    }
}
add_action( 'manage_ctp_member_posts_custom_column', 'ctp_member_admin_column_content', 10, 2 );

function ctp_project_admin_columns( $columns ) {
    $updated = array();
    foreach ( $columns as $key => $label ) {
        $updated[ $key ] = $label;
        if ( 'title' === $key ) {
            $updated['ctp_project_year'] = __( 'Year', 'capstone-team-portfolio' );
            $updated['ctp_project_categories'] = __( 'Categories', 'capstone-team-portfolio' );
        }
    }
    return $updated;
}
add_filter( 'manage_ctp_project_posts_columns', 'ctp_project_admin_columns' );

function ctp_project_admin_column_content( $column, $post_id ) {
    if ( 'ctp_project_year' === $column ) {
        echo esc_html( get_post_meta( $post_id, '_ctp_project_year', true ) ?: '—' );
    } elseif ( 'ctp_project_categories' === $column ) {
        $terms = get_the_term_list( $post_id, 'ctp_project_category', '', ', ' );
        echo $terms ? wp_kses_post( $terms ) : '—';
    }
}
add_action( 'manage_ctp_project_posts_custom_column', 'ctp_project_admin_column_content', 10, 2 );

/** Count only real content for the homepage statistics. */
function ctp_get_portfolio_stats() {
    $member_counts = wp_count_posts( 'ctp_member' );
    $project_counts = wp_count_posts( 'ctp_project' );
    $member_ids = get_posts( array( 'post_type' => 'ctp_member', 'post_status' => 'publish', 'posts_per_page' => -1, 'fields' => 'ids' ) );
    $skill_count = 0;
    foreach ( $member_ids as $member_id ) {
        $skills = get_post_meta( $member_id, '_ctp_member_skills', true );
        if ( $skills ) {
            $skill_items = array_filter( array_map( 'trim', explode( ',', $skills ) ) );
            $skill_count += count( $skill_items );
        }
    }
    return array(
        'members' => isset( $member_counts->publish ) ? (int) $member_counts->publish : 0,
        'projects' => isset( $project_counts->publish ) ? (int) $project_counts->publish : 0,
        'skills' => $skill_count,
    );
}

/** Rewrites are flushed by WordPress on theme activation; project URLs remain stable afterwards. */

add_shortcode( 'ctp_contact_form', 'ctp_render_contact_form' );

/** Preconnect to Google Fonts for faster type loading. */
function ctp_resource_hints( $urls, $relation_type ) {
    if ( 'preconnect' === $relation_type ) {
        $urls[] = 'https://fonts.googleapis.com';
        $urls[] = array( 'href' => 'https://fonts.gstatic.com', 'crossorigin' );
    }
    return $urls;
}
add_filter( 'wp_resource_hints', 'ctp_resource_hints', 10, 2 );

/** Apply the saved colour mode before paint to avoid a flash of the wrong theme. */
function ctp_theme_mode_script() {
    echo "<script>(function(){var t;try{t=localStorage.getItem('ctp-theme');}catch(e){}if(t!=='light'&&t!=='dark'){t='dark';}document.documentElement.setAttribute('data-theme',t);}());</script>\n";
}
add_action( 'wp_head', 'ctp_theme_mode_script', 1 );

/** Hero headline with its final sentence set in italic. */
function ctp_hero_title_html() {
    $title = trim( ctp_get_option( 'ctp_hero_title', 'Four Minds. One Vision. One Innovation.' ) );
    $parts = preg_split( '/(?<=[.!?])\s+/', $title );
    if ( count( $parts ) < 2 ) { return esc_html( $title ); }
    $last = array_pop( $parts );
    return esc_html( implode( ' ', $parts ) ) . ' <em>' . esc_html( $last ) . '</em>';
}

/** Unique skills across all published members, for the homepage ticker. */
function ctp_get_all_skills() {
    $ids = get_posts( array( 'post_type' => 'ctp_member', 'post_status' => 'publish', 'posts_per_page' => -1, 'fields' => 'ids' ) );
    $all = array();
    foreach ( $ids as $id ) {
        $skills = get_post_meta( $id, '_ctp_member_skills', true );
        if ( ! $skills ) { continue; }
        foreach ( array_filter( array_map( 'trim', explode( ',', $skills ) ) ) as $skill ) {
            $all[ strtolower( $skill ) ] = $skill;
        }
    }
    return array_values( $all );
}


/** Team name shown in the header, footer, page labels and browser tab. */
function ctp_brand_name() {
    $name = trim( (string) ctp_get_option( 'ctp_brand_name', 'OG Team Portfolio' ) );
    return '' !== $name ? $name : 'OG Team Portfolio';
}

/** Small label above the homepage headline; replaces the old default with the team name. */
function ctp_hero_eyebrow() {
    $eyebrow = trim( (string) ctp_get_option( 'ctp_eyebrow', '' ) );
    if ( '' === $eyebrow || 'CAPSTONE TEAM PORTFOLIO' === strtoupper( $eyebrow ) ) {
        return strtoupper( ctp_brand_name() );
    }
    return $eyebrow;
}

/** Use the team name in the browser tab title instead of the WordPress Site Title. */
function ctp_document_title_parts( $parts ) {
    if ( isset( $parts['site'] ) ) { $parts['site'] = ctp_brand_name(); }
    if ( ( is_front_page() || is_home() ) && isset( $parts['title'] ) && $parts['title'] === get_bloginfo( 'name' ) ) { $parts['title'] = ctp_brand_name(); }
    return $parts;
}
add_filter( 'document_title_parts', 'ctp_document_title_parts' );
