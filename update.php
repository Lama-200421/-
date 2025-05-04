<?php
session_start();

// التحقق من تسجيل الدخول
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php"); // إذا لم يكن مسجل الدخول، يتم التوجيه لصفحة تسجيل الدخول
    exit();
}

$user_id = $_SESSION['user_id']; // استرجاع user_id من الجلسة

// الاتصال بقاعدة البيانات
$conn = new mysqli("localhost", "root", "", "school_wallet");

// التحقق من الاتصال بقاعدة البيانات
if ($conn->connect_error) {
    die("<script>alert('فشل الاتصال بقاعدة البيانات');</script>");
}

// جلب بيانات المستخدم من جدول users
$sql = "SELECT * FROM users WHERE id = '$user_id'";
$result = $conn->query($sql);

// التحقق إذا كانت الاستعلامات جلبت بيانات
if ($result->num_rows > 0) {
    $user = $result->fetch_assoc();
} else {
    die("<script>alert('لا توجد بيانات للمستخدم');</script>");
}

// إذا المستخدم عدّل بياناته
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = $_POST['username'];
    $nationalid = $_POST['nationalid'];
    $email = $_POST['email'];

    if ($_FILES['profile_pic']['name']) {
        // حفظ الصورة في نفس مجلد المشروع
        $target = basename($_FILES['profile_pic']['name']);
        move_uploaded_file($_FILES['profile_pic']['tmp_name'], $target);
        $profile_pic = $target;

        $sql_update = "UPDATE users SET username='$username', nationalid='$nationalid', email='$email', `profile pic`='$profile_pic' WHERE id='$user_id'";
    } else {
        $sql_update = "UPDATE users SET username='$username', nationalid='$nationalid', email='$email' WHERE id='$user_id'";
    }

    if ($conn->query($sql_update) === TRUE) {
        echo "<script>alert('تم تحديث البيانات بنجاح!');</script>";
    } else {
        echo "<script>alert('حدث خطأ أثناء التحديث: " . $conn->error . "');</script>";
    }
}
?>

<html dir="rtl">
<head>
  <meta charset="UTF-8">
<title>profile</title>
  <link href="https://fonts.googleapis.com/css2?family=Tajawal:wght@400;700&display=swap" rel="stylesheet">

<style>


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
  height:45px;
    margin-right: 0px;
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
            background-color:#6495ED ;
			color: white;

        }

        .user:hover .dropdown{
            display: block;
        }

    footer {
      position: fixed;
      bottom: 0;
      width: 100%;
      background-color:#6495ED ;
      color: white;
      text-align: center;
      padding: 10px;
      font-size: 14px;
    }

body {
      background-color:#F0F0F0;
      font-family:'Tajawal', sans-serif;
      direction: rtl;
      margin:0;
      padding:0;
	    align-items: center;
		justify-content: center;
		display: flex;
		color: #6495ED;
    }
	
	
#preview {
  display: block;
  margin: 10px auto;
  border-radius: 50%;
  border: 2px solid #ccc;
}
button {
    width:60%;
    padding: 12px;
    margin: 40px auto;
    border-radius: 8px;
    font-size: 16px;
    background-color:#6495ED;
    color:#00008B;
    border: none;
}
button:hover {
    background-color:#00008B;
    color:white;
}
#profile-pic{
  display: none;
}
#profile-pic1{
    width:100px;
    padding: 12px;
    margin: 40px auto;
    border-radius: 8px;
    font-size: 16px;
    background-color:#6495ED;
    color:#00008B;
    border: none;
}
form {
width: 900px;
  height:900px;
  border-radius: 20px;
    
    margin: 120px;
    padding: 20px;
    border: 1px solid #ccc;
  
	 display: flex;
  flex-wrap: wrap;
  justify-content: space-between;
  align-items: center;
}

form h3 {
width:100%;
 font-size: 20px;
      color: #6495ED;
      font-weight: bold;
      margin-bottom: 20px;
   color:#00008B;
  text-align: center;
   font-family:'Tajawal', sans-serif;
 
}
form h1 {color: #6495ED;}

form input[type="text"] {
  width: 45%;
  padding: 10px 15px;
  margin-bottom: 15px;
  border: none;
  border-bottom: 2px solid #6495ED;
  outline: none;
  font-size: 14px;
  text-align:right;
        background-color:#F0F0F0;
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
    <a href="home page.html">الرئيسية</a>
    <a href="add money.html">إضافة الأموال</a>
    <a href="dependents.html">التابعين</a>
    <a href="hhh.html">مسببات الحساسة</a>
    <a href="contactus.html">تواصل معنا</a>
  </nav>

  <div class="user">
    <img src="user.png" alt="العميل">
    <div class="dropdown">
      <a href="creat.php">إنشاء الحساب</a>
      <a href="login.php">تسجيل الدخول</a>
      <a href="update.php">تحديث الملف الشخصي</a>
    </div>
  </div>
</header>                                              <footer>©️ 2025 جميع الحقوق محفوظة</footer>

<hr/>
<form id="profile-form" method="POST" action="">
<h1>اعدادات الحساب ⚙️</h1><br><br>

<h3>تعديل الصورة الشخصية</h3>
  <input type="file" name="profile_pic" id="profile-pic" accept="image/*"><br><br>

  <img id="preview" src="default.png" width="150" style="margin-top:10px;"><br><br>
 <label for="profile-pic" id="profile-pic1">تغيير الصورة</label><br><br>
<hr/>

<h3>تغيير الايميل</h3>
  <input type="text" name="email" id="email" value="<?php echo htmlspecialchars($user['email']); ?>" required><br><br>
<hr/>

<h3>تغيير اسم المستخدم</h3>
  <input type="text" name="username" id="username" value="<?php echo htmlspecialchars($user['username']); ?>" required><br><br>
<hr/>

<h3>تغيير رقم الهوية</h3>
  <input type="text" name="nationalid" id="nationalid" value="<?php echo htmlspecialchars($user['nationalid']); ?>" required><br><br>
<hr/>

<button type="submit">حفظ التغييرات</button><br><br>
</form>

<script>
document.getElementById('profile-pic').addEventListener('change', function () {
  const file = this.files[0];
  if (file) {
    document.getElementById('preview').src = URL.createObjectURL(file);
  }
});
</script>
</body>
</html>
