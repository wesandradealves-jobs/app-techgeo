<template>
	<div class="topBar">
		<div class="container">
			<p>Seja Bem Vindo(a), {{ vm._data.displayname }}</p>
	        <md-button @click="signout" class="md-icon-button">
	          <md-icon>exit_to_app</md-icon>
	        </md-button>			
		</div>
	</div>
</template>

<script>

	import Vue from 'vue';

	var vm = new Vue({
	  data: {
	  	displayname: ''
	  }
	});

	export default {
		name: 'topBar',
		beforeCreate () {
			var displayname = JSON.parse(sessionStorage.getItem('user')).displayname;
			vm._data.displayname = (Array.isArray(displayname)) ? displayname[0] : displayname;
		},		
		methods: {
			signout: function() {
				sessionStorage.removeItem('cookie');
				sessionStorage.removeItem('cookie_name');
				sessionStorage.removeItem('user');
				sessionStorage.removeItem('user_products');

			    var cookies = document.cookie.split(";");

			    for (var i = 0; i < cookies.length; i++) {
			        var cookie = cookies[i];
			        var eqPos = cookie.indexOf("=");
			        var name = eqPos > -1 ? cookie.substr(0, eqPos) : cookie;
			        document.cookie = name + "=;expires=Thu, 01 Jan 1970 00:00:00 GMT";
			    }
			    
				this.$router.replace('/');
			},
		},
		computed: {
			vm() {
				return vm;
			}
		},
	};
</script>

<style lang="sass">
@import './sass/_topBar'
</style>