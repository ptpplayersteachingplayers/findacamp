# 🎯 PTP Find a Camp - Usage Examples

## Quick Start

### 1. WordPress Shortcode (Easiest)
```php
// In any page or post, use:
[ptp_find_camp gmaps_key="YOUR_GOOGLE_MAPS_API_KEY"]

// Or with custom endpoint:
[ptp_find_camp gmaps_key="YOUR_API_KEY" endpoint="/custom/api/endpoint"]
```

### 2. Gutenberg Block (Recommended)
1. Add a "Custom HTML" block
2. Paste the component code
3. Update the `data-gmaps-key` attribute

### 3. Theme Integration
```php
// In your theme template file:
echo do_shortcode('[ptp_find_camp gmaps_key="YOUR_API_KEY"]');
```

## Configuration Examples

### Basic Setup
```html
<div class="wrap" 
     data-gmaps-key="AIzaSyBFw0Qbyq9zTFTd-tUY6dO6TnQmpqHrAGE" 
     data-endpoint="/wp-json/ptp/v1/winter-products">
```

### Custom Styling
```css
/* Override default colors */
#ptp-find-camp {
  --y: #FF6B35;        /* Orange accent */
  --ink: #2D3748;      /* Dark gray text */
  --muted: #718096;    /* Muted text */
  --b: #E2E8F0;        /* Light borders */
}

/* Custom button style */
.btn.primary {
  background: linear-gradient(45deg, #FF6B35, #F093FB);
  border: none;
}
```

### Add More Locations
```javascript
// In the LOCS object, add:
const LOCS = {
  // ... existing locations
  'your-city': {
    lat: 40.123, 
    lng: -75.456, 
    label: 'Your City, ST', 
    state: 'ST'
  }
};
```

## API Integration Examples

### WooCommerce Integration
```php
function ptp_get_woocommerce_camps() {
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
        
        $camps[] = array(
            'name' => $product->post_title,
            'permalink' => get_permalink($product->ID),
            'prices' => array(
                'price' => (int)($wc_product->get_price() * 100),
                'currency_code' => get_woocommerce_currency()
            ),
            'images' => array(
                array('src' => wp_get_attachment_image_url($wc_product->get_image_id(), 'large'))
            ),
            'tags' => get_product_tags($product->ID),
            'venue' => array(
                'lat' => get_post_meta($product->ID, '_venue_lat', true),
                'lng' => get_post_meta($product->ID, '_venue_lng', true),
                'name' => get_post_meta($product->ID, '_venue_name', true)
            ),
            'loc_tag' => get_post_meta($product->ID, '_location_tag', true)
        );
    }
    
    return new WP_REST_Response(array('items' => $camps), 200);
}
```

### Custom Post Type Integration
```php
function ptp_get_custom_camps() {
    $camps_query = new WP_Query(array(
        'post_type' => 'ptp_camp',
        'post_status' => 'publish',
        'posts_per_page' => -1,
        'meta_query' => array(
            array(
                'key' => 'camp_season',
                'value' => 'winter',
                'compare' => '='
            )
        )
    ));
    
    $camps = array();
    
    while ($camps_query->have_posts()) {
        $camps_query->the_post();
        $post_id = get_the_ID();
        
        $camps[] = array(
            'name' => get_the_title(),
            'permalink' => get_permalink(),
            'prices' => array(
                'price' => (int)(get_field('camp_price', $post_id) * 100),
                'currency_code' => 'USD'
            ),
            'images' => array(
                array('src' => get_the_post_thumbnail_url($post_id, 'large'))
            ),
            'tags' => wp_get_post_terms($post_id, 'camp_category'),
            'venue' => array(
                'lat' => get_field('venue_latitude', $post_id),
                'lng' => get_field('venue_longitude', $post_id),
                'name' => get_field('venue_name', $post_id)
            ),
            'loc_tag' => get_field('location_tag', $post_id)
        );
    }
    
    wp_reset_postdata();
    return new WP_REST_Response(array('items' => $camps), 200);
}
```

## Customization Examples

### Change Map Style
```javascript
// In the ensureMap() function:
map = new google.maps.Map(document.getElementById('map'), {
  center: {lat: 40.15, lng: -75.2},
  zoom: 7,
  styles: [
    {
      "featureType": "all",
      "elementType": "geometry.fill",
      "stylers": [{"color": "#f8fafc"}]
    }
    // ... more custom map styles
  ]
});
```

### Add Custom Filters
```html
<!-- Add after existing tabs -->
<div class="tabs" aria-label="Filter by camp type">
  <button class="tab active" data-type="all">All Types</button>
  <button class="tab" data-type="select">Select</button>
  <button class="tab" data-type="elite">Elite</button>
  <button class="tab" data-type="development">Development</button>
</div>
```

```javascript
// Add type filtering logic
let activeType = 'all';
document.querySelectorAll('[data-type]').forEach(tab => {
  tab.addEventListener('click', () => {
    activeType = tab.dataset.type;
    render(currentProducts, lastUserCoords);
  });
});

// Update render function
function render(list, user) {
  // ... existing code
  list.forEach(p => {
    // ... existing filters
    if (activeType !== 'all') {
      const hasType = p.tags.some(tag => 
        tag.slug.toLowerCase() === activeType.toLowerCase()
      );
      if (!hasType) return;
    }
    // ... rest of render logic
  });
}
```

### Mobile-First Responsive Tweaks
```css
/* Smaller cards on mobile */
@media (max-width: 640px) {
  .grid {
    grid-template-columns: 1fr;
    gap: 12px;
  }
  
  .card .body {
    padding: 12px;
  }
  
  .hero h1 {
    font-size: 1.5rem;
  }
  
  .controls .bar {
    flex-direction: column;
    align-items: stretch;
  }
  
  .input, .select, .btn {
    width: 100%;
  }
}
```

## Testing Examples

### Manual Testing Checklist
```javascript
// Test these scenarios:
const testCases = [
  { zip: '19087', expected: 'Main Line area camps' },
  { zip: '08540', expected: 'Princeton area camps' },
  { zip: '10583', expected: 'Scarsdale area camps' },
  { zip: '19803', expected: 'Hockessin area camps' }
];

// Test state filters
const stateTests = ['PA', 'NJ', 'DE', 'NY'];

// Test radius options
const radiusTests = [10, 25, 50, 100];
```

### Automated Testing (Optional)
```javascript
// Add to your test suite
describe('PTP Find Camp Component', () => {
  test('should load demo data', async () => {
    const demoButton = document.querySelector('#fc-demo');
    demoButton.click();
    
    await new Promise(resolve => setTimeout(resolve, 1000));
    
    const cards = document.querySelectorAll('.card');
    expect(cards.length).toBeGreaterThan(0);
  });
  
  test('should filter by state', () => {
    const paTab = document.querySelector('[data-state="PA"]');
    paTab.click();
    
    const cards = document.querySelectorAll('.card');
    cards.forEach(card => {
      const location = card.querySelector('.meta').textContent;
      expect(location).toContain('PA');
    });
  });
});
```

## Performance Optimization

### Lazy Loading
```javascript
// Load maps only when needed
let mapsLoaded = false;
document.querySelector('#fc-find').addEventListener('click', async () => {
  if (!mapsLoaded) {
    await loadMaps();
    mapsLoaded = true;
  }
  // ... rest of find logic
});
```

### API Caching
```php
// Cache API responses
function ptp_get_cached_camps() {
    $cache_key = 'ptp_winter_camps_' . date('Y-m-d-H');
    $cached = get_transient($cache_key);
    
    if ($cached !== false) {
        return $cached;
    }
    
    $camps = ptp_fetch_camps_from_database();
    set_transient($cache_key, $camps, HOUR_IN_SECONDS);
    
    return $camps;
}
```

## Troubleshooting Examples

### Debug Mode
```javascript
// Add debug logging
const DEBUG = true;
function debug(message, data = null) {
  if (DEBUG) {
    console.log(`[PTP Find Camp] ${message}`, data);
  }
}

// Use throughout the code
debug('Loading products from API', endpoint);
debug('Geocoding result', coordinates);
debug('Rendering camps', filteredCamps);
```

### Error Handling
```javascript
// Enhanced error handling
async function fetchProducts() {
  try {
    const response = await fetch(endpoint);
    if (!response.ok) {
      throw new Error(`HTTP ${response.status}: ${response.statusText}`);
    }
    const data = await response.json();
    return data.items || [];
  } catch (error) {
    console.error('Failed to fetch camps:', error);
    setStatus(`Error loading camps: ${error.message}`);
    return [];
  }
}
```

---

**Need more examples?** Check the `INTEGRATION_GUIDE.md` for detailed setup instructions! 🚀