<?php
/*
Plugin Name: Custom Pods Cart
Version: 2.0
Author: Mason Herber, updated to Pods 2 by Matt Stevens Nov 2012
Description: A plugin to demonstrate the basic shopping cart functionality. This also includes a quantity field for the product
*/

// --------------- DEFINE CONSTANTS ---------------------

define("CART_PLUGIN_URL", plugin_dir_url( __FILE__ ));
define("CART_PAGE", get_bloginfo('url')."/shopping-cart");
define("REMOVE_IMG", CART_PLUGIN_URL."/remove-item.png");
define("CART_TRIGGERS", CART_PLUGIN_URL."js/triggers.js");
define("ADMIN_AJAX_URL",admin_url( 'admin-ajax.php' ));
define('RECIPIENT','joanne.j.ho@gmail.com');

// --------------- AJAX ADD ACTIONS ---------------------

//called from jquery. The jQuery action uses 'wp_ajax_' as a suffix. so 'load-cart' is the action.
//once the action is called from js, this will load the function as if it was an external file:
//IMPORTANT: The actions need to be created for both hooks. This is for loggin or non logged in users:
add_action( 'wp_ajax_cartManager', 'cartManager' );
add_action( 'wp_ajax_nopriv_cartManager', 'cartManager' );
add_action( 'wp_ajax_loadMiniCart', 'loadMiniCart' );
add_action( 'wp_ajax_nopriv_loadMiniCart', 'loadMiniCart' );
add_action( 'wp_ajax_loadCart', 'loadCart' );
add_action( 'wp_ajax_nopriv_loadCart', 'loadCart' );
add_action( 'wp_ajax_sendOrder', 'sendOrder' );
add_action( 'wp_ajax_nopriv_sendOrder', 'sendOrder' );

// --------------- ADD SCRIPTS ---------------------

//create custom hook (to use instead of wp_footer())
function sc_footer(){
    do_action('sc_footer');
}

//add function addSearchScripts to custom hook
add_action('sc_footer', 'addCartScripts');

function addCartScripts(){ ?>
	<script>var cartObj = {"ajaxURL":"<?php echo ADMIN_AJAX_URL;?>", "cartAction": "loadCart", "miniCartAction": "loadMiniCart"}</script>
	<script src="<?php echo CART_TRIGGERS ?>"></script>
<?php 
}

// --------------- DISPLAY FUNCTIONS ---------------------

function displayCart(){
	?>
	<div id="display-cart">
    </div>	    
    <?php
}

function displayMiniCart(){
	?>
    <div id="mini-cart">
    </div>
    <?php
}

//displays add
function displayAddToCart($id, $type){
	
	?>
  <div class="add-to-cart">
    <form class="add-to-cart-form" data-type="<?php echo $type; ?>" data-id="<?php echo $id; ?>" method="POST">

    <div id="booking">                        
        <div>
        <label for="from">Check In/Rent From</label>
        <input type="text" id="from" name="from">
        </div>
        <div>
        <label for="to">Check Out/Rent To</label>
        <input type="text" id="to" name="to">
        </div>
    </div>
<!--         <div id="calDays" style="border: 1px solid green" >calculate days</div> -->
      <label class="qtyppl"></label>
      <input class="qty" name="qty" value = "1" />
      <input class="days" name="days" value = "1" />
      <input class="greenbutton" type="submit" value="add to cart" name="addtocart" />
      <p class="cart-success">Your item has been added to the cart.</p>
     </form>
   </div> 
<?php }


// --------------- AJAX FUNCTIONS ---------------------

//The minicart is loaded when page loads and also whenever an item is added, updated or deleted from cart session.
function loadMiniCart(){
	
	//cartManager() processes the add, update, delete, deleteall functions and returns the modified array
	$productsArray = cartManager();
	
	$productsCount = count($productsArray);
	?>
	<table class="mini-cart">
    <?php
	//if there are items in the array, display it in a list:
	if($productsCount > 0):

		foreach($productsArray as $productArray):
			//loop thru each item in the array and get the array within it:
			//pull out the seperate values from the inner associative array:
			$id = $productArray['id'];
			$qty = $productArray['qty'];
			$type = $productArray['type'];
            $days = $productArray['days'];
			//get the item detail by creating a new pod:
			$pod=pods($type,$id);

			//create an acociative array from these results:
			if(!empty($pod->data)):
				$totalPrice = $pod->field('price')*$qty*$days;
			?>
			<tr>
                <td>[<?php echo $days; ?>]</td>
				<td>[<?php echo $qty; ?>]</td>
				<td><?php echo $pod->field('name');?></td>
				<td><?php echo price_format($totalPrice);?></td>
				<td><img src="<?php echo REMOVE_IMG; ?>" class="delete-icon"  data-id="<?php echo $id; ?>" data-type="<?php echo $type; ?>" /></td>
			</tr>
			<?php
				//update the total price with each item:
				$totalCost += $totalPrice;
				
			endif;
		endforeach;
	?> 
    	<tr class="total-row">
        <td></td>
        <td>Total</td>
        <td><?php echo price_format($totalCost); ?></td>
        <td>&nbsp;</td>
      </tr>
      
      <tr class="delete-row">
        <td>&nbsp;</td>
        <td>&nbsp;</td>
        <td colspan="2"><a href="#" class="delete-all"><img src="<?php echo REMOVE_IMG; ?>" /> Delete All</a></td>
      </tr>
    <?php	
	else:
	?>
		<tr>
    	<td>Your Cart is Empty</td>
    </tr>
    <?php
	endif; 
	?>  
	</table>
	<?php
	exit;
}//end loadMinicart

//The cart is loaded when the cart page loads and also whenever an item is added, updated or deleted from cart session.
function loadCart(){
	
	//this processes the add, update, delete, delete all functions and returns the modified array
	$productsArray = cartManager();
	$productsCount = count($productsArray);
	
	//if there are items in the array, display it in a table:
	if($productsCount > 0):
		?>
	 <form method="post" id="cart-form" class="default-form main" action="">
		<table id="shoppingCart" class="carttable" cellspacing="0" cellpadding="0" border="0">
			<tr class="tablehead">
				<td><div></div>preview</td>
				<td class="name" >gear</td>
				<td class="days" >days</td>
                <td class="qty" >qty</td>
		        <td class="price">price</td>
				<td class="price">total</td>
		        <td>remove</td>
			</tr>
			<?php
			foreach($productsArray as $productArray):
			//loop thru each item in the array and get the array within it:
			//pull out the seperate variables from the inner array:
				$id = $productArray['id'];
				$qty = $productArray['qty'];
				$type = $productArray['type'];
				// $image = $productsArray['image'];
                $days = $productArray['days'];

			//get the item detail by creating a new pod:
				$pod=pods($type,$id);
			//create an acociative array from these results:
			if(!empty($pod->data)):
				$totalPrice = $pod->field('price')*$qty*$days;
			?>
			<tr class="tablegrad">
				<td>
				    <div class="grad">
                    <div class="radialouter">
                     	<div class="line" ></div>
                    </div>
                    </div>
                    <img class="thumb"src="<?php echo $pod->field('image.guid'); ?>" alt="<?php echo $pod->field('name'); ?>" />
				</td>
				<th><?php echo $pod->field('name')?></th>
                <td><input type="text" name="days" value="<?php echo $days;?>" class= "days-input" data-id = "<?php echo $id;?>" data-type="<?php echo $type;?>" /></td>
                <td><input type="text" name="qty" value="<?php echo $qty;?>" class= "qty-input" data-id = "<?php echo $id;?>" data-type="<?php echo $type;?>" /></td>
        		<td><?php echo price_format($pod->field('price'));?></td>
				<td><?php echo price_format($totalPrice);  ?></td>
       			<td>
					<img src="<?php echo REMOVE_IMG; ?>" class="delete-icon" data-id = "<?php echo $id;?>" data-type="<?php echo $type;?>" alt="delete icon" />
				</td>
			</tr>
		<?php
				//each time loops add cost of product to total var:
				$totalCost += $totalPrice;
			endif;
		endforeach;
		?>
			<tr class="total-row tablegrad">
			  	<td>				    
			  		<div class="grad">
                    <div class="radialouter">
                     	<div class="line" ></div>
                    </div>
                    </div>
                    <strong>Total Cost</strong></td>
        		<td></td>
			  	<td></td>
			  	<td></td>
			  	<td><strong><?php echo price_format($totalCost); ?></strong></td>
       		 	<td><a href="#" class="delete-all">Delete All</a></td>
			</tr>
		</table>
<!-- ======================= MOBILE VIEW ================================== -->
		<table id="shoppingCart" class="mobilecarttable" cellspacing="0" cellpadding="0" border="0">
						<?php
			foreach($productsArray as $productArray):
			//loop thru each item in the array and get the array within it:
			//pull out the seperate variables from the inner array:
				$id = $productArray['id'];
				$qty = $productArray['qty'];
				$type = $productArray['type'];
				// $image = $productsArray['image'];
                $days = $productArray['days'];

			//get the item detail by creating a new pod:
				$pod=pods($type,$id);
			//create an acociative array from these results:
			if(!empty($pod->data)):
				$totalPrice = $pod->field('price')*$qty*$days;
			?>
<tr>
                    
                    <th colspan="3">
                        <div class="grad">
                            <div class="radialouter">
                                <div class="line" ></div>
                            </div>
                        </div>
                        <?php echo $pod->field('name')?>
                    </th>
                </tr>
                  <td rowspan="6"><img class="thumb" src="<?php echo $pod->field('image.guid'); ?>" alt="<?php echo $pod->field('name'); ?>" /></td>
                </tr>
                <tr>
                  <td>price</td>
                  <td><?php echo price_format($pod->field('price'));?></td>
                </tr>
                <tr>
                  <td>people</td>
                <td><input type="text" name="qty" value="<?php echo $qty;?>" class= "qty-input" data-id = "<?php echo $id;?>" data-type="<?php echo $type;?>" /></td>
                </tr>
                <tr>
                  <td>days</td>
                <td><input type="text" name="days" value="<?php echo $days;?>" class= "days-input" data-id = "<?php echo $id;?>" data-type="<?php echo $type;?>" /></td>
                </tr>
                <tr>
                  <td>total</td>
                <td><?php echo price_format($totalPrice);  ?></td>
                </tr>
                <tr>
                  <td colspan="2"><img src="<?php echo REMOVE_IMG; ?>" class="delete-icon" data-id = "<?php echo $id;?>" data-type="<?php echo $type;?>" alt="delete icon" /></td>
                </tr>
		<?php
				//each time loops add cost of product to total var:
				//$totalCost += $totalPrice; NO NEED TO RE-CALCULATE THIS FOR THE MOBILE DISPLAY AS THIS WILL DOUBLE THE PRICE AS IT'S ALREADY BEEN CALCULATED ABOVE IN THE NORMAL CART
			endif;
		endforeach;
				?>
			<tr class="total-row tablegrad">
			  	<td colspan="2">				    
			  		<div class="grad">
                    <div class="radialouter">
                     	<div class="line" ></div>
                    </div>
                    </div>
                    <strong>Total Cost: <?php echo price_format($totalCost); ?></strong></td>
       		 	<td><a href="#" class="delete-all">Delete All</a></td>
			</tr>
		</table>
       
<!-- ============================= MOBILE VIEW END =================================== -->

            <div class="radialouter">
            	<div class="line" ></div>
            	<h1>your spot checkout</h1>
        	</div>

		<section class="details">

            <div class="paymentcontainer">
            
            <div class="payment">
                <h3>shipping address</h3>
                <p></p>
                <label for="name" >FIRST NAME</label><br />
                <input type="text" id="name" name="firstname"><br>
                <label>LAST NAME</label><br />
                <input type="text" name="lasttname"><br>
                <label>ADDRESS</label><br />
                <input type="text" name="address"><br>
                <label>POSTAL CODE</label><br />
                <input type="text" name="postcode"><br>
                <label>EMAIL</label><br />
                <input type="text" id="email" name="email"><br>
                <label>PHONE NUMBER</label><br />
                <input type="text" name="phone"><br>

            </div>

             <div class="payment">
                <h3>payment information</h3>
                    <p></p>
                    <label for="credit-num">CARD NUMBER</label><br />
                    <input type="text" id="credit-num" name="credit-num"><br>
                    <label>EXPIRATION DATE</label><br />
                    <input type="text" name="expirationdate"><br>
                    <label>CARD CODE</label><br />
                    <input type="text" name="cardcode">
                    <input type="checkbox" id="termsCond" value="readAgree"/><label>I HAVE READ AND AGREED TO THE TERMS & CONDITIONS <br><a href="<?php bloginfo('url');?>/terms-conditions">as set out on the Terms & Conditions page</a></label><br>
                    <div>
                        <label>&nbsp;</label>
                        <input type="submit" value="BUY NOW" class="cart-btn greenbutton">
                        <input type="hidden" value="sendOrder" name="action" id="action"> 
                        <input type="text" value="" name="spam" class="hidden" id="spam"> 
                    </div>
                    <p id="status"></p>
            </div>
            <div class="payment">
                <h3>pick up information</h3>
                <div class="pickup">
                    <select name="choose an area">
                        <option>Auckland</option>
                        <option>Hamilton</option>
                        <option>Wellington</option>
                        <option>Christchurch</option>
                    </select>
                    <div class="opt sel optauckland">
                        <p>
                            Head Office:<br />
                            ANZ Building.<br />
                            172 Turkey Way<br />
                            PO Box 7495<br />
                            CBD<br />
                            Auckland 3535<br />
                            NEW ZEALAND<br />
                            <br />
                            Freephone: 0800 OUR SPOT (86 2267)<br />
                            Phone: +64 9 8491999<br />
                            Fax: +64 9 849 1749
                        </p>
                    </div>
                    <div class="opt opthamilton">
                        <p>
                            Head Office:<br />
                            Aber Holdings Ltd.<br />
                            17 Mainstreet Place<br />
                            PO Box 10095<br />
                            Te Rapa<br />
                            Hamilton 3241<br />
                            NEW ZEALAND<br />
                            <br />
                            Freephone: 0800 OUR SPOT (86 2267)<br />
                            Phone: +64 7 8491999<br />
                            Fax: +64 7 849 1749
                        </p>
                    </div>
                    <div class="opt optwellington">
                        <p>
                            143 Wellington Street<br />
                            PO Box 6034<br />
                            Wellywood<br />
                            Wellington 1234<br />
                            NEW ZEALAND<br />
                            <br />
                            Freephone: 0800 OUR SPOT (86 2267)<br />
                            Phone: +64 4 8491999<br />
                            Fax: +64 4 849 1749
                        </p>
                    </div>
                    <div class="opt optchristchurch">
                        <p>
                            456 Shakerfield Ave<br />
                            PO Box 7890<br />
                            CBD<br />
                            Christchurch 2365<br />
                            NEW ZEALAND<br />
                            <br />
                            Freephone: 0800 OUR SPOT (86 2267)<br />
                            Phone: +64 2 8491999<br />
                            Fax: +64 2 849 1749
                        </p>
                    </div>
                </div>
            </div>
        </div><!-- cartcontainer -->

 	 	</section>
		</form>		
	<?php
	else:
	?>
		<div id="empty-cart">
			<h3>Your Cart is Empty</h3> 
			<a class="greenbutton" href="<?php echo bloginfo('url');?>/map">Book a Spot</a>
			<a class="greenbutton" href="<?php echo bloginfo('url');?>/gear-hire">Add Some Gear</a>
		</div>
	<?php
	endif;
	exit;	
}//end loadCart()

//This is used to loop thru a 2 dimensional array, check if an item is in there and return the index for the item:
function checkProductInArray($id, $type, $productsArray){

	$key = false;
	$i = 0;
	$arrayCount = count($productsArray);

	if($arrayCount == 0){
		return false;
	}
	for($i = 0; $i < $arrayCount; $i++):
		//check that the id and type of the item is the same as what is in the array:
		if($productsArray[$i]['id'] == $id && $productsArray[$i]['type'] == $type):
			//if it is put the index($i) into var $key:
			$key = $i;
			//break;
		endif; 
	endfor;

	return $key;
}//end checkProductInArray()

//manages adding, removing and updating the cart session
//returns the updated shopping cart array once it has been modified
function cartManager(){
	
	//catch the POST variables sent to the Ajax script:
	$id = isset($_POST['id'])? $_POST['id'] : 0;
	$mode = isset($_POST['mode'])? $_POST['mode'] : "";
	$type = isset($_POST['type'])? $_POST['type'] : "";
	$qty = isset($_POST['qty'])? $_POST['qty'] : "";
    $days = isset($_POST['days'])? $_POST['days'] : "";

	//if the session array doesn't exist then create it
	if(!isset($_SESSION['productsArray'])):
		$_SESSION['productsArray'] = array();
	endif; 
	
	//set local var $productsArray
	$productsArray = $_SESSION['productsArray'];

    //var_dump($productsArray);
	
	//If the item already exists in the cart, then set it's index. if it doesn't exist (or not set) it will be set to false
	$index = isset($_POST['id'])? checkProductInArray($id, $type, $productsArray) : false;
	
	//switch based on the mode
	switch($mode):
		
		case "add":
			//if the item hasn't already been add it to the array, then add it:
			if($index===false):
				
				//create an array and add the values:
				$singleProductArray = array();
				$singleProductArray['id']= $id;
				$singleProductArray['qty']= $qty;
				$singleProductArray['type']= $type;
                $singleProductArray['days']= $days;

				//push the single array into the $productsArray
				$productsArray[] = $singleProductArray;
			
				echo"<div class='status'>Item ".$id." added to cart</div>";	
			else:
				//if the item has already been added to the array
				//add the $qty to the existing quantity for that item
				$productsArray[$index]['qty'] += $qty;
                $productsArray[$index]['days'] = $days;

				echo"<div class='status'>Item ".$id." has been updated</div>";	
			endif;
			
			break;
		
		case "delete":
			//if the item exists	
			if($index !== false):
			
				//unset the array item and resort the array to reset the indexes
				unset($productsArray[$index]);
				$productsArray = array_values($productsArray);
				echo"<div class='status'>Item ".$id." removed from products</div>";	
				
			endif;
			
			break;
			
		case "update":
		
			if($index !== false):	
				//update the qty for that item
				$productsArray[$index]['qty'] = $qty;
                $productsArray[$index]['days'] = $days;
				
                echo "<div class='status'>Item ".$id." has been updated</div>";	
			endif;
			
			break;
	
		case "delete-all":
			//clear all session arrays:
			$productsArray  = array();
			echo "<div class='status'>All items removed from itinerary</div>";
			
			break;
				
	endswitch;	
	
	//return modified products array
	$_SESSION['productsArray'] = $productsArray;
	return $productsArray;
	
}//end cartManager()

function price_format($price){
	return "$".number_format($price, 2, '.', ',');
}

//once jquery has validated the form, this function puts together email of the items in the cart and emails them
function sendOrder(){
	//catch post vars
	$subject = "website order";
	$name = $_POST['name'];
	$email = $_POST['email'];
	$cctype = $_POST['credit-type'];
	$ccnum = $_POST['credit-num'];
	$message = $_POST['message'];
	
	//set email body and headers
	$body = "
	Website Order:\n\n
	name: $name\n
	email: $email\n
	credit card: $cctype\n
	number: $ccnum\n
	message: $message\n
	-------------\n
	Order:\n\n
	";
	
	$productsArray = $_SESSION['productsArray'];
	
	$totalCost = 0;
	$productsCount = count($productsArray);
	
	if($productsCount > 0){
		
		foreach($productsArray as $productArray):
			//test_dump($productArray);
			$id = $productArray['id'];
			$qty = $productArray['qty'];
			$type = $productArray['type'];
            $days = $productArray['days'];
			
			$pod = pods($type,$id);
			//for each item. create an array of data from query result:
			if(!empty($pod->data)):
				$price = $pod->field('price');
				$product = $pod->field('name');
				$totalPrice = $price*$qty*$days;
				$body .= "
				Product = $product \n
				Type = $type \n
                Days = $days \n
				Qty = $qty \n
				Price = $price \n
				Sub Total = $totalPrice \n
				-----------------
				\n\n" ;
				
				$totalCost += $totalPrice;
			endif;
		endforeach;
	}//end if
	$body .= "Total = $totalCost\n";
	$headers = 'From: '.$_POST['name'].'<'.$_POST['email'].'>'."\r\n";
	
	//send email
	if(mail(RECIPIENT, $subject , $body, $headers)){	
		echo "success";
	} else {
		echo "error";
	}//end if mail
	
	exit;
	
}//function

?>
