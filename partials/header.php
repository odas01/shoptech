<?php
if (!isset($_SESSION['user'])) {
    $_SESSION['user'] = array(
        'id' => '',
        'name' => '',
        'password' => ''
    );
}   

if (!empty($_GET['action'])) {
    switch ($_GET['action']) {
        case 'login':
            $query = "SELECT * FROM `user` WHERE `email` LIKE '{$_GET['email']}'";
            $result = mysqli_query($conn, $query);
            $fullname = mysqli_fetch_array($result);
            $_SESSION['user']['name'] = $fullname['fullname'];
            $_SESSION['user']['id'] = $fullname['id'];
            $_SESSION['user']['password'] = $fullname['password'];
            

            $result = mysqli_query($conn, "SELECT `product_id`, `quantity`
            FROM `cart`
            INNER JOIN `product`
            ON `cart`.`product_id` = `product`.`id`
            WHERE `cart`.`user_id` = {$_SESSION['user']['id']}");
            $carts = array();
            while ($row = mysqli_fetch_array($result)) {
                $carts[$row['product_id']] = $row['quantity'];
            }
            $_SESSION['cart'] = $carts;

            header('Location: ./index.php');
            break;
        case 'logout':
            unset($_SESSION['user']);
            unset($_SESSION['cart']);
            header('Location: ./index.php');
            break;
    }
}
?>

<div class="header">
    <div class="container">
        <div class="header__container">
            <div class="menu__mobile">
                <div class="menu__mobile-img">
                    <img src="../asset/img/navbar/menu.png" alt="" />
                </div>

                <div class="dropdown">
                    <div class="dropdown__overlay"></div>
                    <div class="dropdown__body">
                        <div class="dropdown__list">
                            <div class="dropdown__top">
                                <?php if (!empty($_SESSION['user']['name'])) { ?>
                                    <div class="dropdown__user">
                                        <div class="dropdown__user-infor">
                                            <img src="../asset/img/navbar/user_mobile2.png" alt="">
                                            <span><?= $_SESSION['user']['name'] ?></span>
                                        </div>
                                        <a href="./index.php?action=logout" class="dropdown__user-logout">
                                            Đăng xuất
                                        </a>
                                    </div>
                                <?php } else { ?>
                                    <i class="far fa-user"></i>
                                    <a href="./login.php">Đăng nhập</a>
                                <?php } ?>
                            </div>
                            <div class="dropdown__main">
                                <a href="./index.php">TRANG CHỦ</a>
                                <a href="./index.php">LIÊN HỆ</a>
                                <a href="./index.php">HỖ TRỢ</a>
                            </div>
                            <div class="dropdown__bottom">
                                <p>Số điện thoại: <span>0329881171</span></p>
                                <p>Email: <span>lntthanh3317@gmail.com</span></p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="logo">
                <a href="index.php">
                    <img src="../asset/img/navbar/logo.png" alt="" />
                </a>
            </div>
            <div class="search">
                <div class="search__wrap">
                    <input type="text" placeholder="Nhập tên sản phẩm cần tìm..." />
                    <div class="search__btn">
                        <i class="fa-solid fa-magnifying-glass"></i>
                    </div>
                    <div class="search__list"></div>
                </div>
            </div>
            <a href="<?= isset($_SESSION['cart']) ? "cart.php" : "login.php" ?>" class="header__cart">
                <div class="header__cart-icon">
                    <img src="../asset/img/cart/cart.png" alt="" />
                </div>
                <span class="position-absolute  top-0 start-100 translate-middle badge rounded-pill bg-info">
                    <?= isset($_SESSION['cart']) ? count($_SESSION['cart']) : 0 ?>
                </span>
            </a>

            <div class="header__user">
                <?php if (!empty($_SESSION['user']['name'])) { ?>
                    <div class="header__user-login">
                        <div class="header__user-login--img">
                            <img src="../asset/img/navbar/user_mobile2.png" alt="">
                        </div>
                        <span><?= $_SESSION['user']['name'] ?></span>
                        <ul class="header__user-menu">
                            <li class="header__user-item"><a href="./index.php?action=logout">Đăng xuất</a></li>
                            <li class="header__user-item">

                                <a href="./login.php?action=changePassword">
                                    Đổi mật khẩu
                                </a>
                            </li>
                        </ul>
                    </div>

                <?php } else { ?>
                    <a href="../page/login.php" class="header__user-link">
                        <span>Đăng nhập</span>
                    </a>
                <?php
                }
                ?>
            </div>
        </div>
    </div>
</div>