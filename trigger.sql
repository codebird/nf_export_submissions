DELIMITER //
CREATE TRIGGER new_subs
AFTER UPDATE ON wp_objectmeta 
FOR EACH ROW 
BEGIN 
IF NEW.meta_key='last_sub' THEN
	INSERT INTO new_subs (form_id, sub_id) values (NEW.object_id, NEW.meta_value);  
END IF;
END//
DELIMITER ;