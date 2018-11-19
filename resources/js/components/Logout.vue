<template>
    <transition name="modal">
        <div class="modal modal-overlay" @click.self="$emit('changeLogout')">
        <div class="modal-window">
            <div class="modal-content">
                <p v-if="logoutResult">You are logged out!</p>
                <p v-else-if="!logoutResult" class="text-danger">Log out function was failed!</p>
            </div>
        </div>
        </div>
    </transition>
</template>

<style scoped>
.modal.modal-overlay {
    display: flex;
    align-items: center;
    justify-content: center;
    position: fixed;
    z-index: 30;
    top: 0;
    left: 0;
    width: 100%;
    height: 100%;
    background: rgba(0, 0, 0, 0.5);
}
.modal-window {
    background: #fff;
    border-radius: 4px;
    overflow: hidden;
}
.modal-content {
    padding: 40px 40px;
}

/* animation */
.modal-enter-active, .modal-leave-active {
  transition: opacity 0.4s;
}
.modal-enter-active, .modal-leave-active .modal-window {
    transition: opacity 0.4s, transform 0.4s;
}
.modal-leave-active {
  transition: opacity 0.6s ease 0.4s;
}
.modal-enter, .modal-leave-to {
  opacity: 0;
}
.modal-enter, .modal-leave-to .modal-window {
opacity: 0;
transform: translateY(-20px);
}
</style>

<script>
import userStore from '../userStore.js'
export default {
    mounted() {
        userStore.logout(res => {
            this.logoutResult = true;
            }, error => {
                this.logoutResult = false
                });
    },
    data() {
        return {
            logoutResult: true
        }
    }
}
</script>

