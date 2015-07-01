<?php

/**
 * Provide a dashboard view for the plugin
 *
 * This file is used to markup the public-facing aspects of the plugin.
 *
 * @link       http://example.com
 * @since      1.1.1
 *
 * @package    Custom_Widget_Area
 * @subpackage Custom_Widget_Area/admin/partials
 */
/**
* 
*/
class Menu_view
{
	
	public function __construct()
	{
		# code...
	}
	public function menu_settings_page(){
		add_action( 'add_meta_boxes', self::displayView());
	}
	public function displayView(){

		
		global $purl;
		?>
		
		<div class="wrap">
 
            <div id="icon-themes" class="icon32"><br /></div>
 
            <h2><?php _e( 'Menu Locations', 'wp-custom-widget-area' ); ?></h2>

			<div class="welcome-panel custom-wp">
				<div class="col col-8">
					<?php 
						self::menuForm();
					?>
				</div>
				<div class="col col-4">
					<div class="how-to show-less">
						<h3>How to use?</h3>
						<p>
							<ol class="list">
								<li>Create a new Menu Location.</li>
								<li>Click on the "get code" link from table below.</li>
								<li>Copy the code and Paste it in a wordpress theme where you want to display it.</li>
							</ol>
						</p>
						<br/>
						<h4 style="margin-top: 0;">How to Use it in page or post content?</h4>
						<p>
							<ol class="list">
								<li>Click on the "get shortcode" link form table below.</li>
								<li>Copy the shortcode and Paste it in a post or page editor where you want to display it.</li>
							</ol>
						</p>	
						<br/>
						<h4 style="margin-top: 0;">How to customize menu style?</h4>
						<p>
							<ol class="list">
								<li>Pass the extra arguments while calling function<br>
									i.e.<br>
									<code>
										wp_nav_menu( array( 'theme_location'	=> 'footer-location', 'menu_class'      => 'Cwa-menu', [arguments] => ['values']...	) );
									</code> 
									<br>
									<a href="https://codex.wordpress.org/Function_Reference/wp_nav_menu" target="_blank" > Cick here </a> to know more about available Parameters.
									<br>
									<pre style="word-wrap: break-word;">[Note: for shortcode pass arguments like <code>[menu theme_location='footer-location' 'menu_class'='Cwa-menu' [arguments]=[values]...]</code></pre>
								</li>
								<li>Make sure you have passed custom menu class options i.e. 'menu_class' like in above code.</li>
								<li>Add custom css targeting your menu_class or container_class etc. i.e. <br>
								<code>
									.Cwa-menu a{
										color: red;
									} 
								</code><br>
								at the bottom of your style.css.
								</li>
							</ol>
						</p>	
						<a href="#" style="position: absolute; left: 48%; bottom: 0; z-index: 5;" class="more">Read more</a>
					</div>
				</div>
				
			
			</div>
		</div>
		<div class="cwa-error" style="display:none;">
			
		</div>
		<div id="cwa-table-wrap">
		<?php
			self::menuTable();
		?>
		</div>
		<?php 
	}
	public function menuForm(){
		?>
		<form class="cwa-form" method="post" action="" id="cwa-menu-form">
			<input type="hidden" name="id">
			<div class="basic">
				<div class="cwa-form-row">
					<label  class="cwa-form-label">Name </label><input type="text" name="cwa_name" placeholder="Menu location name" required>	<span class="cwa-form-message"></span>
				</div>
				<div class="cwa-form-row">
					<label class="cwa-form-label">Theme location (Id) </label><input type="text" name="cwa_id" placeholder="Menu location id" required><span class="cwa-form-message"></span>
				</div>
				
					
			</div>
			<div class="cwa-form-row">
				<label class="cwa-form-label"> </label><input type="submit" name="create" value="Create" class="cwa-btn cwa-btn-primary"> <input type="reset" value="Cancel" name="cancel" class="cwa-btn cwa-btn-danger">	
			</div>
		</form>

		<?php
	}
	public function menuTable(){
		$data = self::getMenuData();
		//var_dump($data);
		?>
		<table class="cwa-table responstable">
			<thead>
				<tr>
					<th>Sn</th>
					<th width='30%' >Name</th>
					<th width='30%'>Theme location (Id) </th>
					
					<th></th>
					<th></th>
				</tr>
			</thead>
			<tbody>
				<?php 
				$count = 1;
				foreach ($data as $table) {
					# code...
					?>
					<tr>
						<td><?php echo $count ?></td>
						<td><?php echo $table->cwa_name; ?></td>
						<td><?php echo $table->cwa_id; ?></td>
					
						<td><a href="#get_shortcode" data-id="<?php echo $table->cwa_id; ?>" class="cwa-detail-link tooltip" title="[menu theme_location='<?php echo $table->cwa_id; ?>']">Get shortcode</a> </td>
						<td><a href="#get_code" data-id="<?php echo $table->cwa_id; ?>" class="cwa-detail-link tooltip" title="wp_nav_menu( array( 'theme_location'	=> '<?php echo $table->cwa_id; ?>'	) );">Get code</a> / <a href="#delete" data-id="<?php echo $table->cwa_id; ?>" class="cwa-delete-link">Delete</a></td>
					</tr>
					<?php
					$count++;
				}
				?>
			</tbody>
		</table>
		<?php
		if(isset($_POST['action']))
			die();
	}

	public function getMenuData(){
		global $wpdb, $table_name;

		$sql = "SELECT * FROM $table_name WHERE cwa_type='menu'";

		require_once( ABSPATH . 'wp-admin/includes/upgrade.php' );
		$row = $wpdb->get_results( $sql, 'OBJECT');
		return $row;
	}

}
?>
