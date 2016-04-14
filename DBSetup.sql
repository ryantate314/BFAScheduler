CREATE TABLE worker_position (
	description VARCHAR(32) PRIMARY KEY
);

CREATE TABLE event_worker_position (
	event_id INT,
	worker_id INT,
	position VARCHAR(32),
	estimatedHours INT,
	PRIMARY KEY (event_id, worker_id, position)
);