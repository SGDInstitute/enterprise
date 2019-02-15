<template>
    <div class="shadow bg-white p-8 h-full flex flex-col justify-between">
        <div class="mb-4">
            <p class="text-lg inline-block bg-transparent hover:bg-green text-green-dark font-semibold py-2 px-4 border-2 border-green rounded">Register</p>
        </div>

        <div class="mb-4">
            <h1 class="text-5xl font-normal mb-8 text-green-darker">I Want To Register</h1>

            <p class="text-xl leading-normal text-grey-darkest">Select this option if you need to register and pay now. <br>You can pay with a credit card or a check.</p>
        </div>

        <div class="flex -mx-4">
            <a href="https://apps.sgdinstitute.org/events/mblgtacc-2019" target="_blank" class="flex-1 mx-4 rounded bg-green px-4 py-6 text-white font-semibold hover:bg-green-dark text-center no-underline">Register Now</a>
        </div>
    </div>
</template>

<script>
    export default {
        name: 'register',
        data() {
            return {
                text: ''
            }
        },
    }
</script>
