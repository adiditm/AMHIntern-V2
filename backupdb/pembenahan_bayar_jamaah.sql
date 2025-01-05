select fidmember, count(fdesc) as setoran_awal from tb_payhist where fdesc ='Setoran Awal' group by fidmember order by count(fdesc)  desc, fidmember


select * from tb_payhist where fidmember IN ('JH-2022010015','JU-2019120284','JU-2020010002','JU-2020010012','JU-2020010031','JU-2020020004','JU-2020020007','JU-2020020011','JU-2020020013','JU-2020020014','JU-2020020019','JU-2020030001','JU-2020030002','JU-2020030009','JU-2020030010','JU-2020030011','JU-2020030012','JU-2020030013','JU-2020030036','JU-2020030039','JU-2020030040','JU-2020060001','JU-2020070002','JU-2020070004','JU-2021030002','JU-2021030003','JU-2021100004','JU-2021100005','JU-2021100007','JU-2021100008','JU-2022010017','JU-2022040012','JU-2022040016','JU-2022060024','JU-2023010002','JU-2023010003','JU-2023010019') and fdesc ='Setoran Awal'  order by fidmember
select * from tb_payment where fidmember IN ('JU-2020020011')
select * from tb_payhist where fidmember IN ('JU-2020010002')

select * from m_anggota where fidmember IN ('JH-2022010015','JU-2019120284','JU-2020010002','JU-2020010012','JU-2020010031','JU-2020020004','JU-2020020007','JU-2020020011','JU-2020020013','JU-2020020014','JU-2020020019','JU-2020030001','JU-2020030002','JU-2020030009','JU-2020030010','JU-2020030011','JU-2020030012','JU-2020030013','JU-2020030036','JU-2020030039','JU-2020030040','JU-2020060001','JU-2020070002','JU-2020070004','JU-2021030002','JU-2021030003','JU-2021100004','JU-2021100005','JU-2021100007','JU-2021100008','JU-2022010017','JU-2022040012','JU-2022040016','JU-2022060024','JU-2023010002','JU-2023010003','JU-2023010019') order by fidmember

select fidmember from tb_payhist where fidmember not in (select fidmember from m_anggota)

select fidmember,fnama,fairporttax,fassure,fprice, fairporttax+fassure+fprice 
as fsemua,fstorawal,fangsur1,fangsur2,fangsur3,fangsur4,flunas,ftotalbayar,ftglaktif from m_anggota 
where fidmember IN ('JU-2023010019');

select * from tb_payhist where fidmember IN ('JU-2023010019');
select * from tb_payment where fidmember IN ('JU-2023010019');

select 3621775.00 + 1500000 +  140000

---delete from tb_payhist where fidmember not in (select fidmember from m_anggota)
delete from tb_payhist where fidsys IN ('1291','1329','1330')



JU-2019120284   masih pertanyaan

select 13154000+9000000+8700000

INSERT INTO tb_rules_config( fidrule, fsetname, fsetval, fsetadd1, fket, ftglupdate, fcompany, factive) VALUES ( '1', 'fsponfee', '150000', '', 'Fee Bonus Sponsor Pulsa & PPOB', null, 'mdm', '1');