                </div><!-- /row -->
            </div><!-- /box -->
        </div><!-- /wrapper -->
        <!-- script references -->
		<script src="//ajax.googleapis.com/ajax/libs/jquery/2.0.2/jquery.min.js"></script>
		<script src="<?php echo get_template_directory_uri(); ?>/js/bootstrap.min.js"></script>
		<script src="<?php echo get_template_directory_uri(); ?>/js/jquery.fitvids.js"></script>
        <script src="<?php echo get_template_directory_uri(); ?>/js/lightbox.js"></script>
        <script src="<?php echo get_template_directory_uri(); ?>/js/vdotzero.js"></script>
        <script>
          $(document).ready(function(){
            // Target your videos for fitvids
            $(".video-100").fitVids();
          });
        </script>

	<?php wp_footer(); ?>

	</body>
</html>