<?php
/*
* @Author 		pickplugins
* Copyright: 	pickplugins.com
*/

if ( ! defined('ABSPATH')) exit;  // if direct access 
	

add_action('qa_action_after_single_question', 'after_single_answer_related_questions');

function after_single_answer_related_questions(){
	
	$question_id = get_the_ID();
	$post_type = get_post_type( get_the_ID() );	
	//$post_ids = related_questions_post_ids_by_taxonomy_terms();
	
	//echo '<pre>'.var_export($question_id, true).'</pre>';
    // get post type taxonomies
    $taxonomies = get_object_taxonomies($post_type);
	$taxonomy_terms = array();
	
	//echo '<pre>'.var_export($taxonomies, true).'</pre>';	
	
	
    foreach ($taxonomies as $taxonomy){
        // get the terms related to post
        $terms = get_the_terms( $question_id, $taxonomy );
        if ( !empty( $terms ) ){
				$i = 0;
				foreach ( $terms as $term ){
					
						$taxonomy_terms[$taxonomy][$i] =$term->term_id; 
						$i++;
					}   
			}
    }

	//echo '<pre>'.var_export($taxonomy_terms, true).'</pre>';

	
		if(!empty($taxonomy_terms)){
			
			foreach($taxonomy_terms as $taxonomy => $term_ids){
				
					foreach($term_ids as $term_id){
						
							$wp_query = new WP_Query(
								array (
									'post_type' => $post_type,
									'post_status' => 'publish',							
									
									'tax_query' => array(
										array(
											   'taxonomy' => $taxonomy,
											   'field' => 'id',
											   'terms' => $term_id,
										)
									)
									
									) );
									
									
									
					if ( $wp_query->have_posts() ) :
					$i = 0;
					while ( $wp_query->have_posts() ) : $wp_query->the_post();
							$post_ids[$i] = get_the_ID();
							
							$i++;	
					endwhile;
					
					wp_reset_query();
					endif;			
									
							
						}
				}
				
			}
		else
			{
				$post_ids = array();
			}
	

	
	$key = array_search ($question_id, $post_ids);
	
	if(!empty($post_ids[$key]))
	unset($post_ids[$key]);
	
	
	//echo '<pre>'.var_export($key, true).'</pre>';
	
	//echo '<pre>'.var_export($post_ids, true).'</pre>';	
		
	//echo '<pre>'.var_export($question_id, true).'</pre>';	
	
	

	
	
	
	
	
	?>
    
	
        
        
        
		<?php if(!empty($post_ids)): ?>
        <div class="qa-related-questions">
       		<h3><?php echo __('Related Questions', QARQ_TEXTDOMAIN); ?></h3>
            <div class="list-items">
            <?php
            
                $args = array('post_type' => $post_type, 'post_status' => 'publish',  'post__not_in' => $question_id, 'post__in'=> $post_ids, 'orderby' => 'post__in', 'showposts' => 5);
                
                //echo '<pre>'.var_export($args, true).'</pre>';	
        
        
                $wp_query = new WP_Query($args);	
                
                if ($wp_query->have_posts()){
                        
                        while ($wp_query->have_posts()) : $wp_query->the_post();
                            
                            
                            $post_link = get_permalink(get_the_ID());
                            $post_title = get_the_title(get_the_ID());

                            echo apply_filters('question_answer_related_questions_item', '<a class="item" href="'.$post_link.'">'.$post_title.'</a>');				

                        
                        endwhile; 
                        //wp_reset_query(); 
                        wp_reset_postdata(); 
                    }
            	?>
             </div>
		</div>
        <?php endif; ?>
       
    
    
    <?php
	
	}



	
	