<?php
require_once "config/database.php";
$message = "";
if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $first = trim($_POST["first_name"]);
    $last = trim($_POST["last_name"]);
    $gender = $_POST["gender"];
    $email = trim($_POST["email"]);
    $address = trim($_POST["address"]);
    $phone = trim($_POST["phone"]);
    $username = trim($_POST["username"]);
    $password = $_POST["password"];
    $confirm = $_POST["confirm_password"];

    if ($password !== $confirm) {
        $message = "Passwords do not match.";
    } else {
        $hash = password_hash($password, PASSWORD_DEFAULT);
        $stmt = $conn->prepare("INSERT INTO users(first_name,last_name,gender,email,address,phone,username,password) VALUES(?,?,?,?,?,?,?,?)");
        $stmt->bind_param("ssssssss",$first,$last,$gender,$email,$address,$phone,$username,$hash);
        if ($stmt->execute()) $message = "Registration successful. You can now login.";
        else $message = "Registration failed: " . $conn->error;
    }
}
?>
<!doctype html><html><head><meta charset="utf-8"><meta name="viewport" content="width=device-width,initial-scale=1">
<title>Register | NCP-Tech-NG</title><link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet"><link rel="stylesheet" href="assets/css/style.css"></head>
<body><div class="container py-5"><div class="form-card mx-auto">
<h2>NCP-Tech-NG Registration</h2><?php if($message): ?><div class="alert alert-info"><?=htmlspecialchars($message)?></div><?php endif; ?>
<form method="post"><div class="row g-3">
<div class="col-md-6"><input required name="first_name" class="form-control" placeholder="First name"></div>
<div class="col-md-6"><input required name="last_name" class="form-control" placeholder="Last name"></div>
<div class="col-md-6"><select required name="gender" class="form-select"><option value="">Gender</option><option>Male</option><option>Female</option><option>Other</option></select></div>
<div class="col-md-6"><input required type="email" name="email" class="form-control" placeholder="Email"></div>
<div class="col-12"><input required name="address" class="form-control" placeholder="Address"></div>
<div class="col-md-6"><input name="phone" class="form-control" placeholder="Phone (optional)"></div>
<div class="col-md-6"><input required name="username" class="form-control" placeholder="Username"></div>
<div class="col-md-6"><input required type="password" name="password" class="form-control" placeholder="Password"></div>
<div class="col-md-6"><input required type="password" name="confirm_password" class="form-control" placeholder="Confirm password"></div>
</div><button class="btn btn-primary w-100 mt-4">Register</button></form>
<p class="mt-3">Already registered? <a href="login.php">Login</a></p></div></div></body></html>
