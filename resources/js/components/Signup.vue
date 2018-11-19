<template>
    <transition name="modal">
        <div class="modal modal-overlay" @click.self="$emit('changeSignup')">
            <div class="modal-window">
                <div class="modal-header"><h3>Sign up</h3></div>
                <div class="modal-content">
                    <div class="form-group row">
                        <label for="formGroupExampleInput" class="col-sm-3 col-form-label">Name</label>
                        <div class="col-sm-9">
                            <input type="text" v-model="form.Name" class="form-control" id="formGroupExampleInput" placeholder="Enter your name">
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="exampleInputEmail1" class="col-sm-3 col-form-label">Email address</label>
                        <div class="col-sm-9">
                            <input type="email" v-model="form.Email" class="form-control" id="exampleInputEmail1" aria-describedby="emailHelp" placeholder="Enter email">
                        <small id="emailHelp" class="form-text text-muted">We'll never share your email with anyone else.</small>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="exampleInputPassword1" class="col-sm-3 col-form-label">Password</label>
                        <div class="col-sm-9">
                            <input type="password" v-model="form.Password" class="form-control" id="exampleInputPassword1" placeholder="Password">
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="exampleInputPassword1" class="col-sm-3 col-form-label">Confirm Password</label>
                        <div class="col-sm-9">
                            <input type="password" v-model="form.Confirm_Password" class="form-control" id="exampleInputPassword1" placeholder="Password again">
                        </div>
                    </div>
                    <div>
                        <div class="alert alert-danger float-right col-sm-8" v-if="validationAlert">
                            <div v-for="errorMessage in errorMessageArray" :key="errorMessage">
                                {{ errorMessage }}
                            </div>
                        </div>
                        <div class="alert alert-success float-right col-sm-8" v-if="signupSuccessAlert">
                            Sign up Successfully!
                        </div>
                    </div>
                    <div>
                        <button class="btn btn-outline-primary float-right" @click="signup">Create New User</button>
                    </div>
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
        width: 50%;
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
                Name: "",
                Email: "",
                Password: "",
                Confirm_Password: ""
            },
            errorMessageArray: [],
            validationAlert: false,
            signupSuccessAlert: false
        }
    },
    methods: {
        signup() {
            if (!this.formValidation()) {
                userStore.signup(this.form.Name, this.form.Email, this.form.Password, res => {
                    this.signupSuccessAlert = true;
                    setTimeout(() => {
                        this.$emit('changeSignup');
                    }, 1500);
                }, error => {
                    this.validationAlert = true;
                    let errors = error.response.data.errors
                        for(let key in errors) {
                            for(let value of errors[key]) {
                                this.errorMessageArray.push(value);
                            }
                        }
                });
            }
        },

        formValidation() {
            this.errorMessageArray = [];
            this.validationAlert = false;

            for (let key in this.form) {
                if (!this.form[key]) {
                    this.errorMessageArray.push(key+" is empty");
                    this.validationAlert = true;
                }
            }

            if (this.form.Password != this.form.Confirm_Password) {
                this.errorMessageArray.push("Confirm password doesn't match with password");
                this.validationAlert = true;
            }

            let mailRE = /^[a-zA-Z0-9.!#$%&'*+\/=?^_`{|}~-]+@[a-zA-Z0-9-]+(?:\.[a-zA-Z0-9-]+)*$/
            if (mailRE.test(this.Email)) {
                this.errorMessageArray.push("Email format is wrong");
                this.validationAlert = true;
            }

            return this.validationAlert;
        }
    }
}
</script>

