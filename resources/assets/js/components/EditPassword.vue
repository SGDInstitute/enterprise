<template>
    <form action="" @submit.prevent="submit">
        <div class="row form-group" :class="{'has-error': form.errors.has('old_password')}">
            <label for="old-password" class="col-md-3 col-form-label">Old Password</label>

            <div class="col-md-8">
                <input id="old-password" type="password" class="form-control" v-model="form.old_password">

                <span class="help-block" v-show="form.errors.has('old_password')">
                    {{ form.errors.get('old_password') }}
                </span>
            </div>
        </div>
        <div class="row form-group" :class="{'has-error': form.errors.has('password')}">
            <label for="password" class="col-md-3 col-form-label">Password</label>

            <div class="col-md-8">
                <div class="input-group">
                    <input id="password" type="password" class="form-control" v-model="form.password">
                    <span class="input-group-addon" data-container="body" data-toggle="popover"
                          data-placement="top" title="Password Requirements"
                          data-content="Your password must be at least 8 characters in length, with at least 3 of 4 of the following: upper case letter, lower case letter, number, or special character.">
                        <i class="fa fa-info"></i>
                    </span>
                </div>
                <span class="help-block" v-show="form.errors.has('password')">
                    {{ form.errors.get('password') }}
                </span>
            </div>
        </div>
        <div class="row form-group" :class="{'has-error': form.errors.has('password_confirmation')}">
            <label for="password-confirm" class="col-md-3 col-form-label">Confirm Password</label>

            <div class="col-md-8">
                <input id="password-confirm" type="password" class="form-control" name="password_confirmation"
                       v-model="form.password_confirmation">

                <span class="help-block" v-show="form.errors.has('password_confirmation')">
                    {{ form.errors.get('password_confirmation') }}
                </span>
            </div>
        </div>
        <div class="form-group row">
            <div class="col-md-9 ml-auto">
                <button class="btn btn-primary">Save Profile</button>
            </div>
        </div>
    </form>
</template>

<script>
    export default {
        data() {
            return {
                form: new SparkForm({
                    old_password: '',
                    password: '',
                    password_confirmation: ''
                })
            }
        },
        methods: {
            submit() {
                Spark.post('/settings/password', this.form)
                    .then(response => {

                    })
                    .catch(response => {

                    })
            }
        }
    }
</script>