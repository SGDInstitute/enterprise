<template>
    <div class="modal fade" id="loginOrRegisterModal" tabindex="-1" role="dialog">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Please Login or Create and Account</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span
                            aria-hidden="true">&times;</span></button>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <form class="col-lg-6" @submit.prevent="login">
                            <h4>Login</h4>
                            <div class="row form-group">
                                <label for="login-modal-email" class="col-md-4 col-form-label">E-Mail</label>

                                <div class="col-md-8">
                                    <input id="login-modal-email" type="email" class="form-control"
                                           :class="{'is-invalid': loginForm.errors.has('email')}" name="email"
                                           v-model="loginForm.email">

                                    <span class="invalid-feedback" v-show="loginForm.errors.has('email')">
                                        {{ loginForm.errors.get('email') }}
                                    </span>
                                </div>
                            </div>

                            <div class="row form-group" >
                                <label for="login-form-password" class="col-md-4 col-form-label">Password</label>

                                <div class="col-md-8">
                                    <input id="login-form-password" type="password" class="form-control"
                                           :class="{'is-invalid': loginForm.errors.has('password')}" name="password"
                                           v-model="loginForm.password">

                                    <span class="invalid-feedback" v-show="loginForm.errors.has('password')">
                                        {{ loginForm.errors.get('password') }}
                                    </span>
                                </div>
                            </div>

                            <div class="row form-group">
                                <div class="col-md-8 ml-auto">
                                    <div class="checkbox">
                                        <label>
                                            <input type="checkbox" name="remember" v-model="loginForm.remember">
                                            Remember Me
                                        </label>
                                    </div>
                                </div>
                            </div>

                            <div class="row form-group">
                                <div class="col-md-8 ml-auto">
                                    <button type="submit" class="btn btn-primary">
                                        <i class="fa fa-btn fa-sign-in"></i> Login
                                    </button>
                                </div>
                            </div>
                        </form>
                        <hr>
                        <form class="col-lg-6" @submit.prevent="register">
                            <h4>Create an Account</h4>

                            <div class="row form-group">
                                <label for="register-modal-name" class="col-md-4 col-form-label">Name</label>

                                <div class="col-md-8">
                                    <input id="register-modal-name" type="text" class="form-control"
                                           :class="{'is-invalid': registrationForm.errors.has('name')}" name="name"
                                           v-model="registrationForm.name">

                                    <span class="invalid-feedback" v-show="registrationForm.errors.has('name')">
                                        {{ registrationForm.errors.get('name') }}
                                    </span>
                                </div>
                            </div>

                            <div class="row form-group">
                                <label for="register-modal-email" class="col-md-4 col-form-label">E-Mail</label>

                                <div class="col-md-8">
                                    <input id="register-modal-email" type="email" class="form-control"
                                           :class="{'is-invalid': registrationForm.errors.has('email')}" name="email"
                                           v-model="registrationForm.email">

                                    <span class="invalid-feedback" v-show="registrationForm.errors.has('email')">
                                        {{ registrationForm.errors.get('email') }}
                                    </span>
                                </div>
                            </div>

                            <div class="row form-group">
                                <label for="register-modal-password" class="col-md-4 col-form-label">Password</label>

                                <div class="col-md-8">
                                    <div class="input-group">
                                        <input id="register-modal-password" type="password" class="form-control"
                                               :class="{'is-invalid': registrationForm.errors.has('password')}"
                                               name="password" v-model="registrationForm.password">
                                        <span class="input-group-addon" data-container="body" data-toggle="popover"
                                              data-placement="top"
                                              title="Password Requirements"
                                              data-content="Your password must be at least 8 characters in length, with at least 3 of the following: upper case letter, lower case letter, number, or special character.">
                                                <i class="fa fa-info"></i></span>
                                    </div>
                                    <span class="invalid-feedback" v-show="registrationForm.errors.has('password')">
                                        {{ registrationForm.errors.get('password') }}
                                    </span>
                                </div>
                            </div>

                            <div class="row form-group">
                                <label for="register-modal-password-confirm" class="col-md-4 col-form-label">Confirm Password</label>

                                <div class="col-md-8">
                                    <input id="register-modal-password-confirm" type="password" class="form-control"
                                           :class="{'is-invalid': registrationForm.errors.has('password_confirmation')}"
                                           name="password_confirmation"
                                           v-model="registrationForm.password_confirmation">

                                    <span class="invalid-feedback"
                                          v-show="registrationForm.errors.has('password_confirmation')">
                                        {{ registrationForm.errors.get('password_confirmation') }}
                                    </span>
                                </div>
                            </div>

                            <div class="row form-group">
                                <div class="col-md-8 ml-auto">
                                    <button type="submit" class="btn btn-primary">
                                        <i class="fa fa-btn fa-user"></i> Create an Account
                                    </button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
    export default {
        data() {
            return {
                loginForm: new SparkForm({
                    email: '',
                    password: '',
                    remember: true
                }),
                registrationForm: new SparkForm({
                    name: '',
                    email: '',
                    password: '',
                    password_confirmation: ''
                })
            }
        },
        created() {
            this.eventHub.$on('showLoginRegister', function() {
                $('#loginOrRegisterModal').modal('show');
            });
            this.eventHub.$on('updatedUser', function() {
                $('#loginOrRegisterModal').modal('hide');
            })
        },
        methods: {
            login() {
                Spark.post('/login', this.loginForm)
                    .then(response => {
                        this.eventHub.$emit('updatedUser', response.user);
                    })
                    .catch(response => {
                        console.log('false');
                        if (response.success === false) {
                            alert(response.status);
                        }
                    })
            },
            register() {
                Spark.post('/register', this.registrationForm)
                    .then(response => {
                        this.eventHub.$emit('updatedUser', response.user);
                        $('#showLoginRegisterModal').modal('hide');
                    })
                    .catch(response => {
                        if (response.success === false) {
                            alert(response.status);
                        }
                    })
            }
        }
    }
</script>