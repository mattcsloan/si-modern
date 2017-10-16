			<?php if ( is_sidebar_active('primary_widget_area') ) : ?>
				<?php dynamic_sidebar('primary_widget_area'); ?>
			<?php endif; ?>
			 
			<?php if ( is_sidebar_active('secondary_widget_area') ) : ?>
				<?php dynamic_sidebar('secondary_widget_area'); ?>
			<?php endif; ?>
            
			<?php 
			$post_id = get_the_ID();

			$headline = get_post_meta( $post_id, 'module_headline', true ); 
			$content = get_post_meta( $post_id, 'module_content', true ); 
			$url = get_post_meta( $post_id, 'module_url', true ); 
			$btnText = get_post_meta( $post_id, 'module_btn', true ); 
			$btnColor = 'btn-'.get_post_meta( $post_id, 'module_btn_color', true ); 
			$moduleDisplay = get_post_meta( $post_id, 'display_module', true );
	
			$headline2 = get_post_meta( $post_id, 'module_headline2', true ); 
			$content2 = get_post_meta( $post_id, 'module_content2', true ); 
			$url2 = get_post_meta( $post_id, 'module_url2', true ); 
			$btnText2 = get_post_meta( $post_id, 'module_btn2', true ); 
			$btnColor2 = 'btn-'.get_post_meta( $post_id, 'module_btn_color2', true ); 
			$moduleDisplay2 = get_post_meta( $post_id, 'display_module2', true ); 

			$headline3 = get_post_meta( $post_id, 'module_headline3', true ); 
			$content3 = get_post_meta( $post_id, 'module_content3', true ); 
			$url3 = get_post_meta( $post_id, 'module_url3', true ); 
			$btnText3 = get_post_meta( $post_id, 'module_btn3', true ); 
			$btnColor3 = 'btn-'.get_post_meta( $post_id, 'module_btn_color3', true ); 
			$moduleDisplay3 = get_post_meta( $post_id, 'display_module3', true ); 

			if($moduleDisplay == 'on' || $moduleDisplay2 == 'on' || $moduleDisplay3 == 'on') {
				$moduleCount = 0;
				if($moduleDisplay == 'on') { $moduleCount++; }
				if($moduleDisplay2 == 'on') { $moduleCount++; }
				if($moduleDisplay3 == 'on') { $moduleCount++; }

				if($moduleCount == 1) {
					$moduleClass = 'one-wide';
				} else if($moduleCount == 2) {
					$moduleClass = 'two-wide';
				} else if($moduleCount == 3) {
					$moduleClass = 'three-wide';
				}
			?>
		    <div class="secondary">
		        <div class="wrapper">
		            <div class="featured-items columns large-pad <?php echo $moduleClass; ?>">
									<?php if($moduleDisplay == 'on') { ?>
										<div class="featured-item col">
											<div class="featured-item-content">
												<?php if($headline != '') { echo '<h3>'.$headline.'</h3>'; } ?>
												<?php if($content != '') { echo '<p>'.$content.'</p>'; } ?>
												<p>
													<?php if($btnColor != '' && $url != '' && $btnText != '') { 
														if(substr($url,0,4) == 'http') {
															echo '<a class="btn '.$btnColor.'" href="'.$url.'" target="_blank">'.$btnText.'</a>';
														} else {
															echo '<a class="btn '.$btnColor.'" href="'.$url.'">'.$btnText.'</a>';
														}
													} ?>
												</p>
											</div>
										</div>
									<?php
									}
									if($moduleDisplay2 == 'on') {
									?>
										<div class="featured-item col">
											<div class="featured-item-content">
												<?php if($headline2 != '') { echo '<h3>'.$headline2.'</h3>'; } ?>
												<?php if($content2 != '') { echo '<p>'.$content2.'</p>'; } ?>
												<p>
													<?php if($btnColor2 != '' && $url2 != '' && $btnText2 != '') { 
														if(substr($url2,0,4) == 'http') {
															echo '<a class="btn '.$btnColor2.'" href="'.$url2.'" target="_blank">'.$btnText2.'</a>'; 
														} else {
															echo '<a class="btn '.$btnColor2.'" href="'.$url2.'">'.$btnText2.'</a>'; 
														}
													} ?>
												</p>
											</div>
										</div>
									<?php
									}
									if($moduleDisplay3 == 'on') {
									?>
										<div class="featured-item col">
											<div class="featured-item-content">
												<?php if($headline3 != '') { echo '<h3>'.$headline3.'</h3>'; } ?>
												<?php if($content3 != '') { echo '<p>'.$content3.'</p>'; } ?>
												<p>
													<?php if($btnColor3 != '' && $url3 != '' && $btnText3 != '') { 
														if(substr($url3,0,4) == 'http') {
															echo '<a class="btn '.$btnColor3.'" href="'.$url3.'" target="_blank">'.$btnText3.'</a>'; 
														} else {
															echo '<a class="btn '.$btnColor3.'" href="'.$url3.'">'.$btnText3.'</a>'; 
														}
													} ?>
												</p>
											</div>
										</div>
									<?php
									} ?>
		            </div>
		        </div>
		    </div>
		  <?php
			}
			?>
