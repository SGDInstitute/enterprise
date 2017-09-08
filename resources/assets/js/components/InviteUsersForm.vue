<template>
    <div class="modal fade" id="inviteUsers" tabindex="-1" role="dialog" aria-labelledby="inviteUsersLabel"
         aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="inviteUsersLabel">Invite users to fill out information</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <p>You can fill out the email fields below to invite users to fill out their own information,
                        you can fill as many or as little as you would like.</p>

                    <div class="form-group row" v-for="ticket in tickets">
                        <label :for="ticket.hash" class="col-md-4 col-form-label">Email for <small>#{{ ticket.hash }}</small></label>
                        <div class="col-sm-8">
                            <input type="email" class="form-control" :id="ticket.hash" placeholder="Email" v-model="form.emails[ticket.hash]">
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="message">Add a note to email:</label>
                        <textarea class="form-control" id="message" name="message" rows="3"></textarea>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-link" data-dismiss="modal">Close</button>
                    <button type="button" class="btn btn-primary">Send invitation email</button>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
    export default {
        props: ['tickets'],
        data() {
            return {
                form: new SparkForm({
                    emails: {},
                    message: '',
                }),
            }
        },
        mounted() {
            this.formFill();

            this.eventHub.$on('showInviteUsers', function () {
                $('#inviteUsers').modal('show');
            });
        },
        methods: {
            submit() {

            },
            formFill() {
                let self = this;
                _.forEach(this.tickets, function(ticket) {
                    self.$set(self.form.emails, ticket.hash, '')
                });
            }
        }
    }
</script>