<?php
/*
Plugin Name: user custom fields
Plugin URI: #
Description: Adding a custom profile fields to USER
Author: Gnanasekaran
Version: 0.1
*/

/**
 * Add additional custom field
 */

add_action ( 'show_user_profile', 'my_show_extra_profile_fields' );
add_action ( 'edit_user_profile', 'my_show_extra_profile_fields' );

function my_show_extra_profile_fields ( $user )
{
?>
	<h3>Extra information</h3>
	<table class="form-table">		
		<tr>
			<th><label for="sname">Extra Name</label></th>
			<td>
				<input type="text" name="sname" id="sname" value="<?php echo esc_attr( get_the_author_meta( 'sname', $user->ID ) ); ?>" class="regular-text" /><br />
				<span class="description">Please enter your Extra Name.</span>
			</td>
		</tr>
		<tr>
			<th><label for="btype">Type of Business</label></th>
			<td>
				<input type="text" name="btype" id="btype" value="<?php echo esc_attr( get_the_author_meta( 'btype', $user->ID ) ); ?>" class="regular-text" /><br />
				<span class="description">Type of Business.</span>
			</td>
		</tr>
		<tr>
			<th><label for="phoneNumber2">Telephone Number 2</label></th>
			<td>
				<input type="tel" name="phoneNumber2" id="phoneNumber2" value="<?php echo esc_attr( get_the_author_meta( 'phoneNumber2', $user->ID ) ); ?>" class="regular-text" /><br />
				<span class="description">Please enter your Telephone Number 2.</span>
			</td>
		</tr>
	</table>
<?php
}

add_action ( 'personal_options_update', 'my_save_extra_profile_fields' );
add_action ( 'edit_user_profile_update', 'my_save_extra_profile_fields' );

/*  If no value already exists for the specified object ID and metadata key, the metadata will be added.*/
function my_save_extra_profile_fields( $user_id )
{
	/* Check current user can update permission or not */
	if ( !current_user_can( 'edit_user', $user_id ) )
		return false;
	
	/* Store name */
	update_usermeta( $user_id, 'sname', $_POST['sname'] );
	/* Type of Business */
	update_usermeta( $user_id, 'btype', $_POST['btype'] );
	/* Telephone Number 2 */
	update_usermeta( $user_id, 'phoneNumber2', $_POST['phoneNumber2'] );

}

/**
 * Add cutom field to registration form
 */

/* Get custom fields */
add_action('register_form','show_first_name_field');
/* Validation */
add_action('register_post','check_fields',10,3);
/* Update values */
add_action('user_register', 'register_extra_fields');

function show_first_name_field()
{
?>	
	<p>
	<label>Extra Name<br/>
	<input id="sname" type="text" required tabindex="30" size="25" value="<?php echo $_POST['sname']; ?>" name="sname" />
	</label>
	</p>
	<p>
	<label>Type of Business<br/>
	<input id="btype" type="text" required tabindex="30" size="25" value="<?php echo $_POST['btype']; ?>" name="btype" />
	</label>
	</p>
	<p>
	<label>Telephone Number 2 <br/>
	<input id="phoneNumber2" type="tel" tabindex="30" size="25" value="<?php echo $_POST['phoneNumber2']; ?>" name="phoneNumber2" />
	</label>
	</p>
<?php
}

function check_fields ( $login, $email, $errors )
{
	/* Store name validation*/
	global $sname;
	if ( $_POST['sname'] == '' )
	{
		$errors->add( 'empty_realname', "<strong>ERROR</strong>: Please Enter your Store name" );
	}
	else
	{
		$sname = $_POST['sname'];
	}
	/* Type of Business */
	global $btype;
	if ( $_POST['btype'] == '' )
	{
		$errors->add( 'empty_realname', "<strong>ERROR</strong>: Please Enter your Type of Business" );
	}
	else
	{
		$btype = $_POST['btype'];
	}
	/* Telephone Number 2 validation*/
	global $phoneNumber2;
	if ( $_POST['phoneNumber2'] == '' )
	{
		$errors->add( 'empty_realname', "<strong>ERROR</strong>: Please Enter your Telephone Number 2" );
	}
	else
	{
		$phoneNumber2 = $_POST['phoneNumber2'];
	}
	

}

function register_extra_fields ( $user_id, $password = "", $meta = array() )
{
	/* Store name update for current user using $user_id*/
	update_user_meta( $user_id, 'sname', $_POST['sname'] );
	/* Type of Business for current user using $user_id*/
	update_user_meta( $user_id, 'btype', $_POST['btype'] );
	/* Telephone Number 2 update for current user using $user_id*/
	update_user_meta( $user_id, 'phoneNumber2', $_POST['phoneNumber2'] );

}

?>