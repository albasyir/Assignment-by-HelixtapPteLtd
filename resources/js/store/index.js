import Vuex from "vuex";
import Vue from "vue";
import Echo from "../plugin/Echo.js";

Vue.use(Vuex);

export default new Vuex.Store({
    state: {
        plaid: {
            channel_token: null,
            public_token: null,
            handler: null,
            channel: null
        }
    },

    mutations: {
        plaidHandler({ plaid }, payload) {
            plaid.handler = payload;
        },

        plaidOpen({ plaid }) {
            plaid.handler.open();
        },

        setPlaidPublicToken({ plaid }, public_token) {
            plaid.public_token = public_token;
        },

        setChannelToken({ plaid }, channel_token) {
            plaid.channel_token = channel_token;
        },

        setChannelHendler({ plaid }, payload) {
            plaid.channel = payload;
        }
    },

    actions: {
        streamExample({ state }, callback) {
            state.plaid.channel.listen(".UpdateExample", callback);
            console.log("listening now");
        },

        startPlaidStream({ state }) {
            this.commit(
                "setChannelHendler",
                Echo.channel(`plaid.${state.plaid.channel_token}`)
            );
        },

        async exchangeToken({ state, dispatch }, public_token) {
            await axios
                .post("/test", { public_token: public_token })
                .catch(e => {
                    console.error(e);
                })
                .then(res => {
                    this.commit("setChannelToken", res.data.channels_key);
                });
        },

        async openPlaid({ state, dispatch }, callback) {
            if (state.plaid.handler) {
                this.commit("plaidOpen");
                return;
            }

            const plaid = await Plaid.create({
                clientName: "Helixtap Assignment",

                env: "sandbox",

                // Replace with your public_key from the Dashboard
                key:
                    process.env.PLAID_PUBLIC_KEY ||
                    "f89978fe2a18ec401f12a13b290e49",

                product: ["transactions"],

                // Optional, use webhooks to get transaction and error updates
                // webhook: "localhost:8000/test",

                // Optional, specify a language to localize Link
                language: "en",

                onLoad: function() {
                    // Optional, called when Link loads
                },

                onSuccess: async (public_token, metadata) => {
                    await dispatch("exchangeToken", public_token);
                    callback();
                },

                onExit: function(err, metadata) {
                    if (err != null) {
                        console.error(err);
                    }
                }
            });

            this.commit("plaidHandler", plaid);
            await dispatch("openPlaid");
        }
    }
});
