<?php
/*
Template Name: Single Gear Item Page
*/
?>
<?php get_header(); 
$podName = "gears";
$gearPermalink = pods_url_variable(-1);
$gearsPod = pods($podName, $gearPermalink);

?>
 
        <div class="wrapper content gearpage clearfix">   

            <div class="radialouter">
                <div class="line" ></div>
            </div>  
           
                <?php if(!empty($gearsPod->data)){ 
                            $image = $gearsPod->field('image');
                ?>
      
                <h1><?php echo $gearsPod->field('name')?></h1>
    
                <div class="gearcontent clearfix">

                    <div class="gear-imageguff">    
                        <img class="photo"src="<?php echo $image['guid'];?>" alt="<?php echo $gearsPod->field('name'); ?>">
                    </div><!-- gearimageguff -->      
                    
                    <div class="geardescription">
                        <p><?php echo $gearsPod->field('description'); ?> </p>
                        <div id="price">
                            <h3>price:</h3>
                            <p>$<?php echo $gearsPod->field('price');?>&#032;per day</p>
                        </div>

                        <?php 
                            if(function_exists('displayAddToCart')):
                                displayAddToCart($gearsPod->field('id'), $podName);
                            endif;
                        ?>

                    </div><!-- geardescription -->    
                
                </div><!-- gearcontent --> 
                <?php } // if ends ?>   
           
                

                <?php displayMiniCart(); ?>    
        </div> <!-- wrapper end-->

<?php get_footer(); ?>