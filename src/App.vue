 <template>
  <div
    id="wrap"
    :class="[
      ($route.meta.slug !== undefined) ? 'pg-' + $route.meta.slug : '',
      this.$route.meta.slug && this.$route.meta.slug !== 'login' ? 'pg-interna' : ''
    ]"
  >
	<main class="main">
		<transition name="fade" mode="out-in">
		  <router-view />
		</transition>
	</main>
  </div>
</template>
<script>
import Vue from 'vue';
import router from "@/router";
import VueMaterial from 'vue-material';
import NProgress from 'nprogress';
import 'vue-material/dist/vue-material.min.css';
import 'vue-material/dist/theme/default-dark.css';
import '../node_modules/nprogress/nprogress.css';

Vue.use(VueMaterial);

export default {
  name: 'App',
  watch: {
    isLoading(value) {
      if (value) {
        NProgress.start();
      } else {
        NProgress.done();
      }
    }
  },
  mounted() {
    if(sessionStorage.getItem('user')){
      if(this.$router.history.current.meta.slug) {
        this.$router.replace(this.$router.history.current.meta.slug);
      } else {
        this.$router.replace('minha-conta');
      }
    } else {
      this.$router.replace('/');
    }
  },    
  computed: {
    isLoading() {
      return this.$store.state.isLoading;
    }
  },    
};
</script>

<style lang="sass">
@import './_style'
</style>

