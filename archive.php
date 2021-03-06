<?php get_header(); ?>


<?php get_sidebar(); ?>



<!-- main -->
<div class="column col-sm-8 col-sm-offset-4" id="main">
                                          
    <!-- content -->
    
    <div class="row" id="content">    
        <div class="col-sm-12">
            
            <div class="page-header">
                <?php the_archive_title( '<h1 class="page-title">', '</h1>' ); ?>   
            </div>
            
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
                                if ($format === 'link') {
                                    echo '<a href="'. get_post_meta( get_the_ID(), 'external_link', true ) .'" title="">'. get_the_title() .'</a>';
                                } else {
                                    echo '<a href="'. get_permalink() .'" title="Permanent Link to '. get_the_title().'">'. get_the_title() .'</a>';
                                }
                            } ?>
                        </h2>        
                    </div>    
                    <div class="post-content">
                        <?php the_content(); ?>
                    </div>
                    <div class="post-footer text-muted">
                        <div class="post-meta post-type"><span class="fa post-format-<?php echo $format ?>"></span> <?php echo ucfirst($format); ?></div>
                        <div class="post-meta post-date"><span class="fa fa-calendar"></span> <?php the_time('F jS, Y') ?></div>
                        <div class="post-meta post-category"><span class="fa fa-folder-open-o"></span> <?php echo get_the_category_list(', '); ?></div>
                        <div class="post-meta post-tags"><span class="fa fa-tag"></span> <?php echo get_the_tag_list('', ', '); ?> </div>
                    </div>
                </div><!-- /post -->
            <?php endwhile; ?>
                
                <!-- pagenation --> 
                <?php
                    if(get_next_posts_link()){
                        $npl=explode('"',get_next_posts_link());
                        echo '<div class="pagenate-link nav-previous"><a href="'.$npl[1].'"><div class="pagenate-meta">Older posts &#187;</div></a></div>';
                    }
                    if(get_previous_posts_link()) {
                        $ppl=explode('"',get_next_posts_link());
                        echo '<div class="pagenate-link nav-next"><a href="'.$ppl[1].'"><div class="pagenate-meta">&#171; Newer posts</div></a></div>';
                    } 
                ?>
                <!-- /pagenation -->
 
            <?php else: ?>
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