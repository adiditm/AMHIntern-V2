<?php
// masterdata/aichatanalytics.php
// Halaman Analitik Percakapan Chat AI untuk Administrator
include_once "../server/config.php";

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// Keamanan: Hanya administrator yang boleh mengakses halaman ini
if (!isset($_SESSION['LoginUser']) || (isset($_SESSION['Priv']) && $_SESSION['Priv'] !== 'administrator')) {
    header("Location: ../main/loginform.php");
    exit;
}

// Parameter Filter
$vRange = isset($_GET['range']) ? trim($_GET['range']) : 'all';
$vRole = isset($_GET['role']) ? trim($_GET['role']) : 'all';
$vTopic = isset($_GET['topic']) ? trim($_GET['topic']) : 'all';
$vQuery = isset($_GET['q']) ? trim($_GET['q']) : '';
$vPage = isset($_GET['p']) ? max(1, intval($_GET['p'])) : 1;
$vLimit = 25;
$vOffset = ($vPage - 1) * $vLimit;

// Build WHERE Clause
$whereParts = array();

if ($vRange === 'today') {
    $whereParts[] = "DATE(created_at) = CURDATE()";
} elseif ($vRange === 'yesterday') {
    $whereParts[] = "DATE(created_at) = DATE_SUB(CURDATE(), INTERVAL 1 DAY)";
} elseif ($vRange === '7d') {
    $whereParts[] = "created_at >= DATE_SUB(NOW(), INTERVAL 7 DAY)";
} elseif ($vRange === '30d') {
    $whereParts[] = "created_at >= DATE_SUB(NOW(), INTERVAL 30 DAY)";
} elseif ($vRange === 'month') {
    $whereParts[] = "MONTH(created_at) = MONTH(CURDATE()) AND YEAR(created_at) = YEAR(CURDATE())";
}

if ($vRole !== '' && $vRole !== 'all') {
    $roleEsc = mysql_real_escape_string($vRole);
    $whereParts[] = "role LIKE '%$roleEsc%'";
}

if ($vTopic !== '' && $vTopic !== 'all') {
    $topicEsc = mysql_real_escape_string($vTopic);
    $whereParts[] = "topic = '$topicEsc'";
}

if ($vQuery !== '') {
    $qEsc = mysql_real_escape_string($vQuery);
    $whereParts[] = "(user_message LIKE '%$qEsc%' OR bot_response LIKE '%$qEsc%' OR user_id LIKE '%$qEsc%')";
}

$whereClause = count($whereParts) > 0 ? "WHERE " . implode(" AND ", $whereParts) : "";

// Export CSV
if (isset($_GET['export']) && $_GET['export'] === 'csv') {
    header('Content-Type: text/csv; charset=utf-8');
    header('Content-Disposition: attachment; filename=analitik_percakapan_' . date('Ymd_His') . '.csv');
    $output = fopen('php://output', 'w');
    fputcsv($output, array('ID', 'Waktu', 'Role', 'User ID', 'Topik', 'Pertanyaan Pengguna', 'Respon AI', 'Status'));
    $db->query("SELECT * FROM m_ai_chat_log $whereClause ORDER BY created_at DESC");
    while ($db->next_record()) {
        fputcsv($output, array(
            $db->f('id'),
            $db->f('created_at'),
            $db->f('role'),
            $db->f('user_id'),
            $db->f('topic'),
            $db->f('user_message'),
            $db->f('bot_response'),
            $db->f('status')
        ));
    }
    fclose($output);
    exit;
}

// 1. Total KPI Metrics
$totalAll = 0;
$totalToday = 0;
$topTopicName = '-';
$topRoleName = '-';

// Cek apakah tabel m_ai_chat_log sudah ada
$tableCheck = @$db->query("SHOW TABLES LIKE 'm_ai_chat_log'");
$hasTable = ($tableCheck && $db->next_record());

if ($hasTable) {
    $db->query("SELECT COUNT(*) as cnt FROM m_ai_chat_log $whereClause");
    if ($db->next_record()) {
        $totalAll = intval($db->f('cnt'));
    }

    $db->query("SELECT COUNT(*) as cnt FROM m_ai_chat_log WHERE DATE(created_at) = CURDATE()");
    if ($db->next_record()) {
        $totalToday = intval($db->f('cnt'));
    }

    $db->query("SELECT topic, COUNT(*) as cnt FROM m_ai_chat_log $whereClause GROUP BY topic ORDER BY cnt DESC LIMIT 1");
    if ($db->next_record() && intval($db->f('cnt')) > 0) {
        $topTopicName = $db->f('topic') . ' (' . $db->f('cnt') . ')';
    }

    $db->query("SELECT role, COUNT(*) as cnt FROM m_ai_chat_log $whereClause GROUP BY role ORDER BY cnt DESC LIMIT 1");
    if ($db->next_record() && intval($db->f('cnt')) > 0) {
        $topRoleName = ucfirst($db->f('role')) . ' (' . $db->f('cnt') . ')';
    }
}
?><? include_once("../framework/admin_headside.blade.php")?><? include_once("../framework/admin_sidebar.blade.php")?>

<div class="right_col" role="main">
  <div class="row">
    <div class="col-md-12 col-sm-12 col-xs-12">
      <div style="display:flex; justify-content:space-between; align-items:center; flex-wrap:wrap; margin-bottom:1.25rem;">
        <div>
          <h3 style="margin:0; font-weight:700; color:var(--amh-amber-300, #fbbf24);">Analitik Percakapan AI</h3>
          <p style="margin:0.25rem 0 0 0; font-size:0.9rem; opacity:0.8;">Ringkasan topik & pertanyaan yang paling sering diajukan oleh pengunjung dan pengguna sistem.</p>
        </div>
        <div style="margin-top:0.5rem;">
          <a href="aichatanalytics.php?<?=http_build_query(array_merge($_GET, array('export' => 'csv')))?><?=!isset($_GET['current']) ? '&current=mdm_aitrain&menu=mdm_aitrain_analytics' : ''?>" class="btn btn-primary btn-sm" style="border-radius:6px;">
            <i class="fa fa-download"></i> Export CSV
          </a>
        </div>
      </div>
    </div>
  </div>

  <? if (!$hasTable) { ?>
  <div class="alert alert-warning" style="border-radius:8px;">
    <strong>Tabel database belum dibuat!</strong> Silakan jalankan script setup migrasi terlebih dahulu dengan membuka URL:
    <a href="../main/setup_ai_tables.php" target="_blank" style="font-weight:bold; text-decoration:underline;">/main/setup_ai_tables.php</a>.
  </div>
  <? } ?>

  <!-- KPI Overview Cards -->
  <div class="row" style="margin-bottom:1.5rem;">
    <div class="col-md-3 col-sm-6 col-xs-12" style="margin-bottom:0.75rem;">
      <div class="amh-glass-panel" style="padding:1.25rem; border-radius:10px; border-left:4px solid #38bdf8; background:rgba(15,23,42,0.65);">
        <div style="font-size:0.8rem; text-transform:uppercase; letter-spacing:0.05em; opacity:0.75;">Total Percakapan</div>
        <div style="font-size:1.8rem; font-weight:700; color:#38bdf8; margin-top:0.25rem;"><?=number_format($totalAll)?></div>
        <div style="font-size:0.8rem; opacity:0.6; margin-top:0.25rem;">Pertanyaan tersimpan</div>
      </div>
    </div>
    <div class="col-md-3 col-sm-6 col-xs-12" style="margin-bottom:0.75rem;">
      <div class="amh-glass-panel" style="padding:1.25rem; border-radius:10px; border-left:4px solid #34d399; background:rgba(15,23,42,0.65);">
        <div style="font-size:0.8rem; text-transform:uppercase; letter-spacing:0.05em; opacity:0.75;">Pertanyaan Hari Ini</div>
        <div style="font-size:1.8rem; font-weight:700; color:#34d399; margin-top:0.25rem;"><?=number_format($totalToday)?></div>
        <div style="font-size:0.8rem; opacity:0.6; margin-top:0.25rem;">Per <?=date('d M Y')?></div>
      </div>
    </div>
    <div class="col-md-3 col-sm-6 col-xs-12" style="margin-bottom:0.75rem;">
      <div class="amh-glass-panel" style="padding:1.25rem; border-radius:10px; border-left:4px solid #fbbf24; background:rgba(15,23,42,0.65);">
        <div style="font-size:0.8rem; text-transform:uppercase; letter-spacing:0.05em; opacity:0.75;">Topik Terpopuler</div>
        <div style="font-size:1.15rem; font-weight:700; color:#fbbf24; margin-top:0.5rem; word-break:break-word;"><?=htmlspecialchars($topTopicName)?></div>
        <div style="font-size:0.8rem; opacity:0.6; margin-top:0.25rem;">Paling banyak ditanyakan</div>
      </div>
    </div>
    <div class="col-md-3 col-sm-6 col-xs-12" style="margin-bottom:0.75rem;">
      <div class="amh-glass-panel" style="padding:1.25rem; border-radius:10px; border-left:4px solid #a78bfa; background:rgba(15,23,42,0.65);">
        <div style="font-size:0.8rem; text-transform:uppercase; letter-spacing:0.05em; opacity:0.75;">Role Penanya Teratas</div>
        <div style="font-size:1.15rem; font-weight:700; color:#a78bfa; margin-top:0.5rem; word-break:break-word;"><?=htmlspecialchars($topRoleName)?></div>
        <div style="font-size:0.8rem; opacity:0.6; margin-top:0.25rem;">Segmen pengguna aktif</div>
      </div>
    </div>
  </div>

  <!-- Filter Bar -->
  <div class="row" style="margin-bottom:1.5rem;">
    <div class="col-md-12">
      <div class="amh-glass-panel" style="padding:1rem 1.25rem; border-radius:10px; background:rgba(15,23,42,0.5);">
        <form method="GET" action="aichatanalytics.php" class="form-inline" style="display:flex; flex-wrap:wrap; gap:0.75rem; align-items:center;">
          <input type="hidden" name="current" value="<?=htmlspecialchars(isset($_GET['current']) ? $_GET['current'] : 'mdm_aitrain')?>">
          <input type="hidden" name="menu" value="<?=htmlspecialchars(isset($_GET['menu']) ? $_GET['menu'] : 'mdm_aitrain_analytics')?>">
          
          <div class="form-group" style="margin:0;">
            <label style="margin-right:0.4rem; font-size:0.85rem;">Periode:</label>
            <select name="range" class="form-control input-sm" style="border-radius:6px;" onchange="this.form.submit()">
              <option value="all" <?=$vRange==='all'?'selected':''?>>Semua Waktu</option>
              <option value="today" <?=$vRange==='today'?'selected':''?>>Hari Ini</option>
              <option value="yesterday" <?=$vRange==='yesterday'?'selected':''?>>Kemarin</option>
              <option value="7d" <?=$vRange==='7d'?'selected':''?>>7 Hari Terakhir</option>
              <option value="30d" <?=$vRange==='30d'?'selected':''?>>30 Hari Terakhir</option>
              <option value="month" <?=$vRange==='month'?'selected':''?>>Bulan Ini</option>
            </select>
          </div>

          <div class="form-group" style="margin:0;">
            <label style="margin-right:0.4rem; font-size:0.85rem;">Role:</label>
            <select name="role" class="form-control input-sm" style="border-radius:6px;" onchange="this.form.submit()">
              <option value="all" <?=$vRole==='all'?'selected':''?>>Semua Role</option>
              <option value="visitor" <?=$vRole==='visitor'?'selected':''?>>Visitor / Umum</option>
              <option value="pebisnis" <?=$vRole==='pebisnis'?'selected':''?>>Pebisnis</option>
              <option value="jamaah" <?=$vRole==='jamaah'?'selected':''?>>Jamaah</option>
              <option value="seller" <?=$vRole==='seller'?'selected':''?>>Seller</option>
              <option value="korwil" <?=$vRole==='korwil'?'selected':''?>>Korwil</option>
              <option value="admin" <?=$vRole==='admin'?'selected':''?>>Admin</option>
            </select>
          </div>

          <div class="form-group" style="margin:0;">
            <label style="margin-right:0.4rem; font-size:0.85rem;">Cari Kata Kunci:</label>
            <input type="text" name="q" value="<?=htmlspecialchars($vQuery)?>" placeholder="Cari pertanyaan / respon..." class="form-control input-sm" style="width:200px; border-radius:6px;">
          </div>

          <button type="submit" class="btn btn-default btn-sm" style="margin:0; border-radius:6px;"><i class="fa fa-filter"></i> Filter</button>
          <? if ($vRange !== 'all' || $vRole !== 'all' || $vTopic !== 'all' || $vQuery !== '') { ?>
            <a href="aichatanalytics.php?current=mdm_aitrain&menu=mdm_aitrain_analytics" class="btn btn-link btn-sm" style="color:#f87171; text-decoration:none; margin:0;"><i class="fa fa-times"></i> Reset</a>
          <? } ?>
        </form>
      </div>
    </div>
  </div>

  <!-- Grid: Topik Terbanyak & Pertanyaan Paling Sering Diajukan -->
  <div class="row" style="margin-bottom:1.5rem;">
    <!-- Bagian 1: Ringkasan Topik Teratas -->
    <div class="col-md-5 col-sm-12 col-xs-12" style="margin-bottom:1rem;">
      <div class="amh-glass-panel" style="padding:1.25rem; border-radius:10px; min-height:350px;">
        <h4 style="margin-top:0; font-weight:700; color:var(--amh-amber-300, #fbbf24); border-bottom:1px solid rgba(255,255,255,0.1); padding-bottom:0.75rem;">
          <i class="fa fa-pie-chart"></i> Ringkasan Topik Percakapan
        </h4>
        <div class="table-responsive" style="margin-top:1rem;">
          <table class="table table-condensed" style="margin:0;">
            <thead>
              <tr style="opacity:0.7; font-size:0.85rem;">
                <th>Topik</th>
                <th style="text-align:right;">Jumlah</th>
                <th style="width:35%;">Persentase</th>
              </tr>
            </thead>
            <tbody>
              <?
              $topicList = array();
              if ($hasTable && $totalAll > 0) {
                  $db->query("SELECT topic, COUNT(*) as cnt FROM m_ai_chat_log $whereClause GROUP BY topic ORDER BY cnt DESC");
                  while ($db->next_record()) {
                      $topicList[] = array(
                          'topic' => $db->f('topic'),
                          'cnt' => intval($db->f('cnt')),
                      );
                  }
              }
              if (count($topicList) > 0) {
                  foreach ($topicList as $t) {
                      $pct = $totalAll > 0 ? round(($t['cnt'] / $totalAll) * 100, 1) : 0;
              ?>
              <tr>
                <td style="font-weight:600; font-size:0.9rem;">
                  <span class="badge" style="background:rgba(56,189,248,0.2); color:#38bdf8; font-weight:500;"><?=htmlspecialchars($t['topic'])?></span>
                </td>
                <td style="text-align:right; font-weight:700;"><?=number_format($t['cnt'])?></td>
                <td>
                  <div class="progress" style="height:10px; margin:5px 0; background:rgba(255,255,255,0.1); border-radius:5px;">
                    <div class="progress-bar progress-bar-warning" role="progressbar" style="width:<?=$pct?>%; background:var(--amh-amber-gradient, #f59e0b);"></div>
                  </div>
                  <div style="font-size:0.75rem; text-align:right; opacity:0.6;"><?=$pct?>%</div>
                </td>
              </tr>
              <?
                  }
              } else {
              ?>
              <tr>
                <td colspan="3" style="text-align:center; opacity:0.6; padding:2rem 0;">Belum ada data topik pada filter ini.</td>
              </tr>
              <? } ?>
            </tbody>
          </table>
        </div>
      </div>
    </div>

    <!-- Bagian 2: Pertanyaan yang Paling Sering Diajukan (Top FAQs) -->
    <div class="col-md-7 col-sm-12 col-xs-12" style="margin-bottom:1rem;">
      <div class="amh-glass-panel" style="padding:1.25rem; border-radius:10px; min-height:350px;">
        <h4 style="margin-top:0; font-weight:700; color:var(--amh-amber-300, #fbbf24); border-bottom:1px solid rgba(255,255,255,0.1); padding-bottom:0.75rem;">
          <i class="fa fa-comments-o"></i> Pertanyaan yang Paling Sering Diajukan Pengguna
        </h4>
        <div class="table-responsive" style="margin-top:1rem;">
          <table class="table table-hover" style="margin:0;">
            <thead>
              <tr style="opacity:0.7; font-size:0.85rem;">
                <th style="width:35px;">#</th>
                <th>Pertanyaan / Topik Pertanyaan</th>
                <th>Kategori Topik</th>
                <th style="text-align:center; width:80px;">Frekuensi</th>
                <th style="width:110px;">Terakhir</th>
              </tr>
            </thead>
            <tbody>
              <?
              $faqList = array();
              if ($hasTable) {
                  $db->query("SELECT MIN(user_message) as user_message, MIN(topic) as topic, MIN(role) as role, COUNT(*) as freq, MAX(created_at) as last_time
                              FROM m_ai_chat_log $whereClause
                              GROUP BY LOWER(TRIM(user_message))
                              ORDER BY freq DESC, last_time DESC
                              LIMIT 10");
                  while ($db->next_record()) {
                      $faqList[] = array(
                          'msg' => $db->f('user_message'),
                          'topic' => $db->f('topic'),
                          'role' => $db->f('role'),
                          'freq' => intval($db->f('freq')),
                          'last_time' => $db->f('last_time'),
                      );
                  }
              }
              if (count($faqList) > 0) {
                  $rank = 1;
                  foreach ($faqList as $faq) {
              ?>
              <tr>
                <td style="font-weight:700; color:var(--amh-amber-300, #fbbf24);"><?=$rank++?></td>
                <td style="font-size:0.9rem; font-weight:500;">
                  <?=htmlspecialchars($faq['msg'])?>
                </td>
                <td>
                  <span class="label label-default" style="font-size:0.75rem; background:rgba(255,255,255,0.1);"><?=htmlspecialchars($faq['topic'])?></span>
                </td>
                <td style="text-align:center;">
                  <span class="badge" style="background:#f59e0b; color:#1e293b; font-weight:700; padding:4px 8px;"><?=$faq['freq']?>x</span>
                </td>
                <td style="font-size:0.75rem; opacity:0.7;">
                  <?=date('d/m/y H:i', strtotime($faq['last_time']))?>
                </td>
              </tr>
              <?
                  }
              } else {
              ?>
              <tr>
                <td colspan="5" style="text-align:center; opacity:0.6; padding:2rem 0;">Belum ada riwayat pertanyaan pada filter ini.</td>
              </tr>
              <? } ?>
            </tbody>
          </table>
        </div>
      </div>
    </div>
  </div>

  <!-- Bagian 3: Riwayat Log Percakapan Terbaru (Tabel Detail) -->
  <div class="row">
    <div class="col-md-12">
      <div class="amh-glass-panel" style="padding:1.25rem; border-radius:10px;">
        <div style="display:flex; justify-content:space-between; align-items:center; border-bottom:1px solid rgba(255,255,255,0.1); padding-bottom:0.75rem; margin-bottom:1rem;">
          <h4 style="margin:0; font-weight:700; color:var(--amh-amber-300, #fbbf24);">
            <i class="fa fa-list"></i> Riwayat Lengkap Percakapan
          </h4>
          <span style="font-size:0.85rem; opacity:0.7;">Menampilkan <?=number_format(min($vLimit, max(0, $totalAll - $vOffset)))?> dari <?=number_format($totalAll)?> percakapan</span>
        </div>

        <div class="table-responsive">
          <table class="table table-striped table-hover" style="margin:0;">
            <thead>
              <tr style="opacity:0.8;">
                <th style="width:130px;">Waktu</th>
                <th style="width:140px;">Pengguna / Role</th>
                <th style="width:150px;">Topik</th>
                <th>Pertanyaan Pengguna</th>
                <th style="width:130px; text-align:center;">Respon AI</th>
                <th style="width:80px; text-align:center;">Status</th>
              </tr>
            </thead>
            <tbody>
              <?
              if ($hasTable && $totalAll > 0) {
                  $db->query("SELECT * FROM m_ai_chat_log $whereClause ORDER BY created_at DESC LIMIT $vOffset, $vLimit");
                  while ($db->next_record()) {
                      $logId = $db->f('id');
                      $logTime = $db->f('created_at');
                      $logRole = $db->f('role');
                      $logUserId = $db->f('user_id');
                      $logTopic = $db->f('topic');
                      $logMsg = $db->f('user_message');
                      $logResp = $db->f('bot_response');
                      $logStatus = $db->f('status');

                      // Badge role color
                      $badgeStyle = 'background:rgba(148,163,184,0.2); color:#cbd5e1;';
                      if (stripos($logRole, 'pebisnis') !== false) {
                          $badgeStyle = 'background:rgba(251,191,36,0.2); color:#fbbf24;';
                      } elseif (stripos($logRole, 'jamaah') !== false) {
                          $badgeStyle = 'background:rgba(56,189,248,0.2); color:#38bdf8;';
                      } elseif (stripos($logRole, 'seller') !== false) {
                          $badgeStyle = 'background:rgba(52,211,153,0.2); color:#34d399;';
                      } elseif (stripos($logRole, 'admin') !== false) {
                          $badgeStyle = 'background:rgba(248,113,113,0.2); color:#f87171;';
                      }
              ?>
              <tr>
                <td style="font-size:0.85rem; opacity:0.85;">
                  <?=date('d/m/Y', strtotime($logTime))?><br>
                  <small style="opacity:0.7;"><?=date('H:i:s', strtotime($logTime))?></small>
                </td>
                <td>
                  <span class="badge" style="<?=$badgeStyle?> font-weight:600; font-size:0.75rem;">
                    <?=htmlspecialchars(ucwords($logRole))?>
                  </span>
                  <? if ($logUserId) { ?>
                    <div style="font-size:0.75rem; opacity:0.8; margin-top:3px;"><i class="fa fa-user"></i> <?=htmlspecialchars($logUserId)?></div>
                  <? } ?>
                </td>
                <td>
                  <span class="label label-default" style="background:rgba(255,255,255,0.08); font-size:0.8rem;">
                    <?=htmlspecialchars($logTopic)?>
                  </span>
                </td>
                <td style="font-size:0.9rem; line-height:1.4;">
                  <?=htmlspecialchars($logMsg)?>
                </td>
                <td style="text-align:center;">
                  <button type="button" class="btn btn-info btn-xs btnViewChat" data-id="<?=$logId?>" data-msg="<?=htmlspecialchars($logMsg, ENT_QUOTES, 'UTF-8')?>" data-resp="<?=htmlspecialchars($logResp, ENT_QUOTES, 'UTF-8')?>" style="border-radius:4px;">
                    <i class="fa fa-eye"></i> Lihat Respon
                  </button>
                </td>
                <td style="text-align:center;">
                  <? if ($logStatus === 'success') { ?>
                    <span class="label label-success" style="font-size:0.75rem;">Sukses</span>
                  <? } else { ?>
                    <span class="label label-danger" style="font-size:0.75rem;">Gagal</span>
                  <? } ?>
                </td>
              </tr>
              <?
                  }
              } else {
              ?>
              <tr>
                <td colspan="6" style="text-align:center; opacity:0.6; padding:2.5rem 0;">
                  <i class="fa fa-inbox" style="font-size:2rem; margin-bottom:0.5rem; display:block;"></i>
                  Belum ada percakapan yang tercatat. Pertanyaan pengguna yang masuk via chat widget akan otomatis tampil di sini.
                </td>
              </tr>
              <? } ?>
            </tbody>
          </table>
        </div>

        <!-- Pagination -->
        <?
        $totalPages = ceil($totalAll / $vLimit);
        if ($totalPages > 1) {
            $baseQuery = $_GET;
        ?>
        <div style="margin-top:1.5rem; text-align:center;">
          <ul class="pagination pagination-sm" style="margin:0;">
            <? if ($vPage > 1) {
                $baseQuery['p'] = $vPage - 1;
            ?>
              <li><a href="aichatanalytics.php?<?=http_build_query($baseQuery)?>">&laquo; Prev</a></li>
            <? } ?>
            <?
            $startP = max(1, $vPage - 3);
            $endP = min($totalPages, $vPage + 3);
            for ($pi = $startP; $pi <= $endP; $pi++) {
                $baseQuery['p'] = $pi;
            ?>
              <li class="<?=$pi == $vPage ? 'active' : ''?>">
                <a href="aichatanalytics.php?<?=http_build_query($baseQuery)?>"><?=$pi?></a>
              </li>
            <? } ?>
            <? if ($vPage < $totalPages) {
                $baseQuery['p'] = $vPage + 1;
            ?>
              <li><a href="aichatanalytics.php?<?=http_build_query($baseQuery)?>">Next &raquo;</a></li>
            <? } ?>
          </ul>
        </div>
        <? } ?>

      </div>
    </div>
  </div>
</div>

<!-- Modal View Respon AI -->
<div id="aiRespModal" style="display:none; position:fixed; inset:0; background:rgba(8,13,26,0.8); z-index:9999; align-items:center; justify-content:center; padding:1.5rem;">
  <div class="amh-glass-panel" style="max-width:650px; width:100%; border-radius:12px; max-height:85vh; display:flex; flex-direction:column; padding:1.5rem; background:#0f172a; border:1px solid rgba(251,191,36,0.3); box-shadow:0 20px 40px rgba(0,0,0,0.5);">
    <div style="display:flex; justify-content:space-between; align-items:center; border-bottom:1px solid rgba(255,255,255,0.1); padding-bottom:0.75rem; margin-bottom:1rem;">
      <h4 style="margin:0; font-weight:700; color:#fbbf24;"><i class="fa fa-commenting-o"></i> Detail Percakapan AI</h4>
      <button type="button" id="aiRespModalClose" style="background:transparent; border:none; color:#fff; font-size:1.5rem; cursor:pointer;">&times;</button>
    </div>
    <div style="overflow-y:auto; flex-grow:1; padding-right:0.5rem;">
      <div style="margin-bottom:1rem;">
        <label style="font-size:0.75rem; text-transform:uppercase; opacity:0.7; color:#38bdf8;">Pertanyaan Pengguna:</label>
        <div id="modalUserMsg" style="background:rgba(255,255,255,0.06); padding:0.85rem; border-radius:8px; font-size:0.95rem; line-height:1.5; color:#fff;"></div>
      </div>
      <div>
        <label style="font-size:0.75rem; text-transform:uppercase; opacity:0.7; color:#34d399;">Jawaban AI Assistant:</label>
        <div id="modalBotResp" style="background:rgba(15,23,42,0.8); border:1px solid rgba(255,255,255,0.1); padding:0.85rem; border-radius:8px; font-size:0.95rem; line-height:1.6; color:#e2e8f0; white-space:pre-wrap;"></div>
      </div>
    </div>
    <div style="margin-top:1.25rem; text-align:right; border-top:1px solid rgba(255,255,255,0.1); padding-top:0.75rem;">
      <button type="button" id="aiRespModalCloseBtn" class="btn btn-default btn-sm" style="border-radius:6px;">Tutup</button>
    </div>
  </div>
</div>

<script>
(function(){
  var modal = document.getElementById('aiRespModal');
  var userMsg = document.getElementById('modalUserMsg');
  var botResp = document.getElementById('modalBotResp');
  var closeX = document.getElementById('aiRespModalClose');
  var closeBtn = document.getElementById('aiRespModalCloseBtn');

  function closeModal() {
    modal.style.display = 'none';
  }

  document.querySelectorAll('.btnViewChat').forEach(function(btn){
    btn.addEventListener('click', function(){
      userMsg.textContent = btn.getAttribute('data-msg') || '-';
      botResp.textContent = btn.getAttribute('data-resp') || '(Tidak ada respon)';
      modal.style.display = 'flex';
    });
  });

  if (closeX) closeX.addEventListener('click', closeModal);
  if (closeBtn) closeBtn.addEventListener('click', closeModal);
  if (modal) {
    modal.addEventListener('click', function(e){
      if (e.target === modal) closeModal();
    });
  }
})();
</script>

<? include_once("../framework/admin_footside.blade.php")?>