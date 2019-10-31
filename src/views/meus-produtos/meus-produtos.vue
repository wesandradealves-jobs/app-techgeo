<template>
	<div>
		<h2 class="page-title">{{this.current}}</h2>
		<div v-if="this.$route.meta.slug !== 'single'" class="produtos">
			<div class="produtos-header"></div>
			<div class="produtos-list">
				<div @click="$router.replace(`/meus-produtos/${produto.produto.ID}`)" style="color: black" class="produto-card" v-for="produto in vm._data.produtos">
					<div class="produto-card-inner">
						<md-icon :class="'expired'" v-if="_checkAvailability(produto.serial.expiration)">
							error
							<md-tooltip>O serial para este produto expirou.</md-tooltip>
						</md-icon>
			            <div
			              v-if="produto.thumbnail&&UrlExists(produto.thumbnail)"
			              :style="{ backgroundImage: 'url(' + produto.thumbnail + ')' }"
			              class="thumbnail"
			            />
			            <div class="card-footer">
			            	<h2 class="title">{{produto.produto.post_title}}</h2>
			            	<h3 class="additional-info">
				            	<small class="brand">{{produto.marca}}</small>
				            	<small class="category">{{produto.categoria}}</small>
			            	</h3>
			            </div>
					</div>
				</div>
			</div>
		</div>
		<transition v-else name="fade" mode="out-in">
		  <router-view v-on:getProduct="getProduct" />
		</transition>	
	</div>	
</template>

<script>
	import Vue from 'vue';
	import axios from 'axios';
	import VueAxios from 'vue-axios';

	Vue.use(VueAxios, axios);

	var vm = new Vue({
	  data: {
	  	user: JSON.parse(sessionStorage.getItem('user')),
	  	produtos: JSON.parse(sessionStorage.getItem('user_products'))
	  }
	});

	export default {
		name: 'meus_produtos',
		props: ['current'],
		methods: {
			UrlExists(url)
			{
			    var http = new XMLHttpRequest();
			    http.open('HEAD', url, false);
			    http.send();
			    return http.status!=404;
			},			
			getProduct(v) {
				this.$emit('getProduct', v);	
			},			
			_checkAvailability(str) {
				var date = new Date();

				date = String(date.getMonth() + 1).padStart(2, '0') + '/' + 
				String(date.getDate()).padStart(2, '0') + '/' + date.getFullYear();

				var expirationDate = new Date(str.split('/')[1] + '/' + str.split('/')[0] +  '/' + str.split('/')[2]);

				var currentDate = new Date(date);

				var timeDiff = currentDate.getTime() - expirationDate.getTime();
				var DaysDiff = timeDiff / (1000 * 3600 * 24);		

				return DaysDiff > 0;
			}
		},
		computed: {
			vm() {
				return vm;
			}
		}
	};
</script>

<style lang="sass">
	@import './sass/_meus-produtos'
</style>