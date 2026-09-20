<?php
include_once "../server/config.php";
header('Content-Type: text/plain');

$results = array();

// --- Tables ---
$sql1 = "CREATE TABLE IF NOT EXISTS m_ai_document (
  id INT AUTO_INCREMENT PRIMARY KEY,
  role VARCHAR(20) NOT NULL,
  filename VARCHAR(255) NOT NULL,
  filepath VARCHAR(255) NOT NULL,
  status VARCHAR(20) NOT NULL DEFAULT 'pending',
  error_message TEXT NULL,
  uploaded_by VARCHAR(50) NULL,
  uploaded_at DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
  processed_at DATETIME NULL,
  INDEX idx_role (role)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4";
$db->query($sql1);
$results[] = "m_ai_document: " . ($db->Errno ? "ERROR " . $db->Error : "OK");

$sql2 = "CREATE TABLE IF NOT EXISTS m_ai_document_chunk (
  id INT AUTO_INCREMENT PRIMARY KEY,
  document_id INT NOT NULL,
  role VARCHAR(20) NOT NULL,
  chunk_index INT NOT NULL,
  chunk_text TEXT NOT NULL,
  embedding LONGTEXT NOT NULL,
  created_at DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
  INDEX idx_document (document_id),
  INDEX idx_role (role),
  FOREIGN KEY (document_id) REFERENCES m_ai_document(id) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4";
$db->query($sql2);
$results[] = "m_ai_document_chunk: " . ($db->Errno ? "ERROR " . $db->Error : "OK");

// --- Sidebar menu rows (idempotent: only insert if the parent menu_id doesn't exist yet) ---
$db->query("select menu_id from m_menu where menu_id = 'mdm_aitrain'");
if (!$db->next_record()) {
    $db->query("INSERT INTO m_menu (menu_id, menu_title, flevel, fparent, flink, ficon, fhassub, is_active, fismenu, fpriv, menu_order)
        VALUES ('mdm_aitrain', 'Dokumen Training AI', '1', '', '', 'fa-file-text-o', '1', '1', '1', 'administrator', '9500')");
    $results[] = "menu group 'mdm_aitrain': INSERTED";

    $children = array(
        array('mdm_aitrain_visitor', 'Dokumen untuk Visitor'),
        array('mdm_aitrain_jamaah',  'Dokumen untuk Jamaah'),
        array('mdm_aitrain_pebisnis','Dokumen untuk Pebisnis'),
        array('mdm_aitrain_seller',  'Dokumen Untuk Seller'),
        array('mdm_aitrain_korwil',  'Dokumen untuk Korwil'),
        array('mdm_aitrain_admin',   'Dokumen untuk Admin / Karyawan'),
    );
    $order = 9510;
    foreach ($children as $c) {
        $menuId = mysql_real_escape_string($c[0]);
        $title  = mysql_real_escape_string($c[1]);
        $db->query("INSERT INTO m_menu (menu_id, menu_title, flevel, fparent, flink, ficon, fhassub, is_active, fismenu, fpriv, menu_order)
            VALUES ('$menuId', '$title', '2', 'mdm_aitrain', '../masterdata/aitraindocs.php', '', '0', '1', '1', 'administrator', '$order')");
        $results[] = "menu item '$menuId': INSERTED";
        $order += 10;
    }
} else {
    $results[] = "menu group 'mdm_aitrain': already exists, skipped (idempotent)";
}

echo implode("\n", $results) . "\n";
echo "\nIMPORTANT: the new menu will not appear for any admin account until it's\n";
echo "granted on the existing 'Admin Privilege' page (masterdata/menupriv.php) --\n";
echo "log in as admin, open Admin Privilege, tick 'Dokumen Training AI' for the\n";
echo "accounts that should see it. This script does not touch tb_menupriv.\n";
