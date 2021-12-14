delimiter $$
CREATE TRIGGER log_activity_update BEFORE UPDATE
ON activities
FOR EACH ROW
BEGIN

	INSERT INTO activity_logs (activity_id, old_activity_name, old_activity_description)
	VALUES (OLD.activity_id, OLD.activity_name, OLD.activity_description)

END $$
delimiter ;
