<template>
    <div>
        <div class="md:w-1/2 mx-auto">
            <div class="p-6 bg-white rounded shadow">
                <h2 class="text-xl text-center mb-6">How would you like to support?</h2>

                <div class="flex border rounded">
                    <div class="flex-1 border-r p-4 text-lg hover:bg-gray-200 cursor-pointer hover:shadow-inner text-center"
                         :class="[form.type === 'sponsor'  ? 'bg-mint-300 hover:bg-mint-300 shadow-inner' : '']"
                         @click="selectType('sponsor')">Sponsorship
                    </div>
                    <div class="flex-1 border-r p-4 text-lg hover:bg-gray-200 cursor-pointer hover:shadow-inner text-center"
                         :class="[form.type === 'vendor'  ? 'bg-mint-300 hover:bg-mint-300 shadow-inner' : '']"
                         @click="selectType('vendor')">Vendor Table
                    </div>
                    <div class="flex-1 p-4 text-lg hover:bg-gray-200 cursor-pointer hover:shadow-inner text-center"
                         :class="[form.type === 'ad'  ? 'bg-mint-300 hover:bg-mint-300 shadow-inner' : '']"
                         @click="selectType('ad')">Advertisement
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
                                    class="card"
                                    :class="[activeSponsorship(sponsorship.id)  ? 'active' : '']"
                                    :contribution="sponsorship" v-on:select="selectSponsor($event)"></contribution>
                        </div>
                        <div class="w-1/3 px-4 mb-4" v-if="form.sponsorship">
                            <contribution class="card" v-on:select="form.sponsorship = ''; form.amount = 0">
                                <template v-slot:default>
                                    <i class="far fa-times-circle fa-10x block mx-auto text-gray-100 absolute z-0 top-0 right-0 left-0 bottom-0"></i>
                                    <h2 class="relative font-semibold text-gray-700 text-lg mb-2">Deselect Sponsorship</h2>
                                </template>

                                <template v-slot:button>
                                    Deselect
                                </template>
                            </contribution>
                        </div>
                    </div>

                    <div class="mb-8">
                        <h3 class="text-2xl mb-6">Add Vendor Table</h3>
                        <alert v-if="form.sponsorship !== '' && form.sponsorship.description.includes('Vendor')">
                            <p>No need to add a vendor table, one is already included in the sponsorship that was
                                chosen.</p>
                        </alert>

                        <div class="flex flex-wrap -mx-4">
                            <div v-for="vendor in vendors" :key="vendor.id" class="w-1/3 px-4 mb-4">
                                <contribution
                                        class="card"
                                        :disabled="sponsorshipIncludesVendor()"
                                        :class="{'active': activeVendor(vendor.id), 'hover:shadow hover:bg-gray-100': sponsorshipIncludesVendor() }"
                                        :contribution="vendor" v-on:select="form.vendor = $event"></contribution>
                            </div>
                            <div class="w-1/3 px-4 mb-4" v-if="form.vendor">
                                <contribution class="card" v-on:select="form.vendor = ''">
                                    <template v-slot:default>
                                        <i class="far fa-times-circle fa-10x block mx-auto text-gray-100 absolute z-0 top-0 right-0 left-0 bottom-0"></i>
                                        <h2 class="relative font-semibold text-gray-700 text-lg mb-2">Deselect vendor table</h2>
                                    </template>

                                    <template v-slot:button>
                                        Deselect
                                    </template>
                                </contribution>
                            </div>
                        </div>
                    </div>

                    <div>
                        <h3 class="text-2xl mb-6">Add Program Book Advertisement</h3>

                        <alert v-if="form.sponsorship !== '' && form.sponsorship.description.includes('ad')">
                            <p>No need to add an advertisement, one is already included in the sponsorship that was
                                chosen.</p>
                        </alert>

                        <div class="flex flex-wrap -mx-4">
                            <div v-for="ad in ads" :key="ad.id" class="w-1/3 px-4 mb-4">
                                <contribution
                                        class="card"
                                        :disabled="sponsorshipIncludesAd()"
                                        :class="{'active': activeAd(ad.id), 'hover:shadow hover:bg-gray-100': sponsorshipIncludesAd() }"
                                        :contribution="ad" v-on:select="form.ad = $event"></contribution>
                            </div>
                            <div class="w-1/3 px-4 mb-4" v-if="form.ad">
                                <contribution class="card" v-on:select="form.ad = ''">
                                    <template v-slot:default>
                                        <i class="far fa-times-circle fa-10x block mx-auto text-gray-100 absolute z-0 top-0 right-0 left-0 bottom-0"></i>
                                        <h2 class="relative font-semibold text-gray-700 text-lg mb-2">Deselect Program Book Advertisement</h2>
                                    </template>

                                    <template v-slot:button>
                                        Deselect
                                    </template>
                                </contribution>
                            </div>
                        </div>
                    </div>
                </div>

                <div v-if="form.type === 'vendor'" class="mb-8">
                    <div class="flex flex-wrap -mx-4">
                        <div v-for="vendor in vendors" :key="vendor.id" class="w-1/3 px-4 mb-4">
                            <contribution
                                    class="card"
                                    :class="[activeVendor(vendor.id)  ? 'active' : '']"
                                    :contribution="vendor" v-on:select="form.vendor = $event"></contribution>
                        </div>
                    </div>
                </div>

                <div v-if="form.type === 'ad'">
                    <div class="flex flex-wrap -mx-4">
                        <div v-for="ad in ads" :key="ad.id" class="w-1/3 px-4 mb-4">
                            <contribution
                                    class="card"
                                    :class="[activeAd(ad.id)  ? 'active' : '']"
                                    :contribution="ad" v-on:select="form.ad = $event"></contribution>
                        </div>
                    </div>
                </div>
            </div>
            <div class="w-1/3 px-4 relative">
                <div class="mt-10 bg-gray-100 rounded-lg overflow-hidden shadow transition p-4 sticky top-24">
                    <h3 class="text-xl text-gray-700 mb-6">Selected Contributions</h3>

                    <div v-if="form.sponsorship" class="bg-white mb-2 rounded shadow">
                        <div class=" p-4 flex items-center">
                            <label class="font-semibold text-gray-700 text-lg flex-grow block" for="sponsorship-amount">{{
                                form.sponsorship.title }}</label>
                            <div class="w-24 flex items-center">
                                <span class="text-2xl text-gray-700 font-normal">$</span>
                                <input id="sponsorship-amount"
                                       class="text-2xl text-right appearance-none bg-transparent border-none w-full text-gray-700 leading-tight focus:outline-none -mr-4"
                                       type="number" aria-label="Sponsorship Amount" :min="form.sponsorship.amount/100"
                                       step="50" v-model="form.amount">
                            </div>
                        </div>
                        <div class="bg-mint-200 px-4 py-2">
                            <p class="text-xs">The contribution amount can be increased by clicking on the amount and using the up arrow.</p>
                        </div>
                    </div>

                    <div v-if="form.vendor" class="bg-white mb-2 rounded shadow p-4 flex items-center">
                        <label class="font-semibold text-gray-700 text-lg flex-grow block">{{ form.vendor.title
                            }}</label>
                        <div class="w-24 flex items-center">
                            <span class="text-2xl text-gray-700 font-normal">$</span>
                            <p class="text-2xl text-right w-full text-gray-700 leading-tight">{{ form.vendor.amount/100 }}</p>
                        </div>
                    </div>

                    <div v-if="form.ad" class="bg-white rounded shadow p-4 flex items-center">
                        <label class="font-semibold text-gray-700 text-lg flex-grow block">{{ form.ad.title }}</label>
                        <div class="w-24 flex items-center">
                            <span class="text-2xl text-gray-700 font-normal">$</span>
                            <p class="text-2xl text-right w-full text-gray-700 leading-tight">{{ form.ad.amount/100 }}</p>
                        </div>
                    </div>

                    <div class="flex items-center px-4 mt-4">
                        <label class="font-semibold text-gray-700 flex-grow block"
                               for="sponsorship-amount">Total</label>
                        <div class="w-24 flex items-center">
                            <span class="text-2xl text-gray-700 font-normal">$</span>
                            <p class="text-2xl text-right font-semibold w-full text-gray-700 leading-tight">{{ total }}</p>
                        </div>
                    </div>

                    <contribution-checkout class="mt-8" :disable="total === 0" :event="event"></contribution-checkout>
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
                    amount: '',
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
                this.form.amount = sponsor.amount / 100;
                this.form.sponsorship = sponsor;

                if (this.form.sponsorship.description.includes('Vendor') && this.form.vendor) {
                    this.form.vendor = '';
                }
            },
            selectType(type) {
                this.form.type = type;
                this.form.ad = '';
                this.form.amount = '';
                this.form.sponsorship = '';
                this.form.vendor = '';
            },
            sponsorshipIncludesVendor() {
                return this.form.sponsorship !== '' && this.form.sponsorship.description.includes('Vendor');
            },
            sponsorshipIncludesAd() {
                return this.form.sponsorship !== '' && this.form.sponsorship.description.includes('ad');
            }
        },
        computed: {
            ads() {
                let ads = _.filter(this.event.contributions, function (c) {
                    return c.type === 'ad';
                });
                return _.orderBy(ads, ['amount'], ['desc']);
            },
            amount() {
                return this.form.amount;
            },
            sponsorships() {
                let sponsorships = _.filter(this.event.contributions, function (c) {
                    return c.type === 'sponsor';
                });
                return _.orderBy(sponsorships, ['amount'], ['desc']);
            },
            total() {
                let amount = this.form.amount * 100;
                amount += this.form.vendor.amount || 0;
                amount += this.form.ad.amount || 0;

                return amount / 100;
            },
            vendors() {
                let vendors = _.filter(this.event.contributions, function (c) {
                    return c.type === 'vendor';
                });
                return _.orderBy(vendors, ['amount'], ['desc']);
            }
        },
        watch: {
            amount() {
                if(this.form.amount < this.form.sponsorship.amount/100) {
                    this.form.amount = this.form.sponsorship.amount/100;
                }
            }
        }
    }

</script>