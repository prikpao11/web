<!doctype html>
<html lang="th">
<head>
<meta charset="utf-8">
<title>รายการใบสั่งซื้อ</title>
<style>
    body {
        background: url('images/back.jpg') no-repeat center center fixed; /* Update the image path */
        background-size: cover; /* Ensures the image covers the entire background */
        font-family: Arial, sans-serif;
        background-color: #f4f4f4;
        margin: 0;
        padding: 20px;
    }
    h1 {
        color: #333;
        text-align: center;
    }
    table {
        width: 100%;
        max-width: 800px;
        margin: 20px auto;
        border-collapse: collapse;
        background-color: #fff;
        box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
    }
    th, td {
        padding: 10px;
        text-align: center;
        border: 1px solid #ddd;
    }
    th {
        background-color: #f2f2f2;
        color: #333;
    }
    tr:nth-child(even) {
        background-color: #f9f9f9;
    }
    tr:hover {
        background-color: #f1f1f1;
    }
    a {
        color: #007bff;
        text-decoration: none;
    }
    a:hover {
        text-decoration: underline;
    }
</style>
</head>

<body>
<h1>รายการใบสั่งซื้อ</h1>
<table>
  <tr>
    <th width="153">รายละเอียด</th>
    <th width="153">เลขที่ใบสั่งซื้อ</th>
    <th width="193">วันที่</th>
    <th width="150">ราคารวม</th>
    <th width="155">ลูกค้า</th>
  </tr>
  
  <?php
	include("php/config.php");
	$sql = "SELECT * FROM `orders` ORDER BY oid DESC";
	$rs = mysqli_query($con, $sql);
	while ($data = mysqli_fetch_array($rs, MYSQLI_BOTH)) {
?>

  <tr>
    <td><a href="view_order_detail.php?a=<?=$data['oid'];?>">ดูรายละเอียด</a></td>
    <td><?=$data['oid'];?></td>
    <td><?=$data['odate'];?></td>
    <td><?=number_format($data['ototal'], 0);?></td>
    <td><?=$data['member_id'];?></td>
  </tr>
  
  <?php } ?>
  
</table>
</body>
</html>
