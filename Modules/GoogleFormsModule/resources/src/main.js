import './assets/main.css'

import { createApp ,markRaw  } from 'vue'
import { createPinia } from 'pinia'

import App from './App.vue'
import router from './router'
import VueTippy from 'vue-tippy'
import 'tippy.js/dist/tippy.css';



// bootstrap & fontAwesome
import "bootstrap/dist/css/bootstrap.min.css"
 import '@fortawesome/fontawesome-free/css/all.min.css';




const app = createApp(App)
const pinia = createPinia();

pinia.use(({ store }) => {
  store.$router = markRaw(router)
});

app.use(router)

app.use(pinia)

app.use(VueTippy, {
    defaultProps: { placement: 'right' },
  })

app.mount('#app')



import 'bootstrap'; // ✅ happy days

