<?php
/**
 * The template for displaying search forms in warmboot_base
 *
 * @package WordPress
 * @subpackage mb
 */
?>
<?php
	$scriptpath = pathinfo($_SERVER['SCRIPT_NAME']);
	$site_directory = trailingslashit( $scriptpath['dirname'] );
?>
<form class="navbar-form" method="get" role="search" action="<?php echo $site_directory; ?>">
    <div class="input-group">
      <input name="s" type="search" class="form-control has-feedback" placeholder="<?php esc_attr_e( 'Search', 'warmboot_base' ); ?>">
      <span class="input-group-btn">
	        <button class="btn btn-default" type="submit"><i class="glyphicon glyphicon-search"></i></button>
      </span>
    </div><!-- /input-group -->
</form>