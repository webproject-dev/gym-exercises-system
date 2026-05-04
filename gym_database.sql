CREATE DATABASE IF NOT EXISTS gym_system;
USE gym_system;

DROP TABLE IF EXISTS exercises;

CREATE TABLE exercises (
    exercise_id INT AUTO_INCREMENT PRIMARY KEY,
    muscle_group VARCHAR(50) NOT NULL,
    exercise_name VARCHAR(100) NOT NULL,
    difficulty VARCHAR(30) NOT NULL
);

INSERT INTO exercises (muscle_group, exercise_name, difficulty) VALUES
('Chest', 'Bench Press', 'Intermediate'),
('Chest', 'Incline Dumbbell Press', 'Intermediate'),
('Chest', 'Chest Fly', 'Beginner'),
('Legs', 'Squats', 'Beginner'),
('Legs', 'Leg Press', 'Intermediate'),
('Back', 'Deadlift', 'Advanced'),
('Back', 'Lat Pulldown', 'Beginner'),
('Arms', 'Bicep Curl', 'Beginner'),
('Shoulders', 'Shoulder Press', 'Intermediate');
