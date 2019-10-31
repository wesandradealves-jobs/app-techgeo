<template>
	<section class="dashboard">
		<top-bar />
		<div class="content">
			<sidebar />
			<section class="content-inner">
				<scroll-area ref="vs">
					<div class="container">
						<breadcrumbs :current="(!vm._data.current) ? 'Minha Conta' : vm._data.current" />
						<router-view v-on:getProduct="getProduct" :current="vm._data.current" />
					</div>
				</scroll-area>
			</section>
		</div>
		<bottom-bar />
	</section>
</template>

<script>
	import Vue from 'vue';
	import topBar from "@/components/topBar/topBar.vue";
	import bottomBar from "@/components/bottomBar/bottomBar.vue";
	import sidebar from "@/components/sidebar/sidebar.vue";
	import breadcrumbs from "@/components/breadcrumbs/breadcrumbs.vue";
	import router from "@/router";
	import vuescroll from 'vuescroll';
	
	Vue.use(vuescroll, {
	  ops: {
	    vuescroll: {
	      wheelScrollDuration: 500,
	      detectResize: true
	    },
	    scrollPanel: {
	      scrollingX: false,
	      scrollingY: true,
	      speed: 1500,
	      easing: 'easeInOutCubic'
	    },
	    bar: {
	      onlyShowBarOnScroll: false,
	      keepShow: true,
	      background: 'orangered'
	    }
	  },
	  name: 'scrollArea' // customize component name, default -> vueScroll
	});

	var vm = new Vue({
	  data: {
	  	current: ''
	  }
	});

	router.afterEach((to, from) => {
		vm._data.current = to.name;
	});	
	
	export default {
		name: 'dashboard',
		computed: {
			vm() {
				return vm;
			}
		},
		methods: {
			getProduct(v) {
				vm._data.current = v;
			}
		},
		components: {
			bottomBar,
			breadcrumbs,
			sidebar,
			topBar
		}
	};
</script>

<style lang="sass">
@import './sass/_dashboard'
</style>