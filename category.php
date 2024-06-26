<?php
session_start();
if (!isset($_SESSION['username'])) {
    header("Location: index.php");
    exit();
}


include('header.php'); ?>

<body>
    <?php include('navbar.php'); ?>
    <div class="container">
        <h1 class="page-header text-center">CATEGORY CRUD</h1>
        <div class="row">
            <div class="col-md-12">
                <a href="#addcategory" data-toggle="modal" class="pull-right btn btn-primary"><span class="glyphicon glyphicon-plus"></span> Category</a>
            </div>
        </div>
        <div style="margin-top:10px;">
            <table class="table table-striped table-bordered">
                <thead>
                    <th>Category Name</th>
                    <th>Action</th>
                </thead>
                <tbody>
                    <?php
                    $sql = "SELECT * FROM category ORDER BY CategoryID ASC";
                    $query = $conn->query($sql);
                    while ($row = $query->fetch_assoc()) { // Use fetch_assoc() instead of fetch_array()
                    ?>
                        <tr>
                            <td><?php echo htmlspecialchars($row['CategoryName']); ?></td> <!-- Update here -->
                            <td>
                                <a href="#editcategory<?php echo $row['CategoryID']; ?>" data-toggle="modal" class="btn btn-success btn-sm"><span class="glyphicon glyphicon-pencil"></span> Edit</a>
                                <a href="#deletecategory<?php echo $row['CategoryID']; ?>" data-toggle="modal" class="btn btn-danger btn-sm"><span class="glyphicon glyphicon-trash"></span> Delete</a>
                                <?php include('category_modal.php'); ?>
                            </td>
                        </tr>
                    <?php
                    }
                    ?>
                </tbody>
            </table>
        </div>
    </div>
</body>

</html>