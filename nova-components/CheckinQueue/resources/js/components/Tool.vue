<template>
    <div>
        <heading class="mb-6">Checkin Queue</heading>

        <card class="bg-10 p-4" style="min-height: 300px">
            <div class="mb-4 flex justify-between">
                <button class="btn btn-default btn-primary">Select 10</button>
                <div>
                    <a :href="'/print/' + selected" target="_blank" class="btn btn-default btn-primary">Print
                        Selected</a>
                    <button @click.prevent="complete(selected)" class="btn btn-default btn-secondary bg-40 hover:bg-50">Complete Selected</button>
                </div>
            </div>
            <table class="table w-full">
                <thead>
                <tr>
                    <th></th>
                    <th>Batch</th>
                    <th>Name</th>
                    <th>Pronouns</th>
                    <th>College</th>
                    <th>Tshirt</th>
                    <th>Early</th>
                    <th></th>
                </tr>
                </thead>
                <tbody>
                <tr v-if="tickets.length === 0">
                    <td colspan="8">No tickets in queue</td>
                </tr>
                <tr v-else v-for="ticket in tickets" :key="ticket.id" @click="toggleTicket(ticket.id)">
                    <td><input type="checkbox" class="checkbox" v-model="picked" :value="ticket.id"></td>
                    <td>{{ ticket.batch }}</td>
                    <td>{{ ticket.name }}</td>
                    <td>{{ ticket.pronouns || 'n/a' }}</td>
                    <td>{{ ticket.college || 'n/a' }}</td>
                    <td>{{ ticket.tshirt || 'n/a' }}</td>
                    <td>{{ isEarly(ticket.order_created) }}</td>
                    <td class="text-right">
                        <a :href="'/print/' + ticket.id" target="_blank" class="btn btn-default btn-primary">Print</a>
                        <button @click.prevent="complete(ticket.id)" class="btn btn-default btn-secondary btn-secondary bg-40 hover:bg-50">Completed</button>
                    </td>
                </tr>
                </tbody>
            </table>
        </card>
    </div>
</template>

<script>
    import moment from 'moment';

    export default {
        data() {
            return {
                tickets: [],
                picked: [],
            }
        },
        mounted() {
            this.fetchQueue();
        },
        methods: {
            fetchQueue() {
                axios.get('/api/queue')
                    .then(response => {
                        this.tickets = response.data;
                    });
            },
            toggleTicket(id) {
                if (_.includes(this.picked, id)) {
                    this.picked.splice(_.indexOf(this.picked, id), 1);
                } else {
                    this.picked.push(id);
                }
            },
            isEarly(date) {
                return moment(date).isBefore('2019-02-02') ? 'Yes' : 'No';
            },
            complete(ids) {
                axios.patch('/api/queue/' + ids + '/complete')
                    .then(response => {
                        this.tickets = response.data;
                    });
            },
            selectTen() {

            }
        },
        computed: {
            selected() {
                return this.picked.join(',');
            }
        }
    }
</script>
