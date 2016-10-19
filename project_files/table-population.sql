--Rebecca Williams
--Nathan Ortolan
--Guthrie Hayward
--Abdul Shaikh
-- CS 458 - Fall 2016
-- Last Edited 10/16/16

spool table-population-status.txt

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
  values ('ats234','Shaikh','Abdul','ats234@humboldt.edu','root','N','Y');
insert into Users
  values ('ndo28','Ortolan','Nathan','ndo28@humboldt.edu','root','N','Y');
insert into Users
  values ('gmh234','Hayward','Guthrie','gmh234@humboldt.edu','root','N','Y');
insert into Users
  values ('rjw125','Williams','Rebecca','rjw125@humboldt.edu','root','N','Y');
insert into Users
  values ('admin000','ADMIN','SYS','admin000@humboldt.edu','admin','Y','N');

insert into Reports
  values (10001,SYSDATE,SYSDATE+1,'MR','The beach was hella fun');
insert into Reports
  values (10002,SYSDATE,SYSDATE+3,'PL','The beach was hella fun');
insert into Reports
  values (10003,SYSDATE,SYSDATE,'MN','The beach was hella fun');
insert into Reports
  values (10004,SYSDATE,SYSDATE,'AG','The beach was hella fun');
insert into Reports
  values (10005,SYSDATE,SYSDATE,'TR','The beach was hella fun');
insert into Reports
  values (10006,SYSDATE,SYSDATE,'CO','The beach was hella fun');
insert into Reports
  values (10007,SYSDATE,SYSDATE,'DL','The beach was hella fun');
insert into Reports
  values (10008,SYSDATE,SYSDATE,'SL','The beach was hella fun');
insert into Reports
  values (10009,SYSDATE,SYSDATE,'BA','The beach was hella fun');
insert into Reports
  values (10010,SYSDATE,SYSDATE,'BL','The beach was hella fun');
insert into Reports
  values (10011,SYSDATE,SYSDATE,'CO','The beach was hella fun');
insert into Reports
  values (10012,SYSDATE,SYSDATE,'CC','The beach was hella fun');


commit;

spool off
