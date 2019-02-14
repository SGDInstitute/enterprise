<template>
    <div class="shadow-sm bg-white p-8 h-full flex flex-col justify-between">
        <div>
            <p class="text-lg inline-block bg-transparent hover:bg-blue text-blue-dark font-semibold py-2 px-4 border-2 border-blue rounded">Check-in</p>
        </div>

        <div>
            <h1 class="text-5xl font-normal mb-8 text-blue-darker">Already Registered</h1>

            <p class="text-xl leading-normal text-grey-darkest">Select this option if you've already registered or have been registered for this event. You can check-in yourself or a group.</p>
        </div>

        <div class="flex -mx-4">
            <router-link to="/check-in" class="no-underline text-center flex-1 mx-4 rounded bg-blue px-4 py-6 text-white font-semibold hover:bg-blue-dark">Scan Code or Type Confirmation Number</router-link>
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
