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
                                    <option value="accessability">Accessability</option>
                                    <option value="tshirt">T-shirt</option>
                                    <option value="orders">Orders</option>
                                </select>
                            </div>
                            <button type="submit" class="btn btn-default">Run Report</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-body"></div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
export default {
    data() {
        return {
            form: new SparkForm({
                report: ''
            })
        }
    },
    methods: {
        run() {
            Spark.post('/admin/reports/' + this.form.report + '/run');
        }
    }
}
</script>
