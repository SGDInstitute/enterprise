export default (initialAddress) => ({
    options: [],
    address: initialAddress || [],
    chosen: false,
    open: false,

    init() {
        this.$watch('address.line1', () => {
            if (this.address.line1 != '') {
                fetch(
                    'https://api.mapbox.com/geocoding/v5/mapbox.places/' +
                        this.address.line1 +
                        '.json?country=us&limit=5&types=address,place&language=en-US&access_token=pk.eyJ1IjoiaW5zdGl0dXRldGVjaGVuYnkiLCJhIjoiY2t6OG5jdzhlMWxxaDJ1bnh5M2pmZ2Z0bCJ9.awJTo5ilQeFadjZPzWwA4g',
                )
                    .then((response) => response.json())
                    .then((response) => (this.options = response.features));

                if (!this.chosen) {
                    this.open = true;
                }
            }
        });
    },

    choose(option) {
        let parts = option.place_name.split(', ');

        this.address = {
            line1: parts[0],
            city: parts[1],
            state: parts[2].split(' ')[0],
            zip: parts[2].split(' ')[1],
            country: parts[3],
        };

        this.chosen = true;
        this.open = false;
    },

    clearAddress() {
        this.address = {
            line1: '',
            city: '',
            state: '',
            zip: '',
            country: '',
        };

        this.chosen = false;
        this.open = false;
        this.options = [];
    },
});
