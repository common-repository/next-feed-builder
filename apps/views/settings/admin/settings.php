<section class="<?php echo esc_attr('themeDev-next-feed');?>">
	
	<div class="themedev-content">
		<div class="nxadd-nav-menu">
			<div class="nav-settings">
				<?php require ( __DIR__ . '/tab-menu-settings.php' );?>
			</div>
		</div>
		<div class="nxadd-widget-content">
			<?php if($message_status == 'yes'){?>
			<div class="message-settings">
				<div class ="notice is-dismissible" style="margin: 1em 0px; visibility: visible; opacity: 1;">
					<p><?php echo esc_html__(''.$message_text.' ', 'next-addons');?></p>
					<button type="button" class="notice-dismiss"><span class="screen-reader-text"><?php echo esc_html__('Dismiss this notice.', 'next-addons');?></span></button>
				</div>
			</div>
			<?php }?>
			<div class="settings-content">
				 <?php
				 if($active_tab == 'widgets'){ 
					include( __DIR__ .'/include/option-addons.php');
				 }else if($active_tab == 'get-pro'){
					 include( __DIR__ .'/include/get-pro.php');
				 }else if($active_tab == 'general'){
					 include( __DIR__ .'/include/option-general.php');
				 }
				 ?>
			 </div>
		 </div>
	 </div>
</section>
