    <footer class="centerAlign">
        <a href="<?php echo home_url(); ?>"><img id="footerLogo" src="<?php bloginfo('template_url'); ?>/images/logo.png" alt="home"></a>
        <nav>
        	<?php wp_nav_menu(array('menu' => 'Footer Nav Menu')); ?>
        </nav>

        <img src="<?php bloginfo('template_url'); ?>/images/credit_card.gif" alt="we accept all major credit cards">

        <p id="disclaimer">
             &copy; Seejays, 2013. This project was built for educational purposes. The brand represents a fictional company.
        </p>


</footer>

			    <script>
        var siteinfo = {'imagePath': '<?php bloginfo('template_url'); ?>/images/'}
        </script>

        <script src="//ajax.googleapis.com/ajax/libs/jquery/1.9.0/jquery.min.js"></script>
        <script>window.jQuery || document.write('<script src="<?php bloginfo('template_url'); ?>/js/vendor/jquery-1.9.0.min.js"><\/script>')</script>
        <script src="<?php bloginfo('template_url'); ?>/js/vendor/jquery.backstretch.js"></script>
        <script src="<?php bloginfo('template_url'); ?>/js/vendor/waypoints.min.js"></script>
        <script src="<?php bloginfo('template_url'); ?>/js/vendor/jquery-ui-1.10.0.custom.min.js" type="text/javascript"></script>
        <script src="<?php bloginfo('template_url'); ?>/js/plugins.js"></script>
        <script src="<?php bloginfo('template_url'); ?>/js/main.js"></script>

                <?php cfm_footer();
                        ls_footer();
                        sc_footer(); ?>
    </body>
</html>