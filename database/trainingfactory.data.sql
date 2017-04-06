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
(NULL,
'member',
'qwerty',
'member',
'van',
'trainingfactory',
'2017-04-04',
'male',
'member@member.com',
NULL,
NULL,
'street1',
'1234AB',
'The Hague',
'member'),
(NULL,
'instructor',
'qwerty',
'instructor',
'van',
'trainingfactory',
'2017-03-04',
'male',
'instructor@instructor.com',
'2018-02-04',
'2500.50',
'street1',
'4234AC',
'The Hague',
'instructor'),
(NULL,
'admin',
'qwerty',
'admin',
'van',
'trainingfactory',
'2017-04-05',
'female',
'admin@admin.com',
'2018-05-08',
'8000.50',
'street1',
'1111AB',
'The Hague',
'admin')

--
-- Data for Trainings
--

INSERT INTO `trainings` 
(`id`, `description`, `duration`, `extra_costs`)
VALUES
(NULL, 'Boksen', '01:20:00', NULL),
(NULL, 'Kickboksen', '02:10:00', 10),
(NULL, 'MMA', '00:45:00', 49.5),
(NULL, 'Stootzak trainingen', '01:25:00', NULL),
(NULL, 'Bootcamps', '03:30:00', 16.5),
(NULL, 'Fitness-uren', '03:00:00', NULL);
