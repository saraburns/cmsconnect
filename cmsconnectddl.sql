use sburns_db;

drop table if exists humans;
drop table if exists pieces;
drop table if exists groups;
drop table if exists schedule;
drop table if exists members;
drop table if exists instrumentation;
-- The humans table creates a table containing students and coaches
create table humans (
	bnumber char(9) not null primary key,
	email varchar(50) not null,
	password varchar(50) not null, -- this should be made more secure
	instrument enum('clarinet','flute','cello','violin','viola','oboe','tuba',
					'alto','soprano'),
	status enum('student','coach'),
	ingroup boolean,
	admin boolean,
	yr year(4)
	)
	-- table constraints follow
	ENGINE = InnoDB;
	
INSERT into humans values ('B20716868', 'sburns@wellesley.edu', 'ch@mb3r Mus1c', 'clarinet', 'student', false, false, 2016);
INSERT into humans values ('B20702161', 'swang8@wellesley.edu', 'gingerbeard', 'flute', 'student', false, false, 2016);
-- Creates a many-to-many relationship between people and their available time slots,
-- Sunday-Saturday, 7AM-11PM (15 hours/day, 7 days/week) for usage in comparing schedules
create table schedule (
	bnumber char(9) not null,
	timeid char(3) not null,	-- 105 possible hours (15 hours available per day * 7 days/week)
	INDEX (bnumber),
	foreign key (bnumber) references humans(bnumber) on delete cascade
	)
	-- table constraints follow
	ENGINE = InnoDB;

INSERT into schedule values ('B20716868', '103');
INSERT into schedule values ('B20716868', '104');
INSERT into schedule values ('B20703151', '103');
-- creates a table representing each group, membership is represented with a join table, member
create table groups (
	groupid smallint auto_increment not null primary key,
	meetingtime char(3), -- meeting times may begin unestablished
	rehearsaltime char(3) 
	)
	ENGINE = InnoDB;

INSERT into groups values (1,'103', '104');
-- join table to show potential many-to-many relationship for members in a group	
create table members (
	bnumber char(9) not null,
	groupid smallint not null,
	INDEX (bnumber),
	INDEX (groupid),
	foreign key (bnumber) references humans(bnumber) on delete cascade,
	foreign key (groupid) references groups(groupid) on delete cascade
)
	ENGINE  = InnoDB;	
INSERT into members values ('B20716868', 1);
-- contains information on each piece in the CMS music library
create table pieces (
	pid int auto_increment not null primary key,
	title varchar(100) not null,
	yr date,
	composer varchar(50),
	currentgroup smallint,
	INDEX(currentgroup),
	foreign key (currentgroup) references groups(groupid) on delete set null
	)
	-- table constraints follow
	ENGINE = InnoDB;

INSERT into pieces values (1,'Divertimento III', '1803-00-00', 'Wolfgang Amadeus Mozart', 1); 
-- allows a piece to be composed for multiple instruments
create table instrumentation (
	pid int not null,
	instrument enum('clarinet','flute','cello','violin','viola','oboe','tuba',
					'alto','soprano','bassoon'),
	INDEX (pid),
	foreign key (pid) references pieces(pid) on delete cascade
	)
	-- table constraints follow
	ENGINE = InnoDB;

INSERT into instrumentation values (1,'clarinet');
INSERT into instrumentation values (1,'bassoon');
INSERT into instrumentation values (1,'oboe');
