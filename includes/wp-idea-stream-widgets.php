<?php
/* Register widgets for idea stream */
function wp_idea_stream_register_widgets() {
	add_action('widgets_init', create_function('', 'return register_widget("WP_Idea_Stream_Navig");') );
	add_action('widgets_init', create_function('', 'return register_widget("WP_Idea_Stream_Tag_Cloud");') );
	add_action('widgets_init', create_function('', 'return register_widget("WP_Idea_Stream_Category");') );
	$builtin_rating_option = get_option('_ideastream_builtin_rating');
	if($builtin_rating_option!="no"){
		add_action('widgets_init', create_function('', 'return register_widget("WP_Idea_Stream_Best_Rated");') );
	}
}
add_action( 'plugins_loaded', 'wp_idea_stream_register_widgets' );

class WP_Idea_Stream_Navig extends WP_Widget {

	function WP_Idea_Stream_Navig() {
		$widget_ops = array( 'description' => __( "Displays the different menus available in WP IdeaStream Plugin","wp-idea-stream") );
		parent::WP_Widget( false, __('IdeaStream Menu','wp-idea-stream'), $widget_ops);
	}

	function widget( $args, $instance ) {
		
		global $current_user;
		
		extract( $args );
		
		if ( !empty($instance['title']) ) {
			$title = $instance['title'];
		} else {
			$title = __('IdeaStream Menu', 'wp-idea-stream');
		}

		echo $before_widget;
		
		if($instance['title']){
			echo $before_title .
				 $instance['title'].
			     $after_title;
		}
		else echo $before_title .
			 $widget_name.
		     $after_title; ?>
		
			<ul class="is_navig_widget">
				<li class="is_menu_all_ideas"><a href="<?php echo get_bloginfo('siteurl');?>/is/all-ideas/" title="<?php _e('All Ideas','wp-idea-stream');?>"><?php _e('All Ideas','wp-idea-stream');?></a></li>
				<li class="is_menu_new_idea"><a href="<?php echo get_bloginfo('siteurl');?>/is/new-idea/" title="<?php _e('New Idea','wp-idea-stream');?>"><?php _e('New Idea','wp-idea-stream');?></a></li>
				<?php if(is_user_logged_in()):?>
				<li class="is_menu_my_ideas"><a href="<?php echo get_author_idea_url($current_user->ID);?>" title="<?php _e('My Ideas','wp-idea-stream');?>"><?php _e('My Ideas','wp-idea-stream');?></a></li>
				<?php endif;?>
				<?php if($instance['idea_stream_show_featured']==1):?>
				<li class="is_menu_featured_ideas"><a href="<?php echo get_bloginfo('siteurl');?>/is/featured-ideas/" title="<?php _e('Featured Ideas','wp-idea-stream');?>"><?php _e('Featured Ideas','wp-idea-stream');?></a></li>
				<?php endif;?>
			</ul>

		<?php echo $after_widget; ?>
		<?php
		}

	function update( $new_instance, $old_instance ) {
		$instance = $old_instance;
		$instance['title'] = strip_tags( $new_instance['title'] );
		$instance['idea_stream_show_featured'] = strip_tags( $new_instance['idea_stream_show_featured'] );

		return $instance;
	}

	function form( $instance ) {
		$instance = wp_parse_args( (array) $instance, array( 'title' => __('IdeaStream Menu', 'wp-idea-stream'),'idea_stream_show_featured' => 0 ) );
		$title = strip_tags( $instance['title'] );
		$idea_stream_show_featured = strip_tags( $instance['idea_stream_show_featured'] );
		?>
		
		<p><label for="title"><?php _e('Title:','wp-idea-stream') ?></label><input class="widefat" id="<?php echo $this->get_field_id( 'title' ); ?>" name="<?php echo $this->get_field_name( 'title' ); ?>" type="text" value="<?php echo attribute_escape( $title ); ?>" style="width: 80%" /></p>
		<p><select id="<?php echo $this->get_field_id( 'idea_stream_show_featured' ); ?>" name="<?php echo $this->get_field_name( 'idea_stream_show_featured' ); ?>">
				<option value="0" <?php if($idea_stream_show_featured!=1) echo "selected";?>><?php _e('Hide Featured menu','wp-idea-stream');?></option>
				<option value="1" <?php if($idea_stream_show_featured==1) echo "selected";?>><?php _e('Show Featured menu','wp-idea-stream');?></option>
			</select>
		</p>
	<?php
	}
}

/**
 * Idea Stream Tag cloud widget class
 */
class WP_Idea_Stream_Tag_Cloud extends WP_Widget {

	function WP_Idea_Stream_Tag_Cloud() {
		$widget_ops = array( 'description' => __( "The most used Idea Stream tags in cloud format","wp-idea-stream") );
		$this->WP_Widget(false, __('IdeaStream Tag Cloud', 'wp-idea-stream'), $widget_ops);
	}

	function widget( $args, $instance ) {
		extract($args);
		$current_taxonomy = 'tag-ideas';
		if ( !empty($instance['title']) ) {
			$title = $instance['title'];
		} else {
			$title = __('IdeaStream Tag Cloud', 'wp-idea-stream');
		}
		if ( !empty($instance['tag_amount']) ) {
			$tagamount = $instance['tag_amount'];
		} else {
			$tagamount = 30;
		}

		echo $before_widget;
		if ( $title )
			echo $before_title . $title . $after_title;
		echo '<div class="is_tagcloud">';
		wp_tag_cloud( apply_filters('widget_tag_cloud_args', array('taxonomy' => $current_taxonomy, 'number' => $tagamount) ) );
		echo "</div>\n";
		echo $after_widget;
	}

	function update( $new_instance, $old_instance ) {
		$instance['title'] = strip_tags(stripslashes($new_instance['title']));
		$instance['tag_amount'] = stripslashes($new_instance['tag_amount']);
		return $instance;
	}

	function form( $instance ) {
		$current_taxonomy = 'tag-ideas';
?>
	<p><label for="<?php echo $this->get_field_id('title'); ?>"><?php _e('Title:','wp-idea-stream') ?></label>
	<input type="text" class="widefat" id="<?php echo $this->get_field_id('title'); ?>" name="<?php echo $this->get_field_name('title'); ?>" value="<?php if (isset ( $instance['title'])) {echo esc_attr( $instance['title'] );} ?>" /></p>
	<p><label for="<?php echo $this->get_field_id('tag_amount'); ?>"><?php _e('Amount of Tags:','wp-idea-stream') ?></label>
	<input type="text" class="widefat" id="<?php echo $this->get_field_id('tag_amount'); ?>" name="<?php echo $this->get_field_name('tag_amount'); ?>" value="<?php if (isset ( $instance['tag_amount'])) {echo esc_attr( $instance['tag_amount'] );} ?>" /></p><?php
	}
}


/**
 * Idea Stream Categories widget class
 */
class WP_Idea_Stream_Category extends WP_Widget {

	function WP_Idea_Stream_Category() {
		$widget_ops = array( 'description' => __( "A list or a dropdown of IdeaStream categories","wp-idea-stream" ) );
		$this->WP_Widget(false, __('IdeaStream Categories', 'wp-idea-stream'), $widget_ops);
	}

	function widget( $args, $instance ) {
		extract( $args );
		
		if ( !empty($instance['title']) ) {
			$title = $instance['title'];
		} else {
			$title = __('IdeaStream Categories', 'wp-idea-stream');
		}
		
		$d = $instance['dropdown'] ? '1' : '0';

		echo $before_widget;
		if ( $title )
			echo $before_title . $title . $after_title;

		$catis_args = array('taxonomy'=> 'category-ideas', 'name' => 'catideas', 'orderby' => 'name');

		if ( $d ) {
			$catis_args['show_option_none'] = __('Select IdeaStream Category', 'wp-idea-stream');
			wp_dropdown_categories(apply_filters('widget_categories_dropdown_args', $catis_args));
?>

<script type='text/javascript'>
/* <![CDATA[ */
	var dropdown = document.getElementById("catideas");
	function onCatChange() {
		if ( dropdown.options[dropdown.selectedIndex].value > 0 ) {
			location.href = "<?php echo home_url(); ?>/?cat-is="+dropdown.options[dropdown.selectedIndex].value;
		}
	}
	dropdown.onchange = onCatChange;
/* ]]> */
</script>

<?php
		} else {
?>
		<ul>
<?php
		$catis_args = array('taxonomy'=>'category-ideas', 'title_li' => '');
		wp_list_categories(apply_filters('widget_categories_args', $catis_args));
?>
		</ul>
<?php
		}

		echo $after_widget;
	}

	function update( $new_instance, $old_instance ) {
		$instance = $old_instance;
		$instance['title'] = strip_tags($new_instance['title']);
		$instance['dropdown'] = !empty($new_instance['dropdown']) ? 1 : 0;

		return $instance;
	}

	function form( $instance ) {
		//Defaults
		$instance = wp_parse_args( (array) $instance, array( 'title' => '') );
		$title = esc_attr( $instance['title'] );
		$dropdown = isset( $instance['dropdown'] ) ? (bool) $instance['dropdown'] : false;
?>
		<p><label for="<?php echo $this->get_field_id('title'); ?>"><?php _e( 'Title:', 'wp-idea-stream' ); ?></label>
		<input class="widefat" id="<?php echo $this->get_field_id('title'); ?>" name="<?php echo $this->get_field_name('title'); ?>" type="text" value="<?php echo $title; ?>" /></p>

		<p><input type="checkbox" class="checkbox" id="<?php echo $this->get_field_id('dropdown'); ?>" name="<?php echo $this->get_field_name('dropdown'); ?>"<?php checked( $dropdown ); ?> />
		<label for="<?php echo $this->get_field_id('dropdown'); ?>"><?php _e( 'Display as dropdown', 'wp-idea-stream' ); ?></label><br /></p>
<?php
	}

}

/**
 * Idea Stream Best Rated widget class
 */
class WP_Idea_Stream_Best_Rated extends WP_Widget {

	function WP_Idea_Stream_Best_Rated() {
		$widget_ops = array( 'description' => __( "The best rated Ideas by the members","wp-idea-stream") );
		$this->WP_Widget(false, __('IdeaStream Best Rated', 'wp-idea-stream'), $widget_ops);
	}

	function widget( $args, $instance ) {
		extract($args);
		if ( !empty($instance['title']) ) {
			$title = $instance['title'];
		} else {
			$title = __('IdeaStream Best Rated', 'wp-idea-stream');
		}
		if ( !empty($instance['idea_amount']) ) {
			$ideaamount = $instance['idea_amount'];
		} else {
			$ideaamount = 5;
		}

		echo $before_widget;
		if ( $title )
			echo $before_title . $title . $after_title;
			
		$best_rated_list = $this->_get_best_rated_ideas($instance);
		
		$args = array('post_type'=>'ideas', 'post__in' => $best_rated_list);
		
		$br_query = new WP_Query( $args );
		
		// The Loop
		while ( $br_query->have_posts() ) : $br_query->the_post();
			$array_ideas[get_the_ID()]='<li><a href="'.get_permalink().'" title="'.__('Average rating: ','wp-idea-stream').get_post_meta(get_the_ID(), '_ideastream_average_rate', true).'">'.get_the_title().'</a></li>';
		endwhile;
		
		echo '<ol class="is_bestrated">';
		foreach($best_rated_list as $postid){
			echo $array_ideas[$postid];
		}
		echo "</ol>\n";
		echo $after_widget;

		// Reset Post Data
		wp_reset_postdata();
	}

	function update( $new_instance, $old_instance ) {
		$instance['title'] = strip_tags(stripslashes($new_instance['title']));
		$instance['idea_amount'] = stripslashes($new_instance['idea_amount']);
		$instance['idea_month'] = !empty($new_instance['idea_month']) ? 1 : 0;
		return $instance;
	}

	function form( $instance ) {
		$idea_month = isset( $instance['idea_month'] ) ? (bool) $instance['idea_month'] : false;
?>
	<p><label for="<?php echo $this->get_field_id('title'); ?>"><?php _e('Title:','wp-idea-stream') ?></label>
	<input type="text" class="widefat" id="<?php echo $this->get_field_id('title'); ?>" name="<?php echo $this->get_field_name('title'); ?>" value="<?php if (isset ( $instance['title'])) {echo esc_attr( $instance['title'] );} ?>" /></p>
	<p><label for="<?php echo $this->get_field_id('idea_amount'); ?>"><?php _e('Amount of ideas:','wp-idea-stream') ?></label>
	<input type="text" class="widefat" id="<?php echo $this->get_field_id('idea_amount'); ?>" name="<?php echo $this->get_field_name('idea_amount'); ?>" value="<?php if (isset ( $instance['idea_amount'])) {echo esc_attr( $instance['idea_amount'] );} ?>" /></p>
	<p><input type="checkbox" class="checkbox" id="<?php echo $this->get_field_id('idea_month'); ?>" name="<?php echo $this->get_field_name('idea_month'); ?>"<?php checked( $idea_month ); ?> />
	<label for="<?php echo $this->get_field_id('idea_month'); ?>"><?php _e( 'Display only ideas of current month', 'wp-idea-stream' ); ?></label><br /></p><?php
	}
	
	function _get_best_rated_ideas($instance){
		global $wpdb;
		if($instance['idea_month']==1){
			$current_month = date("n");
			$request = $wpdb->get_col("SELECT ID FROM  {$wpdb->prefix}posts LEFT JOIN {$wpdb->prefix}postmeta ON({$wpdb->prefix}posts.ID = {$wpdb->prefix}postmeta.post_id) WHERE meta_key = '_ideastream_average_rate' AND month(post_date)=$current_month ORDER BY meta_value DESC LIMIT ".$instance['idea_amount']);
		}
		else{
			$request = $wpdb->get_col("SELECT post_id FROM {$wpdb->prefix}postmeta WHERE meta_key = '_ideastream_average_rate' ORDER BY meta_value DESC LIMIT ".$instance['idea_amount']);
		}
		return $request;
	}
}

?>