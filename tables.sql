

CREATE TABLE users (
	user_id serial PRIMARY KEY,
	first_name varchar(50) CHECK (first_name <> ''),
	last_name varchar(50)  CHECK (last_name <> ''),
	email varchar(90) UNIQUE,
	is_admin BOOLEAN DEFAULT false,
	user_password varchar(60) CHECK (user_password  <> '')
);

CREATE TABLE topics (
	topic_id serial PRIMARY KEY,
	topic_name varchar(255) CHECK (topic_name  <> ''),
);

CREATE TABLE activities (
	activity_id serial PRIMARY KEY,
	topic_id integer REFERENCES topics(topic_id),
	activity_name varchar(255) CHECK (activity_name <> ''),
	activity_description varchar(255)  CHECK (activity_description  <> '')
);

CREATE TABLE user_topics (
	user_id integer REFERENCES users(user_id),	
	topic_id integer REFERENCES topics(topic_id),
	CONSTRAINT users_topic_pkey PRIMARY KEY (user_id, topic_id),
	completed BOOLEAN DEFAULT false
);


CREATE TABLE activity_logs (
	activity_id integer,
	old_activity_name varchar(255),
	old_activity_description varchar(255),
	logged_at timestamp DEFAULT current_timestamp
);