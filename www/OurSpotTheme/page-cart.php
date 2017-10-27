<?php
/*
Template Name: Cart Page
*/
?>
<?php get_header(); ?>
<div class="wrapper container main clearfix">

        <div class="radialouter">
            <div class="line" ></div>
            <h1>your spot cart</h1>
        </div>
  <div class="cartcontainer">
  <?php 
if(function_exists('displayCart')):
    displayCart();
else:
     echo "Cannot find function dispayCart"; 
endif;
?>
 </div> <!-- cartcontainer--> 
             <?php displayMiniCart(); ?>  
</div> <!-- wrapper -->

<?php get_footer(); ?>