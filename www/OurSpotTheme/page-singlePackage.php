<?php
/*
Template Name: Single Package Page
*/
?>
<?php get_header(); 
$podName = "packages";
$packPermalink = pods_url_variable(-1);
$packPod = pods($podName, $packPermalink);

$packagesPod = pods( $podName );
$params = array( 'orderby' => 'id ASC', 'limit' => -1);
$packagesPod->find( $params );
?>
 
        <div class="wrapper content gearpage clearfix">   

            <div class="radialouter">
                <div class="line" ></div>
            </div>  
             
                <?php if(!empty($packPod->data)){ 
                            $images = $packPod->field('image.guid');
                ?>
      
                <h1><?php echo $packPod->field('name')?></h1>
    
                <div class="gearcontent clearfix">

                    <div class="gear-imageguff"> 
                        <div class="rotator clearfix">
                        <?php  
                         $numImg = count($images);
                         // var_dump($images);
                         // var_dump($numImg);
                         for ($i=0; $i < $numImg; $i++) { 
                              $getImg = $images[$i];
                             // var_dump($getImg);
                        ?>

                        <img class="photo" src="<?php echo $getImg ;?>" /> 
                        <?php } //close images loop?>
                        </div><!-- packslider -->
                    </div><!-- gearimageguff -->      
                    
                    <div class="geardescription">
                        <p><?php echo $packPod->field('description'); ?> </p>
                        <div id="price">
                            <h3>price:</h3>
                            <p>$<?php echo $packPod->field('price');?>&#032;per day</p>
                        </div>

                        <?php 
                            if(function_exists('displayAddToCart')):
                                displayAddToCart($packPod->field('id'), $podName);
                            endif;
                        ?>

                    </div><!-- geardescription -->    
                
                </div><!-- gearcontent --> 
                <?php } // if ends ?>   
            <div class=" centerAlign" id="packages">

            <div class="radialouter ">
                <div class="line" ></div>
            </div>   
            <h2>Explore the rest of our Packages!</h2>

            <ul class="ch-grid circle4">
                <?php while($packagesPod->fetch()):?>
                <li>
                    <div class="ch-item <?php echo $packagesPod->field('altname');?>">
                        <a href="<?php bloginfo('url');?>/packages/<?php echo $packagesPod->field('permalink');?>" class="ch-info ch-hov-sml-1">
                            <p><?php echo $packagesPod->field('name');?></p>
                        </a>
                    </div>
                </li>
               <?php endwhile;?>
            </ul>
        </div>
        </div><!-- #packages -->
                

                <?php displayMiniCart(); ?>    
        </div> <!-- wrapper end-->

<?php get_footer(); ?>