<?php
/**
 * Remove old, unpaid and unprocessed temporary sales transactions.
 *
 * The retention period is configured in tb_rules_config as:
 *   fsetname = 'fautodeltrx'
 *   fsetval  = number of hours
 *
 * This file is intended to be called by cron (HTTP or CLI).
 */
date_default_timezone_set('Asia/Jakarta');

include_once(dirname(__FILE__) . '/../server/config.php');
include_once(CLASS_DIR . 'ruleconfigclass.php');

function deactivetrx_has_column($table, $column) {
    global $dbin;

    $dbin->query("SHOW COLUMNS FROM `$table` LIKE '$column'");
    return ($dbin->next_record() !== false);
}

function deactivetrx_log($message) {
    global $vLogLines;
    $vLogLines[] = $message;
    $vLineBreak = (PHP_SAPI === 'cli') ? "\n" : "<br>\n";
    echo date('Y-m-d H:i:s') . ' ' . $message . $vLineBreak;
}

function deactivetrx_send_report($subject) {
    global $oRules, $oSystem, $vLogLines;

    $vTo = 'amhtechs@gmail.com';
    $vFrom = $oRules->getSettingByField('fmailadmin');
    if ($vFrom === -1 || trim($vFrom) === '') {
        deactivetrx_log('WARNING: email report tidak dikirim karena fmailadmin belum dikonfigurasi.');
        return;
    }

    $vBody = '<html><body><pre>'
        . htmlspecialchars(implode("\n", $vLogLines), ENT_QUOTES, 'UTF-8')
        . '</pre></body></html>';
    $oSystem->smtpmailer($vTo, $vFrom, 'AMHIntern', $subject, $vBody, '', '', true);
    deactivetrx_log('Email report dikirim ke ' . $vTo . '.');
}

// Safety default: cron/tests perform a read-only dry run unless deletion is
// explicitly requested with ?op=delete or the CLI argument --delete.
$vExecuteDelete = false;
if (isset($_GET['op']) && strtolower($_GET['op']) === 'delete') {
    $vExecuteDelete = true;
}
if (isset($argv) && in_array('--delete', $argv, true)) {
    $vExecuteDelete = true;
}

$vHoursRaw = $oRules->getSettingByField('fautodeltrx');
$vHours = filter_var($vHoursRaw, FILTER_VALIDATE_INT, array('options' => array('min_range' => 0)));

// Never delete anything when the rule is missing or invalid.
if ($vHours === false || $vHoursRaw === -1 || $vHoursRaw === '') {
    deactivetrx_log("ERROR: aturan fautodeltrx tidak ditemukan atau tidak valid; tidak ada transaksi yang dihapus.");
    exit(1);
}

$vTables = array('tb_penjualan_temp_out', 'tb_penjualan_temp');
$vConditions = array();

foreach ($vTables as $vTable) {
    // These columns are required to identify a pending transaction safely.
    foreach (array('fprocessed', 'fpaid', 'ftglentry', 'ftanggal') as $vRequiredColumn) {
        if (!deactivetrx_has_column($vTable, $vRequiredColumn)) {
            deactivetrx_log("ERROR: kolom $vRequiredColumn tidak ditemukan pada $vTable; proses dibatalkan.");
            exit(1);
        }
    }

    $vFlags = array(
        "IFNULL(`fprocessed`, '0') = '0'",
        "IFNULL(`fpaid`, '0') = '0'"
    );

    // Some older tb_penjualan_temp_out schemas do not physically store these
    // two flags; that table's pending workflow treats them as zero.
    foreach (array('fsend', 'freceived') as $vFlagColumn) {
        if (deactivetrx_has_column($vTable, $vFlagColumn)) {
            $vFlags[] = "IFNULL(`$vFlagColumn`, '0') = '0'";
        }
    }

    // Do not compare datetime columns with the zero-date literal. MySQL
    // strict mode rejects that literal (error 1292). YEAR() safely returns 0
    // for legacy zero-date values, so only valid dates are considered.
    $vCreatedAt = "CASE WHEN YEAR(`ftglentry`) > 0 THEN `ftglentry` "
        . "WHEN YEAR(`ftanggal`) > 0 THEN `ftanggal` ELSE NULL END";
    $vConditions[$vTable] = implode(' AND ', $vFlags)
        . " AND $vCreatedAt IS NOT NULL"
        . " AND $vCreatedAt <= DATE_SUB(NOW(), INTERVAL $vHours HOUR)";
}

deactivetrx_log('Mode: ' . ($vExecuteDelete ? 'DELETE AKTIF' : 'DRY-RUN (tidak ada data dihapus)'));
deactivetrx_log('Batas usia transaksi: ' . $vHours . ' jam.');

if (!$vExecuteDelete) {
    foreach ($vTables as $vTable) {
        $vSQL = "SELECT fidpenjualan, COUNT(*) AS fcount "
            . "FROM `$vTable` WHERE {$vConditions[$vTable]} "
            . "GROUP BY fidpenjualan ORDER BY fidpenjualan";
        $dbin->query($vSQL);
        $vTransactionCount = 0;
        $vRowCount = 0;
        while ($dbin->next_record()) {
            $vTransactionCount++;
            $vRowCount += (int) $dbin->f('fcount');
            deactivetrx_log($vTable . ' kandidat: ' . $dbin->f('fidpenjualan')
                . ' (' . $dbin->f('fcount') . ' baris)');
        }
        deactivetrx_log($vTable . ': ' . $vTransactionCount
            . ' transaksi / ' . $vRowCount . ' baris akan dihapus.');
    }
    deactivetrx_send_report('Dry-run auto delete transaksi pending');
    exit(0);
}

$vDeleted = array();
$db->query('START TRANSACTION');
foreach ($vTables as $vTable) {
    $vSQL = "DELETE FROM `$vTable` WHERE {$vConditions[$vTable]}";
    $db->query($vSQL);
    $vDeleted[$vTable] = (int) $db->affected_rows();
}
$db->query('COMMIT');

foreach ($vDeleted as $vTable => $vCount) {
    deactivetrx_log($vTable . ': ' . $vCount . ' baris dihapus.');
}
deactivetrx_send_report('Auto delete transaksi pending');
?>
