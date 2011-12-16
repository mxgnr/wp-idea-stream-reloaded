<?php
/**
 * The template for displaying Best Ideas.
 *
 * @package WordPress
 * @subpackage WP Idea Stream
 * @since WP Idea Stream 1.0
 */
header('HTTP/1.1 200 OK');
get_header()?>
<div id="container">
	<div id="content" role="main">
		
		<h1 class="page-title"><?php
			 printf( __( 'Featured Ideas | %s ideas are featured so far', 'wp-idea-stream' ), '<span>' . wp_idea_stream_number_ideas() . '</span>');
		?></h1>
			
                <div id="most_voted_ideas">
		<?php include_once( ABSPATH . 'wp-admin/includes/plugin.php' );
			if(is_plugin_active('vote-it-up/voteitup.php')) {
				MostVotedAllTime_Widget(); // To customize data output and design, check this function into wp-content/plugins/vote-it-up/votingfunctions.php
			}
			else {
				echo '<p style="color: red;">'.__('You need to install the <a href="http://wordpress.org/extend/plugins/vote-it-up/">Vote It Up plugin</a> in order to active this page', 'wp-idea-stream').'</p>';
			}
			?>
                </div>
				
	</div><!-- content -->
</div>
<?php get_sidebar();?>
<?php get_footer();?>