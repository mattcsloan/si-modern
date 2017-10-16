<?php 
      $post_id = get_the_ID();
      
      $link1 = get_post_meta( $post_id, 'link_1', true ); 
      $link2 = get_post_meta( $post_id, 'link_2', true ); 
      $link3 = get_post_meta( $post_id, 'link_3', true ); 
      $link4 = get_post_meta( $post_id, 'link_4', true ); 
      $link5 = get_post_meta( $post_id, 'link_5', true ); 
      $link6 = get_post_meta( $post_id, 'link_6', true ); 
      $link7 = get_post_meta( $post_id, 'link_7', true ); 
      $link8 = get_post_meta( $post_id, 'link_8', true ); 
      $link1Url = get_post_meta( $post_id, 'link_1_url', true ); 
      $link2Url = get_post_meta( $post_id, 'link_2_url', true ); 
      $link3Url = get_post_meta( $post_id, 'link_3_url', true ); 
      $link4Url = get_post_meta( $post_id, 'link_4_url', true ); 
      $link5Url = get_post_meta( $post_id, 'link_5_url', true ); 
      $link6Url = get_post_meta( $post_id, 'link_6_url', true ); 
      $link7Url = get_post_meta( $post_id, 'link_7_url', true ); 
      $link8Url = get_post_meta( $post_id, 'link_8_url', true ); 
      $linkDisplay = get_post_meta( $post_id, 'display_links', true ); 

      if($linkDisplay == 'on') {
?>
            <div class="related-links">
                  <span class="related-links-title">Related Links</span>
                  <ul>
<?php
                        $counter = 1;
                        $links = 8;
                        while ($counter < $links) {
                              $linkNum = ${'link' . $counter};
                              $linkUrl = ${'link' . $counter . 'Url'};
                              if($linkNum != '') { 
                                    if(substr($linkUrl,0,4) == 'http') {
                                          echo '<li><a href="'.$linkUrl.'" target="_blank">'.$linkNum.'</a></li>'; 
                                    } else {
                                          echo '<li><a href="'.$linkUrl.'">'.$linkNum.'</a></li>'; 
                                    }
                              }
                              $counter = $counter+1;
                        }                             
?>
                  </ul>
            </div>
<?php
      }
?>