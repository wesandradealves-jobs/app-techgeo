<?php



$galeria = array(

        'labels' => array('name' => __( 'Galeria' ),'singular_name' => __( 'Galeria' )),

        'public'             => true,

        'publicly_queryable' => true,

        'show_ui'            => true,

        'show_in_menu'       => true,

        'query_var'          => true,

        'rewrite'            => array( 'slug' => 'galeria', 'with_front' => false ),

        'capability_type'    => 'post',

        'has_archive'        => true,

        'hierarchical'       => true,

        'menu_position'      => 0,

        'supports'           => array(  'title', 'thumbnail')

        // 'taxonomies'         => array( 'region', 'discipline' )

);



register_post_type( 'galeria', $galeria );



function themeslug_theme_customizer( $wp_customize ) {

    $wp_customize->add_section( 'logo_section' , array(

        'title'       => __( 'Logo', 'themeslug' ),

        'priority'    => 30,

        'description' => 'Suba a logo do Site'

    ));

    $wp_customize->add_setting( 'logo' );

    $wp_customize->add_control( new WP_Customize_Image_Control( $wp_customize, 'logo', array(

        'label'    => __( 'Logo', 'themeslug' ),

        'section'  => 'logo_section',

        'settings' => 'logo'

    )));   



    // 



    $wp_customize->add_section('footer_section',array(

        'title' => 'Rodapé',

        'description' => '',

        'priority' => 55,

    ));



    $wp_customize->add_setting('endereco_textbox');

    $wp_customize->add_control('endereco_textbox',  array(

        'label' => 'Endereço',

        'section' => 'footer_section',

        'type' => 'text'

    ));



    //



    $wp_customize->add_section('contato_section',array(

        'title' => 'Contato',

        'description' => '',

        'priority' => 55,

    ));



    $wp_customize->add_setting('email_textbox');

    $wp_customize->add_control('email_textbox',  array(

        'label' => 'E-mail',

        'section' => 'contato_section',

        'type' => 'text'

    )); 



    $wp_customize->add_setting('telefone_textbox');

    $wp_customize->add_control('telefone_textbox',  array(

        'label' => 'Telefone',

        'section' => 'contato_section',

        'type' => 'text'

    ));    

}



add_action( 'customize_register', 'themeslug_theme_customizer' );



function remove_customizer_settings( $wp_customize ){

  $wp_customize->remove_panel('nav_menus');

  $wp_customize->remove_section('static_front_page');

}

add_action( 'customize_register', 'remove_customizer_settings', 20 );



// 



function get_the_category_bytax( $id = false, $tcat = 'category' ) {

    $categories = get_the_terms( $id, $tcat );

    if ( ! $categories )

        $categories = array();



    $categories = array_values( $categories );



    foreach ( array_keys( $categories ) as $key ) {

        _make_cat_compat( $categories[$key] );

    }



    // Filter name is plural because we return alot of categories (possibly more than #13237) not just one

    return apply_filters( 'get_the_categories', $categories );

}



// 



function get_custom_field_data($key, $echo = false) {

    global $post;

    $value = get_post_meta($post->ID, $key, true);

    if($echo == false) {

        return $value;

    } else {

        echo $value;

    }

}



//



function hide_admin_bar() {

    wp_add_inline_style('admin-bar', '<style> html { margin-top: 0 !important; } </style>');

    return false;

}



add_filter( 'show_admin_bar', 'hide_admin_bar' );



//



function menu() {

  register_nav_menus(

    array(

      'header' => __( 'Header' )

    )

  );

}



add_action( 'init', 'menu' );



//



function updateNumbers() {

    global $wpdb;

    $querystr = "SELECT $wpdb->posts.* FROM $wpdb->posts WHERE $wpdb->posts.post_status = 'publish' AND $wpdb->posts.post_type = 'post' ";

    $pageposts = $wpdb->get_results($querystr, OBJECT);

    $counts = 0 ;

    if ($pageposts):

    foreach ($pageposts as $post):

    setup_postdata($post);

    $counts++;

    add_post_meta($post->ID, 'incr_number', $counts, true);

    update_post_meta($post->ID, 'incr_number', $counts);

    endforeach;

    endif;

}

 

add_action ( 'publish_post', 'updateNumbers' );

add_action ( 'deleted_post', 'updateNumbers' );

add_action ( 'edit_post', 'updateNumbers' );



// 



add_theme_support( 'post-thumbnails' );

set_post_thumbnail_size( 600, 600 );



// 



update_option( 'siteurl', 'http://www.sight.com.br/' );

update_option( 'home', 'http://www.sight.com.br/' );



// 



if (class_exists('MultiPostThumbnails')) {

    for ($i=1;$i<2;$i++) {

        new MultiPostThumbnails(

            array(

                'label' => 'Imagem destacada '.$i,

                'id' => 'featured-image-'.$i,

                'post_type' => 'destaque'

            )

        ); 

    }

}



if (class_exists('MultiPostThumbnails')) {

    for ($i=1;$i<51;$i++) {

        new MultiPostThumbnails(

            array(

                'label' => 'Imagem '.$i,

                'id' => 'featured-image-'.$i,

                'post_type' => 'galeria'

            )

        ); 

    }

}



function wpse_mime_types_webp( $mimes ) {

    $mimes['webp'] = 'image/webp';

    $mimes['svg'] = 'image/svg+xml';



  return $mimes;

}



add_filter( 'upload_mimes', 'wpse_mime_types_webp' );    





// /**

//  * Extend WordPress search to include custom fields

//  *

//  * https://adambalee.com

//  */



// /**

//  * Join posts and postmeta tables

//  *

//  * http://codex.wordpress.org/Plugin_API/Filter_Reference/posts_join

//  */

// function cf_search_join( $join ) {

//     global $wpdb;



//     if ( is_search() ) {    

//         $join .=' LEFT JOIN '.$wpdb->postmeta. ' ON '. $wpdb->posts . '.ID = ' . $wpdb->postmeta . '.post_id ';

//     }



//     return $join;

// }

// add_filter('posts_join', 'cf_search_join' );



// /**

//  * Modify the search query with posts_where

//  *

//  * http://codex.wordpress.org/Plugin_API/Filter_Reference/posts_where

//  */

// function cf_search_where( $where ) {

//     global $pagenow, $wpdb;



//     if ( is_search() ) {

//         $where = preg_replace(

//             "/\(\s*".$wpdb->posts.".post_title\s+LIKE\s*(\'[^\']+\')\s*\)/",

//             "(".$wpdb->posts.".post_title LIKE $1) OR (".$wpdb->postmeta.".meta_value LIKE $1)", $where );

//     }



//     return $where;

// }

// add_filter( 'posts_where', 'cf_search_where' );



// /**

//  * Prevent duplicates

//  *

//  * http://codex.wordpress.org/Plugin_API/Filter_Reference/posts_distinct

//  */

// function cf_search_distinct( $where ) {

//     global $wpdb;



//     if ( is_search() ) {

//         return "DISTINCT";

//     }



//     return $where;

// }

// add_filter( 'posts_distinct', 'cf_search_distinct' );

$metas = array('username','email','url','displayname','firstname','lastname','nickname','description');

foreach ($metas as $key => $value) {
    register_meta('user', $value, array(
        "type" => "string",
        "show_in_rest" => true,
        "single" => true,
    )); 
}

function update_user( $data ) {

    // date_default_timezone_set('America/Sao_Paulo');

    // $cid = wp_get_post_terms($data['id'], 'category', array("fields" => "all"))[1]->term_id;
    // $produtos = array();
    // $links = array();
    // $term_ids = array();

    // foreach (wp_get_post_terms($data['id'], 'category', array("fields" => "all")) as $key => $value) {
    //     array_push($term_ids, $value->term_id);
    // }

    // foreach (get_field('links_relacionados', $data['id']) as $value) {
    //     array_push($links, array('thumbnail'=>wp_get_attachment_url(get_post_thumbnail_id( get_post($value)->ID ), 'thumbnail'),'noticia'=>get_post($value)));
    // }

    // foreach (get_field('produtos_utilizados', $data['id']) as $key => $value) {
    //     $produto = array(
    //         'thumbnail'=>wp_get_attachment_url(get_post_thumbnail_id( $value->ID ), 'thumbnail'),
    //         'produto'=>$value
    //     );

    //     array_push($produtos, $produto);
    // }

    // $monthsEn = array('January','February','March','April','May','June','July','August','September','October','November','December'); 
    // $monthsPT = array('Janeiro','Fevereiro','Março','Abril','Maio','Junho','Julho','Agosto','Setembro','Outubro','Novembro','Dezembro');

    // $translated = str_ireplace($monthsEn,$monthsPT,date('j \d\e F \d\e Y', strtotime(get_post($data['id'])->post_date)));

    // $return = array(
    //     'post'=>get_post($data['id']),
    //     'post_date'=>$translated,
    //     'permalink'=>get_permalink( $data['id'] ),
    //     'categories'=>array('category'=>wp_get_post_terms( $data['id'], 'category', array("fields" => "all"))[0],'category_link'=>get_term_link(wp_get_post_terms( $data['id'], 'category', array("fields" => "all"))[0]->term_id)),
    //     'visualizacoes'=>get_post_meta( $data['id'], 'my_post_viewed', true ),
    //     'banners'=>get_field('banner', $data['id']),
    //     // 'noticias_relacionadas'=> $posts,
    //     'produtos_relacionados'=>$produtos,
    //     'links_relacionados'=>$links
    // );

    $return = json_encode($data['user']);
 
    return $return;
}
 
 
add_action( 'rest_api_init', function () {
    register_rest_route( 'wp/v2', '/u/(?P<user>\d+)', array(
        'methods' => 'GET',
        'callback' => 'update_user',
    ) );
} );    

// class users

// {

//     public function __construct()

//     {

//         $version = '2';

//         $namespace = 'wp/v' . $version;

//         $base = 'u';

//         register_rest_route($namespace, '/' . $base, array(

//             'methods' => 'POST',

//             'callback' => array($this, 'update_user'),

//         ));

//     }



//     public function update_user($object)

//     {

//         $return = array();



//         global $post;

     

//         $myposts = get_posts( array(

//             'posts_per_page' => -1,

//             'post_type' => $_GET['post_type']

//         ) );

     

//         if ( $myposts ) {

//             foreach ( $myposts as $post ) : 

//                 setup_postdata( $post );

//                 array_push($return, $post);

//             endforeach;

//             wp_reset_postdata();

//         }      



//         return new WP_REST_Response($return, 200);

//     }

// }



// add_action('rest_api_init', function () {

//     $users = new users;

// });
