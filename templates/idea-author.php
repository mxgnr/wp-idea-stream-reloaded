<?php
/**
 * The template for displaying Idea Author Archive pages.
 *
 * @package WordPress
 * @subpackage WP Idea Stream
 * @since WP Idea Stream 1.0
 */
get_header(); ?>

		<div id="container">
			<div id="content" role="main">

<?php
	/* Queue the first post, that way we know who
	 * the author is when we try to get their name,
	 * URL, description, avatar, etc.
	 *
	 * We reset this later so we can run the loop
	 * properly with a call to rewind_posts().
	 */
	if ( have_posts() )
		the_post();
?>

			<?php if ( ! have_posts() ) : ?>
				<div id="entry-author-info">
					<div id="author-avatar">
						<?php echo get_avatar( get_displayed_idea_author_meta( 'user_email' ), 60 ); ?>
					</div><!-- #author-avatar -->
					
					<div id="author-description">
						<h2><?php printf( __( 'About %s', 'wp-idea-stream' ), get_displayed_idea_author() ); ?></h2>
						<?php if ( get_displayed_idea_author_meta( 'description' ) ) : ?>
							<?php displayed_idea_author_meta( 'description' ); ?>
						<?php else:?>
							<p><?php _e("This user hasn't filled his info","wp-idea-stream");?></p>
						<?php endif; ?>
					</div><!-- #author-description	-->
						<?php if(wp_idea_stream_loggedin_user_displayed(true)):?>
							<div id="ideastream-desc-edit" style="display:none;clear:both;margin-left:104px"><?php wp_idea_stream_desc_edit();?></div>
							<div id="ideastream-desc-action" style="clear:both;margin-left:104px"><a href="javascript:void(0)" title="Edit description" id="ideastream-edit-btn"><?php _e('Edit','wp-idea-stream');?></a></div>
						<?php endif;?>
				</div><!-- #entry-author-info -->
			<?php else: ?>

				<h1 class="page-title author"><?php printf( __( 'Author Archives: %s | Amount of submitted ideas so far: %s', 'wp-idea-stream' ), "<span class='vcard'><a class='url fn n' href='" . get_author_idea_url( get_the_idea_author_meta( 'ID' ) ) . "' title='" . esc_attr( get_idea_author() ) . "' rel='me'>" . get_idea_author() . "</a></span>", '<span>' . wp_idea_stream_number_ideas() . '</span>'  ); ?></h1>


					<div id="entry-author-info">
						<div id="author-avatar">
							<?php echo get_avatar( get_the_idea_author_meta( 'user_email' ), 60 ); ?>
						</div><!-- #author-avatar -->
						<div id="author-description">
							<h2><?php printf( __( 'About %s', 'wp-idea-stream' ), get_idea_author() ); ?></h2>
							<?php if ( get_the_idea_author_meta( 'description' ) ) : ?>
								<?php the_idea_author_meta( 'description' ); ?>
							<?php else:?>
								<p><?php _e("This user hasn't filled his info","wp-idea-stream");?></p>
							<?php endif; ?>
						</div><!-- #author-description	-->
							<?php if(wp_idea_stream_loggedin_user_displayed()):?>
								<div id="ideastream-desc-edit" style="display:none;clear:both;margin-left:104px"><?php wp_idea_stream_desc_edit();?></div>
								<div id="ideastream-desc-action" style="clear:both;margin-left:104px"><a href="javascript:void(0)" title="Edit description" id="ideastream-edit-btn"><?php _e('Edit','wp-idea-stream');?></a></div>
							<?php endif; ?>
					</div><!-- #entry-author-info -->
					
			<?php endif;?>


<?php
	/* Since we called the_post() above, we need to
	 * rewind the loop back to the beginning that way
	 * we can run the loop properly, in full.
	 */
	rewind_posts();

	/* Run the loop for the author archive page to output the authors posts
	 * If you want to overload this in a child theme then include a file
	 * called loop-author.php and that will be used instead.
	 */
	?>
	
	<?php do_action('wp_idea_stream_before_idea_author_loop');?>
	
	 	<?php if ( ! have_posts() ) : ?>
			<div id="post-0" class="post error404 not-found">
				<h1 class="entry-title"><?php _e( 'No Ideas!', 'wp-idea-stream' ); ?></h1>
				<div class="entry-content">
					<p><?php _e( 'Apologies, this user has not submitted any idea so far', 'wp-idea-stream' ); ?></p>
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
	
	<?php do_action('wp_idea_stream_after_idea_author_loop');?>
	
	<div id="nav-below" class="navigation">
		<?php wp_idea_stream_paginate_link(); ?>
	</div><!-- #nav-below -->
	
			</div><!-- #content -->
		</div><!-- #container -->

<?php get_sidebar(); ?>
<?php get_footer(); ?>
