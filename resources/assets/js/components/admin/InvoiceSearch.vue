<template>
    <div class="card">
        <div class="card-header">
            Search By Invoice
        </div>
        <div class="card-body">
            <form @submit.prevent="search">
                <div class="form-group">
                    <label for="invoice">Invoice Number</label>
                    <div class="input-group">
                        <span class="input-group-addon" id="basic-addon1">#</span>
                        <input type="text" class="form-control" id="invoice" name="invoice" v-model="invoice" style="text-align: right;">
                    </div>
                </div>
                <button type="submit" class="btn btn-default">Search</button>
            </form>
        </div>
    </div>
</template>

<script>
    export default {
        data() {
            return {
                invoice: ''
            }
        },
        methods: {
            search() {
                window.location = '/admin/invoices/' + this.invoice;
            }
        }
    }
</script>