<?php
/*
Plugin Name: TAC Featured Products Widget

Plugin URI: http://www.disabilityvoice.com

Description: It displays up to 9 featured products from a featured products category in a widget.  This works with WP e-Commerce Plugin already installed.  You must create a category called Featured.  The number of featured products shown in the widget depends on how many featured delete that products you have in the Featured category.

Revision Date: January 31, 2013

Version: 1.0.0

Author:  Timothy Carey
Author URI: http://www.disabilityvoice.com
License: GPL3

Requires at least: WP 3.5
Tested up to: WP 3.5
*/
?>
<?php
/*
This program is free software: you can redistribute it and/or modify
it under the terms of the GNU General Public License as published by
the Free Software Foundation, either version 3 of the License, or
(at your option) any later version.

This program is distributed in the hope that it will be useful,
but WITHOUT ANY WARRANTY; without even the implied warranty of
MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
GNU General Public License for more details.

You should have received a copy of the GNU General Public License
along with this program.  If not, see <http://www.gnu.org/licenses/>.
*/
?>
<?php

?>
<?php

// To create a widget you have to extend the WP_Widget class
class TAC_Featured_Products_Widget extends WP_Widget
{

	// Constructor
	function TAC_Featured_Products_Widget()
	{
		$widget_options = array(
			'classname'	=> 'TAC_Featured_Products_Widget',
			'description' => __('Shows Featured Products from the category called Featured') );
			
		// Call the parent class WP_Widget	
		parent::WP_Widget('TAC_Featured_Products_Widget', 'TAC Featured Products Widget', $widget_options);
	
	}

	function widget($args, $instance)
	{
		// Splits arguments out and makes them local variables. EXTR_SKIP 
		// protects any already created local variables
		extract( $args, EXTR_SKIP );
		
		// Here if a title is set use it. If not use the default title
		$title = ( $instance['title'] ) ? $instance['title'] : 'Follow ';
		
		$showimage = ( $instance['showimage'] ) ? $instance['showimage'] : '';
		
		$showmorebutton = ( $instance['showmorebutton'] ) ? $instance['showmorebutton'] : '';
		
		
		// $before_widget, $after_widget, etc are used for theme compatibility
		
		?>
		
<?php echo $before_widget; ?>
<?php echo $before_title . $title . $after_title; ?>
		
        <div class="demo">

<div class="scroll-pane ui-widget ui-widget-header ui-corner-all">
	<div class="scroll-content">
	
<?php $my_query = new WP_Query( array( 'post_type' => 'wpsc-product', 'posts_per_page' => 9, 'wpsc_product_category'=>'Featured') );
$numindex = 0;
	while( $my_query->have_posts() ) : $my_query->the_post();
	$numindex = $numindex + 1;
	
	echo $numindex + '.';
	
	?>
		<div class="scroll-content-item ui-widget-header">
        
<?php if ($showimage == 'Yes') {
	
	$tactheImage = wpsc_the_product_thumbnail(100,100,'','single');
	if ($tactheImage != '') {

	?>
			<div class="prodImage">
				<img src="<?php echo $tactheImage?>" class="theProduct" alt="<?php the_title();?>" />
			</div>

<?php 
	} 
} ?>			
			<div class="prodName">
				<strong><a href="<?php echo get_permalink( $product->ID ); ?>" title="<?php echo get_the_title( $product->ID ); ?>"><?php $ntt_the_title = get_the_title($product->ID ); echo substr($ntt_the_title, 0, 43);?></a></strong>
			</div>
<?php if ($showmorebutton == 'Yes') {?>
			<div class="prodMoreInfoBut">
				<input type="button" value="More Info" class="nttSubmitBut"
onClick="window.location.href='<?php echo get_permalink( $product->ID ); ?>';" />
			</div>
<?php } ?>
			<div class="prodAddToCartBut">
<?php echo wpsc_add_to_cart_button($id); ?>
			</div>
		</div> <!-- END OF scroll-content-item -->
        <br />
<?php endwhile; ?>

		</div> <!-- End of scroll-content -->
		
		<div class="scroll-bar-wrap ui-widget-content ui-corner-bottom">
		<div class="scroll-bar"></div>
		</div> <!-- End of scroll-bar-wrap -->
	
</div> <!-- End of scroll-pane -->

</div><!-- End of demo -->
        
<?php echo $after_widget; ?>
		
<?php	
	}
	
	// Pass the new widget values contained in $new_instance and update saves 
	// everything for you
	function update($new_instance, $old_instance)
	{
	
		$instance = $old_instance;
		
		$instance['title'] = strip_tags( $new_instance['title'] );
		
		$instance['showimage'] = strip_tags( $new_instance['showimage'] );
		$instance['showmorebutton'] = strip_tags( $new_instance['showmorebutton'] );
		
		return $instance;	
	}
		// Displays options in the widget admin section of site
	function form($instance)
	{
		// Set all of the default values for the widget
		$defaults = array( 'title' => 'Featured Products', 'showimage' => 'Yes', 'showmorebutton' => 'Yes' );
		
		// Grab any widget values that have been saved and merge them into an
		// array with wp_parse_args
		$instance = wp_parse_args( (array) $instance, $defaults );
		$title = $instance['title'];
		$showimage = $instance['showimage'];
		$showmorebutton = $instance['showmorebutton'];
		?>
		
		<!-- Create the form elements needed to set the widget values
		esc_attr() scrubs potentially harmful text -->
		<p>Title: <input class="nttsocialLinks" name="<?php echo $this->get_field_name( 'title' ); ?>" type="text" value="<?php echo esc_attr( $title ); ?>" /></p>
		
        <p>Show Image: 
    <input type="checkbox" name="<?php echo $this->get_field_name( 'showimage' ); ?>" value="Yes" <?php if (esc_attr( $showimage ) == 'Yes' ) echo 'checked=checked'; ?> /></p>
		 
         <p>Show More Button : 
    <input type="checkbox" name="<?php echo $this->get_field_name( 'showmorebutton' ); ?>" value="Yes" <?php if (esc_attr( $showmorebutton ) == 'Yes' ) echo 'checked=checked'; ?> /></p>
		
<?php

	}
}

function TAC_Featured_Products_Widget_init()
{
	// Registers a new widget to be used in your Wordpress theme
	register_widget('TAC_Featured_Products_Widget');
}

// Attaches a rule that tells wordpress to call my function when widgets are 
// initialized
add_action('widgets_init', 'TAC_Featured_Products_Widget_init');

?>