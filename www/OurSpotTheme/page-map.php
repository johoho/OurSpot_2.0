<?php
/***
Template Name: Map Template
***/

get_header();
    $catPod = pods("Locations");
    $params = array( 'orderby' => 'id ASC', 'limit' => -1);
    $catPod->find($params);
    $numCats = $catPod->getTotalRows();


    $mapPod     = pods("campsites");   // create the catPod object.
    $params     = array('orderby'=>'ranking.name DESC','limit' => -1); // create a variable for the filter parameters array.    orderby ranking
    $mapPod     ->find($params); // apply the parameters to the object to get the bits we want.

    $mapLocationPod     = pods("locations");   // create the catPod object.
    $params     = array('orderby'=>'order ASC','limit' => -1); // create a variable for the filter parameters array.    orderby ranking
    $mapLocationPod     ->find($params); // apply the parameters to the object to get the bits we want.



// var_dump($campsPod);
?>

           

    <?php #die(); ?>



<!--==================== Full Width Images  =============================-->
    
    <div class="mapbgimg"></div>
 
    <div class="wrapper content clearfix">
        
        <div class="radialouter">
            <div class="line" ></div>
            <h1>pick your spot</h1>
        </div>

        <div class="maparea" >

           

            <div class="map">

                <?php while ($mapLocationPod->fetch()) { ?>
                    <a class="map-hov <?php echo $mapLocationPod->field('permalink'); ?>"
                        title="<?php echo $mapLocationPod->field('name'); ?>"  
                        data-location="<?php echo $mapLocationPod->field('permalink'); ?>"></a>
                <?php } ?>
                
            </div><!-- map -->

            <div class="box">

                <div class="box2">
                    <div class="box3 clearfix">
                        <div class="top5">
                            <P>TOP FIVE<BR /><span></span> CAMP SITES</P>
                        </div><!-- top5 -->
                        <?php 

                        $counter = array();

                        while ($mapPod->fetch()) { 

                            $key = $mapPod->field('location.name');

                            if( !isset($counter[ $key ] ) ) $counter[ $key ] = 0;
                            if( $counter[ $key ] < 5 ):

                        ?>

                        <a href="campsites/<?php echo $mapPod->field('location.permalink'); ?>/<?php echo $mapPod->field('permalink'); ?>"
                            class="bubblesite"
                            data-location="<?php echo $mapPod->field('location.permalink'); ?>" >
                            <h3><?php echo $mapPod->field('name'); ?></h3>
                            <div class="acticons clearfix" >
                                
                                    <?php $activities = $mapPod->field("activities");

                                    $numAct = count($activities);

                                    for ($i=0; $i < $numAct; $i++) {
                                        $getAct = $activities[$i];
                                        $getActId = ($getAct['id']);

                                        $actPod = pods("Activities",$getActId);
                                        $actName = $actPod->field('name');
                                        $actIcon = $actPod->field('icon.guid');

                                    ?>
                                    <!-- <div class="icon" > -->
                                        <img class="icon" src="<?php echo $actIcon;?>" alt="<?php echo $actName;?>" />        
                                    <!-- </div> -->
                                    <?php } //close activity icon loop ?> 
                            
                            </div>
                        </a>  
                        
                        <?php 

                            endif;
                            ++$counter[ $key ];

                        } ?>

                        <!-- <a href="#" class="greenbutton">VISIT ALL CAMP SITES</a> -->

                        <?php while($catPod->fetch()) { ?>
                            <a href="<?php bloginfo('url'); ?>/map/<?php echo $catPod->field('permalink');?>"
                                id="<?php echo $catPod->field('permalink');?>"
                                class="greenbutton"
                                data-name="<?php echo $catPod->field('name');?>">VISIT All CAMP SITES IN THIS REGION</a>
                        <?php }  ?>
                    </div><!-- box3 -->
                </div><!-- box2 -->
            </div><!-- box -->

        </div><!-- maparea -->
   
    </div> <!-- ================= WRAPPER DIV ENDS ====================== -->
<?php get_footer();?>


