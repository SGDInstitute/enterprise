<template>
    <div class="modal fade" id="viewReceiptModal" tabindex="-1" role="dialog">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">View Receipt</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span
                            aria-hidden="true">&times;</span></button>
                </div>
                <div class="modal-body">
                    <div v-show="receipt === ''" class="text-center">
                        <i class="fa fa-circle-o-notch fa-spin fa-3x fa-fw"></i><span class="sr-only">Loading...</span>
                    </div>
                    <div v-html="receipt"></div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" @click.prevent="resend">Resend Email</button>
                    <a :href="'/orders/' + order.id + '/receipt/download'" class="btn btn-primary">Download</a>
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
                receipt: '',
            }
        },
        created() {
            self = this;
            this.eventHub.$on('showViewReceipt', function () {
                $('#viewReceiptModal').modal('show');

                axios.get('/orders/' + self.order.id + '/receipt')
                    .then(function (response) {
                        self.receipt = response.data.receipt;
                    });
            });
        },
        methods: {
            resend() {
                axios.get('/orders/' + self.order.id + '/receipt/resend')
                    .then(function() {
                        alert('Email sent!');
                    });
            }
        }
    }
</script>