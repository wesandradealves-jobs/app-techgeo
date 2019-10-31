<template>
	<div>
		<h2 class="page-title">{{this.current}}</h2>
		<div>
			<form class="user-form">
				<div class="field-groups">
				    <div>
					    <md-field>
					      <label>Username</label>
					      <md-input readonly v-model="username" type="text"></md-input>
					    </md-field>					    		    	
				    </div>
				    <div>
					    <md-field>
					      <label>E-mail</label>
					      <md-input readonly v-model="email" type="text"></md-input>
					    </md-field>					    		    	
				    </div>
				    <div>
					    <md-field>
					      <label>URL</label>
					      <md-input v-model="url" type="text"></md-input>
					    </md-field>					    		    	
				    </div>
				    <div>
					    <md-field>
					      <label>Display Name</label>
					      <md-input v-model="displayname" type="text"></md-input>
					    </md-field>					    		    	
				    </div>
				    <div>
					    <md-field>
					      <label>Nome</label>
					      <md-input v-model="firstname" type="text"></md-input>
					    </md-field>					    		    	
				    </div>
				    <div>
					    <md-field>
					      <label>Sobrenome</label>
					      <md-input v-model="lastname" type="text"></md-input>
					    </md-field>					    		    	
				    </div>
				    <div>
					    <md-field>
					      <label>Nickname</label>
					      <md-input v-model="nickname" type="text"></md-input>
					    </md-field>					    		    	
				    </div>
				    <div>
					    <md-field>
					      <label>Descrição</label>
					      <md-input v-model="description" type="text"></md-input>
					    </md-field>					    		    	
				    </div>					    				    
				    <input type="hidden" v-model="id" />
				    <md-button @click="_userData" class="md-raised md-primary">Salvar</md-button>
				</div>
			</form>
		</div>
	</div>	
</template>

<script>
	import Vue from 'vue';
	import axios from 'axios';
	import VueAxios from 'vue-axios';

	Vue.use(VueAxios, axios);

	export default {
		name: 'minha_conta',
		props: ['current'],
		methods: {
			_userData() {
				var self = this;

			    self.$store.state.isLoading = true;

				var data = {
					username: self.username,
					id: self.id,
					email: self.email,
					url: self.url,
					displayname: self.displayname,
					firstname: self.firstname,
					lastname: self.lastname,
					nickname: self.nickname,
					description: self.description	
				}

				axios.get(`http://staging.techgeo.com.br/update_user.php?user_data=${JSON.stringify(data)}`)
				.then(function (response) {
					var user_meta = {};

					for (const [key, value] of Object.entries(response.data)) {
						self[key] = value[0];

						user_meta[key] = value[0];
					} 		

					sessionStorage.setItem("user", JSON.stringify(user_meta));

					self.$store.state.isLoading = false;
				})
				.catch(function (err) {
				  console.log(err);

				  self.$store.state.isLoading = false;
				});	
			}
		},
		mounted() {
			var self = this;

			setTimeout(function(){
				var user = JSON.parse(sessionStorage.getItem('user'));

				for (const [key, value] of Object.entries(user)) {
					self[key] = (Array.isArray(value)) ? value[0] : value;
				}  		
			}, 400);
		},
		data() {
			return {
				id: '',
				username: '',
				email: '',
				url: '',
				displayname: '',
				firstname: '',
				lastname: '',
				nickname: '',
				description: ''
			};
		}
	};
</script>

<style lang="css" scoped>
</style>
