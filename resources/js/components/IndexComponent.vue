<template> 
    <div>
        <app-header></app-header>
        <div class="container-fluid">
            <transition name="slide" mode="out-in">
                <router-view></router-view>
            </transition>
        </div>
        <app-footer v-if="userStore.state.authenticated && this.$route.path == '/'"></app-footer>
    </div>
</template>

<style>
.row {
    margin-top: 5px;
    clear: right;
}
table {
    table-layout: fixed;
    word-break: break-word;
    word-wrap: break-word;
}
td {
height: 60px; 
padding:0 !important;
margin:0 !important;
}

/* animation */
.slide-enter-active {
    animation: slide-in 200ms ease-out forwards;
}

.slide-leave-active {
    animation: slide-out 200ms ease-out forwards;

}

@keyframes slide-in {
    from {
        transform: translateY(30px);
        opacity: 0;
    }
    to {
        transform: translateY(0);
        opacity: 1;
    }
}

@keyframes slide-out {
    from {
        transform: translateY(0);
        opacity: 1;
    }
    to {
        transform: translateY(30px);
        opacity: 0;
    }
}
</style>

<script>
import Header from './Header.vue'
import Footer from './Footer.vue'
import dataStore from '../dataStore.js'
import userStore from '../userStore.js'
export default {
    mounted() {
        userStore.init();
        dataStore.currentDataInit();
    },
    data() {
        return {
            userStore: userStore,
            }
    },
    components: {
        appHeader: Header,
        appFooter: Footer
    }
}
</script>
