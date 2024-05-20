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
	<h1 class="page-header text-center">Order List</h1>
	<table class="table table-striped table-bordered">
		<thead>
			<th>Date</th>
			<th>Customer</th>
			<th>Processed By</th>
 			<th>Transaction Type</th>
			<th>Action</th>
		</thead>
		<tbody>
			<?php 
				$sql = "SELECT pb.PurchaseID, pb.DatePurchase, pd.CustomerName, a.FirstName, pb.TotalBill, pd.TransactionType, pd.PurchaseDetailsID 
					FROM PurchaseDetails pd 
					JOIN PurchaseBill pb ON pd.PurchaseDetailsID = pb.PurchaseDetailsID 
					JOIN Administrator a ON pd.AccountID = a.AccountID 
					ORDER BY pb.PurchaseID DESC";
				$query = $conn->query($sql);
				while ($row = $query->fetch_assoc()) {
					?>
					<tr>
						<td><?php echo htmlspecialchars($row['DatePurchase']); ?></td>
						<td><?php echo htmlspecialchars($row['CustomerName']); ?></td>
						<td><?php echo htmlspecialchars($row['FirstName']); ?></td>
						<td><?php echo htmlspecialchars($row['TransactionType']); ?></td>
						<td><a href="#details<?php echo $row['PurchaseDetailsID']; ?>" data-toggle="modal" class="btn btn-danger btn-sm"><span class="glyphicon glyphicon-trash"></span> Remove</a>
							<?php include('sales_modal.php'); ?>
						</td>
					</tr>
					<?php
				}
			?>
		</tbody>
	</table>
</div>
</body>
</html>