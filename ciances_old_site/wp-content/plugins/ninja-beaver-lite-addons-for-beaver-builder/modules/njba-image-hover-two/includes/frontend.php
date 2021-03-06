    
    <?php 
    $style = $settings->style;
    switch ($style) {
        case '1':
    ?>
        <div class="njba-image-hover-box1">
        <a href="<?php if($settings->link_url){echo $settings->link_url;}?>" target="<?php if($settings->link_target){echo $settings->link_target;}?>">
       <div class="njba-image-hover-border njba-image-hover-common">
       <div class="njba-njba-box-dispay">
        <div class="njba-box-dispay-two">
          <h1 class="caption-selector"><?php if(!empty($settings->caption)){echo $module->njba_image_hover_caption_module($style);}?></h1>
          <h2 class="sub-caption-selector"><?php if(!empty($settings->sub_caption)){echo $module->njba_image_hover_sub_caption_module($style);}?></h2>
         </div>
        </div>
       </div>
       <?php if(!empty($settings->photo)){ ?>
        <img src="<?php echo $settings->photo_src; ?>" class="njba-image-responsive" />
        <?php } ?>
        </a>
       </div>
        
        <?php break;
        case '2':
        ?>
        <div class="njba-image-hover-box2">
        <a href="<?php if($settings->link_url){echo $settings->link_url;}?>" target="<?php if($settings->link_target){echo $settings->link_target;}?>">
        <div class="njba-image-hover-box-three">
            
          <div class="njba-box-dispay">
           <div class="njba-box-dispay-two">
             <h1 class="caption-selector"><?php if(!empty($settings->caption)){echo $module->njba_image_hover_caption_module($style);}?></h1>
           </div>  
          </div>   
        </div>
        <?php if(!empty($settings->photo)){ ?>
          <img src="<?php echo $settings->photo_src; ?>" class="njba-image-responsive"/> 
        <?php } ?>
          </a> 
        </div> 
        
        <?php break;
        case '3':
        ?>
        <div class="njba-image-hover-box-four">
        <a href="<?php if($settings->link_url){echo $settings->link_url;}?>" target="<?php if($settings->link_target){echo $settings->link_target;}?>">
           <div class="njba-image-hover-name-one caption-selector">
          <?php if(!empty($settings->caption)){echo $module->njba_image_hover_caption_module($style);}?>
           </div>
           <div class="njba-image-hover-name-two sub-caption-selector">
          <?php if(!empty($settings->sub_caption)){echo $module->njba_image_hover_sub_caption_module($style);}?>
           </div>
           <?php if(!empty($settings->photo)){ ?>
          <img src="<?php echo $settings->photo_src; ?>" class="njba-image-responsive njba-image-hover-img"/>
          <?php } ?>  
         </div>
         </a>
        <?php break;
        case '4':
        ?>
        <div class="njba-image-hover-box-five">
        <a href="<?php if($settings->link_url){echo $settings->link_url;}?>" target="<?php if($settings->link_target){echo $settings->link_target;}?>">
           <div class="njba-image-hover-box-five-one">
              <div class="njba-box-dispay">
                <div class="njba-box-dispay-two">
                  <h1 class="caption-selector"><?php if(!empty($settings->caption)){echo $module->njba_image_hover_caption_module($style);}?></h1>
                  <h2 class="sub-caption-selector"><?php if(!empty($settings->sub_caption)){echo $module->njba_image_hover_sub_caption_module($style);}?></h2>
                </div>  
              </div>    
           </div>
           <?php if(!empty($settings->photo)){ ?>
           <img src="<?php echo $settings->photo_src; ?>" class="njba-image-responsive"/>
           <?php } ?>
         </div>
         </a>
        <?php break;
        case '5':
        ?>
        <div class="njba-image-hover-box-six">
        <a href="<?php if($settings->link_url){echo $settings->link_url;}?>" target="<?php if($settings->link_target){echo $settings->link_target;}?>">
                <div class="njba-image-hover-box-six-one">
                  <div class="njba-box-dispay">
                    <div class="njba-box-dispay-three">
                      <h1 class="caption-selector"><?php if(!empty($settings->caption)){echo $module->njba_image_hover_caption_module($style);}?></h1>
                      <h2 class="sub-caption-selector"><?php if(!empty($settings->sub_caption)){echo $module->njba_image_hover_sub_caption_module($style);}?></h2>
                    </div> 
                  </div>
                </div>
              <?php if(!empty($settings->photo)){ ?>
              <img src="<?php echo $settings->photo_src; ?>" class="njba-image-responsive"/>
              <?php } ?>
              </a>
            </div>
        <?php break;
        } ?>
    
