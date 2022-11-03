import './bootstrap';
import {createApp} from 'vue';
import VueAxios from 'vue-axios';

import App from './App.vue';

const app = createApp(App);

// axios default configs
axios.defaults.baseURL = 'http://localhost/api';
axios.defaults.headers.common['Authorization'] = 'Bearer 1|0fO5Sj4dULPDRjqmsAdnuXCE5J2PSHuUorkYsLIT';
axios.defaults.headers.post['Content-Type'] = 'application/json';
axios.defaults.headers.post['Accept'] = 'application/json';

app.use(VueAxios, axios);
app.mount('#app');
