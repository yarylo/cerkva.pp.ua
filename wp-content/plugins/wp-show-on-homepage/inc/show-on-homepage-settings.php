<div id="HYwpbody"> 
	<img class="logo" src="<?php echo $this->plugin_url;?>images/logo.jpg" alt="logo">
	<h1>Show On Homepage</h1>
	<div class="descr">
		<b><?php _e("Description",$this->plugin_domain);?></b> : <?php _e("Choose what to show on your homepage. You have possibility to show categories",$this->plugin_domain);?>
	</div>
	
	<?php if(get_option($this->plugin_options_disable)){?>
		<div class="error" id="HYdisable">
			<?php _e("The plugin are disabled. To activate it, go to the tab \"Extra\".",$this->plugin_domain);?>
		</div>
	<?php } ?>
	
	<!-- Start tabs -->
	<ul class="wp-tab-bar">
		<li class="wp-tab-active"><a href="#tabs-1"><?php _e("Categories",$this->plugin_domain);?></a></li> 
		<li><a href="#tabs-4"><?php _e("Extra",$this->plugin_domain);?></a></li> 
	</ul>
	
	<div class="wp-tab-panel" id="tabs-1"> 
		<h3><?php _e("Categories",$this->plugin_domain);?></h3>
		
		<p>
			<span class="descr-option"><?php _e("Show categories description",$this->plugin_domain);?></span>
			<?php $this->HYomepage_settings_form('cat');?>
		</p>
	</div>
	<div class="wp-tab-panel" id="tabs-4" style="display: none;">
		<h3><?php _e("Extra",$this->plugin_domain);?></h3> 
		
		<p>
			<span class="descr-option"><?php _e("Disable options description",$this->plugin_domain);?></span>
			<?php $this->HYomepage_settings_form('disable');?>
		</p>
		
		<p>
			<span class="descr-option"><?php _e("Reset options description",$this->plugin_domain);?></span>
			<?php $action_url = "options-general.php?page={$this->plugin_page_option}&_wpnonce=".wp_create_nonce('reset');?>
			<form action="<?php echo admin_url($action_url)?>" method="POST">
				<input type="submit" name="HYreset_options" value="<?php _e("Reset",$this->plugin_domain);?>" class="button-primary" />
			</form>
		</p>
		
	</div>
	<!-- End tabs -->
</div>
 