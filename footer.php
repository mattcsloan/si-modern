    <div class="footer">
        <a name="contact"></a>
    	<div class="wrapper">
            <h1>Contact Us</h1>
            <div class="columns two-wide">
                <div class="col contact-info">
                    <div class="social">
                        <a class="fb" href="#" target="_blank"></a>
                        <a class="tw" href="#" target="_blank"></a>
                        <a class="in" href="#" target="_blank"></a>
                        <a class="yt" href="#" target="_blank"></a>
                        <a class="gp" href="#" target="_blank"></a>
                        <a class="rss" href="#" target="_blank"></a>
                    </div>
                    <p class="company-phone-number">
                        <i class="icon-phone"></i>
                        XXX-XXX-XXXX
                    </p>
                    <p class="company-address">
                        <strong>Company Name</strong>
                        <span>Address Line 1</span>
                        <span>Address Line 2</span>
                        <span>City, ST 12345</span>
                    </p>
                </div>
            </div>
        </div>
        <div class="footer-bar">
            <div class="wrapper">
                <?php wp_nav_menu( array( 'theme_location' => 'main-navigation', 'menu_id' => 'footer-main-navigation', 'depth' => 1) ); ?>
                <p class="copyright">&copy; <span class="year">2017</span> Company Name</p>
            </div>
        </div>
    </div>
    <?php wp_footer(); ?>
</body>
</html>