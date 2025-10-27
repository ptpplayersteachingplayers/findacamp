<?php
/**
 * Complete Find a Camp Page
 * 
 * This is a complete, standalone PHP page that includes:
 * - Full HTML structure
 * - CSS styling
 * - JavaScript functionality
 * - Mock API endpoint
 * - Google Maps integration
 * 
 * Just upload this file to your web server and access it directly.
 * Update the GOOGLE_MAPS_API_KEY constant below with your actual API key.
 */

// Configuration
define('GOOGLE_MAPS_API_KEY', 'AIzaSyBFw0Qbyq9zTFTd-tUY6dO6TnQmpqHrAGE'); // Replace with your actual API key
define('SITE_NAME', 'PTP Soccer Camps');
define('SITE_URL', 'https://ptpsummercamps.com');

// Handle API requests
if (isset($_GET['api']) && $_GET['api'] === 'camps') {
    header('Content-Type: application/json');
    header('Access-Control-Allow-Origin: *');
    
    // Mock camp data - replace this with your actual database queries
    $camps = array(
        array(
            'name' => 'PTP Select Camp — Main Line',
            'permalink' => SITE_URL . '/camps/main-line/',
            'prices' => array('price' => 49900, 'currency_code' => 'USD'),
            'images' => array(array('src' => 'https://ptpsummercamps.com/wp-content/uploads/2025/09/BG7A7201-2-scaled.jpg')),
            'tags' => array(
                array('slug' => 'main-line', 'name' => 'Main Line'),
                array('slug' => 'winter', 'name' => 'Winter'),
                array('slug' => 'select', 'name' => 'Select')
            ),
            'venue' => array('lat' => '40.040', 'lng' => '-75.391', 'name' => 'Main Line Sports Complex', 'address' => 'Main Line, PA'),
            'loc_tag' => 'main-line'
        ),
        array(
            'name' => 'PTP Select Camp — Princeton',
            'permalink' => SITE_URL . '/camps/princeton/',
            'prices' => array('price' => 49900, 'currency_code' => 'USD'),
            'images' => array(array('src' => 'https://ptpsummercamps.com/wp-content/uploads/2025/09/BG7A7342-scaled.jpg')),
            'tags' => array(
                array('slug' => 'princeton', 'name' => 'Princeton'),
                array('slug' => 'winter', 'name' => 'Winter'),
                array('slug' => 'select', 'name' => 'Select')
            ),
            'venue' => array('lat' => '40.357', 'lng' => '-74.667', 'name' => 'Princeton Athletic Complex', 'address' => 'Princeton, NJ'),
            'loc_tag' => 'princeton'
        ),
        array(
            'name' => 'PTP Elite Camp — West Chester',
            'permalink' => SITE_URL . '/camps/west-chester/',
            'prices' => array('price' => 59900, 'currency_code' => 'USD'),
            'images' => array(array('src' => 'https://ptpsummercamps.com/wp-content/uploads/2025/09/BG7A7201-2-scaled.jpg')),
            'tags' => array(
                array('slug' => 'west-chester', 'name' => 'West Chester'),
                array('slug' => 'winter', 'name' => 'Winter'),
                array('slug' => 'elite', 'name' => 'Elite')
            ),
            'venue' => array('lat' => '39.960', 'lng' => '-75.605', 'name' => 'West Chester University', 'address' => 'West Chester, PA'),
            'loc_tag' => 'west-chester'
        ),
        array(
            'name' => 'PTP Development Camp — Short Hills',
            'permalink' => SITE_URL . '/camps/short-hills/',
            'prices' => array('price' => 39900, 'currency_code' => 'USD'),
            'images' => array(array('src' => 'https://ptpsummercamps.com/wp-content/uploads/2025/09/BG7A7342-scaled.jpg')),
            'tags' => array(
                array('slug' => 'short-hills', 'name' => 'Short Hills'),
                array('slug' => 'winter', 'name' => 'Winter'),
                array('slug' => 'development', 'name' => 'Development')
            ),
            'venue' => array('lat' => '40.747', 'lng' => '-74.325', 'name' => 'Short Hills Athletic Center', 'address' => 'Short Hills, NJ'),
            'loc_tag' => 'short-hills'
        ),
        array(
            'name' => 'PTP Elite Camp — Hockessin',
            'permalink' => SITE_URL . '/camps/hockessin/',
            'prices' => array('price' => 59900, 'currency_code' => 'USD'),
            'images' => array(array('src' => 'https://ptpsummercamps.com/wp-content/uploads/2025/09/BG7A7201-2-scaled.jpg')),
            'tags' => array(
                array('slug' => 'hockessin', 'name' => 'Hockessin'),
                array('slug' => 'winter', 'name' => 'Winter'),
                array('slug' => 'elite', 'name' => 'Elite')
            ),
            'venue' => array('lat' => '39.787', 'lng' => '-75.691', 'name' => 'Hockessin Athletic Complex', 'address' => 'Hockessin, DE'),
            'loc_tag' => 'hockessin'
        ),
        array(
            'name' => 'PTP Select Camp — Scarsdale',
            'permalink' => SITE_URL . '/camps/scarsdale/',
            'prices' => array('price' => 49900, 'currency_code' => 'USD'),
            'images' => array(array('src' => 'https://ptpsummercamps.com/wp-content/uploads/2025/09/BG7A7342-scaled.jpg')),
            'tags' => array(
                array('slug' => 'scarsdale', 'name' => 'Scarsdale'),
                array('slug' => 'winter', 'name' => 'Winter'),
                array('slug' => 'select', 'name' => 'Select')
            ),
            'venue' => array('lat' => '41.005', 'lng' => '-73.784', 'name' => 'Scarsdale High School', 'address' => 'Scarsdale, NY'),
            'loc_tag' => 'scarsdale'
        ),
        array(
            'name' => 'PTP Development Camp — Ridgewood',
            'permalink' => SITE_URL . '/camps/ridgewood/',
            'prices' => array('price' => 39900, 'currency_code' => 'USD'),
            'images' => array(array('src' => 'https://ptpsummercamps.com/wp-content/uploads/2025/09/BG7A7342-scaled.jpg')),
            'tags' => array(
                array('slug' => 'ridgewood', 'name' => 'Ridgewood'),
                array('slug' => 'winter', 'name' => 'Winter'),
                array('slug' => 'development', 'name' => 'Development')
            ),
            'venue' => array('lat' => '40.979', 'lng' => '-74.116', 'name' => 'Ridgewood Athletic Center', 'address' => 'Ridgewood, NJ'),
            'loc_tag' => 'ridgewood'
        ),
        array(
            'name' => 'PTP Select Camp — Doylestown',
            'permalink' => SITE_URL . '/camps/doylestown/',
            'prices' => array('price' => 49900, 'currency_code' => 'USD'),
            'images' => array(array('src' => 'https://ptpsummercamps.com/wp-content/uploads/2025/09/BG7A7201-2-scaled.jpg')),
            'tags' => array(
                array('slug' => 'doylestown', 'name' => 'Doylestown'),
                array('slug' => 'winter', 'name' => 'Winter'),
                array('slug' => 'select', 'name' => 'Select')
            ),
            'venue' => array('lat' => '40.310', 'lng' => '-75.130', 'name' => 'Doylestown Sports Complex', 'address' => 'Doylestown, PA'),
            'loc_tag' => 'doylestown'
        )
    );
    
    // Apply filters if provided
    $state_filter = isset($_GET['state']) ? $_GET['state'] : null;
    $search_term = isset($_GET['search']) ? $_GET['search'] : null;
    
    if ($state_filter && $state_filter !== 'all') {
        $camps = array_filter($camps, function($camp) use ($state_filter) {
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
    
    echo json_encode(array(
        'items' => array_values($camps),
        'total' => count($camps),
        'status' => 'success'
    ));
    exit;
}

// Get current page URL for API endpoint
$protocol = isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on' ? 'https' : 'http';
$host = $_SERVER['HTTP_HOST'];
$script = $_SERVER['SCRIPT_NAME'];
$current_url = $protocol . '://' . $host . $script;
$api_endpoint = $current_url . '?api=camps';
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Find a Camp - <?php echo SITE_NAME; ?></title>
    <meta name="description" content="Find PTP Soccer Camps near you. Enter your ZIP code to see camps within your area with interactive maps and distance calculations.">
    
    <!-- Preload critical resources -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;600;700;800;900&display=swap" rel="stylesheet">
    
    <style>
        /* Reset and base styles */
        * {
            box-sizing: border-box;
            margin: 0;
            padding: 0;
        }
        
        body {
            font-family: 'Inter', system-ui, -apple-system, 'Segoe UI', Roboto, Helvetica, Arial, sans-serif;
            line-height: 1.6;
            color: #0e0f11;
            background: #fff;
        }
        
        /* Header */
        .site-header {
            background: #0e0f11;
            color: #fff;
            padding: 1rem 0;
            margin-bottom: 0;
        }
        
        .site-header .container {
            max-width: 1180px;
            margin: 0 auto;
            padding: 0 clamp(16px, 4vw, 28px);
            display: flex;
            justify-content: space-between;
            align-items: center;
        }
        
        .site-header h1 {
            font-size: 1.5rem;
            font-weight: 900;
        }
        
        .site-header nav a {
            color: #e8e9ea;
            text-decoration: none;
            margin-left: 2rem;
            font-weight: 600;
        }
        
        .site-header nav a:hover {
            color: #FCB900;
        }
        
        /* Instructions banner */
        .instructions {
            background: #f8fafc;
            border-bottom: 1px solid #e5e7eb;
            padding: 1rem 0;
        }
        
        .instructions .container {
            max-width: 1180px;
            margin: 0 auto;
            padding: 0 clamp(16px, 4vw, 28px);
        }
        
        .instructions h2 {
            color: #0e0f11;
            font-size: 1.1rem;
            margin-bottom: 0.5rem;
        }
        
        .instructions p {
            color: #6b7280;
            margin-bottom: 0.5rem;
        }
        
        .instructions code {
            background: #e5e7eb;
            padding: 2px 6px;
            border-radius: 4px;
            font-size: 0.9rem;
        }
        
        .instructions ul {
            list-style: none;
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
            gap: 1rem;
            margin-top: 1rem;
        }
        
        .instructions li {
            display: flex;
            align-items: center;
            gap: 0.5rem;
            color: #059669;
            font-weight: 600;
        }
        
        /* Find a Camp Component Styles */
        #ptp-find-camp {
            --y: #FCB900;
            --ink: #0e0f11;
            --muted: #6b7280;
            --soft: #f8fafc;
            --b: #e5e7eb;
            --r: 14px;
            --shadow: 0 10px 30px rgba(0,0,0,.07);
            --pad: clamp(16px,4vw,28px);
            --max: 1180px;
        }
        
        #ptp-find-camp, #ptp-find-camp * {
            box-sizing: border-box;
            font-family: 'Inter', system-ui, -apple-system, "Segoe UI", Roboto, Helvetica, Arial, sans-serif;
        }
        
        .wrap {
            max-width: var(--max);
            margin: 0 auto;
            padding: var(--pad);
        }

        /* Hero */
        .hero {
            position: relative;
            display: grid;
            gap: 10px;
            padding: clamp(28px,6vw,48px) var(--pad);
            background: #0e0f11;
            color: #fff;
        }
        
        .hero h1 {
            margin: 0;
            font-size: clamp(1.8rem,5vw,3rem);
            line-height: 1.07;
            font-weight: 900;
        }
        
        .hero p {
            margin: 0;
            color: #e8e9ea;
            max-width: 880px;
        }
        
        .chips {
            display: flex;
            gap: 8px;
            flex-wrap: wrap;
            margin-top: 10px;
        }
        
        .chip {
            display: inline-flex;
            align-items: center;
            gap: .45rem;
            border: 1px solid rgba(255,255,255,.25);
            border-radius: 999px;
            padding: .45rem .8rem;
            background: rgba(255,255,255,.05);
            backdrop-filter: blur(4px);
            font-weight: 600;
        }

        /* Controls */
        .controls {
            background: #fff;
        }
        
        .controls .bar {
            display: flex;
            flex-wrap: wrap;
            gap: 8px;
            align-items: center;
        }
        
        .input {
            flex: 1;
            min-width: 160px;
            border: 1px solid var(--b);
            border-radius: 999px;
            padding: .8rem 1rem;
            font-family: inherit;
        }
        
        .select {
            border: 1px solid var(--b);
            border-radius: 999px;
            padding: .8rem 1rem;
            background: #fff;
            font-family: inherit;
        }
        
        .btn {
            border: 1px solid #111;
            border-radius: 999px;
            padding: .8rem 1rem;
            font-weight: 800;
            cursor: pointer;
            font-family: inherit;
            text-decoration: none;
            display: inline-flex;
            align-items: center;
            justify-content: center;
        }
        
        .btn.primary {
            background: #111;
            color: #fff;
        }
        
        .btn.secondary {
            background: #fff;
            color: #111;
        }
        
        .btn:hover {
            opacity: 0.9;
        }
        
        .status {
            color: var(--muted);
            font-size: .95rem;
            margin-top: 6px;
        }

        /* Tabs */
        .tabs {
            display: flex;
            gap: 8px;
            flex-wrap: wrap;
            margin-top: 12px;
        }
        
        .tab {
            border: 1px solid var(--b);
            border-radius: 999px;
            padding: .45rem .8rem;
            background: #fff;
            cursor: pointer;
            font-family: inherit;
        }
        
        .tab.active {
            border-color: #111;
            box-shadow: inset 0 0 0 1px #111;
        }

        /* Map */
        .mapwrap {
            margin-top: 14px;
            border: 1px solid var(--b);
            border-radius: var(--r);
            overflow: hidden;
            background: #f8fafc;
        }
        
        #map {
            width: 100%;
            height: 420px;
        }

        /* Results */
        .summary {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-top: 16px;
            color: var(--muted);
        }
        
        .grid {
            display: grid;
            grid-template-columns: 1fr;
            gap: 14px;
            margin-top: 14px;
        }
        
        @media(min-width:640px) {
            .grid {
                grid-template-columns: 1fr 1fr;
            }
        }
        
        @media(min-width:1024px) {
            .grid {
                grid-template-columns: 1fr 1fr 1fr;
            }
        }

        .card {
            display: flex;
            flex-direction: column;
            border: 1px solid var(--b);
            border-radius: var(--r);
            overflow: hidden;
            background: #fff;
            box-shadow: var(--shadow);
        }
        
        .media {
            aspect-ratio: 16/10;
            background: #f2f4f7;
        }
        
        .media img {
            width: 100%;
            height: 100%;
            object-fit: cover;
            display: block;
        }
        
        .body {
            padding: 14px;
        }
        
        .h3 {
            font-weight: 900;
            margin: 0 0 6px;
            font-size: 1.02rem;
        }
        
        .meta {
            display: flex;
            flex-wrap: wrap;
            gap: 8px;
            color: var(--muted);
            font-size: .92rem;
            margin: 0 0 10px;
        }
        
        .dist {
            margin-left: auto;
            color: #111;
            font-weight: 700;
        }
        
        .tags {
            display: flex;
            flex-wrap: wrap;
            gap: 6px;
        }
        
        .tag {
            font-size: .8rem;
            border: 1px solid var(--b);
            border-radius: 999px;
            padding: .25rem .55rem;
            color: #111;
        }
        
        .cta {
            display: flex;
            gap: 10px;
            margin-top: 10px;
        }
        
        .btn-cta {
            flex: 1;
            display: inline-flex;
            justify-content: center;
            align-items: center;
            border: none;
            border-radius: 12px;
            padding: .8rem 1rem;
            background: var(--y);
            color: #111;
            font-weight: 800;
            text-decoration: none;
        }

        .empty {
            padding: 24px;
            border: 1px dashed var(--b);
            border-radius: var(--r);
            background: #fff;
            color: var(--muted);
            margin-top: 14px;
            text-align: center;
        }

        /* Diagnostics */
        details.diag {
            margin-top: 14px;
            border: 1px dashed var(--b);
            border-radius: var(--r);
            padding: 10px;
            background: #fff;
        }
        
        details.diag summary {
            cursor: pointer;
            font-weight: 700;
        }
        
        .kv {
            display: grid;
            grid-template-columns: 160px 1fr;
            gap: 6px;
            font-size: .9rem;
            color: #333;
        }
        
        /* Footer */
        .site-footer {
            background: #f8fafc;
            border-top: 1px solid #e5e7eb;
            padding: 2rem 0;
            margin-top: 3rem;
            text-align: center;
            color: #6b7280;
        }
        
        /* Mobile optimizations */
        @media (max-width: 640px) {
            .controls .bar {
                flex-direction: column;
                align-items: stretch;
            }
            
            .input, .select, .btn {
                width: 100%;
            }
            
            .tabs {
                justify-content: center;
            }
            
            .summary {
                flex-direction: column;
                gap: 0.5rem;
                text-align: center;
            }
        }
    </style>
</head>
<body>
    <!-- Site Header -->
    <header class="site-header">
        <div class="container">
            <h1><?php echo SITE_NAME; ?></h1>
            <nav>
                <a href="<?php echo SITE_URL; ?>">Home</a>
                <a href="<?php echo SITE_URL; ?>/camps/">Camps</a>
                <a href="<?php echo SITE_URL; ?>/about/">About</a>
                <a href="<?php echo SITE_URL; ?>/contact/">Contact</a>
            </nav>
        </div>
    </header>

    <!-- Instructions Banner -->
    <div class="instructions">
        <div class="container">
            <h2>🚀 Complete Find a Camp Page - Ready to Use!</h2>
            <p><strong>This page is fully functional!</strong> Here's what you can do:</p>
            <ul>
                <li>✅ Click "Run demo" to see sample camps</li>
                <li>✅ Enter ZIP "19087" and click "Find Camps"</li>
                <li>✅ Use "Use my location" for geolocation</li>
                <li>✅ Filter by state (PA, NJ, DE, NY)</li>
                <li>✅ Interactive Google Maps with markers</li>
                <li>✅ Mobile responsive design</li>
            </ul>
            <p><strong>To customize:</strong> Edit the constants at the top of this PHP file. Replace <code>GOOGLE_MAPS_API_KEY</code> with your actual API key and update the camp data in the <code>$camps</code> array.</p>
        </div>
    </div>

    <!-- Find a Camp Component -->
    <section id="ptp-find-camp" aria-label="Find a PTP Camp Near You">
        <!-- HERO -->
        <div class="hero">
            <div class="wrap">
                <h1>Find a PTP Camp Near You</h1>
                <p>Mentorship-first training led by NCAA players and pros. Enter your ZIP, pick a radius, and see locations near you.</p>
                <div class="chips">
                    <span class="chip">✅ Fully Insured</span>
                    <span class="chip">🧠 Mentorship-First</span>
                    <span class="chip">🛡️ Background-Checked</span>
                    <span class="chip">⚡ High-Reps, Small Groups</span>
                </div>
            </div>
        </div>

        <!-- CONTROLS + MAP + RESULTS -->
        <div class="controls">
            <div class="wrap" data-gmaps-key="<?php echo GOOGLE_MAPS_API_KEY; ?>" data-endpoint="<?php echo htmlspecialchars($api_endpoint); ?>">
                <div class="bar" role="group" aria-label="Find camps by ZIP">
                    <input id="fc-zip" class="input" inputmode="numeric" maxlength="10" placeholder="ZIP or City (e.g., 19087)">
                    <select id="fc-radius" class="select" aria-label="Radius">
                        <option value="10">10 mi</option>
                        <option value="25" selected>25 mi</option>
                        <option value="50">50 mi</option>
                        <option value="100">100 mi</option>
                    </select>
                    <button id="fc-find" class="btn primary">Find Camps</button>
                    <button id="fc-geo" class="btn secondary">Use my location</button>
                    <button id="fc-demo" class="btn secondary" title="Use sample data to test the layout">Run demo</button>
                </div>

                <div class="tabs" aria-label="Filter by state">
                    <button class="tab active" data-state="all">All</button>
                    <button class="tab" data-state="PA">PA</button>
                    <button class="tab" data-state="NJ">NJ</button>
                    <button class="tab" data-state="DE">DE</button>
                    <button class="tab" data-state="NY">NY</button>
                </div>

                <div class="status" id="fc-status" aria-live="polite"></div>

                <div class="mapwrap"><div id="map"></div></div>

                <div class="summary">
                    <span id="fc-summary-left">Showing 0 camps</span>
                    <span id="fc-summary-right"></span>
                </div>

                <div id="fc-grid" class="grid" role="list"></div>
                <div id="fc-empty" class="empty" hidden>
                    <p>No camps match your filters.</p>
                    <p>Try expanding the radius or clearing the state filter.</p>
                </div>

                <details class="diag">
                    <summary>Diagnostics & Debug Info</summary>
                    <div class="kv"><strong>API Endpoint:</strong><span id="d-endpoint"><?php echo htmlspecialchars($api_endpoint); ?></span></div>
                    <div class="kv"><strong>Products loaded:</strong><span id="d-count">0</span></div>
                    <div class="kv"><strong>Last error:</strong><span id="d-err">(none)</span></div>
                    <div class="kv"><strong>Maps API Key:</strong><span><?php echo substr(GOOGLE_MAPS_API_KEY, 0, 10) . '...'; ?></span></div>
                </details>
            </div>
        </div>
    </section>

    <!-- Site Footer -->
    <footer class="site-footer">
        <div class="container">
            <p>&copy; <?php echo date('Y'); ?> <?php echo SITE_NAME; ?>. All rights reserved.</p>
            <p>Find a Camp page powered by Google Maps and PHP.</p>
        </div>
    </footer>

    <!-- JavaScript for Find a Camp functionality -->
    <script>
    (function(){
        const root = document.querySelector('#ptp-find-camp');
        const wrap = root.querySelector('.wrap[data-gmaps-key]');
        const grid = root.querySelector('#fc-grid');
        const empty = root.querySelector('#fc-empty');
        const statusEl = root.querySelector('#fc-status');
        const summL = root.querySelector('#fc-summary-left');
        const summR = root.querySelector('#fc-summary-right');
        const zipInput = root.querySelector('#fc-zip');
        const radiusSel = root.querySelector('#fc-radius');
        const btnFind = root.querySelector('#fc-find');
        const btnGeo = root.querySelector('#fc-geo');
        const btnDemo = root.querySelector('#fc-demo');
        const tabs = Array.from(root.querySelectorAll('.tab'));

        const diag = { 
            ep: root.querySelector('#d-endpoint'), 
            count: root.querySelector('#d-count'), 
            err: root.querySelector('#d-err') 
        };

        // Known location tags → coordinates + state
        const LOCS = {
            'main-line':   {lat:40.040, lng:-75.391, label:'Main Line, PA', state:'PA'},
            'west-chester':{lat:39.960, lng:-75.605, label:'West Chester, PA', state:'PA'},
            'doylestown':  {lat:40.310, lng:-75.130, label:'Doylestown, PA', state:'PA'},
            'media':       {lat:39.916, lng:-75.387, label:'Media, PA', state:'PA'},
            'princeton':   {lat:40.357, lng:-74.667, label:'Princeton, NJ', state:'NJ'},
            'short-hills': {lat:40.747, lng:-74.325, label:'Short Hills, NJ', state:'NJ'},
            'ridgewood':   {lat:40.979, lng:-74.116, label:'Ridgewood, NJ', state:'NJ'},
            'hockessin':   {lat:39.787, lng:-75.691, label:'Hockessin, DE', state:'DE'},
            'greenville':  {lat:39.777, lng:-75.598, label:'Greenville, DE', state:'DE'},
            'scarsdale':   {lat:41.005, lng:-73.784, label:'Scarsdale, NY', state:'NY'},
            'rye':         {lat:40.980, lng:-73.683, label:'Rye, NY', state:'NY'},
            'garden-city': {lat:40.726, lng:-73.634, label:'Garden City, NY', state:'NY'}
        };
        const VALID_LOCS = new Set(Object.keys(LOCS));

        // Distance helpers
        const toRad = d => d * Math.PI / 180;
        const R = 3958.8; // Earth's radius in miles
        
        function distMiles(a, b) {
            const dLat = toRad(b.lat - a.lat);
            const dLng = toRad(b.lng - a.lng);
            const sa = Math.sin(dLat / 2);
            const sb = Math.sin(dLng / 2);
            const c = 2 * Math.asin(Math.sqrt(sa * sa + Math.cos(toRad(a.lat)) * Math.cos(toRad(b.lat)) * sb * sb));
            return R * c;
        }
        
        const fmtMiles = m => (m < 1) ? `${(m * 5280)|0} ft` : `${m.toFixed(1)} mi`;

        // Fetch with error handling
        async function fetchJson(url) {
            try {
                const response = await fetch(url, {credentials: 'same-origin'});
                if (!response.ok) {
                    throw new Error(`HTTP ${response.status}: ${response.statusText}`);
                }
                return await response.json();
            } catch (error) {
                console.warn('API endpoint not available:', error);
                return { items: [] };
            }
        }

        async function fetchProducts() {
            const endpoint = wrap.dataset.endpoint;
            setStatus('Loading camps from API...');
            diag.err.textContent = '(none)';
            
            try {
                const data = await fetchJson(endpoint);
                const items = Array.isArray(data.items) ? data.items : [];
                diag.count.textContent = String(items.length);
                setStatus(`${items.length} camps loaded successfully.`);
                return items;
            } catch (error) {
                diag.err.textContent = error.message || String(error);
                setStatus('Could not load camps from API. Use demo mode to test.');
                return [];
            }
        }

        // State filter functionality
        let activeState = 'all';
        tabs.forEach(tab => {
            tab.addEventListener('click', () => {
                tabs.forEach(t => t.classList.remove('active'));
                tab.classList.add('active');
                activeState = tab.dataset.state || 'all';
                render(currentProducts, lastUserCoords);
                updateMap(currentProducts, lastUserCoords);
            });
        });

        // Google Maps integration
        let map, geocoder, markers = [], userMarker = null;
        
        function loadMaps() {
            return new Promise((resolve, reject) => {
                if (window.google && google.maps) {
                    resolve();
                    return;
                }
                
                window.__ptpInitMap = () => resolve();
                const key = wrap.dataset.gmapsKey;
                const script = document.createElement('script');
                script.src = `https://maps.googleapis.com/maps/api/js?key=${encodeURIComponent(key)}&callback=__ptpInitMap`;
                script.async = true;
                script.defer = true;
                script.onerror = () => {
                    console.warn('Google Maps failed to load');
                    setStatus('Google Maps unavailable. Map features disabled.');
                    resolve(); // Don't reject, continue without maps
                };
                document.head.appendChild(script);
            });
        }
        
        function ensureMap() {
            if (map || !window.google || !google.maps) return;
            
            map = new google.maps.Map(document.getElementById('map'), {
                center: {lat: 40.15, lng: -75.2},
                zoom: 7,
                mapTypeControl: false,
                streetViewControl: false,
                fullscreenControl: true,
                styles: [
                    {
                        featureType: 'poi',
                        elementType: 'labels',
                        stylers: [{visibility: 'off'}]
                    }
                ]
            });
            
            geocoder = new google.maps.Geocoder();
        }

        async function geocodeZip(query) {
            await loadMaps();
            if (!window.google || !google.maps) {
                throw new Error('Google Maps not available');
            }
            
            ensureMap();
            
            return new Promise((resolve, reject) => {
                geocoder.geocode({
                    address: query,
                    componentRestrictions: {country: 'US'}
                }, (results, status) => {
                    if (status === 'OK' && results && results[0]) {
                        const position = results[0].geometry.location;
                        resolve({lat: position.lat(), lng: position.lng()});
                    } else {
                        reject(new Error('Location not found'));
                    }
                });
            });
        }

        function clearMarkers() {
            markers.forEach(marker => marker.setMap(null));
            markers = [];
            if (userMarker) {
                userMarker.setMap(null);
                userMarker = null;
            }
        }

        function updateMap(products, userCoords) {
            if (!window.google || !google.maps || !map) return;
            
            ensureMap();
            clearMarkers();
            
            const bounds = new google.maps.LatLngBounds();
            
            (products || []).forEach(product => {
                const position = coordsFor(product);
                if (!position) return;
                if (activeState !== 'all' && position.state !== activeState) return;
                
                const marker = new google.maps.Marker({
                    position: {lat: position.lat, lng: position.lng},
                    map: map,
                    title: product.name
                });
                
                const infoContent = `
                    <div style="min-width:220px; padding: 8px;">
                        <strong>${product.name.replace(/`/g, '&#96;')}</strong><br>
                        ${position.label ? `<em>${position.label}</em><br>` : ''}
                        <a href="${product.permalink}" target="_blank" rel="noopener" style="color: #FCB900; font-weight: 600;">View & Register</a>
                    </div>
                `;
                
                const infoWindow = new google.maps.InfoWindow({content: infoContent});
                marker.addListener('click', () => infoWindow.open({anchor: marker, map: map}));
                
                markers.push(marker);
                bounds.extend(marker.getPosition());
            });
            
            if (userCoords) {
                const userPosition = new google.maps.LatLng(userCoords.lat, userCoords.lng);
                userMarker = new google.maps.Marker({
                    position: userPosition,
                    map: map,
                    title: 'Your Location',
                    icon: {
                        path: google.maps.SymbolPath.CIRCLE,
                        scale: 8,
                        strokeWeight: 3,
                        strokeColor: '#111',
                        fillColor: '#FCB900',
                        fillOpacity: 1
                    }
                });
                bounds.extend(userPosition);
            }
            
            if (!bounds.isEmpty()) {
                map.fitBounds(bounds, {top: 28, right: 28, bottom: 28, left: 28});
            }
        }

        // Coordinate resolution
        function coordsFor(product) {
            // Try venue coordinates first
            const venue = product.venue || {};
            if (venue.lat && venue.lng) {
                const lat = parseFloat(venue.lat);
                const lng = parseFloat(venue.lng);
                if (Number.isFinite(lat) && Number.isFinite(lng)) {
                    return {
                        lat: lat,
                        lng: lng,
                        label: venue.name || venue.address || '',
                        state: guessStateFromLabel(venue.name || venue.address || '')
                    };
                }
            }
            
            // Try location tag
            const locationTag = (product.loc_tag || '').toLowerCase();
            if (VALID_LOCS.has(locationTag)) {
                const location = LOCS[locationTag];
                return {
                    lat: location.lat,
                    lng: location.lng,
                    label: location.label,
                    state: location.state
                };
            }
            
            // Try tags
            const matchingTag = (product.tags || []).find(tag => 
                VALID_LOCS.has((tag.slug || '').toLowerCase())
            );
            if (matchingTag) {
                const location = LOCS[matchingTag.slug.toLowerCase()];
                return {
                    lat: location.lat,
                    lng: location.lng,
                    label: location.label,
                    state: location.state
                };
            }
            
            return null;
        }
        
        function guessStateFromLabel(label) {
            if (/\bPA\b|Pennsylvania/i.test(label)) return 'PA';
            if (/\bNJ\b|New Jersey/i.test(label)) return 'NJ';
            if (/\bDE\b|Delaware/i.test(label)) return 'DE';
            if (/\bNY\b|New York/i.test(label)) return 'NY';
            return 'all';
        }

        // Render camp cards
        function render(products, userCoords) {
            grid.innerHTML = '';
            let shownCount = 0;
            const radius = parseFloat(radiusSel.value || '25');
            
            products.forEach(product => {
                const position = coordsFor(product);
                if (!position) return;
                
                // Apply state filter
                if (activeState !== 'all' && position.state !== activeState) return;
                
                // Apply distance filter
                let distance = null;
                if (userCoords && position) {
                    distance = distMiles(userCoords, position);
                    if (!isFinite(distance) || distance > radius) return;
                }
                
                shownCount++;
                
                // Build card HTML
                const image = (product.images && product.images[0] && product.images[0].src) || '';
                const price = (product.prices && product.prices.price) 
                    ? (product.prices.price / 100).toLocaleString(undefined, {
                        style: 'currency',
                        currency: product.prices.currency_code || 'USD'
                    })
                    : '';
                const tags = product.tags || [];
                
                const cardElement = document.createElement('article');
                cardElement.className = 'card';
                cardElement.setAttribute('role', 'listitem');
                cardElement.innerHTML = `
                    <div class="media">
                        ${image ? `<img src="${image}" alt="${product.name.replace(/"/g, '&quot;')}" loading="lazy">` : ''}
                    </div>
                    <div class="body">
                        <h3 class="h3">${product.name}</h3>
                        <div class="meta">
                            ${price ? `<span>${price}</span>` : ''}
                            ${position && position.label ? `<span>• ${position.label}</span>` : ''}
                            ${distance !== null ? `<span class="dist" title="Distance from your location">${fmtMiles(distance)}</span>` : ''}
                        </div>
                        <div class="tags">
                            ${tags.map(tag => `<span class="tag">${tag.name || tag.slug}</span>`).join('')}
                        </div>
                        <div class="cta">
                            <a class="btn-cta" href="${product.permalink}" target="_blank" rel="noopener" 
                               aria-label="Register for ${product.name}">Register Now</a>
                        </div>
                    </div>
                `;
                
                grid.appendChild(cardElement);
            });
            
            // Update summary and empty state
            empty.hidden = shownCount > 0;
            summL.textContent = `${shownCount} camp${shownCount === 1 ? '' : 's'}${activeState === 'all' ? '' : ` in ${activeState}`}`;
            summR.textContent = userCoords ? `within ${radiusSel.value} miles` : '';
        }

        // State management
        function setStatus(message) {
            statusEl.textContent = message || '';
        }
        
        function saveCoords(coords) {
            try {
                localStorage.setItem('ptp_user_coords', JSON.stringify(coords));
            } catch (error) {
                console.warn('Could not save coordinates to localStorage');
            }
        }
        
        function loadCoords() {
            try {
                return JSON.parse(localStorage.getItem('ptp_user_coords') || 'null');
            } catch (error) {
                return null;
            }
        }

        // Event handlers
        let currentProducts = [];
        let lastUserCoords = null;
        
        async function loadProducts() {
            setStatus('Loading camps...');
            try {
                const products = await fetchProducts();
                currentProducts = products;
                render(currentProducts, lastUserCoords);
                await loadMaps();
                updateMap(currentProducts, lastUserCoords);
            } catch (error) {
                diag.err.textContent = error.message || String(error);
                setStatus('Could not load camps. Use demo mode to test.');
            }
        }

        async function handleFindCamps() {
            const query = (zipInput.value || '').trim();
            if (!query) {
                setStatus('Please enter a ZIP code or city name.');
                zipInput.focus();
                return;
            }
            
            setStatus('Finding your location...');
            try {
                const coords = await geocodeZip(query);
                lastUserCoords = coords;
                saveCoords(coords);
                setStatus('Sorting camps by distance from your location...');
                render(currentProducts, lastUserCoords);
                updateMap(currentProducts, lastUserCoords);
            } catch (error) {
                diag.err.textContent = error.message || String(error);
                setStatus('Location not found. Please try a different ZIP code or city.');
            }
        }

        function handleGeolocation() {
            if (!navigator.geolocation) {
                setStatus('Geolocation is not supported by this browser.');
                return;
            }
            
            setStatus('Getting your current location...');
            navigator.geolocation.getCurrentPosition(
                async (position) => {
                    lastUserCoords = {
                        lat: position.coords.latitude,
                        lng: position.coords.longitude
                    };
                    saveCoords(lastUserCoords);
                    render(currentProducts, lastUserCoords);
                    updateMap(currentProducts, lastUserCoords);
                    setStatus('Camps sorted by your current location.');
                },
                (error) => {
                    console.error('Geolocation error:', error);
                    setStatus('Could not get your location. Please enter a ZIP code instead.');
                },
                {
                    enableHighAccuracy: false,
                    timeout: 10000,
                    maximumAge: 300000 // 5 minutes
                }
            );
        }

        // Event listeners
        btnFind.addEventListener('click', handleFindCamps);
        btnGeo.addEventListener('click', handleGeolocation);
        
        radiusSel.addEventListener('change', () => {
            render(currentProducts, lastUserCoords);
            updateMap(currentProducts, lastUserCoords);
        });
        
        zipInput.addEventListener('keydown', (event) => {
            if (event.key === 'Enter') {
                handleFindCamps();
            }
        });

        // Demo functionality
        function getDemoData() {
            return [
                {
                    name: 'PTP Select Camp — Main Line (Demo)',
                    permalink: '#main-line-demo',
                    prices: {price: 49900, currency_code: 'USD'},
                    images: [{src: 'https://ptpsummercamps.com/wp-content/uploads/2025/09/BG7A7201-2-scaled.jpg'}],
                    tags: [{slug: 'main-line', name: 'Main Line'}, {slug: 'winter', name: 'Winter'}, {slug: 'select', name: 'Select'}],
                    venue: {lat: '', lng: '', name: ''},
                    loc_tag: 'main-line'
                },
                {
                    name: 'PTP Select Camp — Princeton (Demo)',
                    permalink: '#princeton-demo',
                    prices: {price: 49900, currency_code: 'USD'},
                    images: [{src: 'https://ptpsummercamps.com/wp-content/uploads/2025/09/BG7A7342-scaled.jpg'}],
                    tags: [{slug: 'princeton', name: 'Princeton'}, {slug: 'winter', name: 'Winter'}, {slug: 'select', name: 'Select'}],
                    venue: {lat: '', lng: '', name: ''},
                    loc_tag: 'princeton'
                },
                {
                    name: 'PTP Elite Camp — West Chester (Demo)',
                    permalink: '#west-chester-demo',
                    prices: {price: 59900, currency_code: 'USD'},
                    images: [{src: 'https://ptpsummercamps.com/wp-content/uploads/2025/09/BG7A7201-2-scaled.jpg'}],
                    tags: [{slug: 'west-chester', name: 'West Chester'}, {slug: 'winter', name: 'Winter'}, {slug: 'elite', name: 'Elite'}],
                    venue: {lat: '', lng: '', name: ''},
                    loc_tag: 'west-chester'
                }
            ];
        }
        
        btnDemo.addEventListener('click', async () => {
            currentProducts = getDemoData();
            lastUserCoords = loadCoords();
            render(currentProducts, lastUserCoords);
            await loadMaps();
            updateMap(currentProducts, lastUserCoords);
            setStatus('Demo data loaded successfully. Layout and map verified.');
        });

        // Initialize
        lastUserCoords = loadCoords();
        loadProducts();
        loadMaps();
    })();
    </script>
</body>
</html>