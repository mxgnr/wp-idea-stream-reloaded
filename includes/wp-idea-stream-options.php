<?php
//Idea Stream Options
if($_POST['_ideastream_save_options']){

	//allow guests to post or not
	if(get_option('_ideastream_allow_guests')!=$_POST['_ideastream_allow_guests']){
		update_option('_ideastream_allow_guests', $_POST['_ideastream_allow_guests']);
	}

	//editor img and link button
	$editor_options = array('image'=>intval($_POST['_idea_editor_image']),'link'=>intval($_POST['_idea_editor_link']));
	update_option('_ideastream_editor_config', $editor_options);
	
	//editor img width
	if(strlen($_POST['_idea_editor_image_size'])>1){
		update_option('_ideastream_image_width', intval($_POST['_idea_editor_image_size']));
	}
	
	//idea status
	if( $_POST['_ideastream_submit_status'] && get_option('_ideastream_submit_status')!=$_POST['_ideastream_submit_status']){
		update_option('_ideastream_submit_status', $_POST['_ideastream_submit_status']);
	}
	
	//awaiting moderation message
	if( strlen($_POST['_ideastream_moderation_message'])>1){
		update_option('_ideastream_moderation_message', wp_kses(stripslashes($_POST['_ideastream_moderation_message']),array()));
	}
	
	//not logged in message
	if( strlen($_POST['_ideastream_login_message'])>1){
		update_option('_ideastream_login_message', wp_kses(stripslashes($_POST['_ideastream_login_message']),array()));
	}
	
	//builtin ratings
	update_option('_ideastream_builtin_rating', $_POST['_ideastream_builtin_rating']);
	if(strlen($_POST['_ideastream_hint_list'])>1){
		update_option('_ideastream_hint_list', explode(',', str_replace(', ',',', $_POST['_ideastream_hint_list'])));
	}
	
	//sharing options
	update_option('_ideastream_sharing_options', $_POST['_ideastream_sharing_options']);
	if(strlen($_POST['_ideastream_twitter_account'])>2){
		update_option('_ideastream_twitter_account', str_replace('@','',$_POST['_ideastream_twitter_account']));
	}
	else delete_option('_ideastream_twitter_account');
	
	//featuring ideas from comment
	update_option('_ideastream_feature_from_comments', $_POST['_ideastream_feature_from_comments']);
	if(strlen($_POST['user_ids_help'])>=1){
		$explode_user_ids = explode(',', str_replace(' ', '', $_POST['user_ids_help']));
		if(count($explode_user_ids)>0) update_option('_ideastream_allowed_featuring_members', $explode_user_ids);
	}
	else delete_option('_ideastream_allowed_featuring_members');
	
	//sending an update message !
	?>
	<div id="message" class="updated fade">
		<p><?php _e( '<strong>IdeaStream Options saved</strong>', 'wp-idea-stream' );?></p>
	</div>
	<?php
}
$ideastream_allow_guests = get_option('_ideastream_allow_guests');
$ideastream_editor_config = get_option('_ideastream_editor_config');
$ideastream_builtin_rating = get_option('_ideastream_builtin_rating');
$ideastream_sharing_options = get_option('_ideastream_sharing_options');
$ideastream_feature_from_comments = get_option('_ideastream_feature_from_comments');
$ideastream_allowed_featuring_members = get_option('_ideastream_allowed_featuring_members');
if(count($ideastream_allowed_featuring_members)>1) $implode_user_ids = implode(',', $ideastream_allowed_featuring_members);
else $implode_user_ids = $ideastream_allowed_featuring_members[0];
if(count(get_option('_ideastream_hint_list'))>1) $implode_stars_caption = implode(',', get_option('_ideastream_hint_list'));
else{
	$onestar = get_option('_ideastream_hint_list');
	$implode_stars_caption = $onestar[0];
}

function is_option_checked($option, $value){
	if($option === $value) return true;
	else return false;
}
?>
<div class="wrap ideastream-admin"><div id="icon-post-ideas" class="icon32 icon32-posts-ideas"><br></div>
	<h2><?php _e('IdeaStream Options','wp-idea-stream');?></h2>
		<form action="" method="post">
			<div id="ideastream_submission_config" class="idea-options">
				<fieldset>
					<legend><strong><?php _e('Idea Submission Options','wp-idea-stream');?></strong></legend>
					<table cellspacing="15">
						<tr>
							<td><label for="_ideastream_allow_guests"><?php _e('Allow guests to submit ideas and vote', 'wp-idea-stream');?></label></td>
							<td><select name="_ideastream_allow_guests">
								<option value="1" <?php if(get_option('_ideastream_allow_guests')=='1') echo 'selected';?>><?php _e('Yes');?></option>
								<option value="0" <?php if(get_option('_ideastream_allow_guests')=='0') echo 'selected';?>><?php _e('No');?></option>
							</select></td>
						</tr>
						<tr>
							<td><label for="_idea_editor_image"><?php _e('Image Button (Wysiwyg Editor)','wp-idea-stream');?></label></td>
							<td style="width:200px"><input type="radio" value="1" name="_idea_editor_image" <?php if(!$ideastream_editor_config || is_option_checked($ideastream_editor_config['image'], 1)) echo "checked";?>>
								<?php _e('Activate');?>&nbsp;
								<input type="radio" value="0" name="_idea_editor_image" <?php if(is_option_checked($ideastream_editor_config['image'], 0)) echo "checked";?>>
								<?php _e('Deactivate');?>
						</tr>
						<tr>
							<td><label for="_idea_editor_link"><?php _e('Link Button (Wysiwyg Editor)','wp-idea-stream');?></label></td>
							<td><input type="radio" value="1" name="_idea_editor_link" <?php if(!$ideastream_editor_config || is_option_checked($ideastream_editor_config['link'], 1)) echo "checked";?>>
								<?php _e('Activate');?>&nbsp;
								<input type="radio" value="0" name="_idea_editor_link" <?php if(is_option_checked($ideastream_editor_config['link'], 0)) echo "checked";?>>
								<?php _e('Deactivate');?>
							</td>
						</tr>
						<tr>
							<td><label for=""><?php _e('Status of new ideas','wp-idea-stream');?></label></td>
							<td><select name="_ideastream_submit_status">
								<option value="publish" <?php if(get_option('_ideastream_submit_status')!='' || get_option('_ideastream_submit_status')=='publish') echo 'selected';?>><?php _e('Published');?></option>
								<option value="pending" <?php if(get_option('_ideastream_submit_status')=='pending') echo 'selected';?>><?php _e('Pending');?></option>
								</select>
							</td>	
						</tr>
						<tr>
							<td><label for="_ideastream_moderation_message"><?php _e('Awaiting moderation message','wp-idea-stream');?></label></td>
							<td><textarea rows="2" cols="40" name="_ideastream_moderation_message"><?php echo get_option(_ideastream_moderation_message);?></textarea></td>
						</tr>
						<tr>
							<td><label for="_idea_editor_image_size"><?php _e('Image max width in pixels <small>(default is 300)</small>','wp-idea-stream');?></label></td>
							<td><input type="text" value="<?php echo get_option('_ideastream_image_width');?>" name="_idea_editor_image_size"></td>
						</tr>
						<tr>
							<td><label for="_ideastream_login_message"><?php _e('Message to display if user is not logged in','wp-idea-stream');?></label></td>
							<td><textarea name="_ideastream_login_message" cols="40" rows="2"><?php echo get_option('_ideastream_login_message');?></textarea></td>
						</tr>
					</table>
				</fieldset>
			</div>
			<div id="ideastream_other_config" class="idea-options">
				<fieldset>
					<legend><strong><?php _e('IdeaStream Ratings, Sharing and Featuring Options', 'wp-idea-stream');?></strong></legend>
					<table cellspacing="15">
						<tr>
							<td style="width:200px"><label><?php _e('Built in rating system', 'wp-idea-stream');?></td>
							<td style="width:200px">
								<input type="radio" value="1" name="_ideastream_builtin_rating" <?php if(!$ideastream_builtin_rating || is_option_checked($ideastream_builtin_rating, "1")) echo "checked";?>>
								<?php _e('Activate');?>&nbsp;
								<input type="radio" value="0" name="_ideastream_builtin_rating" <?php if(is_option_checked($ideastream_builtin_rating, "0")) echo "checked";?>>
								<?php _e('Deactivate');?>
							</td>
						</tr>
						<tr>
							<td><label><?php _e('Comma separated list of captions for the stars','wp-idea-stream');?></td>
							<td><input type="text" value="<?php echo $implode_stars_caption;?>" name="_ideastream_hint_list" style="width:350px;"></td>
						</tr>
						<tr><td colspan="4" class="idea-sep">&nbsp;</td></tr>
						<tr>
							<td><label><?php _e('Sharing options', 'wp-idea-stream');?></label></td>
							<td><input type="radio" value="1" name="_ideastream_sharing_options" <?php if(!$ideastream_sharing_options || is_option_checked($ideastream_sharing_options, "1")) echo "checked";?>>
								<?php _e('Activate');?>&nbsp;
								<input type="radio" value="0" name="_ideastream_sharing_options" <?php if(is_option_checked($ideastream_sharing_options, "0")) echo "checked";?>>
								<?php _e('Deactivate');?>
							</td>
						</tr>
						<tr>
							<td><label><?php _e('Twitter account <small>(leave blank to disable)</small>','wp-idea-stream')?></label></td>
							<td><input type="text" value="<?php echo get_option('_ideastream_twitter_account');?>" name="_ideastream_twitter_account"></td>
						</tr>
						<tr>
							<td colspan="4" class="idea-sep">&nbsp;</td>
						</tr>
						<tr>
							<td><label><?php _e('Featuring ideas in comment area','wp-idea-stream');?></label></td>
							<td><input type="radio" value="1" name="_ideastream_feature_from_comments" <?php if(is_option_checked($ideastream_feature_from_comments, "1")) echo "checked";?>>
									<?php _e('Activate');?>&nbsp;
									<input type="radio" value="0" name="_ideastream_feature_from_comments" <?php if(!$ideastream_feature_from_comments || is_option_checked($ideastream_feature_from_comments, "0")) echo "checked";?>>
									<?php _e('Deactivate');?>
							</td>
							<td colsan="2">(<?php _e('<small>Admin and Editor can also feature ideas by adding a postmeta named <b>idea_stream_featured</b> with a value of <b>1</b>.</small>','wp-idea-stream');?>)</td>
						</tr>
						<tr>
							<td colspan="2"><label><?php _e('Add a comma separated list of trusted user ids to help you','wp-idea-stream');?></label></td>
							<td colspan="2"><input type="text" value="<?php echo $implode_user_ids;?>" name="user_ids_help" style="width:350px;">
							</td>
						</tr>
					</table>
				</fieldset>
			</div>
			<div id="ideastream_validate_config" class="idea-options">
				<input type="submit" name="_ideastream_save_options" value="<?php _e('Save IdeaStream Options', 'wp-idea-stream');?>" class="button-primary">
			</div>
			</form>
</div>
