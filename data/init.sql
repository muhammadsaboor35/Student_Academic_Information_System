-- DROP DATABASE sairsdb;
-- CREATE DATABASE sairsdb;
use sairsdb;

-- CREATE TABLE Person(
--   person_ID 		INT(64) AUTO_INCREMENT PRIMARY KEY,
--   first_name 		VARCHAR(32) NOT NULL,
--   last_name 		VARCHAR(32) NOT NULL,
--   hash_password 		VARCHAR(32) NOT NULL,
--   login_status	 	ENUM ('On', 'Off'),
--   phone         VARCHAR(32),  
--   email			VARCHAR(32),
--   gender		 	ENUM ('Male', 'Female', 'Other'),
--   address			VARCHAR(64));


-- CREATE TABLE Emergency_Contact(
--   person_ID		INT(64),
--   email			VARCHAR(32),
--   first_name		VARCHAR(32),
--   last_name 		VARCHAR(32),
--   relation			VARCHAR(32),
--   phone         VARCHAR(32), 
--   PRIMARY KEY (email),
--   FOREIGN KEY (person_ID) REFERENCES Person(person_ID));

-- CREATE TABLE Instructor(
--   instructor_ID		INT(64),
--   rank			ENUM('Associate', 'Assistant', 'Professor', 'Coordinator', 'Head','Dean'),
--   PRIMARY KEY (instructor_ID),
--   FOREIGN KEY (instructor_ID) REFERENCES Person(person_ID));

-- CREATE TABLE Student(
-- 	student_ID		INT(64),
-- 	advisor_ID		INT(64),
-- 	current_semester 	INT,
-- 	total_semesters		INT,
-- 	degree			ENUM ('Bachelors', 'Masters', 'PhD'),
-- 	register_limit		INT,
-- 	can_register		ENUM ('Yes', 'No'),
-- 	cgpa			DOUBLE,
-- 	PRIMARY KEY (student_ID),
-- 	FOREIGN KEY (advisor_ID) REFERENCES Instructor(instructor_ID),
-- 	FOREIGN KEY (student_ID) REFERENCES Person(person_ID));

-- CREATE TABLE Department(
--     name		VARCHAR(64),
--     building	VARCHAR(32),
--     PRIMARY KEY (name));

-- CREATE TABLE Dept_Person (
--     name		VARCHAR(64),
--     person_ID   INT(64),
--     PRIMARY KEY (name, person_ID),
-- 	FOREIGN KEY (name) REFERENCES Department(name),
-- 	FOREIGN KEY (person_ID) REFERENCES Person(person_ID));

-- CREATE TABLE Teaching_Assistant(
-- 	ta_ID		INT(64),
-- 	PRIMARY KEY (ta_ID),
-- 	FOREIGN KEY (ta_ID) REFERENCES Student(student_ID));

-- CREATE TABLE Course(
-- 	course_ID			VARCHAR(32),
-- 	name				VARCHAR(32),
-- 	a_grade				INT,
-- 	f_grade				INT,
-- 	info				VARCHAR(64),
-- 	dept				VARCHAR(32),
-- 	recommended_semester		INT,
-- 	credits 				INT,
-- 	PRIMARY KEY (course_ID),
-- 	FOREIGN KEY (dept) REFERENCES Department(name));

-- CREATE TABLE Sections(
-- 	course_ID			VARCHAR(32),
-- 	sec_ID				INT(64),
-- 	semester			ENUM('Spring', 'Fall', 'Summer'),
-- 	year 				INT,
-- 	instructor_ID			INT(64),
-- 	room_ID			VARCHAR(32),
-- 	quota				INT,			
-- 	PRIMARY KEY (course_ID, instructor_ID, sec_ID, semester, year),
-- 	FOREIGN KEY (course_ID) REFERENCES Course(course_ID),
-- 	FOREIGN KEY (instructor_ID) REFERENCES Instructor(instructor_ID));

-- CREATE TABLE Time_Slot(
-- 	time_slot_ID	INT(64) AUTO_INCREMENT PRIMARY KEY,
-- 	day		ENUM('Mon', 'Tue', 'Wed', 'Thu', 'Fri'),
-- 	time	ENUM('8-10', '10-12', '13-15', '15-17'));


-- CREATE TABLE Has_Schedule (
-- 	time_slot_ID	INT(64),
-- 	course_ID	VARCHAR(32),
-- 	instructor_ID			INT(64),
-- 	sec_ID				INT(64),
-- 	semester			ENUM('Spring', 'Fall', 'Summer'),
-- 	year 				INT,
-- 	PRIMARY KEY (time_slot_ID, course_ID, instructor_ID, sec_ID, semester, year),
-- 	FOREIGN KEY (time_slot_ID) REFERENCES Time_Slot(time_slot_ID),
-- 	FOREIGN KEY (course_ID, instructor_ID, sec_ID, semester, year) REFERENCES Sections(course_ID, instructor_ID, sec_ID, semester, year));

-- CREATE TABLE Student_Sections(
-- 	student_ID	INT(64),
-- 	course_ID	VARCHAR(32),
-- 	instructor_ID		INT(64),
-- 	sec_ID				INT(64),
-- 	semester			ENUM('Spring', 'Fall', 'Summer'),
-- 	year 				INT,
--     grade               ENUM('A+', 'A', 'A-', 'B+', 'B', 'B-', 'C+', 'C', 'C-', 'D+', 'D', 'F'),
--     semester_no         INT,
-- 	PRIMARY KEY (student_ID, course_ID, instructor_ID, sec_ID, semester, year),
-- 	FOREIGN KEY (student_ID) REFERENCES Student(student_ID),
-- 	FOREIGN KEY (course_ID, instructor_ID, sec_ID, semester, year) REFERENCES Sections(course_ID, instructor_ID, sec_ID, semester, year));


-- CREATE TABLE Task(
-- 	course_ID	VARCHAR(32),
-- 	task_ID		INT(64),
-- 	start_date	DATE,
-- 	end_date	DATE,
-- 	task_name	VARCHAR(32),
-- 	total_score	INT,
-- 	weight		INT,
-- 	PRIMARY KEY (course_ID, task_ID),
-- 	FOREIGN KEY (course_ID) REFERENCES Course(course_ID));

-- CREATE TABLE Assignment(
-- 	course_ID	VARCHAR(32),
-- 	task_ID		INT(64),
--     PRIMARY KEY (course_ID, task_ID),
--     FOREIGN KEY (course_ID, task_ID) REFERENCES Task(course_ID, task_ID));

-- CREATE TABLE Exam(
--     course_ID	VARCHAR(32),
--     task_ID		INT(64),
--     room 		VARCHAR(32),
--     PRIMARY KEY (course_ID, task_ID),
--     FOREIGN KEY (course_ID, task_ID) REFERENCES Task(course_ID, task_ID));


-- CREATE TABLE Attendance(
--     course_ID	VARCHAR(32),
--     task_ID		INT(64),
--     PRIMARY KEY (course_ID, task_ID),
--     FOREIGN KEY (course_ID, task_ID) REFERENCES Task(course_ID, task_ID));


-- CREATE TABLE grades_submission(
--     student_ID	INT(64),
--     course_ID	VARCHAR(32),
--     task_ID		INT(64),
--     ta_ID		INT(64),
--     score		INT,
--     PRIMARY KEY (student_ID, course_ID, task_ID),
--     FOREIGN KEY (ta_ID) REFERENCES Teaching_Assistant(ta_ID),
--     FOREIGN KEY (student_ID) REFERENCES Student(student_ID),
--     FOREIGN KEY (course_ID, task_ID) REFERENCES Task(course_ID, task_ID));

-- CREATE TABLE Requires(
-- 	course_ID			VARCHAR(32),
-- 	pre_course_ID			VARCHAR(32),
-- 	PRIMARY KEY (course_ID, pre_course_ID),
-- 	FOREIGN KEY (course_ID) REFERENCES Course(course_ID),
--     FOREIGN KEY (pre_course_ID) REFERENCES Course(course_ID));

-- CREATE TABLE Course_books(
-- 	course_ID			VARCHAR(32),
-- 	book				VARCHAR(32),
-- 	PRIMARY KEY (course_ID, book),
-- 	FOREIGN KEY (course_ID) REFERENCES Course(course_ID));


-- CREATE TABLE Document(
-- 	document_ID		INT(64) PRIMARY KEY AUTO_INCREMENT UNIQUE,
-- 	type			VARCHAR(32),
-- 	date			DATE,
-- 	person_ID		INT(64),
-- 	cost			DOUBLE,
-- 	method			VARCHAR(32),
-- 	domestic_address	VARCHAR(64),
-- 	country			VARCHAR(32),
-- 	FOREIGN KEY (person_ID) REFERENCES Person(person_ID));

-- CREATE TABLE Admin(
--         admin_ID        INT(64),
--         PRIMARY KEY (admin_ID),
--         FOREIGN KEY (admin_ID) REFERENCES Person(person_ID));

-- CREATE TABLE Club(
--         name            VARCHAR(64),
--         phone           VARCHAR(32),
--         website         VARCHAR(32),
--         budget          INT(64),
--         head_ID         INT(64),
--         PRIMARY KEY (name),
--         FOREIGN KEY (head_ID) REFERENCES Instructor(instructor_ID));

-- CREATE TABLE Participates(
--         student_ID      INT(64),
--         name            VARCHAR(64),
--         PRIMARY KEY (student_ID, name),
--         FOREIGN KEY (student_ID) REFERENCES Student(student_ID),
--         FOREIGN KEY (name) REFERENCES Club(name));


-- CREATE TABLE Seminar(
--         name            VARCHAR(64),
--         seminar_date    DATE,
--         seminar_time    TIME,
--         room            VARCHAR(32),
--         duration        INT,
--         host_ID         INT(64),
--         PRIMARY KEY (name, seminar_date, host_ID),
--         FOREIGN KEY (host_ID) REFERENCES Instructor(instructor_ID));

-- CREATE TABLE Attends(
--         name            VARCHAR(64),
--         seminar_date    DATE,
--         host_ID         INT(64),
--         person_ID       INT(64),
--         PRIMARY KEY (name, seminar_date, host_ID, person_ID),
--         FOREIGN KEY (name, seminar_date) REFERENCES Seminar(name, seminar_date),
--         FOREIGN KEY (host_ID) REFERENCES Instructor(instructor_ID),
--         FOREIGN KEY (person_ID) REFERENCES Person(person_ID));

CREATE INDEX theName ON Person (first_name);
CREATE INDEX theGpa ON Student (cgpa);