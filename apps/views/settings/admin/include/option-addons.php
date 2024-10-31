<form action="<?php echo esc_url(admin_url().'admin.php?page=nextfeed&tab=widgets');?>" name="setting_addons_form" method="post" id="nextaddons-widgets">
	<div class="section-addons addons-default">
		<div class="nxadd-import-layouts">
			<h1><?php echo esc_html__('GLOBAL CONTROL for Elementor or Gutenberg', 'next-feed');?></h1>
			<p class="sub-headding"> <?php echo esc_html__(' Use the Buttons to Activate or Deactivate all the Elements of Next FeedBuilder at once.', 'next-feed');?></p>
			<div class="nxadd-btn-group">
				<button type="button" class="nxadd-btn nxadd-btn-control-enable">Enable All</button>
				<button type="button" class="nxadd-btn nxadd-btn-control-disable">Disable All</button>
			</div>
		</div>
		<div class="next-addons-services addons-wrapper">
			<h3>Blog Elements</h3>
			<div class="nx-row">
				<?php
					if(is_array($widgets) && isset($widgets)){
						foreach( $widgets as $k=>$v ):
								$sp_name = str_replace(['post-', '-'], ['Blog ', ' '], $k); 
								$name = isset($v['name']) ? $v['name'] : ucwords($sp_name);
								$type = isset($v['type']) ? $v['type'] : '';
								$cate = isset($v['cate']) ? $v['cate'] : '';
								$link = isset($v['link']) ? $v['link'] : '';
					?>
						<div class="<?php echo esc_attr('themeDev-form');?> nx-col-lg-4 nx-col-md-6 nx-col-sm-12">
							<div class="card-shadow <?php echo isset($getServices['feed'][$k]) || empty($getServices) ? 'active' : ''; ?>">
								<?php if( !empty($cate) ){?>
								<sup class="<?php echo esc_attr($cate);?>-widget"> <?php echo strtoupper($cate);?></sup>
								<?php }?>
								<input type="checkbox" onclick="nx_addons_ser_add(this)" name="themedev[feed][<?php echo $k;?>][ebable]" <?php echo isset($getServices['feed'][$k]) || empty($getServices) ? 'checked' : ''; ?> class="nextaddons-switch-input next-addons-event-enable" value="Yes" id="nextfeed-<?php echo $k;?>_addons_data"/>
								<label class="nextaddons-checkbox-switch" for="nextfeed-<?php echo $k;?>_addons_data">
									<?php echo esc_html__($name, 'next-feed');?>
									<div class="nxaddons-info-link">
										<a class="nxaddons-demo-link" href="https://products.themedev.net/next-feed/<?php echo $link;?>" target="_blank">
											<i class="nx-icon nx-icon-desktop"></i>
											<span class="nxaddons-info-tooltip">Click and view demo</span>
										</a>
									</div>
									<span class="nextaddons-label-switch" data-active="ON" data-inactive="OFF"></span>
								</label>
							</div>
						</div>
					<?php	
						
						endforeach;
					}
				?>
			</div>

			<?php  if ( did_action( 'nextfeedPro/loaded' ) ) {?>
			<h3>Woo-commerce Elements</h3>
			<div class="nx-row">
				<?php
					if(is_array($widgets_pro) && isset($widgets_pro)){
						foreach( $widgets_pro as $k=>$v ):
							$sp_name = str_replace(['woo-', '-'], ['Product ', ' '], $k);
							$name = isset($v['name']) ? $v['name'] : ucwords($sp_name);
							$type = isset($v['type']) ? $v['type'] : '';
							$cate = isset($v['cate']) ? $v['cate'] : 'pro';
							$link = isset($v['link']) ? $v['link'] : '';
					?>
						<div class="<?php echo esc_attr('themeDev-form');?> nx-col-lg-4 nx-col-md-6 nx-col-sm-12">
							<div class="card-shadow <?php echo isset($getServices['feedpro'][$k]) || empty($getServices) ? 'active' : ''; ?>">
								<?php if( !empty($cate) ){?>
								<sup class="<?php echo esc_attr($cate);?>-widget"> <?php echo strtoupper($cate);?></sup>
								<?php }?>
								<input type="checkbox" onclick="nx_addons_ser_add(this)" name="themedev[feedpro][<?php echo $k;?>][ebable]" <?php echo isset($getServices['feedpro'][$k]) || empty($getServices) ? 'checked' : ''; ?> class="nextaddons-switch-input next-addons-event-enable" value="Yes" id="nextfeedpro-<?php echo $k;?>_addons_data"/>
								<label class="nextaddons-checkbox-switch" for="nextfeedpro-<?php echo $k;?>_addons_data">
									<?php echo esc_html__($name, 'next-feed');?>
									<div class="nxaddons-info-link">
										<a class="nxaddons-demo-link" href="https://products.themedev.net/next-feed/<?php echo $link;?>" target="_blank">
											<i class="nx-icon nx-icon-desktop"></i>
											<span class="nxaddons-info-tooltip">Click and view demo</span>
										</a>
									</div>
									<span class="nextaddons-label-switch" data-active="ON" data-inactive="OFF"></span>
								</label>
							</div>
						</div>
					<?php	
						
						endforeach;
					}
				?>
			</div>
			<?php }?>
		</div>
	</div>
	
	<div class="section-addons <?php echo esc_attr('themeDev-form');?>">
		<button type="submit" name="themedev-feed-submit" class="button nxadd-save-button"> <?php echo esc_html__('Save Setting', 'next-feed');?></button>
	</div>
</form>

