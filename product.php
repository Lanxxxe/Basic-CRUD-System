<?php 
session_start();
if (!isset($_SESSION['username'])) {
    header("Location: index.php");
    exit();
}

include('header.php'); 
?>
<body>
    <?php include('navbar.php'); ?>
    <div class="container">
        <h1 class="page-header text-center">PRODUCTS CRUD</h1>
        <div class="row">
            <div class="col-md-12">
                <select id="catList" class="btn btn-default">
                    <option value="0">All Category</option>
                    <?php
                        include('db_connection.php'); // Ensure you have included your database connection
                        $sql = "SELECT * FROM category";
                        $catquery = $conn->query($sql);
                        while ($catrow = $catquery->fetch_array()) {
                            $catid = isset($_GET['category']) ? $_GET['category'] : 0;
                            $selected = ($catid == $catrow['CategoryID']) ? " selected" : "";
                            echo "<option$selected value='".$catrow['CategoryID']."'>".$catrow['CategoryName']."</option>";
                        }
                    ?>
                </select>
                <a href="#addproduct" data-toggle="modal" class="pull-right btn btn-primary"><span class="glyphicon glyphicon-plus"></span> Product</a>
            </div>
        </div>
        <div style="margin-top:10px;">
            <table class="table table-striped table-bordered">
                <thead>
                    <th>Photo</th>
                    <th>Product Name</th>
                    <th>Price</th>
                    <th>Action</th>
                </thead>
                <tbody>
                    <?php
                        $where = "";
                        if(isset($_GET['category'])) {
                            $catid = $_GET['category'];
                            $where = " WHERE product.CategoryID = $catid";
                        }
                        $sql = "SELECT * FROM product LEFT JOIN category ON category.CategoryID = product.CategoryID $where ORDER BY product.CategoryID ASC, product.ProductName ASC";
                        $query = $conn->query($sql);
                        while ($row = $query->fetch_array()) {
                    ?>
                    <tr>
                        <td><a href="<?php echo empty($row['ImagePath']) ? 'upload/noimage.jpg' : $row['ImagePath']; ?>"><img src="<?php echo empty($row['ImagePath']) ? 'upload/noimage.jpg' : $row['ImagePath']; ?>" height="30px" width="40px"></a></td>
                        <td><?php echo htmlspecialchars($row['ProductName']); ?></td>
                        <td>&#8369; <?php echo number_format($row['Price'], 2); ?></td>
                        <td>
                            <a href="#editproduct<?php echo $row['ProductID']; ?>" data-toggle="modal" class="btn btn-success btn-sm"><span class="glyphicon glyphicon-pencil"></span> Edit</a> 
                            <a href="#deleteproduct<?php echo $row['ProductID']; ?>" data-toggle="modal" class="btn btn-danger btn-sm"><span class="glyphicon glyphicon-trash"></span> Delete</a>
                            <?php include('product_modal.php'); ?>
                        </td>
                    </tr>
                    <?php
                        }
                    ?>
                </tbody>
            </table>
        </div>
    </div>
    <?php include('modal.php'); ?>

    <script>
    $(document).ready(function(){
        $('#catList').change(function(){
            var selectedCategory = $(this).val();
            if (selectedCategory == 0) {
                window.location.href = 'product.php';
            } else {
                window.location.href = 'product.php?category=' + selectedCategory;
            }
        });
    });
</script>

</body>
</html>