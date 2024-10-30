<?php
/***************************************************************
	@
	@	bSlider
	@	bassem.rabia@gmail.com
	@
/**************************************************************/
class bSlider{
	public function __construct(){
		$this->Signature = array(
			'pluginName' => 'bSlider',
			'pluginNiceName' => 'bSlider',
			'pluginSlug' => 'bslider',
			'pluginVersion' => '1.0',
			'postsNumber' => '5'
		); 
		// echo '<pre>';print_r($this->Signature);echo '</pre>';
		// delete_option($this->Signature['pluginSlug'], $pluginOptions);
		
		add_action('admin_menu', array(&$this, 'menu'));
		add_action('admin_enqueue_scripts', array(&$this, 'admin_enqueue'));
		add_action('wp_enqueue_scripts', array(&$this, 'enqueue'));
		add_shortcode('bSlider', array($this, 'run')); 
	}		
	public function enqueue(){
		wp_enqueue_style($this->Signature['pluginSlug'].'-front-style', plugins_url('css/'.$this->Signature['pluginSlug'].'-front.css', __FILE__));
		wp_enqueue_script($this->Signature['pluginSlug'].'-front-js', plugins_url('js/'.$this->Signature['pluginSlug'].'-front.js', __FILE__));
	}
	public function run(){
		$pluginOptions = get_option($this->Signature['pluginSlug']);								
		// echo '<pre>';print_r($pluginOptions);echo '</pre>';
		?>
		<div style="width: 700px;margin: 0 auto;border: 1px solid #E5E5E5;padding: 5px;">
			<div id="bslider">
				<?php
					$args = array(
						'posts_per_page'   => $pluginOptions['postsNumber'],
						'offset'           => 0,
						'category'         => '',
						'category_name'    => $pluginOptions['pluginSlug'],
						'orderby'          => 'date',
						'order'            => 'DESC',
						'include'          => '',
						'exclude'          => '',
						'meta_key'         => '',
						'meta_value'       => '',
						'post_type'        => 'post',
						'post_mime_type'   => '',
						'post_parent'      => '',
						'author'	   => '',
						'post_status'      => 'publish',
						'suppress_filters' => true 
					);
					$myposts = get_posts($args);
					foreach($myposts as $post):setup_postdata($post);
						// echo '<pre>';print_r($post);
						$output = preg_match_all('/<img.+src=[\'"]([^\'"]+)[\'"].*>/i', $post->post_content, $matches);
						?>
						<div class="slide">
							<div class="title"><?php echo $post->post_title;?></div>
							<div class="caption"><?php echo $post->post_excerpt;?></div>
							<a href="<?php echo post_permalink($post->ID);?>"><img src="<?php echo $matches[1][0];?>" /></a>
						</div>
					<?php endforeach; 
					wp_reset_postdata();
					?>
				<div class="steps"></div>
			</div>
		</div>
		<script>
		$(document).ready(function(){
			var settings = {
				delay: 5, // sec
				autoplay: true,
				ltr: 'ltr',
				debug: false 
			};
			bSlider.init(settings);
		}) 
		</script>
		<?php
	}
	public function admin_enqueue(){
		wp_enqueue_style($this->Signature['pluginSlug'].'-admin-style', plugins_url('css/'.$this->Signature['pluginSlug'].'-admin.css', __FILE__));
	}
	public function menu(){		
		add_options_page( 
			$this->Signature['pluginNiceName'], 
			$this->Signature['pluginNiceName'],
			'manage_options',
			strtolower($this->Signature['pluginSlug']).'-main-menu', 
			array(&$this, 'page')
		);
		$pluginOptions = get_option($this->Signature['pluginSlug']);
		if(count($pluginOptions)==1){
			add_option($this->Signature['pluginSlug'], $this->Signature, '', 'yes');
		}
	}
	public function page(){
		?>
		<div class="wrap columns-2 <?php echo $this->Signature['pluginSlug'];?>_wrap">
			<div id="<?php echo $this->Signature['pluginSlug'];?>" class="icon32"></div>  
			<h2><?php echo $this->Signature['pluginName'] .' '.$this->Signature['pluginVersion']; //echo get_locale();?></h2>			
			<div id="poststuff">
				<div id="post-body" class="metabox-holder columns-2">
					<div id="postbox-container-1" class="postbox-container <?php echo $this->Signature['pluginSlug'];?>_container">
						<div class="postbox">
							<h3><span><?php _e('User Guide', 'bslider'); ?></span></h3>
							<div class="inside"> 
								<ol>
									<li><?php _e('Install', 'bslider'); ?></li>
									<li><?php _e('Run', 'bslider'); ?></li>
									<li><?php _e('Enjoy', 'bslider'); ?></li>
									<li><?php _e('Ask for Support if you need', 'bslider'); ?> !</li>
								</ol>
							</div>
						</div>
					</div>									
								
					<div id="postbox-container-2" class="postbox-container">
						<div id="<?php echo $this->Signature['pluginSlug'];?>_container">
							<?php	
								$pluginOptions = get_option($this->Signature['pluginSlug']);								
								// echo '<pre>';print_r($pluginOptions);echo '</pre>';
								if(isset($_POST[$this->Signature['pluginSlug'].'-postsNumber'])){
									$pluginOptions['postsNumber'] = empty($_POST[$this->Signature['pluginSlug'].'-postsNumber'])?'5':$_POST[$this->Signature['pluginSlug'].'-postsNumber'];
									// echo '<pre>';print_r($pluginOptions);echo '</pre>';
									update_option($this->Signature['pluginSlug'], $pluginOptions);		
									?>
									<div class="accordion-header accordion-notification accordion-notification-success">
										<i class="fa dashicons dashicons-no-alt"></i>
										<span class="dashicons dashicons-megaphone"></span>
										<?php echo $this->Signature['pluginName'];?>
										<?php echo __('has been successfully updated', 'bslider');?>.
									</div> <?php
									$pluginOptions = get_option($this->Signature['pluginSlug']);								
									// echo '<pre>';print_r($pluginOptions);echo '</pre>';
								}
							?>
							
							<div class="<?php echo $this->Signature['pluginSlug'];?>_service_content">
								 <div class="accordion-header">
									<i class="fa dashicons dashicons-arrow-down"></i>
									<span class="dashicons dashicons-hidden"></span>
									<?php echo __('Settings', 'bslider');?>
								</div>		
								<div class="<?php echo $this->Signature['pluginSlug'];?>_service_content bslider_service_content_active">
									<form method="POST" action="" />
										<input placeholder="<?php echo __('Please insert nb-post', 'bslider');?>.." class="bslider_input" type="text" name="<?php echo $this->Signature['pluginSlug'];?>-postsNumber" value="<?php echo $pluginOptions['postsNumber'];?>" /> 
										<p class="description"><?php echo __('Show X posts', 'bslider');?></p>
										<input class="bslider_submit" type="submit" value="<?php echo __('Save', 'bslider');?>" />	
										<div class="clear"></div>
										</form>
								</div>
							</div>							
						</div>
					</div>
				</div>
			</div>
		</div>
		<?php 
	}
}	 
?>