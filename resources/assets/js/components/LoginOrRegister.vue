<template>
    <div class="modal fade" id="loginOrRegisterModal" tabindex="-1" role="dialog">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span
                            aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title">Please Login or Create and Account</h4>
                </div>
                <div class="modal-body">

                    <div class="row">
                        <form class="col-md-6 form-horizontal" @submit.prevent="login">
                            <h3>Login</h3>
                            <div class="form-group" :class="{'has-error': loginForm.errors.has('email')}">
                                <label for="email" class="col-md-4 control-label">E-Mail Address</label>

                                <div class="col-md-8">
                                    <input id="email" type="email" class="form-control" name="email"
                                           v-model="loginForm.email">

                                    <span class="help-block" v-show="loginForm.errors.has('email')">
                                        {{ loginForm.errors.get('email') }}
                                    </span>
                                </div>
                            </div>

                            <div class="form-group" :class="{'has-error': loginForm.errors.has('password')}">
                                <label for="password" class="col-md-4 control-label">Password</label>

                                <div class="col-md-8">
                                    <input id="password" type="password" class="form-control" name="password"
                                           v-model="loginForm.password">

                                    <span class="help-block" v-show="loginForm.errors.has('password')">
                                        {{ loginForm.errors.get('password') }}
                                    </span>
                                </div>
                            </div>

                            <div class="form-group">
                                <div class="col-md-8 col-md-offset-4">
                                    <div class="checkbox">
                                        <label>
                                            <input type="checkbox" name="remember" v-model="loginForm.remember">
                                            Remember Me
                                        </label>
                                    </div>
                                </div>
                            </div>

                            <div class="form-group">
                                <div class="col-md-8 col-md-offset-4">
                                    <button type="submit" class="btn btn-primary">
                                        <i class="fa fa-btn fa-sign-in"></i> Login
                                    </button>
                                </div>
                            </div>
                        </form>
                        <form class="col-md-6 form-horizontal" @submit.prevent="register">
                            <h3>Register</h3>

                            <div class="form-group" :class="{'has-error': registrationForm.errors.has('name')}">
                                <label for="name" class="col-md-4 control-label">Name</label>

                                <div class="col-md-8">
                                    <input id="name" type="text" class="form-control" name="name"
                                           v-model="registrationForm.name">

                                    <span class="help-block" v-show="registrationForm.errors.has('name')">
                                        {{ registrationForm.errors.get('name') }}
                                    </span>
                                </div>
                            </div>

                            <div class="form-group" :class="{'has-error': registrationForm.errors.has('email')}">
                                <label for="email" class="col-md-4 control-label">E-Mail Address</label>

                                <div class="col-md-8">
                                    <input id="regsiter_email" type="email" class="form-control" name="email"
                                           v-model="registrationForm.email">

                                    <span class="help-block" v-show="registrationForm.errors.has('email')">
                                        {{ registrationForm.errors.get('email') }}
                                    </span>
                                </div>
                            </div>

                            <div class="form-group" :class="{'has-error': registrationForm.errors.has('password')}">
                                <label for="password" class="col-md-4 control-label">Password</label>

                                <div class="col-md-8">
                                    <div class="input-group">
                                        <input id="register_password" type="password" class="form-control"
                                               name="password" v-model="registrationForm.password">
                                        <span class="input-group-addon" data-container="body" data-toggle="popover"
                                              data-placement="top"
                                              title="Password Requirements"
                                              data-content="Your password must be at least 8 characters in length, with at least 3 of 4 of the following: upper case letter, lower case letter, number, or special character.">
                                                <i class="fa fa-info"></i></span>
                                    </div>
                                    <span class="help-block" v-show="registrationForm.errors.has('password')">
                                        {{ registrationForm.errors.get('password') }}
                                    </span>
                                </div>
                            </div>

                            <div class="form-group"
                                 :class="{'has-error': registrationForm.errors.has('password_confirmation')}">
                                <label for="password-confirm" class="col-md-4 control-label">Confirm Password</label>

                                <div class="col-md-8">
                                    <input id="password-confirm" type="password" class="form-control"
                                           name="password_confirmation"
                                           v-model="registrationForm.password_confirmation">

                                    <span class="help-block"
                                          v-show="registrationForm.errors.has('password_confirmation')">
                                        {{ registrationForm.errors.get('password_confirmation') }}
                                    </span>
                                </div>
                            </div>

                            <div class="form-group">
                                <div class="col-md-8 col-md-offset-4">
                                    <button type="submit" class="btn btn-primary">
                                        <i class="fa fa-btn fa-user"></i> Create an Account
                                    </button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
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