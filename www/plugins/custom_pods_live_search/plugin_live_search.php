<?php
/*
Plugin Name: Custom Pods Live Ajax Search
Version: 2.0
Author: Mason Herber, updated to Pods 2 by Matt Stevens Nov 2012
Description: A plugin to demonstrate a simple ajax search using Pods
*/

define("SEARCH_PLUGIN_URL", plugin_dir_url( __FILE__ ));
define("SEARCH_TRIGGER", SEARCH_PLUGIN_URL."js/triggers.js");

// --------------- ACTIONS ---------------------
add_action( 'wp_ajax_liveSearch', 'liveSearch' );
add_action( 'wp_ajax_nopriv_liveSearch', 'liveSearch' );

// --------------- FUNCTIONS ---------------------

//displays the serach form and accepts the pod to be searched as an argument
function display_live_search($podName){
?>

  <form id="search-form" action="<?php echo admin_url('admin-ajax.php');?>" method="post" class="live-search-form" data-podname="<?php echo $podName; ?>">
      <label for="search">Search <?php echo ucwords($podName)?></label>
      <input type="text" name="search"  id="search" class="search"/>
      <input type="submit" value="Search" class="submit button" />
      <input type="hidden" value="liveSearch" id="action" />
  </form>

<?php	
}

// --------------- SCRIPTS ---------------------
//create custom hook (to use instead of wp_footer())
function ls_footer(){
    do_action('ls_footer');
}

//add function addSearchScripts to custom hook
add_action('ls_footer', 'addSearchScripts');

function addSearchScripts(){ ?>
	<script src="<?php echo SEARCH_TRIGGER ?>"></script>
<?php 
}

//live search function is called by Ajax, it queries the specified pod fields for 'LIKE' string and returns html results
function liveSearch(){
	$searchTerm = $_POST['searchTerm'];
	$podName= $_POST['podName'];
	$thePod = pods($podName);
	//This is searching one Pod at a time searching both the description and name fields
	$params = array( 'orderby' => 't.name ASC', 'limit' => -1, 'where' => "t.name LIKE '%$searchTerm%' || t.description LIKE '%$searchTerm%'");
	$thePod->find($params);
	$numRows = $thePod->total_found();
	
	if($numRows > 0){
		while($thePod->fetch() ){//while there are items to display:
			$id = $thePod->field("id");
			$name = $thePod->field("name");
			$description = $thePod->field("description");
			$price = $thePod->field("price");
      $permalink = $thePod->field("permalink");

			$image = $thePod->field('image');
      $image = wp_get_attachment_image_src($image['ID'], 'medium');
			?>
             
        <div class="post exhibition-listing content gearcontent clearfix">
        	        		<h3>YOUR SEARCH RESULTS</h3>
        	<div class="radialouter">
        		<div class="line"></div>
        	</div>
    	<div class="gear-imageguff">
            <img class="photo" src="<?php echo $image[0]; ?>"/>
      </div><!-- gearimageguff-->      
      <div class="geardescription">
            <?php 
            //var_dump($podName);
              if ($podName == "gears") {
                  $category = $thePod->field("activities");
                  $catPermalink= $category["permalink"];
              } else if ($podName == "campsites"){
                  $category = $thePod->field("location");
                  $catPermalink = $category["permalink"];    
              };
              //var_dump($catPermalink);
            ?>
            <h2><a href="<?php bloginfo( 'url' ); ?>/<?php echo $podName ?>/<?php echo $catPermalink ?>/<?php echo $permalink; ?>"; ?><?php echo $name ?></a></h2>
            <p class="excerpt"><?php echo $description;?></p>
            <p class="price">$<?php echo $price;?>&#032;per day</p>
      </div> <!-- geardescription -->
      
      <a href="<?php bloginfo( 'url' ); ?>/<?php echo $podName ?>/<?php echo $catPermalink ?>/<?php echo $permalink; ?>" class="greenbutton">VIEW ITEM</a>
       
      </div> <!-- end gearcontent -->
				
			<?php
		}//endwhile

	} else {
		echo "<p>There are no matching results for \"$searchTerm\"</p>";
	}
	exit;
}
?>