--
-- Inserting data into the database
--

USE `trainingfactory`;

--
-- Data for Persons
--

INSERT INTO `persons`
(`id`,
 `loginname`,
 `password`,
 `firstname`,
 `preprovision`,
 `lastname`,
 `dateofbirth`,
 `gender`,
 `email_address`,
 `hiring_date`,
 `salary`,
 `street`,
 `postal_code`,
 `place`,
 `role`)
VALUES
(NULL,'member','qwerty','member','van','trainingfactory','2017-04-04','male','member@member.com',NULL,NULL,'street1','1234AB','The Hague','member'),
(NULL,'member1','qwerty','member1','van','trainingfactory1','2016-03-01','male','member1@member.com',NULL,NULL,'street11','1131AB','The Hague','member'),
(NULL,'member2','qwerty','member2','van','trainingfactory2','2015-03-06','male','member2@member.com',NULL,NULL,'street12','1231AB','The Hague','member'),
(NULL,'instructor','qwerty','instructor','van','trainingfactory','2017-04-04','male','instructor@instructor.com','2013-04-04','2500.00','street2','2134AB','The Hague','instructor'),
(NULL,'instructor1','qwerty','instructor1','van1','trainingfactory1','2011-03-11','male','instructor1@instructor.com','2009-04-01','2800.00','street5','2114AB','The Hague','instructor'),
(NULL,'admin','qwerty','admin','van','trainingfactory','2013-04-04','female','admin@admin.com','2012-04-04','2500.00','street3','2134AC','The Hague','admin');

--
-- Data for Trainings
--

INSERT INTO `trainings`
(`id`,
 `description`,
 `duration`,
 `extra_costs`)
VALUES
(NULL, 'Boksen', '01:20:00', NULL),
(NULL, 'Kickboksen', '02:10:00', 10),
(NULL, 'MMA', '00:45:00', 49.5),
(NULL, 'Stootzak trainingen', '01:25:00', NULL),
(NULL, 'Bootcamps', '03:30:00', 16.5),
(NULL, 'Fitness-uren', '03:00:00', NULL);

--
-- Data for Lesssons
--

INSERT INTO `lessons`
(`id`,
 `time`,
 `date`,
 `location`,
 `max_persons`,
 `instructor_id`,
 `training_id`)
 VALUES
 (NULL, '11:09:01', '2017-04-19', '1.01', 5, 2, 1),
 (NULL, '12:19:29', '2017-04-19', '1.02', 5, 2, 2),
 (NULL, '13:29:47', '2017-04-19', '1.03', 5, 2, 3),
 (NULL, '14:39:55', '2017-04-20', '1.04', 5, 2, 4),
 (NULL, '15:49:32', '2017-04-20', '2.01', 5, 2, 5),
 (NULL, '16:59:20', '2017-04-20', '2.02', 5, 2, 6),
 (NULL, '17:39:31', '2017-04-21', '2.03', 5, 2, 1),
 (NULL, '18:29:20', '2017-04-21', '2.04', 5, 2, 2),
 (NULL, '19:19:23', '2017-04-21', '3.01', 5, 2, 3),
 (NULL, '20:39:20', '2017-04-22', '3.02', 5, 2, 4),
 (NULL, '21:19:26', '2017-04-22', '3.03', 5, 2, 5),
 (NULL, '22:29:25', '2017-04-22', '3.04', 5, 2, 6),
 (NULL, '23:19:11', '2017-04-23', '4.01', 5, 2, 2),
 (NULL, '23:29:12', '2017-04-24', '4.02', 5, 2, 4),
 (NULL, '23:29:12', '2017-04-25', '4.02', 5, 2, 6),
 (NULL, '21:29:12', '2017-04-26', '4.02', 5, 2, 1),
 (NULL, '22:29:12', '2017-04-27', '4.02', 5, 2, 2),
 (NULL, '23:29:12', '2017-04-28', '4.02', 5, 2, 3),
 (NULL, '21:29:12', '2017-04-29', '4.02', 5, 2, 4),
 (NULL, '22:29:12', '2017-04-30', '4.02', 5, 2, 5),
 (NULL, '23:29:12', '2017-05-01', '4.02', 5, 2, 6),
 (NULL, '23:29:12', '2017-05-02', '4.02', 5, 2, 1),
 (NULL, '23:29:12', '2017-05-03', '4.02', 5, 2, 2),
 (NULL, '23:39:13', '2017-05-04', '1.03', 5, 2, 4),
 (NULL, '23:39:13', '2017-05-05', '2.03', 5, 2, 5),
 (NULL, '23:39:13', '2017-05-06', '3.03', 5, 2, 1),
 (NULL, '23:39:13', '2017-05-07', '4.03', 5, 2, 2);

--
-- Data for Registrations
--

INSERT INTO `registrations`
(`lesson_id`,
 `member_id`, 
 `payment`)
VALUES 
(1, 1, 'unpaid'),
(2, 1, 'paid'),
(3, 1, 'paid'),
(4, 1, 'unpaid'),
(11, 1, 'paid'),
(1, 2, 'paid'),
(2, 2, 'paid'),
(3, 2, 'unpaid'),
(4, 2, 'unpaid'),
(14, 2, 'unpaid'),
(10, 3, 'unpaid'),
(11, 3, 'unpaid'),
(12, 3, 'unpaid'),
(13, 3, 'unpaid'),
(14, 3, 'unpaid');
