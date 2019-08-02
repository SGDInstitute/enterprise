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

        <div class="flex -mx-4 mt-8" v-if="form.type !== ''">
            <div class="w-2/3 px-4">
                <div v-if="form.type === 'sponsor'" class="mb-8">
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

                <div v-if="form.type === 'vendor'" class="mb-8">
                    <div class="flex flex-wrap -mx-4">
                        <div v-for="vendor in vendors" :key="vendor.id" class="w-1/3 px-4 mb-4">
                            <contribution
                                    class="bg-gray-100 hover:bg-white rounded-lg overflow-hidden shadow hover:shadow-lg transition h-full border-2 border-transparent"
                                    :class="[activeVendor(vendor.id)  ? 'bg-mint-300 hover:bg-mint-300 border-2 border-mint-400' : '']"
                                    :contribution="vendor" v-on:select="form.vendor = $event"></contribution>
                        </div>
                    </div>
                </div>

                <div v-if="form.type === 'ad'">
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
            <div class="w-1/3 px-4 relative">
                <div class="mt-10 bg-gray-100 rounded-lg overflow-hidden shadow transition p-4 sticky top-20">
                    <h3 class="text-xl text-gray-700 mb-6">Selected Contributions</h3>

                    <div v-if="form.sponsorship" class="bg-white mb-2 rounded shadow p-4 flex items-center">
                        <label class="font-semibold text-gray-700 text-lg flex-grow block" for="sponsorship-amount">{{ form.sponsorship.title }}</label>
                        <input type="number" class="w-24 form-control" name="amount" id="sponsorship-amount" :min="form.sponsorship.amount/100" v-model="form.amount">
                    </div>

                    <div v-if="form.vendor" class="bg-white mb-2 rounded shadow p-4 flex items-center">
                        <label class="font-semibold text-gray-700 text-lg flex-grow block">{{ form.vendor.title }}</label>
                        <p class="w-24 pl-2 font-semibold text-mint-800 tracking-wide text-2xl flex items-center"><span class="text-2xl text-gray-700 font-normal">$</span>{{ form.vendor.amount/100 }}</p>
                    </div>

                    <div v-if="form.ad" class="bg-white rounded shadow p-4 flex items-center">
                        <label class="font-semibold text-gray-700 text-lg flex-grow block">{{ form.ad.title }}</label>
                        <p class="w-24 pl-2 font-semibold text-mint-800 tracking-wide text-2xl flex items-center"><span class="text-2xl text-gray-700 font-normal">$</span>{{ form.ad.amount/100 }}</p>
                    </div>

                    <div class="flex items-center px-4 mt-4">
                        <label class="font-semibold text-gray-700 flex-grow block" for="sponsorship-amount">Total</label>
                        <p class="w-24 pl-2 font-semibold text-mint-800 tracking-wide text-2xl flex items-center"><span class="text-2xl text-gray-700 font-normal">$</span>{{ total }}</p>
                    </div>
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
                this.form.amount = sponsor.amount/100;
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
            total() {
                let amount = this.form.sponsorship.amount || 0;
                amount += this.form.vendor.amount || 0;
                amount += this.form.ad.amount || 0;

                return amount/100;
            },
            vendors() {
                return _.filter(this.event.contributions, function (c) {
                    return c.type === 'vendor';
                });
            }
        }
    }

</script>