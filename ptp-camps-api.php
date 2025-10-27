<?php
/**
 * PTP Camps API Endpoint
 * 
 * This file provides the API endpoint for the Find a Camp component.
 * Add this to your WordPress theme's functions.php or create as a plugin.
 */

// Prevent direct access
if (!defined('ABSPATH')) {
    exit;
}

/**
 * Register the API endpoint for PTP camps
 */
add_action('rest_api_init', function () {
    register_rest_route('ptp/v1', '/winter-products', array(
        'methods' => 'GET',
        'callback' => 'ptp_get_winter_products',
        'permission_callback' => '__return_true', // Public endpoint
    ));
});

/**
 * Get winter products/camps data
 * 
 * @param WP_REST_Request $request
 * @return WP_REST_Response
 */
function ptp_get_winter_products($request) {
    // In a real implementation, you would query your WordPress database
    // For now, we'll return mock data that matches the expected format
    
    $camps = array(
        array(
            'name' => 'PTP Select Camp — Main Line',
            'permalink' => home_url('/camps/main-line/'),
            'prices' => array(
                'price' => 49900, // Price in cents
                'currency_code' => 'USD'
            ),
            'images' => array(
                array('src' => 'https://ptpsummercamps.com/wp-content/uploads/2025/09/BG7A7201-2-scaled.jpg')
            ),
            'tags' => array(
                array('slug' => 'main-line', 'name' => 'Main Line'),
                array('slug' => 'winter', 'name' => 'Winter'),
                array('slug' => 'select', 'name' => 'Select')
            ),
            'venue' => array(
                'lat' => '40.040',
                'lng' => '-75.391',
                'name' => 'Main Line Sports Complex',
                'address' => 'Main Line, PA'
            ),
            'loc_tag' => 'main-line'
        ),
        array(
            'name' => 'PTP Select Camp — Princeton',
            'permalink' => home_url('/camps/princeton/'),
            'prices' => array(
                'price' => 49900,
                'currency_code' => 'USD'
            ),
            'images' => array(
                array('src' => 'https://ptpsummercamps.com/wp-content/uploads/2025/09/BG7A7342-scaled.jpg')
            ),
            'tags' => array(
                array('slug' => 'princeton', 'name' => 'Princeton'),
                array('slug' => 'winter', 'name' => 'Winter'),
                array('slug' => 'select', 'name' => 'Select')
            ),
            'venue' => array(
                'lat' => '40.357',
                'lng' => '-74.667',
                'name' => 'Princeton Athletic Complex',
                'address' => 'Princeton, NJ'
            ),
            'loc_tag' => 'princeton'
        ),
        array(
            'name' => 'PTP Elite Camp — West Chester',
            'permalink' => home_url('/camps/west-chester/'),
            'prices' => array(
                'price' => 59900,
                'currency_code' => 'USD'
            ),
            'images' => array(
                array('src' => 'https://ptpsummercamps.com/wp-content/uploads/2025/09/BG7A7201-2-scaled.jpg')
            ),
            'tags' => array(
                array('slug' => 'west-chester', 'name' => 'West Chester'),
                array('slug' => 'winter', 'name' => 'Winter'),
                array('slug' => 'elite', 'name' => 'Elite')
            ),
            'venue' => array(
                'lat' => '39.960',
                'lng' => '-75.605',
                'name' => 'West Chester University',
                'address' => 'West Chester, PA'
            ),
            'loc_tag' => 'west-chester'
        ),
        array(
            'name' => 'PTP Development Camp — Short Hills',
            'permalink' => home_url('/camps/short-hills/'),
            'prices' => array(
                'price' => 39900,
                'currency_code' => 'USD'
            ),
            'images' => array(
                array('src' => 'https://ptpsummercamps.com/wp-content/uploads/2025/09/BG7A7342-scaled.jpg')
            ),
            'tags' => array(
                array('slug' => 'short-hills', 'name' => 'Short Hills'),
                array('slug' => 'winter', 'name' => 'Winter'),
                array('slug' => 'development', 'name' => 'Development')
            ),
            'venue' => array(
                'lat' => '40.747',
                'lng' => '-74.325',
                'name' => 'Short Hills Athletic Center',
                'address' => 'Short Hills, NJ'
            ),
            'loc_tag' => 'short-hills'
        ),
        array(
            'name' => 'PTP Elite Camp — Hockessin',
            'permalink' => home_url('/camps/hockessin/'),
            'prices' => array(
                'price' => 59900,
                'currency_code' => 'USD'
            ),
            'images' => array(
                array('src' => 'https://ptpsummercamps.com/wp-content/uploads/2025/09/BG7A7201-2-scaled.jpg')
            ),
            'tags' => array(
                array('slug' => 'hockessin', 'name' => 'Hockessin'),
                array('slug' => 'winter', 'name' => 'Winter'),
                array('slug' => 'elite', 'name' => 'Elite')
            ),
            'venue' => array(
                'lat' => '39.787',
                'lng' => '-75.691',
                'name' => 'Hockessin Athletic Complex',
                'address' => 'Hockessin, DE'
            ),
            'loc_tag' => 'hockessin'
        ),
        array(
            'name' => 'PTP Select Camp — Scarsdale',
            'permalink' => home_url('/camps/scarsdale/'),
            'prices' => array(
                'price' => 49900,
                'currency_code' => 'USD'
            ),
            'images' => array(
                array('src' => 'https://ptpsummercamps.com/wp-content/uploads/2025/09/BG7A7342-scaled.jpg')
            ),
            'tags' => array(
                array('slug' => 'scarsdale', 'name' => 'Scarsdale'),
                array('slug' => 'winter', 'name' => 'Winter'),
                array('slug' => 'select', 'name' => 'Select')
            ),
            'venue' => array(
                'lat' => '41.005',
                'lng' => '-73.784',
                'name' => 'Scarsdale High School',
                'address' => 'Scarsdale, NY'
            ),
            'loc_tag' => 'scarsdale'
        )
    );

    // Apply filters if provided
    $state_filter = $request->get_param('state');
    $search_term = $request->get_param('search');
    
    if ($state_filter && $state_filter !== 'all') {
        $camps = array_filter($camps, function($camp) use ($state_filter) {
            // Check if any tag matches the state filter
            foreach ($camp['tags'] as $tag) {
                if (strtolower($tag['slug']) === strtolower($state_filter)) {
                    return true;
                }
            }
            return false;
        });
    }
    
    if ($search_term) {
        $camps = array_filter($camps, function($camp) use ($search_term) {
            return stripos($camp['name'], $search_term) !== false;
        });
    }

    // Return the response in the expected format
    return new WP_REST_Response(array(
        'items' => array_values($camps), // Re-index array after filtering
        'total' => count($camps),
        'status' => 'success'
    ), 200);
}

/**
 * Alternative function to get camps from WooCommerce products
 * Use this if you're storing camps as WooCommerce products
 */
function ptp_get_camps_from_woocommerce() {
    if (!class_exists('WooCommerce')) {
        return array();
    }
    
    $args = array(
        'post_type' => 'product',
        'post_status' => 'publish',
        'posts_per_page' => -1,
        'meta_query' => array(
            array(
                'key' => '_ptp_camp_type',
                'value' => 'winter',
                'compare' => '='
            )
        )
    );
    
    $products = get_posts($args);
    $camps = array();
    
    foreach ($products as $product) {
        $wc_product = wc_get_product($product->ID);
        
        // Get product images
        $images = array();
        $image_id = $wc_product->get_image_id();
        if ($image_id) {
            $images[] = array('src' => wp_get_attachment_image_url($image_id, 'large'));
        }
        
        // Get product categories/tags
        $tags = array();
        $terms = wp_get_post_terms($product->ID, 'product_tag');
        foreach ($terms as $term) {
            $tags[] = array(
                'slug' => $term->slug,
                'name' => $term->name
            );
        }
        
        // Get custom venue data
        $venue = array(
            'lat' => get_post_meta($product->ID, '_ptp_venue_lat', true),
            'lng' => get_post_meta($product->ID, '_ptp_venue_lng', true),
            'name' => get_post_meta($product->ID, '_ptp_venue_name', true),
            'address' => get_post_meta($product->ID, '_ptp_venue_address', true)
        );
        
        $camps[] = array(
            'name' => $product->post_title,
            'permalink' => get_permalink($product->ID),
            'prices' => array(
                'price' => (int)($wc_product->get_price() * 100), // Convert to cents
                'currency_code' => get_woocommerce_currency()
            ),
            'images' => $images,
            'tags' => $tags,
            'venue' => $venue,
            'loc_tag' => get_post_meta($product->ID, '_ptp_location_tag', true)
        );
    }
    
    return $camps;
}

/**
 * Add CORS headers for cross-origin requests
 */
add_action('rest_api_init', function() {
    remove_filter('rest_pre_serve_request', 'rest_send_cors_headers');
    add_filter('rest_pre_serve_request', function($value) {
        header('Access-Control-Allow-Origin: *');
        header('Access-Control-Allow-Methods: GET, POST, OPTIONS');
        header('Access-Control-Allow-Headers: Content-Type, Authorization');
        return $value;
    });
});