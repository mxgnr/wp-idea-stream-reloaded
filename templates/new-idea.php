<?php get_header()?>
<div id="container">
	<div id="content" role="main">
		
		<h1 class="page-title"><?php
			 _e( 'Submit your idea!', 'wp-idea-stream' );
		?></h1>
		
		<?php do_action('wp_idea_stream_before_form_new_idea');?>
		
		<?php do_action('wp_idea_stream_insert_editor');?>
		
		<?php do_action('wp_idea_stream_after_form_new_idea');?>
		
	</div>
</div>
<?php get_sidebar();?>
<?php get_footer();?>