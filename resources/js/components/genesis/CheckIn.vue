<template>
    <div class="flex -mx-4 h-full">
        <router-link to="/" class="absolute pin-t p-2 text-grey-darker no-underline hover:text-grey-darkest">< Back</router-link>
        <div class="shadow-sm bg-white p-8 h-full mx-auto">
            <h1 class="text-3xl font-normal mb-8 text-blue-darker">Scan Your Ticket</h1>

            <video id="preview" class="w-64 border border-grey mx-auto mb-4 bg-grey-lighter block mx-auto"></video>
            <div class="text-center mb-16">
                <button @click="start" class="rounded bg-blue px-4 py-3 text-white font-semibold hover:bg-blue-dark">Start Scan</button>
                <button @click="stop" class="rounded bg-grey-light px-4 py-3 text-grey-darkest font-semibold hover:bg-grey">Stop</button>
            </div>

            <h2 class="text-2xl font-normal mb-8 text-blue-darker">Or Type Your Confirmation Number</h2>
            <div class="flex flex-wrap items-stretch w-full mb-4 relative">
                <input type="text" class="flex-shrink flex-grow flex-auto leading-normal w-px flex-1 border h-10 border-grey-light rounded rounded-r-none px-3 relative" v-model="number">
                <div class="flex -mr-px">
                    <router-link :to="'/orders/' + number" class="rounded rounded-l-none no-underline bg-blue px-4 flex items-center h-10 text-white font-semibold hover:bg-blue-dark">Continue</router-link>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
    const Instascan = require('instascan');

    export default {
        name: 'scan',
        data() {
            return {
                number: '',
                error: '',
                scanner: {},
            }
        },
        methods: {
            start() {
                this.scanner = new Instascan.Scanner({ video: document.getElementById('preview') });

                let self = this;
                this.scanner.addListener('scan', function (content) {
                    self.number = content;
                });
                Instascan.Camera.getCameras().then(function (cameras) {
                    if (cameras.length > 0) {
                        self.scanner.start(cameras[0]);
                    } else {
                        self.error = 'No cameras found.';
                    }
                }).catch(function (e) {
                    self.error = e;
                });
            },
            stop() {
                this.scanner.stop();
            }
        }
    }
</script>
