<template>
    <form action="" @submit.prevent="submit">
        <div class="row form-group">
            <label for="old-password" class="col-md-3 col-form-label">Old Password</label>
            <div class="col-md-8">
                <input id="old-password" type="password" class="form-control"
                       :class="{'is-invalid': form.errors.has('old_password')}"
                       v-model="form.old_password">
                <span class="invalid-feedback" v-show="form.errors.has('old_password')">
                    {{ form.errors.get('old_password') }}
                </span>
            </div>
        </div>
        <div class="row form-group">
            <label for="password" class="col-md-3 col-form-label">Password</label>

            <div class="col-md-8">
                <div class="input-group">
                    <input id="password" type="password" class="form-control"
                           :class="{'is-invalid': form.errors.has('password')}"
                           v-model="form.password">
                    <span class="input-group-addon" data-container="body" data-toggle="popover"
                          data-placement="top" title="Password Requirements"
                          data-content="Your password must be at least 8 characters in length, with at least 3 of 4 of the following: upper case letter, lower case letter, number, or special character.">
                        <i class="fa fa-info"></i>
                    </span>
                </div>
                <span class="invalid-feedback" :class="{'show': form.errors.has('password')}">
                    {{ form.errors.get('password') }}
                </span>
            </div>
        </div>
        <div class="row form-group">
            <label for="password-confirm" class="col-md-3 col-form-label">Confirm Password</label>

            <div class="col-md-8">
                <input id="password-confirm" type="password" class="form-control" name="password_confirmation"
                       :class="{'is-invalid': form.errors.has('password_confirmation')}"
                       v-model="form.password_confirmation">
                <span class="invalid-feedback" v-show="form.errors.has('password_confirmation')">
                    {{ form.errors.get('password_confirmation') }}
                </span>
            </div>
        </div>
        <div class="form-group row">
            <div class="col-md-9 ml-auto">
                <div class="alert alert-success alert-dismissible fade show" role="alert" v-show="form.successful">
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                    Successfully updated password
                </div>
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
                        this.form.old_password = '';
                        this.form.password = '';
                        this.form.password_confirmation = '';
                    })
                    .catch(response => {

                    })
            }
        }
    }
</script>