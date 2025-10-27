<?php
/**
 * Plugin Name: PTP Soccer Camps Shop Component
 * Description: A Revolve-style shop component with ZIP code filtering and state tabs for PTP Soccer Camps
 * Version: 1.0.0
 * Author: PTP Soccer Camps
 */

// Prevent direct access
if (!defined('ABSPATH')) {
    exit;
}

class PTP_Shop_Component {
    
    public function __construct() {
        add_action('init', array($this, 'init'));
        add_action('wp_enqueue_scripts', array($this, 'enqueue_scripts'));
        add_shortcode('ptp_shop', array($this, 'render_shop_shortcode'));
    }
    
    public function init() {
        // Initialize any necessary hooks
    }
    
    public function enqueue_scripts() {
        // Only enqueue on pages that use the shortcode
        global $post;
        if (is_a($post, 'WP_Post') && has_shortcode($post->post_content, 'ptp_shop')) {
            wp_enqueue_script('jquery');
        }
    }
    
    public function render_shop_shortcode($atts) {
        $atts = shortcode_atts(array(
            'title' => 'Find a PTP Camp Near You',
            'description' => 'Use your ZIP to see Winter Clinics and Summer Camps closest to you. You can also refine by season, market, and focus.'
        ), $atts);
        
        ob_start();
        ?>
        <!-- ✅ PTP — Revolve‑Style Shop + ZIP Prompt + State Tabs (Woo Store API) -->
        <section id="ptpRevolveShopV2" class="alignfull" aria-label="PTP Soccer Camps — Find a Camp Near You">
            <style>
                /* ===== Tokens ===== */
                #ptpRevolveShopV2{--y:#FCB900;--ink:#0e0f11;--muted:#6b7280;--bg:#fff;--b:#e5e7eb;--r:14px;--shadow:0 8px 24px rgba(0,0,0,.06);--max:1180px;--pad:clamp(12px,3.6vw,28px)}
                #ptpRevolveShopV2,*{box-sizing:border-box;font-family:Inter,system-ui,-apple-system,"Segoe UI",Roboto,Helvetica,Arial,sans-serif}
                #ptpRevolveShopV2{width:100vw;margin-left:calc(50% - 50vw);margin-right:calc(50% - 50vw);background:#fff;color:var(--ink)}

                /* ===== Top bar (ZIP + Sort) ===== */
                #ptpRevolveShopV2 .wrap{max-width:var(--max);margin:0 auto;padding:var(--pad)}
                #ptpRevolveShopV2 .top{display:flex;align-items:center;gap:10px;flex-wrap:wrap;margin-bottom:8px}
                #ptpRevolveShopV2 h1{flex:1;font-weight:800;letter-spacing:-.02em;font-size:clamp(22px,3.6vw,34px);margin:0}
                #ptpRevolveShopV2 .controls{display:flex;gap:10px;align-items:center;flex-wrap:wrap}

                #ptpRevolveShopV2 .zipbox{display:flex;gap:8px;align-items:center;border:1px solid var(--b);border-radius:999px;padding:6px 8px;background:#fff}
                #ptpRevolveShopV2 .zipbox input{border:none;outline:none;font-size:14px;width:120px}
                #ptpRevolveShopV2 .zipbox select{border:none;outline:none;background:#fff;font-size:14px}
                #ptpRevolveShopV2 .btn{appearance:none;border:none;border-radius:999px;background:#0e0f11;color:#fff;padding:10px 14px;font-weight:800;cursor:pointer}
                #ptpRevolveShopV2 .btn.secondary{background:#fff;color:#0e0f11;border:1px solid var(--b)}

                #ptpRevolveShopV2 .sort{border:1px solid var(--b);border-radius:999px;padding:6px 10px;background:#fff}
                #ptpRevolveShopV2 .lede{color:var(--muted);margin:4px 0 14px}

                /* ===== State Tabs (PTP style) ===== */
                #ptpRevolveShopV2 .state-tabs{display:flex;gap:10px;flex-wrap:wrap;margin:6px 0 14px;overflow:auto;padding-bottom:4px;scroll-snap-type:x proximity}
                #ptpRevolveShopV2 .stab{scroll-snap-align:start;appearance:none;border:1px solid var(--b);background:#fff;border-radius:999px;padding:8px 12px;font-weight:800;cursor:pointer;white-space:nowrap}
                #ptpRevolveShopV2 .stab[aria-pressed="true"]{background:var(--ink);color:#fff;border-color:var(--ink)}

                /* ===== Layout: Sidebar + Grid ===== */
                #ptpRevolveShopV2 .layout{display:grid;grid-template-columns:1fr;gap:18px}
                @media(min-width:980px){#ptpRevolveShopV2 .layout{grid-template-columns:260px 1fr}}

                /* Sidebar */
                #ptpRevolveShopV2 .sidebar{border:1px solid var(--b);border-radius:var(--r);padding:14px;position:sticky;top:10px;height:max-content}
                #ptpRevolveShopV2 .sidehdr{display:flex;align-items:center;justify-content:space-between;margin-bottom:6px}
                #ptpRevolveShopV2 .sidehdr strong{font-size:16px}
                #ptpRevolveShopV2 details{border-top:1px solid var(--b)}
                #ptpRevolveShopV2 details:first-of-type{border-top:none}
                #ptpRevolveShopV2 summary{cursor:pointer;padding:12px 2px;font-weight:800;list-style:none}
                #ptpRevolveShopV2 .facet{display:grid;gap:8px;padding:0 2px 14px}
                #ptpRevolveShopV2 label{display:flex;align-items:center;gap:8px;font-size:14px}

                /* Mobile filter button (drawer) */
                #ptpRevolveShopV2 .filter-open{display:flex;gap:8px;align-items:center}
                @media(min-width:980px){#ptpRevolveShopV2 .filter-open{display:none}}
                #ptpRevolveShopV2 .drawer{position:fixed;inset:0;background:rgba(0,0,0,.4);display:none;z-index:60}
                #ptpRevolveShopV2 .drawer.on{display:block}
                #ptpRevolveShopV2 .drawer .panel{position:absolute;left:0;top:0;bottom:0;width:min(88vw,380px);background:#fff;border-right:1px solid var(--b);padding:16px;overflow:auto}

                /* Grid */
                #ptpRevolveShopV2 .grid{display:grid;grid-template-columns:1fr;gap:14px}
                @media(min-width:600px){#ptpRevolveShopV2 .grid{grid-template-columns:repeat(2,1fr)}}
                @media(min-width:980px){#ptpRevolveShopV2 .grid{grid-template-columns:repeat(3,1fr)}}

                /* Card */
                #ptpRevolveShopV2 .card{border:1px solid var(--b);border-radius:12px;overflow:hidden;background:#fff;transition:transform .12s ease, box-shadow .12s ease}
                #ptpRevolveShopV2 .card:hover{transform:translateY(-2px);box-shadow:0 6px 16px rgba(0,0,0,.06)}
                #ptpRevolveShopV2 .media{position:relative;aspect-ratio:3/4;background:#111}
                #ptpRevolveShopV2 .media img{width:100%;height:100%;object-fit:cover;display:block}
                #ptpRevolveShopV2 .badge{position:absolute;top:10px;left:10px;background:var(--y);color:#111;font-weight:800;padding:6px 10px;border-radius:999px;font-size:12px}
                #ptpRevolveShopV2 .body{padding:12px}
                #ptpRevolveShopV2 .title{font-weight:800;line-height:1.35}
                #ptpRevolveShopV2 .meta{font-size:13px;color:var(--muted);margin-top:2px}
                #ptpRevolveShopV2 .price{font-weight:800;margin-top:6px}
                #ptpRevolveShopV2 .cta{margin-top:10px;display:inline-flex;align-items:center;justify-content:center;border-radius:12px;border:2px solid #111;background:#111;color:#fff;font-weight:800;padding:10px 12px;text-decoration:none}

                /* Chips row (active filters) */
                #ptpRevolveShopV2 .chips{display:flex;gap:8px;flex-wrap:wrap;margin:10px 0}
                #ptpRevolveShopV2 .chip{border:1px solid var(--b);border-radius:999px;padding:6px 10px;background:#fff}

                /* Load more */
                #ptpRevolveShopV2 .load{margin:18px 0 0;display:flex;justify-content:center}
                #ptpRevolveShopV2 .load button{appearance:none;border:1px solid var(--b);background:#fff;padding:12px 16px;border-radius:12px;font-weight:800;cursor:pointer}

                /* Skeleton */
                #ptpRevolveShopV2 .skeleton{animation:pulse 1.2s infinite ease-in-out;background:linear-gradient(90deg,#eee,#f7f7f7,#eee);background-size:200% 100%}
                @keyframes pulse{0%{background-position:200% 0}100%{background-position:-200% 0}}
                #ptpRevolveShopV2 .card.skel .media{background:#eee}
                #ptpRevolveShopV2 .card.skel .body>*{height:14px;border-radius:6px}

                /* ===== ZIP Ask Modal ===== */
                #ptpRevolveShopV2 .zipmodal{position:fixed;inset:0;background:rgba(0,0,0,.55);display:none;z-index:80}
                #ptpRevolveShopV2 .zipmodal.on{display:block}
                #ptpRevolveShopV2 .zipmodal .panel{position:absolute;left:50%;top:50%;transform:translate(-50%,-50%);background:#fff;border:1px solid var(--b);border-radius:16px;box-shadow:var(--shadow);width:min(92vw,520px);padding:18px}
                #ptpRevolveShopV2 .zipmodal h3{margin:0 0 6px;font-size:clamp(18px,3vw,22px);font-weight:800}
                #ptpRevolveShopV2 .zipmodal p{margin:0 0 12px;color:var(--muted)}
                #ptpRevolveShopV2 .zipmodal .row{display:flex;gap:10px;align-items:center;margin-bottom:12px}
                #ptpRevolveShopV2 .zipmodal input{flex:1;border:1px solid var(--b);border-radius:999px;padding:10px 12px;font-size:14px}
                #ptpRevolveShopV2 .zipmodal select{border:1px solid var(--b);border-radius:999px;padding:10px 12px;font-size:14px}
                #ptpRevolveShopV2 .zipmodal .actions{display:flex;gap:10px;justify-content:flex-end}
                #ptpRevolveShopV2 .zipmodal .btn{appearance:none;border:none;border-radius:999px;background:#0e0f11;color:#fff;padding:10px 14px;font-weight:800;cursor:pointer}
                #ptpRevolveShopV2 .zipmodal .btn.secondary{background:#fff;color:#0e0f11;border:1px solid var(--b)}
            </style>

            <div class="wrap">
                <div class="top">
                    <h1><?php echo esc_html($atts['title']); ?></h1>
                    <div class="controls">
                        <button class="btn secondary filter-open" type="button" aria-controls="ptpFilterDrawer" aria-expanded="false">Filters</button>
                        <div class="zipbox" role="search">
                            <input id="zipInput" inputmode="numeric" pattern="\d{5}" maxlength="5" placeholder="ZIP code" aria-label="Enter ZIP code">
                            <select id="radiusSelect" aria-label="Select radius">
                                <option value="direct">Exact area</option>
                                <option value="near">Nearby</option>
                            </select>
                            <button class="btn" id="zipSearch" type="button">Search</button>
                        </div>
                        <select id="sortSelect" class="sort" aria-label="Sort products">
                            <option value="menu_order">Featured</option>
                            <option value="date-desc">Newest</option>
                            <option value="price-asc">Price: Low to High</option>
                            <option value="price-desc">Price: High to Low</option>
                            <option value="title-asc">A–Z</option>
                        </select>
                    </div>
                </div>
                <p class="lede"><?php echo esc_html($atts['description']); ?></p>

                <!-- State tabs -->
                <div class="state-tabs" role="tablist" aria-label="Filter by state">
                    <button class="stab" data-state="ALL" aria-pressed="true" role="tab" aria-selected="true">All</button>
                    <button class="stab" data-state="PA" aria-pressed="false" role="tab" aria-selected="false">PA</button>
                    <button class="stab" data-state="NJ" aria-pressed="false" role="tab" aria-selected="false">NJ</button>
                    <button class="stab" data-state="DE" aria-pressed="false" role="tab" aria-selected="false">DE</button>
                    <button class="stab" data-state="MD" aria-pressed="false" role="tab" aria-selected="false">MD</button>
                    <button class="stab" data-state="NY" aria-pressed="false" role="tab" aria-selected="false">NY</button>
                </div>

                <!-- Active chips -->
                <div class="chips" aria-live="polite"></div>

                <div class="layout">
                    <!-- Sidebar faceting -->
                    <aside class="sidebar" aria-label="Filters">
                        <div class="sidehdr"><strong>Filters</strong><button class="btn secondary" id="clearAll" type="button">Clear</button></div>
                        <details open>
                            <summary>Season</summary>
                            <div class="facet" data-facet="season">
                                <label><input type="checkbox" value="winter-clinics" checked> Winter Clinics</label>
                                <label><input type="checkbox" value="summer" checked> Summer Camps</label>
                            </div>
                        </details>
                        <details open>
                            <summary>Market</summary>
                            <div class="facet" data-facet="market">
                                <label><input type="checkbox" value="main-line"> Main Line, PA</label>
                                <label><input type="checkbox" value="west-chester"> West Chester, PA</label>
                                <label><input type="checkbox" value="doylestown"> Doylestown, PA</label>
                                <label><input type="checkbox" value="media"> Media, PA</label>
                                <label><input type="checkbox" value="newtown-square"> Newtown Square, PA</label>
                                <label><input type="checkbox" value="princeton"> Princeton, NJ</label>
                                <label><input type="checkbox" value="short-hills"> Short Hills, NJ</label>
                                <label><input type="checkbox" value="ridgewood"> Ridgewood, NJ</label>
                                <label><input type="checkbox" value="summit"> Summit, NJ</label>
                                <label><input type="checkbox" value="chatham"> Chatham, NJ</label>
                                <label><input type="checkbox" value="montclair"> Montclair, NJ</label>
                                <label><input type="checkbox" value="hockessin"> Hockessin, DE</label>
                                <label><input type="checkbox" value="wilmington"> Wilmington, DE</label>
                                <label><input type="checkbox" value="greenville"> Greenville, DE</label>
                                <label><input type="checkbox" value="scarsdale"> Scarsdale, NY</label>
                                <label><input type="checkbox" value="rye"> Rye, NY</label>
                                <label><input type="checkbox" value="garden-city"> Garden City, NY</label>
                                <label><input type="checkbox" value="white-plains"> White Plains, NY</label>
                                <label><input type="checkbox" value="manhasset"> Manhasset, NY</label>
                                <label><input type="checkbox" value="port-washington"> Port Washington, NY</label>
                            </div>
                        </details>
                        <details open>
                            <summary>Focus</summary>
                            <div class="facet" data-facet="focus">
                                <label><input type="checkbox" value="girls"> Girls</label>
                                <label><input type="checkbox" value="elite"> Elite</label>
                                <label><input type="checkbox" value="goalkeeper"> Goalkeeper</label>
                                <label><input type="checkbox" value="pro-guest"> Pro Guest</label>
                                <label><input type="checkbox" value="one-day"> One‑Day</label>
                                <label><input type="checkbox" value="indoor"> Indoor</label>
                                <label><input type="checkbox" value="outdoor"> Outdoor</label>
                            </div>
                        </details>
                    </aside>

                    <main>
                        <div class="grid" aria-live="polite" aria-busy="true"></div>
                        <div class="load"><button type="button" hidden>Show more</button></div>
                    </main>
                </div>
            </div>

            <!-- ZIP Ask Modal -->
            <div class="zipmodal" id="zipAsk" aria-hidden="true">
                <div class="panel" role="dialog" aria-label="Enter ZIP to find nearby camps">
                    <h3>What's your ZIP code?</h3>
                    <p>We'll show PTP camps near you first. You can change this anytime.</p>
                    <div class="row">
                        <input id="zipModalInput" inputmode="numeric" pattern="\d{5}" maxlength="5" placeholder="e.g., 19087" aria-label="Enter ZIP code">
                        <select id="zipModalRadius" aria-label="Select radius">
                            <option value="direct">Exact area</option>
                            <option value="near" selected>Nearby</option>
                        </select>
                    </div>
                    <div class="actions">
                        <button class="btn" id="zipSaveBtn" type="button">Save ZIP</button>
                        <button class="btn secondary" id="zipSkip" type="button">Skip</button>
                    </div>
                </div>
            </div>

            <!-- Drawer for mobile filters -->
            <div class="drawer" id="ptpFilterDrawer" aria-hidden="true">
                <div class="panel" role="dialog" aria-label="Filters">
                    <!-- Sidebar content will be cloned here on mobile open -->
                </div>
            </div>

            <script>
                (function(){
                    const root = document.getElementById('ptpRevolveShopV2');
                    if(!root) return;
                    const API = '<?php echo esc_url(rest_url('wc/store/v1')); ?>';

                    // ======= CONFIG =======
                    const CATEGORY_SLUGS = ['winter-clinics','summer'];
                    const MARKET_TAGS = ['main-line','media','west-chester','doylestown','newtown-square','princeton','short-hills','ridgewood','summit','chatham','montclair','hockessin','wilmington','greenville','scarsdale','rye','garden-city','white-plains','manhasset','port-washington'];
                    const FOCUS_TAGS  = ['girls','elite','goalkeeper','pro-guest','one-day','indoor','outdoor'];

                    // State to markets mapping for quick tabs
                    const STATE_TO_MARKETS = {
                        ALL: [],
                        PA: ['main-line','media','west-chester','doylestown','newtown-square'],
                        NJ: ['princeton','short-hills','ridgewood','summit','chatham','montclair'],
                        DE: ['hockessin','wilmington','greenville'],
                        MD: [], // add MD markets when ready
                        NY: ['scarsdale','rye','garden-city','white-plains','manhasset','port-washington']
                    };

                    // ZIP → Market tags mapping (extend as needed)
                    const ZIP_TO_MARKET = {
                        // PA — Main Line
                        '19003':['main-line'],'19010':['main-line'],'19041':['main-line'],'19087':['main-line'],'19333':['main-line'],'19085':['main-line'],
                        // PA — West Chester & Doylestown & Media & Newtown Sq
                        '19380':['west-chester'],'19382':['west-chester'],'19383':['west-chester'],
                        '18901':['doylestown'],'18902':['doylestown'],
                        '19063':['media'],'19073':['newtown-square'],
                        // DE — Hockessin / Wilmington / Greenville
                        '19707':['hockessin'],'19803':['wilmington'],'19807':['greenville','wilmington'],
                        // NJ — Short Hills / Summit / Chatham / Montclair / Ridgewood / Princeton
                        '07078':['short-hills'],'07901':['summit'],'07928':['chatham'],'07042':['montclair'],'07043':['montclair'],'07450':['ridgewood'],'07451':['ridgewood'],
                        '08540':['princeton'],'08542':['princeton'],'08544':['princeton'],
                        // NY — Scarsdale / Rye / White Plains / Garden City / Manhasset / Port Washington
                        '10583':['scarsdale'],'10580':['rye'],'10601':['white-plains'],'10605':['white-plains'],'11530':['garden-city'],'11030':['manhasset'],'11050':['port-washington']
                    };

                    const ui = {
                        grid: root.querySelector('.grid'),
                        chips: root.querySelector('.chips'),
                        loadBtn: root.querySelector('.load button'),
                        sort: root.querySelector('#sortSelect'),
                        zipInput: root.querySelector('#zipInput'),
                        radius: root.querySelector('#radiusSelect'),
                        zipBtn: root.querySelector('#zipSearch'),
                        sidebar: root.querySelector('.sidebar'),
                        drawer: root.querySelector('#ptpFilterDrawer'),
                        filterOpen: root.querySelector('.filter-open'),
                        clearAll: root.querySelector('#clearAll'),
                        stateTabs: root.querySelectorAll('.state-tabs .stab'),
                        zipModal: root.querySelector('#zipAsk'),
                        zipModalInput: root.querySelector('#zipModalInput'),
                        zipModalRadius: root.querySelector('#zipModalRadius'),
                        zipSave: root.querySelector('#zipSaveBtn'),
                        zipSkip: root.querySelector('#zipSkip')
                    };

                    const state = {
                        catBySlug: {},
                        tagBySlug: {}, // slug -> {id,name,slug}
                        selectedCats: new Set(['winter-clinics','summer']),
                        selectedTagIds: new Set(),
                        activeZip: '',
                        activeState: 'ALL',
                        page: 1,
                        perPage: 12,
                        hasMore: true,
                        loading: false,
                        sort: {orderby:'menu_order', order:'asc'}
                    };

                    // URL presets (?zip=19087&radius=near&season=summer&market=princeton&focus=girls&state=PA)
                    const usp = new URLSearchParams(location.search);

                    init();

                    async function init(){
                        try {
                            // Prefer URL params, then saved localStorage ZIP
                            let initialZip = (usp.get('zip')||'').trim();
                            let initialMode = usp.get('radius') || localStorage.getItem('ptp_zip_mode') || 'near';
                            if(!initialZip){
                                const savedZip = localStorage.getItem('ptp_zip');
                                if(savedZip) initialZip = savedZip;
                            }
                            if(initialZip){ state.activeZip = initialZip; ui.zipInput.value = initialZip; ui.radius.value = initialMode; }

                            await Promise.all([resolveCategories(CATEGORY_SLUGS), resolveTags([...MARKET_TAGS, ...FOCUS_TAGS])]);

                            hydrateSidebarFromURL();
                            buildChips();
                            wireEvents();

                            if(state.activeZip){
                                applyZipToFilters(state.activeZip, ui.radius.value);
                            } else {
                                openZipModal();
                            }

                            // Apply state from URL if present
                            const qState = (usp.get('state')||'').toUpperCase();
                            if(qState && (qState==='ALL' || STATE_TO_MARKETS[qState])){
                                applyState(qState);
                            }

                            loadProducts({reset:true});
                        } catch (error) {
                            console.error('Error initializing PTP shop:', error);
                            showError('Failed to load camp listings. Please refresh the page.');
                        }
                    }

                    function wireEvents(){
                        // Sorting
                        ui.sort.addEventListener('change',()=>{ state.sort = parseSort(ui.sort.value); state.page=1; loadProducts({reset:true}); });
                        // ZIP search
                        ui.zipBtn.addEventListener('click',()=>{ doZipSearch(); });
                        ui.radius.addEventListener('change',()=>{ if(state.activeZip){ localStorage.setItem('ptp_zip_mode', ui.radius.value); applyZipToFilters(state.activeZip, ui.radius.value); updateURL(); loadProducts({reset:true}); } });
                        // Facets
                        root.querySelectorAll('.facet[data-facet="season"] input').forEach(cb=> cb.addEventListener('change',()=>{ 
                            state.selectedCats = getCheckedValues('.facet[data-facet="season"] input'); updateURL(); loadProducts({reset:true});
                        }));
                        root.querySelectorAll('.facet[data-facet="market"] input, .facet[data-facet="focus"] input').forEach(cb=> cb.addEventListener('change',()=>{ 
                            rebuildTagSelectionFromFacets(); updateURL(); loadProducts({reset:true});
                        }));
                        // Clear
                        ui.clearAll.addEventListener('click',()=>{ clearAllFilters(); updateURL(); loadProducts({reset:true}); });
                        // Drawer
                        ui.filterOpen.addEventListener('click',openDrawer);
                        ui.drawer.addEventListener('click',(e)=>{ if(e.target===ui.drawer) closeDrawer(); });
                        ui.loadBtn.onclick = ()=>{ if(state.hasMore){ state.page++; loadProducts(); } };
                        // State tabs
                        ui.stateTabs.forEach(btn=>{ btn.addEventListener('click',()=>{ applyState(btn.dataset.state || 'ALL'); }); });
                        // ZIP modal actions
                        ui.zipSave.addEventListener('click', saveZipFromModal);
                        ui.zipSkip.addEventListener('click', closeZipModal);
                        
                        // Add keyboard support for modals
                        document.addEventListener('keydown', (e) => {
                            if (e.key === 'Escape') {
                                if (ui.zipModal.classList.contains('on')) closeZipModal();
                                if (ui.drawer.classList.contains('on')) closeDrawer();
                            }
                        });
                    }

                    function openDrawer(){ 
                        const panel = ui.drawer.querySelector('.panel'); 
                        panel.innerHTML = ''; 
                        panel.appendChild(ui.sidebar.cloneNode(true)); 
                        ui.drawer.classList.add('on'); 
                        ui.drawer.setAttribute('aria-hidden','false');
                        ui.filterOpen.setAttribute('aria-expanded', 'true');
                    }
                    
                    function closeDrawer(){ 
                        ui.drawer.classList.remove('on'); 
                        ui.drawer.setAttribute('aria-hidden','true');
                        ui.filterOpen.setAttribute('aria-expanded', 'false');
                    }

                    function doZipSearch(){
                        const z = (ui.zipInput.value||'').trim(); 
                        if(!/^\d{5}$/.test(z)) { 
                            alert('Enter a 5‑digit ZIP'); 
                            return; 
                        }
                        state.activeZip = z; 
                        localStorage.setItem('ptp_zip', z); 
                        localStorage.setItem('ptp_zip_mode', ui.radius.value);
                        applyZipToFilters(z, ui.radius.value); 
                        updateURL(); 
                        loadProducts({reset:true});
                    }

                    function getCheckedValues(sel){ 
                        const set = new Set(); 
                        root.querySelectorAll(sel).forEach(cb=>{ if(cb.checked) set.add(cb.value); }); 
                        return set; 
                    }

                    function rebuildTagSelectionFromFacets(){
                        state.selectedTagIds.clear();
                        // Markets
                        root.querySelectorAll('.facet[data-facet="market"] input:checked').forEach(cb=>{ const t = state.tagBySlug[cb.value]; if(t) state.selectedTagIds.add(t.id); });
                        // Focus
                        root.querySelectorAll('.facet[data-facet="focus"] input:checked').forEach(cb=>{ const t = state.tagBySlug[cb.value]; if(t) state.selectedTagIds.add(t.id); });
                        buildChips();
                    }

                    function clearAllFilters(){
                        state.selectedCats = new Set(['winter-clinics','summer']);
                        state.selectedTagIds.clear();
                        state.activeZip = '';
                        ui.zipInput.value = '';
                        root.querySelectorAll('.facet input').forEach(cb=> cb.checked = true);
                        buildChips();
                    }

                    function buildChips(){
                        const chips = [];
                        // Season chips
                        CATEGORY_SLUGS.forEach(s=>{ if(state.selectedCats.has(s)) chips.push(`<span class="chip">${labelForSeason(s)}</span>`); });
                        // State chip
                        if(state.activeState && state.activeState!=='ALL') chips.unshift(`<span class="chip">State ${state.activeState}</span>`);
                        // Tag chips
                        state.selectedTagIds.forEach(id=>{ const t = Object.values(state.tagBySlug).find(x=> x.id===id); if(t) chips.push(`<span class="chip">${escapeHtml(t.name)}</span>`); });
                        if(state.activeZip) chips.unshift(`<span class="chip">ZIP ${escapeHtml(state.activeZip)}</span>`);
                        ui.chips.innerHTML = chips.join('');
                    }

                    function hydrateSidebarFromURL(){
                        // Seasons
                        const qSeasons = (usp.get('season')||'').split(',').map(s=>s.trim()).filter(Boolean);
                        if(qSeasons.length){ state.selectedCats = new Set(qSeasons.filter(s=> CATEGORY_SLUGS.includes(s))); }
                        root.querySelectorAll('.facet[data-facet="season"] input').forEach(cb=> cb.checked = state.selectedCats.has(cb.value));
                        // Markets & Focus
                        const qMarkets = (usp.get('market')||'').split(',').filter(Boolean);
                        const qFocus   = (usp.get('focus')||'').split(',').filter(Boolean);
                        [...qMarkets, ...qFocus].forEach(slug=>{ const t = state.tagBySlug[slug]; if(t) state.selectedTagIds.add(t.id); });
                        root.querySelectorAll('.facet[data-facet="market"] input').forEach(cb=> cb.checked = qMarkets.includes(cb.value));
                        root.querySelectorAll('.facet[data-facet="focus"] input').forEach(cb=> cb.checked = qFocus.includes(cb.value));
                    }

                    function updateURL(){
                        const params = new URLSearchParams();
                        if(state.activeZip) { params.set('zip', state.activeZip); params.set('radius', ui.radius.value); }
                        const seasons = [...state.selectedCats]; if(seasons.length && seasons.length < CATEGORY_SLUGS.length) params.set('season', seasons.join(','));
                        const tagSlugs = [...state.selectedTagIds].map(id=> idToSlug(id));
                        const markets = tagSlugs.filter(s=> MARKET_TAGS.includes(s)); if(markets.length) params.set('market', markets.join(','));
                        const focus   = tagSlugs.filter(s=> FOCUS_TAGS.includes(s)); if(focus.length) params.set('focus', focus.join(','));
                        if(state.activeState && state.activeState!=='ALL') params.set('state', state.activeState);
                        const v = ui.sort.value; if(v && v!=='menu_order') params.set('sort', v);
                        const url = location.pathname + (params.toString()?('?'+params.toString()):'');
                        history.replaceState(null,'',url);
                        buildChips();
                    }

                    function idToSlug(id){ const t = Object.values(state.tagBySlug).find(x=> x.id===id); return t? t.slug: '' }
                    function labelForSeason(slug){ return slug==='winter-clinics'?'Winter Clinics': slug==='summer'?'Summer Camps': slug }
                    function parseSort(v){ if(v==='price-asc') return {orderby:'price',order:'asc'}; if(v==='price-desc') return {orderby:'price',order:'desc'}; if(v==='date-desc') return {orderby:'date',order:'desc'}; if(v==='title-asc') return {orderby:'title',order:'asc'}; return {orderby:'menu_order',order:'asc'}; }

                    function applyZipToFilters(zip, mode){
                        const markets = new Set(ZIP_TO_MARKET[zip]||[]);
                        if(mode==='near'){
                            if(markets.size===0){ ['main-line','west-chester','media','princeton','wilmington','hockessin'].forEach(m=> markets.add(m)); }
                        }
                        root.querySelectorAll('.facet[data-facet="market"] input').forEach(cb=> cb.checked = markets.has(cb.value));
                        rebuildTagSelectionFromFacets();
                    }

                    function applyState(code){
                        state.activeState = code;
                        ui.stateTabs.forEach(b=> {
                            const isSelected = b.dataset.state === code;
                            b.setAttribute('aria-pressed', String(isSelected));
                            b.setAttribute('aria-selected', String(isSelected));
                        });
                        if(code==='ALL'){
                            // Clear market facet (no tag filter ⇒ show all)
                            root.querySelectorAll('.facet[data-facet="market"] input').forEach(cb=> cb.checked = false);
                            state.selectedTagIds.clear();
                        } else {
                            const markets = new Set(STATE_TO_MARKETS[code]||[]);
                            root.querySelectorAll('.facet[data-facet="market"] input').forEach(cb=> cb.checked = markets.has(cb.value));
                        }
                        rebuildTagSelectionFromFacets();
                        updateURL();
                        loadProducts({reset:true});
                    }

                    // ===== Data =====
                    async function resolveCategories(slugs){
                        try {
                            // Pull a big list so we can build the tree
                            const url = new URL(API + '/products/categories');
                            url.searchParams.set('per_page', 100);
                            const cats = await safeFetch(url) || [];
                            const byParent = new Map();
                            cats.forEach(c => {
                                const arr = byParent.get(c.parent) || [];
                                arr.push(c);
                                byParent.set(c.parent, arr);
                            });

                            // DFS to gather all descendants for a given parent id
                            function gatherDescendants(parentId){
                                const out = new Set([parentId]);
                                const stack = [parentId];
                                while (stack.length){
                                    const id = stack.pop();
                                    const kids = byParent.get(id) || [];
                                    for(const k of kids){
                                        if(!out.has(k.id)){ out.add(k.id); stack.push(k.id); }
                                    }
                                }
                                return [...out];
                            }

                            // Build slug -> [ids...] (parent + all children)
                            state.catBySlug = {};
                            slugs.forEach(s => {
                                const parent = cats.find(c => c.slug === s);
                                state.catBySlug[s] = parent ? gatherDescendants(parent.id) : [];
                            });
                        } catch (error) {
                            console.error('Error resolving categories:', error);
                            throw error;
                        }
                    }
                    
                    async function resolveTags(slugs){ 
                        try {
                            const url = new URL(API + '/products/tags'); 
                            url.searchParams.set('per_page', 100); 
                            url.searchParams.set('slug', slugs.join(',')); 
                            const rows = await safeFetch(url); 
                            (rows||[]).forEach(t=> state.tagBySlug[t.slug] = t); 
                        } catch (error) {
                            console.error('Error resolving tags:', error);
                            throw error;
                        }
                    }

                    async function loadProducts({reset=false}={}){
                        if(state.loading) return; 
                        state.loading = true;
                        if(reset){ state.page=1; state.hasMore=true; showSkeletons(); }
                        const catIds = [...state.selectedCats].flatMap(s => state.catBySlug[s] || []).filter(Boolean);
                        const tagIds = [...state.selectedTagIds];
                        try{
                            const rows = await fetchProducts({categories:catIds, tagIds, page:state.page, perPage:state.perPage, sort:state.sort});
                            if(reset) ui.grid.innerHTML='';
                            renderProducts(rows);
                            state.hasMore = rows.length === state.perPage;
                            ui.loadBtn.hidden = !state.hasMore;
                        } catch (error) {
                            console.error('Error loading products:', error);
                            showError('Failed to load camp listings. Please try again.');
                        } finally{
                            ui.grid.removeAttribute('aria-busy'); 
                            state.loading=false;
                        }
                    }

                    async function fetchProducts({categories=[], tagIds=[], page=1, perPage=12, sort={orderby:'menu_order',order:'asc'}}){
                        try {
                            const url = new URL(API + '/products');
                            url.searchParams.set('per_page', perPage);
                            url.searchParams.set('page', page);
                            url.searchParams.set('orderby', sort.orderby);
                            url.searchParams.set('order', sort.order);
                            // categories may be array-of-arrays (parent + descendants) → flatten
                            const flatCats = (categories||[]).flat().filter(Boolean);
                            if(flatCats.length) url.searchParams.set('category', flatCats.join(','));
                            if(tagIds && tagIds.length) url.searchParams.set('tag', tagIds.join(','));
                            url.searchParams.set('catalog_visibility','visible');
                            return await safeFetch(url) || [];
                        } catch (error) {
                            console.error('Error fetching products:', error);
                            throw error;
                        }
                    }

                    function showSkeletons(n=6){ 
                        ui.grid.setAttribute('aria-busy','true'); 
                        ui.grid.innerHTML=''; 
                        for(let i=0;i<n;i++){ 
                            ui.grid.appendChild(skelCard()); 
                        } 
                    }
                    
                    function skelCard(){ 
                        const el = document.createElement('article'); 
                        el.className='card skel'; 
                        el.innerHTML = `<div class="media skeleton"></div><div class="body"><div class="skeleton" style="width:70%;height:14px"></div><div class="skeleton" style="width:40%;height:14px;margin-top:8px"></div></div>`; 
                        return el; 
                    }

                    function renderProducts(rows){ 
                        rows.forEach(p=> ui.grid.appendChild(productCard(p))); 
                    }
                    
                    function productCard(p){
                        const img = (p.images && p.images[0]) ? p.images[0].src : '';
                        const alt = (p.images && p.images[0]) ? (p.images[0].alt || p.name) : p.name;
                        const stock = p.stock_status; 
                        const low = p.low_stock_remaining; 
                        const badge = low!=null && low<=5 ? 'Almost full' : (stock==='outofstock'?'Sold out': null);
                        const card = document.createElement('article'); 
                        card.className='card';
                        card.innerHTML = `
                            <a class="media" href="${p.permalink}" aria-label="Open ${escapeHtml(p.name)}">
                                ${img?`<img src="${img}" alt="${escapeHtml(alt)}" loading="lazy">`:''}
                                ${badge?`<span class="badge">${badge}</span>`:''}
                            </a>
                            <div class="body">
                                <div class="title">${escapeHtml(p.name)}</div>
                                <div class="meta">${escapeHtml(metaLine(p))}</div>
                                <div class="price">${p.price_html||''}</div>
                                <a class="cta" href="${p.permalink}">View & Register</a>
                            </div>`;
                        return card;
                    }
                    
                    function metaLine(p){ 
                        const attrs = (p.attributes||[]); 
                        const get = (slug)=>{ 
                            const a = attrs.find(x=> x.slug===slug || x.name?.toLowerCase()===slug.replace('pa_','').replaceAll('-',' ')); 
                            return a && a.terms && a.terms[0] ? a.terms[0].name : '' 
                        }; 
                        const date = get('pa_date_range') || get('date range'); 
                        const time = get('pa_time_range') || get('time range'); 
                        const ages = get('pa_ages') || get('ages'); 
                        const venue= get('pa_venue_name') || get('venue name'); 
                        return [date,time,ages,venue].filter(Boolean).join(' • '); 
                    }

                    async function safeFetch(url){ 
                        try {
                            const res = await fetch(url,{credentials:'same-origin'}); 
                            if(!res.ok) throw new Error('HTTP '+res.status); 
                            return await res.json(); 
                        } catch (error) {
                            console.error('Fetch error:', error);
                            throw error;
                        }
                    }
                    
                    function escapeHtml(s){ 
                        return String(s||'').replace(/[&<>"']/g, m=> ({'&':'&amp;','<':'&lt;','>':'&gt;','"':'&quot;','\'':'&#39;'}[m])); 
                    }

                    function openZipModal(){ 
                        ui.zipModal.classList.add('on'); 
                        ui.zipModal.setAttribute('aria-hidden','false'); 
                        ui.zipModalInput.focus();
                    }
                    
                    function closeZipModal(){ 
                        ui.zipModal.classList.remove('on'); 
                        ui.zipModal.setAttribute('aria-hidden','true'); 
                    }
                    
                    function saveZipFromModal(){ 
                        const z = (ui.zipModalInput.value||'').trim(); 
                        const m = ui.zipModalRadius.value || 'near'; 
                        if(!/^\d{5}$/.test(z)){ 
                            alert('Enter a 5‑digit ZIP'); 
                            return; 
                        } 
                        state.activeZip = z; 
                        ui.zipInput.value = z; 
                        ui.radius.value = m; 
                        localStorage.setItem('ptp_zip', z); 
                        localStorage.setItem('ptp_zip_mode', m); 
                        applyZipToFilters(z, m); 
                        updateURL(); 
                        loadProducts({reset:true}); 
                        closeZipModal(); 
                    }
                    
                    function showError(message) {
                        ui.grid.innerHTML = `<div style="text-align: center; padding: 2rem; color: var(--muted);">${message}</div>`;
                    }
                })();
            </script>
        </section>
        <!-- /PTP — Revolve‑Style Shop + ZIP Prompt + State Tabs -->
        <?php
        return ob_get_clean();
    }
}

// Initialize the plugin
new PTP_Shop_Component();