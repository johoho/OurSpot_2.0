<?php
/*
Template Name: Campsites Regional Page
*/
?>
<?php get_header(); 

$catPermalink = pods_var(-1, "url");
$podName = "campsites"; 
$campsPod = pods($podName);
$params = array( 'orderby' => 'name ASC', 'limit' => -1, 'where' => "location.permalink='$catPermalink'");
$campsPod->find($params);
$numcamps = $campsPod->total_found();
$singleCatPod = pods('locations', $catPermalink);

?>
 
    <div class="wrapper content clearfix">       

        <div class="radialouter ">
            <div class="line" ></div>
        </div>  
         
        <div id="liveSearch" class="search-bars">
             <?php     
                if(function_exists(display_live_search)):
                    display_live_search("campsites");
                endif;              
            ?>
        </div>
        
        <div class="centerAlign" id="searchResults"></div>

        <?php if(!empty($singleCatPod->data)){ ?>
            <h1><?php echo $singleCatPod->field('name')?> Campsites</h1>
        <?php }?>
  
        <?php while($campsPod->fetch()):
          $image = $campsPod->field('image.guid');
         // $image = wp_get_attachment_image_src($image['ID']);
        ?>
      
        <div class="gearcontent clearfix">
            
            <div class="radialouter">
                <div class="line"></div>
            </div>
        
            <div class="gear-imageguff">
                
                <a href="<?php bloginfo('url'); ?>/campsites/<?php echo $catPermalink?>/<?php echo $campsPod->field('permalink'); ?>">
                    <img class="photo" src= "<?php echo $image;?>" />
                </a>

                <div id="ratings">
                    <?php 
                    $ranking = $campsPod ->field('ranking');
                    $rankingId = $ranking['id'];
                    $rankingPod = pods("Rankings",$rankingId);
                    $icon = $rankingPod->field('icon');
                    $image = wp_get_attachment_image_src($icon["ID"], "large");                             
                        ?>
                    
                    <img src="<?php echo $image[0]; ?>" alt="<?php echo $rankingPod->field('name'); ?>" />
                    
                </div>
            
            </div> <!-- gear-imageguff-->    


               
            
            <div class="geardescription"><!-- gradescription-->    
        
                <h2><a href="<?php bloginfo('url'); ?>/campsites/<?php echo $catPermalink?>/<?php echo $campsPod->field('permalink'); ?>"><?php echo $campsPod->field('name'); ?></a></h2>
            
                <p class="excerpt"><?php echo $campsPod->field('description');?></p>

                <div id="price">
                        <h3>
                            price:
                        </h3>
                        <p>
                            $ <?php echo $campsPod->field( 'price' );?> &#032;per day
                        </p>
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
                </div> 
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
                </div>
                <div class="rightAlign">
                    <a href="<?php bloginfo('url'); ?>/campsites/<?php echo $catPermalink?>/<?php echo $campsPod->field('permalink'); ?>" class="greenbutton">VIEW CAMPSITE</a>
                </div>
            </div> <!-- geardescription -->

        </div><!-- gearcontent -->
        
        <?php endwhile;?>
                  
        <?php displayMiniCart(); ?>    

        </div> <!-- wrapper end-->

<?php get_footer(); ?>
