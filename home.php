<?php 
session_start();

if (!isset($_SESSION['username'])) {
    header("Location: index.php");
    exit();
}

include('header.php'); 
    
?>

<body>
    <?php include('navbar.php'); 
    ?>
    <div class="container">
        <h1 class="page-header text-center">MENU </h1>
        <ul class="nav nav-tabs">
            <?php
            $sql = "SELECT * FROM category ORDER BY CategoryID ASC";
            $query = $conn->query($sql);
            $firstTab = true; // Variable to track the first tab
            while ($row = $query->fetch_assoc()) {
                $categoryName = $row['CategoryName'];
            ?>
                <li class="<?php echo $firstTab ? 'active' : ''; ?>"><a data-toggle="tab" href="#<?php echo str_replace(' ', '', $categoryName); ?>"><?php echo $categoryName; ?></a></li>
            <?php
                $firstTab = false; // Set to false after the first iteration
            }
            ?>
        </ul>

        <div class="tab-content">
            <?php
            $query = $conn->query($sql);
            $firstPane = true; // Variable to track the first pane
            while ($row = $query->fetch_assoc()) {
                $categoryID = $row['CategoryID'];
                $categoryName = $row['CategoryName'];
            ?>
                <div id="<?php echo str_replace(' ', '', $categoryName); ?>" class="tab-pane fade <?php echo $firstPane ? 'in active' : ''; ?>" style="margin-top:20px;">
                    <div class="row">
                        <?php
                        $productSql = "SELECT * FROM product WHERE CategoryID = $categoryID";
                        $productQuery = $conn->query($productSql);
                        while ($productRow = $productQuery->fetch_assoc()) {
                        ?>
                            <div class="col-md-3">
                                <div class="panel panel-default">
                                    <div class="panel-heading text-center">
                                        <b><?php echo $productRow['ProductName']; ?></b>
                                    </div>
                                    <div class="panel-body">
                                        <img src="<?php echo (!empty($productRow['ImagePath']) ? $productRow['ImagePath'] : 'upload/noimage.jpg'); ?>" height="225px" width="100%">
                                    </div>
                                    <div class="panel-footer text-center">
                                        &#x20B1; <?php echo number_format($productRow['Price'], 2); ?>
                                    </div>
                                </div>
                            </div>
                        <?php
                        }
                        ?>
                    </div>
                </div>
            <?php
                $firstPane = false; // Set to false after the first iteration
            }
            ?>
        </div>
    </div>
</body>

</html>
