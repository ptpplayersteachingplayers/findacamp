# 🚀 PTP Find a Camp - Integration Guide

This guide will help you integrate the fully functional "Find a Camp" component into your WordPress site.

## ✅ What's Included

- **Interactive Google Maps** with camp markers
- **ZIP Code Search** with distance calculation
- **Geolocation Support** (browser location)
- **State Filtering** (PA, NJ, DE, NY)
- **Responsive Design** for all devices
- **WordPress API Integration** ready
- **Demo Mode** for testing

## 🛠️ Quick Setup (3 Steps)

### Step 1: Get a Google Maps API Key

1. Go to [Google Cloud Console](https://console.cloud.google.com/)
2. Create a new project or select existing
3. Enable the **Maps JavaScript API** and **Geocoding API**
4. Create credentials (API Key)
5. Restrict the key to your domain for security

### Step 2: Add the API Endpoint

Choose one of these options:

#### Option A: Use the provided PHP file
1. Copy `ptp-camps-api.php` to your theme's `functions.php` or install as a plugin
2. The endpoint will be available at `/wp-json/ptp/v1/winter-products`

#### Option B: Integrate with WooCommerce
If you're using WooCommerce for camps, modify the API to pull from products:

```php
// In your functions.php or plugin
add_action('rest_api_init', function () {
    register_rest_route('ptp/v1', '/winter-products', array(
        'methods' => 'GET',
        'callback' => 'ptp_get_woocommerce_camps',
        'permission_callback' => '__return_true',
    ));
});
```

### Step 3: Add the Component

#### Method 1: Gutenberg Block (Recommended)
1. Create a new page/post
2. Add a "Custom HTML" block
3. Paste the component code from `find-camp-functional.html`
4. Update the `data-gmaps-key` attribute with your API key

#### Method 2: Shortcode
1. Add the shortcode functionality to your theme/plugin
2. Use `[ptp_find_camp]` in any page/post

#### Method 3: Template Integration
Add directly to your theme template files.

## 🔧 Configuration Options

### Required Attributes

```html
<div class="wrap" 
     data-gmaps-key="YOUR_GOOGLE_MAPS_API_KEY" 
     data-endpoint="/wp-json/ptp/v1/winter-products">
```

### Optional Customizations

#### Change Default Location
```javascript
// In the script section, modify:
center:{lat:40.15,lng:-75.2}, // Your default map center
zoom:7, // Default zoom level
```

#### Add More Location Tags
```javascript
// Add to the LOCS object:
const LOCS = {
  'your-location': {lat:40.000, lng:-75.000, label:'Your Location, ST', state:'ST'},
  // ... existing locations
};
```

#### Customize Styling
Modify the CSS variables at the top:
```css
#ptp-find-camp{
  --y:#FCB900;        /* Accent color */
  --ink:#0e0f11;      /* Text color */
  --muted:#6b7280;    /* Muted text */
  --b:#e5e7eb;        /* Border color */
  --r:14px;           /* Border radius */
  --max:1180px;       /* Max width */
}
```

## 📊 API Data Format

Your API endpoint should return JSON in this format:

```json
{
  "items": [
    {
      "name": "Camp Name",
      "permalink": "https://yoursite.com/camp-url",
      "prices": {
        "price": 49900,
        "currency_code": "USD"
      },
      "images": [
        {"src": "https://yoursite.com/image.jpg"}
      ],
      "tags": [
        {"slug": "location-tag", "name": "Location Name"},
        {"slug": "winter", "name": "Winter"},
        {"slug": "select", "name": "Select"}
      ],
      "venue": {
        "lat": "40.040",
        "lng": "-75.391",
        "name": "Venue Name",
        "address": "Address"
      },
      "loc_tag": "location-slug"
    }
  ],
  "total": 6,
  "status": "success"
}
```

## 🎯 Location Mapping

The component uses a hierarchy to determine camp locations:

1. **venue.lat/lng** - Direct coordinates (highest priority)
2. **loc_tag** - Matches predefined location slugs
3. **tags** - Searches tags for location matches

### Predefined Locations

```javascript
'main-line': {lat:40.040, lng:-75.391, label:'Main Line, PA', state:'PA'}
'princeton': {lat:40.357, lng:-74.667, label:'Princeton, NJ', state:'NJ'}
'west-chester': {lat:39.960, lng:-75.605, label:'West Chester, PA', state:'PA'}
// ... and more
```

## 🧪 Testing

### Demo Mode
Click "Run demo" to test with sample data without API setup.

### Test Checklist
- [ ] ZIP search works (try "19087")
- [ ] Geolocation works (requires HTTPS)
- [ ] Map displays with markers
- [ ] State filtering works
- [ ] Distance calculation shows
- [ ] Mobile responsive
- [ ] Cards display properly

## 🔒 Security & Performance

### API Key Security
```javascript
// Restrict your Google Maps API key to your domain
// In Google Cloud Console: Credentials > API Key > Restrictions
```

### Caching
Consider caching the API response:
```php
// Add to your API endpoint
$cache_key = 'ptp_camps_' . md5(serialize($request->get_params()));
$cached = get_transient($cache_key);
if ($cached !== false) {
    return $cached;
}
// ... your API logic
set_transient($cache_key, $response, HOUR_IN_SECONDS);
```

### CORS Headers
The provided API includes CORS headers for cross-origin requests.

## 🐛 Troubleshooting

### Common Issues

**Maps not loading:**
- Check API key is valid
- Ensure Maps JavaScript API is enabled
- Check browser console for errors

**No camps showing:**
- Verify API endpoint returns data
- Check browser network tab for API calls
- Use demo mode to test layout

**Geolocation not working:**
- Requires HTTPS in production
- User must grant permission
- Fallback to ZIP search

**Distance calculation wrong:**
- Ensure coordinates are in decimal degrees
- Check location mapping is correct

### Debug Mode
Open browser console and check the "Diagnostics" section at the bottom of the component.

## 📱 Mobile Optimization

The component is fully responsive and includes:
- Touch-friendly controls
- Optimized map interactions
- Readable text on small screens
- Proper spacing and sizing

## 🎨 Customization Examples

### Change Button Colors
```css
.btn.primary {
  background: #your-color;
  color: #fff;
}
```

### Modify Card Layout
```css
.card {
  border-radius: 20px;
  box-shadow: 0 4px 20px rgba(0,0,0,0.1);
}
```

### Update Typography
```css
#ptp-find-camp {
  font-family: 'Your Font', system-ui, sans-serif;
}
```

## 🚀 Going Live

1. **Test thoroughly** on staging site
2. **Set up monitoring** for API endpoint
3. **Configure caching** for better performance
4. **Add analytics** tracking if needed
5. **Monitor Google Maps usage** for billing

## 📞 Support

If you encounter issues:
1. Check this guide first
2. Test with demo mode
3. Check browser console for errors
4. Verify API endpoint returns expected data

## 🔄 Updates

To update the component:
1. Backup your current implementation
2. Replace the HTML/CSS/JS code
3. Preserve your API key and endpoint settings
4. Test all functionality

---

**Ready to launch?** Your PTP Find a Camp component is now fully functional! 🎉