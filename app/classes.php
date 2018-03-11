<?php
		include("config.php");

		class listSKUs Extends Connection
    		{
    			public function getList()
					{
						$query = "SELECT id, sku_name FROM sku WHERE status = 1 ORDER BY sku_name ASC";
						$connection = $this->establish_connection();
						$skuLists = $connection->query($query);
						$connection->close();

						if($skuLists->num_rows > 0)
							{
								while($skuList = $skuLists->fetch_assoc())
									{
										echo "
												<option value='".$skuList['id']."'>".$skuList['sku_name']."</option>
											 ";
									}
							}
					}
    		}

    	class listOrders Extends Connection
    		{
    			public function getTotalAmt()
					{
						$query = "SELECT SUM(totalPrice) AS amount FROM orderslist WHERE status = 1";
						$connection = $this->establish_connection();
						$amounts = $connection->query($query);
						$connection->close();

						if($amounts->num_rows > 0)
							{
								echo $amounts->fetch_object()->amount;
							}

						else
							{
								echo 0;
							}
					}

    			public function getOrdersList()
    				{
    					$counter = 0;
    					$query = "SELECT * FROM orderslist WHERE status = 1";
						$connection = $this->establish_connection();
						$ordersLists = $connection->query($query);
						$connection->close();

						if($ordersLists->num_rows > 0)
							{
								while($ordersList = $ordersLists->fetch_assoc())
									{
										$counter++;
										echo "
												<tr id='".$ordersList['id']."'>
		                                            <td>#".$counter."</td>
		                                            <td>
		                                                <input type='number' value='".$ordersList['quantity']."' class='form-control orderListAlterQuantity' placeholder='Qty'>
		                                            </td>
		                                            <td>".$ordersList['width']." CM</td>
		                                            <td>".$ordersList['height']." CM</td>
		                                            <td class='updatedAmount'>Rs. <span class='totalPriceForThisItem'>".$ordersList['totalPrice']."</span>/-</td>
		                                            <td>
		                                                <button data-orderid='".$ordersList['id']."' class='orderListDeleteEntry btn btn-rounded btn-outline-danger waves-effect waves-light m-r-10'><i class='fa fa-close'></i></button>
		                                            </td>
		                                        </tr>
											 ";
									}
							}
    				}
    		}

    	$sku = new listSKUs();
    	$order = new listOrders();
?>