<template>
	<aside class="sidebar">
		<div class="container">
      <h1 class="logo">
        <img src="/static/Logo-Branco1.png" alt="Techgeo" />
      </h1>
			<navigation />
		</div>
	</aside>
</template>

<script>
import navigation from "./modules/navigation/navigation.vue";

export default {

  name: 'sidebar',

  data () {
    return {

    }
  },
  components: {
  	navigation
  }
};
</script>

<style lang="sass">
@import './sass/_sidebar'
</style>