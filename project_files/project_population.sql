--Rebecca Williams
--Nathan Ortolan
--Guthrie Hayward
--Abdul Shaikh
-- CS 458 - Fall 2016
-- Last Edited 10/16/16

spool project-population-out.txt

/*
Populating Beaches table
*/
insert into Beaches
   values ('CV','Centerville');
insert into Beaches
    values('TB','Table Bluff');
insert into Beaches
    values('SS','South Spit');
insert into Beaches
    values('BA','Bay Street to Powerline');
insert into Beaches
    values('PL','Powerline to Manila Community Center');
insert into Beaches
    values('MN','Manila Community Center to Ma-lel Dunes');
insert into Beaches
    values('MA','Ma-lel Dunes to Mad River Parking Lot');
insert into Beaches
    values('MR','Mad River Parking Lot to Mouth of Mad River');
insert into Beaches
    values('CL','Clam Beach');
insert into Beaches
    values('MO','Moonstone');
insert into Beaches
    values('HP','Houda Point');
insert into Beaches
    values('LU','Luffenholtz');
insert into Beaches
    values('BK','Baker');
insert into Beaches
    values('IB','Indian');
insert into Beaches
    values('TR','Trinidad');
insert into Beaches
    values('CO','College Cove');
insert into Beaches
    values('AG','Agate');
insert into Beaches
    values('BL','Big Lagoon');
insert into Beaches
    values('DL','Dry Lagoon');
insert into Beaches
    values('SL','Stone Lagoon');
insert into Beaches
    values('CC','Crescent City Beach');
insert into Beaches
    values('PB','Pelican State Beach');


insert into Species
    values('CASL','California Sea Lion');
insert into Species
    values('STSL','Steller Sea Lion');
insert into Species
    values('NOFS','Northern Fur Seal');
insert into Species
    values('GUFS','Guadalupe Fur Seal');
insert into Species
    values('ELSE','Northern Elephant Seal');
    insert into Species
    values('HASE','Harbor Seal');
insert into Species
    values('UNSL','Unidentified Sea Lion');
insert into Species
    values('UNSE','Unidenified Seal');
insert into Species
      values('UNPI','Unidenified Pinniped');

insert into Species
    values ('HAPO','Harbor Porpoise');
insert into Species
    values ('DAPO','Dalls Porpoise');
insert into Species
    values ('PAWD','Pacific White-Sided Dolphin');
insert into Species
    values ('CADO','Common Dolphin');
insert into Species
    values ('RIDO','Dolphin');
insert into Species
    values ('ORCA','Orca');
insert into Species
    values ('GRWH','Gray Whale');
insert into Species
    values ('SPWH','Sperm Whale');
insert into Species
    values ('UNDO','Unidenified Dolphin');
insert into Species
    values ('UNWH','Unidenified Whale');
insert into Species
    values ('UNCE','Unidenified Cetacean');

insert into Users
  values ('ats234','AS','Shaikh','Abdul','ats234@humboldt.edu','root','N','Y');
insert into Users
  values ('ndo28','NO','Ortolan','Nathan','ndo28@humboldt.edu','root','N','Y');
insert into Users
  values ('gmh234','GH','Hayward','Guthrie','gmh234@humboldt.edu','root','N','Y');
insert into Users
  values ('rjw125','RW','Williams','Rebecca','rjw125@humboldt.edu','root','N','Y');
insert into Users
  values ('adm000','AD','ADMIN','SYS','admin000@humboldt.edu','admin','Y','N');

insert into Reports
  values (10001,'01:30','04:30',SYSDATE+1,'MR','The beach was hella fun');
insert into Reports
  values (10002,'01:30','04:30',SYSDATE+3,'PL','The beach was hella fun');
insert into Reports
  values (10003,'01:30','04:30',SYSDATE,'MN','The beach was hella fun');
insert into Reports
  values (10004,'01:30','04:30',SYSDATE,'AG','The beach was hella fun');
insert into Reports
  values (10005,'01:30','04:30',SYSDATE,'TR','The beach was hella fun');




insert into Report_entries
   values ('HSU_05OCT2016_LU_ORCA_1_SYS', 'ndo28', 10001, 'ORCA', 41.040519, -124.120278, 'y', 'y', 'y', 'blah', 'humboldt.edu', 1 );
insert into Report_entries
   values ('HSU_05OCT2016_LU_HASE_2_SYS', 'rjw125', 10001, 'HASE', 41.050520, -124.120271, 'n', 'n', 'y', 'blah', 'google.com', 2 );
insert into Report_entries
   values ('HSU_05OCT2016_MN_GUFS_1_OPP', 'ats234', 10003, 'GUFS', 40.851112, -124.168776, 'n', 'n', 'y', 'blah', 'humboldt.edu', 1 );
insert into Report_entries
   values ('HSU_05OCT2016_MA_STSL_1_SYS', 'gmh234', 10004, 'STSL', 40.869188, -124.157745, 'y', 'n', 'y', 'blah', 'google.com', 1 );
insert into Report_entries
   values ('HSU_05OCT2016_CL_UNSE_1_SYS', 'gmh234', 10005, 'UNSE', 40.994816, -124.110487, 'n', 'y', 'n', 'blah', 'humboldt.edu', 1 );
insert into Report_entries
   values ('HSU_05OCT2016_CL_HAPO_2_SYS', 'rjw125', 10005, 'HAPO', 40.994815, -124.110482, 'y', 'n', 'y', 'blah', 'google.com', 2 );
insert into Report_entries
   values ('HSU_05OCT2016_CL_DAPO_3_SYS', 'gmh234', 10005, 'DAPO', 40.994828, -124.110533, 'y', 'n', 'y', 'blah', 'humboldt.edu', 3 );



insert into Surveyors
  values ('ndo28',10001);
insert into Surveyors
  values ('rjw125',10001);
insert into Surveyors
  values ('ats234',10003);
insert into Surveyors
  values ('gmh234',10004);
insert into Surveyors
  values ('gmh234',10005);
insert into Surveyors
  values ('rjw125',10005);








commit;

spool off
