		<aside class="flex20">
			<nav>
				<a href="javascript:void(0)" data-type="filtro_por_destaque" data-value="destaques" title="Destaques"><b>Destaques</b></a>
				<ul>
					<li><h3><a href="javascript:void(0)" data-type="filtro_por_categoria" title="Tipos"><b>Tipos</b></a></h3></li>
					<?php
					  $category_ids = get_all_category_ids(); 
					  $args = array('orderby' => 'slug','hide_empty' => FALSE,'parent' => 0);
					  $categories = get_categories( $args );
					  foreach ( $categories as $category ) {
					  	if (strpos($category->name, 'GNSS') !== false || strpos($category->name, 'gnss') !== false) {
						    echo '<li class="has-gnss"><a href="javascript:void(0)" title="'.$category->name.'" data-type="filtro_por_categoria" data-value="'.$category->slug.'">'.$category->name.'</a></li>';
						} else {
							echo '<li><a href="javascript:void(0)" title="'.$category->name.'" data-type="filtro_por_categoria" data-value="'.$category->slug.'">'.$category->name.'</a></li>';
						}
					  }
					?>
				</ul>
				<ul>
					<li><h3><a href="javascript:void(0)" data-type="filtro_por_marca" title="Marcas"><b>Marcas</b></a></h3></li>
					<?php 
						$args=array('public'   => true,'_builtin' => false);
						$output = 'names'; // or objects
						$operator = 'and';
						$taxonomies=get_taxonomies($args,$output,$operator); 
						if ($taxonomies) {
							foreach ($taxonomies  as $taxonomy ) {
							    $terms = get_terms($taxonomy, array('hide_empty' => false));
							    foreach ( $terms as $term) {
							    	echo "<li><a href='javascript:void(0)' title='".$term->name."' data-type='filtro_por_marca' data-value='".$term->slug."'>".$term->name."</a></li>";
							    }
							}
						}
					?>
				</ul>
			</nav>
		</aside>