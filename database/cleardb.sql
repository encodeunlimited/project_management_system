TRUNCATE TABLE discussion_list;
ALTER TABLE discussion_list AUTO_INCREMENT = 1;


TRUNCATE TABLE task_list;
ALTER TABLE task_list AUTO_INCREMENT = 1;

TRUNCATE TABLE ticket_list;
ALTER TABLE ticket_list AUTO_INCREMENT = 1;

TRUNCATE TABLE discussion_list;
ALTER TABLE discussion_list AUTO_INCREMENT = 1;

TRUNCATE TABLE user_productivity;
ALTER TABLE user_productivity AUTO_INCREMENT = 1;

TRUNCATE TABLE project_list;
ALTER TABLE project_list AUTO_INCREMENT = 1;    

TRUNCATE TABLE users;
ALTER TABLE users AUTO_INCREMENT = 1;

INSERT INTO `users` (`id`, `firstname`, `lastname`, `email`, `password`, `type`, `avatar`, `date_created`) VALUES (NULL, 'Super', 'Admin', 'asd@gmail.com', 'b24331b1a138cde62aa1f679164fc62f', '1', 'male.jpg', current_timestamp());