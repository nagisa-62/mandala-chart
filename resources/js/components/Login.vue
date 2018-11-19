<template>
    <transition name="modal">
        <div class="modal modal-overlay" @click.self="$emit('changeLogin')">
            <div class="modal-window">
                <div class="modal-header"><h3>Login</h3></div>
                <div class="modal-content">
                    <div class="form-group">
                        <label for="exampleInputEmail1">Email address</label>
                        <input type="email" class="form-control" id="exampleInputEmail1" aria-describedby="emailHelp" placeholder="Enter email" v-model="form.email">
                        <small id="emailHelp" class="form-text text-muted">We'll never share your email with anyone else.</small>
                    </div>
                    <div class="form-group">
                        <label for="exampleInputPassword1">Password</label>
                        <input type="password" class="form-control" id="exampleInputPassword1" placeholder="Password" v-model="form.password">
                    </div>
                    <div class="alert alert-danger" v-if="validationAlert">
                        {{ alertMessage }}
                    </div>
                    <button class="btn btn-outline-primary" @click="login">Login</button>
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
    padding: 10px 20px;
}
.modal-header {
    background: #5f27cd;
    padding: 10px;
    text-align: right;
    color: #fff;
}
.btn {
    float: right;
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
    data() {
        return {
            form: {
                email: "",
                password: ""
            },
            validationAlert: false,
            alertMessage: ""
        }
    },
    methods: {
        login() {
            if (!this.form.email || !this.form.password) {
                this.validationAlert = true;
                this.alertMessage = "input field is empty";
            }
            else {
                userStore.login(this.form.email, this.form.password, res => {
                    this.$emit('changeLogin');
                }, error => {
                    this.validationAlert = true
                    this.alertMessage = 'Wrong email or password.'
                })
            }
      }
    }
}
</script>

