<?php
/*
Template Name: Home Page
*/
?>
<?php 

get_header(); 
    $packagePod = pods("packages");
    $params = array( 'orderby' => 'id ASC', 'limit' => -1);
    $packagePod->find($params);

    ?>
<!--==================== Full Width Images  =============================-->
    
    <div id="bgImgs"></div>
 
 <div class="wrapper clearfix">       

    <h1 class="pageheading">book your spot with 3 easy steps.</h1>
<!--============================== CIRCLES ==============================-->

            <ul class="ch-grid circle3">
                <li>
                    <div class="ch-item ch-img-1">
                        <a href="<?php bloginfo('url');?>/map" class="ch-info ch-hov-1"></a>
                    </div>
                </li>
                <li>
                    <div class="ch-item ch-img-2">
                        <a href="<?php bloginfo('url');?>/gear-hire" class="ch-info ch-hov-2"></a>
                    </div>
                </li>
                <li>
                    <div class="ch-item ch-img-3">
                        <a href="<?php bloginfo('url');?>/cart" class="ch-info ch-hov-3"></a>
                    </div>
                </li>
            </ul>

<!--============================ CIRCLES END ============================-->
        
        <div class="radialouter">
            <div class="line" ></div>
        </div>

        <div class=" centerAlign" id="packages">
        <h3>packages made easy</h3>        
                        <ul class="ch-grid circle4">
                <?php while($packagePod->fetch()):?>
                <li>
                    <div class="ch-item <?php echo $packagePod->field('altname');?>">
                        <a href="<?php bloginfo('url');?>/packages/<?php echo $packagePod->field('permalink');?>" class="ch-info ch-hov-sml-1">
                            <p><?php echo $packagePod->field('name');?></p>
                        </a>
                    </div>
                </li>
               <?php endwhile;?>
            </ul>
        </div><!-- packages -->
    </div> <!-- wrapper -->

<?php get_footer(); ?>