				
				<?php
		    	for($i=0; $i < $number_teams; $i++) :
					$teams = $settings->teams[$i];
					if($settings->teams_layout_view === "box")
					{
				?>
						<div class="njba-column-<?php echo $settings->show_col;?>">
				<?php 
					}
					else if($settings->teams_layout_view === "slider")
					{
				?>
						<div class="njba-slide-<?php echo $i;?>">
				<?php 
					}
				?>
						    <div class="njba-team-section ">
						        <div class="njba-team-img">
						           <?php $module->image_render($i);?>
						        </div>
						        <div class="njba-team-content">
						        	<?php $module->short_bio($i); ?>
						           	<div class="njba-team-social">
							             <?php $module->social_media($i); ?>
							        </div>
						        </div><!--njba-team-content-->
						    </div><!--njba-team-section-->
						</div>
			<?php 
				endfor;
			?>