<?php
include "db_connect.php";

$search = "";
$level = "";
$results = [];

if (isset($_GET["search"]) || isset($_GET["level"])) {
    $search = trim($_GET["search"] ?? "");
    $level = trim($_GET["level"] ?? "");

    $sql = "SELECT exercise_id, muscle_group, exercise_name, difficulty FROM exercises WHERE 1=1";
    $types = "";
    $params = [];

    if ($search != "") {
        $sql .= " AND (exercise_name LIKE ? OR muscle_group LIKE ?)";
        $keyword = "%" . $search . "%";
        $types .= "ss";
        $params[] = $keyword;
        $params[] = $keyword;
    }

    if ($level != "") {
        $sql .= " AND difficulty = ?";
        $types .= "s";
        $params[] = $level;
    }

    $stmt = $conn->prepare($sql);

    if (!empty($params)) {
        $stmt->bind_param($types, ...$params);
    }

    $stmt->execute();
    $results = $stmt->get_result();
} else {
    $sql = "SELECT exercise_id, muscle_group, exercise_name, difficulty FROM exercises";
    $results = $conn->query($sql);
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Search Exercises</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="d-flex flex-column min-vh-100 bg-light">

<nav class="navbar navbar-expand-lg navbar-dark bg-primary">
    <div class="container">
        <a class="navbar-brand" href="index.html">Gym Exercises System</a>
        <div class="collapse navbar-collapse show">
            <ul class="navbar-nav">
                <li class="nav-item"><a class="nav-link" href="exercises.html">Exercises</a></li>
                <li class="nav-item"><a class="nav-link" href="plans.html">Workout Plans</a></li>
                <li class="nav-item"><a class="nav-link active" href="search_exercises.php">Search DB</a></li>
                <li class="nav-item"><a class="nav-link" href="manage_exercises.php">Manage DB</a></li>
            </ul>
        </div>
    </div>
</nav>

<div class="container my-5 flex-fill">
    <div class="card shadow p-4">
        <h2 class="text-center text-primary">Search Exercises</h2>
        <p class="text-center">Search by exercise name, muscle group, or difficulty level.</p>

        <form method="get" action="search_exercises.php" class="row g-3 mb-4">
            <div class="col-md-6">
                <label class="form-label">Exercise Name or Muscle Group</label>
                <input type="text" name="search" class="form-control" value="<?php echo htmlspecialchars($search); ?>" placeholder="Example: Chest or Bench Press">
            </div>

            <div class="col-md-4">
                <label class="form-label">Difficulty</label>
                <select name="level" class="form-select">
                    <option value="">All</option>
                    <option value="Beginner" <?php if ($level == "Beginner") echo "selected"; ?>>Beginner</option>
                    <option value="Intermediate" <?php if ($level == "Intermediate") echo "selected"; ?>>Intermediate</option>
                    <option value="Advanced" <?php if ($level == "Advanced") echo "selected"; ?>>Advanced</option>
                </select>
            </div>

            <div class="col-md-2 d-flex align-items-end">
                <button type="submit" class="btn btn-primary w-100">Search</button>
            </div>
        </form>

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
                <?php if ($results && $results->num_rows > 0) { ?>
                    <?php while ($row = $results->fetch_assoc()) { ?>
                        <tr>
                            <td><?php echo htmlspecialchars($row["exercise_id"]); ?></td>
                            <td><?php echo htmlspecialchars($row["muscle_group"]); ?></td>
                            <td><?php echo htmlspecialchars($row["exercise_name"]); ?></td>
                            <td><?php echo htmlspecialchars($row["difficulty"]); ?></td>
                        </tr>
                    <?php } ?>
                <?php } else { ?>
                    <tr><td colspan="4">No matching exercises found.</td></tr>
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
