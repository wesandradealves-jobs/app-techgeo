<?php get_header(); ?>
  <main>
	  	<section class="busca">
	  		<div class="wrap">
	  			<form class="search" action="<?php echo home_url(); ?>" role="search" method="GET">
	  				<input type="text" name="s" placeholder="Busca">
					<input type="hidden" name="referrer" value="downloads">
	  				<button>&#x1F50E;</button>
	  			</form>
	  		</div>
	  	</section>
		<?php
		    global $wpdb;
		    $i = 0;
		    $search_arr = array();

		    $search = $wpdb->get_results( "SELECT * FROM $wpdb->postmeta where $wpdb->postmeta.meta_key = '_wp_attached_file' and $wpdb->postmeta.meta_value LIKE '%".$_GET['s']."%' limit 100");

		    foreach ($search as $key => $value) {
		    	if(stripos($value->meta_value, 'pdf')>0){
		    		if(get_post($value->post_id)->post_parent) {
		    			$i++;

						array_push($search_arr, array(
							'file' => $value->meta_value,
							'file_object' => get_post($value->post_id),
							'produto' => get_post(get_post($value->post_id)->post_parent)
						));			    			
		    		}
		    	}
		    }   

		    ?>
		 	<section class="results">
		    	<div class="wrap">
		    		<h2>Encontrado(s) <?php echo $i; ?> resultado(s).</h2>
					<?php
						foreach ($search_arr as $key => $value) {
							echo '<div>';
							echo '<h3>'.$value['file_object']->post_title.'</h3>';
							echo '<a href="'.$value['file_object']->guid.'">Download</a><br><br>';
							echo 'Produto Relacionado: <a href="'.get_permalink( $value['produto']->ID ).'">'.$value['produto']->post_title.'</a>';
							echo '<hr>'; 
							echo '</div>'; 	
						}  
					?>  
		    	</div>
		    </section>
  </main>
<?php get_footer(); ?>