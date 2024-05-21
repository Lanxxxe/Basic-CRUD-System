<!-- Sales Details -->
<div class="modal fade" id="details<?php echo $row['PurchaseDetailsID']; ?>" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                <center><h4 class="modal-title" id="myModalLabel">Sales Full Details</h4></center>
            </div>
            <div class="modal-body">
                <div class="container-fluid">
                    <h5>Customer: <b><?php echo htmlspecialchars($row['CustomerName']); ?></b>
                        <span class="pull-right">
                            <?php echo date('M d, Y', strtotime($row['DatePurchase'])); ?>
                        </span>
                    </h5>
                    <table class="table table-bordered table-striped">
                        <thead>
                            <th>Product Name</th>
                            <th>Price</th>
                            <th>Purchase Quantity</th>
                            <th>Subtotal</th>
                        </thead>
                        <tbody>
                            <?php
                                $sql = "SELECT ppd.ProductName, ppd.ProductPrice, ppd.Quantity, ppd.SubTotal 
                                    FROM ProductPurchaseDetails ppd 
                                    JOIN PurchaseDetails pd ON ppd.PurchaseDetailsID = pd.PurchaseDetailsID 
                                    JOIN PurchaseBill pb ON pd.PurchaseDetailsID = pb.PurchaseDetailsID 
                                    JOIN Administrator a ON pd.AccountID = a.AccountID 
                                    WHERE pb.PurchaseID = '".$row['PurchaseID']."'";
                                $dquery = $conn->query($sql);
                                while($drow = $dquery->fetch_assoc()){
                            ?>
                            <tr>
                                <td><?php echo htmlspecialchars($drow['ProductName']); ?></td>
                                <td class="text-right">&#8369; <?php echo number_format($drow['ProductPrice'], 2); ?></td>
                                <td><?php echo htmlspecialchars($drow['Quantity']); ?></td>
                                <td class="text-right">&#8369; <?php echo number_format($drow['SubTotal'], 2); ?></td>
                            </tr>
                            <?php
                                }
                            ?>
                            <tr>
                                <td colspan="3" class="text-right"><b>TOTAL</b></td>
                                <td class="text-right">&#8369; <?php echo number_format($row['TotalBill'], 2); ?></td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal"><span class="glyphicon glyphicon-remove"></span> Close</button>
            </div>
        </div>
        <!-- /.modal-content -->
    </div>
    <!-- /.modal-dialog -->
</div>
