INSERT INTO m_menu( module_name, menu_id, menu_title, menu_title_en, is_active, menu_order, flink, ficon, flevel, fparent, fismenu, fhassub, fpriv) 
VALUES ( '[none]', 'mdm_trans_mutaspon', 'Mutasi Saldo', '', '1', '8104', '../memstock/ewalletbal.php', 'fa-list', '2', 'mdm_pebisnis', '1', '0', 'sponsor');


INSERT INTO m_menu( module_name, menu_id, menu_title, menu_title_en, is_active, menu_order, flink, ficon, flevel, fparent, fismenu, fhassub, fpriv) 
VALUES ( '[none]', 'mdm_trans_mutakorsub', 'Mutasi Saldo', '', '1', '8104', '../memstock/ewalletbal.php', 'fa-list', '2', 'mdm_korwil_sub', '1', '0', 'korwil;subkorwil;');



INSERT INTO m_menu( module_name, menu_id, menu_title, menu_title_en, is_active, menu_order, flink, ficon, flevel, fparent, fismenu, fhassub, fpriv) 
VALUES ( '[none]', 'mdm_admin_appvwith', 'Approval Withdrawal', '', '1', '2005', '../manager/veriwith.php', 'fa-list', '2', 'mdm_admin', '1', '0', 'korwil;subkorwil;');


INSERT INTO m_menu( module_name, menu_id, menu_title, menu_title_en, is_active, menu_order, flink, ficon, flevel, fparent, fismenu, fhassub, fpriv) 
VALUES ( '[none]', 'spon_trans_tourint', 'Booking Tour Internasional', '', '1', '8101', '../memstock/tour.php', 'fa-list', '2', 'mdm_pebisnis', '1', '0', 'sponsor');

INSERT INTO m_menu( module_name, menu_id, menu_title, menu_title_en, is_active, menu_order, flink, ficon, flevel, fparent, fismenu, fhassub, fpriv) 
VALUES ( '[none]', 'spon_trans_tourdom', 'Booking Tour Domestik', '', '1', '8102', '../memstock/tourdom.php', 'fa-list', '2', 'mdm_pebisnis', '1', '0', 'sponsor');

INSERT INTO m_menu( module_name, menu_id, menu_title, menu_title_en, is_active, menu_order, flink, ficon, flevel, fparent, fismenu, fhassub, fpriv) 
VALUES ( '[none]', 'spon_trans_umroh', 'Booking Umroh', '', '1', '8103', '../memstock/umroh.php', 'fa-list', '2', 'mdm_pebisnis', '1', '0', 'sponsor');

select * from (select fidmember, fnama, fsaldovcr,faktif from m_pebisnis  union select fidkorwil as 
fidmember,a.fnama, b.fsaldovcr, a.faktif from m_korwil a left join m_pebisnis b on a.fidbisnis= b.fidmember )
 as gab where faktif <> '0' order by fidmember  
 
 
 

INSERT INTO m_menu( module_name, menu_id, menu_title, menu_title_en, is_active, menu_order, flink, ficon, flevel, fparent, fismenu, fhassub, fpriv) 
VALUES ( '[none]', 'mdm_trans_tsalkorsub', 'Transfer Saldo', '', '1', '8104', '../memstock/transfer.php', 'fa-list', '2', 'mdm_korwil_sub', '1', '0', 'korwil;subkorwil;');


INSERT INTO m_menu( module_name, menu_id, menu_title, menu_title_en, is_active, menu_order, flink, ficon, flevel, fparent, fismenu, fhassub, fpriv) 
VALUES ( '[none]', 'spon_trans_tsaldo', 'Transfer Saldo', '', '1', '8103', '../memstock/transfer.php', 'fa-list', '2', 'mdm_pebisnis', '1', '0', 'sponsor');


select * from m_admin where fidmember='1702-0000-0577'

        
SELECT a.fidmember from m_pebisnis a left join m_admin b on a.fidmember=b.fidmember 
where a.fidmember='1702-0000-0577' and b.fpassword='e10adc3949ba59abbe56e057f20f883e' and a.faktif <> '0' 


INSERT INTO m_menu( module_name, menu_id, menu_title, menu_title_en, is_active, menu_order, flink, ficon, flevel, fparent, fismenu, fhassub, fpriv) 
VALUES ('[none]', 'mdm_admin_appvwith', 'Approval Transfer Saldo', '', '1', '2005', '../manager/appvtrans.php', 'fa-list', '2', 'mdm_admin', '1', '0', 'administrator');

truncate table tb_komisi



INSERT INTO m_menu(fidsys, module_name, menu_id, menu_title, menu_title_en, is_active, menu_order, flink, ficon, flevel, fparent, fismenu, fhassub, fpriv) 
VALUES ('168', '[none]', 'mdm_admin_lappay', '<font color="#0f0">History Pembayaran</font>', '', '1', '2004', '../manager/rpt_payhistory.php', 'fa-list', '2', 'mdm_admin', '1', '0', 'administrator');


UPDATE m_menu SET menu_title = 'Report Referensi' WHERE fidsys = '43';
UPDATE m_menu SET menu_title = 'Top Referensi' WHERE fidsys = '69';
UPDATE m_menu SET menu_title = 'Set Bns Korwil & Referensi' WHERE fidsys = '108';
UPDATE m_menu SET menu_title = 'Posting Bonus Referensi' WHERE fidsys = '114';
UPDATE m_menu SET menu_title = 'Bonus Referensi Terposting' WHERE fidsys = '120';
UPDATE m_menu SET menu_title = '<font color="#0f0">Laporan Referensi</font>' WHERE fidsys = '123';
UPDATE m_menu SET menu_title = 'Diskon Referensi' WHERE fidsys = '124';
UPDATE m_menu SET menu_title = 'User Referensi / Pebisnis' WHERE fidsys = '125';
UPDATE m_menu SET menu_title = 'Jamaah Direferensi' WHERE fidsys = '127';
UPDATE m_menu SET menu_title = 'Diskon Referensi by Tgl Brgkt ' WHERE fidsys = '138';
UPDATE m_menu SET menu_title = 'Posting Diskon Referensi SP' WHERE fidsys = '141';
UPDATE m_menu SET menu_title = 'Diskon Referensi by Tgl Brgkt  SP' WHERE fidsys = '142';


UPDATE m_menu SET menu_title = 'Posting Diskon KTP' WHERE fidsys = '112';
UPDATE m_menu SET menu_title = 'Posting Diskon Registrasi' WHERE fidsys = '113';
UPDATE m_menu SET menu_title = 'Posting Diskon Referensi' WHERE fidsys = '114';
UPDATE m_menu SET menu_title = 'Diskon KTP' WHERE fidsys = '116';
UPDATE m_menu SET menu_title = 'Diskon Registrasi' WHERE fidsys = '117';
UPDATE m_menu SET menu_title = 'Diskon KTP Terposting' WHERE fidsys = '118';
UPDATE m_menu SET menu_title = 'Diskon Registrasi Terposting' WHERE fidsys = '119';
UPDATE m_menu SET menu_title = 'Diskon Referensi Terposting' WHERE fidsys = '120';
UPDATE m_menu SET menu_title = 'Diskon KTP by Tgl. Brgkt ' WHERE fidsys = '136';
UPDATE m_menu SET menu_title = 'Diskon Reg by Tgl. Brgkt ' WHERE fidsys = '137';

UPDATE m_menu SET menu_title = 'History Pencairan' WHERE fidsys = '46';
UPDATE m_menu SET menu_title = 'Pencairan' WHERE fidsys = '146';
UPDATE m_menu SET menu_title = 'Pencairan' WHERE fidsys = '152';
UPDATE m_menu SET menu_title = 'Pencairan' WHERE fidsys = '153';
UPDATE m_menu SET menu_title = 'Approval Pencairan' WHERE fidsys = '156';

UPDATE m_menu SET menu_title = 'Trans Espay Disc. Stockist' WHERE fidsys = '85';
UPDATE m_menu SET menu_title = 'Set Disc Korwil & Referensi' WHERE fidsys = '108';
