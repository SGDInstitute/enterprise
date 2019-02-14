<template>
    <div class="flex -mx-4 h-full">
        <div class="w-1/3 px-4">
            <check-in></check-in>
        </div>
        <div class="w-1/3 px-4">
            <register></register>
        </div>
        <div class="w-1/3 px-4">
            <lookup></lookup>
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
