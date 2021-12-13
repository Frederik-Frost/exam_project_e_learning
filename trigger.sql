delimiter $$
CREATE TRIGGER log_activity_update BEFORE UPDATE
ON activities
FOR EACH ROW
BEGIN

	INSERT INTO activity_logs (activity_id, old_activity_name, old_activity_description)
	VALUES (OLD.activity_id, OLD.activity_name, OLD.activity_description)

END $$
delimiter ;


-- -- TRIGGER FUNCTION TO LOG EVERY TIME AN ACTIVITY IS UPDATED

-- CREATE OR REPLACE FUNCTION log_activity() RETURNS trigger AS $$
-- DECLARE
-- BEGIN
-- INSERT INTO activity_logs (activity_id, old_activity_name, old_activity_description, old_activity_file_path)
-- VALUES (OLD.activity_id, OLD.activity_name, OLD.activity_description, OLD.activity_file_path);
-- RAISE NOTICE 'Someone just changed activity #%', OLD.event_id;
-- RETURN NEW;
-- END;
-- $$ LANGUAGE plpgsql;


-- CREATE TRIGGER log_activities
-- AFTER UPDATE ON activities
-- FOR EACH ROW EXECUTE PROCEDURE log_activity();




-- -- when updating an activity like this, the old info about this activity is added to the log

-- UPDATE activities
-- SET activity_description='UPDATED DESCRIPTION'
-- WHERE activity_id=7;

-- select * from activity_logs