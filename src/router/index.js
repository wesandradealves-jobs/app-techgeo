import Vue from 'vue';
import Router from 'vue-router';
import NProgress from "nprogress";
import "../../node_modules/nprogress/nprogress.css";

const login = resolve => require(["@/views/login/login.vue"], resolve);
const dashboard = resolve => require(["@/views/dashboard/dashboard.vue"], resolve);
const minha_conta = resolve => require(["@/views/minha-conta/minha-conta.vue"], resolve);
const meus_produtos = resolve => require(["@/views/meus-produtos/meus-produtos.vue"], resolve);
const PageNotFound = resolve => require(["@/views/PageNotFound/PageNotFound.vue"], resolve);
const single = resolve => require(["@/views/single/single.vue"], resolve);

Vue.use(Router);

const router = new Router({
  mode: "history",
  base: process.env.BASE_URL,
  linkActiveClass: "current",
  routes: [
    {
      path: "*",
      name: "PageNotFound",
      component: PageNotFound,
      meta: {
        slug: "page-not-found",
        title: "Techgeo - Página não encontrada"
      }
    },
    {
      path: "/",
      name: "Login",
      component: login,
      meta: {
        slug: "login",
        title: "Techgeo - Login"
      },
      props: true
    },
    {
      path: "/dashboard",
      name: "Dashboard",
      component: dashboard,
      meta: {
        slug: "dashboard",
        title: "Techgeo - Dashboard"
      },
      props: true,
      children: [
        {
          path: "/minha-conta",
          component: minha_conta,
          name: "Minha Conta",
          meta: {
            slug: "minha-conta",
            title: "Techgeo - Dashboard | Minha Conta"
          },
          props: true
        },
        {
          path: "/meus-produtos",
          name: "meus-produtos",
          component: meus_produtos,
          name: "Meus Produtos",
          meta: {
            slug: "meus-produtos",
            title: "Techgeo - Dashboard | Meus Produtos"
          },
          children: [
            {
              path: "/meus-produtos/:id",
              component: single,
              meta: {
                slug: "single",
                title: "Techgeo - Dashboard | Meus Produtos",
              },
              props: true
            }    
          ],
          props: true 
        }
      ]
    }
  ]
});

router.beforeResolve((to, from, next) => {
  if(to.name) {
    NProgress.start()
  }

  const nearestWithTitle = to.matched
    .slice()
    .reverse()
    .find(r => r.meta && r.meta.title);

  const nearestWithMeta = to.matched
    .slice()
    .reverse()
    .find(r => r.meta && r.meta.metaTags);

  if (nearestWithTitle) document.title = nearestWithTitle.meta.title;
  Array.from(document.querySelectorAll("[data-vue-router-controlled]")).map(
    el => el.parentNode.removeChild(el)
  );

  if (!nearestWithMeta) return next();
  nearestWithMeta.meta.metaTags
    .map(tagDef => {
      const tag = document.createElement("meta");

      Object.keys(tagDef).forEach(key => {
        tag.setAttribute(key, tagDef[key]);
      });
      tag.setAttribute("data-vue-router-controlled", "");
      return tag;
    })
    .forEach(tag => document.head.appendChild(tag));

    next();
});

router.afterEach((to, from) => {
    NProgress.done()
});

export default router;