	<?php 
	echo '<div id="breadcrumbs" class="b light-theme">
            <div class="wrap">
              <ul class="b">
                <li><a href="'.site_url().'/galeria" title="Galeria">Galeria</a></li>
              </ul>
            </div>
          </div>';

	$args = array('post_type' => 'galeria', 'order' => 'ASC');
	$query = new WP_Query($args);
	if($query->have_posts()=="1"){ ?>
	<section id="galeria">
		<div class="wrap">
			<ul class="galeria flex cards">
				<?php 
					while ( $query->have_posts() ) : $query->the_post();
						echo '<li onclick="document.location='; 
						echo "'".get_the_permalink()."';return false;";
						echo '" class="flex flex33">';
					?>
						<div><?php echo '<img class="b" src="'.wp_get_attachment_url(get_post_thumbnail_id($post->ID)).'" alt="'.get_the_title().'"/>'; ?></div>
						<div><?php the_title( '<h3>', '</h3>' ); ?></div>
					<?php
						echo '</li>';
					endwhile; 
					wp_reset_query();	
				?>
			</ul>	
		</div>
	</section>
	<?php } ?>

