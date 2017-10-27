<?php
/*
Template Name: Gear Categories Page
*/
?>
<?php get_header();
    $catPod = pods("activities");
    $params = array( 'orderby' => 'id ASC', 'limit' => -1);
    $catPod->find($params);
    $numCats = $catPod->getTotalRows();

    $packagePod = pods("packages");
    $packagePod->find($params);

 ?>
<div class="wrapper content clearfix">     
    <div class="search-bars">
        <?php     
            if(function_exists(display_live_search)):
                display_live_search("gears");
            endif;              
        ?>
    </div>
        <div class="radialouter ">
            <div class="line" ></div>
        </div>  
        <div class="centerAlign" id="searchResults">
        </div>
        <h1>gear hire</h1> 

        <div class="centerAlign" id="packages">
        <nav>
            <ul class="ch-grid circle4">
            <?php while($catPod->fetch()):?>
                <li>
                    <div class="ch-item <?php echo $catPod->field('name');?>">
                        <a href="<?php bloginfo('url'); ?>/gear-hire/<?php echo $catPod->field('permalink');?>"
                            class="ch-info ch-hov-sml-<?php echo $catPod->field('name'); ?>"><p><?php echo $catPod->field('name');?></p></a>
                    </div>
                </li>
            <?php endwhile;?>
            </ul>
        </nav>
       
            

         <div class=" centerAlign" id="packages">

            <div class="radialouter ">
                <div class="line" ></div>
            </div>

            <h1>packages made easy</h1>        
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
        </div>
        </div><!-- #packages -->
    </div> <!-- wrapper end -->

    

<?php get_footer(); ?>