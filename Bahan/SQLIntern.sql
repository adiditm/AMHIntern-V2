ALTER TABLE k6010526_intern.m_program ADD fsyaratsa DOUBLE PRECISION DEFAULT 0;
ALTER TABLE k6010526_intern.m_program ADD fsyaratlns DOUBLE PRECISION DEFAULT 0;

select *,fpromo from m_anggota where fpromo<>''
select * from m_anggota where fidmember like 'JU-2020%'
select * from m_anggota where faktif <> '1'

select * from m_anggota where 1 and frefer ='2002-0000-1452'

INSERT INTO m_menu( module_name, menu_id, menu_title, is_active, menu_order, flink, ficon, flevel, fparent, fismenu, fhassub, fpriv) 
VALUES ('[none]', 'mdm_transaction', 'Transaksi', '1', '9100', '#', 'fa-handshake', '1', '', '1', '1', 'administrator');


INSERT INTO m_menu( module_name, menu_id, menu_title, is_active, menu_order, flink, ficon, flevel, fparent, fismenu, fhassub, fpriv) 
VALUES ('[none]', 'mdm_trans_tourint', 'Booking Tour Internasional', '1', '8101', '#', 'fa-list', '2', 'mdm_transaction', '1', '0', 'administrator');


INSERT INTO m_menu( module_name, menu_id, menu_title, is_active, menu_order, flink, ficon, flevel, fparent, fismenu, fhassub, fpriv) 
VALUES ('[none]', 'mdm_trans_umroh', 'Booking Umroh', '1', '8103', '#', 'fa-list', '2', 'mdm_transaction', '1', '0', 'administrator');


INSERT INTO m_menu( module_name, menu_id, menu_title, is_active, menu_order, flink, ficon, flevel, fparent, fismenu, fhassub, fpriv) 
VALUES ('[none]', 'mdm_trans_mutasi', 'Mutasi Saldo', '1', '8106', '#', 'fa-list', '2', 'mdm_transaction', '1', '0', 'administrator');


INSERT INTO m_menu( module_name, menu_id, menu_title, is_active, menu_order, flink, ficon, flevel, fparent, fismenu, fhassub, fpriv) 
VALUES ('[none]', 'mdm_trans_rsaldo', 'Report Saldo', '1', '8107', '#', 'fa-list', '2', 'mdm_transaction', '1', '0', 'administrator');


INSERT INTO m_menu( module_name, menu_id, menu_title, is_active, menu_order, flink, ficon, flevel, fparent, fismenu, fhassub, fpriv) 
VALUES ('[none]', 'mdm_trans_transbal', 'Transfer Saldo', '1', '8101', '#', 'fa-list', '2', 'mdm_transaction', '1', '0', 'administrator');


ALTER TABLE k6010526_intern.m_menu ADD menu_title_en VARCHAR(250) after menu_title;


select * from m_tour where fidtour='AMHU-0009'


INSERT INTO m_menu( module_name, menu_id, menu_title, menu_title_en, is_active, menu_order, flink, ficon, flevel, fparent, fismenu, fhassub, fpriv) 
VALUES ('[none]', 'mdm_master_data_umtour', 'Umroh dan Tour', '', '1', '1027', '../masterdata/mastertour.php', 'fa-list', '2', 'mdm_master_data', '1', '0', 'administrator');

INSERT INTO m_menu( module_name, menu_id, menu_title, menu_title_en, is_active, menu_order, flink, ficon, flevel, fparent, fismenu, fhassub, fpriv) 
VALUES ( '[none]', 'mdm_trans_withspon', 'Withdraw', '', '1', '8104', '../memstock/withdraw.php', 'fa-list', '2', 'mdm_pebisnis', '1', '0', 'sponsor');


INSERT INTO m_menu( module_name, menu_id, menu_title, menu_title_en, is_active, menu_order, flink, ficon, flevel, fparent, fismenu, fhassub, fpriv) 
VALUES ( '[none]', 'mdm_trans_withkorsub', 'Withdraw', '', '1', '8104', '../memstock/withdraw.php', 'fa-list', '2', 'mdm_pebisnis', '1', '0', 'korwil;subkorwil;');

ALTER TABLE m_pebisnis ADD fsaldovcr DOUBLE DEFAULT 0

INSERT INTO m_menu( module_name, menu_id, menu_title, menu_title_en, is_active, menu_order, flink, ficon, flevel, fparent, fismenu, fhassub, fpriv) 
VALUES ( '[none]', 'spon_trans_tourint', 'Booking Tour Internasional', '', '1', '8101', '../memstock/tour.php', 'fa-list', '2', 'mdm_pebisnis', '1', '0', 'sponsor');

INSERT INTO m_menu( module_name, menu_id, menu_title, menu_title_en, is_active, menu_order, flink, ficon, flevel, fparent, fismenu, fhassub, fpriv) 
VALUES ( '[none]', 'spon_trans_tourdom', 'Booking Tour Domestik', '', '1', '8102', '../memstock/tourdom.php', 'fa-list', '2', 'mdm_pebisnis', '1', '0', 'sponsor');

INSERT INTO m_menu( module_name, menu_id, menu_title, menu_title_en, is_active, menu_order, flink, ficon, flevel, fparent, fismenu, fhassub, fpriv) 
VALUES ( '[none]', 'spon_trans_umroh', 'Booking Umroh', '', '1', '8103', '../memstock/umroh.php', 'fa-list', '2', 'mdm_pebisnis', '1', '0', 'sponsor');
INSERT INTO m_menu( module_name, menu_id, menu_title, menu_title_en, is_active, menu_order, flink, ficon, flevel, fparent, fismenu, fhassub, fpriv) 
VALUES ( '[none]', 'mdm_trans_mutaspon', 'Mutasi Saldo', '', '1', '8104', '../memstock/ewalletbal.php', 'fa-list', '2', 'mdm_pebisnis', '1', '0', 'sponsor');


INSERT INTO m_menu( module_name, menu_id, menu_title, menu_title_en, is_active, menu_order, flink, ficon, flevel, fparent, fismenu, fhassub, fpriv) 
VALUES ( '[none]', 'mdm_trans_mutakorsub', 'Mutasi Saldo', '', '1', '8104', '../memstock/ewalletbal.php', 'fa-list', '2', 'mdm_korwil_sub', '1', '0', 'korwil;subkorwil;');


INSERT INTO m_menu( module_name, menu_id, menu_title, menu_title_en, is_active, menu_order, flink, ficon, flevel, fparent, fismenu, fhassub, fpriv) 
VALUES ( '[none]', 'mdm_admin_appvwith', 'Approval Withdrawal', '', '1', '2005', '../manager/veriwith.php', 'fa-list', '2', 'mdm_admin', '1', '0', 'administrator');



INSERT INTO m_menu( module_name, menu_id, menu_title, menu_title_en, is_active, menu_order, flink, ficon, flevel, fparent, fismenu, fhassub, fpriv) 
VALUES ( '[none]', 'mdm_admin_appvwith', 'Approval Withdrawal', '', '1', '2005', '../manager/veriwith.php', 'fa-list', '2', 'mdm_admin', '1', '0', 'administrator');




INSERT INTO m_menu( module_name, menu_id, menu_title, menu_title_en, is_active, menu_order, flink, ficon, flevel, fparent, fismenu, fhassub, fpriv) 
VALUES ( '[none]', 'spon_trans_tourint', 'Booking Tour Internasional', '', '1', '8101', '../memstock/tour.php', 'fa-list', '2', 'mdm_pebisnis', '1', '0', 'sponsor');

INSERT INTO m_menu( module_name, menu_id, menu_title, menu_title_en, is_active, menu_order, flink, ficon, flevel, fparent, fismenu, fhassub, fpriv) 
VALUES ( '[none]', 'spon_trans_tourdom', 'Booking Tour Domestik', '', '1', '8102', '../memstock/tourdom.php', 'fa-list', '2', 'mdm_pebisnis', '1', '0', 'sponsor');

INSERT INTO m_menu( module_name, menu_id, menu_title, menu_title_en, is_active, menu_order, flink, ficon, flevel, fparent, fismenu, fhassub, fpriv) 
VALUES ( '[none]', 'spon_trans_umroh', 'Booking Umroh', '', '1', '8103', '../memstock/umroh.php', 'fa-list', '2', 'mdm_pebisnis', '1', '0', 'sponsor');





INSERT INTO m_menu( module_name, menu_id, menu_title, menu_title_en, is_active, menu_order, flink, ficon, flevel, fparent, fismenu, fhassub, fpriv) 
VALUES ( '[none]', 'mdm_trans_tsalkorsub', 'Transfer Saldo', '', '1', '8104', '../memstock/transfer.php', 'fa-list', '2', 'mdm_korwil_sub', '1', '0', 'korwil;subkorwil;');


INSERT INTO m_menu( module_name, menu_id, menu_title, menu_title_en, is_active, menu_order, flink, ficon, flevel, fparent, fismenu, fhassub, fpriv) 
VALUES ( '[none]', 'spon_trans_tsaldo', 'Transfer Saldo', '', '1', '8103', '../memstock/transfer.php', 'fa-list', '2', 'mdm_pebisnis', '1', '0', 'sponsor');


INSERT INTO m_menu( module_name, menu_id, menu_title, menu_title_en, is_active, menu_order, flink, ficon, flevel, fparent, fismenu, fhassub, fpriv) 
VALUES ('[none]', 'mdm_admin_appvwith', 'Approval Transfer Saldo', '', '1', '2005', '../manager/appvtrans.php', 'fa-list', '2', 'mdm_admin', '1', '0', 'administrator');


truncate table tb_mutasi

select * from m_anggota where fidmember in ('JU-2020030009','JU-2020030010','JU-2020030011','JU-2020030012')

select * from m_anggota where fidregistrar='SUBMLG0102'


SELECT fidmember,ftgldaftar FROM m_anggota WHERE ftgldaftar > DATE_SUB(NOW(), INTERVAL 24 HOUR)

SELECT fidmember,ftgldaftar FROM m_anggota where faktif='0'
select fidsys,fidmember from m_anggota where timediff(now(),ftgldaftar) >= '24:00:00' and faktif='0'

select now()


INSERT INTO m_menu(fidsys, module_name, menu_id, menu_title, menu_title_en, is_active, menu_order, flink, ficon, flevel, fparent, fismenu, fhassub, fpriv) 
VALUES ('168', '[none]', 'mdm_admin_lappay', '<font color="#0f0">History Pembayaran</font>', '', '1', '2004', '../manager/rpt_payhistory.php', 'fa-list', '2', 'mdm_admin', '1', '0', 'administrator');

select CONVERT_TZ(NOW(),'SYSTEM', 'Asia/Jakarta')

select CONVERT_TZ(NOW()),'Asia/Calcutta','Asia/Calcutta')

select now()

select fidmember, fnama from m_pebisnis where fidmember like '%adi%' or fnama like '%adi%'


select * from m_menu where menu_title like '%bns%'

UPDATE m_menu SET menu_title = 'Report Referensi' WHERE fidsys = '43';
UPDATE m_menu SET menu_title = 'Top Referensi' WHERE fidsys = '69';
UPDATE m_menu SET menu_title = 'Set Bns Korwil & Referensi' WHERE fidsys = '108';
UPDATE m_menu SET menu_title = 'Posting Bonus Referensi' WHERE fidsys = '114';
UPDATE m_menu SET menu_title = 'Bonus Referensi Terposting' WHERE fidsys = '120';
UPDATE m_menu SET menu_title = '<font color="#0f0">Laporan Referensi</font>' WHERE fidsys = '123';
UPDATE m_menu SET menu_title = 'Diskon Referensi' WHERE fidsys = '124';
UPDATE m_menu SET menu_title = 'User Referensi / Pebisnis' WHERE fidsys = '125';

UPDATE m_menu SET menu_title = 'Trans Espay Disc. Stockist' WHERE fidsys = '85';
UPDATE m_menu SET menu_title = 'Set Disc Korwil & Referensi' WHERE fidsys = '108';

UPDATE m_menu SET menu_title = 'Jamaah Direferensi' WHERE fidsys = '127';
UPDATE m_menu SET menu_title = 'Diskon Referensi by Tgl Brgkt ' WHERE fidsys = '138';
UPDATE m_menu SET menu_title = 'Posting Diskon Referensi SP' WHERE fidsys = '141';
UPDATE m_menu SET menu_title = 'Diskon Referensi by Tgl Brgkt  SP' WHERE fidsys = '142';

UPDATE m_menu SET menu_title = 'History Pencairan' WHERE fidsys = '46';
UPDATE m_menu SET menu_title = 'Pencairan' WHERE fidsys = '146';
UPDATE m_menu SET menu_title = 'Pencairan' WHERE fidsys = '152';
UPDATE m_menu SET menu_title = 'Pencairan' WHERE fidsys = '153';
UPDATE m_menu SET menu_title = 'Approval Pencairan' WHERE fidsys = '156';



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
