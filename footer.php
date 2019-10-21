<?php
	/**
	 *
	*/
 
	$footer_layout = ewf_get_footer_layout();
?>

		<div id="footer">
		
			<div class="hr"></div>	
			
			<div class="row fixed">
				<?php ewf_setSection('zone-footer'); ?>
				
				<div class="col-460">
					&copy; <?php echo date('Y'). ' '.get_bloginfo('tagline'); ?> 
				</div><!-- end .col-460 -->
				
				<div class="col-220">
					<?php 
						ewf_setZone(460);
						if ( !function_exists('dynamic_sidebar')  || !dynamic_sidebar('footer-center-right') ); 							
					?>
				</div><!-- end .col-220 -->
				
				<div class="col-220 last">
					<?php 
						ewf_setZone(220);
						if ( !function_exists('dynamic_sidebar')  || !dynamic_sidebar('footer-right') ); 							
					?>
				</div><!-- end .col-220 -->
			
			</div><!-- end .row -->
			
		
		</div><!-- end #footer -->

	<?php wp_footer(); ?>
	
	</div><!-- end #wrap -->
<?php  if (is_front_page()) { ?>
	<script>
		$(document).ready(function(){
			$('#slideshow-index').slick({
				slide: 'li'
			});
		});
	</script>

<?php } ?>
	
</body>
</html>