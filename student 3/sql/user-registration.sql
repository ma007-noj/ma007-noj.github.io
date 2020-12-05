--
-- Database: `aum-db`
--

-- --------------------------------------------------------

--
-- Table structure for table `student`
--

DROP DATABASE IF EXISTS aumdb;
CREATE DATABASE aumdb;

-- select the database
USE aumdb;

drop table student;
drop table courses;
drop table course_enroll;
drop table instructor;


CREATE TABLE `student` (
  `id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `gender` varchar(255) NOT NULL,
  `userID` varchar(255) NOT NULL,
  `password` varchar(200) NOT NULL,
  `email` varchar(255) NOT NULL,
  `dob` DATE,
  `create_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `tbl_member`
--
ALTER TABLE `student`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `tbl_member`
--
ALTER TABLE `student`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

CREATE TABLE `courses` (
  `course_id` int(11) NOT NULL,
  `instructor_id` int(11) NOT NULL,
  `course_name` varchar(200) NOT NULL,
  `time` varchar(200) NOT NULL,
  `classroom` varchar(200) NOT NULL,
  `semester` varchar(200) NOT NULL
);

--
-- Dumping data for table `courses`
--
INSERT INTO `courses` (`course_id`, `instructor_id`, `course_name`, `time`, `classroom`, `semester`) VALUES
(1, 10101, 'PHP', 'tue 12:00 AM', '3', '2020 fall'),
(2, 45565, 'Angular', 'mon 11:00 AM', '5', '2020fall'),
(3, 83821, '.Net', 'mon 11:00 AM', '1', '2020fall'),
(4, 45565, 'PHP', 'wed 3:00 pm', '3', '2020fall'),
(5, 10101, 'Angular', 'wed 3:00 pm', '4', '2020fall');


CREATE TABLE `course_enroll` (
  `user_id` int(11) NOT NULL,
   `course_id` int(11) NOT NULL,
   `instructor_id` int(11) NOT NULL,
   `create_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
);


create table instructor
	(ID			varchar(5), 
	 name			varchar(20) not null, 
	 dept_name		varchar(20), 
	 salary			numeric(8,2) check (salary > 29000)
	);


insert into instructor values ('10101', 'Srinivasan', 'Comp. Sci.', '65000');
insert into instructor values ('12121', 'Wu', 'Finance', '90000');
insert into instructor values ('15151', 'Mozart', 'Music', '40000');
insert into instructor values ('22222', 'Einstein', 'Physics', '95000');
insert into instructor values ('32343', 'El Said', 'History', '60000');
insert into instructor values ('33456', 'Gold', 'Physics', '87000');
insert into instructor values ('45565', 'Katz', 'Comp. Sci.', '75000');
insert into instructor values ('58583', 'Califieri', 'History', '62000');
insert into instructor values ('76543', 'Singh', 'Finance', '80000');
insert into instructor values ('76766', 'Crick', 'Biology', '72000');
insert into instructor values ('83821', 'Brandt', 'Comp. Sci.', '92000');
insert into instructor values ('98345', 'Kim', 'Elec. Eng.', '80000');

commit;