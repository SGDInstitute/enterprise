<template>
    <div class="mb-8">
        <div class="md:w-2/3  lg:w-1/2 md:mx-auto mx-4">
            <div class="p-6 bg-white rounded shadow">
                <h2 class="text-xl text-center mb-6">How would you like to support?</h2>

                <div class="md:flex border rounded">
                    <div class="md:flex-1 md:border-r border-b md:border-b-0 p-4 text-lg hover:bg-gray-200 cursor-pointer hover:shadow-inner text-center flex items-center justify-center"
                         :class="[form.type === 'sponsor'  ? 'bg-mint-300 hover:bg-mint-300 shadow-inner' : '']"
                         @click="selectType('sponsor')">Sponsorship
                    </div>
                    <div class="md:flex-1 md:border-r border-b md:border-b-0 p-4 text-lg hover:bg-gray-200 cursor-pointer hover:shadow-inner text-center flex items-center justify-center"
                         :class="[form.type === 'vendor'  ? 'bg-mint-300 hover:bg-mint-300 shadow-inner' : '']"
                         @click="selectType('vendor')">Vendor Table
                    </div>
                    <div class="md:flex-1 p-4 text-lg hover:bg-gray-200 cursor-pointer hover:shadow-inner text-center flex items-center justify-center"
                         :class="[form.type === 'ad'  ? 'bg-mint-300 hover:bg-mint-300 shadow-inner' : '']"
                         @click="selectType('ad')">Advertisement
                    </div>
                </div>
            </div>
        </div>

        <div class="md:flex md:-mx-4 mt-8 mx-4 md:mx-0" v-if="form.type !== ''">
            <div class="md:w-2/3 px-4">
                <div v-if="form.type === 'sponsor'" class="mb-8">
                    <h3 class="text-2xl mb-6">Choose sponsorship Level</h3>
                    <div class="md:flex md:flex-wrap -mx-4 mb-8">
                        <div v-for="sponsorship in sponsorships" :key="sponsorship.id" class="md:w-1/2 xl:w-1/3 px-4 mb-4">
                            <contribution
                                    class="card"
                                    :class="[activeSponsorship(sponsorship.id)  ? 'active' : '']"
                                    :contribution="sponsorship" v-on:select="selectSponsor($event)"></contribution>
                        </div>
                        <div class="md:w-1/2 xl:w-1/3 px-4 mb-4" v-if="form.sponsorship">
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
                        <alert v-if="sponsorshipIncludesVendor">
                            <p>No need to add a vendor table, one is already included in the sponsorship that was
                                chosen.</p>
                        </alert>

                        <div class="md:flex flex-wrap -mx-4">
                            <div v-for="vendor in vendors" :key="vendor.id" class="md:w-1/2 xl:w-1/3 px-4 mb-4">
                                <contribution
                                        class="card"
                                        :class="{'active': activeVendor(vendor.id), 'hover:shadow hover:bg-gray-100': sponsorshipIncludesVendor }"
                                        :contribution="vendor" v-on:select="selectVendor($event)"></contribution>
                            </div>
                            <div class="md:w-1/2 xl:w-1/3 px-4 mb-4" v-if="form.vendor">
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

                        <alert v-if="sponsorshipIncludesAd">
                            <p>No need to add an advertisement, a {{ sponsorshipAdSize }} is already included in the sponsorship that was
                                chosen.</p>
                        </alert>

                        <div class="md:flex flex-wrap -mx-4">
                            <div v-for="ad in ads" :key="ad.id" class="md:w-1/2 xl:w-1/3 px-4 mb-4">
                                <contribution
                                        class="card"
                                        :class="{'active': activeAd(ad.id), 'hover:shadow hover:bg-gray-100': sponsorshipIncludesAd }"
                                        :contribution="ad" v-on:select="addAd($event)"></contribution>
                            </div>
                            <div class="md:w-1/2 xl:w-1/3 px-4 mb-4" v-if="form.ad">
                                <contribution class="card" v-on:select="form.ads = []">
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
                    <div class="md:flex flex-wrap -mx-4">
                        <div v-for="vendor in vendors" :key="vendor.id" class="md:w-1/2 xl:w-1/3 px-4 mb-4">
                            <contribution
                                    class="card"
                                    :class="{'active': activeVendor(vendor.id), 'hover:shadow hover:bg-gray-100': sponsorshipIncludesVendor }"
                                    :contribution="vendor" v-on:select="selectVendor($event)"></contribution>
                        </div>
                        <div class="md:w-1/2 xl:w-1/3 px-4 mb-4" v-if="form.vendor">
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

                <div v-if="form.type === 'ad'">
                    <div class="md:flex flex-wrap -mx-4">
                        <div v-for="ad in ads" :key="ad.id" class="md:w-1/2 xl:w-1/3 px-4 mb-4">
                            <contribution
                                    class="card"
                                    :class="{'active': activeAd(ad.id), 'hover:shadow hover:bg-gray-100': sponsorshipIncludesAd }"
                                    :contribution="ad" v-on:select="form.ad = $event"></contribution>
                        </div>
                        <div class="md:w-1/2 xl:w-1/3 px-4 mb-4" v-if="form.ad">
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
            <div class="md:w-1/3 px-4 relative">
                <div class="mt-10 bg-gray-100 rounded-lg overflow-hidden shadow transition p-4 sticky top-24">
                    <h3 class="text-xl text-gray-700 mb-6">Selected Contributions</h3>

                    <div v-if="form.sponsorship" class="bg-white mb-2 rounded shadow">
                        <div class="p-4 flex items-center">
                            <label class="font-semibold text-gray-700 text-lg flex-grow block" for="sponsorship-amount">
                                {{ form.sponsorship.title }}
                            </label>
                            <div class="w-32 flex items-center">
                                <span class="text-2xl text-gray-700 font-normal">$</span>
                                <input id="sponsorship-amount"
                                       class="ml-1 form-control text-2xl pr-0"
                                       type="number" aria-label="Sponsorship Amount" :min="form.sponsorship.amount/100"
                                       step="50" v-model="form.amount">
                            </div>
                        </div>
                        <div class="bg-mint-200 px-4 py-2">
                            <p class="text-xs">The contribution amount can be increased by clicking on the amount and using the up arrow or typing a new value.</p>
                        </div>
                    </div>

                    <div v-if="form.vendor" class="bg-white mb-2 rounded shadow">
                        <div class="p-4">
                            <label for="quantity" class="font-semibold mb-4 text-gray-700 text-lg flex-grow block">
                                {{ form.vendor.title }} Vendor Table
                            </label>
                            <div class="flex items-center justify-between">
                                <input type="number" id="quantity" class="w-24 form-control" v-model="form.vendor.quantity">
                                <div class="w-24 flex items-center">
                                    <span class="text-2xl text-gray-700 font-normal">$</span>
                                    <p class="text-2xl text-right w-full text-gray-700 leading-tight">{{ form.vendor.amount/100 }}</p>
                                </div>
                            </div>
                        </div>
                        <div class="bg-mint-200 px-4 py-2" v-if="sponsorshipIncludesVendor">
                            <p class="text-xs">One vendor table is already included in the sponsorship that was
                                chosen, so you will receive {{ parseInt(form.quantity) + 1}} tables.</p>
                        </div>
                    </div>

                    <div v-for="ad in form.ads" class="bg-white mb-2 rounded shadow">
                        <div class="p-4">
                            <label class="font-semibold mb-4 text-gray-700 text-lg flex-grow block">{{ ad.title }}</label>
                            <div class="flex items-center justify-between">
                                <input type="number" class="w-24 form-control" v-model="ad.quantity">
                                <div class="w-24 flex items-center">
                                    <span class="text-2xl text-gray-700 font-normal">$</span>
                                    <p class="text-2xl text-right w-full text-gray-700 leading-tight">{{ ad.amount/100 }}</p>
                                </div>
                            </div>
                        </div>
                        <div class="bg-mint-200 px-4 py-2" v-if="sponsorshipIncludesAd">
                            <p class="text-xs">One {{ sponsorshipAdSize }} is already included in the sponsorship that was
                                chosen, so you will receive {{ adQuantity + 1 }} ads.</p>
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

                    <contribution-checkout class="mt-8" :disable="total === 0" :event="event" :contributions="form" :total="total"></contribution-checkout>
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
                form: {
                    type: '',
                    ads: [],
                    amount: '',
                    sponsorship: '',
                    vendor: '',
                }
            }
        },
        methods: {
            activeAd(id) {
                return _.find(this.form.ads, { 'id': id }) !== undefined;
            },
            activeSponsorship(id) {
                return this.form.sponsorship && this.form.sponsorship.id === id;
            },
            activeVendor(id) {
                return this.form.vendor && this.form.vendor.id === id;
            },
            addAd(ad) {
                ad.quantity = 1;
                this.form.ads.push(ad);
            },
            selectVendor(vendor) {
                vendor.quantity = 1;
                this.form.vendor = vendor;
            },
            selectSponsor(sponsor) {
                this.form.amount = sponsor.amount / 100;
                this.form.sponsorship = sponsor;
            },
            selectType(type) {
                this.form.type = type;
                this.form.ad = '';
                this.form.amount = '';
                this.form.sponsorship = '';
                this.form.vendor = '';
            }
        },
        computed: {
            adQuantity() {
                return _.sumBy(this.form.ads, function(ad) { return parseInt(ad.quantity); });
            },
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
            sponsorshipAdSize() {
                if(this.sponsorshipIncludesAd) {
                    let search = 'page ad';
                    let index = this.form.sponsorship.description.indexOf(search);
                    return this.form.sponsorship.description.substr(index-2, search.length+2);
                }
                return '';
            },
            sponsorshipIncludesVendor() {
                return this.form.sponsorship !== '' && this.form.sponsorship.description.includes('Vendor');
            },
            sponsorshipIncludesAd() {
                return this.form.sponsorship !== '' && this.form.sponsorship.description.includes('ad');
            },
            total() {
                let amount = this.form.amount * 100;
                amount += this.form.vendor.amount * this.form.vendor.quantity || 0;
                amount += _.sumBy(this.form.ads, function(ad) { return ad.amount * ad.quantity; });
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