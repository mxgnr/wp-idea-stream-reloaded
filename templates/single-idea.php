<?php
/**
 * The Template for displaying all single idea posts.
 *
 * @package WordPress
 * @subpackage Twenty_Ten
 * @since Twenty Ten 1.0
 */

get_header(); ?>
	<div id="container">
		<div id="content" role="main">
			<?php if ( have_posts() ) while ( have_posts() ) : the_post(); ?>

							<div id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
								<h1 class="entry-title"><?php the_title(); ?></h1>
								
								
								<div style="float: right;"><?php get_vote_it_up_button(); ?></div>

								<div class="entry-meta">
									<?php wp_idea_stream_posted_on(); ?>
									<?php wp_idea_stream_ratings_single();?>
								</div><!-- .entry-meta -->

								<div class="entry-content">
									<?php the_content(); ?>
								</div><!-- .entry-content -->

			<?php if ( get_the_idea_author_meta( 'description' ) ) : // If a user has filled out their description, show a bio on their entries  ?>
								<div id="entry-author-info">
									<div id="author-avatar">
										<?php echo get_avatar( get_the_idea_author_meta( 'user_email' ), 60 ); ?>
									</div><!-- #author-avatar -->
									<div id="author-description">
										<h2><?php printf( esc_attr__( 'About %s', 'wp-idea-stream' ), get_idea_author() ); ?></h2>
										<?php the_idea_author_meta( 'description' ); ?>
										<div id="author-link">
											<a href="<?php echo get_author_idea_url( get_the_idea_author_meta( 'ID' ) ); ?>">
												<?php printf( __( 'View all ideas by %s <span class="meta-nav">&rarr;</span>', 'wp-idea-stream' ), get_idea_author() ); ?>
											</a>
										</div><!-- #author-link	-->
									</div><!-- #author-description -->
								</div><!-- #entry-author-info -->
			<?php endif; ?>

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
									<?php edit_post_link( __( 'Edit', 'wp-idea-stream' ), '<span class="edit-link">', '</span>' ); ?>
								</div><!-- .entry-utility -->
								
								<?php wp_idea_stream_sharing_services();?>
								
							</div><!-- #post-## -->


							<?php comments_template( '', true ); ?>

			<?php endwhile; // end of the loop. ?>
			
		</div><!-- #content -->
	</div><!-- #container -->

<?php get_sidebar(); ?>
<?php get_footer(); ?>