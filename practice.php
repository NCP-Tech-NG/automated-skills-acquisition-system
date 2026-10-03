<?php
session_start();
require_once 'config/database.php';

if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

$user_id = (int) $_SESSION['user_id'];
$course = trim($_GET['course'] ?? '');

if ($course === '') {
    header("Location: courses.php");
    exit();
}

$stmt = $conn->prepare(
    "SELECT id FROM enrollments WHERE user_id = ? AND course_name = ? LIMIT 1"
);
$stmt->bind_param("is", $user_id, $course);
$stmt->execute();
$enrollment = $stmt->get_result()->fetch_assoc();
$stmt->close();

if (!$enrollment) {
    header("Location: payment.php?course=" . urlencode($course));
    exit();
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Practice Course - ASAMS</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
<div class="container py-5">
    <div class="card shadow-sm mx-auto" style="max-width: 750px;">
        <div class="card-body p-4">
            <span class="badge bg-success mb-2">Enrolled</span>
            <h2>Practice: <?= htmlspecialchars($course) ?></h2>
            <p class="text-muted">
                You have successfully enrolled in this course. This practice page can
                be expanded with course lessons, coding exercises, videos, quizzes and
                other learning materials.
            </p>

            <div class="alert alert-info">
                Practice content for <strong><?= htmlspecialchars($course) ?></strong>
                is ready for development.
            </div>

            <a href="courses.php" class="btn btn-primary">Back to Courses</a>
        </div>
    </div>
</div>
</body>
</html>
