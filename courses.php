<?php
session_start();
require_once 'config/database.php';

if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

$user_id = (int) $_SESSION['user_id'];

$courses = [
    "Barbing",
    "Tailoring",
    "Python Programming",
    "Java Programming",
    "HTML"
];

$enrolled = [];
$stmt = $conn->prepare("SELECT course_name FROM enrollments WHERE user_id = ?");
$stmt->bind_param("i", $user_id);
$stmt->execute();
$result = $stmt->get_result();
while ($row = $result->fetch_assoc()) {
    $enrolled[$row['course_name']] = true;
}
$stmt->close();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Courses - ASAMS</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
<div class="container py-4">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2>Available Courses</h2>
        <a href="dashboard.php" class="btn btn-outline-secondary">Dashboard</a>
    </div>

    <input type="text" id="courseSearch" class="form-control mb-4"
           placeholder="Search course name...">

    <div class="row g-3" id="courseList">
        <?php foreach ($courses as $course): ?>
            <div class="col-md-6 course-card" data-course="<?= htmlspecialchars(strtolower($course)) ?>">
                <div class="card h-100 shadow-sm">
                    <div class="card-body">
                        <h5><?= htmlspecialchars($course) ?></h5>

                        <?php if (isset($enrolled[$course])): ?>
                            <span class="badge bg-success mb-3">Enrolled</span>
                            <br>
                            <a class="btn btn-success"
                               href="practice.php?course=<?= urlencode($course) ?>">
                                Practice Course
                            </a>
                        <?php else: ?>
                            <a class="btn btn-primary"
                               href="payment.php?course=<?= urlencode($course) ?>">
                                Make Payment & Enroll
                            </a>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
        <?php endforeach; ?>
    </div>
</div>

<script>
document.getElementById('courseSearch').addEventListener('input', function () {
    const query = this.value.toLowerCase().trim();

    document.querySelectorAll('.course-card').forEach(function (card) {
        card.style.display = card.dataset.course.includes(query) ? '' : 'none';
    });
});
</script>
</body>
</html>
