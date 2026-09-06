<?php
// This block MUST run before any HTML output (admin_headside.blade.php
// included below prints the page head immediately) -- a header("Location:
// ...") redirect after that would fail with "headers already sent" and
// silently break the delete action, which is exactly what happened during
// live testing. Handle the delete + redirect first, then render normally.
include_once "../server/config.php";

$roleMap = array(
    'mdm_aitrain_visitor'  => array('visitor',  'Dokumen untuk Visitor'),
    'mdm_aitrain_jamaah'   => array('jamaah',   'Dokumen untuk Jamaah'),
    'mdm_aitrain_pebisnis' => array('pebisnis', 'Dokumen untuk Pebisnis'),
    'mdm_aitrain_seller'   => array('seller',   'Dokumen Untuk Seller'),
    'mdm_aitrain_korwil'   => array('korwil',   'Dokumen untuk Korwil'),
    'mdm_aitrain_admin'    => array('admin',    'Dokumen untuk Admin / Karyawan'),
);
$menuParam = isset($_GET['menu']) ? $_GET['menu'] : '';
if (!isset($roleMap[$menuParam])) {
    $menuParam = 'mdm_aitrain_visitor';
}
$currentRole = $roleMap[$menuParam][0];
$pageTitle = $roleMap[$menuParam][1];

if (isset($_GET['delete_id'])) {
    $delId = intval($_GET['delete_id']);
    $db->query("select filepath from m_ai_document where id=$delId and role='" . mysql_real_escape_string($currentRole) . "'");
    if ($db->next_record()) {
        $fp = $db->f('filepath');
        if ($fp && file_exists($fp)) {
            unlink($fp);
        }
        $db->query("delete from m_ai_document where id=$delId"); // chunk rows cascade via FK
    }
    header("Location: aitraindocs.php?op=&current=mdm_admin&menu=" . urlencode($menuParam));
    exit;
}
// No blank line/whitespace before this closing tag and the next opening
// tag below -- even a single stray newline between them is literal output
// sent to the browser, which broke admin_headside.blade.php's own internal
// header() call the same way it broke this file's delete redirect earlier
// (confirmed live: "headers already sent... output started at
// aitraindocs.php:39" pointed exactly at the include line that used to have
// a blank line above it).
?><? include_once("../framework/admin_headside.blade.php")?><? include_once("../framework/admin_sidebar.blade.php")?>

<div class="right_col" role="main">
  <div class="row">
    <div><label><h3><?=htmlspecialchars($pageTitle)?></h3></label></div>
  </div>

  <div class="col-lg-12">
    <form id="aiUploadForm" enctype="multipart/form-data">
      <input type="hidden" name="role" value="<?=htmlspecialchars($currentRole)?>">
      <div class="row">
        <div class="col-lg-4">
          <input type="file" name="docfile" id="aiDocFile" class="form-control" accept=".docx" required>
        </div>
        <div class="col-lg-2">
          <button type="submit" class="btn btn-success" id="aiUploadBtn">Upload</button>
        </div>
      </div>
      <div style="margin-top:0.4em;font-size:0.85em;opacity:0.8">Format: Word (.docx). Maksimum 2MB per file. (Dukungan PDF menyusul.)</div>
    </form>
    <div id="aiUploadStatus" style="margin-top:0.5em"></div>
  </div>

  <!-- .col-lg-12 above floats left (Bootstrap grid); without an explicit
       clear, this div collapses to 0 width beside it on wide viewports --
       invisible on desktop, only "worked" on narrow/mobile widths where
       everything stacks anyway. Confirmed via computed-style inspection
       during live testing (getBoundingClientRect width was literally 0). -->
  <div class="table-responsive" style="margin-top:1.5em; clear:both;">
    <table class="table table-striped">
      <tr>
        <td><strong>Nama File</strong></td>
        <td><strong>Tanggal Upload</strong></td>
        <td><strong>Status</strong></td>
        <td><strong>Aksi</strong></td>
      </tr>
      <?
      $roleEsc = mysql_real_escape_string($currentRole);
      $db->query("select * from m_ai_document where role='$roleEsc' order by uploaded_at desc");
      while ($db->next_record()) {
          $id = $db->f('id');
          $fname = htmlspecialchars($db->f('filename'));
          $uploadedAt = htmlspecialchars($db->f('uploaded_at'));
          $status = $db->f('status');
          $errMsg = htmlspecialchars($db->f('error_message'));
      ?>
      <tr>
        <td><?=$fname?></td>
        <td><?=$uploadedAt?></td>
        <td>
          <?=htmlspecialchars($status)?>
          <? if ($status === 'error' && $errMsg) { ?>
            <div style="color:#f87171;font-size:0.85em"><?=$errMsg?></div>
          <? } ?>
        </td>
        <td>
          <a href="#" class="btn btn-default btn-xs aiViewLink" data-id="<?=$id?>" data-filename="<?=$fname?>">Lihat</a>
          <a href="aitraindocs.php?op=&current=mdm_admin&menu=<?=urlencode($menuParam)?>&delete_id=<?=$id?>"
             class="btn btn-danger btn-xs aiDeleteLink" data-filename="<?=$fname?>">Hapus</a>
        </td>
      </tr>
      <? } ?>
    </table>
  </div>
</div>

<!-- Themed confirm dialog, replacing the browser's native confirm() popup
     (which clashed visually with the site's dark/gold design) -->
<div id="aiConfirmOverlay" style="display:none; position:fixed; inset:0; background:rgba(8,13,26,0.7); z-index:1000; align-items:center; justify-content:center;">
  <div class="amh-glass-panel" style="max-width:360px; width:90%; padding:1.5rem; border-radius:0.75rem; text-align:center;">
    <div style="color:var(--amh-text); font-size:1rem; margin-bottom:1.25rem;">Hapus <strong id="aiConfirmFilename"></strong>?</div>
    <div style="display:flex; gap:0.75rem; justify-content:center;">
      <button type="button" id="aiConfirmCancel" class="amh-btn-outline" style="padding:0.5rem 1.25rem; border-radius:0.5rem; border:1px solid rgba(255,255,255,0.25); background:transparent; cursor:pointer;">Batal</button>
      <button type="button" id="aiConfirmOk" style="padding:0.5rem 1.25rem; border-radius:0.5rem; border:none; background:var(--amh-amber-gradient); color:#1e293b; font-weight:600; cursor:pointer;">Hapus</button>
    </div>
  </div>
</div>

<!-- "Lihat" modal -- renders the ORIGINAL uploaded .docx file (formatting
     included) client-side via mammoth.js, fetched as raw bytes from
     main/api_doc_raw.php. Wider than the delete-confirm dialog since a
     real document page needs more horizontal room; the rendered content
     gets a white background/dark text so Word-style formatting (bold,
     headings) reads naturally regardless of the page's own dark theme. -->
<div id="aiViewOverlay" style="display:none; position:fixed; inset:0; background:rgba(8,13,26,0.9); z-index:1000; align-items:center; justify-content:center; padding:1rem;">
  <div class="amh-glass-panel" style="width:100%; height:100%; padding:1.25rem; border-radius:0.75rem; display:flex; flex-direction:column;">
    <div style="display:flex; justify-content:space-between; align-items:flex-start; gap:1rem; margin-bottom:0.75rem;">
      <div>
        <div style="color:var(--amh-text); font-size:1.05rem; font-weight:600;" id="aiViewFilename"></div>
        <div style="color:var(--amh-text); opacity:0.7; font-size:0.85rem; margin-top:0.25rem;" id="aiViewMeta"></div>
      </div>
      <button type="button" id="aiViewClose" style="background:transparent; border:none; color:var(--amh-text); font-size:1.5rem; line-height:1; cursor:pointer; padding:0;">&times;</button>
    </div>
    <!-- max-width on img keeps a docx's full-resolution embedded images
         (this content is originally slide-deck-style, so images can be
         wider than any reasonable modal) scaled down to fit instead of
         forcing horizontal scroll to see the rest of a slide. -->
    <div id="aiViewBody" style="color:#1e293b; font-size:0.95rem; line-height:1.6; overflow-y:auto; background:#fff; border-radius:0.5rem; padding:1.5rem 2rem; flex-grow:1; max-width:900px; width:100%; margin:0 auto;">Memuat...</div>
  </div>
</div>
<style>
  #aiViewBody img { max-width: 100%; height: auto; }
</style>

<!-- Pure client-side .docx -> HTML converter, used only by the "Lihat"
     modal below -- this PHP 5.6 host has no library that could render
     .docx server-side. -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/mammoth/1.6.0/mammoth.browser.min.js"></script>
<script>
document.getElementById('aiUploadForm').addEventListener('submit', function(e) {
    e.preventDefault();
    var form = e.target;
    var statusDiv = document.getElementById('aiUploadStatus');
    var btn = document.getElementById('aiUploadBtn');
    var formData = new FormData(form);
    btn.disabled = true;
    statusDiv.textContent = 'Mengupload dan memproses dokumen...';
    fetch('../main/api_doc_upload.php', { method: 'POST', body: formData })
        .then(function(r) { return r.json(); })
        .then(function(data) {
            btn.disabled = false;
            if (data.status === 'success') {
                statusDiv.textContent = 'Berhasil: ' + data.chunks_stored + ' potongan tersimpan' + (data.chunks_failed > 0 ? ' (' + data.chunks_failed + ' gagal)' : '') + '.';
                setTimeout(function() { window.location.reload(); }, 1200);
            } else {
                statusDiv.textContent = 'Gagal: ' + data.message;
            }
        })
        .catch(function() {
            btn.disabled = false;
            statusDiv.textContent = 'Gagal: terjadi kesalahan koneksi.';
        });
});

// Themed delete confirmation (replaces native confirm())
(function() {
    var overlay = document.getElementById('aiConfirmOverlay');
    var filenameEl = document.getElementById('aiConfirmFilename');
    var okBtn = document.getElementById('aiConfirmOk');
    var cancelBtn = document.getElementById('aiConfirmCancel');
    var pendingHref = null;

    document.querySelectorAll('.aiDeleteLink').forEach(function(link) {
        link.addEventListener('click', function(e) {
            e.preventDefault();
            pendingHref = link.getAttribute('href');
            filenameEl.textContent = link.getAttribute('data-filename');
            overlay.style.display = 'flex';
        });
    });

    okBtn.addEventListener('click', function() {
        if (pendingHref) { window.location.href = pendingHref; }
    });
    cancelBtn.addEventListener('click', function() {
        overlay.style.display = 'none';
        pendingHref = null;
    });
    overlay.addEventListener('click', function(e) {
        if (e.target === overlay) {
            overlay.style.display = 'none';
            pendingHref = null;
        }
    });
})();

// "Lihat" modal -- fetches the ORIGINAL .docx file's raw bytes and renders
// it client-side with mammoth.js (converts .docx -> HTML in-browser, no
// server-side rendering needed -- this PHP 5.6 host has no library that
// could do that server-side anyway). A fresh fetch every click, so it
// always reflects the currently-uploaded file.
(function() {
    var overlay = document.getElementById('aiViewOverlay');
    var filenameEl = document.getElementById('aiViewFilename');
    var metaEl = document.getElementById('aiViewMeta');
    var bodyEl = document.getElementById('aiViewBody');
    var closeBtn = document.getElementById('aiViewClose');

    function closeModal() {
        overlay.style.display = 'none';
    }

    document.querySelectorAll('.aiViewLink').forEach(function(link) {
        link.addEventListener('click', function(e) {
            e.preventDefault();
            var id = link.getAttribute('data-id');
            filenameEl.textContent = link.getAttribute('data-filename');
            metaEl.textContent = '';
            bodyEl.textContent = 'Memuat...';
            overlay.style.display = 'flex';

            fetch('../main/api_doc_raw.php?id=' + encodeURIComponent(id))
                .then(function(r) {
                    if (!r.ok) { throw new Error('HTTP ' + r.status); }
                    return r.arrayBuffer();
                })
                .then(function(arrayBuffer) {
                    return mammoth.convertToHtml({ arrayBuffer: arrayBuffer });
                })
                .then(function(result) {
                    bodyEl.innerHTML = result.value || '<em>(Dokumen kosong)</em>';
                    if (result.messages && result.messages.length > 0) {
                        console.warn('mammoth.js warnings:', result.messages);
                    }
                })
                .catch(function(err) {
                    bodyEl.textContent = 'Gagal memuat/menampilkan dokumen: ' + err.message;
                });
        });
    });

    closeBtn.addEventListener('click', closeModal);
    overlay.addEventListener('click', function(e) {
        if (e.target === overlay) closeModal();
    });
})();
</script>

<? include_once("../framework/admin_footside.blade.php")?>
