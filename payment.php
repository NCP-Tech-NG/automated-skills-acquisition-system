<?php
session_start();
require_once 'config/database.php';

if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

$user_id = (int) $_SESSION['user_id'];
$course = isset($_GET['course']) ? trim($_GET['course']) : '';

if ($course === '') {
    $course = 'General Skills Acquisition Course';
}

$amount = 0.00;
$message = '';
$error = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $course = trim($_POST['course'] ?? $course);

    if ($course === '') {
        $error = "Please select a course before making payment.";
    } else {
        // Demo payment: no real money is charged.
        $reference = 'ASAMS-' . date('YmdHis') . '-' . strtoupper(bin2hex(random_bytes(3)));

        $conn->begin_transaction();

        try {
            $stmt = $conn->prepare(
                "SELECT id FROM enrollments WHERE user_id = ? AND course_name = ? LIMIT 1"
            );
            $stmt->bind_param("is", $user_id, $course);
            $stmt->execute();
            $existing = $stmt->get_result()->fetch_assoc();
            $stmt->close();

            if ($existing) {
                $conn->rollback();
                $message = "You are already enrolled in this course.";
            } else {
                $stmt = $conn->prepare(
                    "INSERT INTO payments (user_id, course_name, amount, reference, status)
                     VALUES (?, ?, ?, ?, 'successful')"
                );
                $stmt->bind_param("isds", $user_id, $course, $amount, $reference);
                $stmt->execute();
                $payment_id = $stmt->insert_id;
                $stmt->close();

                $stmt = $conn->prepare(
                    "INSERT INTO enrollments (user_id, course_name, payment_id)
                     VALUES (?, ?, ?)"
                );
                $stmt->bind_param("isi", $user_id, $course, $payment_id);
                $stmt->execute();
                $stmt->close();

                $conn->commit();

                $message = "Demo payment completed successfully. You are now enrolled in " . $course . ".";
            }
        } catch (Throwable $e) {
            $conn->rollback();
            $error = "The demo payment could not be completed. Please try again.";
        }
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Make Payment - ASAMS</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
<div class="container py-5">
    <div class="card shadow-sm mx-auto" style="max-width: 650px;">
        <div class="card-body p-4">
            <h2 class="mb-3">MAKE PAYMENT</h2>
            <p class="text-muted">ASAMS demo payment page. No real money is charged.</p>

            <?php if ($message): ?>
                <div class="alert alert-success"><?= htmlspecialchars($message) ?></div>
            <?php endif; ?>

            <?php if ($error): ?>
                <div class="alert alert-danger"><?= htmlspecialchars($error) ?></div>
            <?php endif; ?>

            <form method="post">
                <input type="hidden" name="course" value="<?= htmlspecialchars($course) ?>">

                <div class="mb-3">
                    <label class="form-label">Course</label>
                    <input type="text" class="form-control" value="<?= htmlspecialchars($course) ?>" readonly>
                </div>

                <div class="mb-3">
                    <label class="form-label">Amount</label>
                    <input type="text" class="form-control" value="Demo / Free" readonly>
                </div>

                <button type="submit" class="btn btn-primary w-100">
                    Complete Demo Payment
                </button>
            </form>

            <div class="mt-3 text-center">
                <a href="courses.php">Back to Courses</a>
            </div>
        </div>
    </div>
</div>
</body>
</html>
