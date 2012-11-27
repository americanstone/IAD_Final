-- Entities
DROP TABLE IF EXISTS coursecontent;
DROP TABLE IF EXISTS comments;
DROP TABLE IF EXISTS submissionfile;
DROP TABLE IF EXISTS submission;
DROP TABLE IF EXISTS assignment;
DROP TABLE IF EXISTS usercourses;
DROP TABLE IF EXISTS groups;
DROP TABLE IF EXISTS course;
DROP TABLE IF EXISTS department;
DROP TABLE IF EXISTS semester;
DROP TABLE IF EXISTS users;

CREATE TABLE users
(
	email VARCHAR(30) NOT NULL UNIQUE,
	password VARCHAR(40) NOT NULL,
	name VARCHAR(50) NOT NULL,
	photo VARCHAR(200), 
	role VARCHAR(10),
	PRIMARY KEY (email)
);

CREATE TABLE department
(
	depart_name VARCHAR(30) PRIMARY KEY
);

CREATE TABLE semester
(
	semester VARCHAR(15) NOT NULL,
	active CHAR(1) 
);

CREATE TABLE course
(
	course_id INT NOT NULL AUTO_INCREMENT,
	course_img VARCHAR(200), 
	title VARCHAR(50) NOT NULL UNIQUE,
	description VARCHAR(1000), 
	instructor VARCHAR(30) NOT NULL,
	department VARCHAR(30) NOT NULL,
	semester VARCHAR(15) NOT NULL,
	FOREIGN KEY (instructor) REFERENCES users(email),
	FOREIGN KEY (department) REFERENCES department(depart_name),
	PRIMARY KEY (course_id)
);

CREATE TABLE groups
(
	name VARCHAR(20) NOT NULL,
	course_id INT NOT NULL,
	TA VARCHAR(30),
	PRIMARY KEY (name, course_id),
	FOREIGN KEY (course_id) REFERENCES course(course_id),
	FOREIGN KEY (TA) REFERENCES users(email)
);

CREATE TABLE usercourses
(
	user_id VARCHAR(30) NOT NULL,
	course_id INT NOT NULL,
	role VARCHAR(10) NOT NULL,
	group_name VARCHAR(20),
	FOREIGN KEY (user_id) REFERENCES users(email),
	FOREIGN KEY (course_id) REFERENCES course(course_id),
	FOREIGN KEY (group_name) REFERENCES groups(name)
);

CREATE TABLE assignment
(
	assign_id INT NOT NULL,
	course_id INT NOT NULL,
	name VARCHAR(100) NOT NULL,
	instruction VARCHAR(800) NOT NULL,
	attachment VARCHAR(200),
	assign_date DATE,
	due_date DATE,
	submit_type VARCHAR(10) NOT NULL,
	PRIMARY KEY(assign_id, course_id),
	FOREIGN KEY(course_id) REFERENCES course(course_id)
);

CREATE TABLE submission
(
	submission_id VARCHAR(35) NOT NULL,
	assign_id INT NOT NULL,
	course_id INT NOT NULL,
	submitted_by VARCHAR(30) NOT NULL,
	submit_date DATE,
	score INT,
	PRIMARY KEY(submission_id),
	FOREIGN KEY(assign_id,course_id) REFERENCES assignment(assign_id, course_id)
);

CREATE TABLE submissionfile
(
	filename VARCHAR(80) NOT NULL,
	submission_id VARCHAR(35) NOT NULL,
	last_update DATE,
	update_by VARCHAR(30) NOT NULL,
	PRIMARY KEY(filename),
	FOREIGN KEY(submission_id) REFERENCES submission(submission_id),
	FOREIGN KEY(update_by) REFERENCES users(email)
);

CREATE TABLE comments
(
	name VARCHAR(30) NOT NULL,
	description VARCHAR(50),
	severity INT,
	catagory VARCHAR(20),
	filename VARCHAR(80) NOT NULL,
	line INT NOT NULL,
	FOREIGN KEY(filename) REFERENCES submissionfile(filename)
);

CREATE TABLE coursecontent
(
        topic VARCHAR(30) NOT NULL,
        description VARCHAR(50), 
        attachment VARCHAR(200),
        course_id INT NOT NULL, 
        FOREIGN KEY(course_id) REFERENCES course(course_id)
);