<?php
session_start(); require_once "config/database.php"; $message="";
if($_SERVER["REQUEST_METHOD"]==="POST"){
 $username=trim($_POST["username"]); $password=$_POST["password"];
 $stmt=$conn->prepare("SELECT id,username,password FROM users WHERE username=? LIMIT 1");
 $stmt->bind_param("s",$username); $stmt->execute(); $result=$stmt->get_result(); $user=$result->fetch_assoc();
 if($user && password_verify($password,$user["password"])){ $_SESSION["user_id"]=$user["id"]; $_SESSION["username"]=$user["username"]; header("Location: dashboard.php"); exit; }
 $message="Invalid username or password.";
}
?>
<!doctype html><html><head><meta charset="utf-8"><meta name="viewport" content="width=device-width,initial-scale=1"><title>Login | NCP-Tech-NG</title><link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet"></head>
<body><div class="container py-5"><div class="form-card mx-auto"><h2>NCP-Tech-NG Login</h2><?php if($message): ?><div class="alert alert-danger"><?=$message?></div><?php endif; ?><form method="post"><input required name="username" class="form-control mb-3" placeholder="Username"><input required type="password" name="password" class="form-control mb-3" placeholder="Password"><button class="btn btn-primary w-100">Login</button></form><p class="mt-3">No account? <a href="register.php">Register</a></p></div></div></body></html>
