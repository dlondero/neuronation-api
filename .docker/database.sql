CREATE TABLE users
(
    id    INT AUTO_INCREMENT PRIMARY KEY,
    name  VARCHAR(255)        NOT NULL,
    email VARCHAR(255) UNIQUE NOT NULL
);

CREATE TABLE categories
(
    id   INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(255) NOT NULL UNIQUE
);

CREATE TABLE exercises
(
    id          INT AUTO_INCREMENT PRIMARY KEY,
    name        VARCHAR(255) NOT NULL,
    category_id INT          NOT NULL,
    FOREIGN KEY (category_id) REFERENCES categories (id)
);

CREATE TABLE sessions
(
    id            INT AUTO_INCREMENT PRIMARY KEY,
    user_id       INT       NOT NULL,
    session_stamp TIMESTAMP NOT NULL,
    total_score   INT NOT NULL DEFAULT 0,
    FOREIGN KEY (user_id) REFERENCES users (id),
    INDEX (user_id, session_stamp)
);

CREATE TABLE session_exercises
(
    id          INT AUTO_INCREMENT PRIMARY KEY,
    session_id  INT NOT NULL,
    exercise_id INT NOT NULL,
    score       INT NOT NULL,
    FOREIGN KEY (session_id) REFERENCES sessions (id),
    FOREIGN KEY (exercise_id) REFERENCES exercises (id),
    INDEX (session_id, exercise_id)
);

CREATE TABLE courses
(
    id   INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(255) NOT NULL UNIQUE
);

CREATE TABLE course_exercises
(
    id          INT AUTO_INCREMENT PRIMARY KEY,
    course_id   INT NOT NULL,
    exercise_id INT NOT NULL,
    FOREIGN KEY (course_id) REFERENCES courses (id),
    FOREIGN KEY (exercise_id) REFERENCES exercises (id),
    INDEX (course_id, exercise_id)
);


INSERT INTO users (name, email) VALUES ('John Doe', 'john.doe@example.com');

INSERT INTO categories (id, name) VALUES (1, 'Category 1');
INSERT INTO categories (id, name) VALUES (2, 'Category 2');
INSERT INTO categories (id, name) VALUES (3, 'Category 3');
INSERT INTO categories (id, name) VALUES (4, 'Category 4');
INSERT INTO categories (id, name) VALUES (5, 'Category 5');

INSERT INTO exercises (id, name, category_id) VALUES (1, 'Exercise 1', 1);
INSERT INTO exercises (id, name, category_id) VALUES (2, 'Exercise 2', 2);
INSERT INTO exercises (id, name, category_id) VALUES (3, 'Exercise 3', 3);
INSERT INTO exercises (id, name, category_id) VALUES (4, 'Exercise 4', 4);
INSERT INTO exercises (id, name, category_id) VALUES (5, 'Exercise 5', 5);
INSERT INTO exercises (id, name, category_id) VALUES (6, 'Exercise 6', 1);
INSERT INTO exercises (id, name, category_id) VALUES (7, 'Exercise 7', 2);
INSERT INTO exercises (id, name, category_id) VALUES (8, 'Exercise 8', 3);
INSERT INTO exercises (id, name, category_id) VALUES (9, 'Exercise 9', 4);
INSERT INTO exercises (id, name, category_id) VALUES (10, 'Exercise 10', 5);
INSERT INTO exercises (id, name, category_id) VALUES (11, 'Exercise 11', 1);
INSERT INTO exercises (id, name, category_id) VALUES (12, 'Exercise 12', 2);
INSERT INTO exercises (id, name, category_id) VALUES (13, 'Exercise 13', 3);
INSERT INTO exercises (id, name, category_id) VALUES (14, 'Exercise 14', 4);
INSERT INTO exercises (id, name, category_id) VALUES (15, 'Exercise 15', 5);
INSERT INTO exercises (id, name, category_id) VALUES (16, 'Exercise 16', 1);
INSERT INTO exercises (id, name, category_id) VALUES (17, 'Exercise 17', 2);
INSERT INTO exercises (id, name, category_id) VALUES (18, 'Exercise 18', 3);
INSERT INTO exercises (id, name, category_id) VALUES (19, 'Exercise 19', 4);
INSERT INTO exercises (id, name, category_id) VALUES (20, 'Exercise 20', 5);

INSERT INTO sessions (id, user_id, session_stamp, total_score) VALUES (1, 1, '2024-11-20 00:00:00', 50);
INSERT INTO sessions (id, user_id, session_stamp, total_score) VALUES (2, 1, '2024-11-21 00:00:00', 100);
INSERT INTO sessions (id, user_id, session_stamp, total_score) VALUES (3, 1, '2024-11-22 00:00:00', 150);
INSERT INTO sessions (id, user_id, session_stamp, total_score) VALUES (4, 1, '2024-11-23 00:00:00', 200);

INSERT INTO session_exercises (id, session_id, exercise_id, score) VALUES (1, 1, 1, 10);
INSERT INTO session_exercises (id, session_id, exercise_id, score) VALUES (2, 1, 2, 10);
INSERT INTO session_exercises (id, session_id, exercise_id, score) VALUES (3, 1, 3, 10);
INSERT INTO session_exercises (id, session_id, exercise_id, score) VALUES (4, 1, 4, 10);
INSERT INTO session_exercises (id, session_id, exercise_id, score) VALUES (5, 1, 5, 10);
INSERT INTO session_exercises (id, session_id, exercise_id, score) VALUES (6, 2, 6, 20);
INSERT INTO session_exercises (id, session_id, exercise_id, score) VALUES (7, 2, 7, 20);
INSERT INTO session_exercises (id, session_id, exercise_id, score) VALUES (8, 2, 8, 20);
INSERT INTO session_exercises (id, session_id, exercise_id, score) VALUES (9, 2, 9, 20);
INSERT INTO session_exercises (id, session_id, exercise_id, score) VALUES (10, 2, 10, 20);
INSERT INTO session_exercises (id, session_id, exercise_id, score) VALUES (11, 3, 11, 30);
INSERT INTO session_exercises (id, session_id, exercise_id, score) VALUES (12, 3, 12, 30);
INSERT INTO session_exercises (id, session_id, exercise_id, score) VALUES (13, 3, 13, 30);
INSERT INTO session_exercises (id, session_id, exercise_id, score) VALUES (14, 3, 14, 30);
INSERT INTO session_exercises (id, session_id, exercise_id, score) VALUES (15, 3, 15, 30);
INSERT INTO session_exercises (id, session_id, exercise_id, score) VALUES (16, 4, 16, 40);
INSERT INTO session_exercises (id, session_id, exercise_id, score) VALUES (17, 4, 17, 40);
INSERT INTO session_exercises (id, session_id, exercise_id, score) VALUES (18, 4, 18, 40);
INSERT INTO session_exercises (id, session_id, exercise_id, score) VALUES (19, 4, 19, 40);
INSERT INTO session_exercises (id, session_id, exercise_id, score) VALUES (20, 4, 20, 40);

INSERT INTO courses (name) VALUES ('Course 1'), ('Course 2'), ('Course 3');

INSERT INTO course_exercises (course_id, exercise_id) VALUES (1, 1);
INSERT INTO course_exercises (course_id, exercise_id) VALUES (1, 2);
INSERT INTO course_exercises (course_id, exercise_id) VALUES (1, 3);
INSERT INTO course_exercises (course_id, exercise_id) VALUES (1, 4);
INSERT INTO course_exercises (course_id, exercise_id) VALUES (1, 5);
INSERT INTO course_exercises (course_id, exercise_id) VALUES (1, 6);
INSERT INTO course_exercises (course_id, exercise_id) VALUES (1, 7);
INSERT INTO course_exercises (course_id, exercise_id) VALUES (1, 8);
INSERT INTO course_exercises (course_id, exercise_id) VALUES (1, 9);
INSERT INTO course_exercises (course_id, exercise_id) VALUES (1, 10);
INSERT INTO course_exercises (course_id, exercise_id) VALUES (2, 11);
INSERT INTO course_exercises (course_id, exercise_id) VALUES (2, 12);
INSERT INTO course_exercises (course_id, exercise_id) VALUES (2, 13);
INSERT INTO course_exercises (course_id, exercise_id) VALUES (2, 14);
INSERT INTO course_exercises (course_id, exercise_id) VALUES (2, 15);
INSERT INTO course_exercises (course_id, exercise_id) VALUES (3, 16);
INSERT INTO course_exercises (course_id, exercise_id) VALUES (3, 17);
INSERT INTO course_exercises (course_id, exercise_id) VALUES (3, 18);
INSERT INTO course_exercises (course_id, exercise_id) VALUES (3, 19);
INSERT INTO course_exercises (course_id, exercise_id) VALUES (3, 20);
