<template>
	<form class="login-form">
		<div class="container">
			<img src="/static/Logo-Branco1.png" alt="Techgeo" />
			<div class="field-groups">
			    <md-field :class="messageClass">
			      <label>Username</label>
			      <md-input :required="true" type="text" v-model="username"></md-input>
			      <span class="md-error">{{this.err}}</span>
			    </md-field>
			    <md-field :class="messageClass" :md-toggle-password="true">
			      <label>Password</label>
			      <md-input :required="true" type="password" v-model="password"></md-input>
			      <span class="md-error">{{this.err}}</span>
			    </md-field>		
			    <md-button @click="_login" class="md-raised md-primary">Entrar</md-button> 
			</div>
		</div>
	</form>		
</template>

<script>
	import Vue from 'vue';
	import axios from 'axios';
	import VueAxios from 'vue-axios';
	import router from "@/router";
	Vue.use(VueAxios, axios);

	export default {
		name: 'login',
		methods: {
			_setCookie(cname, cvalue, exdays) {
			  var d = new Date();
			  d.setTime(d.getTime() + (exdays * 24 * 60 * 60 * 1000));
			  var expires = "expires="+d.toUTCString();
			  document.cookie = cname + "=" + cvalue + ";" + expires + ";path=/";
			},			
			_login() {
				if(this.username === '' || this.password === ''){
					this.hasMessages = true;
					this.err = 'Campos obrigatórios.';
				} else {
					this.hasMessages = false;
					this.err = '';

					this.$store.state.isLoading = true;

					var self = this;

				    var data = new FormData();

				    data.append('username', this.username);
				    data.append('password', this.password);

					axios.post('https://staging.techgeo.com.br/api/user/generate_auth_cookie/?insecure=cool', data)
					.then(function (response) {
						self.$store.state.isLoading = false;

						if(response.data.status === 'ok') {
							var cookie_name = response.data.cookie_name;
							var cookie = response.data.cookie;
							var user = response.data.user;

							axios.get('https://staging.techgeo.com.br/api/user/validate_auth_cookie/?insecure=cool&cookie=' + cookie)
							.then(function (response) {
								if(response.data.status === 'ok' && response.data.valid) {
									sessionStorage.setItem("cookie_name", cookie_name);
									sessionStorage.setItem("cookie", cookie);

									const fetchArr = [
										`https://staging.techgeo.com.br/user.php?uid=${user.id}`,
										`https://staging.techgeo.com.br/user_products.php?uid=${user.id}`
									];

									let promise = fetchArr.map(l => fetch(l).then(res => res.json()));

									Promise.all(promise).then(res => {
										sessionStorage.setItem("user", JSON.stringify(res[0]));

										if(res[0]){
										  	sessionStorage.setItem("user", JSON.stringify(res[0]));
											
											self._setCookie(cookie_name, cookie, 1);

											router.push({ path: 'minha-conta' });

											if(res[1]){
												sessionStorage.setItem("user_products", JSON.stringify(res[1]));
											}						      		
										} else {
											router.push({ path: '/' });
										}
									});
								}
							})
							.catch(function (err) {
							  console.log(err);
							});		
						} else {
							self.hasMessages = true;
							self.err = (response.data.error === 'Invalid username/email and/or password.') ? 'Nome de usuário/E-mail e/ou Senha inválidos.' : response.data.error;
						}
					})
					.catch(function (err) {
					  console.log(err);
					  self.$store.state.isLoading = false;
					});			    				
				}
			}
		},
		beforeRouteEnter (to, from, next) {
		    if(sessionStorage.getItem('user')){
		      router.replace('minha-conta');
		    } else {
		      next();
		    }
		},	
		data() {
			return {
				username: '',
				password: '',
				hasMessages: false,
				err: ''
			};
		},
	    computed: {
	      messageClass () {
	        return {
	          'md-invalid': this.hasMessages
	        }
	      }
	    }		
	};
</script>

<style lang="sass">
	@import './sass/_login'
</style>
