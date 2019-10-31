<template>
	<md-bottom-bar class="md-accent" md-type="shift">
		<md-bottom-bar-item @click="$router.replace('/minha-conta')" id="bottom-bar-item-home" md-label="Home" md-icon="home"></md-bottom-bar-item>
		<md-bottom-bar-item @click="$router.replace('/meus-produtos')" id="bottom-bar-item-pages" md-label="Meus Produtos" md-icon="widgets"></md-bottom-bar-item>
		<md-bottom-bar-item @click="signout" id="bottom-bar-item-favorites" md-label="Logout" md-icon="exit_to_app"></md-bottom-bar-item>
	</md-bottom-bar>
</template>

<script>
export default {
	name: 'bottomBar',
	methods: {
		signout: function() {
			sessionStorage.removeItem('cookie');
			sessionStorage.removeItem('cookie_name');
			sessionStorage.removeItem('user');
			localStorage.removeItem('products');

		    var cookies = document.cookie.split(";");

		    for (var i = 0; i < cookies.length; i++) {
		        var cookie = cookies[i];
		        var eqPos = cookie.indexOf("=");
		        var name = eqPos > -1 ? cookie.substr(0, eqPos) : cookie;
		        document.cookie = name + "=;expires=Thu, 01 Jan 1970 00:00:00 GMT";
		    }
		    
			this.$router.replace('/');
		},
	}
};
</script>

<style lang="sass">
@import './sass/_bottomBar'
</style>