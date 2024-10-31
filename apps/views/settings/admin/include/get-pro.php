<div class="section-addons addons-pro">
	<div class="nxadd-feature-section">
        <div class="feature-container">
            <div class="feature-addons-bannar">
               <img src="<?php echo esc_url('https://themedev.net/ads/attach/next-feed-banner.jpg'); ?>" alt="Banner">
            </div>
        </div>
    </div>	
	<h3><?php echo esc_html__('Next FeedBuilder (Pro)', 'next-feed');?></h3>
	<div class="nxadd-pro-features">
		<div class="nx-row nxadd-content-inner">
			<div class="nx-col-lg-6">
				<div class="nxadd-admin-wrapper">
                    <div class="nxadd-admin-block">
                        <div class="nxadd-admin-header">
                            <div class="nxadd-admin-header-icon">
                                <i class="nx-icon nx-icon-file-text-o"></i>
                            </div>
							<h4 class="nxadd-admin-header-title">Woo-commerce</h4>
							<p>Woo-commerce Template builder(Shop, single product, My Account, Cart, Thank You, archive) pages, which will be supported for both Elementor and Gutenberg Page Builder</p>
                        </div>
                    </div>
                   
                </div>
			</div>
			<div class="nx-col-lg-6">
				<div class="feature-addons-bannar nx-pt-lt">
					<img src="<?php echo esc_url('https://themedev.net/ads/attach/woo-feed-pro.png'); ?>" alt="Woo">
				</div>
			</div>
		</div>
		<div class="nx-row nxadd-content-inner">
			<div class="nx-col-lg-6">
				<div class="feature-addons-bannar">
					<img src="<?php echo esc_url('https://themedev.net/ads/attach/demo-woo-feed.png'); ?>" alt="Demo">
				</div>
			</div>
			<div class="nx-col-lg-6">
				<div class="nxadd-admin-wrapper nx-pt-lt">
                    <div class="nxadd-admin-block">
                        <div class="nxadd-admin-header">
                            <div class="nxadd-admin-header-icon">
                                <i class="nx-icon nx-icon-file-text-o"></i>
                            </div>
							<h4 class="nxadd-admin-header-title">Demo Template Upload</h4>
							<p>Demo template upload for Woo-commerce single page, Shop, My Account, Cart, Thank you and Checkout page.</p>
                        </div>
                    </div>
                   
                </div>
			</div>
			
		</div>
	</div>
	<div class="next-addons-services nx-pro">
		<h3 class="nxadd-pro-feature">PRO Features</h3>
		<div class="nx-row nxadd-content-inner nx-inner-pt-0">
			<?php
				if(is_array($widget) && isset($widget)){
					foreach( $widget as $k=>$v ):
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
							<label class="nextaddons-checkbox-switch" for="nextfeedpro-<?php echo $k;?>_addons_data">
								<?php echo esc_html__($name, 'next-feed');?>
								<div class="nxaddons-info-link">
									<a class="nxaddons-demo-link" href="https://products.themedev.net/next-feed/<?php echo $link;?>" target="_blank">
										<i class="nx-icon nx-icon-desktop"></i>
										<span class="nxaddons-info-tooltip">Click and view demo</span>
									</a>
								</div>
								
							</label>
						</div>
					</div>
				<?php	
						
					endforeach;
				}
			?>
		</div>
	</div>
	<div class="nxadd-footer-pro-inner">
		<div class="nx-row ">
			<div class="nx-col-lg-12">
				<h3 class="nxadd-fetaure-pro-title">Get PRO version with exclusive widgets & Blocks.</h3>
				<a href="https://products.themedev.net/next-feed/pricing/" target="_blank" class="nxadd-button nx-get-pro">GET PRO</a>
			</div>
		</div>
	</div>
</div>