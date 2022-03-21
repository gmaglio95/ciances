.fl-node-<?php echo $id; ?> .njba-image-panels-wrap .njba-panel-item {
	height: <?php echo $settings->panel_height; ?>px;
}
.fl-node-<?php echo $id; ?> .njba-image-panels-wrap .njba-panel-item .njba-panel-title {
	height: <?php echo $settings->title_height; ?>%;
	<?php if ( $settings->show_title == 'no' ) { ?> display: none; <?php } ?>
}
.fl-node-<?php echo $id; ?> .njba-image-panels-wrap .njba-panel-item:hover .njba-panel-title {
	height: 100%;
}
.fl-node-<?php echo $id; ?> .njba-image-panels-wrap .njba-panel-item .njba-panel-title h3 {
	font-size: <?php echo $settings->title_font_size['desktop']; ?>px;
	<?php if( $settings->title_font['family']	!= 'Default' ) { ?><?php FLBuilderFonts::font_css( $settings->title_font ); ?><?php } ?>
}
<?php
$number_panels = count($settings->image_panels);
for( $i = 0; $i < $number_panels; $i++ ) {
	$panel = $settings->image_panels[$i];
	if ( !is_object($panel) ) {
		continue;
	}
?>
		.fl-node-<?php echo $id; ?> .njba-image-panels-wrap .njba-panel-link-<?php echo $i; ?> {
			<?php if( $panel->link_type == 'panel' ) { ?> width: <?php echo 100/$number_panels; ?>%; <?php } ?>
		}
		.fl-node-<?php echo $id; ?> .njba-image-panels-wrap .njba-panel-item-<?php echo $i; ?> {
			<?php if( $panel->link_type == 'none' ) { ?> width: <?php echo 100/$number_panels; ?>%;
			<?php } else { ?> width: 100%;  <?php } ?>
		}
		.fl-node-<?php echo $id; ?> .njba-image-panels-wrap .njba-panel-item-<?php echo $i; ?> {
			background-image: url(<?php if(isset($panel->photo_src) ){ echo $panel->photo_src; } ?>);
			<?php if ( $settings->image_panels[$i]->position == 'custom' ) { ?> background-position: <?php echo $settings->image_panels[$i]->custom_position; ?>%; <?php } ?>
		}
		.fl-node-<?php echo $id; ?> .njba-image-panels-wrap .njba-panel-item-<?php echo $i; ?> .njba-panel-title{
			background: <?php echo njba_hex2rgba( '#'.$panel->title_background_color, $panel->title_opacity ) ?>;
		}
		.fl-node-<?php echo $id; ?> .njba-image-panels-wrap .njba-panel-item-<?php echo $i; ?> .njba-panel-title h3 {
			color: #<?php echo $panel->title_color; ?>;
		}
<?php } ?>
@media only screen and ( max-width: 768px ) {
	
	.fl-node-<?php echo $id; ?> .njba-image-panels-wrap .njba-panel-item .njba-panel-title h3 {
		font-size: <?php echo $settings->title_font_size['medium']; ?>px;
	}
	
	<?php for( $i = 0; $i < $number_panels; $i++ ) {
		$panel = $settings->image_panels[$i];
	?>
			.fl-node-<?php echo $id; ?> .njba-image-panels-wrap .njba-panel-link-<?php echo $i; ?>, .fl-node-<?php echo $id; ?> .njba-image-panels-wrap .njba-panel-item-<?php echo $i; ?> {
				width: 100%;
			}
	<?php } ?>
}
@media only screen and ( max-width: 480px ) {
	
	.fl-node-<?php echo $id; ?> .njba-image-panels-wrap .njba-panel-item .njba-panel-title h3 {
		font-size: <?php echo $settings->title_font_size['small']; ?>px;
	}
}
