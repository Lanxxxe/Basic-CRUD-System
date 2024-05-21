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
		<tbody id="tableBody">
		</tbody>
	</table>
</div>


<script type="text/javascript">
	document.addEventListener('DOMContentLoaded', () => {
		var tableBody = document.querySelector('#tableBody');
		tableBody.innerHTML = '';
		var transactionDetails = JSON.parse(localStorage.getItem('orderDetails')) || [];
		const renderTable = () => {
        tableBody.innerHTML = '';
        transactionDetails.forEach((values, index) => {
            let content = `
            <tr data-index="${index}"> 
                <td>${values['dateOfPurchase']}</td>
                <td>${values['customerName']}</td>
                <td>${values['adminFirstName']}</td>
                <td>${values['transactionType']}</td>
                <td><button class="btn btn-primary delete-button">Complete</button></td>
            </tr>
            `;
            tableBody.innerHTML += content;
        });

        // Add event listeners for delete buttons
        document.querySelectorAll('.delete-button').forEach(button => {
            button.addEventListener('click', function() {
                var row = this.closest('tr');
                var index = row.getAttribute('data-index');
                transactionDetails.splice(index, 1);
                localStorage.setItem('orderDetails', JSON.stringify(transactionDetails));
                renderTable(); // Re-render the table
            });
        });
    }

    // Initial render
    renderTable();
	})
</script>
</body>
</html>