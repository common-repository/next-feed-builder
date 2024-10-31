<div class="nextfeed-modal-contineer">
    <form action="" id="_nextfeed_froms_templates" class="nestfeed-forms-start" name="nextdfeed-template-forms" method="post" >
        <div class="next-modal-dialog" id="next-modal-0">
                <div class="next-modal-content post__tab">
                    <div class="next-modal-header clear-both">
                        <div class="tabHeader">
                            <ul class="tab__list clear-both">
                                <li class="tab__list__item active" onclick="next_tab_control(this)" nx-target="#next_tab_0__basic" nx-target-common=".next-tab-item" ><?php echo esc_html__('Basic', 'next-feed');?></li>
                                <li class="tab__list__item" onclick="next_tab_control(this)" nx-target="#next_tab_1__setup" nx-target-common=".next-tab-item" ><?php echo esc_html__('Setup', 'next-feed');?></li>
                                <li class="tab__list__item" onclick="next_tab_control(this)" nx-target="#next_tab_2__demo" nx-target-common=".next-tab-item" ><?php echo esc_html__('Demo', 'next-feed');?></li>
                            </ul>
                        </div>
                           
                        <button type="button" class="next-btn danger" onclick="next_hide_popup(this);" ><?php echo esc_html__('X');?></button>
                    </div>
                    <div class="next-modal-body">
                        <div class="next--tab__post__details tabContent">
                            <p class="_give-message"></p>
                            <div class="tabItem next-tab-item active" id="next_tab_0__basic">
                                <h6 class="next_section-title"><?php echo esc_html__('Basic', 'next-feed');?></h6>
                                <?php do_action('_nextfeed_postforms_basic_before');?>
                                <div class="next-section-blog inlinesection">
                                    <div class="setting-label-wraper">
                                        <label class="setting-label" for="_basic_name"><?php echo __('Name', 'next-feed');?> </label>
                                    </div>
                                    <div class="setting-label-wraper-right">
                                    <input placeholder="Template name here" name="nextfeed[basic][name]" type="text" id="_basic_name" value="New Template - <?php echo time();?>" class="next-regular-text">
                                    </div>
                                </div>
                                <div class="next-section-blog inlinesection">
                                    <div class="setting-label-wraper">
                                        <label class="setting-label" for="_basic_type"><?php echo __('Type', 'next-feed');?> </label>
                                    </div>
                                    <div class="setting-label-wraper-right">
                                    <select name="nextfeed[basic][type]" onchange="_nextfeed_get_categories(this)" id="_basic_type" value="" class="next-regular-text">
                                    <?php
                                     $type = $this->_temp_type();
                                     
                                     foreach($type as $k=>$v):
                                        $name = isset( $v['name']) ? $v['name'] : '';
                                    ?>
                                        <option value="<?php echo $k;?>"> <?php echo esc_html__($name, 'next-feed'); ?> </option>
                                    <?php endforeach;?> 
                                     </select>
                                    
                                     <?php
                                      if ( ! did_action( 'nextfeedPro/loaded' ) ) {
                                     ?>
                                     <p class="nextfeed-pro-massage"> <?php echo __('<strong>PRO Features: </strong> Woo-commerce Templates (Single, Archive, Shop, My Account, Checkout, Cart, Thank you etc) and EDD(Easy Digital Downloads) Templates are available in PRO.)', 'next-feed');?>
                                     <a href="<?php echo esc_url('http://products.themedev.net/next-feed/');?>" style="color: #ea2a2a;" target="_blank"> Get PRO</a>
                                    </p>
                                     <?php }?>
                                     </div>
                                </div>
                                <div class="next-section-blog inlinesection">
                                    <div class="setting-label-wraper">
                                        <label class="setting-label" for="_basic_categories"><?php echo __('Categories', 'next-feed');?> </label>
                                    </div>
                                    <div class="setting-label-wraper-right">
                                    <select name="nextfeed[basic][categories]" id="_basic_categories" value="" class="next-regular-text">
                                        
                                    </select> 
                                    </div>
                                </div> 
                                <div class="next-section-blog inlinesection">
                                    <div class="setting-label-wraper">
                                        <label class="setting-label" for="_basic_categories"><?php echo __('Set Default', 'next-feed');?> </label>
                                    </div>
                                    <div class="setting-label-wraper-right">
                                        <input type="checkbox" name="nextfeed[basic][default]" class="themedev-switch-input" value="yes" id="_basic_default">
                                        <label class="themedev-checkbox-switch" for="_basic_default">
                                            <span class="themedev-label-switch" data-active="ON" data-inactive="OFF"></span>
                                        </label>
                                   
                                        <p class="nextfeed-pro-massage"> <?php echo esc_html__('Set default template for all items.', 'next-feed');?></p>
                                   </div>
                                </div> 
                                <?php do_action('_nextfeed_postforms_basic_after');?>  
                            </div>
                            <div class="tabItem next-tab-item" id="next_tab_1__setup">
                             <?php do_action('_nextfeed_postforms_setup_before');?>
                                 <h6 class="next_section-title"><?php echo esc_html__('Setup', 'next-feed');?></h6>
                            <?php do_action('_nextfeed_postforms_setup_after');?>
                            </div>
                            <div class="tabItem next-tab-item" id="next_tab_2__demo">
                            <?php do_action('_nextfeed_postforms_demo_before');?>
                                <h6 class="next_section-title"><?php echo esc_html__('Template', 'next-feed');?></h6>
                            <?php do_action('_nextfeed_postforms_demo_after');?>
                            </div>
                        </div>
                    </div>
                    <div class="next-modal-footer">
                        <label><input type="checkbox" name="nextfeed[_editor_mode]" value="yes">  <?php echo esc_html__('Save & Edit Template', 'next-feed');?> </label>
                        <button type="submit" name="nextdfeed-template" class="next-btn btn-special"><?php echo esc_html__('Save', 'next-feed');?></button>
                    </div>
                </div>
            </div>
        </div>
        <div class="next-backdrop"></div>
    </form>
</div>