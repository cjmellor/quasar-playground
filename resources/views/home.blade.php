<!DOCTYPE html>
<html lang="en">
<head>
    <link href="https://use.fontawesome.com/releases/v5.0.13/css/all.css" rel="stylesheet" type="text/css">
    <link href="https://cdn.jsdelivr.net/npm/quasar@1.14.3/dist/quasar.min.css" rel="stylesheet" type="text/css">
    <link href="https://unpkg.com/tailwindcss@^1.0/dist/tailwind.min.css" rel="stylesheet">
    <title>Quasar Playground</title>
</head>

<body>
<div id="q-app">
    <q-layout view="hHh lpR fFf">

        <q-header elevated class="text-white bg-primary">
            <q-toolbar>
                <q-toolbar-title>
                    <q-avatar>
                        <img alt="derp" src="https://cdn.quasar.dev/logo/svg/quasar-logo.svg">
                    </q-avatar>
                    Quasar/Laravel Playground Testing
                </q-toolbar-title>
            </q-toolbar>
        </q-header>

        <q-page-container>
            <q-page class="bg-gray-100" padding>

                <div class="flex items-center justify-center px-4 py-12 bg-gray-50 sm:px-6 lg:px-8">
                    <div class="w-full max-w-md">

                        {{-- Will show a login form if not logged in --}}
                        <q-form @submit="login" action="{{ route('login') }}" autofocus class="mt-8" method="POST" v-if="!auth">
                            @csrf
                            <input type="hidden" name="remember" value="true">
                            <div class="rounded-md shadow-sm">
                                <div>
                                    <q-input aria-label="Email address" outlined
                                             placeholder="Email address" required
                                             type="email" v-model="formData.email"
                                    ></q-input>
                                </div>
                                <div class="mt-2">
                                    <q-input :type="isPwd ? 'password' : 'text'" outlined placeholder="Password" required v-model="formData.password">
                                        <template v-slot:append>
                                            <q-icon :name="isPwd ? 'fas fa-eye-slash' : 'fas fa-eye'"
                                                    @click="isPwd = !isPwd"
                                                    class="cursor-pointer"
                                                    size="16px"></q-icon>
                                        </template>
                                    </q-input>
                                </div>
                            </div>

                            <div class="mt-6">
                                <q-btn
                                    class="relative flex justify-center w-full px-4 py-2 text-sm font-medium leading-5 text-white transition duration-150 ease-in-out bg-blue-600 border border-transparent rounded-md group hover:bg-blue-500 focus:outline-none focus:border-blue-700 focus:shadow-outline-blue active:bg-blue-700"
                                    label="Sign In"
                                    type="submit">
                                    <span class="absolute inset-y-0 left-0 flex items-center pl-3">
                                        <svg class="w-5 h-5 text-blue-500 transition duration-150 ease-in-out group-hover:text-blue-400" fill="currentColor"
                                             viewBox="0 0 20 20">
                                            <path clip-rule="evenodd"
                                                  d="M5 9V7a5 5 0 0110 0v2a2 2 0 012 2v5a2 2 0 01-2 2H5a2 2 0 01-2-2v-5a2 2 0 012-2zm8-2v2H7V7a3 3 0 016 0z"
                                                  fill-rule="evenodd"></path>
                                        </svg>
                                    </span>
                                </q-btn>
                            </div>
                        </q-form>

                        {{-- Else, will show some data --}}
                        <div class="space-y-4" v-else>
                            <q-btn label="Logout" @click="logout"></q-btn>

                            <h2 class="text-lg font-semibold tracking-wide">Xbox</h2>
                            <q-list bordered separator>
                                <q-item clickable v-ripple v-for="game in games.xbox">
                                    <q-item-section>
                                        <q-item-label v-text="game"></q-item-label>
                                    </q-item-section>
                                </q-item>
                            </q-list>

                            <h2 class="text-lg font-semibold tracking-wide">Playstation</h2>
                            <q-list bordered separator>
                                <q-item clickable v-ripple v-for="game in games.playstation">
                                    <q-item-section>
                                        <q-item-label v-text="game"></q-item-label>
                                    </q-item-section>
                                </q-item>
                            </q-list>
                        </div>

                    </div>
                </div>

            </q-page>
        </q-page-container>

    </q-layout>
</div>

<!-- Add the following at the end of your body tag -->
<script src="{{ mix('js/app.js') }}"></script>
<script src="https://cdn.jsdelivr.net/npm/vue@^2.0.0/dist/vue.js"></script>
<script src="https://cdn.jsdelivr.net/npm/quasar@1.14.3/dist/quasar.umd.modern.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/quasar@1.14.3/dist/lang/en-gb.umd.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/quasar@1.14.3/dist/icon-set/fontawesome-v5.umd.min.js"></script>

<script>
    Quasar.lang.set(Quasar.lang.enGb)
    Quasar.iconSet.set(Quasar.iconSet.fontawesomeV5)

    new Vue({
        el: '#q-app',
        data: function () {
            return {
                auth: false,
                formData: {
                    email: '',
                    password: '',
                },
                games: {},
                isPwd: true,
            }
        },
        methods: {
            getGames () {
                axios.get('/api/games')
                    .then(response => {
                        this.games = response.data
                    })
            },
            login () {
                axios.post('/login', this.formData)
                    .then(() => {
                        this.auth = true

                        this.notify('positive', 'You have logged in!')
                    })
                    .catch(() => {
                        this.notify('negative', 'Credentials are incorrect :(')
                    })
            },
            logout () {
                axios.get('/logout')
                    .then(() => {
                        this.auth = false

                        this.notify('positive', 'Logged Out', 'top')
                    })
            },
            notify (type, message, position = 'bottom') {
                this.$q.notify({
                    type: type,
                    message: message,
                    position: position,
                })
            },
        },
        mounted () {
            this.getGames()
        },
    })
</script>
</body>
</html>
