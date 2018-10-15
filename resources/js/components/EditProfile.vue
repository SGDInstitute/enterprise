<template>
    <form action="" @submit.prevent="submit">
        <div class="form-group row">
            <label for="name" class="col-md-3 col-form-label">Name*</label>
            <div class="col-md-8">
                <input type="text" class="form-control" id="name"
                       :class="{'is-invalid': form.errors.has('name')}"
                       v-model="form.name">
                <span class="invalid-feedback" v-show="form.errors.has('name')">
                    {{ form.errors.get('name') }}
                </span>
            </div>
        </div>
        <div class="form-group row">
            <label for="email" class="col-md-3 col-form-label">Email*</label>
            <div class="col-md-8">
                <input type="email" class="form-control" id="email"
                       :class="{'is-invalid': form.errors.has('email')}"
                       v-model="form.email">
                <span class="invalid-feedback" v-show="form.errors.has('email')">
                    {{ form.errors.get('email') }}
                </span>
            </div>
        </div>
        <div class="form-group row">
            <label for="pronouns" class="col-md-3 col-form-label">Pronouns</label>
            <div class="col-md-8">
                <input type="text" class="form-control" id="pronouns"
                       :class="{'is-invalid': form.errors.has('pronouns')}"
                       v-model="form.pronouns">
                <span class="invalid-feedback" v-show="form.errors.has('pronouns')">
                    {{ form.errors.get('pronouns') }}
                </span>
            </div>
        </div>
        <div class="form-group row">
            <label for="sexuality" class="col-md-3 col-form-label">Sexuality</label>
            <div class="col-md-8">
                <input type="text" class="form-control" id="sexuality"
                       :class="{'is-invalid': form.errors.has('sexuality')}"
                       v-model="form.sexuality">
                <span class="invalid-feedback" v-show="form.errors.has('sexuality')">
                    {{ form.errors.get('sexuality') }}
                </span>
            </div>
        </div>
        <div class="form-group row">
            <label for="gender" class="col-md-3 col-form-label">Gender</label>
            <div class="col-md-8">
                <input type="text" class="form-control" id="gender"
                       :class="{'is-invalid': form.errors.has('gender')}"
                       v-model="form.gender">
                <span class="invalid-feedback" v-show="form.errors.has('gender')">
                    {{ form.errors.get('gender') }}
                </span>
            </div>
        </div>
        <div class="form-group row">
            <label for="race" class="col-md-3 col-form-label">Race</label>
            <div class="col-md-8">
                <input type="text" class="form-control" id="race"
                       :class="{'is-invalid': form.errors.has('race')}"
                       v-model="form.race">
                <span class="invalid-feedback" v-show="form.errors.has('race')">
                    {{ form.errors.get('race') }}
                </span>
            </div>
        </div>
        <div class="form-group row">
            <label for="college" class="col-md-3 col-form-label">College</label>
            <div class="col-md-8">
                <input type="text" class="form-control" id="college"
                       :class="{'is-invalid': form.errors.has('college')}"
                       v-model="form.college">
                <span class="invalid-feedback" v-show="form.errors.has('college')">
                    {{ form.errors.get('college') }}
                </span>
            </div>
        </div>
        <div class="form-group row">
            <label for="tshirt" class="col-md-3 col-form-label">T-Shirt Size</label>
            <div class="col-md-8">
                <input type="text" class="form-control" id="tshirt"
                       :class="{'is-invalid': form.errors.has('tshirt')}"
                       v-model="form.tshirt">
                <span class="invalid-feedback" v-show="form.errors.has('tshirt')">
                    {{ form.errors.get('tshirt') }}
                </span>
            </div>
        </div>
        <div class="form-group row">
            <label for="accommodation" class="col-md-3 col-form-label">Accommodation</label>
            <div class="col-md-8">
                <textarea class="form-control" id="accommodation"
                          :class="{'is-invalid': form.errors.has('accommodation')}"
                          v-model="form.accommodation"></textarea>
                <span class="invalid-feedback" v-show="form.errors.has('accommodation')">
                    {{ form.errors.get('accommodation') }}
                </span>
            </div>
        </div>

        <div class="form-group">
            <div class="row">
                <div class="col-md-9 ml-auto">
                    <div class="form-check pl-4">
                        <label class="form-check-label" for="wants_program">
                        <input class="form-check-input" type="checkbox" name="wants_program" id="wants_program" :value="true" v-model="form.wants_program">
                            I agree to the <a href="/events/mblgtacc-2019" target="_blank">code for inclusion</a>,
                            <a href="/events/mblgtacc-2019" target="_blank">photo policy</a>, and
                            <a href="/events/mblgtacc-2019" target="_blank">refund policy</a>.
                        </label>
                    </div>
                </div>
            </div>
        </div>
        <div class="form-group row">
            <div class="col-md-9 ml-auto">
                <div class="alert alert-success alert-dismissible fade show" role="alert" v-show="form.successful">
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                    Successfully updated profile
                </div>
                <button class="btn btn-primary">Save Profile</button>
            </div>
        </div>
    </form>
</template>

<script>
    export default {
        props: ['user', 'profile'],
        data() {
            return {
                form: new SparkForm({
                    name: '',
                    email: '',
                    pronouns: '',
                    sexuality: '',
                    gender: '',
                    race: '',
                    college: '',
                    tshirt: '',
                    accommodation: '',
                    wants_program: true,
                })
            }
        },
        created() {
            this.form.name = this.user.name;
            this.form.email = this.user.email;
            this.form.pronouns = this.profile.pronouns;
            this.form.sexuality = this.profile.sexuality;
            this.form.gender = this.profile.gender;
            this.form.race = this.profile.race;
            this.form.college = this.profile.college;
            this.form.tshirt = this.profile.tshirt;
            this.form.accommodation = this.profile.accommodation;
            this.form.wants_program = this.profile.wants_program;
        },
        methods: {
            submit() {
                Spark.patch('/profile', this.form);
            }
        }
    }
</script>