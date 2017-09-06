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
                    <div v-show="invoice === ''" class="text-center">
                        <i class="fa fa-circle-o-notch fa-spin fa-3x fa-fw"></i><span class="sr-only">Loading...</span>
                    </div>
                    <div v-html="invoice"></div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-link" @click.prevent="edit">Edit Invoice</button>
                    <button type="button" class="btn btn-secondary" @click.prevent="resend">Resend Email</button>
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
        },
        methods: {
            resend() {
                axios.get('/invoices/' + self.order.invoice.id + '/resend')
                    .then(function() {
                        alert('Email sent!');
                    });
            },
            edit() {
                $('#viewInvoiceModal').modal('hide');

                this.eventHub.$emit('showInvoiceForm', 'edit');
            }
        }
    }
</script>