<?php

// https://developer.wordpress.org/rest-api/reference/posts/#arguments
add_action( 'rest_api_init', function ()
{

    register_rest_route( 'tesla/v1', '/inventions', [
        'methods' => 'GET',
        'callback' => 'get_inventions_posts_types',
        'permission_callback' => '__return_true',
        'args' => [
            'type' => [ 'required' => false, 'type' => 'string' ],
            'date' => [ 'required' => false, 'type' => 'string' ],
            'country' => [ 'required' => false, 'type' => 'string' ],
            'id' => [ 'required' => false, 'type' => 'string' ],
            'per_page' => [ 'required' => false, 'type' => 'integer' ],
            'page' => [ 'required' => false, 'type' => 'integer' ],
            's' => [ 'required' => false, 'type' => 'string' ],
            'order' => [ 'required' => false, 'type' => 'string' ],
            'orderby' => [ 'required' => false, 'type' => 'string' ],
        ],
    ]);
});

function get_inventions_posts_types( $request )
{
    $json = (array) [];
    $type = (string) $request->get_param( 'type' );
    $date = (string) $request->get_param( 'date' );
    $country = (string) $request->get_param( 'country' );
    $per_page = (int) $request->get_param( 'per_page' ) ? (int) $request->get_param( 'per_page' ) : 6;
    $page = (int) $request->get_param( 'page' ) ? (int) $request->get_param( 'page' ) : 1;
    $search = $request->get_param( 'search' );
    // $order = $request->get_param( 'order' ) ? $request->get_param( 'order' ) : 'ASC';
    // $orderby = $request->get_param( 'orderby' ) ? $request->get_param( 'orderby' ) : 'date';

    $args = [
        'post_type' => INVENTIONS_POST_TYPE,
        'posts_per_page' => (int) $per_page,
        'paged' => (int) $page,
        //'order' => (string) $order,
        //'orderby' => $orderby,
        's' => isset($search) ? (string) $search : '',
        'tax_query' => [
            'relation' => 'AND',
        ],
    ];

    if ( isset($type) && !empty($type) ) {

        $args['tax_query'][] = [
            'taxonomy' => 'type-invention',
            'field' => 'id',
            'terms' => (array) explode( ',', $type ),
            //'operator' => 'AND',
        ];
    }
    if ( isset($date) && !empty($date) ) {

        $args['tax_query'][] = [
            'taxonomy' => 'date-invention',
            'field' => 'id',
            'terms' => (array) explode( ',', $date ),
            //'operator' => 'AND',
        ];
    }
    if ( isset($country) && !empty($country) ) {

        $args['tax_query'][] = [
            'taxonomy' => 'country-invention',
            'field' => 'id',
            'terms' => (array) explode( ',', $country ),
            //'operator' => 'AND',
        ];
    }

    $posts = new WP_Query( $args );

    if ( $posts->have_posts() ) {

        while ( $posts->have_posts() ) {
            $posts->the_post();
            global $post;
            $id = $post->ID;

            $json[] = [
                'id' => (int) esc_attr($id),
                'title' => (array) [ 'rendered' => (string) esc_attr($post->post_title) ],
                'link' => (string) esc_url(get_the_permalink($id)),
                'type' => get_terms_by_id($id,'type-invention'),
                'date' => get_terms_by_id($id,'date-invention'),
                'country' => get_terms_by_id($id,'country-invention'),
                'terms' => (array) array_merge(get_rest_terms($id,'type-invention'),get_rest_terms($id,'date-invention'),get_rest_terms($id,'country-invention')),
            ];
        }
    }

    $response = rest_ensure_response($json);

    $total_posts = (int) $posts->found_posts;
    $max_pages = (int) $posts->max_num_pages;

    $response->header( 'X-WP-Total', (int) $total_posts );
    $response->header( 'X-WP-TotalPages', (int) $max_pages );

    return $response;
}

function set_inventions_filters()
{
    $dates_terms = get_terms([
        'taxonomy' => 'date-invention',
        'hide_empty' => true,
    ]);
    $countries_terms = get_terms([
        'taxonomy' => 'country-invention',
        'hide_empty' => true,
    ]);
    $types_terms = get_terms([
        'taxonomy' => 'type-invention',
        'hide_empty' => true,
    ]);
    get_template_part( 'template-parts/filters/select', '', [
        'taxonomy' => 'country-invention',
        'taxonomy_rest_name' => 'country',
        'terms' => $countries_terms,
        'aria_filter_by_text' => 'Filtre par pays',
        'filter_all_text' => 'Tous',
        'filter_title' => 'Par pays',
        'display_count' => true,
        'limit_by_count' => 5,
    ]);
    //button-checkbox
    get_template_part( 'template-parts/filters/select', '', [
        'taxonomy' => 'date-invention',
        'taxonomy_rest_name' => 'date',
        'terms' => $dates_terms,
        'taxonomy_title' => 'Date',
        'filter_all_text' => 'Toutes',
        'filter_title' => 'Par date',
        'display_count' => true,
        'limit_by_count' => 6,
        //'display_checkbox_all' => true,
    ]);
    //checkbox
    get_template_part( 'template-parts/filters/checkbox', '', [
        'taxonomy' => 'type-invention',
        'taxonomy_rest_name' => 'type',
        'terms' => $types_terms,
        'taxonomy_title' => 'Type',
        'filter_all_text' => 'Tous',
        'filter_title' => 'Par type',
        'display_count' => true,
        'limit_by_count' => 6,
        'display_checkbox_all' => true,
    ]);
}


?>

<div id="inventions-app" class="app-container">
    <div class="row">
        <div class="col-lg-9">
            <?php
                get_template_part( 'template-parts/filters/search-form', '', [
                    'id' => 'inventions-app',
                    // 'placeholder' => 'Saisissez votre recherche',
                    // 'input_type' => 'text',
                    // 'autocomplete' => 'on',
                    // 'class_name' => 'test-form-class',
                    // 'autofocus' => true,
                    // 'aria_search_label' => 'Saisir une recherche',
                    // 'aria_submit_label' => 'Envoyer',
                ]);
            ?>
            <div class="content-area"></div>
        </div>
        <div class="col-lg-3">
            <div class="filters-area">
                <?php set_inventions_filters(); ?>
            </div>
        </div>
    </div>
</div>
<div id="inventions-app-loadmore" class="app-container">
    <div class="row">
        <div class="col-lg-9">
            <?php get_template_part( 'template-parts/filters/search-form', ''); ?>
            <div class="content-area"></div>
        </div>
        <div class="col-lg-3">
            <div class="filters-area">
                <?php set_inventions_filters(); ?>
            </div>
        </div>
    </div>
</div>
<script>
    document.addEventListener('DOMContentLoaded', (event) => {

        const tplInventions = (data) => {

            if ( data.type && data.date && data.country ) {
                let types_ids = data.type;
                let dates_ids = data.date;
                let countries_ids = data.country;
                let types = [];
                let dates = [];
                let countries = [];

                data.terms.forEach(term => {

                    types_ids.forEach(type_id => {
                        if ( type_id === term.id ) {
                            types.push(term.name);
                        }
                    });
                    dates_ids.forEach(date_id => {

                        if ( date_id === term.id ) {
                            dates.push(term.name);
                        }
                    });
                    countries_ids.forEach(country_id => {

                        if ( country_id === term.id ) {
                            countries.push(term.name);
                        }
                    });
                });

                types = '' != types ? `<div class="api-filters"><b>Types</b> : ${types.join(', ')}</div> ` : '';
                dates = '' != dates ? `<div class="api-filters"><b>Dates</b> : ${dates.join(', ')}</div> ` : '';
                countries = '' != countries ? `<div class="api-filters"><b>Pays</b> : ${countries.join(', ')}</div> ` : '';

                return `<div class="col-sm-4 mb-4">
                    <div class="ia-card-item card">
                        <div class="card-body">
                            <div class="card-title"><b>${data.title.rendered}</b></div>
                        </div>
                        <div class="card-footer">${types}${dates}${countries}</div>
                    </div>
                </div>`;
            }
        }

        class InventionsQueryApi extends QueryApi {

            template(data) {
                return tplInventions(data);
            }
        }
        const inventionsApp = new InventionsQueryApi({
            id: 'inventions-app',
            endpoint: 'tesla/v1/inventions',
            containerClass: 'app-inventions',
            contentClass: 'content-inventions row',
            paginate: {
                //type: 'loadmore',
                pagination: {
                    //arrows: 0,
                    prev: "Précédente",
                    next: "Suivante",
                }
            },
            skeleton: {
                //nbItems: 3,
                template: `
                    <div class="skeleton-card ske-card-demo col-sm-4">
                        <div class="ske-title gray-loading"></div>
                        <div class="ske-title mt-2 mb-3 col-8 gray-loading"></div>
                        <div class="ske-img primary-light-loading"></div>
                    </div>
                `,
            },
            query: {
                per_page: 9,
            },
            debug: 1,
        });

        const inventionsAppLoadmore = new InventionsQueryApi({
            id: 'inventions-app-loadmore',
            endpoint: 'tesla/v1/inventions',
            //pager: false,
            query: {
                //per_page: 3,
            },
            paginate: {
                type: 'loadmore',
                loadmore: {
                    more: "Charger plus",
                    loading: "Loading...",
                    //spinner: '',
                }
            },
            skeleton: {
                //disable: true,
                //nbItems: 3,
                template: `
                    <div class="skeleton-card ske-card-demo col-sm-4">
                        <div class="ske-title gray-loading"></div>
                        <div class="ske-title mt-2 mb-3 col-8 gray-loading"></div>
                        <div class="ske-img primary-light-loading"></div>
                    </div>
                `,
            },
            messages: {
                // item : "item",
                // results: 'match',
            },
            debug: 1,
        });
    });
</script>
