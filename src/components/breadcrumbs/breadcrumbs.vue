<template>
	<nav class="breadcrumbs">

		<ul>
			<li v-if="this.current !== 'Minha Conta'">
		        <router-link :to="{ path: `/minha-conta` }">
		          Home
		        </router-link>   
			</li>
			<li v-if="$route.meta.slug === 'single'">
		        <router-link :to="{ path: `/meus-produtos` }">
		          Meus Produtos
		        </router-link> 
			</li>
			<li v-if="this.current !== 'Minha Conta'">
				{{this.current}}
			</li>
		</ul>
	</nav>
</template>

<script>
	export default {
		name: 'breadcrumbs',
		props: ['current'],
		computed: {
			vm() {
				return vm;
			}
		},		
		data() {
			return {

			};
		},
	};
</script>

<style lang="sass">
@import './sass/_breadcrumbs'
</style>
