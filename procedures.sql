-------------------------
-- Create a topic and update the junction table
-------------------------
-- DELIMITER $$

-- CREATE PROCEDURE create_topic(
-- 	IN V_topic_name VARCHAR(255)
-- )
-- BEGIN
-- INSERT INTO topics (topic_name)
-- 	VALUES (V_topic_name);

-- 	INSERT INTO user_topics (user_id, topic_id)
-- 		SELECT  users.user_id AS user_id,
-- 				topics.topic_id AS topic_id
-- 		FROM topics CROSS JOIN users 
-- 		WHERE topics.topic_name = V_topic_name;
-- COMMIT;
-- END $$

-- DELIMITER ;
-------------------------
-- CALL create_topic('What is a relational database?');


-------------------------
-- Create a topic and update the junction table
-------------------------
DELIMITER $$

CREATE PROCEDURE create_topic(
	IN V_topic_name VARCHAR(255)
)
BEGIN
INSERT INTO topics (topic_name)
	VALUES (V_topic_name);

	INSERT INTO user_topics (user_id, topic_id)
		SELECT  users.user_id AS user_id,
				topics.topic_id AS topic_id
		FROM topics CROSS JOIN users 
		WHERE topics.topic_name = V_topic_name
		AND users.is_admin = 1;
COMMIT;
END $$

DELIMITER ;
-------------------------
-- CALL create_topic('What is a relational database?');

-------------------------
-- Create a user and update the junction table
-------------------------
DELIMITER $$

CREATE PROCEDURE create_admin(
	IN V_first_name varchar(50),
	IN V_last_name varchar(50),
	IN V_email varchar(90),
	IN V_is_admin boolean,
	IN V_password varchar(60)
)
BEGIN
INSERT INTO users (first_name, last_name, email, is_admin, user_password)
VALUES (V_first_name, V_last_name, V_email, V_is_admin, V_password);

    INSERT INTO user_topics(user_id, topic_id)
        SELECT  users.user_id AS user_id,
                topics.topic_id AS topic_id
        FROM users CROSS JOIN topics 
        WHERE users.email = V_email;
COMMIT;
END $$

DELIMITER ;
-------------------------
-- CALL create_admin("test", "perso", 'as@s.com', 1,"worddd")


DELIMITER $$

CREATE PROCEDURE create_user(
	IN V_first_name varchar(50),
	IN V_last_name varchar(50),
	IN V_email varchar(90),
	IN V_is_admin boolean,
	IN V_password varchar(60)
)
BEGIN
INSERT INTO users (first_name, last_name, email, is_admin, user_password)
VALUES (V_first_name, V_last_name, V_email, V_is_admin, V_password);

INSERT INTO user_topics
SELECT user_id, 1, 0 FROM users WHERE email = V_email;

COMMIT;
END $$

DELIMITER ;

-- CALL create_user("test", "perso", 'as@s.com', 0,"worddd")
