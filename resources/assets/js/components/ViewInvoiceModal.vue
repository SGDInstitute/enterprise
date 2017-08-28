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
                    <a :href="'/invoices/' + order.invoice.id + '/download'" class="btn btn-primary">Download</a>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
    export default {
        props: ['order'],
        data() {
            return {
                invoice: '',
            }
        },
        created() {
            self = this;
            this.eventHub.$on('showViewInvoice', function () {
                $('#viewInvoiceModal').modal('show');

                axios.get('/invoices/' + self.order.invoice.id)
                    .then(function (response) {
                        self.invoice = response.data.invoice;
                    });
            });
        }
    }
</script>