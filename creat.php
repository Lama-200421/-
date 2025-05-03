<?php

$conn = new mysqli("localhost", "root", "", "school_wallet");


if ($conn->connect_error) {
    die("<script>alert('فشل الاتصال بقاعدة البيانات');</script>");
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = $_POST['username'];
    $nationalid = $_POST['nationalid'];
    $email = $_POST['email'];
    $password = $_POST['password'];
    $confirm = $_POST['confirm'];

    if ($password !== $confirm) {
        echo "<script>alert('كلمة المرور غير متطابقة!');</script>";
    } else {
        $hashed_password = password_hash($password, PASSWORD_DEFAULT);

        $sql = "INSERT INTO users (username, email, password, nationalid)
                VALUES ('$username', '$email', '$hashed_password', '$nationalid')";

        if ($conn->query($sql) === TRUE) {
			            echo "<script>alert('تم إنشاء الحساب بنجاح!');</script>";

        } else {
            echo "<script>alert('خطأ أثناء التسجيل: " . $conn->error . "');</script>";
        }
    }
}

$conn->close();
?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <style>
        body {
      font-family:'Tajawal', sans-serif;
            background: linear-gradient(to right, #e2e2e2, #c9d6ff);
            margin: 0;
        }

        .tit {
            max-width: 450px;
            margin: 80px auto;
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
            border: none;
            border-bottom: 1px solid #757575;
        }
		
        button {
            width: 100%;
            padding: 12px;
            background-color:#6495ED;
            color: #00008B;
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
        <h1>إنشاء حساب جديد</h1>
        <form action="creat.php" method="POST">
            <input type="text" name="username" placeholder="اسم المستخدم" required>
            <input type="text" name="nationalid" placeholder="رقم الهوية" required>
            <input type="email" name="email" placeholder="البريد الإلكتروني" required>
            <input type="password" name="password" placeholder="كلمة المرور" required>
            <input type="password" name="confirm" placeholder="تأكيد كلمة المرور" required>
            <button type="submit">تسجيل</button>
        </form>

        <div class="link">
            <p>لديك حساب؟ <a href="login.php">تسجيل الدخول</a></p>
        </div>
    </div>

</body>
</html>
