            <!-- sidebar -->
            <div class="column col-sm-4" id="sidebar">
                <div class="sidebar-content">
                    <div class="branding">
                        <a href="<?php echo home_url(); ?>" title="<?php echo esc_attr( get_bloginfo( 'name', 'display' ) ); ?>">
                            <?php
                            if(!empty(get_theme_mod( 'site_logo' ))){ 
                                echo '<div class="logo"><img src="'. get_theme_mod( 'site_logo' ) .'" alt="'. esc_attr( get_bloginfo( "name", "display" ) ) .'"></div>';
                            } ?>
                            <h1 class="site-title"><?php bloginfo('name'); ?></h1>
                        </a>
                    </div>
                
                <div class="menu-wrap">
                    <div class="menu-switch fa"></div>
                    <div class="sidebar-collapse">  
                </div>
  
                <?php
                    wp_nav_menu( array( 
                        'theme_location' => 'main-menu',
                        'menu_class' => 'nav main-nav',
                        'menu_id' => 'main-nav',
                        'depth' => 1
                    ));
                ?>
                <?php get_search_form(); ?>
                    
                    <div class="social-networks">
                    <?php
                        $sociallinks = get_option( 'lawrencevdotzero-sociallinks');   
                        //var_dump($sociallinks);
                        foreach($sociallinks as $key => $value) {
                            if($value != null) {
                               echo '<a href="'.$value.'"><span class="fa fa-social fa-'.$key.'-square"></span></a>'; 
                            }

                        }
                    ?>
                    </div>
                   
                    </div>
                    
                </div>
                
            </div>
            <!-- /sidebar -->