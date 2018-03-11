$(document).ready(function()
	{
		var globalPrice = 0; // we have set a global variable here as we have made an ajax request to get response of the price as per SKU selected. but we have also made calucations to caluculate perimeter which is in another function. So to make sure that the value is maintained throughout the scriot we have declared the variable here in global scope

		$("#message, #message2, #message3").hide();

		//  Code for the datatable to alter the quantity starts here. User can change the quantity in this case we have to make a server call and manage it accordingly
		$("body").on('change', '.orderListAlterQuantity', function()
			{
			    var order_id = $(this).closest('tr').attr('id');
			    var qty = this.value;
			    var $this = $(this);

			    if(qty < 1)
			    	{
			    		$("#message3").slideDown("slow");
	                        setTimeout(function() {
	                          $("#message3").slideUp("slow");
	                        }, 5000);
			    		$(this).val(1);
			    	}

			    if(qty > 1 || qty == 1)
			    	{
			    		$.ajax({
								url: '/alter',
								type: 'POST',
								dataType: "json",
								data: {type: "update", orderid: order_id, quantity: qty},
							})
							.done(function(resp)
								{
									if(resp.status == "success")
										{
											$("span#orderTotalAmt").html(resp.amount);
											$this.find('td').first().closest('totalPriceForThisItem').html(resp.total);
											// alert("Order Deleted");
										}

									else if(resp.status == "failed")
										{
											$this.html("<i class='fa fa-close'></i>");
											$this.removeAttr('disabled');
											// alert("Problem Deleting Order! Please Try Again after Sometime.");
										}

									else
										{
											$this.html("<i class='fa fa-close'></i>");
											$this.removeAttr('disabled');
										}
								})
							.fail(function(resp)
								{
									console.log(resp);
								});
			    	}
			});
		// Code for the datatable to alter the quantity ends here. 

		// Code for the datatable to Delete a particular Entry Starts here. User can delete the order entry. in this case we have to make a server call and manage it accordingly
		$("body").on('click', 'button.orderListDeleteEntry', function(event)	
			{
				var id = $(this).data("orderid");
				var $this = $(this);
				$(this).html("Deleting..");
				$(this).prop('disabled', 'true');

				$.ajax({
					url: '/alter',
					type: 'POST',
					dataType: "json",
					data: {type: "delete", orderid: id},
				})
				.done(function(resp)
					{
						if(resp.status == "success")
							{
								$('table#orderList tbody tr#'+id).fadeOut("slow");
								// $('#orderList').DataTable().row("#"+id).remove().draw(false);
								$this.parent().parent().remove();
								$('#orderList').DataTable().columns.adjust().draw(false);
								$("span#orderTotalAmt").html(resp.amount);
								// alert("Order Deleted");
							}

						else if(resp.status == "failed")
							{
								$this.html("<i class='fa fa-close'></i>");
								$this.removeAttr('disabled');
								// alert("Problem Deleting Order! Please Try Again after Sometime.");
							}

						else
							{
								$this.html("<i class='fa fa-close'></i>");
								$this.removeAttr('disabled');
							}
					})
				.fail(function(resp)
					{
						console.log(resp);
					});
			});
		// Code for the datatable to Delete a particular Entry Ends here.

		// Ajax call made to retrieve the price of current SKU starts here.
		$('body').on('change', 'select#make_select', function()
	        {
	          var value = this.value;

	          $.ajax({
			          	url: '/alter',
			          	type: 'POST',
			          	data: {type: "search", id: value},
		          })
	          .done(function(resp)
		          {
		          	globalPrice = resp; //global varibale used here to store the price
		          	$("#price").val("Rs. "+resp+"/-");
		          })
	          .fail(function(resp)
		          {
		          	console.log("error");
		          });
	        });
		// Ajax call made to retrieve the price of current SKU ends here.

		// If there are any errors in form they are highlighted. This code will remove the higlights when clicked on the highlighted fields
		$("body").on('click focus', 'form#makeForm [id^=make_]', function(event)
            {
              	$(this).removeClass('error');
            });
		// Code ends here

		// this is the code when there are manipulations performed to caluculate the frame price and perimeter
		$("body").on('click', 'button.calculate', function(event)
			{
				$("button.calculate").html("Calculating..");
				$("button.calculate").prop('disabled', 'true');

				proceed = true;
				checkForm();

				if(proceed)
					{
						//perimeter formula used to caluculate perimeter 2*(l+b);
						var perimeter = 2*(parseInt($("#make_width").val()) + parseInt($("#make_height").val()));
						$("#perimeter").val(perimeter);
						// Global variable used here to manpulate the price accordingly.
						$("#cost").val("Rs. "+perimeter*globalPrice+"/-");
						$("button.calculate").html("Calculate");
						$("button.calculate").removeAttr('disabled');
					}

				else
					{
						$("button.calculate").html("Calculate");
						$("button.calculate").removeAttr('disabled');
					}
			});
		// Code ends here.

		// this is the code when we are sending data to serve and adding the data to the datatable besides
		$("body").on('click', 'button.addToOrder', function(event)
			{
				$("button.addToOrder").html("Adding Order..");
				$("button.addToOrder").prop('disabled', 'true');

				proceed = true;
				checkForm();

				if(proceed)
					{
						var formVal = [];
						formVal.push({
										"sku": $("#make_select").val(),
										"width": $("#make_width").val(),
										"height": $("#make_height").val()
									});

						$.ajax({
									url: '/alter',
									type: 'POST',
									dataType: 'json',
									data: {type: 'insert', formDat: formVal},
								})
						.done(function(resp)
							{
								if(resp.status == "success")
									{
										$('form#makeForm')[0].reset();
										$("button.addToOrder").html("Add To Order List");
										$("button.addToOrder").removeAttr('disabled');
										$("span#orderTotalAmt").html(resp.amount);
										$("#message").slideDown("slow");
				                        setTimeout(function() {
				                          $("#message").slideUp("slow");
				                        }, 5000);
				                        // .columns.adjust().draw(false)
				                        $('#orderList').DataTable().row.add([
				                        										resp.counter,
				                        										resp.quantity,
				                        										resp.width,
				                        										resp.height,
				                        										resp.cost,
				                        										resp.action
				                        									]).draw(false);
									}
							})
						.fail(function(resp)
							{
								console.log(resp);
							});
					}

				else
					{
						$("button.addToOrder").html("Add To Order List");
						$("button.addToOrder").removeAttr('disabled');
					}
			});
		// Code ends here.
	});

function checkForm()
	{
		$("form#makeForm [id^=make_]").each(function()
            {
                if(!$.trim($(this).val()))
                    {
                        proceed = false;
                        $(this).addClass('error');
                        $("#message2").slideDown("slow");
                        setTimeout(function() {
                          $("#message2").slideUp("slow");
                        }, 5000);
                    }
            });
	}