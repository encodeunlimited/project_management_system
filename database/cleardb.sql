TRUNCATE TABLE discussion_list;
ALTER TABLE discussion_list AUTO_INCREMENT = 1;

TRUNCATE TABLE user_productivity;
ALTER TABLE user_productivity AUTO_INCREMENT = 1;

TRUNCATE TABLE ticket_list;
ALTER TABLE ticket_list AUTO_INCREMENT = 1;



ALTER TABLE user_productivity DROP FOREIGN KEY task_id;

TRUNCATE TABLE task_list;
ALTER TABLE task_list AUTO_INCREMENT = 1;

ALTER TABLE user_productivity ADD CONSTRAINT task_id FOREIGN KEY (task_id) REFERENCES task_list (id);


ALTER TABLE user_productivity DROP FOREIGN KEY project_ids;
ALTER TABLE discussion_list DROP FOREIGN KEY FORIGN;
ALTER TABLE ticket_list DROP FOREIGN KEY prg_id;
ALTER TABLE task_list DROP FOREIGN KEY project_id;
TRUNCATE TABLE project_list;
ALTER TABLE project_list AUTO_INCREMENT = 1;
ALTER TABLE discussion_list ADD CONSTRAINT FORIGN FOREIGN KEY (project_id) REFERENCES project_list (id);
ALTER TABLE ticket_list ADD CONSTRAINT FORIGN FOREIGN KEY (project_id) REFERENCES project_list (id);
ALTER TABLE task_list ADD CONSTRAINT FORIGN FOREIGN KEY (project_id) REFERENCES project_list (id);
ALTER TABLE user_productivity ADD CONSTRAINT FORIGN FOREIGN KEY (project_id) REFERENCES project_list (id);



TRUNCATE TABLE users;
ALTER TABLE users AUTO_INCREMENT = 1;

INSERT INTO `users` (`id`, `firstname`, `lastname`, `email`, `password`, `type`, `avatar`, `date_created`) VALUES (NULL, 'Super', 'Admin', 'asd@gmail.com', 'b24331b1a138cde62aa1f679164fc62f', '1', 'male.jpg', current_timestamp());