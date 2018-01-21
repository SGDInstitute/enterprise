<template>
    <div>
        <div class="row">
            <div class="col-md-6">
                <div class="card">
                    <div class="card-body">
                        <form class="form-inline" @submit.prevent="run">
                            <div class="form-group">
                                <label class="sr-only" for="exampleInputEmail3">Report Type</label>
                                <select name="report" id="report" class="form-control" v-model="form.report">
                                    <option :value="report" :key="report" v-for="report in reports">{{ report }}</option>
                                </select>
                            </div>
                            <button type="submit" class="btn btn-default">Run Report</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
        <div class="row" v-show="reportData" style="margin-top: 2rem;">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-body">
                        <a :href="downloadLink" class="btn btn-default" target="_blank">Download</a>
                        <div v-html="reportData"></div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
export default {
    props: ['reports'],
    data() {
        return {
            form: new SparkForm({
                report: ''
            }),
            reportData: '',
            downloadLink: ''
        }
    },
    methods: {
        run() {
            Spark.post('/admin/reports/' + this.form.report + '/run', this.form)
                .then(response => {
                    this.reportData = response.data.html;
                    this.downloadLink = response.data.download;
                });
        }
    }
}
</script>
