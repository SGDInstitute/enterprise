<template>
    <div class="md:flex -mx-4 h-full">
        <div class="w-full mb-4 md:mb-0 md:w-1/2 px-4">
            <check-in></check-in>
        </div>
        <div class="w-full md:w-1/2 px-4">
            <register></register>
        </div>
    </div>
</template>

<script>
    import CheckIn from './Home/Checkin'
    import Lookup from './Home/Lookup'
    import Register from './Home/Register'

    export default {
        name: 'home',
        components: {CheckIn, Lookup, Register}
    }
</script>
