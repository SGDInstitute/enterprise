<template>
    <div>
        <div class="md:w-1/2 mx-auto">
            <div class="p-6 bg-white rounded shadow">
                <h2 class="text-xl text-center mb-6">How would you like to support?</h2>

                <div class="flex border rounded">
                    <div class="flex-1 border-r p-4 text-lg hover:bg-gray-200 cursor-pointer hover:shadow-inner text-center"
                         :class="[form.type === 'sponsor'  ? 'bg-mint-300 hover:bg-mint-300 shadow-inner' : '']"
                         @click="form.type = 'sponsor'">Sponsorship
                    </div>
                    <div class="flex-1 border-r p-4 text-lg hover:bg-gray-200 cursor-pointer hover:shadow-inner text-center"
                         @click="form.type = 'vendor'">Vendor Table
                    </div>
                    <div class="flex-1 p-4 text-lg hover:bg-gray-200 cursor-pointer hover:shadow-inner text-center"
                         @click="form.type = 'ad'">Advertisement
                    </div>
                </div>
            </div>
        </div>

        <div v-if="form.type === 'sponsor'" class="container my-8">
            <h3 class="text-2xl mb-6">Choose sponsorship Level</h3>
            <div class="flex flex-wrap -mx-4 mb-8">
                <div v-for="sponsorship in sponsorships" :key="sponsorship.id" class="w-1/3 px-4 mb-4">
                    <contribution
                            class="bg-gray-100 hover:bg-white rounded-lg overflow-hidden shadow hover:shadow-lg transition h-full border-2 border-transparent"
                            :class="[activeSponsorship(sponsorship.id)  ? 'bg-mint-300 hover:bg-mint-300 border-2 border-mint-400' : '']"
                            :contribution="sponsorship" v-on:select="selectSponsor($event)"></contribution>
                </div>
            </div>

            <div class="mb-8">
                <h3 class="text-2xl mb-6">Add Vendor Table</h3>
                <div v-if="form.sponsorship !== '' && form.sponsorship.description.includes('Vendor')"
                     class="bg-mint-200 mb-4 border-t-4 border-mint-500 rounded overflow-hidden text-mint-900 px-4 py-3 shadow-md"
                     role="alert">
                    <div class="flex items-center">
                        <div class="py-1">
                            <svg class="fill-current h-6 w-6 text-mint-500 mr-4" xmlns="http://www.w3.org/2000/svg"
                                 viewBox="0 0 20 20">
                                <path d="M2.93 17.07A10 10 0 1 1 17.07 2.93 10 10 0 0 1 2.93 17.07zm12.73-1.41A8 8 0 1 0 4.34 4.34a8 8 0 0 0 11.32 11.32zM9 11V9h2v6H9v-4zm0-6h2v2H9V5z"/>
                            </svg>
                        </div>
                        <p>No need to add a vendor table, one is already included in the sponsorship that was
                            chosen.</p>
                    </div>
                </div>

                <div class="flex flex-wrap -mx-4">
                    <div v-for="vendor in vendors" :key="vendor.id" class="w-1/3 px-4 mb-4">
                        <contribution
                                class="bg-gray-100 hover:bg-white rounded-lg overflow-hidden shadow hover:shadow-lg transition h-full border-2 border-transparent"
                                :disabled="form.sponsorship !== '' && form.sponsorship.description.includes('Vendor')"
                                :class="[activeVendor(vendor.id)  ? 'bg-mint-300 hover:bg-mint-300 border-2 border-mint-400' : '']"
                                :contribution="vendor" v-on:select="form.vendor = $event"></contribution>
                    </div>
                </div>
            </div>

            <div>
                <h3 class="text-2xl mb-6">Add Program Book Advertisement</h3>

                <div class="flex flex-wrap -mx-4">
                    <div v-for="ad in ads" :key="ad.id" class="w-1/3 px-4 mb-4">
                        <contribution
                                class="bg-gray-100 hover:bg-white rounded-lg overflow-hidden shadow hover:shadow-lg transition h-full border-2 border-transparent"
                                :class="[activeAd(ad.id)  ? 'bg-mint-300 hover:bg-mint-300 border-2 border-mint-400' : '']"
                                :contribution="ad" v-on:select="form.ad = $event"></contribution>
                    </div>
                </div>
            </div>
        </div>

        <div v-if="form.type === 'vendor'" class="container mt-8">
            <div class="flex flex-wrap -mx-4">
                <div v-for="vendor in vendors" :key="vendor.id" class="w-1/3 px-4 mb-4">
                    <contribution
                            class="bg-gray-100 hover:bg-white rounded-lg overflow-hidden shadow hover:shadow-lg transition h-full border-2 border-transparent"
                            :class="[activeVendor(vendor.id)  ? 'bg-mint-300 hover:bg-mint-300 border-2 border-mint-400' : '']"
                            :contribution="vendor" v-on:select="form.vendor = $event"></contribution>
                </div>
            </div>
        </div>

        <div v-if="form.type === 'ad'" class="container mt-8">
            <div class="flex flex-wrap -mx-4">
                <div v-for="ad in ads" :key="ad.id" class="w-1/3 px-4 mb-4">
                    <contribution
                            class="bg-gray-100 hover:bg-white rounded-lg overflow-hidden shadow hover:shadow-lg transition h-full border-2 border-transparent"
                            :class="[activeAd(ad.id)  ? 'bg-mint-300 hover:bg-mint-300 border-2 border-mint-400' : '']"
                            :contribution="ad" v-on:select="form.ad = $event"></contribution>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
    export default {
        props: ['event'],
        data() {
            return {
                form: new SparkForm({
                    type: '',
                    ad: '',
                    sponsorship: '',
                    vendor: ''
                })
            }
        },
        methods: {
            activeAd(id) {
                return this.form.ad && this.form.ad.id === id;
            },
            activeSponsorship(id) {
                return this.form.sponsorship && this.form.sponsorship.id === id;
            },
            activeVendor(id) {
                return this.form.vendor && this.form.vendor.id === id;
            },
            selectSponsor(sponsor) {
                this.form.sponsorship = sponsor;

                if (this.form.sponsorship.description.includes('Vendor') && this.form.vendor) {
                    this.form.vendor = '';
                }
            }
        },
        computed: {
            ads() {
                return _.filter(this.event.contributions, function (c) {
                    return c.type === 'ad';
                });
            },
            sponsorships() {
                return _.filter(this.event.contributions, function (c) {
                    return c.type === 'sponsor';
                });
            },
            vendors() {
                return _.filter(this.event.contributions, function (c) {
                    return c.type === 'vendor';
                });
            }
        }
    }

</script>