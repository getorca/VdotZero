<?php get_header(); ?>

<?php get_sidebar(); ?>

<!-- main -->
<div class="column col-sm-8 col-sm-offset-4" id="main">
                                          
    <!-- content -->
    
    <div class="row" id="content">    
        <div class="col-sm-12">
            <?php if (have_posts()) : while (have_posts()) : the_post(); ?>
                <?php //some post functions
                    $format = get_post_format();
                    if ( false === $format ) {
                        $format = 'standard';
                    }
                ?>
                <div <?php post_class(); ?>>
                    <div class="post-header">
                        <?php if ($format === video) {
                            echo '<div class="video-100">'.get_post_meta( get_the_ID(), 'video_embed', true ).'</div>';            
                        } elseif ( has_post_thumbnail() ) {
                            echo '<div class="feature-img">';
	                        the_post_thumbnail();
                            echo '</div>';
                        } ?>
                        <h2>
                            <?php if (is_single()) { 
                                echo get_the_title();
                            } else {
                                echo '<a href="'. get_permalink() .'" title="Permanent Link to '. get_the_title().'">'. get_the_title() .'</a>';
                            } ?>
                        </h2>        
                    </div>    
                    <div class="post-content">
                        <?php the_content(); ?>
                    </div>
                    
                </div><!-- /post -->
            
                    <?php
                     // If comments are open or we have at least one comment, load up the comment template.
			         if ( comments_open() || get_comments_number() ) :
				        comments_template();
			         endif;
                    ?>
            
            <?php endwhile; else: ?>
    	       <p><?php _e('Sorry, no posts matched your criteria.'); ?></p>
            <?php endif; ?>
        </div>
    </div>
    <!-- /content -->
    
    <!-- footer -->
    
    <div class="row" id="footer">
        <hr/>
        <div class="col-md-12">
            <a href="#" class="pull-right">©Copyright LawrenceStewartDOTca</a>
        </div>
    </div>
    <!-- /footer -->
                      
</div>
<!-- /main -->

<?php get_footer(); ?>