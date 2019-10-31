<template>
	<div class="produto">
		<div class="produto-inner">
            <div
              v-if="vm._data.produto.thumbnail&&UrlExists(vm._data.produto.thumbnail)"
              :style="{ backgroundImage: 'url(' + vm._data.produto.thumbnail + ')' }"
              class="thumbnail"
            />
            <div class="produto-info">
            	<div v-html="vm._data.produto.produto.post_content" v-if="vm._data.produto.produto.post_content" />
            	<ul class="downloads" v-if="vm._data.produto.manual||vm._data.produto.catalogo">
	            	<li v-if="vm._data.produto.manual">
	            		<md-button :href="vm._data.produto.manual" class="md-raised md-accent">
		            		<i class="fas fa-download"></i>
		            		<span>
		            			<small>Baixe o</small>
		            			Manual
		            		</span>	
	            		</md-button>
	            	</li>
	            	<li v-if="vm._data.produto.catalogo">
	            		<md-button :href="vm._data.produto.catalogo" class="md-raised md-accent">
		            		<i class="fas fa-download"></i>
		            		<span>
		            			<small>Baixe o</small>
		            			Catálogo
		            		</span>	
	            		</md-button>
	            	</li>
            	</ul>
            </div>

		    <md-divider></md-divider>

		    <md-toolbar :class="(vm._data.serialEnabled) ? 'md-toolbar-expired' : ''">
		      <h3 class="md-title">
		      		<span v-if="!vm._data.serialEnabled">
			      	  {{ this.serial }}	
				      <input id="serial" type="hidden" v-model="serial" />
		      		</span>
		      		<span v-else>Seu serial expirou dia {{ vm._data.produto.serial.expiration }} <md-icon>error</md-icon></span>
			  </h3>
		      <md-button v-if="!vm._data.serialEnabled" class="md-icon-button" @click.stop.prevent="copy">
		        <md-icon>
			        file_copy
			        <md-tooltip>Seu serial irá expirar dia: {{ vm._data.produto.serial.expiration }}</md-tooltip>
			    </md-icon>
		      </md-button>
		    </md-toolbar>    

			<md-dialog :md-active.sync="this.message !== ''">
			    <md-dialog-title>{{ this.message }}</md-dialog-title>
				<md-dialog-actions>
					<md-button class="md-primary" @click="this.message = ''">Fechar</md-button>
				</md-dialog-actions>
			</md-dialog>			            
		</div>
	</div>
</template>

<script>
	import Vue from 'vue';
	import store from "@/store";

	const VueHead = require("vue-head");

	Vue.use(VueHead);

	var vm = new Vue({
	  data: {
	  	produto: [],
	  	serialEnabled: true
	  }
	});

	export default {
		name: 'single',
		beforeRouteEnter (to, from, next) {
			var produtos = JSON.parse(sessionStorage.getItem('user_products'));

			for (const [key, value] of Object.entries(produtos)) {
	        	if(value.produto.ID === parseInt(to.params.id)){
	        		vm._data.produto = value;
	        	}
			} 

			function checkAvailability(str) {
				var date = new Date();

				date = String(date.getMonth() + 1).padStart(2, '0') + '/' + 
				String(date.getDate()).padStart(2, '0') + '/' + date.getFullYear();

				var expirationDate = new Date(str.split('/')[1] + '/' + str.split('/')[0] +  '/' + str.split('/')[2]);

				var currentDate = new Date(date);

				var timeDiff = currentDate.getTime() - expirationDate.getTime();
				var DaysDiff = timeDiff / (1000 * 3600 * 24);		

				return DaysDiff > 0;
			}

			vm._data.serialEnabled = checkAvailability(vm._data.produto.serial.expiration);

			next();
		},			
		mounted() {
			this.$emit('getProduct', vm._data.produto.produto.post_title);	
			this.getAsyncData();
		},
		methods: {
			getAsyncData: function() {
				var self = this;
				window.setTimeout(function() {
					self.meta.name = self.title = "Techgeo - " + vm._data.produto.produto.post_title;
					self.meta.description = " | " + vm._data.produto.produto.post_content.replace(/(<([^>]+)>)/gi, "");
					self.meta.ogImage = vm._data.produto.thumbnail;
					self.$emit("updateHead");
				});
			},	
			UrlExists(url)
			{
			    var http = new XMLHttpRequest();
			    http.open('HEAD', url, false);
			    http.send();
			    return http.status!=404;
			},			
	        copy () {
	          let testingCodeToCopy = document.querySelector('#serial');

	          var self = this;

	          console.log(testingCodeToCopy);
	          testingCodeToCopy.setAttribute('type', 'text');   
	          testingCodeToCopy.select();

	          try {
	            var successful = document.execCommand('copy');
	            var msg = successful ? 'successful' : 'unsuccessful';
	            self.message = 'Serial copiado com sucesso!'; 
	          } catch (err) {
	            self.message = 'Ocorreram erros ao copiar.';
	          }

	          setTimeout(function(){ 
	          	self.message = '';
	          }, 1000);

	          testingCodeToCopy.setAttribute('type', 'hidden')
	          window.getSelection().removeAllRanges()
	        },
		},
		data() {
			return {
				title: "",
				meta: {
					name: "",
					description: "",
					ogImage: ""
				},				
				serial: vm._data.produto.serial.code,
				message: ''
			};
		},
		computed: {
			vm() {
				return vm;
			}
		},
		head: {
			title: function() {
			  return {
			    inner: this.title,
			    separator: " ",
			    complement: this.meta.description
			  };
			},
			meta: function() {
			  return [
			    { name: "application-name", content: this.meta.name },
			    { name: "description", content: this.meta.description },
			    { name: "twitter:title", content: this.meta.name },
			    { n: "twitter:description", c: this.meta.description },
			    { itemprop: "name", content: this.meta.name },
			    { itemprop: "description", content: this.meta.description },
			    { property: "fb:app_id", content: "123456789" },
			    { property: "og:title", content: this.meta.name },
			    { p: "og:image", c: this.meta.ogImage }
			  ];
			},
			links: function() {
			  return [
			    { rel: "canonical", href: window.location.href, id: "canonical" }
			  ];
			}
		}
	};
</script>

<style lang="sass">
	@import './sass/_single'
</style>