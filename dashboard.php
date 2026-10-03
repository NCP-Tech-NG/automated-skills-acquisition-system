<?php session_start(); if(!isset($_SESSION["user_id"])) { header("Location: login.php"); exit; } ?>
<!doctype html><html><head><meta charset="utf-8"><meta name="viewport" content="width=device-width,initial-scale=1"><title>Dashboard | NCP-Tech-NG</title><link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet"></head>
<body><nav class="navbar navbar-dark bg-dark"><div class="container"><span class="navbar-brand">NCP-Tech-NG ASAMS</span><a class="btn btn-outline-light btn-sm" href="logout.php">Logout</a></div></nav>
<div class="container py-5"><h1>Welcome, <?=htmlspecialchars($_SESSION["username"])?></h1><p>Select an option:</p>
<div class="d-grid gap-2 col-md-6"><a class="btn btn-success" href="payment.php">Make Payment</a><a class="btn btn-primary" href="courses.php">Search Courses</a></div></div></body></html>
