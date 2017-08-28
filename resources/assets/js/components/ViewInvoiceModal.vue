<template>
    <div class="modal fade" id="viewInvoiceModal" tabindex="-1" role="dialog">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">View Invoice</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span
                            aria-hidden="true">&times;</span></button>
                </div>
                <div class="modal-body">
                    <div v-html="invoice"></div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-primary" @click.prevent="create">Save</button>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
    export default {
        data() {
            return {
                order_id: '',
                invoice: '',
            }
        },
        created() {
            self = this;
            this.eventHub.$on('showViewInvoice', function (id) {
                $('#viewInvoiceModal').modal('show');
                self.order_id = id;

                axios.get('/orders/' + id + '/invoices')
                    .then(function (response) {
                        self.invoice = response.data.invoice;
                    });
            });
        }
    }
</script>