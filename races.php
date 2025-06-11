<?php include 'db/connect.php'; ?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Hanoi Marathon 2024</title>
    <link rel="stylesheet" href="css/styles.css">
</head>
<body>
    <header>
        <div class="logo">
            <img src="Image/logo.jpg" alt="Hanoi Marathon Logo">
            <h1>
                <span>Hanoi</span>
                <span>Marathon</span>
                <span>2024</span>
            </h1>
        </div>
        <nav>
            <ul>
                <li><a href="index.php">Home Page</a></li>
                <li><a href="races.php">Races</a></li>
                <li><a href="result.php">Result</a></li>
                <li><a href="index.php#contact">Contact</a></li>
                <li><a href="account.php">Account</a></li>
            </ul>
        </nav>
    </header>

    <main>
    <section id="races">
        <h2>Upcoming and Past Races</h2>
        <div class="race-container">
            <?php
            // Truy vấn lấy danh sách các giải chạy từ bảng marathon
            $query = "SELECT * FROM marathon ORDER BY Date DESC"; // Sắp xếp từ giải gần nhất
            $result = mysqli_query($conn, $query);
            session_start(); // Bắt đầu phiên làm việc
            if (!$result) {
                echo "Lỗi truy vấn: " . mysqli_error($conn); // Hiển thị lỗi nếu có
            } else {
                if (mysqli_num_rows($result) > 0) {
                    while ($row = mysqli_fetch_assoc($result)) {
                        $raceName = $row['RaceName'];
                        $raceDate = $row['Date'];
                        $raceID = $row['MarathonID'];
                        $today = date('Y-m-d');
                        $isPast = strtotime($raceDate) < strtotime($today);

                        // Tạo đường dẫn tới ảnh của giải chạy
                        $imagePath = "Image/photo" . $raceID . ".jpg"; // Đường dẫn ảnh

                        // Container cho mỗi giải chạy
                        echo "<div class='race-item' id='race-{$raceID}'>";
                        echo "<img src='{$imagePath}' alt='Race Image' class='race-image'>"; // Hiển thị ảnh
                        echo "<h3>{$raceName}</h3>";
                        echo "<p>Race date: {$raceDate}</p>";
                        if (!$isPast) {
                            // Bộ đếm ngược cho các giải chưa diễn ra
                            echo "<div class='countdown' id='countdown-{$raceID}' data-date='{$raceDate}'></div>";
                            // Kiểm tra người dùng đã đăng nhập chưa
                            if (isset($_SESSION['user_id'])) {
                                // Thêm nút "Join" cho các giải chạy chưa diễn ra, điều hướng tới trang race_details.php
                                echo "<a href='race_register.php?race_id={$raceID}' class='join-button'>Join</a>";
                            } else {
                                // Nếu chưa đăng nhập, hiển thị thông báo
                                echo "<a href='login.php' class='join-button'>Join</a>";
                            }
                        } else {
                            // Thông báo cho giải đã diễn ra
                            echo "<p class='race-status'>Ended</p>";
                        }

                        echo "</div>";
                    }
                } else {
                    echo "<p>Không có giải chạy nào.</p>";
                }
            }
            ?>
        </div>
    </section>
    </main>

    <a href="register.php" class="register-button">Register</a>

    <footer id="contact">
        <div class="organizer-info">
            <h2>BUI DUC NHI</h2>
            <p>Tel: +84 378-271-888 (not real :v )</p>
            <p>Email: <a href="mailto:buiducnhi@gmail.com">buiducnhi@gmail.com (not real :v)</a></p>
            <p>Address: Ha Noi</p>
        </div>
    </footer>
    <script src="js/script.js"></script>
</body>
</html>
