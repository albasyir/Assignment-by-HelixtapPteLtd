<template>
  <div id="app">
    <v-app id="inspire">
      <v-app id="inspire">
        <v-navigation-drawer v-model="drawer" app>
          <v-list dense>
            <v-list-item link>
              <v-list-item-action>
                <v-icon>mdi-home</v-icon>
              </v-list-item-action>
              <v-list-item-content>
                <v-list-item-title>Home</v-list-item-title>
              </v-list-item-content>
            </v-list-item>
          </v-list>
        </v-navigation-drawer>

        <v-app-bar app color="indigo" dark>
          <v-app-bar-nav-icon @click.stop="drawer = !drawer"></v-app-bar-nav-icon>
          <v-toolbar-title>Application</v-toolbar-title>
        </v-app-bar>

        <v-content>
          <v-container class="fill-height" fluid>
            <v-row align="center" justify="center">
              <v-col class="text-center">
                <h1>Token Checker</h1>

                <!-- Token Displayer Here -->
                <div
                  v-for="(token, key) in public_tokens"
                  :key="key"
                >{{ token.string }} - {{ token.expire }}</div>
              </v-col>
            </v-row>
          </v-container>
        </v-content>
        <v-footer color="indigo" app>
          <span class="white--text">Hai</span>
        </v-footer>
      </v-app>
    </v-app>
  </div>
</template>

<script>
export default {
  data: () => ({
    drawer: true,
    public_tokens: []
  }),

  methods: {
    startUp() {
      // Open plaid login
      this.$store.dispatch("openPlaid", () => {
        this.streamExample();
      });
    },

    streamExample() {
      // Open Chennel
      this.$store.dispatch("startPlaidStream");

      // Start Stram
      this.$store.dispatch("streamExample", e => {
        this.public_tokens.push({
          string: e.updated.public_token,
          expire: e.updated.expiration
        });
      });
    }
  },

  mounted: function() {
    this.startUp();
  }
};
</script>
