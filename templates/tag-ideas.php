<?php
/**
 * The template for displaying Idea tags.
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
			printf( __( 'Tag Archives: %s | %s ideas were posted in this tag so far', 'wp-idea-stream' ), '<span>' . single_tag_title( '', false ) . '</span>', '<span>' . wp_idea_stream_number_ideas() . '</span>' );
		?></h1>
		
		<?php do_action('wp_idea_stream_before_tag_loop');?>
	
			<?php if ( ! have_posts() ) : ?>
				<div id="post-0" class="post error404 not-found">
					<h1 class="entry-title"><?php _e( 'No Ideas!', 'wp-idea-stream' ); ?></h1>
					<div class="entry-content">
						<p>
							<?php 
							if(is_user_logged_in()){
								printf( __('OOps, It looks like no idea has been submitted in this tag yet, <a href="%s" title="Submit your idea">add yours</a>', 'wp-idea-stream'), wp_idea_stream_new_form() );
							}else{
								_e( 'OOps, It looks like no idea has been submitted in this tag yet, please log in to add yours!', 'wp-idea-stream' );
							}
							?>
						</p>
					</div><!-- .entry-content -->
				</div><!-- #post-0 -->
			<?php endif; ?>
	
		<?php while ( have_posts() ) : the_post(); ?>
		
			<div id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
				<h2 class="entry-title"><a href="<?php the_permalink(); ?>" title="<?php printf( esc_attr__( 'Permalink to %s', 'wp-idea-stream' ), the_title_attribute( 'echo=0' ) ); ?>" rel="bookmark"><?php the_title(); ?></a></h2>

				<div style="float: right;"><?php get_vote_it_up_button(); ?></div>

				<div class="entry-meta">
					<?php wp_idea_stream_posted_on(); ?>
					<?php wp_idea_stream_ratings();?>
				</div><!-- .entry-meta -->

				<div class="entry-summary">
					<?php the_excerpt(); ?>
				</div><!-- .entry-summary -->
		
				<div class="entry-utility">
					
						<span class="cat-links">
							<?php wp_idea_stream_posted_in_cat(); ?>
						</span>
						<span class="meta-sep">|</span>
						
						<?php $tags_idea = wp_idea_stream_posted_in_tag();
						if($tags_idea):?>
						<span class="tag-links">
							<?php printf( __( '<span class="%1$s">Tagged</span> %2$s', 'wp-idea-stream' ), 'entry-utility-prep entry-utility-prep-tag-links', $tags_idea ); ?>
						</span>
						<span class="meta-sep">|</span>
						<?php endif;?>
						
					<span class="comments-link"><?php comments_popup_link( __( 'Leave a comment', 'wp-idea-stream' ), __( '1 Comment', 'wp-idea-stream' ), __( '% Comments', 'wp-idea-stream' ) ); ?></span>
					<?php edit_post_link( __( 'Edit', 'wp-idea-stream' ), '<span class="meta-sep">|</span> <span class="edit-link">', '</span>' ); ?>
				</div><!-- .entry-utility -->
			
			</div>
			
		<?php endwhile; // End the loop. Whew. ?>
		
		<?php do_action('wp_idea_stream_after_tag_loop');?>
		
		<div id="nav-below" class="navigation">
			<?php wp_idea_stream_paginate_link('paged'); ?>
		</div><!-- #nav-below -->
				
	</div><!-- content -->
</div>
<?php get_sidebar();?>
<?php get_footer();?>
