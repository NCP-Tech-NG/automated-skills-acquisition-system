<?php
session_start();
?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<title>NCP-Tech-NG | ASAMS</title>
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
<link rel="stylesheet" href="assets/css/style.css">
</head>
<body>
<nav class="navbar navbar-dark bg-dark">
  <div class="container"><a class="navbar-brand fw-bold" href="index.php">NCP-Tech-NG</a>
  <a class="btn btn-outline-light btn-sm" href="login.php">Login</a></div>
</nav>
<header class="hero py-5">
<div class="container py-5">
<h1>Automated Skills Acquisition Management System</h1>
<p class="lead">Learn, enroll and practice practical digital and vocational skills.</p>
<a class="btn btn-primary" href="register.php">Get Started</a>
</div></header>
<div class="container py-5">
<h2>Available Skills</h2>
<div class="row g-3">
<?php
$courses = ["Barbing","Tailoring","Python Programming","Java Programming","HTML"];
foreach ($courses as $course) {
 echo '<div class="col-md-4"><div class="card h-100 shadow-sm"><div class="card-body"><h5>'.htmlspecialchars($course).'</h5><p>Explore this skill and practice the course content.</p><a href="login.php" class="btn btn-outline-primary">Practice</a></div></div></div>';
}
?>
</div></div>
<footer class="py-4 text-center bg-light">© <?php echo date("Y"); ?> NCP-Tech-NG</footer>
</body></html>
