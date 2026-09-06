<!-- top navigation -->
<?
 if ($vPriv=='sponsor')
     $vJenis = 'sponsor';
 else if ($vPriv=='korwil')
     $vJenis = 'korwil';
 else $vJenis='';

 if ($vJenis=='korwil') {
     $vsql="select a.fidbisnis from m_korwil a where a.fidkorwil='$vUser' ";
     $db->query($vsql);
     $db->next_record();
     $vIDSal = $db->f('fidbisnis');
 } else {
     $vIDSal = $vUser;
 }

 if ($_SESSION['Priv']=='seller')
     $vSaldo = $oMember->getMemFieldSell('fsaldovcr',$vUser);
 else
     $vSaldo = $oMember->getSaldoAdm($vUser,$vJenis);

 $vPendingWD = $oJual->getPendingWD($vUser,$vJenis);
 $vPendingTrans = $oJual->getPendingTrans($vUser,$vJenis);
 $vPendingTrx = $oJual->getPendingTrx($vUser,$vJenis);
 $vEndap = $oRules->getSettingByField('fmindap');
?>
<div class="amh-topbar amh-glass-panel" style="margin:1rem 1rem 0;border-radius:1rem;">
  <button class="amh-sidebar-toggle" id="amhSidebarToggle" type="button"><i class="fa fa-bars"></i></button>

  <? if($vMarkDev !='') { ?>
    <span style="font-weight:bold;color:#f00"><?=$vMarkDev?></span>
  <? } ?>

  <div style="flex:1"></div>

  <button class="amh-topbar-bell" type="button" title="Notifikasi">
    <i class="fa fa-bell-o" style="color:#fbbf24"></i>
    <span class="amh-dot"></span>
  </button>

  <div class="amh-topbar-user">
    <button type="button" id="amhUserMenuToggle">
      <span class="fa fa-user-circle" style="font-size:1.6em;color:#fbbf24"></span>
      <span><?=$_SESSION['LoginUser']?></span>
      <span class="fa fa-angle-down"></span>
    </button>
    <div class="amh-topbar-dropdown amh-glass-panel" id="amhUserMenuDropdown">
      <? if ($_SESSION['Priv'] != 'administrator') { ?>
      <div style="white-space:nowrap;">
        Saldo<br>
        <span style="color:#38bdf8;">
          [ID: <?=$vIDSal?>] : <?=number_format($vSaldo,0,",",".")?>
          <? if (($vSaldo - $vEndap) > 0) { ?>
            (Aktif: <?=number_format($vSaldo - $vEndap,0,",",".")?>)
          <? } else { ?>
            (Aktif: <?=number_format(0,0,",",".")?>)
          <? } ?>
        </span>
      </div>
      <? } ?>
      <input type="hidden" id="hSaldoG" name="hSaldoG" value="<?=(int) ($vSaldo - $vEndap)?>" />
      <a href="../main/logout.php"><i class="fa fa-sign-out"></i> Log Out</a>
    </div>
  </div>
</div>

<script>
(function() {
  var sidebar = document.getElementById('amhSidebar');
  var backdrop = document.getElementById('amhSidebarBackdrop');
  var toggle = document.getElementById('amhSidebarToggle');
  function closeSidebar() { sidebar.classList.remove('amh-open'); backdrop.classList.remove('amh-open'); }
  function openSidebar() { sidebar.classList.add('amh-open'); backdrop.classList.add('amh-open'); }
  if (toggle) toggle.addEventListener('click', function() {
    sidebar.classList.contains('amh-open') ? closeSidebar() : openSidebar();
  });
  if (backdrop) backdrop.addEventListener('click', closeSidebar);

  var userToggle = document.getElementById('amhUserMenuToggle');
  var userDropdown = document.getElementById('amhUserMenuDropdown');
  if (userToggle) userToggle.addEventListener('click', function(e) {
    e.stopPropagation();
    userDropdown.classList.toggle('amh-open');
  });
  document.addEventListener('click', function() { userDropdown.classList.remove('amh-open'); });

  // Notification bell: Lobibox toasts (css/lobibox.css, vendor) used to pop
  // up and stay stacked on screen the moment the page's inline <script>
  // blocks ran Lobibox.notify(...). Now the stack starts hidden; the bell
  // toggles it open/closed, and a "Tutup Semua" button (injected as the
  // wrapper's first child) just closes the panel again -- it must NOT
  // delete the toast elements, so the same notifications are still there
  // to review next time the bell is clicked. Lobibox creates its wrapper
  // element lazily on the first notify() call, and inline scripts further
  // down the page can add more after that -- watch for DOM changes instead
  // of guessing a fixed delay.
  var bell = document.querySelector('.amh-topbar-bell');
  if (bell) {
    // Open the panel automatically the moment the user lands here fresh
    // from the login form (same "referrer was login.php" signal the
    // dashboard pages already use for the Tata Cara modal) -- every other
    // page load while browsing the admin panel keeps it hidden until the
    // bell is clicked, same as before.
    var notifPanelOpen = /login\.php/i.test(document.referrer);

    // Lobibox plays its own sound on every individual notify() call --
    // with a few dozen pending-item notifications firing on page load,
    // that was a burst of overlapping chimes. Disable Lobibox's own
    // per-toast sound and play a single, softer one instead, once per
    // page load. DEFAULTS is merged in ahead of each call's own options
    // (js/lobibox.js), so this covers every Lobibox.notify() call across
    // every legacy page without editing any of them individually.
    if (window.Lobibox && Lobibox.notify) {
      Lobibox.notify.DEFAULTS = Lobibox.notify.DEFAULTS || {};
      Lobibox.notify.DEFAULTS.sound = false;
    }
    var notifSoundPlayed = false;
    var playNotifSoundOnce = function(count) {
      // Only right after login (notifPanelOpen already carries that same
      // referrer check) -- otherwise every other page load would also
      // trigger a "new" mutation once notifications are restored from
      // sessionStorage there too, playing the sound on every navigation
      // instead of just once after signing in.
      if (!notifPanelOpen || notifSoundPlayed || count === 0) return;
      notifSoundPlayed = true;
      try {
        var snd = new Audio('/sounds/sound2.ogg');
        snd.volume = 0.5;
        snd.play().catch(function() {});
      } catch (e) {}
    };

    var getNotifWrapper = function() { return document.querySelector('.lobibox-notify-wrapper'); };

    // Lobibox.notify() calls are only baked into indexadmin.php's/
    // indexnonadmin.php's own trailing <script>, so any other page never
    // gets a .lobibox-notify-wrapper at all -- the bell had nothing to
    // open outside the dashboard. Persist the dashboard's notification
    // HTML across page loads (sessionStorage survives navigation within
    // the tab, not just this one page) and, on a page with no wrapper of
    // its own, rebuild a synthetic one from that saved copy so the bell
    // still opens the same notifications everywhere.
    var NOTIF_STORAGE_KEY = 'amhNotifHistory';
    var saveNotifHistory = function(w) {
      if (!w.querySelectorAll('.lobibox-notify').length) return;
      try { sessionStorage.setItem(NOTIF_STORAGE_KEY, w.innerHTML); } catch (e) {}
    };
    var restoreNotifHistoryIfNeeded = function() {
      if (getNotifWrapper()) return; // this page made its own -- nothing to restore
      var saved;
      try { saved = sessionStorage.getItem(NOTIF_STORAGE_KEY); } catch (e) { saved = null; }
      if (!saved) return;
      var w = document.createElement('div');
      w.className = 'lobibox-notify-wrapper';
      w.innerHTML = saved;
      document.body.appendChild(w);
    };

    var updateNotifDot = function() {
      var w = getNotifWrapper();
      var count = w ? w.querySelectorAll('.lobibox-notify').length : 0;
      var dot = bell.querySelector('.amh-dot');
      if (dot) dot.style.display = count > 0 ? 'block' : 'none';
    };

    var applyNotifPanelVisibility = function() {
      var w = getNotifWrapper();
      if (w) w.style.display = notifPanelOpen ? '' : 'none';
    };

    var ensureCloseAllButton = function(w) {
      if (w.querySelector('.amh-notif-closeall')) return;
      var btn = document.createElement('button');
      btn.type = 'button';
      btn.className = 'amh-notif-closeall';
      btn.textContent = 'Tutup Semua';
      btn.addEventListener('click', function(e) {
        e.stopPropagation();
        notifPanelOpen = false;
        applyNotifPanelVisibility();
      });
      w.insertBefore(btn, w.firstChild);
    };

    var notifObserver = new MutationObserver(function() {
      var w = getNotifWrapper();
      if (!w) return;
      ensureCloseAllButton(w);
      applyNotifPanelVisibility();
      updateNotifDot();
      playNotifSoundOnce(w.querySelectorAll('.lobibox-notify').length);
      saveNotifHistory(w);
    });
    notifObserver.observe(document.body, { childList: true, subtree: true });

    // Give this page's own Lobibox.notify() calls (if any -- only the
    // dashboard has them) a chance to run first, since they fire in a
    // <script> further down the page than this one. Only once nothing
    // showed up do we fall back to the saved history.
    var tryRestore = function() { restoreNotifHistoryIfNeeded(); };
    if (document.readyState === 'complete') {
      tryRestore();
    } else {
      window.addEventListener('load', tryRestore);
    }

    bell.addEventListener('click', function(e) {
      e.stopPropagation();
      notifPanelOpen = !notifPanelOpen;
      applyNotifPanelVisibility();
    });
    document.addEventListener('click', function(e) {
      var w = getNotifWrapper();
      if (notifPanelOpen && w && !w.contains(e.target) && !bell.contains(e.target)) {
        notifPanelOpen = false;
        applyNotifPanelVisibility();
      }
    });
  }

  // sidebar submenu expand/collapse (parent items render as href="javascript:;")
  document.querySelectorAll('.amh-sidebar-nav > ul > li > a[href="javascript:;"]').forEach(function(a) {
    a.addEventListener('click', function(e) {
      e.preventDefault();
      var sub = a.parentNode.querySelector('.amh-submenu');
      if (sub) {
        sub.style.display = (sub.style.display === 'block') ? 'none' : 'block';
      }
    });
  });

  // draggable sidebar width (desktop only — the resizer itself is hidden on
  // mobile via CSS, this just guards against a stray touch/mouse event)
  var resizer = document.getElementById('amhSidebarResizer');
  if (resizer) {
    var resizing = false;
    var MIN_WIDTH = 180, MAX_WIDTH = 420;

    try {
      var saved = localStorage.getItem('amhSidebarWidth');
      if (saved) document.documentElement.style.setProperty('--amh-sidebar-width', saved);
    } catch (e) {}

    resizer.addEventListener('mousedown', function(e) {
      resizing = true;
      resizer.classList.add('amh-dragging');
      document.body.style.userSelect = 'none';
      e.preventDefault();
    });
    document.addEventListener('mousemove', function(e) {
      if (!resizing) return;
      var w = Math.min(MAX_WIDTH, Math.max(MIN_WIDTH, e.clientX));
      document.documentElement.style.setProperty('--amh-sidebar-width', w + 'px');
    });
    document.addEventListener('mouseup', function() {
      if (!resizing) return;
      resizing = false;
      resizer.classList.remove('amh-dragging');
      document.body.style.userSelect = '';
      try {
        localStorage.setItem('amhSidebarWidth', getComputedStyle(document.documentElement).getPropertyValue('--amh-sidebar-width').trim());
      } catch (e) {}
    });
  }

  // Full-bleed scrollable tables on mobile: .right_col's own padding isn't
  // one fixed value across every page (some pages set it inline), so it
  // can't be reliably cancelled out from a stylesheet alone -- measure it
  // for real and apply the exact negative margin needed.
  function fullBleedTables() {
    if (window.innerWidth > 991) {
      document.querySelectorAll('.right_col .table-responsive').forEach(function(el) {
        el.style.marginLeft = '';
        el.style.marginRight = '';
        el.style.width = '';
      });
      return;
    }
    var rightCol = document.querySelector('.right_col');
    if (!rightCol) return;
    var cs = getComputedStyle(rightCol);
    var padLeft = parseFloat(cs.paddingLeft) || 0;
    var padRight = parseFloat(cs.paddingRight) || 0;
    document.querySelectorAll('.right_col .table-responsive').forEach(function(el) {
      // phpMyEdit nests one .table-responsive inside another (form wrapper,
      // then table wrapper) -- only the outermost should get pulled to the
      // edge; an inner one's "100%" is already relative to the outer one's
      // now-widened box, so adjusting both compounds the offset.
      if (el.parentElement.closest('.table-responsive')) return;
      el.style.marginLeft = (-padLeft) + 'px';
      el.style.marginRight = (-padRight) + 'px';
      el.style.width = 'calc(100% + ' + (padLeft + padRight) + 'px)';
    });
  }
  // This script tag (in admin_topnav.blade.php) is included near the top of
  // the page, before the page-specific .table-responsive content below it
  // exists in the DOM -- calling fullBleedTables() immediately finds
  // nothing. Re-run once the rest of the page has actually loaded.
  fullBleedTables();
  if (document.readyState === 'complete') {
    fullBleedTables();
  } else {
    window.addEventListener('load', fullBleedTables);
  }
  window.addEventListener('resize', fullBleedTables);

  // Card view for phpMyEdit list tables on mobile: a wide multi-column
  // table can't fit a phone screen by trimming padding alone. Restructure
  // each data row into a card -- first few columns always visible, the
  // rest behind a "+ Detail" toggle labeled from the table's own header
  // text. Runs once per table (marked via data-cardified) and only
  // activates the CSS class at <=767px; it never removes/hides real data,
  // just re-classes existing cells.
  var CARD_PRIMARY_COUNT = 3; // how many data columns (after the nav/radio cell) stay always-visible
  function cardifyListTables() {
    document.querySelectorAll('.right_col table.pme-main').forEach(function(table) {
      if (!table.dataset.cardified) {
        var headerRow = table.querySelector('tr.pme-header');
        var dataRows = table.querySelectorAll('tr[class^="pme-row-"]');
        if (!headerRow || !dataRows.length) return; // not a list-view table (e.g. this is an add/change form) -- skip
        var headers = Array.from(headerRow.children).map(function(th) {
          var a = th.querySelector('a');
          return (a ? a.textContent : th.textContent).trim();
        });
        dataRows.forEach(function(row) {
          Array.from(row.children).forEach(function(cell, i) {
            if (i === 0) return; // radio/nav select cell -- leave alone
            // every field gets its column header as a label now, not just
            // the ones behind "+ Detail" -- a bare "PUSM" or "3000000"
            // with no indication of which column it came from wasn't
            // actually readable, only visually tidy.
            cell.setAttribute('data-label', headers[i] || '');
            if (i <= CARD_PRIMARY_COUNT) {
              cell.classList.add('amh-card-primary');
            } else {
              cell.classList.add('amh-card-secondary');
            }
          });
          if (!row.querySelector('.amh-card-toggle')) {
            var toggleTd = document.createElement('td');
            toggleTd.className = 'amh-card-toggle-cell';
            var btn = document.createElement('button');
            btn.type = 'button';
            btn.className = 'amh-card-toggle';
            btn.textContent = '+ Detail';
            btn.addEventListener('click', function() {
              row.classList.toggle('amh-card-expanded');
              btn.textContent = row.classList.contains('amh-card-expanded') ? '− Tutup' : '+ Detail';
            });
            toggleTd.appendChild(btn);
            row.appendChild(toggleTd);
          }
        });
        table.dataset.cardified = 'true';
      }
      table.classList.toggle('amh-card-table', window.innerWidth <= 767);
    });
  }
  cardifyListTables();
  if (document.readyState === 'complete') {
    cardifyListTables();
  } else {
    window.addEventListener('load', cardifyListTables);
  }
  window.addEventListener('resize', cardifyListTables);
})();
</script>
<!-- /top navigation -->
