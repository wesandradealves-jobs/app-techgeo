<template>
	<nav class="navigation">
		<ul>
			<li v-for="item in this.items">
        <router-link :title="item.label" :to="{ path: `/${item.slug}` }">
          {{item.label}}
        </router-link>   				
			</li>
		</ul>
	</nav>
</template>

<script>
export default {

  name: 'navigation',

  data() {
    return {
    	items: [
        {
          'slug':'minha-conta',
          'label':'Minha Conta'
        },
    		{
    			'slug':'meus-produtos',
    			'label':'Meus Produtos'
    		}    		
    	]
    };
  },
};
</script>

<style lang="sass">
@import './sass/_navigation'
</style>
