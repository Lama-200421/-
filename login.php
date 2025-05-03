<?php

session_start();

$conn = new mysqli("localhost", "root", "", "school_wallet");

if ($conn->connect_error) {
    die("<script>alert('فشل الاتصال بقاعدة البيانات');</script>");
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = $_POST['username'];
    $password = $_POST['password'];

    $sql = "SELECT * FROM users WHERE username='$username'";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
if (password_verify($password, $row['password'])) {
    $_SESSION['id'] = $row['id'];
    header("Location: dependents.php");
    exit();
}         else {
            echo "<script>alert('كلمة المرور غير صحيحة');</script>";
        }
    } else {
        echo "<script>alert('اسم المستخدم غير موجود');</script>";
    }
}

$conn->close();
?>

<html>
<head>
    <style>
        body {
      font-family:'Tajawal', sans-serif;
            background:linear-gradient(to right,#e2e2e2,#c9d6ff);
            margin: 0;
        }

        .tit {
            max-width: 400px;
            margin: 100px auto;
            background-color: white;
            padding: 30px;
            border-radius: 10px;
            box-shadow: 0 20px 35px rgba(0,0,1,0.7);
        }

			
        h1 {
			font-size:30px;
			font-weight:bold;
			margin-bottom:30px;
            text-align: center;
            color: #6495ED;
        }

        input {
            width: 100%;
            padding: 12px;
            margin: 10px 0;
            border:none;
            border-bottom:1px solid #757575;
        }
		
        button {
            width: 100%;
            padding: 12px;
            background-color:#6495ED;
            color:#00008B;
            border: none;
            border-radius: 6px;
            font-size: 16px;
        }

        button:hover {
            background-color: #00008B;
			color:white;
        }


        .link {
            text-align: center;
            margin-top: 15px;
        }

        .link a {
            color:#6495ED;
            text-decoration: none;
        }
    </style>
</head>
<body>

    <div class="tit">
        <h1>تسجيل الدخول</h1>
        <form action="login.php" method="POST">
            <input type="text" name="username" placeholder="اسم المستخدم" required>
            <input type="password" name="password" placeholder="كلمة المرور" required>
			            <button onclick="location.href='dependents.php'">دخول</button>

        </form>
        <div class="link">
            <p>مستخدم جديد؟ <a href="creat.php">إنشاء حساب</a></p>
        </div>
    </div>

</body>
</html>
