<?php
/*
Plugin Name: Form Mail Custom
Version: 1.0
Author: Seejays (adapted from code by Matthew Stevens)
Description: A custom self-contained plugin featuring a contact form with jQuery validation and Ajax send mail functionality - the form requires styling via theme CSS using .contact-form and add cfm_footer() before the closing </body> tag
*/
//define constants
define( 'RECIPIENT', 'joanne.j.ho@gmail.com' );
define( "FORM_PLUGIN_URL", plugin_dir_url( __FILE__ ) );

//create custom hook (to use instead of wp_footer())
function cfm_footer() {
  do_action( 'cfm_footer' );
}

//add function addFormScripts to custom hook
add_action( 'cfm_footer', 'addFormScripts' );

//add sendMail action to wp_ajax
add_action( 'wp_ajax_sendMail', 'sendMail' );
add_action( 'wp_ajax_nopriv_sendMail', 'sendMail' );

// add shortcode
add_shortcode( 'contact-form', 'displayContactForm' );//[contact-form]
//
function displayContactForm() {?>
    <form class="contact-form" id="contact-form" action="<?php echo admin_url('admin-ajax.php'); ?>" method="post">
                    <p id="status"></p>

                    <div class="select">
                        <select>
                            <option id="ops_20" value="Enquiry Type">Enquiry Type</option>
                            <option id="ops_21" value="booking">Booking a Campsite</option>
                            <option id="ops_22" value="Gear Hire">Gear Hire</option>
                            <option id="ops_23" value="Urgent"> Urgent</option>
                        </select>
                    </div>

                    <div class="contact_contain clearfix">
                        <div class="">
                            <label for="firstName">First Name</label>
                            <input type="text" id="firstName" name="firstName">
                        </div>
                        <div class="">
                            <label for="lastName">Last Name</label>
                            <input type="text" id="LastName" name="LastName">
                        </div>
                    </div> <!-- name_contain -->

                    <div class="contact_contain clearfix">
                        <div class="">
                            <label for="phone">Phone Number</label>
                            <input type = "text" id = "txtPhone" />
                        </div>
                        <div class="">
                            <label for="email">Email</label>
                            <input type="text" id="email" name="email">
                        </div>
                    </div><!-- contact_contain -->


                    <div class="contact_msg">
                        <textarea name="message" id="message" rows="10" cols="57" placeholder=" Message Here"></textarea>
                    </div>

                    <div class="select">
                        <select>
                            <option id="ops_30" value="contactMethod">
                                Contact me via
                            </option>
                            <option id="ops_31" value="byEmail">
                                Email Me
                            </option>
                            <option id="ops_32" value="byPhone">
                                Call Me
                            </option>
                        </select>
                    </div>

                    <div class="contact_subscribe">
                        <input type = "checkbox" id = "chkNewsletter" value = "newsletter" />
                        <label>Subscribe to Newsletter</label>
                    </div>

                    <div>   
                        <input class="button" type="submit" value="Send"> 
                        <input class="button" type="reset" value="Reset">
                    </div>
                    <input id="spam" class="hidden" name="spam" type="text" value=""> <input name="action" type="hidden" value="sendMail">
                </form>
<?php }

function addFormScripts() {
?>
          <script src="<?php echo FORM_PLUGIN_URL.'js/jquery.formvalidation.js' ?>" type="text/javascript">
</script>
          <script src="<?php echo FORM_PLUGIN_URL.'js/contact.js' ?>" type="text/javascript">
</script>
<?php
}

function sendMail() {

  define('RECIPIENT', 'ramon.thackwell@mediadesign.school.nz');

  //catch the post vars
  $firstName = $_POST['firstName'];
  $lastName = $_POST['LastName'];
  $txtPhone = $_POST['txtPhone'];
  $email = $_POST['email'];
  $message = $_POST['message'];

  //set email body and headers
  $body = $message."\n\n";
  $body.= $lastName.'<'.$email.'>';
  $headers = 'From: '.$LastName.'<'.$email.'>'."\r\n";

  //send email
  if ( mail( RECIPIENT, $body, $headers ) ) {

    echo "success";

  } else {

    echo "error";

  }//end if else
  exit;
}
?>
