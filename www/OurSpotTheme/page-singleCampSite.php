<?php
/*
Template Name: Single Campsite Page
*/

get_header();
$podName = "campsites";
$campPermalink = pods_url_variable(-1);
$campsPod = pods($podName, $campPermalink);
?>
    <div class="wrapper content camppage clearfix">
        <div class="radialouter">
            <div class="line"></div>
        </div>    

        <?php if(!empty($campsPod->data)){ 
            $image = $campsPod->field('image');
        ?>
            
        <h1><?php echo $campsPod->field( 'name' );?></h1>
            
        <div class="gearcontent clearfix"?>
                
            <div class="gear-imageguff">
                <img class="photo" src= "<?php echo $image['guid'];?>" />
                <div id="ratings">
                    <?php 
                        $ranking = $campsPod ->field('ranking');
                        $rankingId = $ranking['id'];
                        $rankingPod = pods("Rankings",$rankingId);
                        $icon = $rankingPod->field('icon');
                        $image = wp_get_attachment_image_src($icon["ID"], "large");                             
                    ?>
                    <img src="<?php echo $image[0]; ?>" alt="<?php echo $rankingPod->field('name'); ?>" />    
                </div><!-- ratings-->
            </div><!-- gearimageguff -->    
            
            <div class="geardescription">     
                
                <p><?php echo $campsPod->field( 'description' );?></p>
                
                <div id="price">
                    <h3>price:</h3>
                    <p>$<?php echo $campsPod->field( 'price' );?>&#032;per day</p>
                </div>
                
                
                
                <div id="facilities">
                    <?php $facilities = $campsPod->field( "facilities" );
                        $numFac = count($facilities);
                        for ($i=0; $i < $numFac; $i++) { 
                            $getFac = $facilities[$i];
                            $getFacId = ($getFac['id']);
                            $facPod = pods("Facilities",$getFacId);
                            $facName = $facPod->field('name');
                            $facIcon = $facPod->field('icon.guid');
                    ?>
                    <img src="<?php echo $facIcon;?>" alt="<?php echo $facName;?>" />
                    <?php } //close facility icon loop?>
                </div> <!-- facilities -->
                
                <div id="activities">
                    <?php $activities = $campsPod->field("activities");
                        $numAct = count($activities);
                        for ($i=0; $i < $numAct; $i++) {
                            $getAct = $activities[$i];
                            $getActId = ($getAct['id']);
                            $actPod = pods("Activities",$getActId);
                            $actName = $actPod->field('name');
                            $actIcon = $actPod->field('icon.guid');
                    ?>
                    <img src="<?php echo $actIcon;?>" alt="<?php echo $actName;?>" />        
                    <?php } //close activity icon loop ?>
                </div><!-- activities -->
                
                
                    
                        <?php
                       if ( function_exists( 'displayAddToCart' ) ):
                         displayAddToCart( $campsPod->field( 'id' ), $podName );
                       endif;
                    ?>
                
                
            </div><!- geardescription ->
        </div> <!-- gearcontent -->
        <?php } //close while ?>
            
        <div class="line"></div>
        <?php displayMiniCart(); ?>

    </div><!-- ================= WRAPPER DIV ENDS ====================== -->

<?php get_footer();?>


