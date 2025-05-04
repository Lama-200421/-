 <?php
session_start();
$conn = new mysqli("localhost", "root", "", "school_wallet");


if (!isset($_SESSION['id'])) {
    die("الرجاء تسجيل الدخول أولاً.");
}

$userID = $_SESSION['id'];


if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $studentName = $_POST['student_name'];
    $birthDate = $_POST['birth_date'];
    $schoolName = $_POST['school_name'];


    $sql = "INSERT INTO dependents (student_name, birth_date, school_name, user_id)
            VALUES ('$studentName', '$birthDate', '$schoolName', '$userID')";
    $conn->query($sql);
}


$result = $conn->query("SELECT * FROM dependents WHERE user_id = $userID");
?>

<!DOCTYPE html>
<html lang="ar"…
 <?php
session_start();
$conn = new mysqli("localhost", "root", "", "school_wallet");

if (!isset($_SESSION['id'])) {
    die("الرجاء تسجيل الدخول أولاً.");
}

$userID = $_SESSION['id'];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $studentName = $_POST['student_name'];
    $birthDate = $_POST['birth_date'];
    $schoolName = $_POST['school_name'];

    $sql = "INSERT INTO dependents (student_name, birth_date, school_name, user_id)
            VALUES ('$studentName', '$birthDate', '$schoolName', '$userID')";
    $conn->query($sql);
}

$result = $conn->query("SELECT * FROM dependents WHERE user_id = $userID");
?>

<!DOCTYPE html>
<html lang="ar" dir="rtl">
<head>
    <meta charset="UTF-8">
    <title>إضافة تابع</title>
    <link href="https://fonts.googleapis.com/css2?family=Tajawal:wght@400;700&display=swap" rel="stylesheet">
    <style>
        body {
            font-family: 'Tajawal', sans-serif;
          margin: 0;
            padding: 0 ;
            max-width: 1200px;
        }

        header {
            position: fixed;
            top: 0;
            width: 100%;
            background-color: #6495ED;
            color: #00008B;
            display: flex;
            align-items: center;
            justify-content: space-between;
            padding: 10px 30px;
            box-shadow: 0 2px 5px rgba(0,0,0,0.1);
            z-index: 1000;
        }

        .header-left {
            display: flex;
            align-items: center;
        }

        .logo {
            height: 45px;
            margin-right: 0;
        }

        .site-title {
            font-size: 16px;
            font-weight: bold;
            color: white;
            margin-right: 5px;
        }

        .nav-links a {
            color: #00008B;
            text-decoration: none;
            font-weight: bold;
            font-size: 14px;
            padding: 4px 10px;
            transition: background 0.3s;
            margin-left: 45px;
        }

        .nav-links a:hover {
            background-color: #00008B;
            color: white;
            border-radius: 6px;
        }

        .user {
            position: relative;
            display: flex;
            align-items: center;
            margin-left: 60px;
        }

        .user img {
            width: 45px;
            height: 45px;
            border-radius: 50%;
            border: 2px solid white;
        }

        .dropdown {
            display: none;
            position: absolute;
            background-color: white;
            min-width: 160px;
            top: 50px;
            left: 0;
            border-radius: 8px;
        }

        .dropdown a {
            color: #00008B;
            padding: 12px 16px;
            display: block;
            text-decoration: none;
        }

        .dropdown a:hover {
            background-color: #6495ED;
            color: white;
        }

        .user:hover .dropdown {
            display: block;
        }

        footer {
            position: fixed;
            bottom: 0;
            width: 100%;
            background-color: #6495ED;
            color: white;
            text-align: center;
            padding: 10px;
            font-size: 14px;
        }

        h2 {
            color: #6495ED;
            font-weight: bold;
            margin-top: 100px;
        }

        form {
            display: flex;
            align-items: center;
            gap: 10px;
            flex-wrap: wrap;
            margin-bottom: 20px;
        }

        label {
            color: black;
            font-size: 14px;
        }

        input[type="text"], input[type="date"] {
            border: 1px solid #6495ED;
            border-radius: 8px;
            padding: 6px;
        }

        button {
            border-radius: 8px;
            background-color: #6495ED;
            color: #00008B;
            border: none;
            padding: 8px 16px;
            cursor: pointer;
        }

        button:hover {
            background-color: #00008B;
            color: white;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 80px;
        }

        th {
            background-color: #f0f0f0;
            padding: 10px;
            text-align: center;
        }

        td {
            text-align: center;
            padding: 8px;
            border: 1px solid #ccc;
        }
    </style>
</head>
<body>

<header>
  <div class="header-left">
    <img src="logo.png" alt="شعار" class="logo">
    <span class="site-title">محفظة المدرسة</span>
  </div>

  <nav class="nav-links">
    <a href="#">الرئيسية</a>
    <a href="#">إضافة الأموال</a>
    <a href="#">التابعين</a>
    <a href="#">مسببات الحساسة</a>
    <a href="#">تواصل معنا</a>
  </nav>

  <div class="user">
    <img src="user.png" alt="العميل">
    <div class="dropdown">
      <a href="#">إنشاء الحساب</a>
      <a href="#">تسجيل الدخول</a>
      <a href="#">تحديث الملف الشخصي</a>
    </div>
  </div>
</header>

<h2>إضافة تابع</h2>
<form method="POST">
    <label>اسم الطالب:</label>
    <input type="text" name="student_name" required>

    <label>تاريخ الميلاد:</label>
    <input type="date" name="birth_date" required>

    <label>اسم المدرسة:</label>
    <input type="text" name="school_name" required>

    <button type="submit">إضافة</button>
</form>

<h3>قائمة التابعين:</h3>
<?php if ($result && $result->num_rows > 0): ?>
    <table>
        <tr>
            <th>اسم الطالب</th>
            <th>تاريخ الميلاد</th>
            <th>اسم المدرسة</th>
        </tr>
        <?php while ($row = $result->fetch_assoc()): ?>
            <tr>
                <td><?php echo htmlspecialchars($row['student_name']); ?></td>
                <td><?php echo htmlspecialchars($row['birth_date']); ?></td>
                <td><?php echo htmlspecialchars($row['school_name']); ?></td>
            </tr>
        <?php endwhile; ?>
    </table>
<?php else: ?>
    <p>لا يوجد تابعين حتى الآن.</p>
<?php endif; ?>

<footer>©️ 2025 جميع الحقوق محفوظة</footer>

</body>
</html>
