{{--
    Componente de estilos compartidos para el módulo de productos.
    Uso: <x-amo-styles />
    Coloca este archivo en: resources/views/components/amo-styles.blade.php
--}}

<link href="https://fonts.googleapis.com/css2?family=Playfair+Display:wght@600;700&family=Inter:wght@400;500;600&family=Material+Symbols+Outlined:wght,FILL@100..700,0..1&display=swap" rel="stylesheet"/>

<style>
    /* ══════════════════════════════════════
       TOKENS
    ══════════════════════════════════════ */
    :root {
        --primary:                  #973100;
        --primary-container:        #c04000;
        --primary-fixed:            #ffdbcf;
        --on-primary:               #ffffff;
        --secondary:                #7b5551;
        --secondary-container:      #fecbc6;
        --on-secondary-container:   #7a5450;
        --surface:                  #fcf9f8;
        --surface-container-lowest: #ffffff;
        --surface-container-low:    #f6f3f2;
        --surface-container:        #f0eded;
        --surface-container-high:   #eae7e7;
        --surface-container-highest:#e5e2e1;
        --on-surface:               #1c1b1b;
        --on-surface-variant:       #594139;
        --outline-variant:          #e1bfb4;
        --tertiary-fixed:           #e9e2d3;
        --on-tertiary-fixed:        #1e1b13;
        --error:                    #ba1a1a;
    }

    /* ══════════════════════════════════════
       BASE
    ══════════════════════════════════════ */
    body {
        background-color: var(--surface);
        color: var(--on-surface);
        font-family: 'Inter', sans-serif;
    }
    .material-symbols-outlined {
        font-variation-settings: 'FILL' 0, 'wght' 400, 'GRAD' 0, 'opsz' 24;
        vertical-align: middle;
    }

    /* ══════════════════════════════════════
       SIDEBAR
    ══════════════════════════════════════ */
    .amo-sidebar {
        position: fixed; left: 0; top: 0; height: 100%; width: 256px;
        background: var(--surface-container-lowest);
        box-shadow: 4px 0 20px rgba(0,0,0,0.05);
        display: flex; flex-direction: column; z-index: 50;
    }
    .amo-sidebar-logo { padding: 32px 24px 16px; }
    .amo-sidebar-logo h1 {
        font-family: 'Playfair Display', serif;
        font-size: 24px; font-weight: 700;
        color: var(--primary); line-height: 1.2;
    }
    .amo-sidebar-logo p {
        font-size: 12px; color: var(--on-surface-variant);
        letter-spacing: 0.05em; margin-top: 2px;
    }
    .amo-nav-link {
        display: flex; align-items: center; gap: 12px;
        padding: 12px 16px; border-radius: 12px;
        font-size: 14px; font-weight: 600; letter-spacing: 0.05em;
        color: var(--on-surface-variant);
        transition: background 0.2s, color 0.2s;
        text-decoration: none; margin: 2px 8px;
    }
    .amo-nav-link:hover  { background: var(--surface-container-low); color: var(--on-surface); }
    .amo-nav-link.active {
        background: var(--surface-container-low);
        color: var(--primary); font-weight: 700;
        border-right: 3px solid var(--primary);
    }
    .amo-sidebar-footer {
        margin-top: auto; padding: 16px 24px;
        border-top: 1px solid rgba(123,85,81,0.1);
        display: flex; align-items: center; gap: 12px;
    }
    .amo-avatar {
        width: 40px; height: 40px; border-radius: 50%;
        background: var(--secondary-container);
        display: flex; align-items: center; justify-content: center;
        overflow: hidden; flex-shrink: 0;
    }

    /* ══════════════════════════════════════
       HEADER
    ══════════════════════════════════════ */
    .amo-header {
        position: sticky; top: 0; z-index: 40;
        background: rgba(252,249,248,0.85); backdrop-filter: blur(12px);
        border-bottom: 1px solid rgba(123,85,81,0.1);
        padding: 12px 32px;
        display: flex; justify-content: space-between; align-items: center;
    }
    .amo-search-wrap { position: relative; }
    .amo-search-wrap .icon {
        position: absolute; left: 12px; top: 50%; transform: translateY(-50%);
        color: var(--on-surface-variant); font-size: 20px;
    }
    .amo-search {
        padding: 8px 16px 8px 40px;
        background: var(--surface-container-low);
        border: none; border-radius: 9999px;
        font-size: 14px; width: 100%;
        outline: none; color: var(--on-surface);
    }
    .amo-search:focus { box-shadow: 0 0 0 2px var(--primary); }
    .amo-icon-btn {
        padding: 8px; border-radius: 8px;
        border: 1px solid rgba(123,85,81,0.2);
        background: transparent; color: var(--on-surface-variant);
        cursor: pointer; transition: background 0.2s;
        display: flex; align-items: center;
    }
    .amo-icon-btn:hover { background: var(--surface-container-low); }

    /* ══════════════════════════════════════
       MAIN / LAYOUT
    ══════════════════════════════════════ */
    .amo-main { padding: 32px; min-height: 100vh; }

    /* ══════════════════════════════════════
       BREADCRUMB
    ══════════════════════════════════════ */
    .amo-breadcrumb {
        display: flex; align-items: center; gap: 6px;
        font-size: 12px; color: var(--on-surface-variant); margin-bottom: 8px;
    }
    .amo-breadcrumb a { color: var(--on-surface-variant); text-decoration: none; }
    .amo-breadcrumb a:hover { color: var(--primary); }
    .amo-breadcrumb .current { color: var(--primary); font-weight: 600; }

    /* ══════════════════════════════════════
       SECTION CARD
    ══════════════════════════════════════ */
    .amo-card {
        background: var(--surface-container-lowest);
        border-radius: 12px;
        box-shadow: 0 4px 20px rgba(0,0,0,0.04);
        overflow: hidden; margin-bottom: 20px;
    }
    .amo-card-header {
        display: flex; align-items: center; gap: 8px;
        padding: 20px 28px; border-bottom: 1px solid rgba(123,85,81,0.08);
    }
    .amo-card-header h3 {
        font-family: 'Playfair Display', serif;
        font-size: 20px; font-weight: 600; color: var(--secondary);
    }
    .amo-card-body { padding: 24px 28px; }

    /* ══════════════════════════════════════
       FORM FIELDS
    ══════════════════════════════════════ */
    .amo-label {
        display: block; font-size: 13px; font-weight: 600;
        letter-spacing: 0.04em; color: var(--on-surface-variant); margin-bottom: 6px;
    }
    .amo-input, .amo-select {
        width: 100%; padding: 12px 14px;
        background: var(--surface);
        border: 1px solid rgba(225,191,180,0.5);
        border-radius: 8px; font-size: 15px; color: var(--on-surface);
        outline: none; transition: border-color 0.2s, box-shadow 0.2s;
        font-family: 'Inter', sans-serif;
    }
    .amo-input:focus, .amo-select:focus {
        border-color: var(--primary);
        box-shadow: 0 0 0 3px rgba(151,49,0,0.1);
    }
    .amo-input.error { border-color: var(--error); }
    .amo-input-prefix { position: relative; }
    .amo-input-prefix .prefix {
        position: absolute; left: 14px; top: 50%; transform: translateY(-50%);
        color: var(--on-surface-variant); font-size: 15px; pointer-events: none;
    }
    .amo-input-prefix .amo-input { padding-left: 28px; }
    .amo-error-msg { font-size: 12px; color: var(--error); margin-top: 4px; }

    /* ══════════════════════════════════════
       GRID HELPERS
    ══════════════════════════════════════ */
    .amo-grid-2 { display: grid; grid-template-columns: 1fr 1fr; gap: 20px; }
    .amo-grid-3 { display: grid; grid-template-columns: 1fr 1fr 1fr; gap: 20px; }
    .amo-col-span-2 { grid-column: span 2; }
    @media(max-width: 640px) {
        .amo-grid-2, .amo-grid-3 { grid-template-columns: 1fr; }
        .amo-col-span-2 { grid-column: span 1; }
    }

    /* ══════════════════════════════════════
       IMAGE DROP ZONE
    ══════════════════════════════════════ */
    .amo-drop-zone {
        position: relative; min-height: 180px; border-radius: 12px;
        border: 2px dashed rgba(225,191,180,0.7);
        background: var(--surface); cursor: pointer;
        display: flex; flex-direction: column; align-items: center; justify-content: center;
        gap: 10px; text-align: center; padding: 24px;
        transition: border-color 0.2s, background 0.2s;
        overflow: hidden;
    }
    .amo-drop-zone:hover { border-color: var(--primary); background: rgba(151,49,0,0.03); }
    .amo-drop-zone input { position: absolute; inset: 0; opacity: 0; cursor: pointer; }
    .amo-drop-zone .drop-icon { font-size: 40px; color: var(--outline-variant); transition: color 0.2s; }
    .amo-drop-zone:hover .drop-icon { color: var(--primary); }
    #preview-img { max-height: 160px; border-radius: 8px; object-fit: contain; }

    /* ══════════════════════════════════════
       TOGGLE / SWITCH
    ══════════════════════════════════════ */
    .amo-toggle-wrap {
        display: flex; justify-content: space-between; align-items: center;
        padding: 14px 16px; background: var(--surface); border-radius: 8px;
        border: 1px solid rgba(225,191,180,0.4);
    }
    .amo-toggle-label { font-size: 14px; font-weight: 600; color: var(--on-surface); }
    .amo-toggle-sub   { font-size: 12px; color: var(--on-surface-variant); margin-top: 2px; }
    .amo-switch { position: relative; display: inline-flex; align-items: center; cursor: pointer; }
    .amo-switch input { opacity: 0; width: 0; height: 0; position: absolute; }
    .amo-switch-track {
        width: 44px; height: 24px; background: var(--surface-container-highest);
        border-radius: 9999px; position: relative; transition: background 0.2s;
    }
    .amo-switch input:checked + .amo-switch-track { background: var(--primary); }
    .amo-switch-track::after {
        content: ''; position: absolute; top: 2px; left: 2px;
        width: 20px; height: 20px; border-radius: 50%;
        background: white; box-shadow: 0 1px 4px rgba(0,0,0,0.2);
        transition: transform 0.2s;
    }
    .amo-switch input:checked + .amo-switch-track::after { transform: translateX(20px); }

    /* ══════════════════════════════════════
       BUTTONS
    ══════════════════════════════════════ */
    .amo-btn-primary {
        display: inline-flex; align-items: center; justify-content: center; gap: 8px;
        background: var(--primary); color: var(--on-primary);
        padding: 10px 20px; border-radius: 12px;
        font-size: 14px; font-weight: 600; letter-spacing: 0.05em;
        border: none; cursor: pointer; text-decoration: none;
        box-shadow: 0 4px 12px rgba(151,49,0,0.25);
        transition: opacity 0.2s, transform 0.1s;
    }
    .amo-btn-primary:hover  { opacity: 0.9; }
    .amo-btn-primary:active { transform: scale(0.97); }

    /* Variante ancho completo para formularios */
    .amo-btn-primary.full-width {
        width: 100%; padding: 14px;
        box-shadow: 0 4px 14px rgba(151,49,0,0.3);
    }

    .amo-btn-ghost {
        display: block; width: 100%; text-align: center;
        padding: 14px; border-radius: 10px;
        font-size: 14px; font-weight: 600; letter-spacing: 0.05em;
        color: var(--secondary);
        background: transparent;
        border: 1px solid rgba(123,85,81,0.3);
        cursor: pointer; text-decoration: none;
        transition: background 0.2s;
    }
    .amo-btn-ghost:hover { background: var(--surface-container-low); }

    .amo-btn-edit, .amo-btn-del {
        padding: 6px 12px; border-radius: 8px;
        font-size: 12px; font-weight: 600;
        border: 1px solid; cursor: pointer; transition: background 0.2s;
        text-decoration: none; display: inline-flex; align-items: center;
    }
    .amo-btn-edit {
        border-color: var(--outline-variant);
        background: var(--surface-container-lowest);
        color: var(--on-surface);
    }
    .amo-btn-edit:hover { background: var(--surface-container-low); }
    .amo-btn-del { border-color: #fecdd3; background: var(--surface-container-lowest); color: var(--error); }
    .amo-btn-del:hover { background: #fef2f2; }

    /* ══════════════════════════════════════
       BANNERS / FLASH
    ══════════════════════════════════════ */
    .amo-error-banner {
        background: #fef2f2; border: 1px solid #fecdd3;
        border-radius: 10px; padding: 14px 18px;
        font-size: 14px; color: var(--error); margin-bottom: 20px;
    }
    .amo-error-banner ul { margin: 0; padding-left: 20px; }

    .amo-flash-ok {
        background: #ecfdf5; color: #065f46;
        border: 1px solid #a7f3d0;
        border-radius: 10px; padding: 12px 16px;
        font-size: 14px; margin-bottom: 20px;
    }

    /* ══════════════════════════════════════
       METRIC CARDS (index)
    ══════════════════════════════════════ */
    .amo-metric-card {
        background: var(--surface-container-lowest);
        border-radius: 12px;
        box-shadow: 0 4px 20px rgba(0,0,0,0.04);
        padding: 24px;
        display: flex; flex-direction: column; gap: 8px;
    }
    .amo-metric-label { font-size: 11px; font-weight: 600; letter-spacing: 0.08em; text-transform: uppercase; color: var(--secondary); }
    .amo-metric-value { font-family: 'Playfair Display', serif; font-size: 40px; font-weight: 700; color: var(--on-surface); line-height: 1; }
    .amo-metric-value.primary { color: var(--primary); }
    .amo-metric-sub { font-size: 12px; display: flex; align-items: center; gap: 4px; }

    /* ══════════════════════════════════════
       TABLE (index)
    ══════════════════════════════════════ */
    .amo-table-card {
        background: var(--surface-container-lowest);
        border-radius: 12px;
        box-shadow: 0 4px 20px rgba(0,0,0,0.04);
        overflow: hidden;
    }
    .amo-table-toolbar {
        padding: 16px 24px;
        border-bottom: 1px solid rgba(123,85,81,0.1);
        background: rgba(252,249,248,0.5);
        display: flex; justify-content: space-between; align-items: center; flex-wrap: wrap; gap: 12px;
    }
    .amo-tab-btn {
        font-size: 14px; font-weight: 600; letter-spacing: 0.05em;
        color: var(--on-surface-variant);
        background: none; border: none; cursor: pointer;
        padding-bottom: 4px; transition: color 0.2s;
    }
    .amo-tab-btn.active { color: var(--primary); border-bottom: 2px solid var(--primary); }
    .amo-tab-btn:hover  { color: var(--primary); }

    table { border-collapse: collapse; width: 100%; }
    thead { background: var(--surface-container-low); }
    thead th {
        padding: 14px 20px;
        font-size: 11px; font-weight: 600; letter-spacing: 0.08em;
        text-transform: uppercase; color: var(--on-surface-variant);
        text-align: left;
    }
    tbody tr { border-top: 1px solid rgba(151,49,0,0.06); transition: background 0.15s; }
    tbody tr:hover { background: rgba(246,243,242,0.6); }
    tbody td { padding: 14px 20px; font-size: 14px; }

    /* ══════════════════════════════════════
       BADGES
    ══════════════════════════════════════ */
    .amo-badge {
        display: inline-flex; align-items: center;
        padding: 2px 10px; border-radius: 9999px;
        font-size: 11px; font-weight: 600;
    }
    .amo-badge-classic  { background: var(--tertiary-fixed);      color: var(--on-tertiary-fixed); }
    .amo-badge-season   { background: var(--secondary-container); color: var(--on-secondary-container); }
    .amo-badge-gluten   { background: #d4edda; color: #155724; }
    .amo-badge-event    { background: var(--primary-fixed); color: var(--primary); }

    .amo-status-badge {
        display: inline-flex; align-items: center; gap: 5px;
        padding: 3px 10px; border-radius: 9999px;
        font-size: 11px; font-weight: 600;
    }
    .amo-status-dot { width: 6px; height: 6px; border-radius: 50%; flex-shrink: 0; }
    .amo-status-on  { background: #ecfdf5; color: #065f46; }
    .amo-status-on  .amo-status-dot { background: #10b981; }
    .amo-status-off { background: #fef2f2; color: #991b1b; }
    .amo-status-off .amo-status-dot { background: #ef4444; }

    /* ══════════════════════════════════════
       STOCK BAR (index)
    ══════════════════════════════════════ */
    .amo-stock-bar { display: flex; align-items: center; gap: 8px; }
    .amo-bar-track { width: 56px; height: 4px; background: var(--surface-container); border-radius: 9999px; overflow: hidden; }
    .amo-bar-fill  { height: 100%; background: var(--primary); border-radius: 9999px; }

    /* ══════════════════════════════════════
       PAGINATION (index)
    ══════════════════════════════════════ */
    .amo-pagination {
        padding: 12px 24px;
        border-top: 1px solid rgba(123,85,81,0.1);
        display: flex; justify-content: space-between; align-items: center;
        background: rgba(252,249,248,0.3);
    }
    .amo-page-btn {
        width: 32px; height: 32px; border-radius: 8px;
        border: 1px solid rgba(123,85,81,0.2);
        background: transparent; color: var(--on-surface-variant);
        cursor: pointer; font-size: 13px; font-weight: 500;
        display: flex; align-items: center; justify-content: center;
        transition: background 0.2s;
    }
    .amo-page-btn:hover  { background: var(--surface-container-low); }
    .amo-page-btn.active { background: var(--primary); color: #fff; border-color: var(--primary); }
    .amo-page-nav {
        padding: 6px 12px; border-radius: 8px;
        border: 1px solid rgba(123,85,81,0.2);
        background: transparent; font-size: 13px; cursor: pointer;
        color: var(--on-surface-variant); transition: background 0.2s;
    }
    .amo-page-nav:disabled { opacity: 0.35; cursor: not-allowed; }
    .amo-page-nav:not(:disabled):hover { background: var(--surface-container-low); }

    /* ══════════════════════════════════════
       SEARCH / FILTER INPUTS (index)
    ══════════════════════════════════════ */
    .amo-filter-input, .amo-filter-select {
        padding: 8px 14px;
        border: 1px solid var(--outline-variant);
        border-radius: 8px; font-size: 14px;
        background: var(--surface-container-lowest);
        color: var(--on-surface);
        outline: none; transition: border 0.2s;
    }
    .amo-filter-input:focus,
    .amo-filter-select:focus {
        border-color: var(--primary);
        box-shadow: 0 0 0 2px rgba(151,49,0,0.12);
    }

    /* ══════════════════════════════════════
       STYLE-GUIDE TIP (nuevo/editar)
    ══════════════════════════════════════ */
    .amo-tip { display: flex; gap: 14px; align-items: flex-start; }
    .amo-tip-icon {
        width: 44px; height: 44px; border-radius: 50%; flex-shrink: 0;
        display: flex; align-items: center; justify-content: center;
    }
    .amo-tip-icon.primary-fixed       { background: var(--primary-fixed); }
    .amo-tip-icon.secondary-container { background: var(--secondary-container); }
</style>