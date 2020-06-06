window._ = require("lodash");

/**
 * We'll load the axios HTTP library which allows us to easily issue requests
 * to our Laravel back-end. This library automatically handles sending the
 * CSRF token as a header based on the value of the "XSRF" token cookie.
 */

window.axios = require("./plugin/Axios.js").default;

/**
 * Vue Js
 */
import Vue from "vue";
import Template from "./layout/default.vue";

import store from "./store/index.js";
import vuetify from "./plugin/Vuetify.js";

window.Vue = new Vue({
    el: "#app",
    render: h => h(Template),
    store,
    vuetify
});
