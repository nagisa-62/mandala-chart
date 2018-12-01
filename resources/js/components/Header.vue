<template>
    <div>
        <nav class="navbar navbar-expand-lg navbar-dark">
            <div class="navbar-brand"><b>Mandala Chart</b></div>
            <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNavDropdown" aria-controls="navbarNavDropdown" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNavDropdown">
                <ul class="navbar-nav mr-auto">
                    <li class="nav-item active">
                        <router-link to="/" activeClass="active" tag="div"><a class="nav-link">Home</a></router-link>
                    </li>
                    <li class="nav-item">
                        <router-link to="/howto" activeClass="active" tag="div"><a class="nav-link">How to Use</a></router-link>
                    </li>
                </ul>
                <ul class="navbar-nav">
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" href="#" id="navbarDropdownMenuLink" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        {{ listTitle }}
                        </a>
                        <div class="dropdown-menu dropdown-menu-right" aria-labelledby="navbarDropdownMenuLink">
                        <div class="dropdown-item" @click="changeLogin" v-if="!userStore.state.authenticated">Log in</div>
                        <div class="dropdown-item" @click="changeLogout" v-if="userStore.state.authenticated">Log out</div>
                        <div class="dropdown-item" @click="changeSignup" v-if="!userStore.state.authenticated">Sign up</div>
                        </div>
                    </li>
                </ul>
            </div>
        </nav>
        <app-login v-if="LoginModal" @changeLogin="changeLogin"></app-login>
        <app-logout v-if="LogoutModal" @changeLogout="changeLogout"></app-logout>
        <app-signup v-if="signupModal" @changeSignup="changeSignup"></app-signup>
    </div>
</template>

<style scoped>
    .navbar {
        background-color: #5f27cd;
    }
</style>

<script>
import userStore from '../userStore.js'
import Login from './Login.vue'
import Logout from './Logout.vue'
import Signup from './Signup.vue'
export default {
    data() {
        return {
            LoginModal: false,
            LogoutModal: false,
            signupModal: false,
            userStore: userStore
        }
    },
    computed: {
        listTitle: () => {
            if(userStore.state.authenticated){
                return userStore.state.user.name;
            }
            else {
                return "Log in or Sign up";
            }
        }
    },
    components: {
        AppLogin: Login,
        AppLogout: Logout,
        AppSignup: Signup
    },
    methods: {
        changeLogin() {
            this.LoginModal = !this.LoginModal;
        },
        changeLogout() {
            this.LogoutModal = !this.LogoutModal;
        },
        changeSignup() {
            this.signupModal = !this.signupModal;
        }
    }
}
</script>


 