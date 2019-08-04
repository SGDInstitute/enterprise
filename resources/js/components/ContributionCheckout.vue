<template>
    <div>
        <button @click.prevent="checkout" :disabled="disable || processing" class="btn btn-mint btn-block">
            Contribute
        </button>

        <portal to="modals" v-if="show">
            <modal :show="show">
                <div slot="header" class="p-6 bg-black flex justify-between shadow">
                    <h1 class="text-xl text-white">Contribute to {{ event.title }}</h1>
                    <button @click="cancel" class="text-white bg-grey rounded-full p-1 h-6 w-6 hover:bg-grey-dark"><i
                            class="fal fa-times"></i></button>
                </div>
                <div slot="body" class="p-6">
                    <p class="mb-4">Choose method of payment</p>

                </div>
                <div slot="footer" class="bg-grey-darkest p-6 flex justify-between items-center">
                    <button @click="cancel" class="text-grey-light py-2 px-4 border border-black bg-grey-darker">
                        Cancel
                    </button>
                </div>
            </modal>
        </portal>
    </div>
</template>

<script>
    export default {
        props: ['disable', 'event', 'contributions'],
        data() {
            return {
                show: false,
                processing: false,
            }
        },
        methods: {
            cancel() {
                this.show = false;
                this.processing = false;
            },
            checkout() {
                this.show = true;
            },
        }
    }
</script>
