<?php
@session_start(); // เริ่มต้นเซสชัน ถ้ายังไม่ได้เริ่ม

@session_destroy();

// เปลี่ยนเส้นทางไปยังหน้าหลัก
echo "กำลังกลับสู่หน้าหลัก....";
echo "<meta http-equiv=\"refresh\" content=\"2;URL=home.php\">";
?>
<meta charset="utf-8">
