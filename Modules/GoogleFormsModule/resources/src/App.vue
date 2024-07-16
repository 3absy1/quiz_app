

<script>
import {  RouterView } from 'vue-router'
import 'vue3-toastify/dist/index.css';

export default{

data(){
    return{
        routeLocation : ""
    }
},

  components:{
    RouterView,
  },

}
</script>

<template>
  <main>
      <RouterView />
  </main>
</template>



<style>

.main{
  height: 100%;
  min-height: 100vh;
  overflow: hidden;
  background-color: #F9F9F9;
}
@media (max-width : 600px) {
  .main {
    width: 100% !important;
    height: 100%;
    min-height: 100vh;
  }
}
a.router-link-exact-active {
  color: #686868;
  text-decoration: none;
  font-weight: bolder;

}

a.router-link-exact-active:focus {
  background-color: transparent;
  font-weight: bolder;
}
/* header {
  line-height: 1.5;
  max-height: 100vh;
}

.logo {
  display: block;
  margin: 0 auto 2rem;
}

nav {
  width: 100%;
  font-size: 12px;
  text-align: center;
  margin-top: 2rem;
}


nav a {
  display: inline-block;
  padding: 0 1rem;
  border-left: 1px solid var(--color-border);
}

nav a:first-of-type {
  border: 0;
}

@media (min-width: 1024px) {
  header {
    display: flex;
    place-items: center;
    padding-right: calc(var(--section-gap) / 2);
  }

  .logo {
    margin: 0 2rem 0 0;
  }

  header .wrapper {
    display: flex;
    place-items: flex-start;
    flex-wrap: wrap;
  }

  nav {
    text-align: left;
    margin-left: -1rem;
    font-size: 1rem;

    padding: 1rem 0;
    margin-top: 1rem;
  }
} */
</style>
