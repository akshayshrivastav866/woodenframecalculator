<?php
		if($_POST)
			{
				if(count($_POST) > 0)
					{
						include("classes.php");

						class updateOrder Extends listOrders
							{
								public function getPriceForSingleUnit()
									{
										$fire2 = "SELECT sku.pricepercm AS price, width, height FROM orderslist, sku WHERE orderslist.id = '".$_POST['orderid']."' AND orderslist.sku_id = sku.id";
										$connection = $this->establish_connection();
										$calculations = $connection->query($fire2);
										$connection->close();

										if($calculations->num_rows > 0)
											{
											    while($calculation = $calculations->fetch_assoc())
													{
														$price = $calculation['price'];
														$width = $calculation['width'];
														$height = $calculation['height'];
													}

												$perimeter = 2*($width+$height);
												$costing = $price * $perimeter;
												return $costing;
											}
									}

								public function updateOrderDetails()
									{
										$fire = "SELECT totalPrice AS total FROM orderslist WHERE id = '".$_POST['orderid']."' ";
										$connection = $this->establish_connection();
										$totalPrices = $connection->query($fire);
										$connection->close();

										if($totalPrices->num_rows > 0)
											{
												$totalPrice = $totalPrices->fetch_object()->total;
											}

										if($_POST['quantity'] == 1)
											{
												$tot = $this->getPriceForSingleUnit();
											}
										else if($_POST['quantity'] > 1)
											{
												$tot = $totalPrice * $_POST['quantity'];
											}

										$date = new Date();
										$modified = $date->getDate();

										$query = "UPDATE orderslist SET quantity = '".$_POST['quantity']."', totalPrice = '".$tot."', modified = '".$modified."' WHERE id = '".$_POST['orderid']."' ";
										$connection = $this->establish_connection();

										if ($connection->query($query) === TRUE)
											{
												$query = "SELECT SUM(totalPrice) AS amount FROM orderslist";
												$connection = $this->establish_connection();
												$amounts = $connection->query($query);
												$connection->close();

												//this amounts should be a centralized functioned but due to some issues manually working it everywhere when code is ready will tewak this.
												if($amounts->num_rows > 0)
													{
													    echo  json_encode(array(
													    	"status" => 'success',
													    	"amount" => $amounts->fetch_object()->amount,
													    	"total" => $tot
													    ));
													}

												else
													{
														echo 0;
													}
											}
										else
											{
												$connection->close();
												echo  json_encode(array(
											    	"status" => 'failed',
											    	"value" => ''
											    ));
											    // echo "Error deleting record: " . $conn->error;
											}
									}
							}

						class searchSkuPrice Extends Connection
							{
								public function getDetails($id, $requestMethod)
									{
										$query = "SELECT pricepercm FROM sku WHERE id = '".$id."' ";
										$connection = $this->establish_connection();
										$price = $connection->query($query);
										$connection->close();

										if($price->num_rows > 0)
											{
												if($requestMethod == "externalRequest")
													{
														echo $price->fetch_object()->pricepercm;
													}

												else if($requestMethod == "internalRequest")
													{
														return $price->fetch_object()->pricepercm;
													}

												else
													{
														echo 0;
													}
											}
									}
							}

						class Order Extends listOrders
							{
								public function deleteOrder()
									{
										$query = "DELETE FROM orderslist WHERE id = '".$_POST['orderid']."' ";
										$connection = $this->establish_connection();

										if ($connection->query($query) === TRUE)
											{
												$query = "SELECT SUM(totalPrice) AS amount FROM orderslist";
												$connection = $this->establish_connection();
												$amounts = $connection->query($query);
												$connection->close();

												if($amounts->num_rows > 0)
													{
													    echo  json_encode(array(
													    	"status" => 'success',
													    	"amount" => $amounts->fetch_object()->amount
													    ));
													}

												else
													{
														echo 0;
													}
											}
										else
											{
												$connection->close();
												echo  json_encode(array(
											    	"status" => 'failed',
											    	"value" => ''
											    ));
											    // echo "Error deleting record: " . $conn->error;
											}
									}
							}

						class makeEntry Extends searchSkuPrice
							{
								public function insertData()
									{
										$status = 1; //default status of entry added whether it should be displayed in vview side or not if it is 1 it will be displayed, if it is 0 then it will not be displayed.
										$quantity = 1; //default quantity is 1;
										$date = new Date();
										$created = $modified = $date->getDate();

										// print_r($_POST); // we printed the data and saw what is in the post.
										// print_r($_POST['formDat'][0]); //we printed the data and saw the array format for formDat
										// echo $_POST['formDat'][0]['sku'];
										// exit();

										//we are now calculating perimeter on server side coz we cant trust the user data entry for money issues, so wen need to make a strict server side validation code. we shoed used the values through jquery because that was justa a small thing and we don't want to give trouble to server again and again for small things.
										$perimeter = 2*($_POST['formDat'][0]['width']+$_POST['formDat'][0]['height']);

										//we extended the function here as we had already created it for getting the price so instead of coding it again we reused it.
										$skuPrice = new searchSkuPrice();
										$cost = $perimeter * $skuPrice->getDetails($_POST['formDat'][0]['sku'], "internalRequest");
										
										$query = "INSERT INTO orderslist(sku_id, status, quantity, width, height, totalPrice, created, modified) VALUES('".$_POST['formDat'][0]['sku']."', '".$status."', '".$quantity."', '".$_POST['formDat'][0]['width']."', '".$_POST['formDat'][0]['height']."', '".$cost."', '".$created."', '".$modified."')";
										$connection = $this->establish_connection();

										if ($connection->query($query) === TRUE)
											{
												$orderID = $connection->insert_id;

												$query1 = "SELECT SUM(totalPrice) AS amount FROM orderslist";
												$connection = $this->establish_connection();
												$amounts = $connection->query($query1);
												$connection->close();

												//this amounts should be a centralized functioned but due to some issues manually working it everywhere when code is ready will tewak this.
												if($amounts->num_rows > 0)
													{
													    echo json_encode(array(
													    	"status" => 'success',
													    	"amount" => $amounts->fetch_object()->amount,
													    	"counter" => "#1",
													    	"quantity" => "<input type='number' value='".$quantity."' class='form-control orderListAlterQuantity' placeholder='Qty'>",
													    	"width" => $_POST['formDat'][0]['width']." CM",
													    	"height" => $_POST['formDat'][0]['width']." CM",
													    	"cost" => "Rs. ".$cost."/-",
													    	"action" => "<button data-orderid='".$orderID."' class='orderListDeleteEntry btn btn-rounded btn-outline-danger waves-effect waves-light m-r-10'><i class='fa fa-close'></i></button>"
													    ));
													}
											}

										else
											{
												$connection->close();
												echo  json_encode(array(
											    	"status" => 'failed',
											    	"value" => ''
											    ));
											}
									}
							}

						if($_POST['type'] == "insert")
							{
								$makeEntry = new makeEntry();
								$makeEntry->insertData();
							}

						if($_POST['type'] == "delete")
							{
								$order = new Order();
								$order->deleteOrder();
							}

						else if($_POST['type'] == "update")
							{
								$updateOrder = new updateOrder();
								$updateOrder->updateOrderDetails();
							}
						
						else if($_POST['type'] == "search")
							{
								$skuPrice = new searchSkuPrice();
								$skuPrice->getDetails($_POST['id'], "externalRequest");
							}
					}
				
			}

		else
			{
				echo "Not a Valid Request..";
			}
?>