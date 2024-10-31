<?php
$active_tab = isset($_GET["tab"]) ? $_GET["tab"] : 'widgets';
?>
 <ul class="nav-tab-wrapper">
	<li><a href="<?php echo esc_url(admin_url().'admin.php?page=nextfeed&tab=general');?>" class="nav-tab <?php if($active_tab == 'general'){echo 'nav-tab-active';} ?> "><?php echo esc_html__('General', 'next-addons');?></a></li>
	<li><a href="<?php echo esc_url(admin_url().'admin.php?page=nextfeed&tab=widgets');?>" class="nav-tab <?php if($active_tab == 'widgets'){echo 'nav-tab-active';} ?> "><?php echo esc_html__('Widgets', 'next-addons');?></a></li>
	<?php 
	if ( ! did_action( 'nextfeedPro/loaded' ) ) {
	?>
	<li><a href="<?php echo esc_url(admin_url().'admin.php?page=nextfeed&tab=get-pro');?>" class="nav-tab nav-item-pro <?php if($active_tab == 'get-pro'){echo 'nav-tab-active';} ?>"><?php echo esc_html__('Get Pro', 'next-addons');?></a></li> 
	
	<?php }?>
</ul>