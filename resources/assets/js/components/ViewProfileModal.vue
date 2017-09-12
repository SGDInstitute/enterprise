<template>
    <div class="modal fade" id="viewProfileModal" tabindex="-1" role="dialog">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">View Ticket Details</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span
                            aria-hidden="true">&times;</span></button>
                </div>
                <div class="modal-body">
                    <dl class="row">
                        <dt class="col-sm-4">Ticket #</dt>
                        <dd class="col-sm-8">{{ ticket }}</dd>
                        <dt class="col-sm-4">Name</dt>
                        <dd class="col-sm-8">{{ user.name }}</dd>
                        <dt class="col-sm-4">Email</dt>
                        <dd class="col-sm-8">{{ user.email }}</dd>
                        <dt class="col-sm-4">Pronouns</dt>
                        <dd class="col-sm-8">{{ user.profile.pronouns }}</dd>
                        <dt class="col-sm-4">Sexuality</dt>
                        <dd class="col-sm-8">{{ user.profile.sexuality }}</dd>
                        <dt class="col-sm-4">Gender</dt>
                        <dd class="col-sm-8">{{ user.profile.gender }}</dd>
                        <dt class="col-sm-4">Race</dt>
                        <dd class="col-sm-8">{{ user.profile.race }}</dd>
                        <dt class="col-sm-4">College</dt>
                        <dd class="col-sm-8">{{ user.profile.college }}</dd>
                        <dt class="col-sm-4">T-shirt</dt>
                        <dd class="col-sm-8">{{ user.profile.tshirt }}</dd>
                        <dt class="col-sm-4">Accommodation</dt>
                        <dd class="col-sm-8">{{ user.profile.accommodation }}</dd>
                    </dl>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-link" data-dismiss="modal">Close</button>
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
                ticket: '',
                user: { profile: {} },
            }
        },
        created() {
            let self = this;
            this.eventHub.$on('showViewProfileModal', function (ticket) {
                self.ticket = ticket;
                $('#viewProfileModal').modal('show');

                self.loadUserFromTicket(ticket);
            });
        },
        methods: {
            loadUserFromTicket(ticket) {
                this.user = _.find(this.tickets, function(t) {
                    return t.hash === ticket;
                }).user;
            }
        }
    }
</script>