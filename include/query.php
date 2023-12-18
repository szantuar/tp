<?php

return [
//change
'query_1' => "SELECT stand.id_stand, setlist.description, model.name, stand.name AS stand FROM ((setlist INNER JOIN stand ON setlist.uid_stand = stand.id_stand) INNER JOIN model ON setlist.model = model.id_model) WHERE setlist.is_use = 1 AND setlist.status = 1 ORDER BY stand.name ASC;",

'query_2' => "SELECT id_user, name, password, status FROM users WHERE UPPER(name) = UPPER(:name);",

'query_3' => "SELECT * FROM user_access WHERE uid_user = :id_acc;",

'query_4' => "SELECT setlist.id_set, client.name AS model_client, model.name AS model, setlist.description, setlist.date_create, users.name AS user_name, setlist.is_use, stand.name AS stand_name, setlist.status, (SELECT count(parts_set.is_damaged) FROM parts_set WHERE setlist.id_set = parts_set.id_set AND (parts_set.is_damaged = 1 OR parts_set.is_damaged = 2) AND parts_set.status = 1) AS damaged FROM ((((setlist INNER JOIN model ON setlist.model = model.id_model) INNER JOIN client ON client.id_client = model.uid_client) INNER JOIN stand ON stand.id_stand = setlist.uid_stand) INNER JOIN users ON users.id_user = setlist.id_user_make) WHERE setlist.status = 1;", 

'query_5' => "SELECT * FROM stand WHERE id_stand = :stand LIMIT 1;",

'query_6' => "UPDATE setlist SET uid_stand = :id_stand, is_use = 0 WHERE id_set = :id_set LIMIT 1;",

'query_7' => "UPDATE setlist SET uid_stand = :id_stand, is_use = 1 WHERE id_set = :id_set LIMIT 1;", 

'query_8' => "INSERT INTO set_use_history (id_set, date_transaction, type_transaction, uid_stand, uid_user) VALUES (:id_set, :actual_date, 3, :id_stand, :id_user);", 

'query_9' => "SELECT * FROM stand WHERE status = 1 ORDER BY name ASC;",

'query_10' => "SELECT * FROM model WHERE id_model = :model AND status = 1;",

'query_11' => "SELECT * FROM stand WHERE id_stand = :stand LIMIT 1;",

'query_12' => "INSERT INTO setlist (model, description, date_create, id_user_make, date_finish, id_user_finish,	is_use, uid_stand, status) VALUES (:model, :desc, :date, :id_user, null, null, 1, :stand, 1);",

'query_13' => "INSERT INTO setlist (model, description, date_create, id_user_make, date_finish, id_user_finish,	is_use, uid_stand, status) VALUES (:model, :desc, :date, :id_user, null, null, 0, :stand, 1);",

'query_14' => "INSERT INTO set_use_history (id_set, date_transaction, type_transaction, uid_stand, uid_user) VALUES (:set, :date,  4, :stand, :id_user);",

'query_15' => "SELECT * FROM stand ORDER BY name ASC;", 

'query_16' => "SELECT * FROM model WHERE status = 1 ORDER BY name ASC;", 

'query_17' => "SELECT id_set, description status FROM setlist WHERE id_set = :id_set AND status = 1;",

'query_18' => "SELECT parts_set.id_parts, parts_set.id_set, parts_history.id_pn, parts_history.sn, parts_set.id_history_parts FROM parts_set INNER JOIN parts_history ON parts_set.id_history_parts = parts_history.id_history WHERE parts_set.id_set = :id_set AND parts_set.status = 1",

'query_19' => "SELECT part_number, description FROM part_master WHERE id = :id_pn;",

'query_20' => "SELECT part_master.id, part_master.part_number, part_master.description, inventory.qty, localization.name FROM ((part_master INNER JOIN inventory ON part_master.id = inventory.master_id) INNER JOIN localization ON inventory.loc_id = localization.id) WHERE part_master.part_number = :pn AND (inventory.stock_room_id = 1 OR inventory.stock_room_id = 3 OR inventory.stock_room_id = 12)",

'query_21' => "UPDATE parts_undercheck SET status = 0 WHERE id_history_parts = :old_hist;",

'query_22' => "UPDATE parts_set SET id_history_parts = :id_history, id_set = :id_set, status = 1, is_damaged = 2 WHERE status = 0 LIMIT 1;",

'query_23' => "INSERT INTO parts_set (id_set, id_history_parts, is_damaged, status) VALUES (:id_set, :id_history, 2, 1);",

'query_24' => "SELECT * FROM parts_history WHERE id_history = :id_his;",

'query_25' => "INSERT INTO  parts_history(id_set, id_pn, sn, type_transaction, date_create, id_user) VALUES (:id_set, :id_pn, :sn, 6, :date, :id_user);", 

'query_26' => "UPDATE parts_set SET id_history_parts = :new_history WHERE id_history_parts = :old_history;", 

'query_27' => "SELECT * FROM parts_history WHERE id_history = :id_his;",

'query_28' => "SELECT * FROM parts_set WHERE id_set = :id_set AND id_history_parts = :id_his AND status = 1 and is_damaged = 1;",

'query_29' => "UPDATE parts_undercheck SET status = 2 WHERE id_history_parts = :id_hist AND status = 1;",

'query_30' => "UPDATE parts_set SET status = 0 WHERE id_history_parts = :old_history;",

'query_31' => "SELECT * FROM parts_set WHERE id_set = :id_set AND status = 1 and is_damaged = 1;",

'query_32' => "SELECT parts_set.id_history_parts, parts_set.id_parts, parts_set.id_set, parts_set.status, parts_history.id_pn, parts_history.sn FROM (parts_set INNER JOIN parts_history ON parts_set.id_history_parts = parts_history.id_history) WHERE parts_set.id_set = :id_set AND parts_set.status = 1;",

'query_33' => "UPDATE setlist SET date_finish = :finish_time, id_user_finish = :user, status = 0, is_use = 0, uid_stand = 1 WHERE id_set = :id_set;",

'query_34' => "INSERT INTO set_use_history (id_set, date_transaction, type_transaction, uid_stand, uid_user) VALUES (:id_set, :date, 8, 1, :user);",

'query_35' => "UPDATE parts_set SET status = 0 WHERE id_parts = :id_parts;",

'query_36' => "UPDATE parts_undercheck SET type_transaction = :type, id_history_parts = :new_history WHERE id_history_parts = :id_hist;",

'query_37' => "SELECT * FROM setlist WHERE uid_stand = :stand AND is_use = 1 AND status = 1;",

'query_38' => "SELECT parts_set.id_parts, parts_set.id_set, parts_history.id_pn, parts_history.sn, parts_set.id_history_parts, parts_set.is_damaged FROM parts_set INNER JOIN parts_history ON parts_set.id_history_parts = parts_history.id_history WHERE parts_set.id_set = :id_set AND parts_set.status = 1",

'query_39' => "SELECT id_user, name, status FROM users WHERE name = :user OR id_user = :id_acc;",

'query_40' => "SELECT * FROM parts_history WHERE id_history = :id_hist LIMIT 1",

'query_41' => "SELECT * FROM parts_set WHERE id_history_parts = :id_hist AND is_damaged = 0 AND status = 1;",

'query_42' => "SELECT parts_undercheck.id_history_parts, parts_history.id_pn, parts_history.sn, parts_history.id_set, parts_history.date_create, parts_undercheck.type_transaction FROM (parts_undercheck INNER JOIN parts_history ON parts_history.id_history = parts_undercheck.id_history_parts) WHERE parts_undercheck.status <> 0 AND (parts_undercheck.type_transaction = 12 or parts_undercheck.type_transaction = 13) AND UPPER(parts_history.sn) LIKE UPPER(CONCAT('%', :search, '%')) ORDER BY parts_history.date_create DESC;",

'query_43' => "UPDATE parts_undercheck SET type_transaction = :type, id_history_parts = :id_hist, date_create = :date, status = 1 WHERE status = 0 LIMIT 1;",

'query_44' => "INSERT INTO parts_undercheck (id_history_parts, type_transaction, date_create, status) VALUES (:id_hist, :type, :date, 1);",

'query_45' => "UPDATE parts_set SET is_damaged = 1, id_history_parts = :id_hist WHERE id_history_parts = :old_history LIMIT 1;",

'query_46' => "SELECT parts_undercheck.id_history_parts, parts_history.id_pn, parts_history.sn, parts_history.id_set, parts_undercheck.status, parts_history.date_create FROM (parts_undercheck INNER JOIN parts_history ON parts_history.id_history = parts_undercheck.id_history_parts) WHERE parts_undercheck.status <> 0 AND (parts_undercheck.type_transaction = 10 OR parts_undercheck.type_transaction = 21) order by parts_history.date_create DESC;",

'query_47' => "SELECT parts_undercheck.id_history_parts, parts_history.id_pn, parts_history.sn, parts_history.id_set, parts_history.date_create, parts_undercheck.type_transaction FROM (parts_undercheck INNER JOIN parts_history ON parts_history.id_history = parts_undercheck.id_history_parts) WHERE parts_undercheck.status <> 0 AND (parts_undercheck.type_transaction = 12 or parts_undercheck.type_transaction = 13) ORDER BY parts_history.date_create DESC;",

'query_48' => "UPDATE parts_set SET id_history_parts = :id_hist, is_damaged = 0 WHERE id_history_parts = :old_hist;",

'query_49' => "SELECT count(status) as qty FROM parts_undercheck WHERE status <> 0 AND (type_transaction = 12 or type_transaction = 13);",

'query_50' => "UPDATE parts_undercheck SET id_history_parts = :id_hist, type_transaction = 11 WHERE id_history_parts = :old_hist;",

'query_51' => "SELECT parts_undercheck.id_history_parts, parts_history.id_pn, parts_history.sn, parts_history.id_set, parts_history.date_create FROM (parts_undercheck INNER JOIN parts_history ON parts_history.id_history = parts_undercheck.id_history_parts) WHERE parts_undercheck.status <> 0 AND parts_undercheck.type_transaction = 11 order by parts_history.date_create DESC;",

'query_52' => "SELECT parts_undercheck.id_history_parts, parts_history.id_pn, parts_history.sn, parts_history.id_set, parts_history.date_create, parts_undercheck.type_transaction FROM (parts_undercheck INNER JOIN parts_history ON parts_history.id_history = parts_undercheck.id_history_parts) WHERE parts_undercheck.status <> 0 AND (parts_undercheck.type_transaction = 25 or parts_undercheck.type_transaction = 26) ORDER BY parts_history.date_create DESC;",

'query_53' => "UPDATE parts_undercheck SET status = 0 WHERE id_history_parts = :id_hist;",

'query_54' => "SELECT part_master.id, part_master.part_number, part_master.description, (SELECT SUM(inventory.qty) FROM inventory WHERE inventory.master_id = part_master.id AND (inventory.stock_room_id = 1 OR inventory.stock_room_id = 3 OR inventory.stock_room_id = 12)) AS qty FROM part_master WHERE part_master.part_number = :pn;",

'query_55' => "SELECT password FROM users WHERE id_user = :id_acc;",

'query_56' => "UPDATE users SET password = :pass WHERE id_user = :id_acc;",

'query_57' => "SELECT name FROM users WHERE name = :name",

'query_58' =>"INSERT INTO users (name, password, date_create, status) VALUES (:name, :pass, :date, 1);",

'query_59' => "INSERT INTO user_access (uid_user, setlist, newset, standchange, setedit, setremove, demand, QA, password, newuser, newmodel, newstand, resetpassword, addaccess) VALUES (:id_acc, 0, 0, 0, 0, 0, 0, 0, 1, 0, 0, 0, 0, 0);",

'query_60' => "SELECT name FROM model WHERE name = :name;",

'query_61' => "SELECT id_client, name FROM client WHERE id_client = :id_client;",

'query_62' => "INSERT INTO model (uid_client, name, status) VALUES (:client, :name, 1);",

'query_63' => "SELECT name FROM stand WHERE name = :name;",

'query_64' => "INSERT INTO stand (name, status) VALUES (:name, 1);",

'query_65' => "UPDATE users SET password = :pass WHERE id_user = :id_user;",

'query_66' => "SELECT users.name, users.id_user, user_access.setlist, user_access.newset, user_access.standchange, user_access.setedit, user_access.setremove, user_access.demand, user_access.QA, user_access.password, user_access.newuser, user_access.newmodel, user_access.newstand, user_access.resetpassword, user_access.addaccess FROM (user_access INNER JOIN users ON user_access.uid_user = users.id_user) ORDER BY users.name ASC;",

'query_67' => "SELECT id_user FROM users WHERE id_user = :id_user;",

'query_68' => "SELECT * FROM access_list WHERE access_table = :access;",

'query_69' => "SELECT * FROM user_access WHERE uid_user = :id_user",

'query_70' => "INSERT INTO access_history (uid_access, gid_user, uid_user, date_create, type_transaction) VALUES (:access, :gid_user, :uid_user, :date, :status);",
    
'query_71' => "SELECT setlist.id_set, client.name AS model_client, model.name AS model, setlist.description, setlist.date_create, users.name AS user_name, setlist.is_use, stand.name AS stand_name, setlist.status, (SELECT count(parts_set.is_damaged) FROM parts_set WHERE setlist.id_set = parts_set.id_set AND (parts_set.is_damaged = 1 OR parts_set.is_damaged = 2) AND parts_set.status = 1) AS damaged FROM ((((setlist INNER JOIN model ON setlist.model = model.id_model) INNER JOIN client ON client.id_client = model.uid_client) INNER JOIN stand ON stand.id_stand = setlist.uid_stand) INNER JOIN users ON users.id_user = setlist.id_user_make) WHERE setlist.status = 1 AND UPPER(setlist.description) LIKE UPPER(CONCAT('%', :search, '%'));",

'query_72' => "SELECT stand.id_stand, setlist.description, model.name, stand.name AS stand FROM ((setlist INNER JOIN stand ON setlist.uid_stand = stand.id_stand) INNER JOIN model ON setlist.model = model.id_model) WHERE setlist.is_use = 1 AND setlist.status = 1 AND UPPER(stand.name) LIKE UPPER(CONCAT('%', :search, '%')) ORDER BY stand.name ASC;",

'query_73' => "SELECT parts_undercheck.id_history_parts, parts_history.id_pn, parts_history.sn, parts_history.id_set, parts_undercheck.status, parts_history.date_create FROM (parts_undercheck INNER JOIN parts_history ON parts_history.id_history = parts_undercheck.id_history_parts) WHERE parts_undercheck.status <> 0 AND (parts_undercheck.type_transaction = 10 OR  parts_undercheck.type_transaction = 21) AND UPPER(parts_history.sn) LIKE UPPER(CONCAT('%', :search, '%')) ORDER BY parts_history.date_create DESC;",

'query_74' => "SELECT parts_undercheck.id_history_parts, parts_history.id_pn, parts_history.sn, parts_history.id_set, parts_history.date_create FROM (parts_undercheck INNER JOIN parts_history ON parts_history.id_history = parts_undercheck.id_history_parts) WHERE parts_undercheck.status <> 0 AND parts_undercheck.type_transaction = 11 AND UPPER(parts_history.sn) LIKE UPPER(CONCAT('%', :search, '%')) ORDER BY parts_history.date_create DESC;",

'query_75' => "SELECT model.id_model, client.name AS client, model.name, model.status FROM (model INNER JOIN client ON model.uid_client = client.id_client) ORDER BY model.name ASC;",
 
'query_76' => "SELECT model.id_model, client.name AS client, model.name, model.status FROM (model INNER JOIN client ON model.uid_client = client.id_client) WHERE UPPER(model.name) LIKE UPPER(CONCAT('%', :search, '%')) ORDER BY model.name ASC;",
    
'query_77' => "SELECT id_model, status FROM model WHERE id_model = :id;",
    
'query_78' => "UPDATE model SET status = :status WHERE id_model = :id_model",
    
'query_79' => "INSERT INTO model_history (id_model, date_transaction, type_transaction, id_user) VALUES (:id_model, :date, :type, :id_acc);",

'query_80' => "SELECT id_stand, name, status FROM stand WHERE UPPER(name) LIKE UPPER(CONCAT('%', :search, '%')) ORDER BY name ASC;", 
    
'query_81' => "SELECT id_stand, name, status FROM stand WHERE id_stand = :id;",
    
'query_82' => "UPDATE stand SET status = :status WHERE id_stand = :id_stand",
    
'query_83' => "INSERT INTO stand_history (id_stand, date_transaction, type_transaction, id_user) VALUES (:id_stand, :date, :type, :id_acc);",

'query_84' => "INSERT INTO user_history (uid_user, date_transaction, type_transaction, id_user) VALUES (:uid_user, :date, :type, :id_acc);",
    
'query_85' => "SELECT id_user, name, status FROM users ORDER BY name ASC;",

'query_86' => "SELECT id_user, name, status FROM users WHERE UPPER(name) LIKE UPPER(CONCAT('%', :search, '%'))  ORDER BY name ASC;",

'query_87' => "SELECT id_user, name, status FROM users WHERE id_user = :id_user;",

'query_88' => "UPDATE users SET status = :status WHERE id_user = :id_user",
    
'query_89' => "SELECT users.name, users.id_user, user_access.setlist, user_access.newset, user_access.standchange, user_access.setedit, user_access.setremove, user_access.demand, user_access.QA, user_access.password, user_access.newuser, user_access.newmodel, user_access.newstand, user_access.resetpassword, user_access.addaccess FROM (user_access INNER JOIN users ON user_access.uid_user = users.id_user) WHERE UPPER(users.name) LIKE UPPER(CONCAT('%', :search, '%'))  ORDER BY users.name ASC;",

'query_90' => "SELECT id_set, model, status FROM setlist WHERE model = :id_model AND status = 1;",

'query_91' => "SELECT id_set, uid_stand, status FROM setlist WHERE uid_stand = :id_stand AND status = 1;",

'query_92' => "SELECT parts_history.sn FROM (parts_set INNER JOIN parts_history ON parts_set.id_history_parts = parts_history.id_history) WHERE parts_set.status = 1 AND parts_history.sn = :sn;",

'query_93' => "SELECT parts_history.sn FROM (parts_undercheck INNER JOIN parts_history ON parts_undercheck.id_history_parts = parts_history.id_history) WHERE parts_undercheck.status = 1 AND parts_history.sn = :sn;",

'query_94' => "SELECT sn, date_create, type_transaction FROM parts_history WHERE sn = :sn AND type_transaction < 14 ORDER BY date_create DESC LIMIT 1",

'query_95' => "SELECT count(status) as qty FROM parts_undercheck WHERE (type_transaction = 10 OR type_transaction = 21) AND status <> 0;",

'query_96' => "SELECT count(status) as qty FROM parts_undercheck WHERE status <> 0 AND type_transaction = 11;",

'query_97' => "SELECT parts_undercheck.id_history_parts, parts_history.id_pn, parts_history.sn, parts_history.id_set, parts_history.date_create, parts_undercheck.type_transaction FROM (parts_undercheck INNER JOIN parts_history ON parts_history.id_history = parts_undercheck.id_history_parts) WHERE parts_undercheck.status <> 0 AND (parts_undercheck.type_transaction = 25 or parts_undercheck.type_transaction = 26) AND UPPER(parts_history.sn) LIKE UPPER(CONCAT('%', :search, '%')) ORDER BY parts_history.date_create DESC;",

'query_98' => "INSERT INTO parts_undercheck (id_history_parts, type_transaction, date_create, status) VALUES (:id_hist, 21, :date, 1);",

'query_99' => "UPDATE parts_undercheck SET type_transaction = 21, id_history_parts = :id_hist, date_create = :date, status = 1 WHERE status = 0 LIMIT 1;",

'query_100' => "UPDATE parts_undercheck SET status = 0 WHERE id_history_parts = :old_history;",

'query_101' => "SELECT id_set, id_pn, sn, date_create, type_transaction FROM parts_history WHERE sn = :sn ORDER BY date_create DESC LIMIT 1",

'query_102' => "INSERT INTO parts_history (id_set, id_pn, sn, type_transaction, date_create ,id_user) VALUES (:id_set, :id_pn, :sn, :type, :date, :id_acc);",

'query_103' => "SELECT count(status) as qty FROM parts_undercheck WHERE (type_transaction = 25 OR type_transaction = 26) AND status <> 0;",

];
//$db->returnQuery
?>