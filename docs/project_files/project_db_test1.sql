-- Nathan Ortolan, Becky Williams, Abdul Shaikh, Guthrie Hayward
-- CS 458 - Fall 2016
-- Project - Iteration #1 Testing
--         - testing database functionality
-- Modified :
--            10/23/2016 - ndo28
--            10/25/2016 - ndo28 & rjw125 (Pair Programming)

spool project-db-test1.txt


-- ======================  UNIT TESTING  ======================
prompt
prompt ======================  UNIT TESTING  ======================
prompt

prompt
prompt ==  Testing marine mammal walk database tables   ==
prompt
prompt == Table : Beaches
prompt =
prompt ==
prompt ===
prompt ====
prompt =====    EXPECTED RESULTS :
prompt
prompt   BEAC BEACH_NAME
prompt   ==== =============================================
prompt   AG   Agate
prompt   BK   Baker
prompt   BA   Bay Street to Powerline
prompt   BL   Big Lagoon
prompt   CV   Centerville
prompt   CL   Clam Beach
prompt   CO   College Cove
prompt   CC   Crescent City Beach
prompt   DL   Dry Lagoon
prompt   HP   Houda Point
prompt   IB   Indian
prompt
prompt   BEAC BEACH_NAME
prompt   ==== =============================================
prompt   LU   Luffenholtz
prompt   MA   Ma-lel Dunes to Mad River Parking Lot
prompt   MR   Mad River Parking Lot to Mouth of Mad River
prompt   MN   Manila Community Center to Ma-lel Dunes
prompt   MO   Moonstone
prompt   PB   Pelican State Beach
prompt   PL   Powerline to Manila Community Center
prompt   SS   South Spit
prompt   SL   Stone Lagoon
prompt   TB   Table Bluff
prompt   TR   Trinidad
prompt
prompt   22 rows selected.

prompt
prompt =
prompt ==
prompt ===
prompt ====
prompt =====    ACTUAL RESULTS :
prompt

select *
from Beaches
order by beach_name;


prompt
prompt ==  Testing marine mammal walk database tables   ==
prompt
prompt == Table : Species
prompt =
prompt ==
prompt ===
prompt ====
prompt =====    EXPECTED RESULTS :
prompt
prompt   SPEC SPEC_NAME
prompt   ==== ==============================
prompt   CASL California Sea Lion
prompt   CADO Common Dolphin
prompt   DAPO Dalls Porpoise
prompt   RIDO Dolphin
prompt   GRWH Gray Whale
prompt   GUFS Guadalupe Fur Seal
prompt   HAPO Harbor Porpoise
prompt   HASE Harbor Seal
prompt   ELSE Northern Elephant Seal
prompt   NOFS Northern Fur Seal
prompt   ORCA Orca
prompt
prompt   SPEC SPEC_NAME
prompt   ==== ==============================
prompt   PAWD Pacific White-Sided Dolphin
prompt   SPWH Sperm Whale
prompt   STSL Steller Sea Lion
prompt   UNCE Unidenified Cetacean
prompt   UNDO Unidenified Dolphin
prompt   UNPI Unidenified Pinniped
prompt   UNSE Unidenified Seal
prompt   UNWH Unidenified Whale
prompt   UNSL Unidentified Sea Lion
prompt
prompt   20 rows selected.

prompt
prompt =
prompt ==
prompt ===
prompt ====
prompt =====    ACTUAL RESULTS :
prompt

select *
from Species
order by spec_name;


prompt
prompt ==  Testing marine mammal walk database tables   ==
prompt
prompt == Table : Users
prompt =
prompt ==
prompt ===
prompt ====
prompt =====    EXPECTED RESULTS :
prompt
prompt   HSU_USE USER_FNAME           USER_LNAME
prompt   ======= ==================== ==============================
prompt   USER_EMAIL
prompt   =============================================
prompt   adm000  SYS                  ADMIN
prompt   admin000@humboldt.edu
prompt
prompt   gmh234  Guthrie              Hayward
prompt   gmh234@humboldt.edu
prompt
prompt   ndo28   Nathan               Ortolan
prompt   ndo28@humboldt.edu
prompt
prompt
prompt   HSU_USE USER_FNAME           USER_LNAME
prompt   ======= ==================== ==============================
prompt   USER_EMAIL
prompt   =============================================
prompt   ats234  Abdul                Shaikh
prompt   ats234@humboldt.edu
prompt
prompt   rjw125  Rebecca              Williams
prompt   rjw125@humboldt.edu

prompt
prompt =
prompt ==
prompt ===
prompt ====
prompt =====    ACTUAL RESULTS :
prompt

select hsu_username, user_fname, user_lname, user_email
from Users
order by user_lname;


prompt
prompt ==  Testing marine mammal walk database tables   ==
prompt
prompt == Table : Reports
prompt =
prompt ==
prompt ===
prompt ====
prompt =====    EXPECTED RESULTS :
prompt
prompt   REPORT_ID REPORT_DA
prompt   ========== =========
prompt   SURVEY_SUMMARY
prompt   ================================================================================
prompt       10001 24-OCT-16
prompt   The beach was hella fun
prompt
prompt       10002 26-OCT-16
prompt   The beach was hella fun
prompt
prompt       10003 23-OCT-16
prompt   The beach was hella fun
prompt
prompt
prompt   REPORT_ID REPORT_DA
prompt   ========== =========
prompt   SURVEY_SUMMARY
prompt   ================================================================================
prompt       10004 23-OCT-16
prompt   The beach was hella fun
prompt
prompt       10005 23-OCT-16
prompt   The beach was hella fun

prompt
prompt =
prompt ==
prompt ===
prompt ====
prompt =====    ACTUAL RESULTS :
prompt


select report_id, report_date, survey_summary
from Reports
order by report_id;


prompt
prompt ==  Testing marine mammal walk database tables   ==
prompt
prompt == Table : Report_entries
prompt =
prompt ==
prompt ===
prompt ====
prompt =====    EXPECTED RESULTS :
prompt
prompt   REPORT_ID PRN
prompt   ========== ==============================
prompt   10001 HSU_05OCT2016_LU_ORCA_1_SYS
prompt   10001 HSU_05OCT2016_LU_HASE_2_SYS
prompt   10003 HSU_05OCT2016_MN_GUFS_1_OPP
prompt   10004 HSU_05OCT2016_MA_STSL_1_SYS
prompt   10005 HSU_05OCT2016_CL_UNSE_1_SYS
prompt   10005 HSU_05OCT2016_CL_HAPO_2_SYS
prompt   10005 HSU_05OCT2016_CL_DAPO_3_SYS
prompt
prompt   7 rows selected.

prompt
prompt =
prompt ==
prompt ===
prompt ====
prompt =====    ACTUAL RESULTS :
prompt

select report_id, PRN
from Report_entries
order by report_id;


prompt
prompt ==  Testing marine mammal walk database tables   ==
prompt
prompt == Table : Surveyors
prompt =
prompt ==
prompt ===
prompt ====
prompt =====    EXPECTED RESULTS :
prompt
prompt   HSU_USE  REPORT_ID
prompt   ======= ==========
prompt   ats234       10003
prompt   gmh234       10004
prompt   gmh234       10005
prompt   ndo28        10001
prompt   rjw125       10001
prompt   rjw125       10005
prompt
prompt   6 rows selected.
prompt

prompt
prompt =
prompt ==
prompt ===
prompt ====
prompt =====    ACTUAL RESULTS :
prompt

select *
from Surveyors
order by hsu_username;




-- ======================  ACCEPTANCE TESTING  ======================
prompt
prompt ======================  ACCEPTANCE TESTING  ======================
prompt
-- =============== Query #1 ===============
prompt
prompt ==============    Query #1    ===============
prompt
prompt == Testing admin_report_by_date user story ==
prompt
prompt == A query that returns reports generated  ==
prompt ==           in October 2016               ==
prompt
prompt == Displaying report date, report id, and  ==
prompt ==              report beach               ==
prompt
prompt =
prompt ==
prompt ===
prompt ====
prompt =====    EXPECTED RESULTS :
prompt

prompt   REPORT_DA  REPORT_ID BEACH_NAME
prompt ===================================================================
prompt   24-OCT-16      10001 Mad River Parking Lot to Mouth of Mad River
prompt   26-OCT-16      10002 Powerline to Manila Community Center
prompt   23-OCT-16      10003 Manila Community Center to Ma-lel Dunes
prompt   23-OCT-16      10004 Agate
prompt   23-OCT-16      10005 Trinidad
prompt
prompt =
prompt ==
prompt ===
prompt ====
prompt =====    ACTUAL RESULTS :

select r.report_date, r.report_id, b.beach_name
from Reports r, Beaches b
where (r.beach_abbr = b.beach_abbr) and
      (r.report_date between '01-OCT-16' and '31-OCT-16')
order by report_id;




-- =============== Query #2 ===============
prompt
prompt =================   Query #2   ==================
prompt
prompt == Testing admin_report_by_surveyor user story ==
prompt
prompt == A query that returns all reports in which   ==
prompt ==   surveyor Guthrie Hayward was involved     ==
prompt
prompt == Displaying report date, report id, and      ==
prompt ==              report beach                   ==
prompt
prompt =
prompt ==
prompt ===
prompt ====
prompt =====    EXPECTED RESULTS :
prompt

prompt   Reports by Guthrie Hayward :
prompt
prompt   REPORT_DA  REPORT_ID BEACH_NAME
prompt ===================================================================
prompt   23-OCT-16      10004 Agate
prompt   23-OCT-16      10005 Trinidad
prompt
prompt =
prompt ==
prompt ===
prompt ====
prompt =====    ACTUAL RESULTS :
prompt

prompt Reports by Guthrie Hayward :

select r.report_date, r.report_id, b.beach_name
from Reports r, Beaches b, Users u, Surveyors s
where (r.beach_abbr = b.beach_abbr) and
      (r.report_id = s.report_id) and
      (s.hsu_username = u.hsu_username) and
      (u.user_lname = 'Hayward') and
      (u.user_fname = 'Guthrie');



-- =============== Query #3 ===============
prompt
prompt =================    Query #3    ==================
prompt
prompt == Testing admin_report_by_coordinate user story ==
prompt
prompt ==  A query that returns all reports sorted by   ==
prompt ==   their coordinates (increasing latitude)     ==
prompt
prompt ==      Displaying report date, report id        ==
prompt ==       report beach, report entry PRN          ==
prompt ==         and report entry latitude/s           ==
prompt
prompt =
prompt ==
prompt ===
prompt ====
prompt =====    EXPECTED RESULTS :
prompt
prompt   PRN                              LATITUDE REPORT_DA
prompt ===================================================================
prompt   BEACH_NAME
prompt ===================================================================
prompt   HSU_05OCT2016_MN_GUFS_1_OPP     40.851112 23-OCT-16
prompt   Manila Community Center to Ma-lel Dunes
prompt
prompt   HSU_05OCT2016_MA_STSL_1_SYS     40.869188 23-OCT-16
prompt   Agate
prompt
prompt   HSU_05OCT2016_CL_HAPO_2_SYS     40.994815 23-OCT-16
prompt   Trinidad
prompt
prompt
prompt   PRN                              LATITUDE REPORT_DA
prompt ===================================================================
prompt   BEACH_NAME
prompt ===================================================================
prompt   HSU_05OCT2016_CL_UNSE_1_SYS     40.994816 23-OCT-16
prompt   Trinidad
prompt
prompt   HSU_05OCT2016_CL_DAPO_3_SYS     40.994828 23-OCT-16
prompt   Trinidad
prompt
prompt   HSU_05OCT2016_LU_ORCA_1_SYS     41.040519 24-OCT-16
prompt   Mad River Parking Lot to Mouth of Mad River
prompt
prompt
prompt   PRN                              LATITUDE REPORT_DA
prompt ===================================================================
prompt   BEACH_NAME
prompt ===================================================================
prompt   HSU_05OCT2016_LU_HASE_2_SYS      41.05052 24-OCT-16
prompt   Mad River Parking Lot to Mouth of Mad River
prompt
prompt =
prompt ==
prompt ===
prompt ====
prompt =====    ACTUAL RESULTS :


select e.PRN, e.latitude, r.report_date, b.beach_name
from Reports r, Beaches b, Report_entries e
where (r.beach_abbr = b.beach_abbr) and
      (r.report_id = e.report_id)
order by e.latitude;



spool off
