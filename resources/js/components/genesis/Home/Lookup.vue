<template>
    <div class="shadow-sm bg-white p-8 h-full flex flex-col justify-between">
        <div>
            <p class="text-lg inline-block bg-transparent hover:bg-purple text-purple-dark font-semibold py-2 px-4 border-2 border-purple rounded">Check-in</p>
        </div>

        <div>
            <h1 class="text-5xl font-normal mb-8 text-purple-darker">Look Up Your Ticket</h1>

            <p class="text-xl leading-normal text-grey-darkest">Select this option if you're not sure if you've registered, do not know your confirmation number, or did not receive a ticket email.</p>
        </div>

        <div class="flex -mx-4">
            <router-link to="/lookup" class="no-underline text-center flex-1 mx-4 rounded bg-purple px-4 py-6 text-white font-semibold hover:bg-purple-dark">Lookup Ticket</router-link>
        </div>
    </div>
</template>

<script>
    export default {
        name: 'checkin',
        data() {
            return {
                text: ''
            }
        },
    }
</script>
