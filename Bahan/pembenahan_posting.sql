select a.fidmember, a.fnama from m_anggota a left join tb_payhist b on a.fidmember=b.fidmember where 
concat(a.fprop,a.fkota,a.fkec) in (select concat(a.fprop,a.fkabkota,a.fkec) as farea from tb_korwil_area a left join m_korwil 
b on a.fidkorwil=b.fidkorwil where a.fidkorwil='MLG02' )  and a.fpaket='REQ' and flunas > 0 and 
a.faktif='1' and b.fkind like '%lunas' and date(b.ftanggal) between '2019-12-01' and '2019-12-31' 


select * from tb_payhist where fidmember='JU-2023010019'
select * from m_anggota where fidmember='JU-2023010019'

select * from tb_payment where fidmember='JU-2023010019'


select * from m_anggota concat(a.fprop,a.fkota,a.fkec) 
in (select concat(a.fprop,a.fkabkota,a.fkec) as farea from 
tb_korwil_area a left join m_korwil b on a.fidkorwil=b.fidkorwil where a.fidkorwil='MLG02' ) 



select * from m_anggota a where a.fpaket='REQ' and a.fprogram='1' and concat(a.fprop,a.fkota,a.fkec) in (select concat(a.fprop,a.fkabkota,a.fkec) as farea from 
tb_korwil_area a left join m_korwil b on a.fidkorwil=b.fidkorwil where  a.fidkorwil='MLG02' ) 


select * from m_anggota a where concat(a.fprop,a.fkota,a.fkec) in (select concat(a.fprop,a.fkabkota,a.fkec) as farea from 
tb_korwil_area a left join m_korwil b on a.fidkorwil=b.fidkorwil where a.fidkorwil='MLG02' ) 


select curr_code from m newtrh_ioc



INSERT INTO amhtechn_intern.m_anggota
	(fidsys, fidmember, fidjamaah, fjenis, fstorawal, fangsur1, fangsur2, fangsur3, fangsur4, flunas, ftotalbayar, frefer, fnama, fnohp, fnamabank, fnorekening, ftempat, ftgllahir, falamat, fkota, fkodepos, fprop, femail, fpassword, fpaspor, fnamarefer, faktif, ftglaktif, fatasnama, fkotabank, ftgldaftar, fstatusrow, ftglentry, fcount, fcabbank, fcountrybank, fswift, flastuser, flastupdate, ftitle, fsex, fnation, ffoto, fdoc, fnoktp, fcountry, fket, fnpwp, fpasscntid, fpassno, fpassrelease, fpassexpired, fpassnoreg, fpassoffice, fpasssign, ftgldepart, frelation, fnik, feducation, fjob, fpaket, fpaketday, fjenpay, fprogram, flastactive, fprice, fairporttax, fassure, fkakek, fayah, fkec, fdes, focname, focktp, focjenkel, focalamat, foctelp, fochp, focrelation, fbring, fbringdoc, fcheckidentdoc, fcheckident, fumur, fmuhrim, fusername, fkurslunas, fidregistrar, fpromo, fnohprefer, fnoktprefer, fnamabuss, fnohpbuss, fnoktpbuss, farabassure, fwarisbuss, fprod)
VALUES 
	('', '', '', '', , , , , , , , '', '', '', '', '', '', , '', '', '', '', '', '', '', '', '', , '', '', , '', , '', '', '', '', '', , '', '', '', '', '', '', '', '', '', '', '', , , '', '', '', , '', '', '', '', '', '', '', '', , , , , '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', , '', '', , '', '', '', '', '', '', '', , '', '');