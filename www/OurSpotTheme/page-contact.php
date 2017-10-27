<?php 

/***
Template Name: Contact Template
***/

get_header(); ?>

    <div class="aspectwrapper">
        <div class="aspectcontent">
           <!--  <iframe class="contactmap" scrolling="no" marginheight="0" marginwidth="0" src="http://maps.google.co.nz/maps?f=q&amp;source=s_q&amp;hl=en&amp;geocode=&amp;q=Media+Design+School,+Albert+Street,+Auckland&amp;aq=0&amp;oq=media+design+&amp;sll=-36.863023,174.865469&amp;sspn=0.948206,2.108002&amp;t=h&amp;ie=UTF8&amp;hq=Media+Design+School,&amp;hnear=Albert+St,+Auckland&amp;cid=15089202811003734988&amp;ll=-36.848101,174.763727&amp;spn=0.04121,0.087891&amp;z=14&amp;iwloc=A&amp;output=embed&amp;iwloc=near"></iframe> -->
          <iframe width="100%" height="350" frameborder="0" scrolling="yes" marginheight="0" marginwidth="0" src="//maps.google.co.nz/maps?f=q&amp;source=s_q&amp;hl=en&amp;geocode=&amp;q=Media+Design+School,+Albert+Street,+Auckland&amp;aq=0&amp;oq=media+de&amp;sll=-36.863023,174.865469&amp;sspn=0.924034,1.115112&amp;ie=UTF8&amp;hq=Media+Design+School,&amp;hnear=Albert+St,+Auckland&amp;t=m&amp;z=16&amp;output=embed"></iframe>
      </div>
    </div>
    
     <div class="wrapper contact-wrap clearfix">       

         <div class="clearfix">
                <div class="radialouter ">
                <div class="line" ></div></div>
                <h1>contact us</h1>
            </div> <!-- -->

           
            <div class="clearfix">
               
                <div id="contactDeets">
                    <p>Head Office:</p>
                    <p>Seejays Holdings Ltd.</p>
                    <p>Albert Street</p>
                    <p>PO BOX 12345</p>
                    <p>Auckland</p>
                    <p>New Zealand</p><br>
                    <p>Freephone: 0800 our spot (862 267)</p>
                    <p>Phone: +64 9 123 4567</p>
                    <p>Fax: +64 9 765 4321</p>
                </div>
            <?php 
                if(function_exists('displayContactForm')):
                    displayContactForm();
                else:
                    echo "Cannot find function dispayContactForm";
                endif;
            ?>

            
             </div> <!-- block2 -->

    </div> <!-- ================= WRAPPER DIV ENDS ====================== -->

<?php get_footer(); ?>