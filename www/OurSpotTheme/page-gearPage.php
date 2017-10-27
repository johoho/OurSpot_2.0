<?php
/*
Template Name: Gear Page
*/
?>
<?php get_header();
$catPermalink = pods_var( -1, "url" );
$podName = "gears";
$gearsPod = pods( $podName );
$params = array( 'orderby' => 'name ASC', 'limit' => -1, 'where' => "activities.permalink='$catPermalink'" );
$gearsPod->find( $params );
$numgears = $gearsPod->total_found();
$singleCatPod = pods( 'activities', $catPermalink );
?>

     <div class="wrapper content clearfix">
          <div class="radialouter ">
               <div class="line" ></div>
          </div>
          <div id="liveSearch" class="search-bars">
               <?php
                    if ( function_exists( display_live_search ) ):
                      display_live_search( "gears" );
                    endif;
               ?>
          </div>
          <div class="centerAlign" id="searchResults"></div>
          <?php if(!empty($singleCatPod->data)){ ?>
               <h1><?php echo $singleCatPod->field('name')?> gear</h1>
          <?php }?>

          <?php while ( $gearsPod->fetch() ):
               $image = $gearsPod->field( 'image.guid' );
               //$image = wp_get_attachment_image_src( $image['ID'] );
          ?>
          <div class="gearcontent clearfix">
               <div class="radialouter ">
                    <div class="line" ></div>
               </div>
               
               <div class="gear-imageguff clearfix">
                    <a href="<?php bloginfo( 'url' ); ?>/gears/<?php echo $catPermalink?>/<?php echo $gearsPod->field( 'permalink' ); ?>">
                         <img class="photo" src= "<?php echo $image;?>" />
                    </a>
               </div> <!-- gearimageguff -->     
               
               <div class="geardescription">
                    <h2><a href="<?php bloginfo( 'url' ); ?>/gears/<?php echo $catPermalink?>/<?php echo $gearsPod->field( 'permalink' ); ?>"><?php echo $gearsPod->field( 'name' ); ?></a></h2>
                    
                    <p class="excerpt"><?php echo $gearsPod->field( 'description' );?></p>
                    
                    <div id="price">
                         <h3>price:</h3>
                         <p>$<?php echo $gearsPod->field( 'price' );?> &#032; per day </p>
                    </div>
               
               </div> <!-- geardescription -->
               <div class="rightAlign">
                    <a href="<?php bloginfo( 'url' ); ?>/gears/<?php echo $catPermalink?>/<?php echo $gearsPod->field( 'permalink' ); ?>" class="greenbutton">VIEW ITEM</a>
               </div>
          </div><!-- gearcontent -->
          <?php endwhile;?>
     </div> <!-- wrapper end-->


<?php get_footer(); ?>
