<?php

if ( class_exists( 'Share_Twitter' ) && ! class_exists( 'Share_MSTeams' ) ) :

// Build button
class Share_MSTeams extends Share_Twitter {
	var $shortname = 'msteams';
	public function __construct( $id, array $settings ) {
		parent::__construct( $id, $settings );
		$this->smart = 'official' == $this->button_style;
		$this->icon = 'icon' == $this->button_style;
		$this->button_style = 'icon-text';
	}

	public function get_name() {
		return __( 'Microsoft Teams', 'mstjp' );
	}

	// Load resources (js or css) in the head
	public function display_header() {
		if ( $this->smart ) {
?>
<script type="text/javascript" src="//teams.microsoft.com/share/launcher.js"></script>
<style type="text/css">
	.share-msteams tr td {
		padding: 0 !important;
	}
</style>
<?php
		} else {
?>
<style type="text/css">
	.sd-social-icon-text li.share-msteams a.sd-button > span {
		background: url('<?php echo plugins_url( 'teams-icon.png', __FILE__ ); ?>') no-repeat;
		padding-left: 20px;
	}

	.sd-social-icon .sd-content ul li[class*='share-'].share-msteams a.sd-button {
		background: #2B587A url('<?php echo plugins_url( 'teams-icon-only.png', __FILE__ ); ?>') no-repeat;
		color: #fff !important;
		padding: 16px;
		top: 12px;
	}
</style>
<?php
		}
	}

	public function get_display( $post ) {

		if ( $this->smart ) {
			return '<a href="https://teams.microsoft.com/share/" class="teams-share-button" data-icon-px-size="16" data-href="' . get_permalink( $post->ID ) . '" >Microsoft Teams</a>';
		} else if ( $this->icon ) {
			return '<a target="_blank" rel="nofollow" class="share-msteams sd-button share-icon" href="https://teams.microsoft.com/share?href='. get_permalink( $post->ID ) .'"><span></span></a>';
		} else {
			return '<a target="_blank" rel="nofollow" class="share-msteams sd-button share-icon" href="https://teams.microsoft.com/share?href='. get_permalink( $post->ID ) .'"><span>Microsoft Teams</span></a>';
		}
	}

}

endif; // class_exists
