<template>
    <form action="">
        <div class="form-group row">
            <label for="name" class="col-md-3 col-form-label">Name*</label>
            <div class="col-md-8">
                <input type="text" class="form-control" id="name" v-model="form.user.name">
            </div>
        </div>
        <div class="form-group row">
            <label for="email" class="col-md-3 col-form-label">Email*</label>
            <div class="col-md-8">
                <input type="email" class="form-control" id="email" v-model="form.user.email">
            </div>
        </div>
        <div class="form-group row">
            <label for="pronouns" class="col-md-3 col-form-label">Pronouns</label>
            <div class="col-md-8">
                <input type="text" class="form-control" id="pronouns" v-model="form.profile.pronouns">
            </div>
        </div>
        <div class="form-group row">
            <label for="sexuality" class="col-md-3 col-form-label">Sexuality</label>
            <div class="col-md-8">
                <input type="text" class="form-control" id="sexuality" v-model="form.profile.sexuality">
            </div>
        </div>
        <div class="form-group row">
            <label for="gender" class="col-md-3 col-form-label">Gender</label>
            <div class="col-md-8">
                <input type="text" class="form-control" id="gender" v-model="form.profile.gender">
            </div>
        </div>
        <div class="form-group row">
            <label for="race" class="col-md-3 col-form-label">Race</label>
            <div class="col-md-8">
                <input type="text" class="form-control" id="race" v-model="form.profile.race">
            </div>
        </div>
        <div class="form-group row">
            <label for="college" class="col-md-3 col-form-label">College</label>
            <div class="col-md-8">
                <input type="text" class="form-control" id="college" v-model="form.profile.college">
            </div>
        </div>
        <div class="form-group row">
            <label for="tshirt" class="col-md-3 col-form-label">T-Shirt Size</label>
            <div class="col-md-8">
                <input type="text" class="form-control" id="tshirt" v-model="form.profile.tshirt">
            </div>
        </div>
        <div class="form-group row">
            <label for="accommodation" class="col-md-3 col-form-label">Accommodation</label>
            <div class="col-md-8">
                <textarea class="form-control" id="accommodation" v-model="form.profile.accommodation"></textarea>
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
        props: ['user', 'profile'],
        data() {
            return {
                form: new SparkForm({
                    profile: {
                        pronouns: '',
                        sexuality: '',
                        gender: '',
                        race: '',
                        college: '',
                        tshirt: '',
                        accommodation: '',
                    },
                    user: {
                        name: '',
                        email: ''
                    }
                })
            }
        },
        created() {
            this.form.user.name = this.user.name;
            this.form.user.email = this.user.email;
            this.form.profile.pronouns = this.profile.pronouns;
            this.form.profile.sexuality = this.profile.sexuality;
            this.form.profile.gender = this.profile.gender;
            this.form.profile.race = this.profile.race;
            this.form.profile.college = this.profile.college;
            this.form.profile.tshirt = this.profile.tshirt;
            this.form.profile.accommodation = this.profile.accommodation;
        },
        methods: {
            submit() {

            }
        }
    }
</script>