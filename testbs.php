<?php
session_start();
include("php/config.php");

if (isset($_GET['id'])) {
    $id = $_GET['id'];
    $sql = "SELECT * FROM product WHERE p_id='{$id}'";
    $rs = mysqli_query($con, $sql);
    $data = mysqli_fetch_array($rs);
    
    if ($data) {
        $_SESSION['sid'][$id] = $data['p_id'];
        $_SESSION['sname'][$id] = $data['p_name'];
        $_SESSION['sprice'][$id] = $data['p_price'];
        $_SESSION['spicture'][$id] = $data['p_picture'];
        $_SESSION['sitem'][$id] = isset($_SESSION['sitem'][$id]) ? $_SESSION['sitem'][$id] + 1 : 1;
    }
}
?>
<!doctype html>
<html>
<head>
    <meta charset="utf-8">
    <title>ตะกร้าสินค้า</title>
    <link href="bootstrap.css" rel="stylesheet" type="text/css">
</head>
<body>
    <section class="py-24 relative">
        <div class="w-full max-w-7xl px-4 md:px-5 lg-6 mx-auto">
            <h2 class="title font-manrope font-bold text-4xl leading-10 mb-8 text-center text-black">Shopping Cart</h2>
            <?php if (!empty($_SESSION['sid'])) {
                $total = 0;
                $i = 0;
                foreach ($_SESSION['sid'] as $pid) {
                    $i++;
                    $sum = $_SESSION['sprice'][$pid] * $_SESSION['sitem'][$pid];
                    $total += $sum;
            ?>
            <div class="rounded-3xl border-2 border-gray-200 p-4 lg:p-8 grid grid-cols-12 mb-8 max-lg:max-w-lg max-lg:mx-auto gap-y-4">
                <div class="col-span-12 lg:col-span-2 img box">
                    <img src="images/<?php echo $_SESSION['spicture'][$pid]; ?>" alt="<?php echo $_SESSION['sname'][$pid]; ?>" class="max-lg:w-full lg:w-[180px] rounded-lg object-cover">
                </div>
                <div class="col-span-12 lg:col-span-10 detail w-full lg:pl-3">
                    <div class="flex items-center justify-between w-full mb-4">
                        <h5 class="font-manrope font-bold text-2xl leading-9 text-gray-900"><?php echo $_SESSION['sname'][$pid]; ?></h5>
                        <a href="clear2.php?id=<?php echo $pid; ?>" class="rounded-full group flex items-center justify-center focus-within:outline-red-500">
                            <svg width="34" height="34" viewBox="0 0 34 34" fill="none" xmlns="http://www.w3.org/2000/svg">
                                <circle class="fill-red-50 transition-all duration-500 group-hover:fill-red-400" cx="17" cy="17" r="17" fill="" />
                                <path class="stroke-red-500 transition-all duration-500 group-hover:stroke-white" d="M14.1673 13.5997V12.5923M12.4673 13.5997H21.534V18.8886C21.534 20.6695 21.534 21.5599 20.9807 22.1131C20.4275 22.6664 19.5371 22.6664 17.7562 22.6664H16.2451C14.4642 22.6664 13.5738 22.6664 13.0206 22.1131C12.4673 21.5599 12.4673 20.6695 12.4673 18.8886V13.5997Z" stroke="#EF4444" stroke-width="1.6" stroke-linecap="round"/>
                            </svg>
                        </a>
                    </div>
                    <div class="flex justify-between items-center">
                        <div class="flex items-center gap-4">
                            <input type="text" id="number" class="border border-gray-200 rounded-full w-10 aspect-square outline-none text-gray-900 font-semibold text-sm py-1.5 px-3 bg-gray-100 text-center" value="<?php echo $_SESSION['sitem'][$pid]; ?>" readonly>
                        </div>
                        <h6 class="text-indigo-600 font-manrope font-bold text-2xl leading-9 text-right"><?php echo number_format($_SESSION['sprice'][$pid], 0); ?> บาท</h6>
                    </div>
                </div>
            </div>
            <?php } ?>
            <div class="flex flex-col md:flex-row items-center md:items-center justify-between lg:px-6 pb-6 border-b border-gray-200 max-lg:max-w-lg max-lg:mx-auto">
                <h5 class="text-gray-900 font-manrope font-semibold text-2xl leading-9 w-full max-md:text-center max-md:mb-4">Subtotal</h5>
                <div class="flex items-center justify-between gap-5">
                    <h6 class="font-manrope font-bold text-3xl lead-10 text-indigo-600"><?php echo number_format($total, 0); ?> บาท</h6>
                </div>
            </div>
            <div class="max-lg:max-w-lg max-lg:mx-auto">
                <p class="font-normal text-base leading-7 text-gray-500 text-center mb-5 mt-6">Shipping taxes, and discounts calculated at checkout</p>
                <a href="record.php" class="rounded-full py-4 px-6 bg-indigo-600 text-white font-semibold text-lg w-full text-center transition-all duration-500 hover:bg-indigo-700">Checkout</a>
            </div>
            <?php } else { ?>
            <div class="text-center">
                <p class="font-normal text-base leading-7 text-gray-500">ไม่มีสินค้าในตะกร้า</p>
            </div>
            <?php } ?>
        </div>
    </section>
</body>
</html>
