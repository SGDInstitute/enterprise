<template>
  <div class="mb-16">
    <div class="md:w-2/3 lg:w-1/2 md:mx-auto mx-4">
      <div class="p-6 bg-white rounded shadow">
        <h2 class="text-xl text-center mb-6">How would you like to support?</h2>

        <div class="md:flex border rounded">
          <div
            class="md:flex-1 md:border-r border-b md:border-b-0 p-4 text-lg hover:bg-gray-200 cursor-pointer hover:shadow-inner text-center flex items-center justify-center"
            :class="[form.type === 'sponsor'  ? 'bg-mint-300 hover:bg-mint-300 shadow-inner' : '']"
            @click="selectType('sponsor')"
          >Sponsorship</div>
          <div
            class="md:flex-1 md:border-r border-b md:border-b-0 p-4 text-lg hover:bg-gray-200 cursor-pointer hover:shadow-inner text-center flex items-center justify-center"
            :class="[form.type === 'vendor'  ? 'bg-mint-300 hover:bg-mint-300 shadow-inner' : '']"
            @click="selectType('vendor')"
          >Vendor Table</div>
          <div
            class="md:flex-1 p-4 text-lg hover:bg-gray-200 cursor-pointer hover:shadow-inner text-center flex items-center justify-center"
            :class="[form.type === 'ad'  ? 'bg-mint-300 hover:bg-mint-300 shadow-inner' : '']"
            @click="selectType('ad')"
          >Advertisement</div>
        </div>
      </div>
    </div>

    <div class="md:flex md:-mx-4 mt-8 mx-4 md:mx-0" v-if="form.type !== ''">
      <div class="md:w-2/3 px-4">
        <div v-if="form.type === 'sponsor'" class="mb-8">
          <h3 class="text-2xl mb-6">Choose sponsorship Level</h3>
          <div class="md:flex md:flex-wrap -mx-4 mb-8">
            <div
              v-for="sponsorship in sponsorships"
              :key="sponsorship.id"
              class="md:w-1/2 xl:w-1/3 px-4 mb-4"
            >
              <contribution
                class="card"
                :class="[activeSponsorship(sponsorship.id)  ? 'active' : '']"
                :contribution="sponsorship"
                v-on:select="selectSponsor($event)"
              ></contribution>
            </div>
            <div class="md:w-1/2 xl:w-1/3 px-4 mb-4" v-if="form.sponsorship">
              <contribution class="card" v-on:select="form.sponsorship = ''; form.amount = 0">
                <template v-slot:default>
                  <i
                    class="far fa-times-circle fa-10x block mx-auto text-gray-100 absolute z-0 top-0 right-0 left-0 bottom-0"
                  ></i>
                  <h2 class="relative font-semibold text-gray-700 text-lg mb-2">Deselect Sponsorship</h2>
                </template>

                <template v-slot:button>Deselect</template>
              </contribution>
            </div>
          </div>

          <div class="mb-8">
            <h3 class="text-2xl mb-6">Add Vendor Table</h3>
            <alert v-if="sponsorshipIncludesVendor">
              <p>
                One vendor table is already included in the sponsorship that was
                chosen, but feel free to purchase additional tables below.
              </p>
            </alert>

            <div class="md:flex flex-wrap -mx-4">
              <div v-for="vendor in vendors" :key="vendor.id" class="md:w-1/2 xl:w-1/3 px-4 mb-4">
                <contribution
                  class="card"
                  :class="{'active': activeVendor(vendor.id), 'hover:shadow hover:bg-gray-100': sponsorshipIncludesVendor }"
                  :contribution="vendor"
                  v-on:select="selectVendor($event)"
                ></contribution>
              </div>
              <div class="md:w-1/2 xl:w-1/3 px-4 mb-4" v-if="form.vendor">
                <contribution class="card" v-on:select="form.vendor = ''">
                  <template v-slot:default>
                    <i
                      class="far fa-times-circle fa-10x block mx-auto text-gray-100 absolute z-0 top-0 right-0 left-0 bottom-0"
                    ></i>
                    <h2
                      class="relative font-semibold text-gray-700 text-lg mb-2"
                    >Deselect vendor table</h2>
                  </template>

                  <template v-slot:button>Deselect</template>
                </contribution>
              </div>
            </div>
          </div>

          <div>
            <h3 class="text-2xl mb-6">Add Program Book Advertisement</h3>

            <alert v-if="sponsorshipIncludesAd">
              <p>
                A {{ sponsorshipAdSize }} is already included in the sponsorship that was
                chosen, but feel free to purchase an additional ad or upgrade the size below.
              </p>
            </alert>

            <div v-if="adUpgrades" class="mb-4">
              <h4 class="text-lg mb-4">Upgrade {{ sponsorshipAdSize }}</h4>
              <div class="md:flex flex-wrap -mx-4">
                <div
                  v-for="adUpgrade in adUpgrades"
                  :key="'U' + adUpgrade.id"
                  class="md:w-1/2 xl:w-1/3 px-4 mb-4"
                >
                  <contribution
                    class="card"
                    :class="{'active': activeAdUpgrade(adUpgrade.id), 'hover:shadow hover:bg-gray-100': sponsorshipIncludesAd }"
                    :contribution="adUpgrade"
                    v-on:select="addAdUpgrade($event)"
                  ></contribution>
                </div>
                <div class="md:w-1/2 xl:w-1/3 px-4 mb-4" v-if="form.adUpgrade">
                  <contribution class="card" v-on:select="form.adUpgrade = ''">
                    <template v-slot:default>
                      <i
                        class="far fa-times-circle fa-10x block mx-auto text-gray-100 absolute z-0 top-0 right-0 left-0 bottom-0"
                      ></i>
                      <h2
                        class="relative font-semibold text-gray-700 text-lg mb-2"
                      >Deselect Program Book Ad Upgrade</h2>
                    </template>

                    <template v-slot:button>Deselect</template>
                  </contribution>
                </div>
              </div>
            </div>

            <div class="md:flex flex-wrap -mx-4">
              <div v-for="ad in ads" :key="ad.id" class="md:w-1/2 xl:w-1/3 px-4 mb-4">
                <contribution
                  class="card"
                  :class="{'active': activeAd(ad.id), 'hover:shadow hover:bg-gray-100': sponsorshipIncludesAd }"
                  :contribution="ad"
                  v-on:select="addAd($event)"
                ></contribution>
              </div>
              <div class="md:w-1/2 xl:w-1/3 px-4 mb-4" v-if="form.ad">
                <contribution class="card" v-on:select="form.ads = []">
                  <template v-slot:default>
                    <i
                      class="far fa-times-circle fa-10x block mx-auto text-gray-100 absolute z-0 top-0 right-0 left-0 bottom-0"
                    ></i>
                    <h2
                      class="relative font-semibold text-gray-700 text-lg mb-2"
                    >Deselect Program Book Advertisement</h2>
                  </template>

                  <template v-slot:button>Deselect</template>
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
                :contribution="vendor"
                v-on:select="selectVendor($event)"
              ></contribution>
            </div>
            <div class="md:w-1/2 xl:w-1/3 px-4 mb-4" v-if="form.vendor">
              <contribution class="card" v-on:select="form.vendor = ''">
                <template v-slot:default>
                  <i
                    class="far fa-times-circle fa-10x block mx-auto text-gray-100 absolute z-0 top-0 right-0 left-0 bottom-0"
                  ></i>
                  <h2
                    class="relative font-semibold text-gray-700 text-lg mb-2"
                  >Deselect vendor table</h2>
                </template>

                <template v-slot:button>Deselect</template>
              </contribution>
            </div>
          </div>
        </div>

        <div v-if="form.type === 'ad'">
          <div class="md:flex flex-wrap -mx-4">
            <div v-for="ad in ads" :key="ad.id" class="md:w-1/2 xl:w-1/3 px-4 mb-4">
              <contribution
                class="card"
                :class="{'active': activeAd(ad.id)}"
                :contribution="ad"
                v-on:select="addAd($event)"
              ></contribution>
            </div>
            <div class="md:w-1/2 xl:w-1/3 px-4 mb-4" v-if="form.ads.length > 0">
              <contribution class="card" v-on:select="form.ads = []">
                <template v-slot:default>
                  <i
                    class="far fa-times-circle fa-10x block mx-auto text-gray-100 absolute z-0 top-0 right-0 left-0 bottom-0"
                  ></i>
                  <h2
                    class="relative font-semibold text-gray-700 text-lg mb-2"
                  >Deselect Program Book Advertisement</h2>
                </template>

                <template v-slot:button>Deselect</template>
              </contribution>
            </div>
          </div>
        </div>
      </div>
      <div class="md:w-1/3 px-4 relative">
        <div class="sticky top-24">
          <div class="mt-10 bg-gray-100 rounded-lg overflow-hidden shadow transition p-4">
            <h3 class="text-xl text-gray-700 mb-6">Selected Contributions</h3>

            <div v-if="form.sponsorship" class="bg-white mb-2 rounded shadow">
              <div class="p-4 flex items-center">
                <label
                  class="font-semibold text-gray-700 text-lg flex-grow block flex items-center"
                  for="sponsorship-amount"
                >
                  {{ form.sponsorship.title }}
                  <button
                    class="btn btn-link text-gray-400"
                    @click="form.sponsorship = ''"
                    title="Remove Sponsorship"
                  >
                    <i class="fa fa-trash text-sm"></i>
                  </button>
                </label>
                <div class="w-32 flex items-center">
                  <span class="text-2xl text-gray-700 font-normal">$</span>
                  <input
                    id="sponsorship-amount"
                    class="ml-1 form-control text-2xl pr-0"
                    :class="{'form-error': form.errors.hasOwnProperty('amount') }"
                    type="number"
                    aria-label="Sponsorship Amount"
                    :min="form.sponsorship.amount/100"
                    step="50"
                    v-model="form.amount"
                  />
                </div>
              </div>
              <div
                v-if="form.errors.hasOwnProperty('amount')"
                class="bg-red-200 text-red-900 px-4 py-2 text-xs"
              >{{ form.errors.amount }}</div>
              <div class="bg-mint-200 px-4 py-2">
                <p
                  class="text-xs"
                >The contribution amount can be increased by clicking on the amount and using the up arrow or typing a new value.</p>
              </div>
            </div>

            <div v-if="form.vendor" class="bg-white mb-2 rounded shadow">
              <div class="p-4">
                <label
                  for="quantity"
                  class="font-semibold mb-4 text-gray-700 text-lg flex-grow block"
                >
                  {{ form.vendor.title }} Vendor Table
                  <button
                    class="btn btn-link text-gray-400"
                    @click="form.vendor = ''"
                    title="Remove Vendor"
                  >
                    <i class="fa fa-trash text-sm"></i>
                  </button>
                </label>
                <div class="flex items-center justify-between">
                  <input
                    type="number"
                    id="quantity"
                    class="w-24 form-control"
                    v-model="form.vendor.quantity"
                  />
                  <div class="w-24 flex items-center">
                    <span class="text-2xl text-gray-700 font-normal">$</span>
                    <p
                      class="text-2xl text-right w-full text-gray-700 leading-tight"
                    >{{ form.vendor.amount/100 }}</p>
                  </div>
                </div>
              </div>
              <div class="bg-mint-200 px-4 py-2" v-if="sponsorshipIncludesVendor">
                <p class="text-xs">
                  One vendor table is already included in the sponsorship that was
                  chosen, so you will receive {{ vendorQuantity }} tables.
                </p>
              </div>
            </div>

            <div v-if="form.adUpgrade" class="bg-white mb-2 rounded shadow">
              <div class="p-4">
                <label
                  for="quantity"
                  class="font-semibold mb-4 text-gray-700 text-lg flex-grow block"
                >
                  {{ form.adUpgrade.title }}
                  <button
                    class="btn btn-link text-gray-400"
                    @click="form.adUpgrade = ''"
                    title="Remove Ad Upgrade"
                  >
                    <i class="fa fa-trash text-sm"></i>
                  </button>
                </label>
                <div class="flex items-center justify-end">
                  <div class="w-24 flex items-center">
                    <span class="text-2xl text-gray-700 font-normal">$</span>
                    <p
                      class="text-2xl text-right w-full text-gray-700 leading-tight"
                    >{{ form.adUpgrade.amount/100 }}</p>
                  </div>
                </div>
              </div>
            </div>

            <div v-for="ad in form.ads" :key="ad.id" class="bg-white mb-2 rounded shadow">
              <div class="p-4">
                <label class="font-semibold mb-4 text-gray-700 text-lg flex-grow block">
                  {{ ad.title }}
                  <button
                    class="btn btn-link text-gray-400"
                    @click="removeAd(ad)"
                    title="Remove Ad"
                  >
                    <i class="fa fa-trash text-sm"></i>
                  </button>
                </label>
                <div class="flex items-center justify-between">
                  <input type="number" class="w-24 form-control" v-model="ad.quantity" />
                  <div class="w-24 flex items-center">
                    <span class="text-2xl text-gray-700 font-normal">$</span>
                    <p
                      class="text-2xl text-right w-full text-gray-700 leading-tight"
                    >{{ ad.amount/100 }}</p>
                  </div>
                </div>
              </div>
              <div class="bg-mint-200 px-4 py-2" v-if="sponsorshipIncludesAd">
                <p class="text-xs">
                  One {{ sponsorshipAdSize }} is already included in the sponsorship that was
                  chosen, so you will receive {{ adQuantity + 1 }} ads.
                </p>
              </div>
            </div>

            <div class="flex items-center px-4 mt-4">
              <label
                class="font-semibold text-gray-700 flex-grow block"
                for="sponsorship-amount"
              >Total</label>
              <div class="w-24 flex items-center">
                <span class="text-2xl text-gray-700 font-normal">$</span>
                <p
                  class="text-2xl text-right font-semibold w-full text-gray-700 leading-tight"
                >{{ total }}</p>
              </div>
            </div>

            <p
              v-if="isGuest"
              class="text-sm italic mt-8"
            >Please login or create an account before contributing.</p>

            <contribution-checkout
              class="mt-2"
              :disable="total === 0 || isGuest"
              :event="event"
              :contributions="form"
              :total="total"
            ></contribution-checkout>
          </div>

          <p
            class="text-sm mt-4 italic px-4 text-gray-600"
          >Disclaimer: Your contribution will be designated for {{ event.title }}. After all expenses for the event are paid, any excess revenues may be designated for other programs or the Institute’s general fund to continue the Institute’s efforts to connect, educate, and empower LGBTQ+ students in the Midwest.</p>
        </div>
      </div>
    </div>
  </div>
</template>

<script>
export default {
  props: ["event"],
  data() {
    return {
      form: {
        type: "",
        ads: [],
        adUpgrade: "",
        amount: "",
        sponsorship: "",
        vendor: "",
        errors: {}
      }
    };
  },
  methods: {
    activeAd(id) {
      return _.find(this.form.ads, { id: id }) !== undefined;
    },
    activeAdUpgrade(id) {
      return this.form.adUpgrade && this.form.adUpgrade.id === id;
    },
    activeSponsorship(id) {
      return this.form.sponsorship && this.form.sponsorship.id === id;
    },
    activeVendor(id) {
      return this.form.vendor && this.form.vendor.id === id;
    },
    addAd(ad) {
      let foundAd = _.find(this.form.ads, { id: ad.id });
      if (typeof foundAd === "undefined") {
        ad.quantity = 1;
        this.form.ads.push(ad);
      } else {
        foundAd.quantity += 1;
      }
    },
    addAdUpgrade(ad) {
      this.form.adUpgrade = ad;
    },
    removeAd(ad) {
      this.form.ads = _.reject(this.form.ads, function(a) {
        return a.id === ad.id;
      });
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
      this.form.ads = [];
      this.form.amount = "";
      this.form.sponsorship = "";
      this.form.vendor = "";
      this.form.adUpgrade = "";
    }
  },
  computed: {
    adQuantity() {
      return _.sumBy(this.form.ads, function(ad) {
        return parseInt(ad.quantity);
      });
    },
    ads() {
      let ads = _.filter(this.event.contributions, function(c) {
        return c.type === "ad";
      });
      return _.orderBy(ads, ["amount"], ["desc"]);
    },
    adUpgrades() {
      if (
        this.sponsorshipIncludesAd &&
        this.sponsorshipAdSize !== "Full page ad"
      ) {
        let ads = _.cloneDeep(this.ads);
        let includedAd = _.find(ads, {
          title: this.sponsorshipAdSize + " in program"
        });

        let moreExpensiveAds = _.filter(ads, function(ad) {
          return ad.amount > includedAd.amount;
        });

        return _.map(moreExpensiveAds, function(ad) {
          ad.title = "Upgrade to a " + ad.title;
          ad.amount = ad.amount - includedAd.amount;

          return ad;
        });
      }
    },
    amount() {
      return this.form.amount;
    },
    isGuest() {
      return window.SGDInstitute.user === null;
    },
    sponsorships() {
      let sponsorships = _.filter(this.event.contributions, function(c) {
        return c.type === "sponsor";
      });
      return _.orderBy(sponsorships, ["amount"], ["desc"]);
    },
    sponsorshipAdSize() {
      if (this.sponsorshipIncludesAd) {
        if (
          this.form.sponsorship.description.toLowerCase().indexOf("full") >= 0
        ) {
          return "Full page ad";
        }

        let search = "page ad";
        let index = this.form.sponsorship.description.indexOf(search);
        return this.form.sponsorship.description.substr(
          index - 2,
          search.length + 2
        );
      }
      return "";
    },
    sponsorshipIncludesVendor() {
      return (
        this.form.sponsorship !== "" &&
        this.form.sponsorship.description.includes("Vendor")
      );
    },
    sponsorshipIncludesAd() {
      return (
        this.form.sponsorship !== "" &&
        this.form.sponsorship.description.includes("ad")
      );
    },
    total() {
      let amount = this.form.amount * 100;
      amount += this.form.vendor.amount * this.form.vendor.quantity || 0;
      amount += this.form.adUpgrade.amount || 0;
      amount += _.sumBy(this.form.ads, function(ad) {
        return ad.amount * ad.quantity;
      });
      return amount / 100;
    },
    vendorQuantity() {
      return parseInt(this.form.vendor.quantity) + 1;
    },
    vendors() {
      let vendors = _.filter(this.event.contributions, function(c) {
        return c.type === "vendor";
      });
      return _.orderBy(vendors, ["amount"], ["desc"]);
    }
  },
  watch: {
    amount() {
      if (this.form.amount < this.form.sponsorship.amount / 100) {
        this.form.errors.amount =
          "The contribution amount for this sponsorship cannot be less than $" +
          this.form.sponsorship.amount / 100;
      } else if (this.form.amount === this.form.sponsorship.amount / 100) {
        delete this.form.errors["amount"];
      } else {
        let sponsorshipAmount = this.form.sponsorship.amount;
        let moreExpensiveSponsorships = _.filter(this.sponsorships, function(
          sponsorship
        ) {
          return sponsorship.amount > sponsorshipAmount;
        });

        if (moreExpensiveSponsorships.length > 0) {
          let oneTierUp = _.minBy(moreExpensiveSponsorships, "amount");

          if (this.form.amount >= oneTierUp.amount / 100) {
            this.form.errors.amount =
              "The contribution amount selected qualifies you for a higher sponsorship tier. Please selet " +
              oneTierUp.title +
              " instead.";
          } else {
            delete this.form.errors["amount"];
          }
        }
      }
    }
  }
};
</script>