import sys

file_path = 'z:/ProjectsX/AMHIntern/main/reorderout.php'
with open(file_path, 'r', encoding='utf-8') as f:
    content = f.read()

target1 = '''	function amhReorderoutFinish($pMessage) {
		global $oSystem;
		$vBack = amhReorderoutGetBackUrl();
		unset($_SESSION['reorderout_back_url']);
		$vMsg = str_replace(array("\\\\", "'"), array("\\\\\\\\", "\\\\'"), (string)$pMessage);
		$vBackJs = str_replace(array("\\\\", "'"), array("\\\\\\\\", "\\\\'"), $vBack);
		echo "<script language='JavaScript'>alert('{$vMsg}');window.location='{$vBackJs}';</script>";
		exit;
	}'''

replacement1 = '''	function amhReorderoutFinish($pMessage, $pNoJual = '', $pIDMember = '', $pTanggal = '') {
		global $oSystem;
		$vBack = amhReorderoutGetBackUrl();
		unset($_SESSION['reorderout_back_url']);
		$vMsg = str_replace(array("\\\\", "'"), array("\\\\\\\\", "\\\\'"), (string)$pMessage);
		$vBackJs = str_replace(array("\\\\", "'"), array("\\\\\\\\", "\\\\'"), $vBack);
		
		if ($pNoJual != '') {
			$vUrlDet = "../memstock/detjual.php?uNoJual=" . urlencode($pNoJual) . "&uIDMember=" . urlencode($pIDMember) . "&uTanggal=" . urlencode($pTanggal);
			echo "
			<style>
			.custom-modal-overlay {
				position: fixed; top: 0; left: 0; width: 100%; height: 100%;
				background: rgba(0,0,0,0.6); z-index: 999999;
				display: flex; justify-content: center; align-items: center;
			}
			.custom-modal-content {
				background: #fff; width: 90%; max-width: 800px; height: 90%;
				border-radius: 8px; box-shadow: 0 4px 15px rgba(0,0,0,0.2);
				position: relative; overflow: hidden; display: flex; flex-direction: column;
			}
			.custom-modal-header {
				padding: 10px 15px; background: #f8f9fa; border-bottom: 1px solid #ddd;
				display: flex; justify-content: space-between; align-items: center;
			}
			.custom-modal-header h4 { margin: 0; font-family: sans-serif; font-size: 16px; }
			.custom-modal-close {
				background: #dc3545; color: white; border: none; padding: 6px 15px;
				border-radius: 4px; cursor: pointer; font-weight: bold;
			}
			.custom-modal-close:hover { background: #c82333; }
			</style>
			<div class='custom-modal-overlay'>
				<div class='custom-modal-content'>
					<div class='custom-modal-header'>
						<h4>Detail Nota: $pNoJual</h4>
						<button class='custom-modal-close' onclick='window.location=\\\"{$vBackJs}\\\"'>Tutup &amp; Lanjutkan</button>
					</div>
					<iframe src='{$vUrlDet}' style='width:100%; flex: 1; border:none;'></iframe>
				</div>
			</div>
			<script language='JavaScript'>
			alert('{$vMsg}');
			</script>";
		} else {
			echo "<script language='JavaScript'>alert('{$vMsg}');window.location='{$vBackJs}';</script>";
		}
		exit;
	}'''

target2 = '''amhReorderoutFinish("Permintaan order berhasil dengan ID $vNextJual. Pebisnis akan menyelesaikan pembayaran melalui akun login.");'''
replacement2 = '''amhReorderoutFinish("Permintaan order berhasil dengan ID $vNextJual. Pebisnis akan menyelesaikan pembayaran melalui akun login.", $vNextJual, $vBuyer, date('Y-m-d'));'''

if target1 in content and target2 in content:
    content = content.replace(target1, replacement1)
    content = content.replace(target2, replacement2)
    with open(file_path, 'w', encoding='utf-8') as f:
        f.write(content)
    print('Success')
else:
    print('Targets not found')
    if target1 not in content:
        print('Target 1 not found')
    if target2 not in content:
        print('Target 2 not found')
