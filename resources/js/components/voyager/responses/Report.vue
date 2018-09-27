<template>
    <div class="report">
        <form class="form-inline" @submit.prevent="generate">
            <div class="form-group">
                <label class="sr-only" for="type">Question</label>
                <select v-model="form.type" id="type" class="form-control" style="min-width: 150px;">
                    <option value="bar">Bar</option>
                    <option value="pie">Pie</option>
                </select>
            </div>
            <div class="form-group">
                <label class="sr-only" for="question">Question</label>
                <select v-model="form.question" id="question" class="form-control" style="max-width: 250px;">
                    <option v-for="field in fields" :value="field.id">{{ field.question }}</option>
                </select>
            </div>
            <button type="submit" class="btn btn-default">Generate Report</button>
        </form>

        <div class="report-area"></div>
    </div>
</template>

<script>
    export default {
        props: ['survey'],
        data() {
            return {
                form: new SparkForm({
                    type: 'pie',
                    question: ''
                })
            }
        },
        methods: {
            generate() {
                Spark.post('/admin/surveys/' + this.survey.id + '/responses/report', this.form)
                    .then(response => {
                        console.log(response);
                    });
            }
        },
        computed: {
            fields() {
                return this.survey.form.filter(function (field) {
                    if(field.type !== 'section' && field.type !== 'textarea') {
                        return field;
                    }
                })
            }
        }
    }
</script>