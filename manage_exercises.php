<?php
include "db_connect.php";

$message = "";

if (isset($_POST["insert"])) {
    $muscle_group = trim($_POST["muscle_group"]);
    $exercise_name = trim($_POST["exercise_name"]);
    $difficulty = trim($_POST["difficulty"]);

    if ($muscle_group == "" || $exercise_name == "" || $difficulty == "") {
        $message = "Please fill all insert fields.";
    } else {
        $stmt = $conn->prepare("INSERT INTO exercises (muscle_group, exercise_name, difficulty) VALUES (?, ?, ?)");
        $stmt->bind_param("sss", $muscle_group, $exercise_name, $difficulty);
        $stmt->execute();
        $message = "Exercise inserted successfully.";
    }
}

if (isset($_POST["update"])) {
    $exercise_id = intval($_POST["exercise_id"]);
    $muscle_group = trim($_POST["new_muscle_group"]);
    $exercise_name = trim($_POST["new_exercise_name"]);
    $difficulty = trim($_POST["new_difficulty"]);

    if ($exercise_id <= 0 || $muscle_group == "" || $exercise_name == "" || $difficulty == "") {
        $message = "Please fill all update fields correctly.";
    } else {
        $stmt = $conn->prepare("UPDATE exercises SET muscle_group = ?, exercise_name = ?, difficulty = ? WHERE exercise_id = ?");
        $stmt->bind_param("sssi", $muscle_group, $exercise_name, $difficulty, $exercise_id);
        $stmt->execute();
        $message = "Exercise updated successfully.";
    }
}

if (isset($_POST["delete"])) {
    $delete_id = intval($_POST["delete_id"]);

    if ($delete_id <= 0) {
        $message = "Please enter a valid ID to delete.";
    } else {
        $stmt = $conn->prepare("DELETE FROM exercises WHERE exercise_id = ?");
        $stmt->bind_param("i", $delete_id);
        $stmt->execute();
        $message = "Exercise deleted successfully.";
    }
}

$allExercises = $conn->query("SELECT exercise_id, muscle_group, exercise_name, difficulty FROM exercises ORDER BY exercise_id");
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manage Exercises</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="d-flex flex-column min-vh-100 bg-light">

<div class="navbar navbar-expand-lg navbar-dark bg-primary">
    <div class="container">
        <a class="navbar-brand" href="index.html">Gym Exercises System</a>

        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
            <span class="navbar-toggler-icon"></span>
        </button>

        <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav">
                <li class="nav-item"><a class="nav-link" href="exercises.html">Exercises</a></li>
                <li class="nav-item"><a class="nav-link" href="plans.html">Workout Plans</a></li>
                <li class="nav-item"><a class="nav-link" href="contact.html">Contact</a></li>
                <li class="nav-item"><a class="nav-link" href="about.html">About</a></li>
                <li class="nav-item"><a class="nav-link" href="questionnaire.html">Questionnaire</a></li>
                <li class="nav-item"><a class="nav-link" href="calculator.html">Calculator</a></li>
                <li class="nav-item"><a class="nav-link" href="search_exercises.php">Search Exercises</a></li>
                <li class="nav-item"><a class="nav-link active" href="manage_exercises.php">Manage Exercises</a></li>
            </ul>
        </div>
    </div>
</div>

<div class="container my-5 flex-fill">
    <h2 class="text-center text-primary mb-4">Manage Exercises Database</h2>

    <?php if ($message != "") { ?>
        <div class="alert alert-info text-center"><?php echo htmlspecialchars($message); ?></div>
    <?php } ?>

    <div class="row">
        <div class="col-md-4 mb-4">
            <div class="card shadow p-3 h-100">
                <h4 class="text-primary">Insert Exercise</h4>
                <form method="post" action="manage_exercises.php">
                    <label class="form-label">Muscle Group</label>
                    <input type="text" name="muscle_group" class="form-control mb-2" required>

                    <label class="form-label">Exercise Name</label>
                    <input type="text" name="exercise_name" class="form-control mb-2" required>

                    <label class="form-label">Difficulty</label>
                    <select name="difficulty" class="form-select mb-3" required>
                        <option value="">Choose</option>
                        <option>Beginner</option>
                        <option>Intermediate</option>
                        <option>Advanced</option>
                    </select>

                    <button type="submit" name="insert" class="btn btn-primary w-100">Insert</button>
                </form>
            </div>
        </div>

        <div class="col-md-4 mb-4">
            <div class="card shadow p-3 h-100">
                <h4 class="text-primary">Update Exercise</h4>
                <form method="post" action="manage_exercises.php">
                    <label class="form-label">Exercise ID</label>
                    <input type="number" name="exercise_id" class="form-control mb-2" required>

                    <label class="form-label">New Muscle Group</label>
                    <input type="text" name="new_muscle_group" class="form-control mb-2" required>

                    <label class="form-label">New Exercise Name</label>
                    <input type="text" name="new_exercise_name" class="form-control mb-2" required>

                    <label class="form-label">New Difficulty</label>
                    <select name="new_difficulty" class="form-select mb-3" required>
                        <option value="">Choose</option>
                        <option>Beginner</option>
                        <option>Intermediate</option>
                        <option>Advanced</option>
                    </select>

                    <button type="submit" name="update" class="btn btn-warning w-100">Update</button>
                </form>
            </div>
        </div>

        <div class="col-md-4 mb-4">
            <div class="card shadow p-3 h-100">
                <h4 class="text-primary">Delete Exercise</h4>
                <form method="post" action="manage_exercises.php">
                    <label class="form-label">Exercise ID</label>
                    <input type="number" name="delete_id" class="form-control mb-3" required>
                    <button type="submit" name="delete" class="btn btn-danger w-100">Delete</button>
                </form>
            </div>
        </div>
    </div>

    <div class="card shadow p-4">
        <h4 class="text-center text-primary">Current Exercises Table</h4>
        <table class="table table-striped table-bordered text-center">
            <thead>
                <tr class="table-primary">
                    <th>ID</th>
                    <th>Muscle Group</th>
                    <th>Exercise Name</th>
                    <th>Difficulty</th>
                </tr>
            </thead>
            <tbody>
                <?php while ($row = $allExercises->fetch_assoc()) { ?>
                    <tr>
                        <td><?php echo htmlspecialchars($row["exercise_id"]); ?></td>
                        <td><?php echo htmlspecialchars($row["muscle_group"]); ?></td>
                        <td><?php echo htmlspecialchars($row["exercise_name"]); ?></td>
                        <td><?php echo htmlspecialchars($row["difficulty"]); ?></td>
                    </tr>
                <?php } ?>
            </tbody>
        </table>
    </div>
</div>

<footer class="bg-primary text-white text-center p-3">
    <p>© 2026 Gym Exercises System</p>
</footer>

</body>
</html>
